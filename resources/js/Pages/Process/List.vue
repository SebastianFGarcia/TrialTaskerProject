<template>
    <Head title="Procesos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Procesos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <HeaderTable route_to="processes.create" :getData="getData" />
                    <div class="grid gap-3 w-full" v-if="processes.data.length != 0">
                        <a class="grid gap-1 shadow border p-4 sm:grid-cols-2 lg:grid-cols-4 rounded-lg cursor-pointer" v-for="process in processes.data" :key="process.id" :class="{ 'bg-slate-50 hover:bg-slate-100': process.status, 'bg-orange-50 hover:bg-orange-100': !process.status }" :href="route('processes.show', process.id)">
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Nombre: <span class="text-sm text-gray-500 font-normal">{{ process.name }}</span></h3>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Cliente: <span class="text-sm text-gray-500 font-normal">{{ process.people.name }}</span></h3>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Radicado: <span class="text-sm text-gray-500 font-normal">{{ process.radicate }}</span></h3>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Estado: <span class="text-sm text-gray-500 font-normal"><span v-if="process.status">En proceso</span><span v-else>Finalizado</span></span></h3>
                            </div>
                            <div class="sm:col-span-2 lg:col-span-4">
                                <h3 class="text-lg sm:text-sm font-semibold text-gray-900">Descripción: <span class="text-sm text-gray-500 font-normal">{{ process.description }}
                                </span></h3>
                                
                            </div>
                        </a>
                    </div>
                    <div class="grid gap-3 w-full mt-4" v-else>
                        <a class="shadow border p-4 rounded-lg cursor-pointer" :href="route('processes.create')"> 
                            <div class="grid place-content-center w-full">
                                <p class="text-lg sm:text-sm font-semibold text-gray-500">No hay procesos registrados. <span class="text-sm text-gray-500 font-normal">Click aquí para crear uno</span></p>
                                <IconCirclePlus class="w-full grid place-content-center text-gray-300" :size="70" stroke-width="1"/>
                            </div>
                        </a>
                    </div>
                    <Pagination :data="processes" :getData="getData" v-if="processes.data.length != 0" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { IconEdit, IconArrowLeft, IconTrash, IconCirclePlus} from '@tabler/icons-vue';
import Pagination from '@/Components/Pagination.vue';
import HeaderTable from '@/Components/HeaderTable.vue';
import { Head, usePage, router } from '@inertiajs/vue3';

defineProps({
    processes: {
        type: Object,
    }
});

const processes = usePage().props.processes;


function getData(sort = '', per_page = '', page = '', search = '', direction = '') {
    const url = new URL(window.location.href)
    direction = direction != '' ? direction : url.searchParams.get('direction');
    sort = sort != '' ? sort : url.searchParams.get('sort');
    per_page = per_page != '' ? per_page : url.searchParams.get('per_page');
    page = page != '' ? page : processes.last_page > url.searchParams.get('page') ? url.searchParams.get('page') : 1;
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
        router.visit('processes', {
            replace: true,
            preserveScroll: true,
            only: ['processes'],
            data: data,
        });
    } else {
        router.visit('processes', {
            replace: true,
            preserveScroll: true,
            only: ['processes'],
        });
    }
}

</script>

<style></style>