<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <CanvasWorkspace></CanvasWorkspace>
    </AppLayout>
</template>
<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head } from '@inertiajs/vue3';
    import CanvasWorkspace from '@/components/CanvasWorkspace.vue';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'WorkSpace',
            href: '/dashboard',
        },
    ];
</script>
