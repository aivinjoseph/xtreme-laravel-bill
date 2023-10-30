<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SideMenu from '@/Components/Layout/SideMenu.vue';

defineProps({
    title: String
})

</script>

<template>
    <AppLayout :title="title">
        <div>
            <div class="w-full">
                <SideMenu />
            </div>

            <main>
                <slot />
            </main>
        </div>
    </AppLayout>
</template>
