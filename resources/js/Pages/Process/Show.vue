<template>
    <Head title="Proceso" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{process.name}}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="pb-3 flex justify-end gap-2">
                        <a :href="route('processes.edit', process.id)" class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <IconEdit :size="20" stroke-width="2"/>
                        </a>
                        <button type="button"  class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="destroy(process.id)">
                            <IconTrash :size="20" stroke-width="2"/>
                        </button>
                    </div>
                    <div class="grid gap-2 md:gap-4 lg:gap-6 shadow border p-4 sm:grid-cols-2 rounded-lg" :class="{ 'bg-slate-50': process.status, 'bg-orange-50': !process.status }">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Proceso</h2>
                            <div class="grid md:grid-cols-2 gap-1">
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ process.name }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Radicado: <span class="text-sm text-gray-500 font-normal">{{ process.radicate }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Estado: <span class="text-sm text-gray-500 font-normal"><span v-if="process.status">En proceso</span><span v-else>Finalizado</span></span></h3>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <h3 class="text-lg font-semibold text-gray-900">Descripción</h3>
                                    <p class="text-sm text-gray-500 font-normal">{{ process.description }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Cliente</h2>
                            <div class="grid md:grid-cols-2">
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ process.people.name }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Identificación: <span class="text-sm text-gray-500 font-normal">{{ process.people.nit }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Teléfono: <span class="text-sm text-gray-500 font-normal">{{ process.people.phone }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Correo: <span class="text-sm text-gray-500 font-normal">{{ process.people.email }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Dirección</h3>
                                    <p class="text-sm text-gray-500 font-normal">{{ process.people.address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { IconEdit, IconArrowLeft, IconTrash} from '@tabler/icons-vue';
import Pagination from '@/Components/Pagination.vue';
import Swal from 'sweetalert2';
import { Head, usePage, router } from '@inertiajs/vue3';

defineProps({
    process: {
        type: Object,
    }
});

const destroy = (id) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.visit(route('processes.destroy', id),{
                method: 'DELETE',
                onSuccess: () => {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    }).fire({
                        icon: 'success',
                        title: 'Proceso eliminado'
                    })
                }
            });
        }
    })
}


</script>

<style>

</style>