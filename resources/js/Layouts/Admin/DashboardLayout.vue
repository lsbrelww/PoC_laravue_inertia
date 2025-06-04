<template>
    <div class="min-h-screen xl:flex">
        <DashboardSidebar />
        <Backdrop />
        <div class="flex-1 transition-all duration-300 ease-in-out dark:bg-slate-600"
            :class="[isExpanded || isHovered ? 'lg:ml-[290px]' : 'lg:ml-[90px]']">
            <AppHeader />
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import DashboardSidebar from './DashboardSidebar.vue';
import AppHeader from './AppHeader.vue'
import { useSidebar } from '../../Composables/useSidebar'
import Backdrop from './Backdrop.vue'
const { isExpanded, isHovered } = useSidebar()
</script>
