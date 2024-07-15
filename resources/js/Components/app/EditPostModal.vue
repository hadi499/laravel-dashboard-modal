<template>
    <modal :show="modelValue" max-width="lg">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-3">
                Edit Post
            </h2>

            <div class=" flex flex-col gap-3">

                <div class="flex flex-col gap-2">
                    <InputLabel for="title" value="Title" />
                    <Input id="title" type="text" v-model="form.title" />
                    <InputError :message="form.errors.title" />
                </div>
                <div class="flex flex-col gap-2">
                    <InputLabel for="slug" value="Slug" />
                    <Input class="w-full" id="slug" type="text" v-model="form.slug" />
                </div>
                <div class="flex flex-col gap-2">
                    <InputLabel for="image" value="Image" />
                    <input id="image" type="file" @input="form.image = $event.target.files[0]" />
                    <InputError :message="form.errors.image" />
                </div>
                <div>
                    <InputLabel for="category_id" value="Category" />
                    <select v-model="form.category_id" id="category_id" name="category_id" class=" 
                mt-1
                block
                w-full
                pl-3
                pr-10
                py-2
                text-base
                border-gray-300
                focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                sm:text-sm
                rounded-md
              ">
                        <option value="" disabled>Select a category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.category_id" />
                </div>
                <div class="flex flex-col gap-2">
                    <InputLabel for="body" value="Body" />
                    <TextAreaInput class="w-full" rows="8" id="body" type="text" v-model="form.body" />

                    <InputError :message="form.errors.body" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <PrimaryButton class="ml-3" @click="editPost">
                    Edit
                </PrimaryButton>
            </div>

        </div>
    </modal>
</template>

<script setup>
// Imports
import Modal from "@/Components/Modal.vue";
import Input from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextAreaInput from '@/Components/TextArea.vue'
import { useForm, usePage } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from 'vue';


const props = defineProps({
    modelValue: Boolean,
    categories: Array,
    post: Object,

})

const form = useForm({
    title: props.post?.title,
    slug: props.post?.slug,
    image: null,
    oldImage: props.post?.image,
    category_id: props.post?.category_id,
    body: props.post?.body,
})


const emit = defineEmits(['update:modelValue', 'update:post'])

watch(() => props.post, (newPost) => {
    form.title = newPost?.title || '';
    form.slug = newPost?.slug || '';
    form.oldImage = newPost?.image || '';
    form.category_id = newPost?.category.id || null;
    form.body = newPost?.body || '';
}, { immediate: true });


const editPost = () => {
    Inertia.post(`/dashboard/${props.post.slug}/edit`, {
        _method: "put",
        title: form.title,
        slug: form.slug,
        image: form.image,
        oldImage: form.oldImage,
        category_id: form.category_id,
        body: form.body,
    });
}

function closeModal() {
    emit('update:modelValue', false);
    form.clearErrors();
    form.reset();

}


</script>
