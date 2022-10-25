<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import GameForm from '@/Pages/Game/Partials/GameForm.vue';
import GameResult from '@/Pages/Game/Partials/GameResult.vue';
import LeaderBoard from '@/Pages/Game/Partials/LeaderBoard.vue';

</script>

<template>
    <AppLayout title="Game">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Acto Card Game
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <GameForm/>
            </div>
        </div>

        <GameResult v-if="$page.props.gameResult"/>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-2xl text-center">
                            Leader Board
                        </div>
                        <div class="mt-5">
                            <LeaderBoard />
                        </div>
                        <div class="mt-6 text-gray-500">
                            Feel free to change this page and add as many components as you'd like.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
