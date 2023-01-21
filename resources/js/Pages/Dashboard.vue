<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageHeader from "@/Components/PageHeader.vue";
</script>

<script>
export default {
    data() {
        return {
            stats: [
                { name: 'Total Users', stat: this.$page.props.users },
                { name: 'Total Threads & Replies', stat: this.$page.props.threads },
                ],
        }
    }
}
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #pagehead>
            <PageHeader title="dashboard" :button="false"></PageHeader>
        </template>

            <div>
                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div v-for="item in stats" :key="item.name" class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">{{ item.name }}</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ item.stat }}</dd>
                    </div>
                </dl>
            </div>
    </AdminLayout>
</template>
