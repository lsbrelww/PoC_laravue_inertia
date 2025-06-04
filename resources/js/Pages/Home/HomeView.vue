<script setup lang="ts">
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

const data = ref(0)
const events = usePage().props.events
</script>

<template>
    <h1 class="text-uppercase">Welcome</h1>
    <p>{{ events }}</p>
    <p>Count: {{ data }}</p>
    <button @click="data++">Increment</button>
</template>
