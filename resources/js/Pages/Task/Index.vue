<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Notification from '@/Components/Notification.vue';
import { reactive, ref } from 'vue';

defineProps({
    tasks: Array,
    notification: String,
});

const confirmingTaskDeletion = ref(false);
const taskId = ref(null);
const activeMap = reactive({});
const form = useForm({});
const formComment = useForm({
    content: '',
    task_id: '',
});
const formDelete = useForm({});

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

const toggleAccordion = (index) => {
    activeMap[index] = !activeMap[index];
    formComment.task_id = index ? index : '';
}

const saveComment = (index) => {
    formComment.post(route('comment.store'), {
        preserveScroll: true,
        onSuccess: () => {
            formComment.reset();
            toggleAccordion(index);
        },
    });
}

const destroyComment = (id) => {
    formDelete.delete(route('comment.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            formDelete.reset();
        },
    });
}

</script>

<style scoped>
    .is-open {
        display: block !important;
    }
</style>

<template>
    <AppLayout title="Task">
        <Notification :message="notification"/>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task
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
                            <div class="my-2 hidden" :class="{ 'is-open': !!activeMap[task.id] }">
                                <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>

                                <div class="my-2 bg-gray-100 p-2 rounded" v-if="task.comments.length">
                                    <div class="flex justify-between ml-3 text-sm text-gray-600 p-2 bg-white border border-gray-300 mb-1 rounded" v-for="comment in task.comments" :key="comment.id">
                                        <p>{{ comment.content }}</p>
                                        <button @click="destroyComment(comment.id)" class="btn-danger">X</button>
                                    </div>
                                </div>

                                <textarea v-model="formComment.content" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                <button class="btn-primary mb-2" @click="saveComment(task.id)">Save</button>
                                
                            </div>
                            <div class="flex justify-between mt-4">
                                <div>
                                    <button @click="toggleAccordion(task.id)" class="btn-secondary mr-2">Comment <span class="bg-red-500 text-white text-xs px-1 rounded">{{ task.comments.length }}</span></button>
                                    <Link :href="`/task/${task.id}/edit`" class="btn-info">Edit</Link>
                                </div>
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
