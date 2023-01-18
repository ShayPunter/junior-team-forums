<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { VueEditor } from "vue3-editor";
</script>

<script>

import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    title: "",
    content: "",
    forum: "",
})

export default {
    name: 'app',
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        };
    },

    methods: {
        upload(e) {
            e.preventDefault()

            form.forum = this.$page.props.forum

            this.$inertia.post(route('thread.store'), form)
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
    <AppLayout title="ThreadCreate">
        <template #pagetitle>Create new thread</template>

                <form @submit="upload" class="space-y-8 divide-gray-200">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="forum" :value="this.$page.props.forum">
                    <div class="space-y-8 sm:space-y-5">

                        <div class="space-y-6 sm:space-y-5">
                            <div class="space-y-6 sm:space-y-5">
                                <div>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <input placeholder="Thread title" type="text" name="title" id="title" v-model="form.title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" />
                                    </div>
                                </div>

                                <div class="">
                                    <VueEditor id="editor" useCustomImageHandler
                                               @imageAdded="handleImageAdded" v-model="form.content" height="150" class="w-full" :editor-toolbar="toolbarOptions"/>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button onsubmit="upload" type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-orange-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Save</button>
                        </div>
                    </div>
                </form>
    </AppLayout>
</template>
