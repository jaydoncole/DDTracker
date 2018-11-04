<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Sets up the database structure and inserts the data for the "static" tables that will be relied on by other tables
 */
class InitialMigration extends Migration
{
    public function up()
    {
        Schema::create('locations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description', 300)->default('');    
            $table->string('notes', 300)->default('');
        });

        Schema::create('difficulty_levels', function(Blueprint $table) {
            $table->increments('id');
            $table->string('description');  
        });


        Schema::create('location_lengths', function(Blueprint $table) {
            $table->increments('id');
            $table->string('description');
        });


        Schema::create('characters', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description', 300)->default('');
            $table->integer('position_1_rank')->default(0);
            $table->integer('position_2_rank')->default(0);
            $table->integer('position_3_rank')->default(0);
            $table->integer('position_4_rank')->default(0);
            $table->string('icon');
            $table->string('notes', 300)->default('');    
        });


        Schema::create('character_recomendation_codes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('description');
        });

        Schema::create('character_location_pairings', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('character_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('recomendation_code');
            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('recomendation_code')->references('id')->on('character_recomendation_codes');
        });

        Schema::create('provisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('price');  
        });


        Schema::create('starting_provision_recomendations', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('location_length');
            $table->unsignedInteger('provision_id');
            $table->unsignedInteger('recommended_amount');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('location_length')->references('id')->on('location_lengths');
            $table->foreign('provision_id')->references('id')->on('provisions');
        });

        Schema::create('dungeon_runs', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('location_length');
            $table->unsignedInteger('difficulty_level');
            $table->boolean('run_completed');
            $table->string('notes', 300)->default('');
            $table->timestamp('run_time')->nullable;
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('location_length')->references('id')->on('location_lengths');
            $table->foreign('difficulty_level')->references('id')->on('difficulty_levels');
        });

        Schema::create('dungeon_run_provisions', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dungeon_run_id');
            $table->unsignedInteger('provision_id');
            $table->unsignedInteger('amount_taken');
            $table->unsignedInteger('amount_unused');
            $table->unsignedInteger('amount_lacking');
            $table->foreign('dungeon_run_id')->references('id')->on('dungeon_runs');
            $table->foreign('provision_id')->references('id')->on('provisions');
        });

        Schema::create('dungeon_run_characters', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dungeon_run_id');
            $table->unsignedInteger('character_id');
            $table->unsignedInteger('position');            
            $table->boolean('character_survived');
            $table->foreign('dungeon_run_id')->references('id')->on('dungeon_runs');
            $table->foreign('character_id')->references('id')->on('characters');
        });

        Schema::create('curios', function(Blueprint $table) {
            $table->increments('id');   
            $table->string('name');
            $table->unsignedInteger('location')->nullable();
        });

        DB::table('locations')->insert(
            array(
                array('name' => 'The Ruins', 'description' => 'Creatures are vulnerable to blight, and have resiliance to bleed. Most enemies are Unholy make the Crusader especially useful.'),
                array('name' => 'The Warrens', 'description' => 'Creatures are vulnerable to bleed, resiliant to blight. Most enemies are Beast'),
                array('name' => 'The Weald', 'description' => 'Bleed, debuff and move skills are all useful, blight is not as useful here.'),
                array('name' => 'The Cove', 'description' => 'Blight is most useful here, while Bleed damage is less useful. Having high stun resistance is also good here.'),
                array('name' => 'Courtyard', 'description' => 'Creatures are vulnerable to bleed while resistant to blight'),
                array('name' => 'Farmstead', 'description' => 'No need for torches or shovels here. Bring a good Vestal!'),
                array('name' => 'The Darkest Dungeon', 'description' => 'Good luck!')
        ));

        DB::table('difficulty_levels')->insert(
            array(
                array('description' => 'Apprentice'),
                array('description' => 'Veteran'),
                array('description' => 'Champion')
        ));

        DB::table('location_lengths')->insert(
            array(
                array('description' => 'Short'),
                array('description' => 'Medium'),
                array('description' => 'Long'),
                array('description' => 'Epic')
        ));

        DB::table('characters')->insert(
            array(
                array('name' => 'Abomination', 'description' => 'Blight damage in human form. Does increased damage in beast form. Causes stress to other party members when changing to beast form, can heal stress on self only.', 'icon' => 'abomination.png'),
                array('name' => 'Antiquarian', 'description' => 'One of the weakest characters, does light blight damage. Does allow gold to stack more and can find Antiques which are worth more money.', 'icon' => 'antiquarian.png'),
                array('name' => 'Arbalest', 'description' => 'Good overall damage dealer, can mark targets working well with Bounter Hunter, Occultist, and Houndmaster. Also makes a good backup healer', 'icon' => 'arbalest.png'),
                array('name' => 'Bounty Hunter', 'description' => 'Good crowd control abilities make the Bounty Hunter useful in many situations. Can mark targets making them good to pair with Arbalest, Occultist, and Houndmaster', 'icon' => 'bountyhunter.png'),
                array('name' => 'Crusader', 'description' => 'Solid tank, most effective in Ruins where there are a large number of Unholy enemies', 'icon' => 'crusader.png'),
                array('name' => 'Grave Robber', 'description' => 'Works well in many different positions; does good blight damage. Does not work as well with Crusdaders or Lepers who are more position dependent', 'icon' => 'graverobber.png'),
                array('name' => 'Hellion', 'description' => 'Balances damage and durability making her good for the front of the group, does bleed damage.', 'icon' => 'hellion.png'),
                array('name' => 'Highwayman', 'description' => 'Damage dealing character with high mobility making him effective in any position.', 'icon' => 'highwayman.png'),
                array('name' => 'Hound Master', 'description' => 'Does high bleed damage making him more effective in Weald and Warrens, can mark enemies making him a good pairing with Arbalest, Bounty Hunter, and Occultist.', 'icon' => 'houndmaster.png'),
                array('name' => 'Jester', 'description' => 'Highly mobile character that does bleed damage, wouldn\'t work well with unmoving classes such as Crusaders or Lepers', 'icon' => 'jester.png'),
                array('name' => 'Leper', 'description' => 'Takes and gives the largest amounts of damage, works best with characters who can boos accuracy such as Man-at-Arms', 'icon' => 'leper.png'),
                array('name' => 'Man-at-Arms', 'description' => 'Good front-line defender with many buffs that can help the rest of the party.', 'icon' => 'manatarms.png'),
                array('name' => 'Occultist', 'description' => 'Powerful debuffs and healing, works best when boosting critcal  with trinkets to improve morale of the party', 'icon' => 'occultist.png'),
                array('name' => 'Plague Doctor', 'description' => 'Deals good blight damage, is useful for stunning back-row enemies and for buffing allies.', 'icon' => 'plaguedoctor.png'),
                array('name' => 'Vestal', 'description' => 'The best healing class, useful in vertually any group', 'icon' => 'vestal.png'),
                array('name' => 'Flagellant', 'description' => 'Front-line damage dealer that gets stronger with damage. Does bleed damage.', 'icon' => 'flagellant.png'),
                array('name' => 'Shieldbreaker', 'description' => 'Highly mobile character that does blight damage, can break gaurd, and reveal stealthed enemies.', 'icon' => 'shieldbreaker.png')
        ));

        DB::table('character_recomendation_codes')->insert(
            array(
                array('description' => 'Recommended'),
                array('description' => 'Acceptable'),
                array('description' => 'Not Recommended')
        ));


        DB::table('provisions')->insert(
            array(
                array('name' => 'Food', 'description' => 'Eat to restor health and prevent hunger', 'price' => 75),
                array('name' => 'Shovel', 'description' => 'Removes obstacles', 'price' => 250),
                array('name' => 'Antivenom', 'description' => 'Counters blight, poison, and toxins', 'price' => 150),
                array('name' => 'Bandage', 'description' => 'Stops bleeding', 'price' => 150),
                array('name' => 'Medicinal Herbs', 'description' => 'Cures diseases and maladies', 'price' => 200),
                array('name' => 'Skeleton Key', 'description' => 'Unlocks strongboxes and doors', 'price' => 200),
                array('name' => 'Holy Water', 'description' => 'Restores purity and purges evil', 'price' => 150),
                array('name' => 'Laudanum', 'description' => 'Cures horror effects', 'price' => 100),
                array('name' => 'Torch', 'description' => 'Increases the light level', 'price' => 75),
                array('name' => 'Firewood', 'description' => 'Sets up camping', 'price' => 0),
        ));
    }


    public function down()
    {
        Schema::table('character_location_pairings', function(Blueprint $table) {
            $table->dropForeign('character_location_pairings_character_id_foreign');
            $table->dropForeign('character_location_pairings_location_id_foreign');
            $table->dropForeign('character_location_pairings_recomendation_code_foreign');
        });
        Schema::table('starting_provision_recomendations', function(Blueprint $table) {
            $table->dropForeign('starting_provision_recomendations_location_id_foreign');
            $table->dropForeign('starting_provision_recomendations_location_length_foreign');
            $table->dropForeign('starting_provision_recomendatons_provision_id_foreign');
        });
        Schema::table('dungeon_runs', function(Blueprint $table) {
            $table->dropForeign('dungeon_runs_location_id_foreign');
            $table->dropForeign('dungeon_runs_location_length_foreign');
            $table->dropForeign('dungeon_runs_difficulty_level_foreign');
        });
        Schema::table('dungeon_run_provisions', function(Blueprint $table){
            $table->dropForeign('dungeon_run_gear_dungeon_run_id_foreign');
            $table->dropForeign('dungeon_run_gear_provision_id_foreign');
        });
        Schema::table('dungeon_run_provisions', function(Blueprint $table) {
            $table->dropForeign('dungeon_run_characters_dungeon_run_id_foreign');
            $table->dropForeign('dungeon_run_characters_dungeon_character_id_foreign');
        });
        Schema::drop('dungeon_run_provisions');
        Schema::drop('dungeon_runs');
        Schema::drop('starting_provision_recomendations');
        Schema::drop('character_location_pairings');
        Schema::drop('provisions');
        Schema::drop('difficulty_levels');
        Schema::drop('location_lengths');
        Schema::drop('characters');
        Schema::drop('character_recomendation_codes');
        Schema::drop('dungeon_run_characters');
        Schema::drop('curios');
        Schema::drop('locations');
    }
}

