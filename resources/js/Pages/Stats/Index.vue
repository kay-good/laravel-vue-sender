<script>
import Layout from '@/Layout/index.vue'

export default {
    layout: Layout,
}
</script>

<script setup>
import { useForm, Head, router } from '@inertiajs/vue3';

defineProps(['stats']);

const form = useForm({
    startDate: '',
    endDate: '',
});

function submit() {
    router.post('/stats', form, {
        onSuccess: () => console.log("wow"),
    })
}
</script>

<template>
    <Head title="Stats" />
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-100">
        <form @submit.prevent="submit" class="flex gap-4 flex-wrap">
            <input type="date" v-model="form.startDate" placeholder="your message" required
                class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-1/3 grow px-5 py-2">
            <input type="date" v-model="form.endDate" placeholder="time" required
                class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-1/3 grow px-5 py-2">
            <button type="submit" class="bg-gray-400 rounded-md shadow-sm w-1/3 grow">Получить</button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <!-- <div>{{ stats }}</div> -->
            <div v-for="stat in stats" :key="stat.id" class="p-6 flex space-x-2">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-800">"{{ stat.message }}"</span>
                        <spam class="ml-2 text-sm text-gray-600">{{ stat.phone }}</spam>
                        <spam class="ml-2 text-sm text-gray-600">{{ stat.send_date }}</spam>
                        <span class="text-gray-800">"{{ stat.err }}"</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
