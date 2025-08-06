<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\User;
use App\Driver;
use App\Season;
use App\Series;
use App\Points;
use App\Circuit;

// ACC Result Parsing Controller Class
class AccController extends Controller
{
    private $output;
    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    // View to Upload Race Results
    public function raceUpload()
    {
        $series = Series::where('code', 'acc')->firstOrFail();
        $seasons = Season::where([
            ['status', '<', 2],
            ['series', $series['id']]
        ])->get();

        $points = Points::all();

        return view('accupload')
               ->with('points', $points)
               ->with('seasons', $seasons);
    }

    public function parseJson(Request $request)
    {
        $race1 = request()->file('race1');
        $race2 = request()->file('race2');
        $quali = request()->file('quali');
        $classes = request()->file('classes');

        // Mode input not needed as it is set implicitly based on file uploads
        //$mode = request()->has('mode') ? request()->mode : 0;

        // First call for parseResults with quali, race1, class and mode as true
        $this->parseResults($quali, $race1, $classes, false);

        // Second call for parseResults with race1, race2, class and mode as false
        if ($race2 && $race2->isValid() && $race2->getSize() > 0) {
            $this->parseResults($race1, $race2, $classes, true);
        }
    }

    // TODO: Accept other encodings. Currently only supports UTF-8
    // ACC Result File are in UTF-16LE encoding
    // UTF-8 conversion is handled. To be tested
    public function parseResults($quali, $race, $classes, $mode)
    {

        // Helper to get file contents as UTF-8
        $getUtf8 = function($file) {
            if (!$file) return null;
            $content = file_get_contents($file);
            $encoding = mb_detect_encoding($content, 'UTF-8, UTF-16LE, UTF-16BE, ISO-8859-1, ISO-8859-15, Windows-1252', true);
            if ($encoding !== 'UTF-8') {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
            }
            return $content;
        };

        $race_content = $getUtf8($race);
        $quali_content = $getUtf8($quali);
        $classes_content = $getUtf8($classes);

        $jq = json_decode($quali_content, true);
        $json = json_decode($race_content, true);

        $round = (int)request()->round;
        $points = (int)request()->points;
        $season = Season::find(request()->season);

        $sp_circuit = Circuit::getTrackByGame($json['trackName'], $season['series']);
        if ($sp_circuit == null) {
            return response()->json([]);
        }

        $totalLaps = 0;
        $results = array();
        if (count($json['sessionResult']['leaderBoardLines']) > 0) {
            $totalLaps = $json['sessionResult']['leaderBoardLines'][0]['timing']['lapCount'];
        }

        $track = array(
            'circuit_id' => $sp_circuit['id'],
            'official' => $sp_circuit['official'],
            'display' => $sp_circuit['name'],
            "season_id" => $season['id'],
            "distance" => $totalLaps / 10.0,
            "points" => (int)$points,
            "round" => $round
        );

        $qualiPosition = array();
        foreach ($jq['sessionResult']['leaderBoardLines'] as $k => $driver) {
            if ($mode) {
                // Multi Session, Single Driver Setup
                if (!array_key_exists($driver['currentDriver']['playerId'], $qualiPosition)) {
                    $qualiPosition[$driver['currentDriver']['playerId']] = $k + 1;
                }
            } else {
                // Single Session, Multi Driver Setup
                $qualiPosition[$driver['car']['carId']] = $k + 1;
            }
        }

        foreach ($json['sessionResult']['leaderBoardLines'] as $k => $driver) {
            $user = User::where('steam_id', substr($driver['currentDriver']['playerId'], 1))->first();
            $dr = Driver::where('user_id', $user['id'])->first();
            if ($dr == null) {
                $dr['name'] = $driver['currentDriver']['shortName'];
                $dr['id'] = -1;
            }

            $grid = 0;
            $status = 0;
            $total_time = "";
            $bestLap = "";
            $team_ind = array_search($driver['car']['carModel'], array_column($season['constructors'], "game"));

            // Grid Position
            if ($mode) {
                if (array_key_exists($driver['currentDriver']['playerId'], $qualiPosition)) {
                    $grid = $qualiPosition[$driver['currentDriver']['playerId']];
                }
            } else {
                if (array_key_exists($driver['car']['carId'], $qualiPosition)) {
                    $grid = $qualiPosition[$driver['car']['carId']];
                }
            }

            // Fastest Lap
            if ($json['sessionResult']['bestlap'] == $driver['timing']['bestLap'] && $k < 10) {
                $status = 1;
            }

            // Total Time
            // if($totalLaps == $driver['timing']['lapCount'])
            if ($driver['timing']['lastLap'] == 2147483647) {
                $status = -2;
                $total_time = "DNF";
            } else {
                $total_time = $this->convertMillisToStandard($driver['timing']['totalTime']);
            }
            // else
            // {
            //     $total_time = "+" . ($totalLaps - $driver['timing']['lapCount']) . " Lap";
            //     if($totalLaps - $driver['timing']['lapCount'] > 1)
            //         $total_time .= "s";
            // }

            if ($driver['timing']['bestLap'] == 2147483647) {
                $bestLap = "-";
            } else {
                $bestLap = $this->convertMillisToStandard($driver['timing']['bestLap']);
            }

            // Push to Results
            array_push($results, array(
                "position" => $k + 1,
                "driver" => $dr['name'],
                "driver_id" => $dr['id'],
                "matched_driver" => $dr['name'],
                "team" => $season['constructors'][$team_ind]['name'],
                "constructor_id" => $season['constructors'][$team_ind]['id'],
                "matched_team" => $season['constructors'][$team_ind]['name'],
                "grid" => $grid,
                "stops" => $driver['timing']['lapCount'],
                "status" => $status,
                "fastestlaptime" => $bestLap,
                "time" => $total_time
            ));
        }

        // Prepare the base JSON structure
        $overall = ["track" => $track, "results" => $results];
        $overall['results'] = array_values($overall['results']);
        usort($overall['results'], function($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        // If classes file is not provided, only download overall.json
        if (!$classes) {
            $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'acc_json_' . uniqid();
            mkdir($tmpDir);
            file_put_contents($tmpDir . '/overall.json', json_encode($overall, JSON_PRETTY_PRINT));
            return response()->download($tmpDir . '/overall.json', 'overall.json')->deleteFileAfterSend(true);
        }

        // Otherwise, do the class split and zip logic
        $pro = null;
        $silver = null;
        $am = null;
        $class_json = [];
        if ($classes_content) {
            $class_json = json_decode($classes_content, true);
        }
        if (is_array($class_json) && isset($class_json['pro']) && isset($class_json['silver']) && isset($class_json['am'])) {
            foreach (["pro", "silver", "am"] as $classKey) {
                $classDrivers = isset($class_json[$classKey]['drivers']) ? $class_json[$classKey]['drivers'] : [];
                $classSeason = isset($class_json[$classKey]['season']) ? $class_json[$classKey]['season'] : $track['season_id'];
                $classTrack = $track;
                $classTrack['season_id'] = $classSeason;
                $filteredResults = array_filter($results, function($r) use ($classDrivers) {
                    return in_array($r['driver_id'], $classDrivers);
                });
                $filteredResults = array_values($filteredResults);
                usort($filteredResults, function($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
                if ($classKey === 'pro') {
                    $pro = ["track" => $classTrack, "results" => $filteredResults];
                } elseif ($classKey === 'silver') {
                    $silver = ["track" => $classTrack, "results" => $filteredResults];
                } elseif ($classKey === 'am') {
                    $am = ["track" => $classTrack, "results" => $filteredResults];
                }
            }
        } else {
            $pro = ["track" => $track, "results" => $results];
            $silver = ["track" => $track, "results" => $results];
            $am = ["track" => $track, "results" => $results];
        }
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'acc_json_' . uniqid();
        mkdir($tmpDir);
        file_put_contents($tmpDir . '/overall.json', json_encode($overall, JSON_PRETTY_PRINT));
        file_put_contents($tmpDir . '/pro.json', json_encode($pro, JSON_PRETTY_PRINT));
        file_put_contents($tmpDir . '/silver.json', json_encode($silver, JSON_PRETTY_PRINT));
        file_put_contents($tmpDir . '/am.json', json_encode($am, JSON_PRETTY_PRINT));
        $zipPath = $tmpDir . '/results.zip';
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($tmpDir . '/overall.json', 'overall.json');
            $zip->addFile($tmpDir . '/pro.json', 'pro.json');
            $zip->addFile($tmpDir . '/silver.json', 'silver.json');
            $zip->addFile($tmpDir . '/am.json', 'am.json');
            $zip->close();
        }
        return response()->download($zipPath, 'results.zip')->deleteFileAfterSend(true);
    }
}
