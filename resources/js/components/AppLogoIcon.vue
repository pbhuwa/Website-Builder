<template>
    <img src="../../../public/WEBLAB-LOGO.png" alt="WebLab" class="h-8 w-auto" />
</template>
<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>
