<template>
    <Head title="Editar etapa" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar etapa</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form class="grid gap-2 md:gap-4 lg:gap-6 md:grid-cols-2">
                        <div class="flex flex-col w-full gap-4 md:border-r-2 ">
                            <div class="flex flex-col w-full gap-2">
                                <InputLabel for="type_stage_id" value="Seleccione la etapa:" />
                                <SelectInput id="type_stage_id" v-model="form.type_stage_id" class="w-full md:w-10/12" :options="types"/>
                                <InputError :message="form.errors.type_stage_id" />
                            </div>
                            <div>
                                <InputLabel for="name" value="Nombre:" />
                                <TextInput id="name" type="text"  class="w-full md:w-10/12" v-model="form.name" autofocus placeholder="Nombre del procedimiento" />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="procedure_date" value="Fecha:" />
                                <TextInput id="procedure_date" type="date" class="w-full md:w-10/12" v-model="form.procedure_date" />
                                <InputError :message="form.errors.procedure_date" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Descripción:" />
                                <TextAreaInput id="description" placeholder="Descripción del proceso"
                                    class="w-full md:w-10/12" rows="5" v-model="form.description" />
                                <InputError :message="form.errors.description" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-end w-full">
                                <SecondaryButton @click="openModal" :disabled="form.processing"> Agregar persona
                                </SecondaryButton>
                            </div>
                            <div class="flex flex-col w-full gap-2">
                                <div class="p-2 sm:p-3 bg-gray-50 shadow sm:rounded-lg" v-for=" (person,index) in groupPeople">
                                    <div class="flex justify-between gap-2 text-sm">
                                        <p><span v-if="person.type">{{person.type}}</span><span v-else>{{ person.type_people.name }}</span> {{ person.name }}</p>
                                        <div class="flex gap-2">
                                            <button type="button" @click="editPerson(person)"
                                                class="text-blue-600 font-medium text-sm py-1">
                                                <IconEdit :size="16" />
                                            </button>
                                            <button type="button" @click="removePerson(index)"
                                                class="text-red-600 font-medium text-sm ">
                                                <IconTrash :size="16" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end w-full">
                                <button  @click="openFile" id="upload_widget" class="cloudinary-button">
                                    Cargar archivos
                                </button>
                            </div>
                            <div class="flex flex-col w-full gap-2">
                                <div class="p-2 sm:p-3 bg-gray-50 shadow sm:rounded-lg" v-for=" (file,index) in groupFiles">
                                    <div class="flex justify-between gap-2 text-sm">
                                        <a :href="file.url" target="_blank"><span v-if="file.name">{{ file.name }}</span><span v-else>{{ file.original_filename }}</span></a>
                                        <div class="flex gap-2" >
                                            <button type="button" @click="removeFile(index)"
                                                class="text-red-600 font-medium text-sm ">
                                                <IconTrash :size="16" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end w-full md:w-10/12">
                            <SecondaryButton @click="update" :disabled="form.processing"> Actualizar </SecondaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>   
    <Modal :show="modal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Buscar personas
            </h2>
            <form @submit.prevent="save">
                <div class="mt-6 grid md:grid-cols-2 gap-2">
                    <div class="col-span-1 md:col-span-2">
                        <InputLabel for="search" value="Buscar persona:" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="search" id="search"
                                class="block w-full  pl-10 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Ingrese el numero de documento" v-model="search" ref="searchInput"/>
                            <button type="button"
                                class="text-white absolute right-1 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1"
                                @click="searchPeople">Buscar</button>
                        </div>
                    </div>
                    <div class="">
                        <InputLabel for="name" value="Nombre:" />
                        <TextInput id="name" v-model="formPeople.name" type="text" class="mt-1 block w-full"
                            placeholder="Nombre" v-bind:disabled="!actionsPeople" />
                        <InputError :message="formPeople.errors.name" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="email" value="Correo electrónico:" />
                        <TextInput id="email" ref="emailInput" v-model="formPeople.email" type="email"
                            class="mt-1 block w-full" placeholder="Correo electrónico" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.email" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="type_people_id" value="Tipo de persona:" />
                        <SelectInput id="type_people_id" ref="type_people_id" v-model="formPeople.type_people_id"
                            class="mt-1 block w-full" :options="types_people"  v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.type_people_id" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="nit" value="Documento de identidad:" />
                        <TextInput id="nit" ref="nitInput" v-model="formPeople.nit" type="text" class="mt-1 block w-full"
                            placeholder="Documento de identidad" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.nit" class="mt-2" />
                        <InputError :message="formPeople.errors.document_type_id" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="phone" value="Teléfono:" />
                        <TextInput id="phone" ref="phoneInput" v-model="formPeople.phone" type="text"
                            class="mt-1 block w-full" placeholder="Teléfono" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.phone" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="address" value="Dirección:" />
                        <TextInput id="address" ref="addressInput" v-model="formPeople.address" type="text"
                            class="mt-1 block w-full" placeholder="Dirección" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.address" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="issue_nit" value="Fecha de expedición de documento:" />
                        <TextInput id="issue_nit" ref="issue_nitInput" v-model="formPeople.issue_nit" type="date"
                            class="mt-1 block w-full" placeholder="Fecha de expedición" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.issue_nit" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="num_ministry" value="Número de ministerio:" />
                        <TextInput id="num_ministry" ref="num_ministryInput" v-model="formPeople.num_ministry" type="text"
                            class="mt-1 block w-full" placeholder="Número de ministerio" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.num_ministry" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="num_dispach" value="Número de despacho:" />
                        <TextInput id="num_dispach" ref="num_dispachInput" v-model="formPeople.num_dispach" type="text"
                            class="mt-1 block w-full" placeholder="Número de despacho" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.num_dispach" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="radicated" value="Radicado:" />
                        <TextInput id="radicated" ref="radicatedInput" v-model="formPeople.radicated" type="text"
                            class="mt-1 block w-full" placeholder="Radicado" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.radicated" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="authority" value="Autoridad:" />
                        <TextInput id="authority" ref="authorityInput" v-model="formPeople.authority" type="text"
                            class="mt-1 block w-full" placeholder="Autoridad" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.authority" class="mt-2" />
                    </div>
                    <div class="">
                        <InputLabel for="number" value="Número:" />
                        <TextInput id="number" ref="numberInput" v-model="formPeople.number" type="text"
                            class="mt-1 block w-full" placeholder="Número" v-bind:disabled="!actionsPeople"/>
                        <InputError :message="formPeople.errors.number" class="mt-2" />
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="actionsPeople= true" :disabled="actionsPeople" v-if="edit"> Habilitar Actualizar </SecondaryButton>
                    <SecondaryButton @click="actionsPeople= true" :disabled="actionsPeople" v-if="create"> Habilitar Crear </SecondaryButton>
                    <SecondaryButton @click="savePeople" :disabled="form.processing"> Añadir </SecondaryButton>
                    <SecondaryButton @click="closeModal" :disabled="form.processing"> Cancelar </SecondaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import Modal from '@/Components/Modal.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { IconEdit, IconTrash } from '@tabler/icons-vue';
