<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDungeonRunProvisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::Drop('dungeon_run_provisions');
        Schema::create('dungeon_run_provisions', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('dungeon_run_id');
            $table->unsignedInteger('provision_id');
            $table->unsignedInteger('amount_used');
            $table->foreign('dungeon_run_id')->references('id')->on('dungeon_runs');
            $table->foreign('provision_id')->references('id')->on('provisions');
        });    

        Schema::create('bosses', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->string('name');
        });

        DB::table('bosses')->insert(
            array(
                array('location_id' => 1, 'name' => 'The Necromancer'),
                array('location_id' => 1, 'name' => 'The Blind Prophet'),
                array('location_id' => 2, 'name' => 'The Swine King'),
                array('location_id' => 2, 'name' => 'The Formless Flesh'),
                array('location_id' => 3, 'name' => 'The Hag'),
                array('location_id' => 3, 'name' => 'The Brigand Cannon'),
                array('location_id' => 4, 'name' => 'The Siren'),
                array('location_id' => 4, 'name' => 'The Drowned Crew')
            )
        );
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
