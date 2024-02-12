<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ApplicantInfo from "@/Components/FinanceApplication/ApplicantInfo.vue";
import ApplicantAddress from "@/Components/FinanceApplication/ApplicantAddress.vue";
import ApplicantEmployer from "@/Components/FinanceApplication/ApplicantEmployer.vue";
import { financeDefaultData} from './finance-form';

const form = useForm({
    ...financeDefaultData
});

const submit = () => {
    form.post(route("finance-application.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Apply for Finance">
        <div class="max-w-7xl mx-auto p-4 md:px-8 mt-4">
            <h1 class="text-2xl font-bold text-gray-800">Finance Application</h1>
            <p class="text-gray-500 mt-2">Please scan below barcode.</p>
            <div class="mt-1">
                <img class="w-36 h-36" src="/img/finance-application-qr.png" alt="Finance Application" />
            </div>
            <p class="text-gray-500 mt-8">Or fill out the information below.</p>
            <iframe src="https://virtualdesk.pro/quickApp?vendor=VND-79853" class="w-full mt-2" height="800px"></iframe>
            <form v-if="1==2" @submit.prevent="submit" class="mt-2">
               <ApplicantInfo :form="form"/>
               <div class="mt-8"></div>

               <ApplicantAddress :form="form" />
               <div class="mt-8"></div>

               <ApplicantEmployer :form="form" />
               <div class="mt-8"></div>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                    <InputLabel for="terms">
                        <div class="flex items-center">
                            <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                            <div class="ml-2">
                                I agree to the
                                <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a>
                                and
                                <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                            </div>
                        </div>
                        <InputError class="" :message="form.errors.terms" />
                    </InputLabel>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
