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
                <a href="/admin/dashboard"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'admin/dashboard' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'admin/dashboard' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/dashboard.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Dashboard</span>
                </a>
            </li>


            <li>
                <a href="/admin/maternal-profiles"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'admin/maternal-profiles' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'admin/maternal-profiles' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/maternal.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Maternal</span>
                </a>
            </li>

            <li>
                <a href="/admin/child-profiles"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'admin/child-profiles' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'admin/child-profiles' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/child.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Child</span>
                </a>
            </li>

            <li>
                <a href="/admin/schedules"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'admin/schedules' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'admin/schedules' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/calendar.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Schedules</span>
                </a>
            </li>

            <li>
                <a href="/admin/maternal-reports"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'admin/maternal-reports' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'admin/maternal-reports' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/report.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">Reports</span>
                </a>
            </li>

            <li>
                <a href="/admin/user-management"
                    :class="[sidebarCollapsed ? 'pointer-events-none' : '', currentRoute === 'admin/user-management' ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 hover:text-white']"
                    class="flex items-center gap-2 px-4 py-2 transition-all duration-300 rounded group">
                    <img :class="currentRoute === 'admin/user-management' ? 'filter brightness-0 invert' : 'group-hover:filter group-hover:brightness-0 group-hover:invert'"
                        src="/storage/assets/child.png" alt="">
                    <span x-show="!sidebarCollapsed" class="sidebar-label">User Management</span>
                </a>
            </li>
        </ul>
        <!-- Logout Button at Bottom -->
        <div class=" border-t py-3 flex items-center justify-center">
            <button class="flex items-center justify-center gap-2 px-4 py-1 transition-all duration-300 rounded group bg-blue-600 text-white cursor-pointer">
                <img src="/storage/assets/logout.png" alt="">
                <span x-show="!sidebarCollapsed" class="sidebar-label">Logout</span>
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
