<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { VueEditor } from "vue3-editor";
import * as dayjs from 'dayjs'
</script>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    content: "",
    forum: "",
})

export default {
    data() {
        return {
            thread: '',
            threadReplies: '',
            toolbarOptions: [
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],

                [{ 'list': 'ordered'}, { 'list': 'bullet' }],

                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],

                ['link', 'image'],

                ['clean']
            ]
        }
    },

    mounted() {

        // fetch all categories and forums
        axios.get(route('api-thread-replies', this.$page.props.thread.id)).then(response => {
            this.threadReplies = response.data
            console.log(response.data)
        })

    },

    methods: {
        reply() {
            this.$inertia.post(route('threadReplies.store'), {
                'replyContent': form.content,
                'thread': this.$page.props.thread.id,
            })

            location.reload();
        },

        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            let formData = new FormData();
            formData.append("image", file);

            axios({
                url: route('api-uploadImage'),
                method: "POST",
                data: formData
            })
                .then(result => {
                    const url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
}
</script>

<template>
    <AppLayout title="Junior Team Forum">
        <template #pagetitle>Viewing Thread: {{ this.$page.props.thread.title }}</template>

        <div class="bg-gray-50 rounded shadow px-4 py-5 sm:px-6">
            <div class="flex space-x-3 border-b pb-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" :src="this.$page.props.poster.profile_photo_url" alt="Poster Profile" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="#" class="hover:underline">{{ this.$page.props.poster.name }}</a>
                    </p>
                    <p class="text-sm text-gray-500">
                        <a href="#" class="hover:underline">{{ dayjs(this.$page.props.thread.created_at).format('DD/MM/YYYY HH:MM') }}</a>
                    </p>
                </div>
                <div class="flex flex-shrink-0 self-center">
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600">
                                <span class="sr-only">Open options</span>
                                <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                            </MenuButton>
                        </div>
                    </Menu>
                </div>
            </div>

            <div class="my-4" v-html="this.$page.props.thread.content"></div>

        </div>

        <div v-for="threadReply in threadReplies" class="bg-gray-50 rounded shadow my-4 py-4 px-4 lg:grid lg:grid-cols-12">
            <div class="mt-6 flex items-center text-sm col-start-1 row-start-1 mt-0 flex-col items-start col-span-2">
                <img :src="threadReply.poster.profile_photo_url" class="rounded h-[96px] w-[96px] mx-auto" width="96" height="96">
                <p class="text-lg font-semibold my-2 font-medium text-gray-900">
                    {{ threadReply.poster.name }}
                </p>
            </div>

            <div class="lg:col-span-10">
                <div class="xl:col-span-2 xl:mt-0">
                    <div class="flex space-x-3 border-b pb-4">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm text-gray-500">
                                Replied at: {{ dayjs(threadReply.threadReply.created_at).format('DD/MM/YYYY HH:MM') }}
                            </p>
                        </div>
                        <div class="flex flex-shrink-0 self-center">
                            <Menu as="div" class="relative inline-block text-left">
                                <div>
                                    <MenuButton class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600">
                                        <span class="sr-only">Open options</span>
                                        <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                    </MenuButton>
                                </div>
                            </Menu>
                        </div>
                    </div>

                    <div class="my-4" v-html="threadReply.threadReply.content"></div>
                </div>
            </div>
        </div>

        <div v-if="this.$page.props.user" class="bg-gray-50 rounded shadow my-4 py-4 px-4 lg:grid lg:grid-cols-12">
            <div class="mt-6 flex items-center text-sm col-start-1 row-start-1 mt-0 flex-col items-start col-span-2">
                <img :src="this.$page.props.user.profile_photo_url" class="rounded h-[96px] w-[96px] mx-auto" width="96" height="96">
            </div>

            <div class="lg:col-span-10">
                <div class="xl:col-span-2 xl:mt-0">
                    <VueEditor id="editor" useCustomImageHandler
                               @imageAdded="handleImageAdded" v-model="form.content" height="150" class="w-full" :editor-toolbar="toolbarOptions"/>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <a @click="reply(e)">
                                <button type="button" class="ml-3 hover:pointer inline-flex justify-center rounded-md border border-transparent bg-orange-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Post Reply</button>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>

<style>
.ql-editor {
    height: 150px;
}

h1, h2, h3, h4, h5, h6 {
    font-size: revert;
}

blockquote {
    margin: 5px;
    padding-left: 10px;
    border-left: 4px rgba(0,0,0,0.2) solid;
}

ol {
    list-style: normal-nums;
    margin-left: 20px;
}

ul {
    list-style: disc;
    margin-left: 20px;
}
</style>
