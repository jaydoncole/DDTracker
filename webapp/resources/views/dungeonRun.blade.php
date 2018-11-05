@extends('maintemplate')

@section ('inline-scripts')
<script>
var CharacterSelector = {
    ActiveSlot: 0,

    Load: function() {
        $('#character-slot-4').click(CharacterSelector.FetchCharacterOptions);
        $('#character-slot-3').click(CharacterSelector.FetchCharacterOptions);
        $('#character-slot-2').click(CharacterSelector.FetchCharacterOptions);
        $('#character-slot-1').click(CharacterSelector.FetchCharacterOptions);
        $("body").on('click', '.selectable-character', CharacterSelector.SelectCharacter);
    },

    SelectCharacter: function(e) {
        CharacterSelector.ClearSelectedCharacter();
        $(this).addClass('selected-character');
        $(this).removeClass('unselected-character');
        $("#character-slot-" + CharacterSelector.ActiveSlot).attr("src", $(this).attr("src"));
        $("#selected-character-slot-" + CharacterSelector.ActiveSlot).attr('value', $(this).attr("data-character-id"));
        $("#character-selection-modal").modal("hide");
    },

    ClearSelectedCharacter: function() {
        $('.selectable-character').each(function() {
            $(this).addClass('unselected-character');
            $(this).removeClass('selected-character');
        });
    },

    FetchCharacterOptions: function(e) {
        e.preventDefault();
        CharacterSelector.ActiveSlot = $(this).attr('id').substr(-1, 1);
        var url = $(this).attr('data-selection-url');
        // Replace the last value in the URL with the actual selected location
        url = url.substring(0, url.length - 1) + $('#location').val();
        $.ajax({
            url: url
        }).done(CharacterSelector.DisplayCharacterOptions);
    },

    DisplayCharacterOptions: function(data) {
        CharacterSelector.ClearSelectedCharacter();
        for(var i = 0; i < data.characters.length; i++) {
            var portrait = $('#character-' + data.characters[i].id);
            // Clear and previous recomendations
            portrait.removeClass('recommended-character');
            portrait.removeClass('unrecommended-character');
            switch(data.characters[i].recomended) {
                case 3:
                    portrait.addClass('unrecommended-character');
                    break;
                case 1:
                    portrait.addClass('recommended-character');
                    break;

            }
        }
        $('#character-selection-modal').modal();
    }
    
}

var ProvisionManager = {
    Load: function() {
        $('#location').change(ProvisionManager.RefreshProvisions);
        $('#length').change(ProvisionManager.RefreshProvisions);
    },

    RefreshProvisions: function(e) {
        var url = $('#provision-table').attr('data-refresh-url');
        url += '/' + $('#location').val() + '/' + $('#length').val();
        $.ajax({
            url: url
        }).done(function(data){
            console.log(data);
            for(var i=0; i < data.length; i++) {
                $('#provision-' + data[i].provision_id + '-suggestion').text(data[i].recomendation);
                $('#provision-' + data[i].provision_id + '-taken').val(data[i].recomendation);
            }
        });
    }

}
$(CharacterSelector.Load);
$(ProvisionManager.Load);


</script>
@endsection

