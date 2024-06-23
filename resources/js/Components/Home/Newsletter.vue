<script setup>
    import { ref } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { useForm } from '@inertiajs/vue3';

    const subscribed = ref(false);

    const form = useForm({email: ''});

    const subscribe = () => {
        subscribed.value = true;
        form.post(route('newsletter.store'));
        form.reset("email");
    }

</script>
<template>
    <div class="flex justify-center bg-slate-100">
        <div class="w-full md:w-2/5 p-8">
            <h2 class="text-xl font-semibold">Newsletter</h2>
            <h2 class="my-2">Receive updates on our latest inventory.</h2>
            <form @submit.prevent="subscribe">
                <div class="flex mb-4">
                    <input type="email" v-model="form.email" required placeholder="Your email address" class="px-4 py-2 w-full bg-white border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" />
                    <PrimaryButton type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                        Subscribe
                    </PrimaryButton>
                </div>
            </form>
            <p v-if="subscribed" class="text-green-600 font-medium">Thank you for subscribing!</p>
        </div>
    </div>
</template>