<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Points;

class AddPost10ColumnsToPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            $presentColumns = Schema::getColumnListing('points');
            for ($i = 11; $i < 31; ++$i) {
                if (in_array(strval($i), $presentColumns)) {
                    $table->renameColumn("`" . strval($i) . "`", 'P' . $i);
                } else {
                    $table->integer('P' . $i)->default(0);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Is there non-zero data in the column?
            // If so, rename the column without the P
            // Else, drop the column
        Schema::table('points', function (Blueprint $table) {
            $pointsColumnList = [];
            for ($i = 30; $i > 10; --$i) {
                array_push($pointsColumnList, DB::raw("SUM(`P" . $i . "`) as `P" . $i . "`"));
            }
            $pointsSumPerColumn = Points::select($pointsColumnList)
                                        ->first()->toArray();

            foreach ($pointsSumPerColumn as $pointsColumn => $pointsSum) {
                if ($pointsSum == "0") {
                    $table->dropColumn($pointsColumn);
                } else {
                    $newName = "`" . substr($pointsColumn, 1) . "`";
                    $table->renameColumn($pointsColumn, $newName);
                }
            }
        });
    }
}
