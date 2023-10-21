<script setup>
    import InputError from "@/Components/InputError.vue";
    import InputLabel from "@/Components/InputLabel.vue";
    import TextInput from "@/Components/TextInput.vue";

    const props = defineProps({
        form: Object,
    });

</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 bg-gray-100 p-8 rounded shadow-sm">
        <div class="text-xl font-bold text-gray-800 lg:col-span-3">
            ApplicantInfo
        </div>
        <div>
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" type="text" class="block w-full" autofocus autocomplete="name" />
            <InputError class="" :message="form.errors.name" />
        </div>

        <div>
            <InputLabel for="email" value="Email" />
            <TextInput id="email" v-model="form.email" type="email" class="block w-full" autocomplete="username" />
            <InputError class="" :message="form.errors.email" />
        </div>

        <div>
            <InputLabel for="phone" value="Phone" />
            <TextInput id="phone" v-model="form.phone" type="text" class="block w-full" autocomplete="new-phone" />
            <InputError class="" :message="form.errors.phone" />
        </div>

        <div>
            <InputLabel for="sin" value="SIN" />
            <TextInput id="sin" v-model="form.sin" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.sin" />
        </div>

        <div>
            <InputLabel for="dob" value="Date of Birth" />
            <TextInput id="dob" v-model="form.dob" type="date" class="block w-full" />
            <InputError class="" :message="form.errors.dob" />
        </div>

        <div>
            <InputLabel for="marital_status" value="Marital Status" />
            <select id="marital_status" v-model="form.marital_status" class="block w-full">
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="common law">Common Law</option>
                <option value="divorced">Divorced</option>
            </select>
            <InputError class="" :message="form.errors.marital_status" />
        </div>

        <div>
            <InputLabel for="license_number" value="Driver License Number" />
            <TextInput id="license_number" v-model="form.license_number" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.license_number" />
        </div>
        
        <div>
            <InputLabel for="license_expiry" value="Driver License Exipiry Date" />
            <TextInput id="license_expiry" v-model="form.license_expiry" type="date" class="block w-full" />
            <InputError class="" :message="form.errors.license_expiry" />
        </div>

    </div>
</template>
