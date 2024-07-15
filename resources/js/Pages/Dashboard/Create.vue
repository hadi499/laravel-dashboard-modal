<template>

    <Head title="Create Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
                <form class="w-[600px] flex flex-col gap-3">

                    <div class="flex flex-col gap-2">
                        <InputLabel for="title" value="Title" />
                        <Input id="title" type="text" v-model="form.title" />
                        <InputError :message="form.errors.title" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <InputLabel for="image" value="Image" />
                        <input id="image" type="file" @input="form.image = $event.target.files[0]" />
                        <InputError :message="form.errors.image" />
                    </div>

                </form>

            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>

import { useForm, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Input from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'


defineProps({
    categories: Array,
})

const form = useForm({
    title: '',
    image: null,
    category_id: '',
    body: ''
})

</script>