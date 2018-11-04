<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CharacterRecommendations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('character_location_pairings')->insert(
            array(
                // The Ruins: Creatures are unholy, vulnerable to blight, resitent to beed
                array('character_id' => 1,  'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 2,  'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 3,  'location_id' => 1, 'recomendation_code' => 2),
                array('character_id' => 4,  'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 5,  'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 6,  'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 7,  'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 8,  'location_id' => 1, 'recomendation_code' => 2),
                array('character_id' => 9,  'location_id' => 1, 'recomendation_code' => 3),
                array('character_id' => 10, 'location_id' => 1, 'recomendation_code' => 3),
                array('character_id' => 11, 'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 12, 'location_id' => 1, 'recomendation_code' => 2),
                array('character_id' => 13, 'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 14, 'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 15, 'location_id' => 1, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 1, 'recomendation_code' => 3),
                array('character_id' => 17, 'location_id' => 1, 'recomendation_code' => 2),

                // The Warrens: Creatures are mostly beast vulnerable to bleed, resiliant to blight
                array('character_id' => 1,  'location_id' => 2, 'recomendation_code' => 3),
                array('character_id' => 2,  'location_id' => 2, 'recomendation_code' => 2),
                array('character_id' => 3,  'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 4,  'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 5,  'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 6,  'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 7,  'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 8,  'location_id' => 2, 'recomendation_code' => 2),
                array('character_id' => 9,  'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 10, 'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 11, 'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 12, 'location_id' => 2, 'recomendation_code' => 2),
                array('character_id' => 13, 'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 14, 'location_id' => 2, 'recomendation_code' => 3),
                array('character_id' => 15, 'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 2, 'recomendation_code' => 1),
                array('character_id' => 17, 'location_id' => 2, 'recomendation_code' => 2),

                // The Weald: Monstars vulnerable to bleed, debuf and move skills are useful
                array('character_id' => 1,  'location_id' => 3, 'recomendation_code' => 3),
                array('character_id' => 2,  'location_id' => 3, 'recomendation_code' => 2),
                array('character_id' => 3,  'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 4,  'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 5,  'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 6,  'location_id' => 3, 'recomendation_code' => 2),
                array('character_id' => 7,  'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 8,  'location_id' => 3, 'recomendation_code' => 2),
                array('character_id' => 9,  'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 10, 'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 11, 'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 12, 'location_id' => 3, 'recomendation_code' => 2),
                array('character_id' => 13, 'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 14, 'location_id' => 3, 'recomendation_code' => 2),
                array('character_id' => 15, 'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 3, 'recomendation_code' => 1),
                array('character_id' => 17, 'location_id' => 3, 'recomendation_code' => 2),

                // The Cove: Resistant to bleeding, susceptible to blight
                array('character_id' => 1,  'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 2,  'location_id' => 4, 'recomendation_code' => 2),
                array('character_id' => 3,  'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 4,  'location_id' => 4, 'recomendation_code' => 3),
                array('character_id' => 5,  'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 6,  'location_id' => 4, 'recomendation_code' => 2),
                array('character_id' => 7,  'location_id' => 4, 'recomendation_code' => 2),
                array('character_id' => 8,  'location_id' => 4, 'recomendation_code' => 3),
                array('character_id' => 9,  'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 10, 'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 11, 'location_id' => 4, 'recomendation_code' => 2),
                array('character_id' => 12, 'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 13, 'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 14, 'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 15, 'location_id' => 4, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 4, 'recomendation_code' => 2),
                array('character_id' => 17, 'location_id' => 4, 'recomendation_code' => 2),


                // The Courtyard
                array('character_id' => 1,  'location_id' => 5, 'recomendation_code' => 2),
                array('character_id' => 2,  'location_id' => 5, 'recomendation_code' => 2),
                array('character_id' => 3,  'location_id' => 5, 'recomendation_code' => 3),
                array('character_id' => 4,  'location_id' => 5, 'recomendation_code' => 2),
                array('character_id' => 5,  'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 6,  'location_id' => 5, 'recomendation_code' => 2),
                array('character_id' => 7,  'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 8,  'location_id' => 5, 'recomendation_code' => 2),
                array('character_id' => 9,  'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 10, 'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 11, 'location_id' => 5, 'recomendation_code' => 3),
                array('character_id' => 12, 'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 13, 'location_id' => 5, 'recomendation_code' => 3),
                array('character_id' => 14, 'location_id' => 5, 'recomendation_code' => 3),
                array('character_id' => 15, 'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 5, 'recomendation_code' => 1),
                array('character_id' => 17, 'location_id' => 5, 'recomendation_code' => 2),

                // Farmstead
                array('character_id' => 1,  'location_id' => 6, 'recomendation_code' => 2),
                array('character_id' => 2,  'location_id' => 6, 'recomendation_code' => 2),
                array('character_id' => 3,  'location_id' => 6, 'recomendation_code' => 3),
                array('character_id' => 4,  'location_id' => 6, 'recomendation_code' => 3),
                array('character_id' => 5,  'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 6,  'location_id' => 6, 'recomendation_code' => 2),
                array('character_id' => 7,  'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 8,  'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 9,  'location_id' => 6, 'recomendation_code' => 2),
                array('character_id' => 10, 'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 11, 'location_id' => 6, 'recomendation_code' => 3),
                array('character_id' => 12, 'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 13, 'location_id' => 6, 'recomendation_code' => 2),
                array('character_id' => 14, 'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 15, 'location_id' => 6, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 6, 'recomendation_code' => 3),
                array('character_id' => 17, 'location_id' => 6, 'recomendation_code' => 2),
            
                // The Darkest Dungeon
                array('character_id' => 1,  'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 2,  'location_id' => 7, 'recomendation_code' => 2),
                array('character_id' => 3,  'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 4,  'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 5,  'location_id' => 7, 'recomendation_code' => 2),
                array('character_id' => 6,  'location_id' => 7, 'recomendation_code' => 2),
                array('character_id' => 7,  'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 8,  'location_id' => 7, 'recomendation_code' => 2),
                array('character_id' => 9,  'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 10, 'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 11, 'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 12, 'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 13, 'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 14, 'location_id' => 7, 'recomendation_code' => 2),
                array('character_id' => 15, 'location_id' => 7, 'recomendation_code' => 1),
                array('character_id' => 16, 'location_id' => 7, 'recomendation_code' => 2),
                array('character_id' => 17, 'location_id' => 7, 'recomendation_code' => 2)
                
            )
        );


        DB::table('characters')->where('id', 1) ->update(array('position_4_rank' => 2, 'position_3_rank' => 5, 'position_2_rank' => 7, 'position_1_rank' => 5));
        DB::table('characters')->where('id', 2) ->update(array('position_4_rank' => 7, 'position_3_rank' => 7, 'position_2_rank' => 5, 'position_1_rank' => 5));
        DB::table('characters')->where('id', 3) ->update(array('position_4_rank' => 7, 'position_3_rank' => 7, 'position_2_rank' => 2, 'position_1_rank' => 2));
        DB::table('characters')->where('id', 4) ->update(array('position_4_rank' => 4, 'position_3_rank' => 6, 'position_2_rank' => 7, 'position_1_rank' => 5));
        DB::table('characters')->where('id', 5) ->update(array('position_4_rank' => 2, 'position_3_rank' => 2, 'position_2_rank' => 6, 'position_1_rank' => 6));
        DB::table('characters')->where('id', 6) ->update(array('position_4_rank' => 5, 'position_3_rank' => 6, 'position_2_rank' => 6, 'position_1_rank' => 3));
        DB::table('characters')->where('id', 7) ->update(array('position_4_rank' => 2, 'position_3_rank' => 3, 'position_2_rank' => 5, 'position_1_rank' => 6));
        DB::table('characters')->where('id', 8) ->update(array('position_4_rank' => 3, 'position_3_rank' => 6, 'position_2_rank' => 6, 'position_1_rank' => 4));
        DB::table('characters')->where('id', 9) ->update(array('position_4_rank' => 6, 'position_3_rank' => 6, 'position_2_rank' => 6, 'position_1_rank' => 4));
        DB::table('characters')->where('id', 10)->update(array('position_4_rank' => 4, 'position_3_rank' => 6, 'position_2_rank' => 6, 'position_1_rank' => 2));
        DB::table('characters')->where('id', 11)->update(array('position_4_rank' => 1, 'position_3_rank' => 2, 'position_2_rank' => 5, 'position_1_rank' => 7));
        DB::table('characters')->where('id', 12)->update(array('position_4_rank' => 4, 'position_3_rank' => 5, 'position_2_rank' => 7, 'position_1_rank' => 7));
        DB::table('characters')->where('id', 13)->update(array('position_4_rank' => 5, 'position_3_rank' => 6, 'position_2_rank' => 6, 'position_1_rank' => 5));
        DB::table('characters')->where('id', 14)->update(array('position_4_rank' => 6, 'position_3_rank' => 7, 'position_2_rank' => 4, 'position_1_rank' => 2));
        DB::table('characters')->where('id', 15)->update(array('position_4_rank' => 6, 'position_3_rank' => 7, 'position_2_rank' => 5, 'position_1_rank' => 3));
        DB::table('characters')->where('id', 16)->update(array('position_4_rank' => 4, 'position_3_rank' => 4, 'position_2_rank' => 7, 'position_1_rank' => 7));
        DB::table('characters')->where('id', 17)->update(array('position_4_rank' => 1, 'position_3_rank' => 5, 'position_2_rank' => 5, 'position_1_rank' => 6));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
