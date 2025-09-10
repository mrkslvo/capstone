<script setup>
import { ref, computed } from "vue";

const props = defineProps({
    users: Array,
    loggedUser: Object
});
const emit = defineEmits(["close"]);


const toggleMessage = ref(false); // false = users list, true = message box
const selectedUser = ref(null);

// search query
const search = ref("");

// messages per user (simple local state)
const messages = ref({}); // { userId: [ { text, sender, time } ] }

// new message input
const newMessage = ref("");

// computed filtered users
const filteredUsers = computed(() => {
    if (!search.value) return props.users;
    return props.users.filter(
        (user) =>
            user.fullname.toLowerCase().includes(search.value.toLowerCase()) ||
            user.role.toLowerCase().includes(search.value.toLowerCase())
    );
});

function openMessage(user) {
    selectedUser.value = user;
    toggleMessage.value = true;
}

function backToUsers() {
    selectedUser.value = null;
    toggleMessage.value = false;
}

function sendMessage() {
    if (!newMessage.value.trim() || !selectedUser.value) return;

    const id = selectedUser.value.id;
    if (!messages.value[id]) messages.value[id] = [];

    messages.value[id].push({
        text: newMessage.value,
        sender: "me",
        time: new Date().toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
        }),
    });

    newMessage.value = "";
}
</script>

<template>
    <!-- Users Sidebar -->
    <div
        v-if="!toggleMessage"
        class="fixed top-0 right-0 w-80 h-full bg-blue-50 shadow-2xl z-50 flex flex-col p-4"
    >
        <!-- Header -->
        <div
            class="flex justify-between items-center border-b border-blue-200 pb-2"
        >
            <h2 class="text-lg font-semibold text-blue-700">Messages</h2>
            <button
                class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg shadow hover:bg-blue-600"
                @click="emit('close')"
            >
                Close
            </button>

        </div>

        <!-- Search -->
        <div class="mt-3">
            <input
                v-model="search"
                type="text"
                placeholder="Search..."
                class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
        </div>

        <!-- Users List -->
        <div class="flex-1 overflow-y-auto mt-4">
            <ul class="space-y-2">
                <li v-for="user in filteredUsers" :key="user.id">
                    <button
                        @click="openMessage(user)"
                        class="w-full text-left px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 shadow-sm"
                    >
                        {{ user.fullname }}
                        <span class="text-xs text-blue-500"
                            >({{ user.role }})</span
                        >
                    </button>
                </li>
                <li
                    v-if="filteredUsers.length === 0"
                    class="text-center text-blue-500 text-sm py-4"
                >
                    No users found
                </li>
            </ul>
        </div>
    </div>

    <!-- Message Box -->
    <div
        v-else
        class="fixed bottom-0 right-16 rounded-md w-96 h-1/2 bg-blue-50 shadow-2xl z-50 flex flex-col"
    >
        <!-- Header -->
        <div
            class="flex justify-between items-center border-b border-blue-200 px-4 py-2"
        >
            <h2 class="text-lg font-semibold text-blue-700">
                Chat with {{ selectedUser?.fullname }}
            </h2>
            <button
                class="px-3 py-1 bg-gray-400 text-white text-sm rounded-lg shadow hover:bg-gray-500"
                @click="backToUsers"
            >
                Back
            </button>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-3 space-y-2 text-gray-700">
            <div
                v-for="(msg, i) in messages[selectedUser?.id] || []"
                :key="i"
                :class="msg.sender === 'me' ? 'text-right' : 'text-left'"
            >
                <span
                    :class="
                        msg.sender === 'me'
                            ? 'inline-block bg-blue-500 text-white px-3 py-1 rounded-lg'
                            : 'inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-lg'
                    "
                >
                    {{ msg.text }}
                </span>
                <div class="text-xs text-gray-400 mt-1">
                    {{ msg.time }}
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 border-t border-blue-200 flex items-center gap-2">
            <input
                v-model="newMessage"
                type="text"
                placeholder="Type a message..."
                class="flex-1 px-3 py-2 text-sm border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                @keyup.enter="sendMessage"
            />
            <button
                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600"
                @click="sendMessage"
            >
                Send
            </button>
        </div>
    </div>
</template>
