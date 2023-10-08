<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Navbar from '@/Components/Layout/Navbar.vue';
import Footer from '@/Components/Layout/Footer.vue';
defineProps({
    title: String,
});


const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <Navbar />

            <!-- Page Content -->
            <main class="relative w-full overflow-hidden transition-all duration-300 z-10">
                <slot />
            </main>

            <Footer />
        </div>
    </div>
</template>
