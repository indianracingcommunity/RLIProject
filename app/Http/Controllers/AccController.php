<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Image as Img;

use App\Http\Requests\RaceResults;

use App\User;
use App\Race;
use App\Result;
use App\Driver;
use App\Season;
use App\Circuit;
use App\Constructor;

class AccController extends Controller
{
    private $output;
    public function __construct() {
        $this->output = new ConsoleOutput();
    }

    public function raceUpload() {
        return view('accupload');
    }
    public function qualiIndex() {
        return view('qualiimage');
    }

    public function closest_match($input, $dic) {

        // no shortest distance found, yet
        $shortest = -1;
        $index = 0;

        // loop through words to find the closest
        foreach ($dic as $i => $word) {

            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($input, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                //$closest = $word;
                $index = $i;
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                // set the closest match, and shortest distance
                //$closest  = $word;
                $index = $i;
                $shortest = $lev;
            }
        }

        $res = array($index, $shortest);
        return $res;
    }

    protected function crude_flatten($array) {
        $res = array();
        for($i = 0; $i < count($array); $i++) {
            $ires = array();
            $ires['id'] = $array[$i]['id'];
            $ires['name'] = $array[$i]['name'];

            foreach($array[$i]['alias'] as $j => $alias) {
                $ires['alias'] = $alias;
                array_push($res, $ires);
            }
        }
        return $res;
    }

    public function race_name(String $src, Bool $pub=false) {
        $tess = new TesseractOCR();
        $tess->lang('eng')->psm(1);

        $imag = $this->getImage($src, "name");
        $tess->image($imag->dirname . '/' . $imag->basename);
        $tr = $tess->run();
        unlink($imag->dirname . '/' . $imag->basename);

        //Replace Series of '\n' with a single '$'
        $tri = preg_replace('/\n+/', '$', $tr);
        $track = explode("$", $tri);

        if(count($track) < 2)
            return response()->json($track);

        $circuits = Circuit::getOfficial();

        if($pub) {
            return array(
                'official' => $track[1],
                'display' => $track[0]
            );
        }

        $official = array_column($circuits, 'official');
        $index = $this->closest_match($track[1], $official);
        return array(
            'circuit_id' => $circuits[$index[0]]['id'],
            'official' => $track[1],
            'display' => $track[0]
        );
    }

