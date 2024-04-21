<script setup>
    import { info } from '@/info';
    const props = defineProps({
        data: Array,
        car: Object
    })
</script>

<template>
    <div class="p-8">
        <div class="text-4xl font-black">
            {{ info.name }}
        </div>
        <div class="mt-16">
            <div class="text-2xl font-bold">{{ car.name }}</div>
        </div>
        <div class="mt-4 bg-gray-100 rounded-lg">
            <div class="grid grid-cols-2 gap-4">
                <div v-for="item in data" :key="item.name">
                    <div class="font-bold text-gray-700">{{ item.name }}</div>
                    <div class="text-gray-500">{{ item.value }}</div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            Contact Number: {{ info.phone }}
        </div>
        <div>
            Email: {{ info.email }}
        </div>
    </div>
</template>