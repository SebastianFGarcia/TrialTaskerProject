<template>
    <Head title="Crear Proceso" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear etapa</h2>
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
                        <div class="flex flex-col w-full gap-2">
                            dsadasda
                        </div>
                        <div class="flex justify-end w-full md:w-10/12">
                            <SecondaryButton @click="save" :disabled="form.processing"> Guardar </SecondaryButton>
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
    process: {
        type: Object,
        default: null,
    },
    types: {
        type: Object,
        default: null,
    }
});

const process = usePage().props.process;


const form = useForm({
    name: '',
    procedure_date: '',
    description : '',
    process_id: process.id,
    type_stage_id: '',
});

const save = () => {
    form.post(route('stages.store'), {
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
                title: 'Etapa creada correctamente'
            })
            router.back();
        },
    });
};



</script>

<style>

</style>