<script setup>
import { Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref, watch } from 'vue';

const showMobileMenu = ref(false);

// watch for showMobileMenu changes and close the menu when it changes
watch(showMobileMenu, (value) => {
  if (!value) return document.body.classList.remove('overflow-hidden');

  return document.body.classList.add('overflow-hidden');
});

const logout = () => {
  router.post(route('logout'));
}

</script>

<template>
  <nav class="bg-gray-50 mx-auto flex w-full items-center justify-between p-6 lg:px-8" aria-label="Global">
    <div class="flex lg:flex-1">
      <a href="/" class="-m-1.5 p-1.5">
        <span class="sr-only">Xtreme Motors Inc</span>
        <ApplicationLogo class="w-48"/>
      </a>
    </div>
    <div class="flex lg:hidden">
      <button
        type="button"
        @click="showMobileMenu = true"
        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
        <span class="sr-only">Open main menu</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-6">
      <Link href="/dashboard" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Dashboard</Link>
      <Link href="/" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Home</Link>
      <Link href="/inventory" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Inventory</Link>
      <div class="relative group hover:cursor-pointer">
        <span class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Financing</span>
        <div class="absolute top-6 w-40 bg-gray-50 shadow p-2 gap-2 z-50 hidden group-hover:flex flex-col">
          <Link href="/finance-application" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Finance Application</Link>
          <Link href="/payment-calculator" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Payment Calculator</Link>
        </div>
      </div>
      <Link href="/contact-us" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Contact Us</Link>
      <Link href="/about-us" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">About Us</Link>
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
      <form v-if="$page.props.auth.user" @submit.prevent="logout">
        <button type="submit">Logout</button>
      </form>
      <Link v-else href="/login" class="text-sm font-semibold leading-6 text-gray-800 hover:underline hover:text-gray-600">Log in <span aria-hidden="true">&rarr;</span></Link>
    </div>
  </nav>
  <!-- Mobile menu, show/hide based on menu open state. -->
  <div class="lg:hidden" role="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0" :class="showMobileMenu ? 'z-10' : '-z-10'"></div>
    <div :class="showMobileMenu ? 'right-0 z-10' : '-right-full -z-10'"
    class="fixed inset-y-0 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
      <div class="flex items-center justify-between">
        <Link href="#" class="-m-1.5 p-1.5">
          <span class="sr-only">Your Company</span>
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=orange&shade=600" alt="">
        </Link>
        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="showMobileMenu = false">
          <span class="sr-only">Close menu</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="mt-6 flow-root">
        <div class="-my-6 divide-y divide-gray-500/10">
          <div class="space-y-2 py-6">
            <Link @click="showMobileMenu = false" href="/dashboard" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Dashboard</Link>
            <Link @click="showMobileMenu = false" href="/" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Home</Link>
            <Link @click="showMobileMenu = false" href="/Inventory" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Inventory</Link>
            <Link @click="showMobileMenu = false" href="/finance-application" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Finance Application</Link>
            <Link @click="showMobileMenu = false" href="/payment-calculator" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Payment Calculator</Link>
            <Link @click="showMobileMenu = false" href="/contact-us" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Contact Us</Link>
            <Link @click="showMobileMenu = false" href="/about-us" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">About Us</Link>
          </div>
          <div class="py-6">
            <Link @click="showMobileMenu = false" href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-800 hover:bg-gray-50">Log in</Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
