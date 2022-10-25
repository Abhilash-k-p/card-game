<script setup>

import { ref, onMounted } from 'vue'
import {usePage} from "@inertiajs/inertia-vue3";
import {computed, watch} from 'vue';

const leaderBoardData = ref([])
const newGameAdded = computed(() => usePage().props.value.gameResult || '');

const leaderBoardApi = async (cursor) => {
    await axios.get('leaderboard' + (cursor ? '?page='+cursor : '')).then((response) => {
        leaderBoardData.value = response.data
    });
}

onMounted( () => {
    leaderBoardApi();
})

watch(newGameAdded, () => {
    leaderBoardApi();
});

</script>

<template>
    <div>
        <p v-for="(item, index) in leaderBoardData['data']">
            <span @click="leaderBoardApi('2')">{{ item.name }}</span>
        </p>
    </div>
</template>
