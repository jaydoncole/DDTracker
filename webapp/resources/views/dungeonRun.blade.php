@extends('maintemplate')

@section('content')
<form method="post" action="{{route('saveDungeonRun')}}">
    <fieldset>
        <legend>Save Run Information</legend>
        <div class="form-row">
            <label for="location">Location</label>
            <select name="location" id="location">
                <option value="Weald">Weald</option>
                <option value="Warrens">Warrens</option>
                <option value="Ruins">Ruins</option>
                <option value="Cove">Cove</option>
                <option value="Courtyard">Courtyard</option>
                <option value="Farmstead">Farmstead</option>
                <option value="The Darkest Dungeon">The Darkest Dungeon</option>
            </select>
            <label for="hero-slot-4">Hero</label>
            <select title="Hero Slot 4" class="selectpicker">
                <option>
        </div>
    </fieldset>
</form>

@endsection
