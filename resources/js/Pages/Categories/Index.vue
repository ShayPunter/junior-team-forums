<script setup>
import { ref, computed } from 'vue'
import PageHeader from "@/Components/PageHeader.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>

<template>
    <AdminLayout title="Categories">
        <template #pagehead>
            <PageHeader title="Categories" :button="true" :button_link="route('category.create')" button_text="Add Category"></PageHeader>
        </template>

        <div class="py-6">

            <div class="flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full table-fixed divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"></th>
                                    <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Threads</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="category in $page.props.categories" :key="category.position" class="bg-gray-50">
                                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                    </td>
                                    <td class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900">
                                        {{ category.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        0
                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a :href="route('category.edit', category.id)" class="text-indigo-600 hover:text-indigo-900"
                                        >Edit<span class="sr-only">, {{ category.name }}</span></a
                                        >
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>
