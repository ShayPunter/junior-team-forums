<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ChevronRightIcon } from '@heroicons/vue/20/solid'
import { ChatBubbleLeftIcon } from '@heroicons/vue/24/outline'
import { Head } from '@inertiajs/inertia-vue3'
</script>

<script>
export default {
    data() {
        return {
            threads: '',
        }
    },
}
</script>

<template>
    <Head>
        <title>{{ $page.props.forum.name }}</title>
        <meta name="description" :content="'Junior Team Forum - Viewing Forum ' +  $page.props.forum.name ">

        <meta property="og:title" :content="$page.props.forum.name + '- Junior Team Forum'" />
        <meta property="og:description" :content="$page.props.forum.name + '- Junior Team Forum'" />
    </Head>

    <AppLayout title="Junior Team Forum">
        <template #pagetitle>Viewing Forum: {{ $page.props.forum.name }}</template>

        <div class="overflow-hidden bg-white shadow sm:rounded-md mt-6">
            <div class="border-b border-gray-200 bg-gray-100 px-4 py-5 sm:px-6">
                <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $page.props.forum.name }}</h3>
                    </div>
                    <div v-if="$page.props.user" class="ml-4 mt-2 flex-shrink-0">
                        <a :href="route('thread.create', $page.props.forum.id)">
                            <button type="button" class="relative inline-flex items-center rounded-md border border-transparent bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Create new thread</button>
                        </a>
                    </div>
                </div>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="thread in $page.props.threads" :key="thread.thread.id">
                    <a :href="route('thread.show', thread.thread)" class="block hover:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex min-w-0 flex-1 items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <ChatBubbleLeftIcon class="w-[48px] h-[48px]"></ChatBubbleLeftIcon>
                                </div>
                                <div class="truncate">
                                    <div class="flex text-sm">
                                        <p class="truncate font-semibold text-lg text-gray-900">{{ thread.thread.title }}</p>
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <ChatBubbleLeftIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            <p class="text-sm">
                                                Thread Replies: {{ thread.replies }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0">
                                <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
