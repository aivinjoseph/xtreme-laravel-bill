
<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="container flex justify-center mx-auto mt-8">
            <ul class="flex last:border-r last:border-gray-200">
                <template v-for="(link, key) in links">
                    <li v-if="link.url === null" :key="key">
                        <button class="h-10 px-5 text-gray-300 bg-white border border-r-0 border-gray-200 hover:bg-gray-100">
                            <span v-html="link.label"></span>
                        </button>
                    </li>
                    <li v-else :key="link" :class="{ 'bg-black': link.active }" :href="link.url">
                        <Link class="flex items-center h-10 px-5 text-gray-600 bg-white border border-r-0 border-gray-200" :href="link.url" :class="{ 'font-bold': link.active, 'bg-blue-100': link.active }">
                        <span v-html="link.label"></span>
                        </Link>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>
