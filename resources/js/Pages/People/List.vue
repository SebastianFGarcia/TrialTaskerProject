<template>
    <Head title="Personas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Personas</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <HeaderTable :getData="getData" />
                    <Table :data="people.data" :columns="columns" name="people" :edit="openModal" :destroy="destroy"
                        :getData="getData" />
                    <Pagination :data="people" :getData="getData" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="modal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ title }}
            </h2>
            <form @submit.prevent="save">
                <div class="mt-6 grid md:grid-cols-2 gap-2">
                    <div class="">
                        <InputLabel for="name" value="Nombre:" />
                        <TextInput id="name" ref="nameInput" v-model="form.name" type="text"
                            class="mt-1 block w-full" placeholder="Nombre" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="email" value="Correo electrónico:" />
                        <TextInput id="email" ref="emailInput" v-model="form.email" type="email"
                            class="mt-1 block w-full" placeholder="Correo electrónico" />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="type_people_id" value="Tipo de persona:" />
                        <SelectInput id="type_people_id" ref="type_people_id" v-model="form.type_people_id"
                            class="mt-1 block w-full" :options="types" />
                        <InputError :message="form.errors.type_people_id" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="nit" value="Documento de identidad:" />
                        <TextInput id="nit" ref="nitInput" v-model="form.nit" type="text"
                            class="mt-1 block w-full" placeholder="Documento de identidad" />
                        <InputError :message="form.errors.nit" class="mt-2" />
                        <InputError :message="form.errors.document_type_id" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="phone" value="Teléfono:" />
                        <TextInput id="phone" ref="phoneInput" v-model="form.phone" type="text"
                            class="mt-1 block w-full" placeholder="Teléfono" />
                        <InputError :message="form.errors.phone" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="address" value="Dirección:" />
                        <TextInput id="address" ref="addressInput" v-model="form.address" type="text"
                            class="mt-1 block w-full" placeholder="Dirección" />
                        <InputError :message="form.errors.address" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="issue_nit" value="Fecha de expedición de documento:" />
                        <TextInput id="issue_nit" ref="issue_nitInput" v-model="form.issue_nit" type="date"
                            class="mt-1 block w-full" placeholder="Fecha de expedición" />
                        <InputError :message="form.errors.issue_nit" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="num_ministry" value="Número de ministerio:" />
                        <TextInput id="num_ministry" ref="num_ministryInput" v-model="form.num_ministry" type="text"
                            class="mt-1 block w-full" placeholder="Número de ministerio" />
                        <InputError :message="form.errors.num_ministry" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="num_dispach" value="Número de despacho:" />
                        <TextInput id="num_dispach" ref="num_dispachInput" v-model="form.num_dispach" type="text"
                            class="mt-1 block w-full" placeholder="Número de despacho" />
                        <InputError :message="form.errors.num_dispach" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="radicated" value="Radicado:" />
                        <TextInput id="radicated" ref="radicatedInput" v-model="form.radicated" type="text"
                            class="mt-1 block w-full" placeholder="Radicado" />
                        <InputError :message="form.errors.radicated" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="authority" value="Autoridad:" />
                        <TextInput id="authority" ref="authorityInput" v-model="form.authority" type="text"
                            class="mt-1 block w-full" placeholder="Autoridad" />
                        <InputError :message="form.errors.authority" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="number" value="Número:" />
                        <TextInput id="number" ref="numberInput" v-model="form.number" type="text"
                            class="mt-1 block w-full" placeholder="Número" />
                        <InputError :message="form.errors.number" class="mt-2" />
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="save" :disabled="form.processing"> Guardar </SecondaryButton>
                    <SecondaryButton @click="closeModal" :disabled="form.processing"> Cancelar </SecondaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
  
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Table from '@/Components/Table.vue';
import HeaderTable from '@/Components/HeaderTable.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Swal from 'sweetalert2';
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import { ref, nextTick } from 'vue';

const id = ref(null);
const modal = ref(false);
const nameInput = ref(null);
const title = ref(null);
const operacion = ref(null);

const props = defineProps({
    people: {
        type: Object
    },
    types: {
        type: Object
    }
})

