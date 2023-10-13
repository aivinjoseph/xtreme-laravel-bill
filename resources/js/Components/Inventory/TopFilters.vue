<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    defineProps({
        form: Object,
        makes: Array,
        models: Array,
    });

    const emit = defineEmits(['submit']);
    const submit = () => emit('submit');
</script>

<template>
    <div class="w-full grid grid-cols-3 gap-4 py-4 bg-gray-100 p-4 rounded">
        <div>
            <InputLabel for="make" value="Make" />
            <select v-model="form.make" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Make</option>
                <option v-for="make in makes" :key="make.id" :value="make.name">{{ make.name }}</option>
            </select>
        </div>
        <div>
            <InputLabel for="model" value="Model" />
            <select v-model="form.model" class="rounded border-gray-300 w-full mt-1">
                <option value="">Select Model</option>
                <option v-for="model in models" :key="model.id" :value="model.name">{{ model.name }}</option>
            </select>
        </div>
        <div class="flex items-end">
            <primary-button class="h-10 text-center" :processing="form.processing" @click="submit">
                Search
            </primary-button>
        </div>
    </div>
</template>