import { Head, usePage, router, useForm } from '@inertiajs/vue3';
import { ref, nextTick } from 'vue';
import Swal from 'sweetalert2'


const modal = ref(false);
const searchInput = ref(null);
const search = ref(null);
const actionsPeople = ref(false);
const edit = ref(false);
const create = ref(true);


defineProps({
    stage: {
        type: Object,
        default: null,
    },
    types: {
        type: Object,
        default: null,
    },
    types_people: {
        type: Object,
        default: null,
    },
    people: {
        type: Object,
        default: null,
    },
});

const stage = usePage().props.stage;
const people = usePage().props.people;
const types_people = usePage().props.types_people;
const groupPeople = ref(stage.people);
const groupFiles = ref(stage.files);


const form = useForm({
    name: stage.name,
    procedure_date: stage.procedure_date,
    description : stage.description,
    process_id: stage.process_id,
    type_stage_id: stage.type_stage_id,
    people: groupPeople.value,
    files: groupFiles.value,
});

const formPeople = useForm({
    id: '',
    name: '',
    type_people_id: '',
    type: '',
    email: '',
    nit: '',
    document_type_id: '',
    phone: '',
    address: '',
    issue_nit: '',
    num_ministry: '',
    num_dispach: '',
    radicated: '',
    authority: '',
    number: '',
});


const searchPeople = () => {
    if (search.value.length > 0) {
        const person = people.find((person) => person.nit == search.value);
        if (person) {
            formPeople.id = person.id;
            formPeople.name = person.name;
            formPeople.type_people_id = person.type_people_id;
            formPeople.type = types_people.find((type) => type.id == person.type_people_id).name;
            formPeople.email = person.email;
            formPeople.nit = person.nit;
            formPeople.document_type_id = person.document_type_id;
            formPeople.phone = person.phone;
            formPeople.address = person.address;
            formPeople.issue_nit = person.issue_nit;
            formPeople.num_ministry = person.num_ministry;
            formPeople.num_dispach = person.num_dispach;
            formPeople.radicated = person.radicated;
            formPeople.authority = person.authority;
            formPeople.number = person.number;
            actionsPeople.value = false;
            edit.value = true;
            create.value = false;
        } else {
            form.reset();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No se encontró la persona',
            })
            create.value = true;
        }
    } else {
        form.reset();
    }
}

