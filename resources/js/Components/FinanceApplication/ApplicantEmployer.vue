<script setup>
    import Checkbox from "@/Components/Checkbox.vue";
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
            Applicant Employer
        </div>

        <div>
            <InputLabel for="employer_name" value="Employer" />
            <TextInput id="employer_name" v-model="form.employer" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.employer" />
        </div>

        <div>
            <InputLabel for="job_title" value="Job Title" />
            <TextInput id="job_title" v-model="form.job_title" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.job_title" />
        </div>

        <div>
            <InputLabel for="employer_phone" value="Employer Phone" />
            <TextInput id="employer_phone" v-model="form.employer_phone" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.employer_phone" />
        </div>

        <div>
            <InputLabel for="income_amount" value="Income (Monthly)" />
            <TextInput id="income_amount" v-model="form.income_amount" type="number" class="block w-full" />
            <InputError class="" :message="form.errors.income_amount" />
        </div>

        <div>
            <InputLabel for="income_frequency" value="Income Frequency" />
            <select id="income_frequency" v-model="form.income_frequency" class="block w-full">
                <option value="weekly">weekly</option>
                <option value="monthly">monthly</option>
                <option value="yearly">yearly</option>
            </select>
            <InputError class="" :message="form.errors.income_frequency" />
        </div>

        <div>
            <InputLabel for="job_length" value="Employment Length (Years)" />
            <TextInput id="job_length" v-model="form.job_length" type="number" class="block w-full" />
            <InputError class="" :message="form.errors.job_length" />
        </div>

        <div>
            <InputLabel for="employer_address" value="Employment Address" />
            <TextInput id="employer_address" v-model="form.employer_address" type="text" class="block w-full" />
            <InputError class="" :message="form.errors.employer_address" />
        </div>
    </div>
</template>
