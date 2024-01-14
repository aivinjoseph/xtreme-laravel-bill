<script setup>
    defineProps({
        availability: {
            type: String,
            required: true
        }
    })
</script>
<template>
    <div class="absolute capitalize font-semibold text-gray-100 rounded px-4 py-2 opacity-80" :class="{'bg-green-500': availability == 'available', 'bg-orange-500': availability == 'upcoming', 'bg-red-500': availability == 'sold'}">
        {{ availability }}
    </div>
</template>