const savePeople = () => {
    formPeople.post(route('stages.validatePeople'), {
        preserveScroll: true,
        onSuccess: () => {
            if (actionsPeople.value) {
                if (edit.value) {
                    const index = groupPeople.value.findIndex((person) => person.id == formPeople.id);
                    formPeople.type = types_people.find((type) => type.id == formPeople.type_people_id).name;
                    groupPeople.value[index] = formPeople.data();
                } else if (create.value) {
                    if (groupPeople.value.find((person) => person.nit == formPeople.nit)) {
                        formPeople.type = types_people.find((type) => type.id == formPeople.type_people_id).name;
                        const index = groupPeople.value.findIndex((person) => person.nit == formPeople.nit);
                        groupPeople.value[index] = formPeople.data();
                    } else {
                        formPeople.type = types_people.find((type) => type.id == formPeople.type_people_id).name;
                        groupPeople.value.push(formPeople.data());
                    }
                }else{
                    formPeople.type = types_people.find((type) => type.id == formPeople.type_people_id).name;
                    groupPeople.value.push(formPeople.data());
                }
            } else {
                if(groupPeople.value.find((person) => person.id == formPeople.id)){
                    const index = groupPeople.value.findIndex((person) => person.id == formPeople.id);
                    formPeople.type = types_people.find((type) => type.id == formPeople.type_people_id).name;
                    groupPeople.value[index] = formPeople.data();
                }else{
                    formPeople.type = types_people.find((type) => type.id == formPeople.type_people_id).name;
                    groupPeople.value.push(formPeople.data());
                }
            }
            closeModal();
        },
    });
};

const editPerson = (person) => {
    formPeople.id = person.id;
    formPeople.name = person.name;
    formPeople.type_people_id = person.type_people_id;
    formPeople.type = types_people.find((type) => type.id == person.type_people_id).name;
    formPeople.email = person.email;
    formPeople.nit = person.nit;
    formPeople.document_type_id = person.document_type_id;
    formPeople.phone = person.phone;
    formPeople.address = person.address;
    formPeople.issue_nit = person.issue_nit;
    formPeople.num_ministry = person.num_ministry;
    formPeople.num_dispach = person.num_dispach;
    formPeople.radicated = person.radicated;
    formPeople.authority = person.authority;
    formPeople.number = person.number;
    actionsPeople.value = true;
    edit.value = true;
    create.value = false;
    openModal();
};

const removePerson = (index) => {
    groupPeople.value.splice(index, 1);
};

const openModal = () => {
    modal.value = true;
    nextTick(() => searchInput.value.focus());
};

const closeModal = () => {
    modal.value = false;
    formPeople.reset();
    formPeople.clearErrors();
    search.value = '';
    edit.value = false;
    create.value = true;
    actionsPeople.value = false;
}
const cloudName = "dcvsxucd4"; // replace with your own cloud name
const uploadPreset = "preset_TrialTasker";
const myWidget = cloudinary.createUploadWidget(
  {
    cloudName: cloudName,
    uploadPreset: uploadPreset,
    //cropping: true, //add a cropping step
    // showAdvancedOptions: true,  //add advanced options (public_id and tag)
    // sources: [ "local", "url"], // restrict the upload sources to URL and local files
    // multiple: false,  //restrict upload to a single file
    // folder: "user_images", //upload files to the specified folder
    // tags: ["users", "profile"], //add the given tags to the uploaded files
    // context: {alt: "user_uploaded"}, //add the given context data to the uploaded files
    //clientAllowedFormats: ["pdf"], //restrict uploading to image files only
    // maxImageFileSize: 2000000,  //restrict file size to less than 2MB
    // maxImageWidth: 2000, //Scales the image down to a width of 2000 pixels before uploading
    // theme: "purple", //change to a purple theme
  },
  (error, result) => {
    if (!error && result && result.event === "success") {
        const file = result.info;
        if (groupFiles.value.length == 0 ) {
            groupFiles.value.push(file);
        } else {
            if (groupFiles.value.find((file) => file.original_filename == result.info.original_filename)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El archivo ya se encuentra en la lista',
            })
            } else {
            groupFiles.value.push(file);
            }
        }
        console.log(groupFiles.value);
    }
  }
);

const openFile = (e) => {
    e.preventDefault();
    myWidget.open();
};

const removeFile = (index) => {
    groupFiles.value.splice(index, 1);
};

const update = () => {
    form.files=[];
    groupFiles.value.forEach((file) => {
        if(file.name) {
            console.log(file.name);
            form.files.push({
                original_filename: file.name,
                url: file.url,
            });
        }
        else {
            form.files.push({
                original_filename: file.original_filename,
                url: file.url,
            });
        }
    });
    form.people = groupPeople.value;
    form.put(route('stage.update', stage.id), {
        preserveScroll: true,
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
                title: 'Etapa actualizada'
            })
        }
    });
}


</script>

<style>

</style>