@section('content')
<form method="post" action="{{route('saveDungeonRun')}}">
    {{csrf_field()}}
    <fieldset>
        <legend>Save Run Information</legend>
        <div class="form-row">
            <div class="form-group col">
                <label for="location">Location</label><br />
                <select name="location" id="location">
                    @foreach($locations as $location)
                        <option value="{{$location->id}}">{{$location->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col">
                <label for="length">Length</label><br />
                <select name="length" id="length">
                    @foreach($locationLengths as $locationLength)
                        <option value="{{$locationLength->id}}">{{$locationLength->description}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col">
                <label for="difficulty">Difficulty</label><br />
                <select name="difficulty" id="difficulty">
                    @foreach($difficultyLevels as $difficultyLevel)
                        <option value="{{$difficultyLevel->id}}">{{$difficultyLevel->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Hero Composition</legend>
        <div class="form-row">
            <div class="form-group col">
                <label for="character-slot-4">Slot 4</label><br />
                <input type="image" id="character-slot-4" class="character-slot" src="{{asset('imgs/empty_character.png')}}" data-selection-url="{{route('characterSelection', array('slot' => 4, 'location' => 0))}}">
                <input type="hidden" name="character_slot_4" id="selected-character-slot-4" value="0"><br>
                <label for="slot-4-died">Died?</label> 
                <input type="checkbox" id="slot-4-died" name="slot_4_died" value="1">
            </div>
            <div class="form-group col">
                <label for="character-slot-3">Slot 3</label><br />
                <input type="image" id="character-slot-3" class="character-slot" src="{{asset('imgs/empty_character.png')}}" data-selection-url="{{route('characterSelection', array('slot' => 3, 'location' => 0))}}">
                <input type="hidden" name="character_slot_3" id="selected-character-slot-3" value="0"><br>
                <label for="slot-3-died">Died?</label> 
                <input type="checkbox" id="slot-3-died" name="slot_3_died" value="1">
            </div>
            <div class="form-group col">
                <label for="character-slot-2">Slot 2</label><br />
                <input type="image" id="character-slot-2" class="character-slot" src="{{asset('imgs/empty_character.png')}}" data-selection-url="{{route('characterSelection', array('slot' => 2, 'location' => 0))}}">
                <input type="hidden" name="character_slot_2" id="selected-character-slot-2" value="0"><br>
                <label for="slot-2-died">Died?</label> 
                <input type="checkbox" id="slot-2-died" name="slot_2_died" value="1">
            </div>
            <div class="form-group col">
                <label for="character-slot-1">Slot 1</label><br />
                <input type="image" id="character-slot-1" class="character-slot" src="{{asset('imgs/empty_character.png')}}" data-selection-url="{{route('characterSelection', array('slot' => 1, 'location' => 0))}}">
                <input type="hidden" name="character_slot_1" id="selected-character-slot-1" value="0"><br>
                <label for="slot-1-died">Died?</label> 
                <input type="checkbox" id="slot-1-died" name="slot_1_died" value="1">
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Provisions</legend>
        <div class="table-responsive">
        <table id="provision-table" data-refresh-url="{{url('provisionRecomendations')}}" class="table table-sm">
            <thead>
                <tr><th scope="col">Provision</th><th scope="col">Taken</th><th scope="col">Unused</th><th scope="col">Lacking</th><th scope="col">Recomended</th></tr>
            </thead>
            <tbody>
            @foreach($provisions as $provision)
                <tr>
                    <td>{{$provision->name}}</td>
                    <td><input type="text" id="provision-{{$provision->id}}-taken" name="provision[{{$provision->id}}][taken]" class="form-control form-control-" value="{{$provision->recommended}}"></td>
                    <td><input type="text" name="provision[{{$provision->id}}][unused]" class="form-control form-control-"></td>
                    <td><input type="text" name="provision[{{$provision->id}}][lacking]" class="form-control form-control-"></td>
                    <td><span id="provision-{{$provision->id}}-suggestion" class="col-3">{{$provision->recommended}}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </fieldset>
    <div>
        <label for="successful-run">Was the run successful?</label>
        <input type="checkbox" id="successful-run" name="successful_run" value="1">
    </div>
    <input type="submit" value="Save">
</form>

<div class="modal fade" tabindex="-1" role="dialog" id="character-selection-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Character</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <psan aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="character-list">
            @foreach($characters as $character) 
                <img src="{{asset('imgs/' . $character->icon)}}" id="character-{{$character->id}}" data-character-id="{{$character->id}}" title="{{$character->name}}" width="90" height="90" class="selectable-character unselected-character" />
            @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

