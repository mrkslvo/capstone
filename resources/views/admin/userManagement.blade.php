<x-layout>
    <title>User Management</title>
    <div class="flex h-screen bg" x-data="userCrud()" x-cloak>
        <!-- Sidebar -->
        <x-adminSidebar />

        <!-- Main Content -->
        <main class="flex-1 p-4 space-y-3 overflow-auto">
            <x-header>User Management</x-header>
            <div class="bg-white p-4 rounded shadow">
                <!-- Filters -->
                <div class=" grid grid-cols-2 gap-4 mb-4">
                    <div class=" flex items-center gap-2">
                        <input type="text" x-model="search" placeholder="Search users..."
                            class="border px-3 py-2 rounded w-1/3">
                        <select class="border px-3 py-2 rounded" x-model="filterRole">
                            <option value="">All Roles</option>
                            <option>BHW</option>
                            <option>BNS</option>
                            <option>Midwife</option>
                        </select>
                        <select class="border px-3 py-2 rounded " x-model="filterStatus">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class=" flex items-center justify-end">
                        <button @click="openAdd()" class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer">Add
                            User</button>
                    </div>

                </div>

                <!-- User Table -->
                <div class="bg-white rounded">
                    <table class="table">
                        <thead>
                            <tr class="table-head">
                                <th class="p-3">NAME</th>
                                <th class="p-3">EMAIL</th>
                                <th class="p-3">ROLE</th>
                                <th class="p-3">ASSIGNED AREA</th>
                                <th class="p-3">STATUS</th>
                                <th class="p-3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="user in filteredUsers()" :key="user.id">
                                <tr class="table-body">
                                    <td class="p-3" x-text="user.name"></td>
                                    <td class="p-3" x-text="user.email"></td>
                                    <td class="p-3" x-text="user.role"></td>
                                    <td class="p-3" x-text="user.assigned_area"></td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded"
                                            :class="statusColors[user.status]">
                                            <span x-text="user.status" class=" capitalize"></span>
                                        </span>
                                    </td>
                                    <td class="p-3 flex gap-2">
                                        <button @click="openEdit(user)" class="text-blue-600 cursor-pointer"><img
                                                src="/storage/assets/edit.png" alt=""></button>
                                        {{-- <button @click="remove(user.id)"
                                            class="text-red-600 cursor-pointer">Delete</button> --}}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 bg-black/30 flex items-center justify-center z-50">
            <div x-show="modalOpen" x-transition class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-lg font-bold mb-4" x-text="form.id ? 'Edit User' : 'Add User'"></h2>
                <form @submit.prevent="form.id ? updateUser() : addUser()">
                    @csrf
                    @method('POST')
                    <div class="mb-4">
                        <input type="text" x-model="form.name" name="name" class="border p-2 w-full rounded"
                            placeholder="Name" :class="errors.name ? 'border-red-500' : ''">
                        <p x-text="errors.name" class="text-sm text-red-600 mt-1 error-message" id="error-name"></p>
                    </div>

                    <div class="mb-4">
                        <input type="text" x-model="form.email" name="email" placeholder="Email"
                            class="border p-2 w-full" :class="errors.email ? 'border-red-500' : ''" />
                        <p x-text="errors.email" class="text-red-600 text-sm mt-1 error-message" id="error-email"></p>
                    </div>

                    <div class="mb-4">
                        <select :class="errors.role ? 'border-red-500' : ''" class="w-full border px-4 py-2 rounded"
                            name="role" x-model="form.role">
                            <option value="" disabled>Select Role</option>
                            <option value="BHW">BHW</option>
                            <option value="BNS">BNS</option>
                            <option value="Midwife">Midwife</option>
                        </select>
                        <p x-text="errors.role" class="text-red-600 text-sm mt-1 error-message" id="error-role"></p>
                    </div>

                    <div class="mb-4">
                        <input :class="errors.assigned_area ? 'border-red-500' : ''" type="text"
                            x-model="form.assigned_area" name="assigned_area" placeholder="Assigned Area"
                            class="border p-2 w-full" />
                        <p x-text="errors.assigned_area" class="text-red-600 text-sm mt-1 error-message"
                            id="error-assigned_area"></p>
                    </div>

                    <div class="mb-4">
                        <select name="status" x-model="form.status" :class="errors.status ? 'border-red-500' : ''"
                            class="w-full border px-4 py-2 rounded">
                            <option value="" disabled>Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <p class="text-red-600 text-sm mt-1" x-text="errors.status"></p>
                    </div>

                    <div class="mb-4" x-show="!form.id">
                        <input type="password" :class="errors.password ? 'border-red-500' : ''" x-model="form.password"
                            name="password" placeholder="Password" class="border p-2 w-full" />
                        <p x-text="errors.password" class="text-red-600 text-sm mt-1 error-message" id="error-password">
                        </p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="modalOpen = false; clearErrors()"
                            class="px-4 py-2 border rounded hover:bg-gray-100 cursor-pointer">Cancel</button>
                        <button type="submit" :disabled="isLoading"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">
                            <span x-show="!isLoading">Save</span>
                            <span x-show="isLoading">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @include('components.successModal')
    </div>
</x-layout>

