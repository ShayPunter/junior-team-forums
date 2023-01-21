<script setup>
import PageHeader from "@/Components/PageHeader.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>

<template>
    <AdminLayout title="Users">
        <template #pagehead>
            <PageHeader title="Users" :button="true" :button_link="route('users.create')" button_text="Add User"></PageHeader>
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
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="user in $page.props.users" class="bg-gray-50">
                                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                    </td>
                                    <td class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900">
                                        {{ user.user.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ user.user.email }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ user.role }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a :href="route('users.edit', user.user)" class="text-indigo-600 hover:text-indigo-900"
                                        >Edit<span class="sr-only">, {{ user.name }}</span></a
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
