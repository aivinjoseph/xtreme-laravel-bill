<script setup>
import Wheel from '@/Components/Footer/Wheel.vue';
import CarAnimation from '@/Components/Footer/CarAnimation.vue';
import { info } from '../../info.js';
</script>
<template>
  <footer class="group relative text-gray-100 body-font overflow-hidden bg-red-800 dark:bg-muted-1000">   
    <div class="relative w-full max-w-7xl mx-auto px-5 py-8 pt-16 z-20">
      <div class="absolute top-4">
        <Wheel />
      </div>
      <div class="grid grid-cols-2 md:grid-cols-5 justify-center">
        <div class="md:col-start-2 w-full px-4">
          <h2 class="font-sans font-medium text-gray-100 tracking-widest text-sm uppercase mb-4">
            Buy vehicles
          </h2>
          <ul class="font-sans space-y-2 mb-10">
            <li>
              <a href="/inventory" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Inventory
              </a>
            </li>
            <li>
              <a href="/inventory?featured=1" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Featured Cars
              </a>
            </li>
            <li>
              <a href="/inventory?availability=upcoming" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Upcoming Cars
              </a>
            </li>
            <li>
              <a href="/finance-application" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Finance Application
              </a>
            </li>
          </ul>
        </div>
        <div class="w-full px-4">
          <h2 class="font-sans font-medium text-gray-100 tracking-widest text-sm uppercase mb-4">
            Service
          </h2>
          <ul class="font-sans space-y-2 mb-10">
            <li>
              <a href="/test-booking" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Book Test Drive
              </a>
            </li>
            <li>
              <a href="/payment-calculator" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Payment Calculator
              </a>
            </li>
            <li>
              <a href="/faqs" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                FAQs
              </a>
            </li>
          </ul>
        </div>
        <div class="w-full px-4">
          <h2 class="font-sans font-medium text-gray-100 tracking-widest text-sm uppercase mb-4">
            Company
          </h2>
          <ul class="font-sans space-y-2 mb-10">
            <li class="text-sm">
              {{ info.address }}
            </li>
            <li>
              <a :href="`tel:${info.phone}`" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                {{ info.phone }}
              </a>
            </li>
            <li>
              <a :href="`mailto:${info.email}`" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                {{ info.email }}
              </a>
            </li>
            <li>
              <a href="/about-us" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                About us
              </a>
            </li>
            <li>
              <a href="/contact-us" class="text-sm underline-offset-4 text-gray-300 hover:text-white hover:underline dark:text-muted-400 dark:hover:text-gray-100">
                Contact
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
    <div class="bg-muted-1000 dark:bg-muted-900 z-20">
      <div class="w-full max-w-7xl mx-auto px-5 py-6 flex justify-around items-center sm:flex-row flex-col">
        <p class="text-sm text-muted-400 sm:ml-6 sm:mt-0 mt-4">
          © {{ new Date().getFullYear() }} {{ info.name }} — All Rights Reserved.
        </p>
        <span class="flex gap-3 sm:mt-0 mt-4 justify-center text-sm">
          <a href="/terms" class="text-muted-400 hover:text-primary-500 hover:underline">
            Terms of Use & Disclaimer
          </a>
          <a href="/privacy" class="text-muted-400 hover:text-primary-500 hover:underline">
            Privacy Policy
          </a>
        </span>
      </div>
    </div>
  </footer>
</template>

<style>
.animate-wheel {
  -webkit-animation: spin 4s linear infinite;
  -moz-animation: spin 4s linear infinite;
  animation: spin 4s linear infinite;
}

@-moz-keyframes spin {
  100% {
    -moz-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}</style>
