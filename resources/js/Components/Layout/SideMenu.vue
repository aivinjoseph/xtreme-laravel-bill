<script setup>

    const menus = [
        {name: 'Dashboard', route: 'dashboard', icon: 'home'},
        {name: 'Users', route: 'users', icon: 'users'},
        {name: 'Master Data', route: 'master-data', icon: 'users'},
    ]
</script>

<template>
    <div class="grid grid-cols-1">
        <div class="p-2 hover:bg-gray-100" v-for="menu in menus" :key="menu.name">
            {{ menu.name }}
        </div>
    </div>
</template>