<script setup>

import { useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';


const form = useForm({
    _method: 'POST',
    gameInput: '',
    distinct: false,
    cards: []
});

const playGame = () => {
    form.cards = form.gameInput.trim().length > 0 ? form.gameInput.trim().split(' ') : [];
    form.post(route('play.start'), {
        errorBag: 'playGame',
        preserveScroll: true,
    });
};

const getRandomCards = () => {
    axios.get('/card/randomCards' + (form.distinct ? '?distinct=true' : '')).then(response => {
        form.gameInput = response?.data['cards']?.join(' ');
    }).catch(err => console.log(err));
}


</script>

<template>
    <JetFormSection @submitted="playGame">
        <template #title>
            Let's Play
        </template>

        <template #description>
            Use
            <span class="bg-white px-4 border rounded-md border-gray-300 shadow-sm">Generate Random Cards</span>
            button to generate valid random cards or type valid card numbers in the input area space seperated. <br/><br/>
            Valid cards:<br/><span class="bg-white px-4 border rounded-md border-gray-300 shadow-sm">
            2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A
            </span>
        </template>

        <template #form>

            <!-- Game Input -->
            <div class="col-span-12 sm:col-span-6">
                <JetLabel for="gameInput" value="Input your card Number's" />
                <JetInput
                    id="gameInput"
                    v-model="form.gameInput"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="off"
                />
                <JetInputError :message="form.errors.cards" class="mt-2" />
            </div>

            <div class="col-span-6">
                <JetCheckbox id="terms" v-model:checked="form.distinct" name="distinct" />
                <label for="distinct" class="ml-2 text-sm">
                    Play with unique cards only
                </label>
            </div>
        </template>

        <template #leftActions>

        </template>

        <template #actions>

            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Result Saved.
            </JetActionMessage>


            <button type="button" @click="getRandomCards" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                Generate Random Cards
            </button>

            <JetButton class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Play!
            </JetButton>
        </template>
    </JetFormSection>
</template>
