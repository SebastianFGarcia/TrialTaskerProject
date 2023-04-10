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
                    <div class="shadow border my-2 p-4 sm:grid-cols-2 rounded-lg"
                        :class="{ 'bg-slate-50': stage.status, 'bg-orange-50': !stage.status }">

                        <h2 class="text-md sm:text-sm  font-semibold text-gray-900">Etapa</h2>
                        <div class="grid gap-1">
                            <div class="col-span-1">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Nombre: <span
                                        class="text-sm text-gray-500 font-normal">{{ stage.name }}</span></h3>
                            </div>
                            <div class="col-span-1">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Tipo: <span
                                        class="text-sm text-gray-500 font-normal">{{ stage.type_stage.name }}</span></h3>
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
                            <div class="col-span-1 sm:col-span-2 md:col-span-4">
                                <h3 class="text-md sm:text-sm font-semibold text-gray-900">Descripción: <span class="text-sm text-gray-500 font-normal">{{ stage.description }}</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="shadow border my-2 p-4 sm:grid-cols-2 rounded-lg" v-for="person in stage.people">
                        <h2 class="text-md sm:text-sm  font-semibold text-gray-900">{{ person.type_people.name }}</h2>
                        <div class="grid gap-1 sm:grid-cols-2 lg:grid-cols-3">
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ person.name }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900">Documento de identidad: <span class="text-sm text-gray-500 font-normal">{{ person.nit }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.issue_nit">Fecha de expedición: <span class="text-sm text-gray-500 font-normal">{{ person.issue_nit }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900">Correo electrónico: <span class="text-sm text-gray-500 font-normal">{{ person.email }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.phone">Teléfono: <span class="text-sm text-gray-500 font-normal">{{ person.phone }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.authority">Numero de autoridad: <span class="text-sm text-gray-500 font-normal">{{ person.authority }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.num_dispach">Numero de despacho: <span class="text-sm text-gray-500 font-normal">{{ person.num_dispach }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.num_ministry">Numero de ministerio: <span class="text-sm text-gray-500 font-normal">{{ person.num_ministry }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.number">Numero: <span class="text-sm text-gray-500 font-normal">{{ person.number }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.radicated">Radicado: <span class="text-sm text-gray-500 font-normal">{{ person.radicated }}</span></h3>
                            <h3 class="text-md sm:text-sm font-semibold text-gray-900" v-if="person.address">Dirección: <span class="text-sm text-gray-500 font-normal">{{ person.address }}</span></h3>
                        </div>
                    </div>
                    <div class="shadow border my-2 p-4 sm:grid-cols-2 rounded-lg" v-for="file in stage.files">
                        <a :href="file.url" target="_blank" class="text-md sm:text-sm w-full  font-semibold text-gray-900">
                            <p>{{ file.name }}</p>
                        </a>
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

const stage = usePage().props.stage;


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