<script setup lang="ts">
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import DashboardLayout from '../../Layouts/Admin/DashboardLayout.vue'
import SidebarProvider from '../../Components/SidebarProvider.vue'
import ThemeProvider from '../../Components/ThemeProvider.vue'

const data = ref(0)
const events = usePage().props.events
</script>

<template>
    <ThemeProvider>
        <SidebarProvider>
            <DashboardLayout>
                <div>
                    <h1 class="uppercase">Welcome</h1>
                    <p>{{ events }}</p>
                    <p>Count: {{ data }}</p>
                    <button @click="data++" class="bg-emerald-300">Increment</button>
                </div>
            </DashboardLayout>
        </SidebarProvider>
    </ThemeProvider>
</template>
