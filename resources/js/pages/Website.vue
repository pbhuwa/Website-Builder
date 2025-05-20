<template>
    <Head title="Website" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <WebsiteList></WebsiteList>
    </AppLayout>
</template>
<script setup lang="ts">
import WebsiteList from '@/components/WebsiteList.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Websites',
        href: '/websites',
    },
];
</script>
