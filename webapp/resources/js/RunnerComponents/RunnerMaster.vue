<template>
    <form method="post" action="/saveDungeonRun">
        <fieldset>
            <legend>Run Settings</legend>
            <div class="settings">
                <div class="location-setting">
                    <label for="location">Location</label>
                    <select name="location" id="location" v-model="selectedLocation" @change="getProvisionSuggestions">
                        <option v-for="location in locations" :value="location.id">{{location.name}}</option>
                    </select>
                    <label for="length">Length</label>
                    <select id="length" name="length" v-model="selectedLength" @change="getProvisionSuggestions">
                        <option v-for="locationLength in locationLengths" :value="locationLength.id">{{ locationLength.description }}</option>
                    </select>
                    <label for="difficulty">Difficulty</label>
                    <select id="difficulty" name="difficulty" v-model="selectedDifficulty">
                        <option v-for="difficulty in difficulties" :value="difficulty.id">{{ difficulty.description}}</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Hero Composition</legend>
            <div class="characters">
                <CharacterSlot 
                    v-for="(slot, index) in characterSlots" 
                    :slotNumber="index" 
                    :characterState="slot"
                    :location="selectedLocation" 
                    :characters="characters" 
                    :key="index"  
                    :selectFunction="selectCharacter"
                    :characterDiedFunction = "characterDied"
                />
            </div>
        </fieldset>
        <fieldset>
            <legend>Provisions</legend>
            <table id="provision-table">
                <tr>
                    <th>Provision</th>
                    <th>Recommended</th>
                    <th>Used</th>
                </tr>
                <Provision 
                    v-for="provision in provisions" 
                    :provisionState="provision"
                    :updateAmountUsed="updateProvisionsUsed" 
                    :key="provision.name" 
                />
            </table>
        </fieldset>
        <label for="successful">Was the run successful?</label>
        <input type="checkbox" id="successful" v-model="runSuccessful">
        <div class="controls">
            <button @click.prevent="saveRun">Save Run</button>
        </div>
    </form>
</template>
<script>
import CharacterSlot from "./CharacterSlot";
import Provision from "./Provision";
import axios from 'axios'
export default {
    components: {
        CharacterSlot,
        Provision
    },
    data() {
        return {
            locations: [],
            locationLengths: [],
            difficulties: [],
            characters: [],
            provisions: [],
            selectedLocation: 1,
            selectedLength: 1,
            selectedDifficulty: 1,
            runSuccessful: false,
            characterSlots: [
                {
                    name: 4,
                    selectedCharacter: 0,
                    characterImage: 'empty_character.png',
                    died: false
                }, 
                {
                    name: 3,
                    selectedCharacter: 0,
                    characterImage: 'empty_character.png',
                    died: false
                }, 
                {
                    name: 2,
                    selectedCharacter: 0,
                    characterImage: 'empty_character.png',
                    died: false
                },
                {
                    name: 1,
                    selectedCharacter: 0,
                    characterImage: 'empty_character.png',
                    died: false
                }
            ],
        };
    },
    methods: {
        selectCharacter(slotNumber, characterId, characterImage) {
            this.characterSlots[slotNumber].selectedCharacter = characterId;
            this.characterSlots[slotNumber].characterImage = characterImage;
        },
        updateProvisionsUsed(provisionId, amountUsed) {
            for(var provision of this.provisions) {
                if(provision.id == provisionId) {
                    provision.amountUsed = amountUsed;
                    break;
                }
            }
        },

        characterDied(slotNumber, died) {
            this.characterSlots[slotNumber].died = died;
        },

        getProvisionSuggestions() {
            axios.get('/provisionSuggestions/' + this.selectedLocation + '/' + this.selectedLength)
                .then(response => {
                    for(var provision of this.provisions) {
                        for(var recommend of response.data) {
                            if(provision.id == recommend.provision_id) {
                                provision.recommended = recommend.recommendation;
                                break;
                            }
                        }
                    }
                    this.provisions.recommended = response.data;
            });
        },

        saveRun() {
            var post = {
                location_id: this.selectedLocation,
                location_length: this.selectedLength,
                difficulty_level: this.selectedDifficulty,
                run_completed: this.runSuccessful,
                provision: {}
            }
            for(var slot of this.characterSlots) {
                post['character_slot_' + slot.name] = slot.selectedCharacter;
                post['slot_' + slot.name + '_died'] = slot.died;
            }
            for (var i=0; i < this.provisions.length; i++) {
                post.provision[i] = {
                    id: this.provisions[i].id,
                    used: this.provisions[i].amountUsed
                }
            }
            const resetForm = this.resetForm;
            axios.post('/saveRun', post)
                .then(function(response) {
                    resetForm();
            });
        },

        resetForm() {
            for (var slot of this.characterSlots) {
                slot.characterImage = "empty_character.png";
                slot.died = false;
                slot.selectedCharacter = 0;
            }

            for (var provision of this.provisions) {
                provision.amountUsed = 0;
                this.getProvisionSuggestions();
            }
        }
    },
    created() {
        axios.get('/locations')
            .then(response => {
                this.locations = response.data;
            })
            .catch(function(error){
                console.log(error);
            });
        axios.get('/locationLengths')
            .then(response => {
                this.locationLengths = response.data;
            });
        axios.get('/difficultyLevels')
            .then(response => {
                this.difficulties = response.data;
            });
        axios.get('/characters')
            .then(response => {
                this.characters = response.data;
            });
        axios.get('/provisions')
            .then(response => {
                for(var provision of response.data) {
                    provision.amountUsed = 0;
                    provision.recommended = 0;
                    this.provisions.push(provision);
                }
                this.getProvisionSuggestions();
            });
    }
}
</script>
