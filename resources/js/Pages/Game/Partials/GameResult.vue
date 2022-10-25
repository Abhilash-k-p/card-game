<script setup>

const WON = 'WON';
const LOST = 'LOST';
const TIE = 'TIE';

</script>

<template>
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div v-if="$page.props.gameResult['playScore']['result'] === WON" class="text-2xl text-center text-green-500">
                        You won this game :)
                    </div>
                    <div v-if="$page.props.gameResult['playScore']['result'] === LOST" class="text-2xl text-center text-red-500">
                        You lost this game :(
                    </div>
                    <div v-if="$page.props.gameResult['playScore']['result'] === TIE" class="text-2xl text-center text-gray-500">
                        Game ended in a tie!!
                    </div>
                    <div class="mt-6 text-gray-500">
                        User Won : {{ $page.props.gameResult['playScore']['user_score'] }} Times <br/>
                        CPU Won : {{ $page.props.gameResult['playScore']['cpu_score'] }} Times <br/>
                        Tie's : {{ $page.props.gameResult['userCardSequence'].length - ($page.props.gameResult['playScore']['cpu_score'] + $page.props.gameResult['playScore']['user_score']) }}
                    </div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="border-b">
                                        <tr>
                                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                #
                                            </th>
                                            <th v-for="(item, index) in $page.props.gameResult['userCardSequence']" scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Card#{{ index + 1}}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="border-b">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">USER</td>
                                            <td v-for="(item) in $page.props.gameResult['userCardSequence']" class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{ item }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">CPU</td>
                                            <td v-for="(item) in $page.props.gameResult['gameCardSequence']" class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{ item }}
                                            </td>

                                        </tr>
                                        <tr class="bg-white border-b">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">WINNER</td>
                                            <td v-for="(item) in $page.props.gameResult['playScore']['resultHand']" class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{ item === WON ? 'USER' : (item === LOST ? 'CPU' : 'TIE')}}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