const people = usePage().props.people;
const types = usePage().props.types;
console.log(people);


const columns = [
    {
        name: 'Nombre',
        key: 'name',
    },
    {
        name: 'Correo',
        key: 'email',
    },
    {
        name: 'Teléfono',
        key: 'phone',
    },
    {
        name: 'Dirección',
        key: 'address',
    },
    {
        name: 'Documento de identidad',
        key: 'nit',
    },
    {
        name: 'Fecha de expedición',
        key: 'issue_nit',
    },
    {
        name: 'Tipo de persona',
        key: 'type_people_id',
        key_2: {
            name: 'name',
            key: 'type_people'
        }
    }
]

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    nit: '',
    issue_nit: '',
    num_ministry: '',
    num_dispach: '',
    radicated: '',
    authority: '',
    number: '',
    type_people_id: '',
});


const openModal = (op, param) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operacion.value = op;
    if (op == 1) {
        title.value = 'Crear persona';
    } else {
        title.value = 'Editar persona';
        id.value = param.id;
        form.name = param.name;
        form.email = param.email;
        form.phone = param.phone;
        form.address = param.address;
        form.nit = param.nit;
        form.issue_nit = param.issue_nit;
        form.num_ministry = param.num_ministry;
        form.num_dispach = param.num_dispach;
        form.radicated = param.radicated;
        form.authority = param.authority;
        form.number = param.number;
        form.type_people_id = param.type_people_id;
    }
}

const closeModal = () => {
    modal.value = false;
    form.reset();
    form.clearErrors();
}

const save = () => {
    if (operacion.value == 1) {
        form.post(route('people.store'), {
            preserveScroll: true,
            onSuccess: () => {
                ok('Persona creada');
                getData();
            }
        });
    } else {
        id.value = id.value;
        form.put(route('people.update', id.value), {
            preserveScroll: true,
            onSuccess: () => {
                ok('Persona actualizada');
                getData();
            },
        });
    }
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})


const ok = (message) => {
    closeModal();
    form.reset();
    Toast.fire({
        icon: 'success',
        title: message
    })
}

const destroy = (id) => {
    Swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Bórralo!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(route('people.destroy', id))
                .then((response) => {
                    getData();
                    Toast.fire({
                        icon: 'success',
                        title: 'Persona eliminada'
                    })
                })
        }
    })
}

function getData(sort = '', per_page = '', page = '', search = '', direction = '') {

    const url = new URL(window.location.href)
    direction = direction != '' ? direction : url.searchParams.get('direction');
    sort = sort != '' ? sort : url.searchParams.get('sort');
    per_page = per_page != '' ? per_page : url.searchParams.get('per_page');
    page = page != '' ? page : people.last_page > url.searchParams.get('page') ? url.searchParams.get('page') : 1;
    search = search != '' ? search : url.searchParams.get('search');

    let data = {};
    if (search && per_page && sort && direction && page) data = {search: search,per_page: per_page,sort: sort,direction: direction,page: page,}
    else if (search && per_page && sort && direction)data = {search: search,per_page: per_page,sort: sort,direction: direction,}
    else if (sort && direction && per_page && page) data = {sort: sort,direction: direction,per_page: per_page,page: page,}
    else if (search && per_page && page) data = {search: search,per_page: per_page,page: page,} 
    else if (search && per_page) data = {search: search,per_page: per_page,}
    else if (sort && direction && page) data = {sort: sort,direction: direction,page: page,}
    else if (sort && direction && per_page) data = {sort: sort,direction: direction,per_page: per_page,}
    else if (sort && direction && search) data = {sort: sort,direction: direction,per_page: per_page,}
    else if (sort && direction) data = {sort: sort,direction: direction,}
    else if (per_page) data = {per_page: per_page,}
    else if (search) data = {search: search,}
    else if (page) data = {page: page,}


    if (data) {
        router.visit('people', {
            replace: true,
            preserveScroll: true,
            only: ['people'],
            data: data,
        });
    } else {
        router.visit('people', {
            replace: true,
            preserveScroll: true,
            only: ['people'],
        });
    }
}

</script>
  