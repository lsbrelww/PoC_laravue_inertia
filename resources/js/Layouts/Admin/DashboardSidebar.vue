<template>
    <aside :class="[
        'fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200',
        {
            'lg:w-[290px]': isExpanded || isMobileOpen || isHovered,
            'lg:w-[90px]': !isExpanded && !isHovered,
            'translate-x-0 w-[290px]': isMobileOpen,
            '-translate-x-full': !isMobileOpen,
            'lg:translate-x-0': true,
        },
    ]" @mouseenter="!isExpanded && (isHovered = true)" @mouseleave="isHovered = false">
        <div :class="[
            'py-8 flex',
            !isExpanded && !isHovered ? 'lg:justify-center' : 'justify-start',
        ]">
            <div to="/">
                <img v-if="isExpanded || isHovered || isMobileOpen" class="dark:hidden"
                    src="../../../images/logo/logo.svg" alt="Logo" width="150" height="40" />
                <img v-if="isExpanded || isHovered || isMobileOpen" class="hidden dark:block"
                    src="../../../images/logo/logo-dark.svg" alt="Logo" width="150" height="40" />
                <img v-else src="../../../images/logo/logo-icon.svg" alt="Logo" width="32" height="32" />
            </div>
        </div>
        <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
            <nav class="mb-6">
                <div class="flex flex-col gap-4">
                    <div v-for="(menuGroup, groupIndex) in menuGroups" :key="groupIndex">
                        <h2 :class="[
                            'mb-4 text-xs uppercase flex leading-[20px] text-gray-400',
                            !isExpanded && !isHovered
                                ? 'lg:justify-center'
                                : 'justify-start',
                        ]">
                            <template v-if="isExpanded || isHovered || isMobileOpen">
                                {{ menuGroup.title }}
                            </template>
                            <span v-else>...</span>
                        </h2>
                        <ul class="flex flex-col gap-4">
                            <li v-for="(item, index) in menuGroup.items" :key="item.name">
                                <button v-if="item.subItems" @click="toggleSubmenu(groupIndex, index)" :class="[
                                    'menu-item group w-full',
                                    {
                                        'menu-item-active': isSubmenuOpen(groupIndex, index),
                                        'menu-item-inactive': !isSubmenuOpen(groupIndex, index),
                                    },
                                    !isExpanded && !isHovered
                                        ? 'lg:justify-center'
                                        : 'lg:justify-start',
                                ]">
                                    <span :class="[
                                        isSubmenuOpen(groupIndex, index)
                                            ? 'menu-item-icon-active'
                                            : 'menu-item-icon-inactive',
                                    ]">
                                        <component :is="item.icon" />
                                    </span>
                                    <span v-if="isExpanded || isHovered || isMobileOpen" class="menu-item-text">{{
                                        item.name }}</span>
                                    <ChevronDownIcon v-if="isExpanded || isHovered || isMobileOpen" :class="[
                                        'ml-auto w-5 h-5 transition-transform duration-200',
                                        {
                                            'rotate-180 text-brand-500': isSubmenuOpen(
                                                groupIndex,
                                                index
                                            ),
                                        },
                                    ]" />
                                </button>
                                <a v-else-if="item.path" :href="item.path" :class="[
                                    'menu-item group',
                                    {
                                        'menu-item-active': isActive(item.path),
                                        'menu-item-inactive': !isActive(item.path),
                                    },
                                ]">
                                    <span :class="[
                                        isActive(item.path)
                                            ? 'menu-item-icon-active'
                                            : 'menu-item-icon-inactive',
                                    ]">
                                        <component :is="item.icon" />
                                    </span>
                                    <span v-if="isExpanded || isHovered || isMobileOpen" class="menu-item-text">{{
                                        item.name }}</span>
                                </a>
                                <transition @enter="startTransition" @after-enter="endTransition"
                                    @before-leave="startTransition" @after-leave="endTransition">
                                    <div v-show="isSubmenuOpen(groupIndex, index) &&
                                        (isExpanded || isHovered || isMobileOpen)
                                        ">
                                        <ul class="mt-2 space-y-1 ml-9">
                                            <li v-for="subItem in item.subItems" :key="subItem.name">
                                                <a :href="subItem.path" :class="[
                                                    'menu-dropdown-item',
                                                    {
                                                        'menu-dropdown-item-active': isActive(
                                                            subItem.path
                                                        ),
                                                        'menu-dropdown-item-inactive': !isActive(
                                                            subItem.path
                                                        ),
                                                    },
                                                ]">
                                                    {{ subItem.name }}
                                                    <span class="flex items-center gap-1 ml-auto">
                                                        <span v-if="subItemExists(subItem)" :class="[
                                                            'menu-dropdown-badge',
                                                            {
                                                                'menu-dropdown-badge-active': isActive(
                                                                    subItem.path
                                                                ),
                                                                'menu-dropdown-badge-inactive': !isActive(
                                                                    subItem.path
                                                                ),
                                                            },
                                                        ]">
                                                            new
                                                        </span>
                                                        <span v-if="subItem.pro" :class="[
                                                            'menu-dropdown-badge',
                                                            {
                                                                'menu-dropdown-badge-active': isActive(
                                                                    subItem.path
                                                                ),
                                                                'menu-dropdown-badge-inactive': !isActive(
                                                                    subItem.path
                                                                ),
                                                            },
                                                        ]">
                                                            pro
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </transition>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </aside>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { GridIcon, CalenderIcon, SettingsIcon, ListIcon, TableIcon, PageIcon } from "../../../icons"
import { useSidebar } from "../../Composables/useSidebar";
import ChevronDownIcon from "../../../icons/ChevronDownIcon.vue";

