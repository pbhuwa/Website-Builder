<template>
    <div v-show="message">
        <p class="text-sm text-red-600 dark:text-red-500">
            {{ message }}
        </p>
    </div>
</template>
<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>
