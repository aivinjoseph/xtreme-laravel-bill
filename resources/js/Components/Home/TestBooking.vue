<template>
    <section class="w-full pt-12 pb-32 px-4 bg-white overflow-hidden">
        <!--Container-->
        <div class="w-full max-w-7xl mx-auto z-10">
            <!--Content-->
            <div class="relative flex flex-col items-center mx-auto ltablet:flex-row-reverse ltablet:max-w-5xl lg:flex-row-reverse lg:max-w-5xl xl:max-w-6xl">
                <!-- Column -->
                <div class="w-full h-64 ptablet:h-[475px] ltablet:w-1/2 ltablet:h-auto lg:w-1/2 lg:h-auto">
                    <img class="h-full w-full object-cover" src="img/photo/600x600/1.jpg" alt="Cars in line" width="576" height="576" />
                </div>

                <!-- Column -->
                <div class="max-w-lg bg-white border border-gray-200 md:max-w-2xl md:z-10 md:shadow-xl md:shadow-gray-400/10-800/10 md:absolute md:top-0 md:mt-48 lg:w-3/6 lg:left-0 lg:mt-20 lg:ml-20 xl:mt-24 xl:ml-12">
                    <!-- Content -->
                    <div class="flex flex-col p-12">
                        <h2 class="font-heading font-light text-2xl ltablet:text-4xl lg:text-4xl text-gray-800">
                            Book a test drive
                        </h2>
                        <p class="font-sans text-gray-500 mt-4">
                            You can take control and explore the car of your dreams firsthand. Discover the thrill of the open road, feel the comfort of the interior, and experience the cutting-edge technology that sets our vehicles apart.
                        </p>
                        <!-- Buttons -->
                        <div class="flex items-center gap-4 mt-8">
                            <a href="/test-booking" class="inline-block w-full text-center text-base font-medium text-white bg-red-800 py-4 px-10 hover:bg-red-700-1000 md:w-44 tw-accessibility transition-all duration-300">
                                Get Started
                            </a>
                            <p class="hidden md:block font-sans text-sm text-gray-500">
                                No credit card required
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>