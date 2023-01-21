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
                name: this.$page.props.user.name,
                email: this.$page.props.user.email,
                password: null,
                password_confirmation: null,
                role: this.$page.props.role,
            }
        };
    },

    methods: {
        upload(e) {
            e.preventDefault()

            const formData = new FormData();
            formData.append("name", this.form.name)
            formData.append("email", this.form.email)
            formData.append("password", this.form.password)
            formData.append("password_confirmation", this.form.password_confirmation)
            formData.append("role", this.form.role)

            this.$inertia.post(route('users.update', this.$page.props.user), { '_method': 'PATCH',
                    'name': this.form.name,
                    'email': this.form.email,
                    'password': this.form.password,
                    'password_confirmation': this.form.password_confirmation,
                    'role': this.form.role });
        },

        destroy() {
            if (confirm('Are you sure you want to delete this user?')) {
                this.$inertia.delete(route('users.destroy', this.$page.props.user));
            }
        }
    }
}
</script>

<template>
    <AdminLayout title="Users">
        <template #pagehead>
            <PageHeader title="Edit User" :button="false"></PageHeader>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
                                    <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Email*</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input type="email" name="email" id="email" v-model="form.email" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm" />
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
                                    <label for="password" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Password</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input id="password" name="password" v-model="form.password" type="password" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p class="text-gray-500 text-sm">Leave this field blank to not modify the users password.</p>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:pt-5">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Password Confirmation</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation" type="password" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p class="text-gray-500 text-sm">Leave this field blank to not modify the users password.</p>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
                                    <label for="role" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Role*</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <select id="role" name="role" v-model="form.role" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                            <option>default</option>
                                            <option>admin</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button onsubmit="upload" type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                            <button @click="destroy" type="button" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Delete User</button>
                        </div>
                    </div>
                </form>

    </AdminLayout>
</template>
