<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            if(!count($provisionDetails)) {
                $provisionRecomendations[] = array('provision_id' => $provision->id, 'recomendation' => $this->GetDefaultProvisionRecomendations($location, $length, $provision->id));
            }
            
        }
        return $provisionRecomendations;
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
