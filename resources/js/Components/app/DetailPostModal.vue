<template>

    <modal :show="modelValue" max-width="lg">
        <div class="p-3">
            <h2 class="text-lg font-medium text-gray-900 mb-3">
                Detail Post
            </h2>
            <div>
                {{ post.title }}
            </div>
            <img :src="post.image_url + '/' + post.image" alt="">
            <div v-html="post.body"></div>
            <div class="mt-6 flex justify-end">
                <PrimaryButton @click="closeModal">Close</PrimaryButton>

            </div>


        </div>
    </modal>


</template>

<script setup>
import Modal from "@/Components/Modal.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"

defineProps({
    modelValue: Boolean,
    post: Object,
    // image_url: String

})

const emit = defineEmits(['update:modelValue'])

function closeModal() {
    emit('update:modelValue')
}


</script>