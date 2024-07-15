<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-3 flex justify-end">
                    <a href="#" @click.prevent="showCreatePostModal" class=" px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white
                        rounded-md
            ">New Post</a>
                </div>

                <div class="">
                    <table class="min-w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>

                                <th class="text-lg font-semibold text-gray-900  py-4 text-left">
                                    Title
                                </th>
                                <th class="text-lg font-semibold text-gray-900  py-4 text-left">
                                    Excerpt
                                </th>
                                <th class="text-lg font-semibold text-gray-900  py-4 text-left">
                                    Created at
                                </th>
                                <th class="text-lg font-semibold text-gray-900  py-4 text-left">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post of posts" :key="post.id">

                                <td class="py-4  text-sm font-medium text-gray-900 ">
                                    {{ post.title }}
                                </td>
                                <td class="py-4 text-sm font-medium text-gray-900 ">
                                    {{ post.excerpt }}
                                </td>


                                <td>
                                    {{ post.created_at }}
                                </td>
                                <td>
                                    <a href="#" @click.prevent="showDetailModal(post)"
                                        class="bg-blue-500 px-2 py-1 rounded-md">Detail</a>
                                    <a href="#" @click.prevent="showEditModal(post)"
                                        class="bg-green-500 px-2 py-1 rounded-md ml-3">edit</a>
                                    <a href="#" @click.prevent="showDeleteModal(post)"
                                        class="bg-red-500 px-2 py-1 rounded-md ml-3">Delete</a>
                                    <!-- <button @click="deletePost(post.id)"
                                        class="px-2 py-1 ml-3 bg-red-400 rounded-md hover:bg-red-800 hover:text-white">Delete
                                        Post</button> -->
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <div v-if="!posts.length" class="py-8 text-center text-sm text-gray-400">
                        There is no data in this folder
                    </div>

                </div>
            </div>
        </div>
        <createPostModal v-model="createPostModal" :categories="categories" />
        <DetailPostModal v-model="postDetailModal" :post="selectedPost" :image_url="image_url" />
        <EditPostModal v-model="editPostModal" :post="selectedPost" :categories="categories"
            @update:modelValue="editPostModal = $event" @update:post="updatePost" />
        <DeleteModal v-model="deletePostModal" :post="selectedPost" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CreatePostModal from '@/Components/app/CreatePostModal.vue'
import DetailPostModal from '@/Components/app/DetailPostModal.vue'
import EditPostModal from '@/Components/app/EditPostModal.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import DeleteModal from '@/Components/app/DeleteModal.vue';
import { Inertia } from "@inertiajs/inertia";

const createPostModal = ref(false)
const postDetailModal = ref(false)
const editPostModal = ref(false)
const deletePostModal = ref(false);
const selectedPost = ref(null)


defineProps({
    posts: Object,
    categories: Object,
    image_url: String

})

function showDetailModal(post) {
    selectedPost.value = post
    postDetailModal.value = true
}

function showEditModal(post) {
    selectedPost.value = post
    editPostModal.value = true
}

function showCreatePostModal() {
    createPostModal.value = true
}

const showDeleteModal = (post) => {
    selectedPost.value = post;
    deletePostModal.value = true;
};

const updatePost = (updatedPost) => {
    const index = props.posts.findIndex(post => post.id === updatedPost.id);
    if (index !== -1) {
        props.posts[index] = updatedPost;
    }
};

// const deletePost = (id) => {
//     if (confirm('Are you sure you want to delete this post?')) {
//         Inertia.delete(`/dashboard/${id}`);
//     }
// };
</script>
