<script setup>
import { Head, Link } from '@inertiajs/vue3';
import LawyerPana from '@/Components/svg/LawyerPana.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Bienvenido" />
    <div class="min-h-screen bg-dots-darker bg-center bg-gray-100">
        <div v-if="canLogin" class="flex justify-end items-center gap-3 p-4 lg:px-8">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900  focus:outline focus:outline-2 focus:rounded-sm">
            Dashboard</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900">
                Iniciar Sesión</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="font-semibold text-white bg-[#C19d88] hover:bg-[#a98a78] text-sm px-5 py-2 rounded-full">
                Registrar</Link>
            </template>
        </div>

            <!-- Heading -->
            <div class=" container mx-auto p-6 lg:p-8 grid grid-cols-1 md:grid-cols-2">
                <div class="flex flex-col items-center justify-center">

                    <h1 class="text-3xl md:text-5xl font-bold leading-tight text-[#33292e] font-serif">Maneja tus casos de manera más eficiente con TrialTasker</h1>
                    <p class="text-[#615a5d] text-sm md:text-xl mt-4">TrialTasker es una herramienta poderosa para abogados que permite manejar y organizar sus casos de manera eficiente, ahorrando tiempo y dinero.</p>
                </div>
                <LawyerPana class="max-w-md mx-auto" />
            </div>
            <!-- Message -->

            <div class="mt-4 bg-[#a98a78]">
                <div class="container mx-auto max-w-3xl p-6 lg:p-8 text-center">
                    <p class="text-white">"Con TrialTasker, manejar tus casos nunca había sido tan fácil. Nuestra aplicación está diseñada para ser intuitiva y fácil de usar, con una interfaz limpia y sencilla que te permite acceder a tus casos en pocos clics. Además, te guiamos paso a paso a través de todo el proceso, desde la creación de un caso hasta la gestión de documentos y tareas. ¡No necesitas ser un experto en tecnología para usar TrialTasker!"</p>
                </div>
            </div>

            <!-- Features -->
            <div class=" container mx-auto p-6 lg:p-8 mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="border rounded-lg p-6 md:p-8 bg-white shadow">
                    <h2 class="text-xl md:text-2xl font-bold text-[#33292e] mb-4">Organiza tus casos</h2>
                    <p class="text-sm md:text-base text-[#615a5d] mb-4">Crea y organiza tus casos de manera fácil y rápida, mantén la información importante en un solo lugar y nunca pierdas el rastro de tus casos.</p>
                </div>
                <div class="border rounded-lg p-6 md:p-8 bg-white shadow">
                    <h2 class="text-xl md:text-2xl font-bold text-[#33292e] mb-4">Accede a tus casos en cualquier momento y lugar</h2>
                    <p class="text-sm md:text-base text-[#615a5d] mb-4">TrialTasker te permite acceder a toda la información de tus casos desde cualquier dispositivo con conexión a Internet, lo que significa que podrás trabajar en ellos en cualquier momento y lugar.</p>
                </div>
                <div class="border rounded-lg p-6 md:p-8 bg-white shadow">
                    <h2 class="text-xl md:text-2xl font-bold text-[#33292e] mb-4">Ahorra tiempo y dinero</h2>
                    <p class="text-sm md:text-base text-[#615a5d] mb-4">Elimina tareas manuales y tediosas, automatiza procesos y aumenta tu productividad, lo que te permite ahorrar tiempo y dinero en el manejo de tus casos.</p>
                </div>
            </div>

            <!-- Call to action -->
            <div class="container mx-auto p-6 lg:p-8 mt-16 text-center">
                <h2 class="text-4xl font-bold text-[#33292e] mb-4">Regístrate ahora y prueba TrialTasker gratis</h2>
                <p class="text-[#615a5d] text-xl mb-8">Empieza a manejar tus casos de manera más eficiente hoy mismo.</p>
                <Link v-if="canRegister" :href="route('register')" class="inline-block py-4 px-8 text-white bg-[#C19d88] rounded-lg hover:bg-[#a98a78] transition duration-200">Registrate ahora</Link>
            </div>
        <!-- footer -->
        <div class="bg-[#a49ea1] text-[#33292e] py-8 mt-16">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-evenly items-center">
                    <div class="">
                        <a href="#" class="font-bold text-2xl mb-2">TrialTasker</a>
                        <p class="text-sm">Maneja tus casos de manera más eficiente con TrialTasker</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <p class="text-sm">Una herramienta poderosa para abogados</p>
                        <p class="text-sm">Maneja tus casos de manera más eficiente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}</style>
