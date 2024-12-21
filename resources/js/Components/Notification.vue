<script setup>
import { onMounted, ref, watch} from 'vue';

const props = defineProps({
    message: String,
    required: true,
});

const show = ref(props.message ? true : false);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 3000);
});

watch(() => props.message, () => {
    show.value = true;

    setTimeout(() => {
        show.value = false;
    }, 3000);
});
</script>

<template>
    <div
        class="fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-lg rounded-md"
        :class="{ 'hidden': !show }"
    >
        <div class="flex justify-between">
            <p class="font-bold">Notification</p>
        </div>
        <p>{{ message }}</p>
    </div>
</template>