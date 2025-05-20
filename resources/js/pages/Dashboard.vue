<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <CanvasWorkspace></CanvasWorkspace>
    </AppLayout>
</template>
<script setup lang="ts">
import CanvasWorkspace from '@/components/CanvasWorkspace.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'WorkSpace',
        href: '/dashboard',
    },
];
</script>
