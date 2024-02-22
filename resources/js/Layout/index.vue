<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <main>
        <header class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-100 flex justify-between">
            <Link active-class="active" href="/clients">Cliets</Link>
            <Link href="/tasks">Tasks</Link>
            <Link href="/stats">Stats</Link>
        </header>
        <slot />
    </main>
</template>
