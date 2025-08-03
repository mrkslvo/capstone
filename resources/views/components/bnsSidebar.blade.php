<aside x-data="sidebar()" id="sidebar"
    :class="[sidebarCollapsed ? 'w-20' : 'w-64', 'transition-all duration-500 ease-in-out bg-white shadow-md flex flex-col overflow-hidden']">

    <!-- Menu Bar -->
    <div class="h-16 flex items-center px-4 border-b" :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">
        <div class="font-bold text-lg text-blue-900 sidebar-label flex items-center justify-center gap-2">
            <span x-show="!sidebarCollapsed" class="inline-block w-8 h-8">
                <img src="/storage/assets/logo.png" alt="">
            </span>
            <span x-show="!sidebarCollapsed">PediaMat</span>
        </div>
        <button @click="toggleSidebar()" class="text-xl cursor-pointer">☰</button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col justify-between p-4 font-semibold text-blue-700">
        <ul class="space-y-2 text-blue-700">
            <li>
                <a href="dashboard"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'bns/dashboard' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'bns/dashboard' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/dashboard.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Dashboard</span>
                </a>
            </li>


            <li>
                <a href="child-profiles"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'bns/child-profiles' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'bns/child-profiles' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/child.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Child</span>
                </a>
            </li>

            <li>
                <a href="schedules"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'bns/schedules' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'bns/schedules' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/calendar.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Schedules</span>
                </a>
            </li>

            <li>
                <a href="reports"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'bns/reports' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'bns/reports' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/report.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Reports</span>
                </a>
            </li>
        </ul>
        <!-- Logout Button at Bottom -->
        <div class="mt-4 pt-4 border-t flex items-center justify-center">
            <button
                class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg flex items-center justify-center gap-2">
                Logout
            </button>
        </div>
    </nav>
    <script>
        function sidebar() {
            return {
                sidebarCollapsed: false,
                openDropdown: null,
                currentRoute: window.location.pathname.replace(/^\/+/, ''), // remove leading slash

                toggleSidebar() {
                    this.sidebarCollapsed = !this.sidebarCollapsed;
                },

                toggleDropdown(name) {
                    this.openDropdown = this.openDropdown === name ? null : name;
                }
            }
        }
    </script>
</aside>