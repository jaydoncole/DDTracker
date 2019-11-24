<template>
    <div>
        <div class="character-slot">
            <label :for="slotId">Slot {{ characterState.name }}</label>
            <input type="image" :id="slotId" :src="imageUrl" @click="fetchCharacterOptions" class="selected-image" width="90" height="90">
            <input type="hidden" name="slot_id" :value="slotNumber">
            <span class="died-checkbox">
                <label :for="diedId">Died?</label>
                <input type="checkbox" :id="diedId" v-model="characterState.died">
            </span>
        </div>

        <div id="modal-mask" v-if="displayModal">
            <div id="modal-wrapper">
                <div id="modal-container">
                    <h5>Select Character</h5>
                    <div id="character-list">
                        <img 
                            v-for="character in characters" 
                            :src="generateCharacterImage(character.icon)" 
                            :data-character-id="character.id" 
                            width="90" height="90" 
                            class="character-image" 
                            :class="getCharacterRecommendationClass(character.id)"
                            @click="selectCharacter">
                    </div>
                    <button class="close" @click="displayModal = false">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        characterState: Object,
        slotNumber: Number,
        location: Number,
        characters: Array,
        selectFunction: Function,
        characterDiedFunction: Function,
    },
    data() {
        return {
            displayModal: false,
            characterRecommendations: [],
        }
    },

    methods: {
        generateCharacterImage(imageName) {
            return "imgs/" + imageName;

        },
        fetchCharacterOptions(e) {
            e.preventDefault();
            this.displayModal = true;
            axios.get('/characterSuggestions/' + this.characterState.name + '/' + this.location)
                .then(response => {
                    this.characterRecommendations = response.data.characters;
            })
        },
        getCharacterRecommendationClass(characterId) {
            for (var recommend of this.characterRecommendations) {
                if(recommend.id == characterId) {
                    if(recommend.recommended == 1) {
                        return 'recommended-character';
                    } else if(recommend.recommended == 3) {
                        return 'not-recommended-character';
                    }
                }    
            }
            return '';
        },
        selectCharacter(event) {
            this.characterState.characterImage = event.target.currentSrc.split('/').slice(-1)[0];        
            this.characterState.selectedCharacter = event.target.dataset.characterId;
            this.displayModal = false;
            this.selectFunction(this.slotNumber, this.characterState.selectedCharacter, this.characterState.characterImage);
        },
    },

    computed: {
        slotId() {
            return "character-slot-" + this.slotNumber;
        },
        diedId() {
            return "slot-" + this.slotNumber + "-died";
        },
        imageUrl() {
            return "imgs/" + this.characterState.characterImage;
        },
    }
}
</script>
