<x-layout>
    <title>Dashboard</title>
    <div class="flex h-screen bg-blue-50" x-data="dashboard()" x-cloak>
        <!-- Sidebar -->
        <x-adminSidebar />

        <!-- Main Content -->
        <main class="flex-1 p-4 space-y-4">
            <x-header>Dashboard Overview</x-header>
            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-green-100 shadow rounded-lg p-4 flex items-center gap-4">
                    <img src="/storage/assets/maternal-50.png" alt="Maternal" class="w-12 h-12">
                    <div>
                        <p class="text-2xl font-bold">1,234</p>
                        <p class="text-sm text-gray-600">Total Pregnant Patients</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-yellow-100 shadow rounded-lg p-4 flex items-center gap-4">
                    <img src="/storage/assets/child-50.png" alt="Child" class="w-12 h-12">
                    <div>
                        <p class="text-2xl font-bold">5,678</p>
                        <p class="text-sm text-gray-600">Total Children</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-indigo-100 shadow rounded-lg p-4 flex items-center gap-4">
                    <img src="/storage/assets/maternal-50.png" alt="New Maternal" class="w-12 h-12">
                    <div>
                        <p class="text-2xl font-bold">45</p>
                        <p class="text-sm text-gray-600">New Maternal Registrations</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class=" bg-red-200 shadow rounded-lg p-4 flex items-center gap-4">
                    <img src="/storage/assets/child-50.png" alt="Child Immunizations" class="w-12 h-12">
                    <div>
                        <p class="text-2xl font-bold">120</p>
                        <p class="text-sm text-gray-600">Upcoming Child Immunizations</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-6">
                <!-- Calendar -->
                <div class="bg-white p-4 rounded-lg shadow min-w-1/3">
                    <div class="flex items-center justify-between mb-4 gap-2">
                        {{-- <a href="?month={{ $previousMonth }}"
                            class="bg-gray-200 text-gray-700 rounded py-1 px-2 hover:bg-gray-300">← Previous</a> --}}

                        <h2 class="text-xl font-bold text-center">{{ $today->format('F Y') }}</h2>

                        {{-- <a href="?month={{ $nextMonth }}"
                            class="bg-gray-200 text-gray-700 rounded py-1 px-2 hover:bg-gray-300">Next →</a> --}}
                    </div>

                    <div class="grid grid-cols-7 gap-2 text-center text-sm font-semibold">
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                            <div>{{ $day }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-2 mt-2">
                        @for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay())
                            @php
                                $formatted = $date->format('Y-m-d');
                                $scheduleType = optional($groupedSchedules->get($formatted))[0]->type ?? null;

                                $bg = match ($scheduleType) {
                                    'immunization' => 'bg-green-400 text-white',
                                    'prenatal' => 'bg-blue-400 text-white',
                                    'timbang' => 'bg-red-400 text-white',
                                    default => 'bg-white text-black'
                                };

                                $isCurrentMonth = $date->format('Y-m') === $today->format('Y-m');
                                $textColor = $isCurrentMonth ? '' : 'text-gray-300';
                            @endphp

                            <div
                                class="border rounded-lg p-2 flex flex-col items-start justify-start {{ $bg }} {{ $textColor }}">
                                <div class="text-xs font-bold">{{ $date->day }}</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Schedule List -->
                <div class="bg-white p-4 rounded-lg shadow flex-1 ">
                    <!-- Table Wrapper -->
                    <div class="container mx-auto">
                        <div class="rounded border border-gray-200 scrollable">
                            <!-- Sticky Header -->
                            <table class="w-full text-sm text-left border-collapse table-fixed">
                                <thead class="bg-gray-100 sticky top-0 z-10">
                                    <tr class="bg-blue-200 text-gray-700">
                                        <th class="p-3 w-1/4">Date</th>
                                        <th class="p-3 w-1/4">Time</th>
                                        <th class="p-3 w-1/4">Day</th>
                                        <th class="p-3 w-1/4">Type</th>
                                    </tr>
                                </thead>
                            </table>

                            <!-- Scrollable Body -->
                            <div class="overflow-y-auto max-h-[30vh]">
                                <table class="w-full text-sm text-left border-collapse table-fixed">
                                    <tbody>
                                        <template x-for="schedule in schedules" :key="schedule.id">
                                            <tr class="border-b border-blue-200 hover:bg-gray-50">
                                                <!-- Date -->
                                                <td class="p-3 w-1/4" x-text="schedule.date"></td>

                                                <!-- Time -->
                                                <td class="p-3 w-1/4" x-text="formatTime(schedule.time)"></td>

                                                <!-- Day -->
                                                <td class="p-3 w-1/4" x-text="formatDay(schedule.date)"></td>

                                                <!-- Type with color -->
                                                <td class="p-3">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded"
                                                        :class="statusColors[schedule.type]">
                                                        <span x-text="schedule.type" class=" capitalize"></span>
                                                    </span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-4">Recent Activity</h2>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-500">📄</span>
                        <div>
                            <p>Monthly Maternal Health Report generated.</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-500">📄</span>
                        <div>
                            <p>Child Immunization Coverage Report updated.</p>
                            <p class="text-xs text-gray-500">5 hours ago</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-500">📄</span>
                        <div>
                            <p>Weekly Schedule Overview Report published.</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                    </li>
                </ul>
            </div>
        </main>
    </div>


    <script>
        function dashboard() {
            return {
                schedules: @json($allSchedules),

                statusColors: {
                    'immunization': 'bg-green-100 text-green-700',
                    'prenatal': 'bg-blue-100 text-blue-700',
                    'timbang': 'bg-red-100 text-red-700',
                },

                formatDay(dateString) {
                    const date = new Date(dateString.replace(/-/g, '/'));
                    return date.toLocaleDateString('en-US', { weekday: 'long' });
                },

                formatTime(timeString) {
                    const [hour, minute] = timeString.split(':').map(Number);
                    const date = new Date();
                    date.setHours(hour, minute);
                    return date.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                }
            }
        }
    </script>
</x-layout>
