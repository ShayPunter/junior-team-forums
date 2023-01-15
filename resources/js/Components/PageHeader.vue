<script>
export default {
    props: {
        title: String,
        button: Boolean,
        button_link: String,
        button_text: String,
    }
}
</script>

<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ title }}</h2>
            </div>
            <div v-if="button" class="mt-4 flex md:mt-0 md:ml-4">
                <a :href="button_link">
                    <button type="button" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{  button_text }}</button>
                </a>
            </div>
        </div>
    </div>
</template>
