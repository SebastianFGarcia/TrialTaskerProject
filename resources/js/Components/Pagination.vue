<template>
    <div class="flex flex-col justify-center sm:flex-row sm:justify-between  items-center py-3 gap-3">
        <div class="flex items-center">
            <span class="text-sm text-gray-700">Mostrando</span>
            <select class="mx-2 form-select form-select-sm text-sm text-gray-700" v-model="countList">
                <option>10</option>
                <option>20</option>
                <option>30</option>
                <option>40</option>
                <option>50</option>
            </select>
            <span class="text-sm text-gray-700">registros</span>
        </div>
        <nav aria-label="Pagination" v-if="data.last_page > 1">
            <ul class="inline-flex items-center -space-x-px">
                <li v-for="page in data.links" :key="page">
                    <button
                        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-200 hover:text-gray-700"
                        :class="{ 'bg-gray-400 text-gray-700 hover:bg-gray-400 ': page.active }" :disabled="page.active || page.url === null"
                        v-html="page.label" 
                        @click="getPage(page.url)"/>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';





defineProps({
    data: {
        type: Object,
    },
});

const data = usePage().props.users;
const countList = ref(data.per_page);
const page = ref(data.current_page);

watch(countList, (value) => {
    let url = new URL(window.location.href);
    let is_sort = url.searchParams.get('sort');
    let is_direction = url.searchParams.get('direction');
    if (is_sort && is_direction) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                per_page: value,
                sort: is_sort,
                direction: is_direction
            }
        });
    } else {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                per_page: value 
            }
        });
    }
});

watch(page, (value) => {
    let url = new URL(window.location.href);
    let is_perpage = url.searchParams.get('per_page');
    let is_sort = url.searchParams.get('sort');
    let is_direction = url.searchParams.get('direction');
    if (is_sort && is_direction && is_perpage) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                per_page: countList.value,
                page: value,
                sort: is_sort,
                direction: is_direction
            }
        });
    } else
    if (is_sort && is_direction) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                page: value,
                sort: is_sort,
                direction: is_direction
            }
        });
    } else
    if(is_perpage) {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                per_page: countList.value,
                page: value 
            }
        });
    } else {
        router.visit('users', { 
            replace: true, 
            preserveScroll: true, 
            only: ['users'], 
            data: {
                page: value 
            }
        });
    }
});

function getPage(url) {
    url = new URL(url);
    page.value = url.searchParams.get('page');
}





</script>

<style></style>