<script setup>
    import { Link } from '@inertiajs/vue3';
    import CarActions from '@/Components/Cars/CarActions.vue';
    import AvailabilityBadge from '@/Components/Cars/AvailabilityBadge.vue';

    defineProps({
        car: {
            type: Object,
            required: true,
        },
    });
</script>

<template>
    <div class="flex flex-col rounded shadow-sm border border-gray-100">
        <div class="relative">
            <div v-if="$page.props.auth.user" class="absolute right-2 top-2">
                <CarActions :car="car" />
            </div>
            <availability-badge :availability="car.availability" />
            <Link :href="`/inventory/${car.slug}`">
                <img loading="lazy" class="object-cover object-center w-full rounded-t h-32 lg:h-36" :src="car.images[car.featured_image_index]" alt="Vehicle image" />
            </Link>
        </div>
        <div class="mt-2 flex justify-between gap-4 px-2">
            <Link :href="`/inventory/${car.slug}`" class="font-semibold hover:underline whitespace-nowrap overflow-ellipsis overflow-hidden">
                {{ car.name }}
            </Link>
            <div class="">
                <span class="font-semibold text-red-700">
                    ${{ car.price }}
                </span>
            </div>
        </div>
        <div class="my-2 px-1 h-full flex items-end justify-around gap-2 divide-gray-200">
            <div class="flex flex-col items-center justify-end text-center">
                <span class="text-sm font-semibold">
                    {{ car.engine }}
                </span>
                <small class="text-gray-500">
                    Engine
                </small>
            </div>
            <div class="flex flex-col items-center justify-end text-center">
                <span class="text-sm font-semibold">
                    {{ car.body_type }}
                </span>
                <small class="text-gray-500">
                    Body Type
                </small>
            </div>
            <div class="flex flex-col items-center justify-end text-center">
                <span class="text-sm font-semibold">
                    {{ car.mileage }}
                    <small>
                        {{ car.mileage_unit }}
                    </small>
                </span>
                <small class="text-gray-500">
                    Mileage
                </small>
            </div>
        </div>
    </div>
</template>
