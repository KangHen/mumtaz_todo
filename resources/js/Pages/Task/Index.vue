<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    tasks: Array,
});
</script>

<template>
    <AppLayout title="Todo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <Link href="/task/create" class="btn-primary">Create Task</Link>
                </div>

                <div class="bg-white overflow-hidden shadow sm:rounded-lg mt-3" v-for="task in tasks" :key="task.id">
                    <div class="container mx-auto">
                        <div class="bg-white p-6">
                            <h2 class="text-2xl font-semibold mb-4">
                                {{ task.title }}
                            </h2>
                            <p>{{ task.description }}</p>
                            <div>
                                <span v-for="tag in task.tags" :key="tag.id" class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">
                                    {{ tag.name }}
                                </span>
                            </div>
                            <div class="flex justify-between mt-4">
                                <Link :href="`/tasks/${task.id}/edit`" class="btn-info">Edit</Link>
                                <button class="btn-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
