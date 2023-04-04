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

const props = defineProps({
    data: {
        type: Object,
    },
    getData:{
        type: Function,
    }
});

const data = props.data;
const countList = ref(data.per_page);
const page = ref(data.current_page);

watch(countList, (value) => {
    props.getData('',value);
});

function getPage(url) {
    url = new URL(url);
    page.value = url.searchParams.get('page');
    props.getData('','',page.value);
}





</script>

<style></style>