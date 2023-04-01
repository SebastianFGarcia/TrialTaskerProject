<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Verificar correo electrónico" />
        <div class="mb-4 text-sm text-gray-600">
            Gracias por registrarte. Antes de empezar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no lo has recibido, estaremos encantados de enviarte otro.
        </div>
        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.
        </div>
        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reenviar enlace de verificación
                </PrimaryButton>

                <Link :href="route('logout')" method="post" as="button"
                    class=" text-sm text-gray-600 hover:text-gray-900 ">
                    Cerrar sesión
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
