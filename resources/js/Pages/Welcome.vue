<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ChevronRightIcon, ChatBubbleLeftIcon} from '@heroicons/vue/20/solid'
import { ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline';
import { Head } from '@inertiajs/inertia-vue3'
</script>

<script>
export default {
    data() {
        return {
            categories: '',
        }
    },

    mounted() {

        // fetch all categories and forums
        axios.get(route('api-categories')).then(response => {
            console.log(response.data.categories)
            this.categories = response.data.categories
        })

    },

    methods: {
        async getThreadCount(forum_id) {
            let count;

            try {
                const response = await fetch(route('api-thread-count', forum_id));
                const data = await response.json();
                count = data;
            } catch (err) {
                console.error(err);
            }

            console.log(count)

            return count;
        }
    },

}
</script>

<template>
    <AppLayout title="Junior Team Forum">
        <Head>
            <title>Home</title>
            <meta name="description" content="Junior Team Forum, the best place for all of your minecraft services and requirements!">

            <meta property="og:title" content="Home - Junior Team Forum" />
            <meta property="og:description" content="Junior Team Forum, the best place for all of your minecraft services and requirements!" />
            <meta property="og:image" :content="asset('logo.png')" />
        </Head>

        <template #pagetitle>Junior Team Forum</template>

        <div v-for="category in categories" class="overflow-hidden bg-white shadow sm:rounded-md mt-6">
            <div class="border-b border-gray-200 bg-gray-100 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ category.category.name }}</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="forum in category.forums" :key="forum.id">
                    <a :href="route('view-forum', forum.forum.id)" class="block hover:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex min-w-0 flex-1 items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <ChatBubbleLeftRightIcon class="w-[48px] h-[48px]"></ChatBubbleLeftRightIcon>
                                </div>
                                <div class="truncate">
                                    <div class="flex text-sm">
                                        <p class="truncate font-semibold text-lg text-gray-900">{{ forum.forum.name }}</p>
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <ChatBubbleLeftIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            <p class="text-sm">
                                                Threads: {{ forum.threadCount }}
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
