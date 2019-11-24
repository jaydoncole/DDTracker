<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getLocations()
    {
        return response()->json(\App\Location::all());
    }

    public function getDifficultyLevels()
    {
        return response()->json(\App\DifficultyLevel::all());
    }

    public function getLocationLengths()
    {
        return response()->json(\App\LocationLength::all());
    }

    public function getCharacters()
    {
        return response()->json(\App\Character::all());
    }

    public function getProvisions()
    {
        return response()->json(\App\Provision::all());
    }


    public function getCharacterSelection($slot, $location)
    {
        $characters = \App\Character::all();
        $characterSelections = $this->suggestCharacters($characters, $slot, $location);
        return response()->json(array('status' => 'success', 'characters' => $characterSelections));
        
    }

    private function suggestCharacters($characters, $slot, $location)
    {
        $characterPosition = 'position_' . $slot . '_rank';
        $characterSuggestions = array();
        foreach($characters as $character) {
            $recommendation = \App\CharacterLocationPairing
                ::where('character_id', '=', $character->id)
                ->where('location_id', '=', $location)
                ->first();
            if($recommendation['recommendation_code'] == 1 && $character->$characterPosition > 5) {
                $characterSuggestions[] = array('id' => $character->id, 'recommended' => 1);
            } else if ($recommendation['recommendation_code'] == 2 && $character->$characterPosition > 5) {
                $characterSuggestions[] = array('id' => $character->id, 'recommended' => 2);
            } else {
                $characterSuggestions[] = array('id' => $character->id, 'recommended' => 3);
            }
        }
        return $characterSuggestions;
    }

    public function getProvisionRecommendations($location, $length)
    {
        $provisionRecommendations = array();
        $provisions = \App\Provision::all();
        foreach($provisions as $provision) {
            $provisionDetails = \DB::table('dungeon_runs')
                ->join('dungeon_run_provisions', 'dungeon_run_provisions.dungeon_run_id', '=', 'dungeon_runs.id')
                ->where('dungeon_runs.location_id', '=', $location)
                ->where('dungeon_runs.location_length', '=', $length)
                ->where('dungeon_run_provisions.provision_id', '=', $provision->id)
                ->get();
            $provisionRecommendations[] = array(
                'provision_id' => $provision->id,
                'recommendation' => (count($provisionDetails) > 10)
                    ? $this->calculateProvisionDetails($provisionDetails)
                    : $this->getDefaultProvisionRecommendations($location, $length, $provision->id));
        }
        return response()->json($provisionRecommendations);
    }

    private function calculateProvisionDetails($provisionDetails)
    {
        $recommendedAmount = 0;
        $totalNeeded = 0;
        foreach($provisionDetails as $provisionDetail) {
            $totalNeeded += $provisionDetail->amount_used;
        }
        $recommendedAmount = round($totalNeeded / count($provisionDetails));
        return $recommendedAmount;
    }


    private function getDefaultProvisionRecommendations($location, $length, $provisionId)
    {
        $provisionRecommendation = \App\StartingProvisionRecommendation
            ::where('location_id', '=', $location)
            ->where('location_length', '=', $length)
            ->where('provision_id', '=', $provisionId)
            ->first();
        return $provisionRecommendation->recommended_amount;
    }


    public function saveRun(Request $request)
    {
        $dungeonRun = new \App\DungeonRun();
        $dungeonRun->location_id = $request->location_id;
        $dungeonRun->location_length = $request->location_length;
        $dungeonRun->difficulty_level = $request->difficulty_level;
        $dungeonRun->run_completed = is_null($request->run_completed) ? 0 : 1;
        $dungeonRun->save();

        for($i = 1; $i <= 4; $i++) {
            $character = new \App\DungeonRunCharacter();
            $character->dungeon_run_id = $dungeonRun->id;
            $characterSlot = 'character_slot_' . $i;
            $characterDied = 'slot_' . $i . '_died';
            $characterSurvived = $request->$characterDied && $request->$characterDied == 1 ? 0 : 1;
            $character->character_id = $request->$characterSlot;   
            $character->position = $i;
            $character->character_survived = $characterSurvived;
            $character->save();
        }

        foreach($request->provision as $provisionStats) {
            $provision = new \App\DungeonRunProvision(); 
            $provision->dungeon_run_id = $dungeonRun->id; 
            $provision->provision_id = $provisionStats['id']; 
            $provision->amount_used = is_null($provisionStats['used']) ? 0 : $provisionStats['used'];
            $provision->save();
        }

        return response()->json(array('status' => 'saved'));
    }
}
