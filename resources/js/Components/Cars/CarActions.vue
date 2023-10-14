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
        form.patch(`/cars/${props.car.id}/featured`);
    };

</script>

<template>
    <Dropdown :open="true">
        <template #trigger>
            <button class="bg-gray-100 rounded p-2 hover:shadow hover:bg-gray-200">Actions &#9660;</button>
        </template>
        <template #content>
            <div class="flex flex-col text-left gap-2">
                <Link class="flex p-2 hover:bg-gray-100" :href="`/inventory/${car.id}/edit`">Edit</Link>
                <button class="flex p-2 hover:bg-gray-100 text-left" @click="setAsFeautered">Set as Featured</button>
            </div>
        </template>
    </Dropdown>
</template>