<template>
    <div class="flex justify-between mb-5">
        <!-- create -->
        <div >
            <button class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green" @click="create(1)" v-if="create">
                <IconPlus stroke-width="3" class="w-4 h-4 mr-2" />
                Crear
            </button>
            <a class="flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green" v-if="route_to" :href="route(route_to)">
                <IconPlus stroke-width="3" class="w-4 h-4 mr-2" />
                Crear
            </a>
        </div>
        <!-- search -->
        <div class="relative text-gray-600 focus-within:text-gray-400">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <button class="p-1 focus:outline-none focus:shadow-outline">
                    <IconSearch stroke-width="1" />
                </button>
            </span>
            <input type="search" name="search" id="search"
                class="py-2 text-sm text-gray-900 bg-gray-100 rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-900"
                placeholder="Buscar..." autocomplete="off" v-model="search" @input="getSearch()" />
        </div>
    </div>
</template>

<script setup>
import { useForm, router  } from '@inertiajs/vue3';
import { IconSearch, IconPlus  } from '@tabler/icons-vue';
import { onMounted, ref } from 'vue';

const props = defineProps({
    route_to: {
        type: String,
        default: null,
    },
    getData:{
        type: Function,
    },
    create:{
        type: Function,
        default: null,
    }
});

const search = ref(null)

const getSearch = () => {
    if (search.value == '') {
        search.value = null;
    }
    props.getData('','','',search.value)
}

onMounted(() => {
    const url = new URL(window.location.href);
    const searchParam = url.searchParams.get('search');
    if(searchParam) {
        search.value = searchParam;
        const searchInput = document.getElementById('search');
        searchInput.focus();
    }
});


</script>

<style></style>