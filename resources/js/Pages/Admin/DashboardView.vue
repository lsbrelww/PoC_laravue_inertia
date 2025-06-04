<script setup lang="ts">
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import DashboardLayout from '../../Layouts/Admin/DashboardLayout.vue'
import SidebarProvider from '../../Components/SidebarProvider.vue'
import ThemeProvider from '../../Components/ThemeProvider.vue'

const data = ref(0)
const users = usePage().props.users
</script>

<template>
    <ThemeProvider>
        <SidebarProvider>
            <DashboardLayout>
                <div>
                    {{ users }}
                </div>
            </DashboardLayout>
        </SidebarProvider>
    </ThemeProvider>
</template>
