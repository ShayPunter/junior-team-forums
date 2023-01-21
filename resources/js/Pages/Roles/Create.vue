<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageHeader from "@/Components/PageHeader.vue";
</script>

<script>

import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    name: "",
    permissions: [],
})

export default {
    name: 'app',
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        };
    },

    methods: {
        upload(e) {
            e.preventDefault()

            this.$inertia.post(route('roles.store'), form)
        }
    }
}
</script>

<template>
    <AdminLayout title="Add Roles">
        <template #pagehead>
            <PageHeader title="Add Role" :button="false"></PageHeader>
        </template>

                <form @submit="upload" class="space-y-8 divide-gray-200">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="space-y-8 sm:space-y-5">

                        <div class="space-y-6 sm:space-y-5">
                            <div class="space-y-6 sm:space-y-5">
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
                                    <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Name*</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input type="text" name="name" id="name" v-model="form.name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm" />
                                    </div>
                                </div>

                                <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 col-span-1">Permissions*</label>
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
                                    <div v-for="permission in this.$page.props.permissions" class="relative flex col-span-1">
                                        <div class="flex h-5 items-center">
                                            <input id="permissions" v-model="form.permissions" :value="permission.id" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="permissions" class="font-medium text-gray-700">{{ permission.name }}</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button onsubmit="upload" type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                        </div>
                    </div>
                </form>
    </AdminLayout>
</template>
