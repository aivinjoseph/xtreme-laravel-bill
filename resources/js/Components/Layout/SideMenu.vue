<script setup>
    import { Link } from '@inertiajs/vue3';

    const menus = [
        { name: 'Dashboard', route: 'dashboard', icon: 'home' },
        // { name: 'Users', route: 'users', icon: 'users' },
        { name: 'Master Data', route: 'master-data', icon: 'users' },
        { name: 'Finance Application', route: 'finance-application.index', icon: 'users' },
        { name: 'Drive Test Bookings', route: 'test-booking.index', icon: 'users' },
        { name: 'Contacts', route: 'contacts.index', icon: 'users' },
        { name: 'Appraisals', route: 'appraisals.index', icon: 'users' },
    ]

    const isUrl = (url, $page) => {
        let currentUrl = $page.url.substr(1)

        if (url === '') {
            return currentUrl === ''
        }

        return currentUrl.includes(url.split('.')[0])
    }
</script>

<template>
    <div class="border border-gray-200 flex justify-center m-2 ">
        <Link :href="route(menu.route)" class="px-4 py-2 hover:bg-gray-100 hover:text-gray-800 cursor-pointer text-gray-800" :class="isUrl(menu.route, $page) && 'bg-gray-100'" v-for="menu in menus" :key="menu.name">
            {{ menu.name }}
        </Link>
    </div>
</template>