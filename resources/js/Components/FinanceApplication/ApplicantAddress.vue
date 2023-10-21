<script setup>
    import InputError from "@/Components/InputError.vue";
    import InputLabel from "@/Components/InputLabel.vue";
    import TextInput from "@/Components/TextInput.vue";

    const props = defineProps({
        form: Object,
    });

</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4  bg-gray-100 p-8 rounded shadow-sm">
        <div class="text-xl font-bold text-gray-800 lg:col-span-3">
            Applicant Address
        </div>

        <div>
            <InputLabel for="address" value="Address" />
            <TextInput id="address" v-model="form.address" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.address" />
        </div>

        <div>
            <InputLabel for="city" value="city" />
            <TextInput id="city" v-model="form.city" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.city" />
        </div>

        <div>
            <InputLabel for="province" value="province" />
            <TextInput id="province" v-model="form.province" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.province" />
        </div>

        <div>
            <InputLabel for="postal_code" value="postal_code" />
            <TextInput id="postal_code" v-model="form.postal_code" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.postal_code" />
        </div>

        <div>
            <InputLabel for="residence_type" value="Residence Status" />
            <select id="residence_type" v-model="form.residence_type" class="block w-full">
                <option value="rent">Rent</option>
                <option value="own">own</option>
                <option value="own free clear">own free clear</option>
                <option value="with family">with family</option>
            </select>
            <InputError class="" :message="form.errors.residence_type" />
        </div>

        <div>
            <InputLabel for="rent_mortgage_amount" value="Mortgage/Rent (Monthly)" />
            <TextInput id="rent_mortgage_amount" v-model="form.rent_mortgage_amount" type="number" class="block w-full" />
            <InputError class="" :message="form.errors.rent_mortgage_amount" />
        </div>

    </div>
</template>
