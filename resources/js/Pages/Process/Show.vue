<template>
    <Head title="Proceso" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{process.name}}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="pb-3 flex justify-end gap-2" v-if="process.status">
                        <button type="button"  class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="changeStatus(process.id)" >
                            Finalizar
                        </button>
                        <a :href="route('processes.edit', process.id)" class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <IconEdit :size="20" stroke-width="2"/>
                        </a>
                        <button type="button"  class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="destroy(process.id)">
                            <IconTrash :size="20" stroke-width="2"/>
                        </button>
                    </div>
                    <div class="grid gap-2 md:gap-4 lg:gap-6 shadow border p-4 sm:grid-cols-2 rounded-lg" :class="{ 'bg-slate-50': process.status, 'bg-orange-50': !process.status }">
                        <div>
                            <h2 class="text-lg sm:text-sm  font-semibold text-gray-900">Proceso</h2>
                            <div class="grid md:grid-cols-2 gap-1">
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ process.name }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Radicado: <span class="text-sm text-gray-500 font-normal">{{ process.radicate }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Estado: <span class="text-sm text-gray-500 font-normal"><span v-if="process.status">En proceso</span><span v-else>Finalizado</span></span></h3>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Descripción</h3>
                                    <p class="text-sm text-gray-500 font-normal">{{ process.description }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-sm font-semibold text-gray-900">Cliente</h2>
                            <div class="grid md:grid-cols-2">
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ process.people.name }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Identificación: <span class="text-sm text-gray-500 font-normal">{{ process.people.nit }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Teléfono: <span class="text-sm text-gray-500 font-normal">{{ process.people.phone }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Correo: <span class="text-sm text-gray-500 font-normal">{{ process.people.email }}</span></h3>
                                </div>
                                <div class="col-span-1">
                                    <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Dirección</h3>
                                    <p class="text-sm text-gray-500 font-normal">{{ process.people.address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <HeaderTable route_to="stages.create" :route_to_id="process.id" :getData="getData"  class="mt-4" v-if="process.status"/>
                    <div class="grid gap-3 w-full mt-4" v-if="stages.data.length != 0">
                        <a class="grid gap-1 shadow border p-4 sm:grid-cols-2 lg:grid-cols-4 rounded-lg cursor-pointer"  v-for="stage in stages.data" :key="stage.id" :class="{ 'bg-slate-50 hover:bg-slate-100': stage.status, 'bg-orange-50 hover:bg-orange-100': !stage.status }" :href="route('stages.show', stage.id)" >
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ stage.name }}</span></h3>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Etapa: <span class="text-sm text-gray-500 font-normal">{{ stage.type_stage.name }}</span></h3>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Estado: <span class="text-sm text-gray-500 font-normal"><span v-if="stage.status">En proceso</span><span v-else>Finalizado</span></span></h3>
                            </div>
                            <div class="sm:col-span-2 lg:col-span-4">
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Descripción: <span class="text-sm text-gray-500 font-normal">
                                    {{ stage.description }}
                                </span></h3>
                            </div>
                        </a>
                    </div>
                    <div class="grid gap-3 w-full mt-4" v-else>
                        <a class="shadow border p-4 rounded-lg cursor-pointer" :href="route('stages.create', process.id)"> 
                            <div class="grid place-content-center w-full">
                                <p class="text-lg sm:text-sm font-semibold text-gray-500">No hay etapas registradas. <span class="text-sm text-gray-500 font-normal">Click aquí para crear una</span></p>
                                <IconCirclePlus class="w-full grid place-content-center text-gray-300" :size="70" stroke-width="1"/>
                            </div>
                        </a>
                    </div>
                    <Pagination :data="stages" :getData="getData" v-if="stages.data.length != 0"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import HeaderTable from '@/Components/HeaderTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { IconEdit, IconArrowLeft, IconTrash, IconCirclePlus} from '@tabler/icons-vue';
import Pagination from '@/Components/Pagination.vue';
import Swal from 'sweetalert2';
import { Head, usePage, router } from '@inertiajs/vue3';

defineProps({
    process: {
        type: Object,
    },
    stages: {
        type: Object,
    }
});

const stages = usePage().props.stages;
const process = usePage().props.process;


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

const changeStatus = (id) => {
    router.visit(route('processes.changeStatus', id),{
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
                title: 'Proceso finalizado'
            })
        }
    });
}



function getData(sort = '', per_page = '', page = '', search = '', direction = '') {
    const url = new URL(window.location.href)
    direction = direction != '' ? direction : url.searchParams.get('direction');
    sort = sort != '' ? sort : url.searchParams.get('sort');
    per_page = per_page != '' ? per_page : url.searchParams.get('per_page');
    page = page != '' ? page : stages.last_page > url.searchParams.get('page') ? url.searchParams.get('page') : 1;
    search = search != '' ? search : url.searchParams.get('search');
    console.log(direction, sort, per_page, page, search);

    let data = {};
    if (search && per_page && sort && direction && page) data = { search: search, per_page: per_page, sort: sort, direction: direction, page: page, }
    else if (search && per_page && sort && direction) data = { search: search, per_page: per_page, sort: sort, direction: direction, }
    else if (sort && direction && per_page && page) data = { sort: sort, direction: direction, per_page: per_page, page: page, }
    else if (search && per_page && page) data = { search: search, per_page: per_page, page: page, }
    else if (search && per_page) data = { search: search, per_page: per_page, }
    else if (per_page && page) data = { per_page: per_page, page: page }
    else if (sort && direction && per_page) data = { sort: sort, direction: direction, per_page: per_page, }
    else if (sort && direction && search) data = { sort: sort, direction: direction, per_page: per_page, }
    else if (sort && direction) data = { sort: sort, direction: direction, }
    else if (per_page) data = { per_page: per_page, }
    else if (search) data = { search: search, }
    else if (page) data = { page: page, }


    if (data) {
        router.visit(route('processes.show',process.id), {
            replace: true,
            preserveScroll: true,
            only: ['stages'],
            data: data,
        });
    } else {
        router.visit(route('processes.show',process.id), {
            replace: true,
            preserveScroll: true,
            only: ['stages'],
        });
    }
}


</script>

<style>

</style>