<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    task: Object,
    tags: Array,
    taskTags: Array,
});

const form = useForm({
    title: props.task.title,
    description: props.task.description,
    tags: props.taskTags,
});

const submit = () => {
    form.put(route('task.update', props.task.id));
};
</script>

<template>
    <AppLayout title="Create Todo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Task
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <Link href="/dashboard" class="btn-light">Back</Link>
                </div>
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <div class="container mx-auto py-6 px-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    class="mt-1 block w-full"
                                    autocomplete="new-password"
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="description" value="Description" />
                                <textarea v-model="form.description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="tags" value="Tags" />
                                <template v-for="tag in tags">
                                    <input 
                                        type="checkbox" 
                                        :id="`tag-${tag.id}`" 
                                        :value="tag.id" 
                                        v-model="form.tags" 
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                    <label :for="`tag-${tag.id}`" class="ml-2 mr-2 text-sm text-gray-600">{{ tag.name }}</label>
                                </template>
                                
                                <InputError :message="form.errors.tags" class="mt-2" />
                            </div>

                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
