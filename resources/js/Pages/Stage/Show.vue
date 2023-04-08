<template>
    <Head title="etapa" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ stage.name }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="pb-3 flex justify-end gap-2" v-if="stage.status">
                        <button type="button"  class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="changeStatus(stage.id)" >
                            Finalizar
                        </button>
                        <a :href="route('stage.edit', stage.id)" class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <IconEdit :size="20" stroke-width="2"/>
                        </a>
                        <button type="button"  class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="destroy(stage.id)">
                            <IconTrash :size="20" stroke-width="2"/>
                        </button>
                    </div>
                    <div class="shadow border p-4 sm:grid-cols-2 rounded-lg"
                        :class="{ 'bg-slate-50': stage.status, 'bg-orange-50': !stage.status }">

                        <h2 class="text-md sm:text-sm  font-semibold text-gray-900">Etapa</h2>
                        <div class="grid gap-1">
                            <div class="col-span-1">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Nombre: <span
                                        class="text-sm text-gray-500 font-normal">{{ stage.name }}</span></h3>
                            </div>
                            <div class="col-span-1">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Estado: <span
                                        class="text-sm text-gray-500 font-normal"><span v-if="stage.status">En
                                            proceso</span><span v-else>Finalizado</span></span></h3>
                            </div>
                            <div class="col-span-1">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Fecha: <span
                                        class="text-sm text-gray-500 font-normal">{{ stage.procedure_date }}</span></h3>
                            </div>
                            <div class="col-span-1 sm:col-span-3">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Descripción: <span class="text-sm text-gray-500 font-normal">{{ stage.description }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import HeaderTable from '@/Components/HeaderTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { IconEdit, IconArrowLeft, IconTrash, IconCirclePlus } from '@tabler/icons-vue';
import Pagination from '@/Components/Pagination.vue';
import Swal from 'sweetalert2';
import { Head, usePage, router } from '@inertiajs/vue3';

defineProps({
    stage: {
        type: Object,
        default: null,
    }
});


const changeStatus = (id) => {
    Swal.fire({
        title: '¿Estas seguro de finalizar la etapa?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Finalizar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.visit(route('stage.changeStatus', id),{
                method: 'PUT',
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
                        title: 'Etapa finalizada'
                    })
                }
            });
        }
    })
}

const destroy = (id) => {
    Swal.fire({
        title: '¿Estas seguro de eliminar la etapa?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.visit(route('stage.destroy', id),{
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
                        title: 'Etapa eliminada'
                    })
                }
            });
        }
    })
}


</script>

<style></style>