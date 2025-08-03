<x-layout>
    <div class="flex h-screen bg" x-data="schedulePage()" x-init="init()" x-cloak>
        <!-- Sidebar -->
        <x-bnsSidebar />

        <!-- Main Content -->
        <main class="flex-1 p-3 overflow-auto ">
            <x-header>Schedules</x-header>

            <div class="flex gap-3 mt-3">

                <!-- Calendar -->
                <div class="bg-white p-4 rounded-lg shadow min-w-1/3 max-h-[50vh]">
                    <div class="flex items-center justify-between mb-4 gap-2">
                        <a href="?month={{ $previousMonth }}"
                            class="bg-gray-200 text-gray-700 rounded py-1 px-2 hover:bg-gray-300">← Previous</a>

                        <h2 class="text-xl font-bold text-center">{{ $today->format('F Y') }}</h2>

                        <a href="?month={{ $nextMonth }}"
                            class="bg-gray-200 text-gray-700 rounded py-1 px-2 hover:bg-gray-300">Next →</a>
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
                                class="border rounded-lg p-2 flex flex-col items-center justify-center {{ $bg }} {{ $textColor }}">
                                <div class="text-xs font-bold text-center ">{{ $date->day }}</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Schedule List -->
                <div class="bg-white p-4 rounded-lg shadow flex-1">
                    <div class="flex items-center justify-between my-3">
                        <h1 class="text-2xl font-bold">Schedule List</h1>
                        <div class="flex items-center gap-4 text-sm mb-2">
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div> Immunization
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div> Prenatal
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div> Timbang
                            </div>
                        </div>
                        <button @click="showAddModal = true"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer">+ Add Schedule</button>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-end gap-4 mb-4">
                        <div class="flex flex-col ">
                            <label class="text-sm font-semibold">Date Range</label>
                            <input type="date" x-model="filters.date" class="border rounded p-1 text-sm cursor-pointer">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-sm font-semibold">Schedule Type</label>
                            <select x-model="filters.type" class="border rounded p-1 text-sm cursor-pointer">
                                <option value="">All</option>
                                <option value="immunization">Immunization</option>
                                <option value="prenatal">Prenatal</option>
                                <option value="timbang">Timbang</option>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-sm font-semibold">Status</label>
                            <select x-model="filters.status" class="border rounded p-1 text-sm cursor-pointer">
                                <option value="">All</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <button @click="applyFilter"
                            class="bg-blue-600 text-white px-4 py-1 rounded text-sm cursor-pointer">Filter</button>
                    </div>

                    <!-- Table -->
                    <div class="bg-white rounded-lg flex-1 ">
                        <div class="container mx-auto">
                            <div class="rounded  border-gray-200 scrollable">
                                <!-- Sticky Header -->
                                <table class="table">
                                    <thead class="sticky top-0 z-10">
                                        <tr class="table-head">
                                            <th class="p-3">Date</th>
                                            <th class="p-3">Time</th>
                                            <th class="p-3">Day</th>
                                            <th class="p-3">Type</th>
                                            <th class="p-3">Status</th>
                                            <th class="p-3">Action</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div class="overflow-y-auto max-h-[50vh]">
                                    <table class="table">
                                        <tbody class=" overflow-y-auto">
                                            <template x-for="schedule in filteredSchedules" :key="schedule.id">
                                                <tr class="table-body   ">
                                                    <td class="p-3" x-text="schedule.date"></td>
                                                    <td class="p-3" x-text="formatTime(schedule.time)"></td>
                                                    <td class="p-3" x-text="formatDay(schedule.date)"></td>
                                                    <td class="p-3">
                                                        <span class="px-2 py-1 text-xs font-semibold rounded"
                                                            :class="statusColors[schedule.type]">
                                                            <span x-text="schedule.type" class=" capitalize"></span>
                                                        </span>
                                                    </td>
                                                    <td class="p-3" x-text="schedule.status"></td>
                                                    <td class="p-3">
                                                        <button @click="openEdit(schedule)" class=" cursor-pointer">
                                                            <img src="{{ asset('/storage/assets/edit.png') }}"
                                                                alt="Edit">
                                                        </button>
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
            </div>

            <!-- ✅ Success Modal -->
            <div x-show="showSuccess"
                class="fixed inset-0 flex items-center justify-center bg-black/40 bg-opacity-50 z-[999]">
                <div x-show="showSuccess" x-transition
                    class="relative bg-white p-6 rounded-lg shadow-md max-w-sm w-full text-center">
                    <button @click="showSuccess = false; location.reload();"
                        class="absolute top-2 right-3 text-gray-500 hover:text-black text-lg cursor-pointer">&times;</button>
                    <h2 class="text-green-600 font-semibold text-lg mb-2">Success</h2>
                    <p x-text="successMessage" class="text-gray-700"></p>
                </div>
            </div>

            <!-- Add Modal -->
            <div x-show="showAddModal" class="fixed inset-0 flex items-center justify-center bg-black/30 z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <h2 class="text-lg font-bold mb-4">Add Schedule</h2>
                    <form @submit.prevent="addSchedule">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <label>Date</label>
                                <input type="date" x-model="newSchedule.date" name="date" :min="minDate"
                                    class="border rounded w-full p-2" />
                                <span class="text-red-500 text-sm" x-text="errors.date"></span>
                            </div>

                            <div>
                                <label>Date</label>
                                <input type="time" x-model="newSchedule.time" name="time"
                                    class="border rounded w-full p-2" />
                                <span class="text-red-500 text-sm" x-text="errors.time"></span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block font-medium">Schedule Type</label>
                            <select x-model="newSchedule.type" name="type" class="border p-2 w-full rounded">
                                <option value="">Select Type</option>
                                <option value="immunization">Immunization</option>
                                <option value="prenatal">Prenatal</option>
                                <option value="timbang">Timbang</option>
                            </select>
                            <span class="text-red-500 text-sm" x-text="errors.type"></span>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showAddModal = false; clearErrors()"
                                class="bg-gray-400 px-4 py-2 rounded cursor-pointer ">Cancel</button>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div x-show="showEditModal" class="fixed inset-0 flex items-center justify-center bg-black/30 z-50">
                <div x-show="showEditModal" x-transition class="bg-white p-6 rounded shadow-md w-full max-w-md">
                    <h2 class="text-lg font-bold mb-4">Edit Schedule</h2>
                    <form @submit.prevent="updateSchedule">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <label class="block font-medium">Date</label>
                                <input type="date" x-model="editScheduleForm.date" name="date" :min="minDate"
                                    class="border p-2 w-full rounded" :min="minDate">
                                <span class="text-red-500 text-sm" x-text="errors.date"></span>
                            </div>
                            <div>
                                <label class="block font-medium">Time</label>
                                <input type="time" x-model="editScheduleForm.time" name="time"
                                    class="border p-2 w-full rounded">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <label class="block font-medium">Type</label>
                                <select x-model="editScheduleForm.type" name="type" class="border p-2 w-full rounded">
                                    <option value="immunization">Immunization</option>
                                    <option value="prenatal">Prenatal</option>
                                    <option value="timbang">Timbang</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium">Status</label>
                                <select x-model="editScheduleForm.status" name="status"
                                    class="border p-2 w-full rounded">
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showEditModal = false; clearErrors()"
                                class="bg-gray-400 px-4 py-2 rounded">Cancel</button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function schedulePage() {
            return {
                schedules: @json($allSchedules),
                showAddModal: false,
                showEditModal: false,
                showSuccess: false,
                successMessage: '',
                minDate: '{{ now()->toDateString() }}',
                filters: { date: '', type: '', status: '' },

                newSchedule: { date: '', time: '', type: '', status: 'pending' },
                editScheduleForm: { id: '', date: '', time: '', type: '', status: '' },
                errors: { date: '', time: '', type: '', status: '' },

                get filteredSchedules() {
                    return this.schedules.filter(s =>
                        (!this.filters.date || s.date === this.filters.date) &&
                        (!this.filters.type || s.type === this.filters.type) &&
                        (!this.filters.status || s.status === this.filters.status)
                    );
                },


                clearErrors() {
                    this.errors = { date: '', time: '', type: '', status: '' };
                    $('input, select, textarea').removeClass('border-red-500');
                },

                validateSchedule(schedule) {
                    this.clearErrors();
                    let isValid = true;

                    // Date validation
                    if (!schedule.date) {
                        this.errors.date = 'Date is required.';
                        $('[name="date"]').addClass('border-red-500');
                        isValid = false;
                    } else {
                        const exists = this.schedules.some(s =>
                            s.date === schedule.date && s.id !== schedule.id // allow same date only if it's the same record (editing)
                        );

                        if (exists) {
                            this.errors.date = 'Already have a schedule.';
                            $('[name="date"]').addClass('border-red-500');
                            isValid = false;
                        }
                    }

                    // Time validation
                    if (!schedule.time) {
                        this.errors.time = 'Time is required.';
                        $('[name="time"]').addClass('border-red-500');
                        isValid = false;
                    }

                    if (!['immunization', 'prenatal', 'timbang'].includes(schedule.type)) {
                        this.errors.type = 'Type must be immunization, prenatal, or timbang.';
                        $('[name="type"]').addClass('border-red-500');
                        isValid = false;
                    }

                    if (schedule.status && !['confirmed', 'pending', 'completed'].includes(schedule.status)) {
                        this.errors.status = 'Status must be confirmed, pending, or completed.';
                        $('[name="status"]').addClass('border-red-500');
                        isValid = false;
                    }

                    return isValid;
                },

                addSchedule() {
                    if (!this.validateSchedule(this.newSchedule)) return;

                    fetch(`{{ route('schedules.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.newSchedule)
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.errors) {
                                this.errors = data.errors;
                                return;
                            }

                            this.successMessage = data.message;
                            this.schedules.push(data.schedule);
                            this.showAddModal = false;
                            this.showSuccess = true;
                        })
                        .catch(err => console.error(err));
                },

                openEdit(schedule) {
                    this.editScheduleForm = { ...schedule };
                    this.clearErrors();
                    this.showEditModal = true;
                },

                updateSchedule() {
                    // 1. Client-side validation first
                    if (!this.validateSchedule(this.editScheduleForm)) return;


                    fetch(`/admin/schedules/${this.editScheduleForm.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ...this.editScheduleForm,
                            _method: 'PATCH'
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.errors) {
                                this.errors = data.errors;
                                return;
                            }

                            this.successMessage = data.message;
                            const index = this.schedules.findIndex(s => s.id === this.editScheduleForm.id);
                            if (index !== -1) this.schedules[index] = { ...this.editScheduleForm };
                            this.showEditModal = false;
                            this.showSuccess = true;
                        })
                        .catch(err => alert('Update failed'));
                },

                init() {
                    window.addEventListener('success', e => {
                        this.successMessage = e.detail.message;
                        this.showSuccess = true;
                        setTimeout(() => location.reload(), 3000);
                    });
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
                },

                statusColors: {
                    'immunization': 'bg-green-100 text-green-700',
                    'prenatal': 'bg-blue-100 text-blue-700',
                    'timbang': 'bg-red-100 text-red-700',
                },
            };
        }

    </script>

</x-layout>
