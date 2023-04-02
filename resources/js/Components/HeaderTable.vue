<template>
    <div class="flex justify-end mb-5">
        <!-- search -->
        <div class="relative text-gray-600 focus-within:text-gray-400">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <button class="p-1 focus:outline-none focus:shadow-outline">
                    <IconSearch stroke-width="1" />
                </button>
            </span>
            <input type="search" name="search" id="search"
                class="py-2 text-sm text-gray-900 bg-gray-100 rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-900"
                placeholder="Buscar..." autocomplete="off" v-model="search.search" @input="searchList()" />
        </div>
    </div>
</template>

<script setup>
import { useForm, router  } from '@inertiajs/vue3';
import { IconSearch } from '@tabler/icons-vue';
import { onMounted } from 'vue';

const props = defineProps({
    route_to: {
        type: String,
    },
    only: {
        type: Array,
    },
});

const search = useForm({
    search: '',
});

onMounted(() => {
    const url = new URL(window.location.href);
    const searchParam = url.searchParams.get('search');
    if(searchParam) {
        search.search = searchParam;
        const searchInput = document.getElementById('search');
        searchInput.focus();
    }
});

function searchList() {
    let url = new URL(window.location.href);
    let is_perpage = url.searchParams.get('per_page');
    if(is_perpage) {
        router.visit(props.route_to, { 
            replace: true, 
            preserveScroll: true, 
            only: props.only, 
            data: {
                per_page: is_perpage,
                search: search.search,
            },
        });
    } else {
        router.visit(props.route_to, { 
            replace: true, 
            preserveScroll: true, 
            only: props.only, 
            data: {
                search: search.search,
            },
        });
    }
}
</script>

<style></style>