<script>
    function userCrud() {
        return {
            // 🔰 Data
            users: @json($users),
            form: {
                id: null,
                name: '',
                email: '',
                password: '',
                role: '',
                assigned_area: '',
                status: 'inactive'
            },

            // 🔰 UI State
            modalOpen: false,
            isLoading: false,
            showSuccess: false,
            successMessage: '',

            // 🔍 Filters
            search: '',
            filterRole: '',
            filterStatus: '',

            errors: {},

            statusColors: {
                'active': 'bg-green-100 text-green-700',
                'inactive': 'bg-red-100 text-red-700',
            },

            // 🚀 Modal Handling
            openAdd() {
                this.resetForm();
                this.modalOpen = true;
            },

            openEdit(user) {
                this.form = { ...user, password: '' };
                this.modalOpen = true;
            },

            resetForm() {
                this.form = {
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    role: '',
                    assigned_area: '',
                    status: 'inactive'
                };
                $('.error-message').text('');
                $('input, select').removeClass('border-red-500');
            },

            // ✅ Add User
            async addUser() {
                this.isLoading = true;
                this.clearErrors();

                if (!this.validateForm()) {
                    this.isLoading = false;
                    return;
                }

                try {
                    const res = await fetch('{{ route("users.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await res.json();
                    this.users.unshift(data.user);
                    this.modalOpen = false;
                    this.triggerSuccess(data.message);
                } catch (error) {
                    console.error('Add user failed:', error);
                } finally {
                    this.isLoading = false;
                }
            },

            // 🔁 Update User
            async updateUser() {
                this.isLoading = true;
                this.clearErrors();

                if (!this.validateForm(true)) {
                    this.isLoading = false;
                    return;
                }

                try {
                    const res = await fetch('/admin/user-management/' + this.form.id, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await res.json();

                    const index = this.users.findIndex(u => u.id === this.form.id);
                    if (index !== -1) this.users[index] = data.user;

                    this.modalOpen = false;
                    this.triggerSuccess(data.message);
                } catch (error) {
                    console.error('Update user failed:', error);
                } finally {
                    this.isLoading = false;
                }
            },

            // ❌ Remove User
            async remove(id) {
                if (!confirm('Are you sure?')) return;

                const res = await fetch('/user-management/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });

                const data = await res.json();
                this.users = this.users.filter(u => u.id !== id);
                this.triggerSuccess(data.message);
            },

            // ✨ Success Handler
            triggerSuccess(message) {
                this.successMessage = message;
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 1500);
            },

            // 🔎 Search + Filter
            filteredUsers() {
                return this.users.filter(user => {
                    return (
                        (!this.search || user.name.toLowerCase().includes(this.search.toLowerCase())) &&
                        (!this.filterRole || user.role === this.filterRole) &&
                        (!this.filterStatus || user.status === this.filterStatus)
                    );
                });
            },

            // 🧹 Clear Errors
            clearErrors() {
                $('.error-message').text('');
                $('input, select, textarea').removeClass('border-red-500');
            },

            validateForm(isUpdate = false) {
                this.errors = {};
                let hasError = false;


                const nameExists = this.users.some(user =>
                    user.name.toLowerCase() === this.form.name.toLowerCase() && user.id !== this.form.id
                );

                const emailExists = this.users.some(user =>
                    user.email.toLowerCase() === this.form.email.toLowerCase() && user.id !== this.form.id
                );

                // 🔹 Name: required, string, unique
                if (!this.form.name) {
                    this.errors.name = 'Name is required.';
                    hasError = true;
                } else if (
                    isUpdate &&
                    this.users.some(user => user.name.toLowerCase() === this.form.name.toLowerCase() && user.id !== this.form.id)
                ) {
                    this.errors.name = 'Name already exists.';
                    hasError = true;
                } else if (
                    !isUpdate &&
                    this.users.some(user => user.name.toLowerCase() === this.form.name.toLowerCase())
                ) {
                    this.errors.name = 'Name already exists.';
                    hasError = true;
                }

                // 🔹 Email: required, email format, unique
                if (!this.form.email) {
                    this.errors.email = 'Email is required.';
                    hasError = true;
                } else if (!/^\S+@\S+\.\S+$/.test(this.form.email)) {
                    this.errors.email = 'Invalid email format.';
                    hasError = true;
                } else if (
                    isUpdate &&
                    this.users.some(user => user.email.toLowerCase() === this.form.email.toLowerCase() && user.id !== this.form.id)
                ) {
                    this.errors.email = 'Email already exists.';
                    hasError = true;
                } else if (
                    !isUpdate &&
                    this.users.some(user => user.email.toLowerCase() === this.form.email.toLowerCase())
                ) {
                    this.errors.email = 'Email already exists.';
                    hasError = true;
                }

                // 🔹 Role: required, must be in allowed values
                const allowedRoles = ['BHW', 'BNS', 'Midwife'];
                if (!this.form.role) {
                    this.errors.role = 'Role is required.';
                    hasError = true;
                } else if (!allowedRoles.includes(this.form.role)) {
                    this.errors.role = 'Invalid role selected.';
                    hasError = true;
                }

                // 🔹 Assigned Area: required
                if (!this.form.assigned_area) {
                    this.errors.assigned_area = 'Assigned area is required.';
                    hasError = true;
                }

                // 🔹 Status: required, must be in allowed values
                const allowedStatus = ['active', 'inactive'];
                // 🔹 Status: required
                if (!this.form.status) {
                    this.errors.status = 'Status is required.';
                    hasError = true;
                } else if (!allowedStatus.includes(this.form.status)) {
                    this.errors.status = 'Invalid status selected.';
                    hasError = true;
                }

                // 🔹 Password: required (if not updating), string, min:6
                if (!isUpdate) {
                    if (!this.form.password) {
                        this.errors.password = 'Password is required.';
                        hasError = true;
                    } else if (this.form.password.length < 6) {
                        this.errors.password = 'Password must be at least 6 characters.';
                        hasError = true;
                    }
                }

                return !hasError;
            }
        }
    }
</script>