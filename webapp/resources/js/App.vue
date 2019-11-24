<template>
  <div>
      <h1>Darkest Dungeon Tracker</h1>
      <DungeonRunner />      
      <footer>Darkest Dungeon Stat Tracker and Planner</footer>
  </div>
</template>

<script>
import DungeonRunner from './RunnerComponents/RunnerMaster.vue';
export default {
  components: { 
      DungeonRunner 
  },
  name: 'app',
  data () {
    return {
    }
  }
}
</script>
