<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from '@inertiajs/inertia-vue3'
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Popover,
    PopoverButton,
    PopoverOverlay,
    PopoverPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    ArrowLongLeftIcon,
    CheckIcon,
    HandThumbUpIcon,
    HomeIcon,
    MagnifyingGlassIcon,
    PaperClipIcon,
    QuestionMarkCircleIcon,
    UserIcon,
} from '@heroicons/vue/20/solid'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import dayjs from "dayjs";

const user = {
    name: 'Whitney Francis',
    email: 'whitney@example.com',
    imageUrl:
        'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
}
const navigation = [
    { name: 'Dashboard', href: '#' },
    { name: 'Jobs', href: '#' },
    { name: 'Applicants', href: '#' },
    { name: 'Company', href: '#' },
]
const breadcrumbs = [
    { name: 'Jobs', href: '#', current: false },
    { name: 'Front End Developer', href: '#', current: false },
    { name: 'Applicants', href: '#', current: true },
]
const userNavigation = [
    { name: 'Your Profile', href: '#' },
    { name: 'Settings', href: '#' },
    { name: 'Sign out', href: '#' },
]
const attachments = [
    { name: 'resume_front_end_developer.pdf', href: '#' },
    { name: 'coverletter_front_end_developer.pdf', href: '#' },
]
const eventTypes = {
    applied: { icon: UserIcon, bgColorClass: 'bg-gray-400' },
    advanced: { icon: HandThumbUpIcon, bgColorClass: 'bg-blue-500' },
    completed: { icon: CheckIcon, bgColorClass: 'bg-green-500' },
}
const timeline = [
    {
        id: 1,
        type: eventTypes.applied,
        content: 'Applied to',
        target: 'Front End Developer',
        date: 'Sep 20',
        datetime: '2020-09-20',
    },
    {
        id: 2,
        type: eventTypes.advanced,
        content: 'Advanced to phone screening by',
        target: 'Bethany Blake',
        date: 'Sep 22',
        datetime: '2020-09-22',
    },
    {
        id: 3,
        type: eventTypes.completed,
        content: 'Completed phone screening with',
        target: 'Martha Gardner',
        date: 'Sep 28',
        datetime: '2020-09-28',
    },
    {
        id: 4,
        type: eventTypes.advanced,
        content: 'Advanced to interview by',
        target: 'Bethany Blake',
        date: 'Sep 30',
        datetime: '2020-09-30',
    },
    {
        id: 5,
        type: eventTypes.completed,
        content: 'Completed interview with',
        target: 'Katherine Snyder',
        date: 'Oct 4',
        datetime: '2020-10-04',
    },
]
const comments = [
    {
        id: 1,
        name: 'Leslie Alexander',
        date: '4d ago',
        imageId: '1494790108377-be9c29b29330',
        body: 'Ducimus quas delectus ad maxime totam doloribus reiciendis ex. Tempore dolorem maiores. Similique voluptatibus tempore non ut.',
    },
    {
        id: 2,
        name: 'Michael Foster',
        date: '4d ago',
        imageId: '1519244703995-f4e0f30006d5',
        body: 'Et ut autem. Voluptatem eum dolores sint necessitatibus quos. Quis eum qui dolorem accusantium voluptas voluptatem ipsum. Quo facere iusto quia accusamus veniam id explicabo et aut.',
    },
    {
        id: 3,
        name: 'Dries Vincent',
        date: '4d ago',
        imageId: '1506794778202-cad84cf45f1d',
        body: 'Expedita consequatur sit ea voluptas quo ipsam recusandae. Ab sint et voluptatem repudiandae voluptatem et eveniet. Nihil quas consequatur autem. Perferendis rerum et.',
    },
]
</script>

<script>
export default {

    methods: {
        stripAndExerpt(text) {
            let cleanText = text.replace(/<\/?[^>]+(>|$)/g, "");
            return cleanText.substring(0, 30)
        }
    }

}
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
                                <div class="px-4 py-6 sm:px-6">
                                    <ul role="list" class="space-y-8">
                                        <li v-for="activity in $page.props.activity">
                                            <div class="flex space-x-3">
                                                <div>
                                                    <div class="text-sm">
                                                        <p class="font-semibold text-md text-gray-900"><a :href="route('thread.show', activity.id)" class="hover:underline">{{ activity.type === 'thread' ? 'Created thread: ' + activity.title : 'Replied to thread: ' + activity.title }}</a></p>
                                                    </div>
                                                    <div class="mt-1 text-sm text-gray-700">
                                                        {{ stripAndExerpt(activity.content) }}
                                                    </div>
                                                    <div class="mt-2 space-x-2 text-sm">
                                                        <span class="font-medium text-gray-500">{{ dayjs(activity.updated_at).format('DD/MM/YYYY HH:MM') }}</span>
                                                        {{ ' ' }}
                                                        <span class="font-medium text-gray-500">&middot;</span>
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
