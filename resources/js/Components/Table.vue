<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-5">
                <tr class="border">
                    <th scope="col" class="px-4 py-2" v-for="column in columns" :key="column.key">
                        <div class="flex items-center justify-between" >
                            {{ column.name }}
                            <a @click="getData(column.key)">
                                <IconArrowsSort :size="17" />
                            </a>
                        </div>
                    </th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b " v-for="item in data" :key="item.id">
                    <td class=" px-4 py-2" v-for="column in columns" :key="column.key">
                        <span v-if="!column.key_2"> {{ item[column.key] }} </span>
                        <span v-if="column.key_2"> {{ item[column.key_2.key][column.key_2.name]}} </span>
                    </td>
                    <td class=" px-4 py-2">
                        <a v-if="edit " @click="edit(0,item)" class="me-1">Editar</a>
                        <a v-if="destroy " @click="destroy(item.id)" class="ms-1">Eliminar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { IconArrowsSort } from '@tabler/icons-vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    columns: {
        type: Object,
        required: true
    },
    data: {
        type: Object,
        required: true
    },
    name: {
        type: String,
        required: true
    },
    edit: {
        type: Function,
        default: null
    },
    destroy: {
        type: Function,
        default: null
    },
    getData: {
        type: Function,
        required: true
    }
})

const columns = props.columns;
const data = props.data;
const edit = props.edit;

const getData = (column) => {
    const url = new URL(window.location.href);
    const direction = url.searchParams.get('direction') == 'desc' ? 'asc' : 'desc';
    props.getData(column, '', '', '', direction);
}
</script>

<style></style>