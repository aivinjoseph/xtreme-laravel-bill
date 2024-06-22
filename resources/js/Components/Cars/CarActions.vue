<script setup>
    import { Link } from '@inertiajs/vue3';
    import Dropdown from '@/Components/Dropdown.vue';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        car: {
            type: Object,
            required: true,
        },
    });

    const setAsFeautered = () => {
        const form = useForm({});
        form.patch(route('cars.featured', props.car.id));
    };

    const archive = () => {
        if(! confirm("Are you sure you want to archive this car?")) return;
        const form = useForm({});
        form.delete(route('cars.destroy', props.car.id));
    };

</script>

<template>
    <Dropdown :open="true">
        <template #trigger>
            <button class="bg-gray-100 rounded p-2 hover:shadow hover:bg-gray-200">Actions &#9660;</button>
        </template>
        <template #content>
            <div class="flex flex-col text-left gap-2">
                <Link class="flex p-2 hover:bg-gray-100" :href="route('cars.edit', car.id)">Edit</Link>
                <button v-if="!car.featured" class="flex p-2 hover:bg-gray-100 text-left" @click="setAsFeautered">Set as Featured</button>
                <button v-if="car.featured" class="flex p-2 hover:bg-gray-100 text-left" @click="setAsFeautered">Remove from Featured</button>
                <button class="flex p-2 hover:bg-gray-100 text-left" @click="archive">Archive</button>
            </div>
        </template>
    </Dropdown>
</template>