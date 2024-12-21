<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

defineProps({
    tasks: Array,
});

const confirmingTaskDeletion = ref(false);
const taskId = ref(null);

const form = useForm({});

const confirmTaskDeletion = (id) => {
    confirmingTaskDeletion.value = true;
    taskId.value = id;
};

const deleteTask = () => {
    form.delete(route('task.destroy', taskId.value), {
        preserveScroll: true,
        onSuccess: () => closeModal()
    });
};

const closeModal = () => {
    confirmingTaskDeletion.value = false;

    form.reset();
};
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
                                <span v-for="tag in task.tags" :key="tag.id" class="inline-block bg-green-100 text-green-800 text-sm px-2 py-1 rounded mr-2">
                                    {{ tag.name }}
                                </span>
                            </div>
                            <div class="flex justify-between mt-4">
                                <Link :href="`/task/${task.id}/edit`" class="btn-info">Edit</Link>
                                <button @click="confirmTaskDeletion(task.id)" class="btn-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <DialogModal :show="confirmingTaskDeletion" @close="closeModal">
                <template #title>
                    Delete Task
                </template>

                <template #content>
                    Are you sure you want to delete your Task?
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTask"
                    >
                        Delete Task
                    </DangerButton>
                </template>
        </DialogModal>
    </AppLayout>
</template>
