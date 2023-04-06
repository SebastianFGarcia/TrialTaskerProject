<template>
    <Head title="Editar Proceso" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Proceso</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form class="grid gap-2 md:gap-4 lg:gap-6 md:grid-cols-2">
                        <div class="flex flex-col w-full gap-4 border-r-2">
                            <div>
                                <InputLabel for="name" value="Nombre:" />
                                <TextInput id="name" type="text" placeholder="Nombre del proceso" class="w-full md:w-10/12"
                                    v-model="form.name" autofocus />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="radicate" value="Radicado:" />
                                <TextInput id="radicate" type="text" placeholder="Radicado del proceso"
                                    class="w-full md:w-10/12" v-model="form.radicate" />
                                <InputError :message="form.errors.radicate" />
                            </div>
                            <div>
                                <InputLabel for="description" value="Descripción:" />
                                <TextAreaInput id="description" placeholder="Descripción del proceso"
                                    class="w-full md:w-10/12" rows="5" v-model="form.description" />
                                <InputError :message="form.errors.description" />
                            </div>
                        </div>
                        <div class="flex flex-col w-full gap-2">
                            <div>
                                <InputLabel for="search" value="Buscar cliente:" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <input type="search" id="search" class="block w-full  pl-10 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ingrese el numero de documento" v-model="search" />
                                    <button type="button" class="text-white absolute right-1 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1" @click="searchPeople">Buscar</button>
                                </div>
                                <InputError :message="form.errors.people_id" />
                            </div>
                            <div>
                                <InputLabel for="people_name" value="Nombre:" />
                                <TextInput id="people_name" type="text" placeholder="Nombre del cliente"
                                    class="w-full md:w-10/12" v-model="form.people_name" v-bind:disabled="actionsClient" />
                                <InputError :message="form.errors.people_name"/>
                            </div>
                            <div>
                                <InputLabel for="people_nit" value="Nit:" />
                                <TextInput id="people_nit" type="text" placeholder="Nit del cliente" class="w-full md:w-10/12"
                                    v-model="form.people_nit" v-bind:disabled="actionsClient"/>
                                <InputError :message="form.errors.people_nit" />
                            </div>
                            <div>
                                <InputLabel for="people_email" value="Email:" />
                                <TextInput id="people_email" type="text" placeholder="Email del cliente"
                                    class="w-full md:w-10/12" v-model="form.people_email" v-bind:disabled="actionsClient"/>
                                <InputError :message="form.errors.people_email" />
                            </div>
                            <div>
                                <InputLabel for="people_phone" value="Teléfono:" />
                                <TextInput id="people_phone" type="text" placeholder="Teléfono del cliente"
                                    class="w-full md:w-10/12" v-model="form.people_phone" v-bind:disabled="actionsClient"/>
                                <InputError :message="form.errors.people_phone" />
                            </div>
                            <div>
                                <InputLabel for="people_address" value="Dirección:" />
                                <TextInput id="people_address" type="text" placeholder="Dirección del cliente"
                                    class="w-full md:w-10/12" v-model="form.people_address" v-bind:disabled="actionsClient"/>
                                <InputError :message="form.errors.people_address" />
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" @click="actionsClient = false " v-if="form.people_id" :class="{ 'opacity-25': actionsClient == false }" :disabled="actionsClient == false">Habilitar editar</button>
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" @click="update" v-else>Habilitar crear</button>

                            </div>
                        </div>
                        <div class="flex justify-end w-full md:w-10/12">
                            <SecondaryButton @click="save" :disabled="form.processing"> Actualizar </SecondaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, usePage, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2'

defineProps({
    people: {
        type: Object,
        default: null,
    },
    process: {
        type: Object,
        default: null,
    },
});

const people = usePage().props.people;
const process = usePage().props.process;
const actionsClient = ref(true);
const search = ref('');

const form = useForm({
    name: process.name,
    radicate: process.radicate,
    description: process.description,
    people_id: process.people_id,
    people_name: process.people.name,
    people_nit: process.people.nit,
    people_email: process.people.email,
    people_phone: process.people.phone,
    people_address: process.people.address,
    update: false,
});


const searchPeople = () => {
    if (search.value.length > 0) {
        const client = people.find((client) => client.nit == search.value);
        if (client) {
            form.people_id = client.id;
            form.people_name = client.name;
            form.people_nit = client.nit;
            form.people_email = client.email;
            form.people_phone = client.phone;
            form.people_address = client.address;
            actionsClient.value = true;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Cliente no encontrado',
                text: '¿Desea habilitar los campos para crear un nuevo cliente?',
                confirmButtonText: 'Si',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    actionsClient.value = false;
                }
            });
            form.people_id = '';
            form.people_name = '';
            form.people_nit = '';
            form.people_email = '';
            form.people_phone = '';
            form.people_address = '';
        }
    }
};

const update = () => {
    form.update = true;
    actionsClient.value = false;
};



const save = () => {
    form.put(route('processes.update', process.id), {
        preserveScroll: true,
    });
};

</script>

<style></style>