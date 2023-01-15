<script setup>
import Welcome from '@/Components/Welcome.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageHeader from "@/Components/PageHeader.vue";
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #pagehead>
            <PageHeader title="dashboard" :button="false"></PageHeader>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
