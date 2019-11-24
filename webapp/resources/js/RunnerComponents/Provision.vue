<template>
    <tr>
        <td>{{ provisionState.name }}</td>
        <td>{{ provisionState.recommended }}</td>
        <td><img src="imgs/plus.png" @click="provisionState.amountUsed++" width="50" height="50" /></td>
        <td><input type="text" v-model="provisionState.amountUsed" class="provision-used"></td>
        <td><img src="imgs/minus.png" 
            @click="provisionState.amountUsed = provisionState.amountUsed == 0 ? 0 : provisionState.amountUsed - 1" 
            width="50" height="50" /></td>
    </tr>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        provisionId: Number,
        updateAmountUsed: Function,
        provisionState: Object
    },
}
</script>
