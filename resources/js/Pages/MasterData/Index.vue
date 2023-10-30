<script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
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
    const form = useForm({ name: '', manufacturer_id: '', table: selectedTable.value.name});
    const makes = ref(props.tables.find(table => table.name == 'Manufacturer').data);
    const selectedItem = ref(null);

    const changeTable = (table) => {
        selectedTable.value = table;
        form.table = table.name;
    }

    const closeModal = () => {
        showModal.value = false;
        selectedItem.value = null;
        form.reset();
    }

    const edit = (item) => {
        showModal.value = true;
        form.name = item.name;
        form.manufacturer_id = item.manufacturer_id;
        selectedItem.value = item;
    }

    const submit = () => {
        if (selectedItem.value) {
            form.put(route('master-data.update', selectedItem.value.id), {
                preserveScroll: true,
                onSuccess: () => location.reload(),
            });
            return;
        }

        form.post(route('master-data.store'), {
            preserveScroll: true,
            onSuccess: () => location.reload(),
        });
    }

    const deleteItem = (item) => {
        if (confirm('Are you sure you want to delete this item?')) {
            form.delete(route('master-data.destroy', item.id, {table: selectedTable.name}), {
                preserveScroll: true,
                onSuccess: () => location.reload(),
            });
        }
    }

</script>

<template>
    <AdminLayout title="Master Data">
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
                <div class="flex justify-end">
                    <PrimaryButton @click="submit" :disabled="form.processing">Save</PrimaryButton>
                </div>
            </div>
        </Modal>
        <div class="py-12 max-w-7xl mx-auto ">
            <div class="flex px-4 lg:px-8">
                <div class="w-2/4 md:w-1/4 shadow rounded flex flex-col">
                    <div class="bg-gray-800 p-4 border-b text-gray-100 rounded-t border-gray-100">
                        <h3 class="text-xl font-semibold">Master Data</h3>
                    </div>
                    <button class="w-full py-2 px-4 rounded hover:bg-gray-100 border-b border-gray-100 text-left" :class="{'bg-gray-100 font-bold': table.name == selectedTable.name}" v-for="table in tables" :key="table.name" @click="changeTable(table)">{{ table.label }}</button>
                </div>
                <div class="px-4 w-full">
                    <div class="flex justify-between">
                        <h3 class="text-xl font-semibold">{{ selectedTable.label }}</h3>
                        <PrimaryButton @click="showModal = true">Add New</PrimaryButton>
                    </div>
                    <div class="flex gap-4 flex-wrap mt-4">
                        <div v-for="data in selectedTable.data" :key="data.id" class="border border-gray-100 bg-gray-50 shadow-sm rounded p-4">
                            <div class="font-bold text-gray-800 text-center">{{ data.name }}</div>
                            <div class="mt-4 flex gap-8">
                                <button @click="edit(data)" class="text-sm text-green-700 font-semibold">
                                    Edit
                                </button>
                                <button @click="deleteItem(data)" class="text-sm text-red-700 font-semibold">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>