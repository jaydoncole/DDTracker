<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DungeonRun;
use App\DungeonRunCharacter;
use App\DungeonRunProvision;

class DungeonRunController extends Controller 
{
    public function StartRun()
    {
        $provisionsRecomendations = $this->GetProvisionRecomendations(1, 1);
        $provisions = \App\Provision::all();
        foreach($provisions as $provision) {
            foreach($provisionsRecomendations as $provisionRecomendation) {
                if($provision->id === $provisionRecomendation['provision_id']) {
                    $provision->recommended = $provisionRecomendation['recomendation'];
                    break;
                }
            }
        }
        return view('dungeonRun')
            ->with('locations', \App\Location::all())
            ->with('difficultyLevels', \App\DifficultyLevel::all())
            ->with('locationLengths', \App\LocationLength::all())
            ->with('characters', \App\Character::all())
            ->with('provisions', $provisions);
    }




    public function SaveRun(Request $request)
    {
        $dungeonRun = new DungeonRun();
        $dungeonRun->location_id = $request->location;
        $dungeonRun->location_length = $request->length;
        $dungeonRun->difficulty_level = $request->difficulty;
        $dungeonRun->run_completed = is_null($request->successful_run) ? 0 : 1;
        $dungeonRun->save();

        for($i = 1; $i <= 4; $i++) {
            $character = new DungeonRunCharacter();
            $character->dungeon_run_id = $dungeonRun->id;
            $characterSlot = 'character_slot_' . $i;
            $characterDied = 'slot_' . $i . '_died';
            $characterSurvived = $request->$characterDied && $request->$characterDied == 1 ? 0 : 1;
            $character->character_id = $request->$characterSlot;   
            $character->position = $i;
            $character->character_survived = $characterSurvived;
            $character->save();
        }

        foreach($request->provision as $provisionId => $provisionStats) {
            $provision = new DungeonRunProvision();
            $provision->dungeon_run_id = $dungeonRun->id;
            $provision->provision_id = $provisionId;
            $provision->amount_taken = is_null($provisionStats['taken']) ? 0 : $provisionStats['taken'];
            $provision->amount_unused = is_null($provisionStats['unused']) ? 0 : $provisionStats['unused'];
            $provision->amount_lacking = is_null($provisionStats['lacking']) ? 0 : $provisionStats['lacking'];
            $provision->save();
        }

        return redirect('dungeonRun');
    }


    public function GetProvisionRecomendations($location = 1, $length = 1)
    {
        $provisionRecomendations = array();
        $provisions = \App\Provision::all();
        foreach($provisions as $provision) {
            $provisionDetails = \DB::table('dungeon_runs')
                ->join('dungeon_run_provisions', 'dungeon_run_provisions.dungeon_run_id', '=', 'dungeon_runs.id')
                ->where('dungeon_runs.location_id', '=', $location)
                ->where('dungeon_runs.location_length', '=', $length)
                ->where('dungeon_run_provisions.provision_id', '=', $provision->id)
                ->get();
            $provisionRecomendations[] = array(
                'provision_id' => $provision->id, 
                'recomendation' => (count($provisionDetails) > 10) 
                    ? $this->CalculateProvisionDetails($provisionDetails)
                    : $this->GetDefaultProvisionRecomendations($location, $length, $provision->id));
        }
        return $provisionRecomendations;
    }

    private function CalculateProvisionDetails($provisionDetails)
    {
        $recommendedAmount = 0;
        $totalNeeded = 0;
        foreach($provisionDetails as $provisionDetail) {
            $totalNeeded += $provisionDetail->amount_taken - $provisionDetail->amount_unused + $provisionDetail->amount_lacking;
        }
        $recommendedAmount = round($totalNeeded / count($provisionDetails));
        return $recommendedAmount;
    }

    private function GetDefaultProvisionRecomendations($location, $length, $provisionId)
    {
        $provisionRecomendation = \App\StartingProvisionRecomendation
            ::where('location_id', '=', $location)
            ->where('location_length', '=', $length)
            ->where('provision_id', '=', $provisionId)
            ->first();
        return $provisionRecomendation->recommended_amount;
        

    }

    public function GetCharacterSelection($slot, $location)
    {
        $characters = \App\Character::all();
        $characterSelections = $this->SuggestCharacters($characters, $slot, $location);
        return response()->json(array('status' => 'success', 'characters' => $characterSelections));
        
    }

    private function SuggestCharacters($characters, $slot, $location)
    {
        $characterPosition = 'position_' . $slot . '_rank';
        $characterSuggestions = array();
        foreach($characters as $character) {
            $recomendation = \App\CharacterLocationPairing
                ::where('character_id', '=', $character->id)
                ->where('location_id', '=', $location)
                ->first();
            if($recomendation['recomendation_code'] == 1 && $character->$characterPosition > 5) {
                $characterSuggestions[] = array('id' => $character->id, 'recomended' => 1);
            } else if ($recomendation['recomendation_code'] == 2 && $character->$characterPosition > 5) {
                $characterSuggestions[] = array('id' => $character->id, 'recomended' => 2);
            } else {
                $characterSuggestions[] = array('id' => $character->id, 'recomended' => 3);
            }
        }
        return $characterSuggestions;
    }
}
