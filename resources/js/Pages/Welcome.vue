<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { CalendarIcon, ChevronRightIcon, ChatBubbleLeftIcon } from '@heroicons/vue/20/solid'

const positions = [
    {
        id: 1,
        title: 'Back End Developer',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
    },
]
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
            this.categories = response.data.categories
        })

    },

    methods: {
        getThreadCount(forum_id) {
            var count = 0;

            axios.get(route('api-thread-count', forum_id)).then(response => {
                count = response.data;
            })

            return count;
        }
    }
}
</script>

<template>
    <AppLayout title="Junior Team Forum">
        <template #page_title>Junior Team Forum</template>

        <div v-for="category in categories" class="overflow-hidden bg-white shadow sm:rounded-md mt-6">
            <div class="border-b border-gray-200 bg-gray-100 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ category.category.name }}</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="forum in category.forums" :key="forum.id">
                    <a :href="route('forums.show', forum)" class="block hover:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex min-w-0 flex-1 items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <img src="https://via.placeholder.com/48" class="w-[48px] h-[48px]" alt="Forum Image">
                                </div>
                                <div class="truncate">
                                    <div class="flex text-sm">
                                        <p class="truncate font-semibold text-lg text-gray-900">{{ forum.name }}</p>
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <ChatBubbleLeftIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            <p class="text-sm">
                                                Threads: {{ getThreadCount(forum.id) }}
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
