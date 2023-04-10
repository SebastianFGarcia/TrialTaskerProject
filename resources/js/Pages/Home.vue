<template>
  <Head title="Inicio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid w-full md:grid-cols-2 place-items-center gap-2 p-6 sm:px-20 bg-white  border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl leading-tight text-gray-800">
                                Bienvenido a nuestra aplicación de gestión de procesos de abogados. Simplifique su trabajo diario y aumente la productividad de su equipo con nuestra herramienta fácil de usar.
                            </h2>
                            <p class="mt-2"> TrialTasker es una herramienta poderosa para abogados que permite manejar y organizar sus casos de manera eficiente, ahorrando tiempo y dinero.</p>
                            <div class="flex justify-center mt-4">
                                <a :href="route('processes')">
                                    <SecondaryButton>
                                        Ver procesos
                                    </SecondaryButton>
                                </a>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <Amico class="w-72 sm:w-96 h-w-72 sm:h-96" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Amico from '@/Components/svg/Amico.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
</script>

<style>

</style>