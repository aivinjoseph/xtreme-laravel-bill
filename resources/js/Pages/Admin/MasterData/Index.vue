<script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';

    const props = defineProps({
        tables: {
            type: Array,
            required: true
        }
    })

    const selectedTable = ref(props.tables[0]);
    const showModal = ref(false);
    const form = useForm({ name: '', manufacturer_id: ''});
    const makes = ref(props.tables.find(table => table.name == 'Manufacturer').data);

    const changeTable = (table) => {
        selectedTable.value = table
    }

    const closeModal = () => {
        showModal.value = false;
    }

    const submit = () => {
        form.post(route('master-data.store', { name: selectedTable.value.name, table: selectedTable.value.name }), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                form.reset();
            }
        });
    }
</script>

<template>
    <AppLayout title="Master Data">
        <Modal :show="showModal"  @close="closeModal">
            <div class="p-4">
                <div class="flex justify-between">
                    <h2>Add new {{ selectedTable.label }}</h2>
                    <button @click="closeModal" class="font-bold  text-red-800">X</button>
                </div>
                <div class="py-4">
                    <div v-if="selectedTable.name == 'CarModel'" class="mb-2">
                        <InputLabel for="make" value="Make" />
                        <select v-model="form.manufacturer_id" class="rounded border-gray-300 w-full mt-1">
                            <option value="">Select Make</option>
                            <option v-for="make in makes" :key="make.id" :value="make.id">{{ make.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.make" />
                    </div>
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                </div>
                <div>
                    <PrimaryButton @click="submit">Save</PrimaryButton>
                </div>
            </div>
        </Modal>
        <div class="py-12 max-w-7xl mx-auto ">
            <div class="flex px-4 lg:px-8">
                <div class="w-1/4 flex flex-col gap-2 text-left">
                    <button class="w-full py-2 rounded hover:bg-gray-100" :class="{'bg-gray-100 font-bold': table.name == selectedTable.name}" v-for="table in tables" :key="table.name" @click="changeTable(table)">{{ table.label }}</button>
                </div>
                <div class="px-4 w-full">
                    <div class="flex justify-between">
                        <h3 class="text-xl font-semibold">{{ selectedTable.label }}</h3>
                        <PrimaryButton @click="showModal = true">Add New</PrimaryButton>
                    </div>
                    <div class="flex gap-4 flex-wrap mt-4">
                        <div v-for="data in selectedTable.data" :key="data.id" class="border border-gray-100 rounded p-4">
                            <div class="font-bold text-gray-800 text-center">{{ data.name }}</div>
                            <div class="mt-4 flex gap-8">
                                <button class="text-sm text-green-700 font-semibold">
                                    Edit
                                </button>
                                <button class="text-sm text-red-700 font-semibold">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>