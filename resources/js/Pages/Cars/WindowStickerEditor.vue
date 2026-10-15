<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    car: { type: Object, required: true },
    dealer: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['back', 'preview', 'update:address']);
</script>

<template>
    <section class="window-sticker-editor mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 print:hidden">
        <div class="flex flex-col gap-4 border-b pb-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-red-800">Window Sticker</p>
                <h1 class="mt-1 text-2xl font-bold text-gray-900">Window Sticker Editor</h1>
                <p class="mt-1 text-sm text-gray-500">{{ car.year }} {{ car.make }} {{ car.model }}</p>
            </div>
            <SecondaryButton type="button" @click="emit('back')">Back to vehicle</SecondaryButton>
        </div>

        <div class="mt-6 max-w-3xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <InputLabel for="window-sticker-dealer-address" value="Dealer Address" />
            <textarea
                id="window-sticker-dealer-address"
                :value="dealer.address || ''"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                @input="emit('update:address', $event.target.value)"
            ></textarea>
            <p class="mt-2 text-sm text-gray-500">This temporary address applies only to the current Window Sticker.</p>
        </div>

        <div class="mt-6 flex justify-end">
            <PrimaryButton type="button" @click="emit('preview')">Preview Window Sticker</PrimaryButton>
        </div>
    </section>
</template>