const route = window.location.pathname;

const { isExpanded, isMobileOpen, isHovered, openSubmenu } = useSidebar();

const menuGroups = [
    {
        title: "Menu",
        items: [
            {
                icon: GridIcon,
                name: "Dashboard",
                subItems: [{ name: "Ecommerce", path: "/show", pro: false }],
            },
            {
                icon: CalenderIcon,
                name: "Calendar",
                path: "/home",
            },
            {
                icon: SettingsIcon,
                name: "User Profile",
                path: "/profile",
            },

            {
                name: "Forms",
                icon: ListIcon,
                subItems: [
                    { name: "Form Elements", path: "/form-elements", pro: true },
                ],
            },
            {
                name: "Tables",
                icon: TableIcon,
                subItems: [{ name: "Basic Tables", path: "/basic-tables", pro: false }],
            },
            {
                name: "Pages",
                icon: PageIcon,
                subItems: [
                    { name: "Black Page", path: "/blank", pro: false },
                    { name: "404 Page", path: "/error-404", pro: false },
                ],
            },
        ],
    },
];

const isActive = (path: any) => route === path;

const toggleSubmenu = (groupIndex: any, itemIndex: any) => {
    const key = `${groupIndex}-${itemIndex}`;
    openSubmenu.value = openSubmenu.value === key ? null : key;
};

const isAnySubmenuRouteActive = computed(() => {
    return menuGroups.some((group) =>
        group.items.some(
            (item: any) =>
                item.subItems && item.subItems.some((subItem: any) => isActive(subItem.path))
        )
    );
});

const isSubmenuOpen = (groupIndex: any, itemIndex: any) => {
    const key = `${groupIndex}-${itemIndex}`;
    return (
        openSubmenu.value === key ||
        (isAnySubmenuRouteActive.value &&
            menuGroups[groupIndex].items[itemIndex].subItems?.some((subItem) =>
                isActive(subItem.path)
            ))
    );
};

const startTransition = (el: any) => {
    el.style.height = "auto";
    const height = el.scrollHeight;
    el.style.height = "0px";
    el.offsetHeight; // force reflow
    el.style.height = height + "px";
};

const endTransition = (el: any) => {
    el.style.height = "";
};

const subItemExists = (subItem: any) => {
    return subItem.new ?? false
}
</script>
