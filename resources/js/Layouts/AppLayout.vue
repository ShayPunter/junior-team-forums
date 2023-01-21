<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

const user = {
    name: 'Tom Cook',
    email: 'tom@example.com',
    imageUrl:
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}
const userNavigation = [
    { name: 'Settings', href: route('profile.show') },
    { name: 'Sign out', href: route('logout.perform') },
]
</script>

<script>
export default {
    data() {
        return {
            admin_view: false,
            navigation: [
                { name: 'Home', href: route('welcome'), current: route().current('welcome') },
            ],
        }
    },

    created() {
        if (this.$page.props.user !== null) {
            axios.post(route('permission-check'), {
                'permission': 'admin.view',
                'user': this.$page.props.user.id,
            }).then(res => {
                if (res.data.can === true) {
                    this.navigation.push({ name: 'Admin', href: route('dashboard'), current: route().current('dashboard') })
                }
            })
        }
    }
}
</script>

<template>
    <div>
        <div class="min-h-full">
            <Disclosure as="nav" class="bg-gray-50" v-slot="{ open }">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8" :src="asset('logo.png')" alt="Your Company" />
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-10 flex items-baseline space-x-4">
                                    <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-300 hover:bg-opacity-75', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-4 flex items-center md:ml-6">

                                <!-- Profile dropdown -->
                                <Menu as="div" v-if="$page.props.user" class="relative ml-3">
                                    <div>
                                        <MenuButton class="flex max-w-xs items-center rounded-full bg-indigo-600 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                                            <span class="sr-only">Open user menu</span>
                                            <img class="h-8 w-8 rounded-full" :src="$page.props.user.profile_photo_url" alt="User Profile Image" />
                                        </MenuButton>
                                    </div>
                                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                            <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                                <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                            </MenuItem>

                                            <MenuItem v-if="admin_view">
                                                <a :href="route('dashboard')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Admin Area</a>
                                            </MenuItem>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                                <div v-else>
                                    <a :href="route('login')">
                                        <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-orange-500 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Login/Sign up</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="-mr-2 flex md:hidden">
                            <!-- Mobile menu button -->
                            <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-200 p-2 text-gray-900 hover:bg-gray-300 hover:bg-opacity-75 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                                <span class="sr-only">Open main menu</span>
                                <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                                <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                            </DisclosureButton>
                        </div>
                    </div>
                </div>

                <DisclosurePanel class="md:hidden">
                    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                        <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-300 hover:bg-opacity-75', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
                    </div>
                    <div v-if="$page.props.user" class="border-t border-orange-500 pt-4 pb-3">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" :src="$page.props.user.profile_photo_url" alt="User Profile Picture" />
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-600">{{ $page.props.user.name }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-orange-500 hover:text-white">{{ item.name }}</DisclosureButton>
                        </div>
                    </div>
                    <div v-else class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                        <a :href="route('login')" class="bg-orange-500 text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-600">
                            Login/Sign up
                        </a>
                    </div>
                </DisclosurePanel>
            </Disclosure>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900"><slot name="pagetitle"></slot></h1>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
