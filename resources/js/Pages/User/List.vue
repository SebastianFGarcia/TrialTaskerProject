<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <HeaderTable route_to="users" :only="['users']"/>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-5">
                                <tr class="border">
                                    <th scope="col" class="px-4 py-2 ">
                                        <div class="flex items-center justify-between">
                                            Nombre
                                            <a @click="orderList('name')"><IconArrowsSort :size="17"/></a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        <div class="flex items-center justify-between">
                                            Correo Electronico
                                            <a @click="orderList('email')"><IconArrowsSort :size="17"/></a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        <div class="flex items-center justify-between">
                                            Telefono
                                            <a @click="orderList('phone')"><IconArrowsSort :size="17"/></a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-2">
                                        <div class="flex items-center justify-between">
                                            Dirección
                                            <a @click="orderList('address')"><IconArrowsSort :size="17"/></a>
                                        </div>
                                    </th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b " v-for="user in users.data" :key="user.id">
                                    <td class=" px-4 py-2">{{ user.name }}</td>
                                    <td class=" px-4 py-2">{{ user.email }}</td>
                                    <td class=" px-4 py-2">{{ user.phone }}</td>
                                    <td class=" px-4 py-2">{{ user.address }}</td> 
                                    <td class=" px-4 py-2 flex justify-center content-center">
                                        <Checkbox name="is_active" :checked="user.is_active==1 ? true : false" @change="changeStatus(user.id)"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="users"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import HeaderTable from '@/Components/HeaderTable.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, usePage, router  } from '@inertiajs/vue3';
import { IconArrowsSort } from '@tabler/icons-vue';
import { ref } from 'vue';
import Swal from 'sweetalert2'

defineProps({
    users: {
        type: Object,
    },
});

const users = usePage().props.users;

function orderList(name) {
    const url = new URL(window.location.href)
    const direction = ref(url.searchParams.get('direction') == 'asc' ? 'desc' : 'asc');
    const per_page = url.searchParams.get('per_page');
    getData(name, direction.value, per_page,'');
}

function getData(sort='', direction='', per_page='',page='') {
    if (sort && direction && per_page && page) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                sort: sort,
                direction: direction,
                per_page: per_page,
                page: page,
            },
        });
    } else if (sort && direction && per_page) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                sort: sort,
                direction: direction,
                per_page: per_page,
            },
        });
    } else if (sort && direction) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                sort: sort,
                direction: direction,
            },
        });
    } else if (per_page) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                per_page: per_page,
            },
        });
    } else {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
        });
    }
}



function changeStatus(id) {
    Swal.fire({
        title: '¿Estas seguro de desactivar este usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cambiar!'
    }).then(async(result) => {
        const url = new URL(window.location.href)
        const direction = ref(url.searchParams.get('direction'));
        const per_page = url.searchParams.get('per_page');
        const page = url.searchParams.get('page');
        const sort = url.searchParams.get('sort');
        if (result.isConfirmed) {
            router.patch(route('users.update', id), {
                preserveScroll: true,
                only: ['users'],
                onSuccess: () => {
                    Swal.fire(
                        'Cambiado!',
                        'El usuario ha sido desactivado.',
                        'success'
                    )
                    getData(sort, direction.value, per_page,page);
                },
                onError: () => {
                    Swal.fire(
                        'Error!',
                        'El usuario no ha sido desactivado.',
                        'error'
                    )
                }
            });
        } else {
            getData(sort, direction.value, per_page,page);
        }
    })
}
</script>

<style></style>