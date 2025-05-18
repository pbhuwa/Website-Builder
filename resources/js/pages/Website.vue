<template>
    <Head title="Website" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <WebsiteList></WebsiteList>
    </AppLayout>
</template>
<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head, usePage } from '@inertiajs/vue3';
    import WebsiteList from '@/components/WebsiteList.vue';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Websites',
            href: '/websites',
        },
    ];
</script>