    public function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
         return mb_convert_encoding($content, 'UTF-8',
             mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function parseJson(Request $request) {
        ini_set('max_execution_time', 300);
        $file = request()->file('photo');      // <input type="file" name="fileinput" />
        //$fileEndEnd = mb_convert_encoding($file, 'UTF-8', "UTF-16LE");
        //$file8 = mb_convert_encoding($file16, 'utf-8');
        $content = file_get_contents($file);
        $json = json_decode($content, true);

        $circuit = Circuit::getTrackByGame($json['trackName']);
        if($circuit == null) return response()->json([]);

        $track = array(
            'circuit_id' => $circuit['id'],
            'official' => $circuit['official'],
            'display' => $circuit['name'],
        );
        return response()->json(["f" => $json]);
    }

    public function testing()
    {
        $string = '{"track":{"circuit_id":4,"official":"BAKU CITY CIRCUIT","display":"AZERBAIJAN GRAND PRIX - RACE"},"results":[{"position":4,"driver":"MaranelloBaby","driver_id":2,"matched_driver":"MaranelloBaby","team":"McLaren","constructor_id":4,"matched_team":"McLaren","grid":2,"stops":2,"fastestlaptime":"1:39.783","time":"48:04.219"},{"position":2,"driver":"GensralPeps","driver_id":13,"matched_driver":"GeneralPepe","team":"Visi","constructor_id":1,"matched_team":"Haas","grid":0,"stops":2,"fastestlaptime":"PLE BTy","time":"+1527\""},{"position":3,"driver":"Streeter","driver_id":7,"matched_driver":"Streeter","team":"Tara Rosso","constructor_id":5,"matched_team":"Toro Rosso","grid":5,"stops":1,"fastestlaptime":"1:43.891","time":"+21.078"},{"position":4,"driver":"IRC | The\u2014Re...","driver_id":5,"matched_driver":"IRC | The\u2014Re...","team":"Haas","constructor_id":1,"matched_team":"Haas","grid":3,"stops":3,"fastestlaptime":"1:43.021","time":"+46.711"},{"position":5,"driver":"TanyR31","driver_id":8,"matched_driver":"TanyR31","team":"Taro Rassa","constructor_id":5,"matched_team":"Toro Rosso","grid":8,"stops":2,"fastestlaptime":"1:43.233","time":"#1:04.222"},{"position":6,"driver":"Rambo.","driver_id":24,"matched_driver":"Rambo","team":"Williams","constructor_id":7,"matched_team":"Williams","grid":6,"stops":3,"fastestlaptime":"1:44.642","time":"+1:08.372"},{"position":7,"driver":"Monk007","driver_id":18,"matched_driver":"Monk007","team":"Renault","constructor_id":6,"matched_team":"Renault","grid":14,"stops":2,"fastestlaptime":"1:48.219","time":"+1 Lap"},{"position":8,"driver":"kapilace6","driver_id":3,"matched_driver":"kapilace6","team":"Red Bull Racing","constructor_id":2,"matched_team":"Red Bull Racing","grid":13,"stops":2,"fastestlaptime":"1:42.651","time":"DNF"},{"position":5,"driver":"Im_A_Myth","driver_id":25,"matched_driver":"Im_A_Myth","team":"Ferrari","constructor_id":10,"matched_team":"Ferrari","grid":1,"stops":4,"fastestlaptime":"1:42.570","time":"ONF"},{"position":10,"driver":"LoneShark","driver_id":27,"matched_driver":"LoneShark","team":"Alfa Romeo Racing","constructor_id":3,"matched_team":"Alfa Romeo Racing","grid":16,"stops":2,"fastestlaptime":"1:43.399","time":"DNF"},{"position":0,"driver":"IRC] rANT","driver_id":20,"matched_driver":"IRC||rANT","team":"Ferrari","constructor_id":10,"matched_team":"Ferrari","grid":10,"stops":4,"fastestlaptime":"1,48.547","time":"DNF"},{"position":12,"driver":"thekC66","driver_id":6,"matched_driver":"theKC66","team":"Red Bull Racing","constructor_id":2,"matched_team":"Red Bull Racing","grid":0,"stops":1,"fastestlaptime":"2:04.452","time":"DNF"},{"position":13,"driver":"BlackSheep","driver_id":19,"matched_driver":"BlackSheep","team":"Mercedes-AMG Petronas","constructor_id":9,"matched_team":"Mercedes-AMG Petronas","grid":7,"stops":1,"fastestlaptime":"1:59,574","time":"DNF"},{"position":14,"driver":"deathblaom1424","driver_id":17,"matched_driver":"deathbloom1421","team":"Mercedes-AMG Petranas","constructor_id":9,"matched_team":"Mercedes-AMG Petronas","grid":3,"stops":0,"fastestlaptime":"neten inne","time":"DNF"}]}';
        $dec = json_decode($string, true);
        $count = count($dec['results']);
        return $dec;
        // return view('standings.review')
        // ->with('json',$dec)
        // ->with('count',$count);
    }

    public function testsave()
    {
        $data = request()->all();
        $track = array("circuit_id"=>$data['circuit_id'],"official"=>$data['official'],"display"=>$data['display']);
        for( $i=0; $i<5; $i++){
       
        $results = array("position"=>$data['position'.$i],"driver"=>$data['driver'.$i],"driver_id"=>$data['driver_id'.$i],"matched_driver"=>$data['matched_driver'.$i],"team"=>$data['team'.$i],"constructor_id"=>$data['constructor_id'.$i],"matched_team"=>$data['matched_team'.$i],"grid"=>$data['grid'.$i],"stops"=>$data['stops'.$i],"fastestlaptime"=>$data['fastestlaptime'.$i],"time"=>$data['time'.$i]);

       $json = response()->json([ 
        "track" => $track,
        "results" => $results
         
    ]);

    return $json;
       }  
      
    }
}
