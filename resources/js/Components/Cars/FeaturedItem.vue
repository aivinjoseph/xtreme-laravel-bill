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
            <img class="object-cover object-center w-full rounded-t h-32 lg:h-36" :src="car.images[car.featured_image_index]" alt="Vehicle image" />
        </div>
        <div class="mt-2 flex gap-4 px-2">
            <Link :href="`/inventory/${car.slug}`" class="font-semibold hover:underline">
                {{ car.name }}
            </Link>
            <div class="ml-auto">
                <span class="font-semibold">
                    ${{ car.price }}
                </span>
            </div>
        </div>
        <div class="w-full px-1 flex mt-auto mb-2 divide-x divide-gray-200">
            <div class="w-full">
                <div class="text-center">
                    <span class="block text-sm font-semibold">
                        {{ car.engine }}
                    </span>
                    <small class="block">
                       Engine
                    </small>
                </div>
            </div>
            <div class="w-full">
                <div class="text-center">
                    <span class="block text-sm font-semibold">
                        {{ car.body_type }}
                    </span>
                    <small class="block">
                        Body Type
                    </small>
                </div>
            </div>
            <div class="w-full">
                <div class="text-center">
                    <span class="block text-sm font-semibold">
                        {{ car.mileage }}
                        <small>
                            {{ car.mileage_unit }}
                        </small>
                    </span>
                    <small class="block">
                        Mileage
                    </small>
                </div>
            </div>
        </div>
    </div>
</template>
