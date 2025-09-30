<script setup>
import UserLayout from "./Layouts/UserLayout.vue";

defineProps({
    'products': Array
})

</script>

<template>
    <UserLayout>
        <div class="bg-white">
            <div
                class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8"
            >
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Latest Products
                </h2>

                <div
                    class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
                >
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="group relative"
                    >
                        <img
                            v-if="product.product_images.length > 0"
                            :src="`${product.product_images[0].image}`"
                            :alt="product.imageAlt"
                            class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80"
                        />
                        <img
                            v-else="product.product_images.length > 0"
                            src="https://via.placeholder.com/300"
                            :alt="product.imageAlt"
                            class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80"
                        />
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a :href="product.href">
                                        <span
                                            aria-hidden="true"
                                            class="absolute inset-0"
                                        />
                                        {{ product.title }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ product.brand.name }}
                                </p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">
                                ${{ product.price }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
