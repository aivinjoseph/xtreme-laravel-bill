<template>
    <section class="w-full py-12 px-4 bg-white dark:bg-muted-900 overflow-hidden">
        <div class="w-full max-w-6xl mx-auto pb-16 border-b border-muted-200 dark:border-muted-800">
            <!--Slider-->
            <div class="relative swiper" x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
                loop: true,
                slidesPerView: 4,
                spaceBetween: 0,
                effect: 'coverflowEffect',
                breakpoints: {
                  300: {
                    slidesPerView: 1,
                    spaceBetween: 30,
                  },
                  768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                  },
                  1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                  },
                },
              });
          ">
                <!--Section title-->
                <div class="w-full flex items-center justify-between space-y-2 py-6">
                    <div>
                        <h2 class="font-heading font-light text-3xl md:text-4xl text-muted-800 dark:text-white">
                            Our Happy Customers
                        </h2>
                        <!--Subtitle-->
                        <p class="font-sans font-light text-lg text-muted-500 dark:text-muted-400">
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit.
                        </p>
                    </div>

                    <div class="carousel-controls hidden md:flex">
                        <button class="w-12 h-12 flex items-center justify-center border-2 border-transparent text-muted-800 dark:text-muted-100 hover:border-muted-800 dark:hover:border-muted-100 transition-colors duration-300">
                            <i class="iconify w-5 h-5" data-icon="lucide:arrow-left"></i>
                        </button>

                        <button class="w-12 h-12 flex items-center justify-center border-2 border-transparent text-muted-800 dark:text-muted-100 hover:border-muted-800 dark:hover:border-muted-100 transition-colors duration-300">
                            <i class="iconify w-5 h-5" data-icon="lucide:arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!--Container-->
                <div class="swiper-container relative" x-ref="container">
                    <div class="grid grid-cols-3 gap-8">
                        <!--Slide 1-->
                        <div class="swiper-slide">
                            <div class="relative">
                                <img src="img/testimonials/1.jpg" alt="Testimonial" />
                                <div class="absolute -bottom-7 right-6 h-14 w-14 flex items-center justify-center px-2 text-muted-500 dark:text-muted-100 border-4 border-white dark:border-muted-900 bg-muted-100 dark:bg-muted-800">
                                    <svg version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 252.3 252.3" style="
                                            enable-background: new 0 0 252.3
                                                252.3;
                                        " xml:space="preserve">
                                        <g>
                                            <path class="fill-current" d="M43.7,169.9c-11.1,0-21.7-4.2-29.9-11.8c-8.5-8-13.5-18.8-13.8-30.5c-0.8-24.1,18.2-44.4,42.3-45.2l0.2,0l2.8,0
                        		c9.8,0.3,18.8,3.9,26,9.7c7.1-5.8,16.1-9.4,26-9.7l0.2,0l2.8,0c9.8,0.3,18.8,3.9,26,9.7c7.1-5.8,16.1-9.4,26-9.7l0.2,0l2.8,0
                        		c9.8,0.3,18.8,3.9,26,9.7c7.1-5.8,16.1-9.4,26-9.7l0.2,0l2.8,0c23,0.8,41.5,19.3,42.3,42.3c0.4,11.7-3.8,22.8-11.8,31.4
                        		c-8,8.5-18.8,13.5-30.5,13.8c-10.9,0.4-21-3.3-28.9-9.7c-7.4,5.9-16.4,9.3-26,9.7c-10.9,0.4-21-3.3-28.9-9.7
                        		c-7.4,5.9-16.4,9.3-26,9.7c-10.9,0.4-21-3.3-28.9-9.7c-7.4,5.9-16.4,9.3-26,9.7C44.7,169.9,44.2,169.9,43.7,169.9z M42.6,91.5
                        		c-19.1,0.7-34,16.7-33.4,35.8c0.3,9.2,4.2,17.8,11,24.1c6.8,6.3,15.6,9.6,24.8,9.3c7.3-0.2,14.1-2.7,19.8-7
                        		c-5.8-7.2-9.5-16.2-9.8-26.1c-0.4-11,3.3-21.1,9.8-29c-5.5-4.2-12.3-6.8-19.7-7H42.6z M187.6,153.7c6.1,4.6,13.8,7.3,22.1,7
                        		c9.2-0.3,17.8-4.2,24.1-11c6.3-6.8,9.6-15.6,9.3-24.8c-0.6-18.1-15.3-32.8-33.4-33.5h-2.5c-7.4,0.3-14.2,2.9-19.7,7
                        		c5.8,7.2,9.5,16.2,9.8,26.1C197.7,135.3,194.2,145.5,187.6,153.7z M132.7,153.7c6.1,4.6,13.8,7.3,22.1,7c7.3-0.2,14.1-2.7,19.8-7
                        		c-5.8-7.2-9.5-16.2-9.8-26.1c-0.4-11,3.3-21.1,9.8-29c-5.5-4.2-12.3-6.8-19.7-7h-2.5c-7.4,0.3-14.2,2.9-19.7,7
                        		c5.8,7.2,9.5,16.2,9.8,26.1C142.8,135.3,139.3,145.5,132.7,153.7z M77.8,153.7c6.1,4.6,13.8,7.3,22.1,7c7.3-0.2,14.1-2.7,19.8-7
                        		c-5.8-7.2-9.5-16.2-9.8-26.1c-0.4-11,3.3-21.1,9.8-29c-5.5-4.2-12.3-6.8-19.7-7h-2.5c-7.4,0.3-14.2,2.9-19.7,7
                        		c5.8,7.2,9.5,16.2,9.8,26.1C87.9,135.3,84.5,145.5,77.8,153.7z M181,105c-4.7,6.1-7.4,13.9-7.2,22.2c0.3,7.5,2.9,14.4,7.2,20
                        		c4.9-6.4,7.4-14.1,7.2-22.3C187.9,117.5,185.3,110.6,181,105z M126.1,105c-4.7,6.1-7.4,13.9-7.2,22.2c0.3,7.5,2.9,14.4,7.2,20
                        		c4.9-6.4,7.4-14.1,7.2-22.3C133,117.5,130.4,110.6,126.1,105z M71.2,105c-4.7,6.1-7.4,13.9-7.2,22.2c0.3,7.5,2.9,14.4,7.2,20
                        		c4.9-6.4,7.4-14.1,7.2-22.3C78.2,117.5,75.5,110.6,71.2,105z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="font-sans font-medium text-lg text-muted-800 dark:text-muted-100">
                                    Mike Thomson
                                </h3>
                                <p class="font-sans text-sm text-muted-400 mb-3">
                                    Las Vegas - NV
                                </p>
                                <p class="font-sans text-sm text-muted-500">
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit. Quae diligentissime contra
                                    Aristonem dicuntur a Chryippo.
                                </p>
                            </div>
                        </div>
                        <!--Slide 2-->
                        <div class="swiper-slide">
                            <div class="relative">
                                <img src="img/testimonials/6.jpg" alt="Testimonial" />
                                <div class="absolute -bottom-7 right-6 h-14 w-14 flex items-center justify-center px-2 text-muted-500 dark:text-muted-100 border-4 border-white dark:border-muted-900 bg-muted-100 dark:bg-muted-800">
                                    <svg version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 252.3 252.3" style="
                                            enable-background: new 0 0 252.3
                                                252.3;
                                        " xml:space="preserve" class="w-full h-full">
                                        <g transform="matrix(2.6914334,0,0,2.6914334,3.9289753e-4,0.00201068)">
                                            <path inkscape:connector-curvature="0" class="fill-current" clip-rule="evenodd" fill-rule="evenodd" d="M56.7,52.4c0.7,3.7-1.2,6.8-2.8,9.7c-1.8,2.8-4.7,5.1-8.3,4.8
                        		c-7.9-0.1-15.7-1.3-22.9-3.5c-0.3-0.1-0.7-0.3-0.8-0.6c-0.1-0.4,0.1-0.8,0.4-1.1c6.6-5.3,14.4-7.8,22.1-10.4c2.9-0.8,6-1.7,9.2-1.3
                        		C54.9,50.2,56.2,51.1,56.7,52.4z M83.8,36.6c3.7,3,7,7.2,5.9,12.2c-1.8,7.4-9.9,11.3-16.3,13.8c-3.5,1.2-7,2.4-10.8,2.7
                        		c-0.2,0-0.6,0-0.7-0.3l0.1-0.4c5.4-6.1,9.5-12.9,13.1-19.9c1.7-3.1,3.2-6.3,4.6-9.5c0.2-0.2,0.4-0.4,0.7-0.4
                        		C81.8,34.9,82.7,35.9,83.8,36.6L83.8,36.6z M31.9,28.8l-0.1,0.4c-7.8,8.9-13,19.2-17.9,29.5c-1,0.9-1.9-0.3-2.7-0.7
                        		C6.8,55.2,2.9,50.5,4,45.1c1.8-7.1,9.2-10.9,15.3-13.5c3.6-1.4,7.4-2.5,11.4-3.1C31.1,28.4,31.7,28.4,31.9,28.8z M70.7,30.2
                        		c0.4,0.2,1,0.3,1.3,0.8c0.2,0.5-0.2,0.8-0.5,1.2c-6.2,4.8-13.2,7.5-20.4,9.9c-3.7,0.9-7.4,2.5-11.4,1.6c-1-0.2-1.8-0.9-2.4-1.8
                        		c-1-2.8,0.4-5.7,1.5-8.2c1.6-3.1,4.4-6.7,8.2-6.7C55.4,26.9,63.3,28.1,70.7,30.2z M81,30.4c6.3,3.5,13.5,9.5,12.7,17.6
                        		c-0.9,7.5-7.9,12.7-14.1,15.9c-18.2,8.7-43.9,9-62.7,1.4c-6.4-2.6-13.5-7.2-16.2-14c-2.1-5.6,0.4-11.5,4.6-15.4
                        		c8.8-8,20-10.7,31.5-12.3c12.5-1.5,25.7-0.2,36.8,3.7C76.2,28.2,78.7,29.2,81,30.4z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="font-sans font-medium text-lg text-muted-800 dark:text-muted-100">
                                    Oba Babatunde
                                </h3>
                                <p class="font-sans text-sm text-muted-400 mb-3">
                                    San Diego - CA
                                </p>
                                <p class="font-sans text-sm text-muted-500">
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit. Quae diligentissime contra
                                    Aristonem dicuntur a Chryippo.
                                </p>
                            </div>
                        </div>
                        <!--Slide 3-->
                        <div class="swiper-slide">
                            <div class="relative">
                                <img src="img/testimonials/4.png" alt="Testimonial" />
                                <div class="absolute -bottom-7 right-6 h-14 w-14 flex items-center justify-center px-2 text-muted-500 dark:text-muted-100 border-4 border-white dark:border-muted-900 bg-muted-100 dark:bg-muted-800">
                                    <svg version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 252.3 252.3" style="
                                            enable-background: new 0 0 252.3
                                                252.3;
                                        " xml:space="preserve">
                                        <path class="fill-current" clip-rule="evenodd" fill-rule="evenodd" d="M126.1,0C56.5,0,0,56.5,0,126.1c0,69.7,56.5,126.1,126.1,126.1c69.7,0,126.1-56.5,126.1-126.1
                        	C252.3,56.5,195.8,0,126.1,0z M22.9,66.8c21-36.5,59.8-59.1,101.9-59.7l-16.3,108.1v0l-86.2,69.7C1.5,148.2,1.8,103.3,22.9,66.8z
                        	 M126.6,245.7c-42.2,0.2-81.3-21.9-102.8-58.2l102.4-42.4L229,186.9C207.6,223.3,168.7,245.6,126.6,245.7z M143.4,116.7L143.4,116.7
                        	L143.4,116.7L143.4,116.7L127.8,7.2c41.9,0.6,80.4,23.2,101.4,59.5c21.1,36.3,21.6,80.8,1.3,117.5L143.4,116.7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="font-sans font-medium text-lg text-muted-800 dark:text-muted-100">
                                    Lakisha Jackson
                                </h3>
                                <p class="font-sans text-sm text-muted-400 mb-3">
                                    Los Angeles - CA
                                </p>
                                <p class="font-sans text-sm text-muted-500">
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit. Quae diligentissime contra
                                    Aristonem dicuntur a Chryippo.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
