<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageHeader from "@/Components/PageHeader.vue";
</script>

<script>
export default {
    name: 'app',
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            form: {
                name: this.$page.props.category.name,
            }
        };
    },

    methods: {
        upload(e) {
            e.preventDefault()

            const formData = new FormData();
            formData.append("name", this.form.name)

            this.$inertia.post(route('category.update', this.$page.props.category), { '_method': 'PATCH',
                    'name': this.form.name,});
        },

        destroy() {
            if (confirm('Are you sure you want to delete this category?')) {
                this.$inertia.delete(route('category.destroy', this.$page.props.category));
            }
        }
    }
}
</script>

<template>
    <AdminLayout title="Edit Category">
        <template #pagehead>
            <PageHeader title="Edit Category" :button="false"></PageHeader>
        </template>

                <form @submit="upload" class="space-y-8">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="space-y-8 sm:space-y-5">

                        <div class="space-y-6 sm:space-y-5">
                            <div class="space-y-6 sm:space-y-5">
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
                                    <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Name*</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input type="text" name="name" id="name" v-model="form.name" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button onsubmit="upload" type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                            <button @click="destroy" type="button" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Delete Category</button>
                        </div>
                    </div>
                </form>

    </AdminLayout>
</template>
