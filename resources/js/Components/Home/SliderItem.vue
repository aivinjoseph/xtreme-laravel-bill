<script setup>
    defineProps({
        index: {
            type: Number,
            required: true
        },
        image: {
            type: String,
            required: true
        }
    })
</script>

<template>
    <div class="bg-blue-400 bg-cover bg-center w-full bg-muted-100 h-[40vh] lg:h-screen dark:bg-muted-1000 brightness-50" :class="index === 1
            ? 'lg:animate-kenburns bg-center lg:bg-left-top'
            : ''"
        :style="`background-image: url(${image});`">
     </div>
</template>

<style>
 .animate-kenburns {
    animation:kenburns 12s linear infinite reverse
}
</style>
