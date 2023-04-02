<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="flex flex-col md:order-last justify-center align-middle">
                <h2 class="text-2xl font-medium text-gray-900">Información de sesiones</h2>
                <p class="mt-1 text-lg text-gray-600">Sessiones con actividad reciente: {{ sessionsActive.lastSessionActive}}</p>
                <p class="mt-1 text-lg text-gray-600">Total de sesiones activas: {{ sessionsActive.allSessionsActive }}</p>
            </div>
            <div class="lg:col-span-2 h-60">
                <Bar :data="chartData" :options="chartOptions" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import { usePage } from '@inertiajs/vue3';


ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);


defineProps({
    sessions: {
        type: Array,
    },
    sessionsActive: {
        type: Object,
    },
});

const sessions = usePage().props.sessions;
const sessionsActive = usePage().props.sessionsActive;

const chartData = {
    labels: sessions.map((session) => session.date),
    datasets: [
        {
            label: 'Sesiones',
            data: sessions.map((session) => session.users_count),
            backgroundColor: '#b1907dd5',
        },
    ],
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: 'Sesiones',
        },
    },
    scales: {
        y: {
            beginAtZero: true,
        },
    },
};

</script>

<style></style>