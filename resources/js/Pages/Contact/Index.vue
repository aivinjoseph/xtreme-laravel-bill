<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submit = () => {
    form.post(route('contacts.store'), {
        onFinish: () => form.reset(...Object.keys(form)),
    });
};
</script>

<template>
    <AppLayout title="Contact Us">
        <div class="max-w-7xl mx-auto p-8 flex flex-col lg:flex-row justify-center gap-8">
            <div class="w-full lg:w-2/4">
                <h1 class="text-3xl font-bold">We Value Your Feedback and Comments</h1>
                <p class="text-gray-500 text-sm mt-1">Please feel free to share your suggestions, comments, and queries regarding our services or your experience with us. Make sure you are a genuine customer. We encourage you to submit the feedback in the form below.</p>
                <form @submit.prevent="submit" class="space-y-2 mt-4">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
            
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
            
                    <div class="lg:col-span-2">
                        <InputLabel for="subject" value="Subject" />
                        <TextInput
                            id="subject"
                            v-model="form.subject"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autocomplete="subject"
                        />
                        <InputError class="mt-2" :message="form.errors.subject" />
                    </div>
            
                    <div class="lg:col-span-2">
                        <InputLabel for="message" value="Message" />
                        <TextArea
                            id="message"
                            v-model="form.message"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.message" />
                    </div>
            
                    <div class="flex justify-end mt-2">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Send Message
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <div class="w-full lg:w-1/4 rounded px-4">
                <div class="text-xl font-bold">
                    XTREME MOTORS INC.
                </div>
                <div class="mt-2">
                    <span class="text-gray-600">Mississauga Rd, Mississauga, ON-L5N 1A7</span> 
                </div>
                <div class="mt-2">
                    Call Us: <a class="text-gray-500" href="tel:+1647-521-7186">647-521-7186</a>
                </div>
                <div class="mt-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5779.165658066755!2d-79.729798!3d43.59440500000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b41d2960ca5ad%3A0xa1fd012669732f04!2s6295%20Mississauga%20Rd%2C%20Mississauga%2C%20ON%20L5N%201A7%2C%20Canada!5e0!3m2!1sen!2sin!4v1698284453410!5m2!1sen!2sin" style="border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
