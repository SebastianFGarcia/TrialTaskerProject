<template>
  <Head title="Tipo de Personas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tipo de Personas</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <HeaderTable :getData="getData" :create="openModal"/>
                    <Table :data="typePeople.data" :columns="columns" name="typePeople" :edit="openModal" :destroy="destroy" :getData="getData"/>
                    <Pagination :data="typePeople"  :getData="getData"/>
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
                <div class="mt-6 ">
                    <InputLabel for="name" value="Nombre:" />
                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-full sm:w-3/4" placeholder="Nombre" />
                    <InputError :message="form.errors.name" class="mt-2" />
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
import Swal from 'sweetalert2';
import { Head, usePage, useForm, router} from '@inertiajs/vue3';
import { ref, nextTick } from 'vue';

const id = ref(null);
const modal = ref(false);
const nameInput = ref(null);
const title = ref(null);
const operacion = ref(null);

const props = defineProps({
    typePeople: {
        type: Object
    },
})

const typePeople = usePage().props.typePeople;

const columns = [
    {
        name: 'Nombre',
        key: 'name',
    }
]

const form = useForm({
    name: '',
});


const openModal = (op,param) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operacion.value = op;
    if(op == 1) {
        title.value = 'Crear Tipo de Persona';
    } else {
        title.value = 'Editar Tipo de Persona';
        id.value = param.id;
        form.name = param.name;
    }
}

const closeModal = () => {
    modal.value = false;
    form.reset();
    form.errors = {};
}

const save = () => {
    if(operacion.value == 1) {
        form.post(route('typePeople.store'),{
            preserveScroll: true,
            onSuccess: () => {
                ok('Tipo de Persona Creado');
                getData();
            }
        });
    } else {
        form.patch(route('typePeople.update', id.value),{
            preserveScroll: true,
            onSuccess: () => {
                ok('Tipo de Persona Actualizado');
                getData();
            }
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
            axios.delete(route('typePeople.destroy', id))
            .then((response) => {
                getData();
                Toast.fire({
                    icon: 'success',
                    title: 'Tipo de Persona Eliminado'
                })
            })
        }
    })
}

function getData(sort='', per_page='', page='', search='', direction='') {

    const url = new URL(window.location.href)
    direction = direction!='' ? direction : url.searchParams.get('direction');
    sort = sort!='' ? sort : url.searchParams.get('sort');
    per_page = per_page!='' ? per_page : url.searchParams.get('per_page');
    page = page!='' ? page : typePeople.last_page>url.searchParams.get('page') ? url.searchParams.get('page') : 1;
    search = search!='' ? search : url.searchParams.get('search');

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
        router.visit('typePeople', {
            replace: true,
            preserveScroll: true,
            only: ['typePeople'],
            data: data,
        });
    } else {
        router.visit('typePeople', {
            replace: true,
            preserveScroll: true,
            only: ['typePeople'],
        });
    }
}

</script>
