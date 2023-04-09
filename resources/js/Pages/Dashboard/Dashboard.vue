<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import Sessions from './Partials/Sessions.vue';


defineProps({
    sessions: {
        type: Array,
    },
    sessionsActive: {
        type: Object,
    },
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Sessions :sessions="sessions" :sessionsActive="sessionsActive" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
