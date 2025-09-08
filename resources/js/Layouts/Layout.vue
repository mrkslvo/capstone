<script setup>
import { ref, computed } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import * as icons from "lucide-vue-next";
import logo from "../../images/logo.png";

const page = usePage();
const user = computed(() => page.props.auth.user);

// Sidebar state
const isCollapsed = ref(false);
const showLabels = ref(true);

const toggleSidebar = () => {
    if (isCollapsed.value) {
        isCollapsed.value = false;
        setTimeout(() => (showLabels.value = true), 100);
    } else {
        showLabels.value = false;
        isCollapsed.value = true;
    }
};

// Define links by role
const roleLinks = {
    admin: [
        { name: "Dashboard", route: "dashboard", icon: "LayoutDashboard", folder: "Admin" },
        { name: "Maternal", route: "maternal", icon: "HeartPulse", folder: "Admin" },
        { name: "Child", route: "child", icon: "Baby", folder: "Admin" },
        { name: "Schedule", route: "schedule", icon: "CalendarDays", folder: "Admin" },
        { name: "Report", route: "report", icon: "ClipboardList", folder: "Admin" },
        { name: "User", route: "user", icon: "Users", folder: "Admin" },
    ],
    parent: [
        { name: "Dashboard", route: "dashboard", icon: "LayoutDashboard", folder: "Parent" },
    ],
    bns: [
        { name: "Dashboard", route: "dashboard", icon: "LayoutDashboard", folder: "Bns" },
    ],
    bhw: [
        { name: "Dashboard", route: "dashboard", icon: "LayoutDashboard", folder: "Bhw" },
    ],
    rhu: [
        { name: "Dashboard", route: "dashboard", icon: "LayoutDashboard", folder: "Rhu" },
    ],
};

// Logout form
const form = useForm();
const logout = () => form.post(route("logout"));
</script>

<template>
    <div  class="flex h-screen bg-[#f0f9ff]">
        <!-- Sidebar -->
        <div
            v-if="user && $page.component !== 'NotFound'"
            :class="[
                'bg-white text-blue-700 flex flex-col justify-between shadow-md transition-all duration-300',
                isCollapsed ? 'w-16' : 'w-56',
            ]"
        >
            <!-- Top Section -->
            <div>
                <!-- Logo / Brand -->
                <button
                    @click="toggleSidebar"
                    class="flex items-center justify-center gap-3 p-4 mb-4 mx-auto rounded-2xl font-bold text-blue-700 hover:bg-blue-50 transition w-full"
                >
                    <img :src="logo" alt="Logo" class="w-8 h-8" />
                    <span
                        v-if="showLabels"
                        class="text-lg text-center transition-opacity duration-500"
                        >PediaMat</span
                    >
                </button>

                <!-- Dynamic Menu -->
                <nav class="flex flex-col px-2 gap-2">
                    <div
                        v-for="item in roleLinks[user.role]"
                        :key="item.name"
                        class="w-full"
                    >
                        <Link
                            :href="route(item.route)"
                            class="group flex items-center rounded-xl w-full py-2 px-3 text-lg font-medium transition-all duration-300"
                            :class="
                                $page.component === `${item.folder}/${item.name}`
                                    ? 'bg-blue-600 text-white shadow'
                                    : 'text-blue-700 hover:bg-blue-600 hover:text-white'
                            "
                        >
                            <component
                                :is="icons[item.icon]"
                                class="w-6 h-6 transition-colors duration-300"
                                :class="
                                    $page.component === `${item.folder}/${item.name}`
                                        ? 'text-white'
                                        : 'text-blue-700 group-hover:text-white'
                                "
                            />
                            <span
                                v-if="showLabels"
                                class="ml-3 transition-opacity duration-500"
                                :class="
                                    $page.component === `${item.folder}/${item.name}`
                                        ? 'text-white'
                                        : 'text-blue-700 group-hover:text-white'
                                "
                                >{{ item.name }}</span
                            >
                        </Link>
                    </div>
                </nav>
            </div>

            <!-- Bottom Section: Logout -->
            <div class="p-3 border-t border-blue-700">
                <form @submit.prevent="logout">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        :class="[
                            'group flex items-center w-full rounded-xl py-2 px-3 text-lg font-medium transition-all duration-300 text-red-600',
                            form.processing
                                ? 'cursor-not-allowed bg-red-400 text-white'
                                : 'hover:bg-red-600 hover:text-white cursor-pointer',
                        ]"
                    >
                        <icons.LogOut
                            class="w-6 h-6 transition-colors duration-300 group-hover:text-white"
                        />
                        <span
                            v-if="showLabels"
                            class="ml-3 transition-opacity duration-500"
                        >
                            {{ form.processing ? "Logging out..." : "Logout" }}
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div :class="user ? 'p-4' : 'p-0'" class="flex-1 overflow-auto">
            <slot />
        </div>
    </div>
</template>
