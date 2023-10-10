<script setup>
    defineProps({
        car: {
            type: Object,
            required: true,
        },
    });
</script>

<template>
    <div>
        <div class="h-48">
            <img class="object-contain object-center w-full rounded" :src="car.images[0]" alt="Vehicle image" />
        </div>
        <div class="mt-4 flex items-center gap-4 px-4">
            <div class="leading-tight">
                <h3 class="font-sans font-semibold text-lg text-muted-800 dark:text-muted-50">
                    {{ car.name }}
                </h3>
            </div>
            <div class="ml-auto">
                <span class="font-sans font-semibold text-lg text-muted-800 dark:text-muted-50">
                    ${{ car.price }}
                </span>
            </div>
        </div>
        <div class="w-full flex mt-6 mb-4 divide-x divide-muted-200 dark:divide-muted-800">
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <span class="block font-sans font-semibold text-muted-800 dark:text-muted-50">
                        {{ car.engine }}
                    </span>
                    <small class="block font-sans text-muted-500 dark:text-muted-400">
                       Engine
                    </small>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <span class="block font-sans font-semibold text-muted-800 dark:text-muted-50">
                        {{ car.body_type }}
                    </span>
                    <small class="block font-sans text-muted-500 dark:text-muted-400">
                        Body Type
                    </small>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <span class="block font-sans font-semibold text-muted-800 dark:text-muted-50">
                        {{ car.mileage }}
                        <small class="font-normal text-muted-500 dark:text-muted-400">
                            mi
                        </small>
                    </span>
                    <small class="block font-sans text-muted-500 dark:text-muted-400">
                        Mileage
                    </small>
                </div>
            </div>
        </div>
        <a href="/vehicle.html" class="relative font-sans font-normal inline-flex items-center justify-center leading-5 no-underline w-full space-x-1 bg-gray-100 hover:bg-gray-800 text-gray-500 hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-100 h-10 px-5 py-3 text-sm tw-accessibility transition-all duration-300">
            View Details
        </a>
    </div>
</template>
