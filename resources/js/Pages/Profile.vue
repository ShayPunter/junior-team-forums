<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from '@inertiajs/inertia-vue3'
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);
</script>

<template>
    <AppLayout title="Junior Team Forum Profile">
        <Head>
            <title>{{ $page.props.profile.name }}'s Profile</title>
            <meta name="description" content="Junior Team Forum, the best place for all of your minecraft services and requirements!">

            <meta property="og:title" content="Home - Junior Team Forum" />
            <meta property="og:description" content="Junior Team Forum, the best place for all of your minecraft services and requirements!" />
        </Head>

            <!-- Page header -->
            <div class="mx-auto max-w-3xl px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full" :src="$page.props.profile.profile_photo_url" :alt="$page.props.profile.name + '\'s Profile Picture'" />
                            <span class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" />
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $page.props.profile.name }} <span v-for="role in $page.props.roles" :class="role === 'admin' ? ['-mt-4 inline-flex items-center rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800'] : ['']">{{ role }}</span></h1>
                        <p class="text-sm font-medium text-gray-500">Joined: {{ dayjs($page.props.profile.created_at).format('DD/MM/YYYY') }}</p>
                    </div>
                </div>
            </div>

            <div class="mx-auto mt-8 grid max-w-3xl grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2 lg:col-start-1">

                    <!-- Comments-->
                    <section aria-labelledby="notes-title">
                        <div class="bg-white shadow sm:overflow-hidden sm:rounded-lg">
                            <div class="divide-y divide-gray-200">
                                <div class="px-4 py-5 sm:px-6">
                                    <h2 id="notes-title" class="text-lg font-medium text-gray-900">Activity</h2>
                                </div>
                                <div class="px-4 py-6 sm:px-6" >
                                    <ul role="list" class="space-y-4 divide-y-2 divide-gray-100">
                                        <li v-for="activity in $page.props.activity">
                                            <div class="flex space-x-3">
                                                <div>
                                                    <div class="text-md">
                                                        <p class="font-semibold text-gray-900"><a :href="route('thread.show', activity.id)" class="hover:underline">{{ activity.type === 'thread' ? 'Created thread: ' + activity.title : 'Replied to thread: ' + activity.title }}</a></p>
                                                    </div>
                                                    <div class="mt-2 space-x-2 text-sm">
                                                        <span class="font-medium text-gray-500">{{ dayjs(activity.updated_at).fromNow() }}</span>
                                                        {{ ' ' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

    </AppLayout>
</template>
