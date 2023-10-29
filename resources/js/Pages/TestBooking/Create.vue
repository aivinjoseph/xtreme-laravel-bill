<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    date: '',
    message: '',
});

const submit = () => {
    form.post(route('test-booking.store'), {});
};
</script>

<template>
    <AppLayout title="Book a test">
        <div class="mx-auto w-full lg:max-w-4xl p-4 lg:p-8">  
            <h1 class="text-2xl font-bold mb-8">Book a test</h1>
            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
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
    
                <div>
                    <InputLabel for="phone_number" value="Phone_number" />
                    <TextInput
                        id="phone_number"
                        v-model="form.phone_number"
                        type="number"
                        class="mt-1 block w-full"
                        required
                        autocomplete="phone_number"
                    />
                    <InputError class="mt-2" :message="form.errors.phone_number" />
                </div>
    
                <div>
                    <InputLabel for="date" value="Date" />
                    <TextInput
                        id="date"
                        v-model="form.date"
                        type="datetime-local"
                        class="mt-1 block w-full"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.date" />
                </div>
    
                <div class="lg:col-span-2">
                    <InputLabel for="message" value="Message" />
                    <TextArea
                        id="message"
                        v-model="form.message"
                        class="mt-1 block w-full"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>
    
                <div class="lg:col-start-2 flex items-center justify-end mt-2">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Book Test
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>