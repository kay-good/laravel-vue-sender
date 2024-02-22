<script>
import Layout from '@/Layout/index.vue'
import Client from '@/Components/Client.vue';

export default {
    layout: Layout,
}
</script>

<script setup>
import { useForm, Head, router } from '@inertiajs/vue3';

defineProps(['clients']);

const form = useForm({
    phone: '',
    fullname: '',
    birthday: '',
});

function submit() {
    router.post('/clients', form, {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Clients" />
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-100">
        <form @submit.prevent="submit" class="flex gap-4 flex-wrap">
            <input type="number" v-model="form.phone" placeholder="Client's phone" required
                class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-1/3 grow">
            <input type="text" v-model="form.fullname" placeholder="Client's name" required
                class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-1/3 grow placeholder-blue-50::placeholder">
            <input type="date" v-model="form.birthday" placeholder="Client's birthday" required
                class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-1/3 grow">
            <button type="submit" class="bg-gray-400 rounded-md shadow-sm w-1/3 grow">Добавить</button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <Client v-for="client in clients" :key="client.id" :client="client" />
        </div>
    </div>
</template>
