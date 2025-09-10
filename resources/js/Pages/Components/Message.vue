<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios"; // ✅ use axios for fetching old messages

const props = defineProps({
    users: Array,
    loggedUser: Object,
});

const emit = defineEmits(["close"]);

const toggleMessage = ref(false);
const selectedUser = ref(null);

const search = ref("");
const messages = ref({});
const newMessage = ref("");

// authenticated user will not display
const filteredUsers = computed(() => {
    const list = props.users.filter((u) => u.id !== props.loggedUser.id);
    if (!search.value) return list;
    return list.filter(
        (user) =>
            user.fullname.toLowerCase().includes(search.value.toLowerCase()) ||
            user.role.toLowerCase().includes(search.value.toLowerCase())
    );
});


async function openMessage(user) {
    selectedUser.value = user;
    toggleMessage.value = true;

    // ✅ fetch all messages from backend
    try {
        const res = await axios.get(route("messages.index", user.id));
        messages.value[user.id] = res.data;
    } catch (e) {
        console.error("Failed to fetch messages:", e);
    }
}

function backToUsers() {
    selectedUser.value = null;
    toggleMessage.value = false;
}

async function sendMessage() {
    if (!newMessage.value.trim() || !selectedUser.value) return;

    const content = newMessage.value;
    const id = selectedUser.value.id;

    if (!messages.value[id]) messages.value[id] = [];

    // show message instantly in UI
    messages.value[id].push({
        content,
        sender_id: props.loggedUser.id,
        receiver_id: id,
        created_at: new Date().toISOString(),
    });

    newMessage.value = "";

    // save to DB and reload messages
    await router.post(
        route("messages.store", id),
        { content },
        {
            preserveScroll: true,
            onSuccess: () => fetchMessages(id), // ✅ reload messages after send
        }
    );
}

</script>

<template>
    <!-- Users Sidebar -->
    <div v-if="!toggleMessage" class="fixed top-0 right-0 w-80 h-full bg-blue-50 shadow-2xl z-50 flex flex-col p-4">
        <div class="flex justify-between items-center border-b border-blue-200 pb-2">
            <h2 class="text-lg font-semibold text-blue-700">Messages</h2>
            <button @click="emit('close')" class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg shadow hover:bg-blue-600">
                Close
            </button>
        </div>

        <!-- Search -->
        <div class="mt-3">
            <input v-model="search" type="text" placeholder="Search..."
                class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <!-- Users List -->
        <div class="flex-1 overflow-y-auto mt-4">
            <ul class="space-y-2">
                <li v-for="user in filteredUsers" :key="user.id">
                    <button @click="openMessage(user)"
                        class="w-full text-left px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 shadow-sm">
                        {{ user.fullname }}
                        <span class="text-xs text-blue-500">({{ user.role }})</span>
                    </button>
                </li>
                <li v-if="filteredUsers.length === 0" class="text-center text-blue-500 text-sm py-4">
                    No users found
                </li>
            </ul>
        </div>
    </div>

    <!-- Message Box -->
    <div v-else class="fixed bottom-0 right-16 rounded-md w-96 h-1/2 bg-blue-50 shadow-2xl z-50 flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center border-b border-blue-200 px-4 py-2">
            <h2 class="text-lg font-semibold text-blue-700">
                Chat with {{ selectedUser?.fullname }}
            </h2>
            <button @click="backToUsers"
                class="px-3 py-1 bg-gray-400 text-white text-sm rounded-lg shadow hover:bg-gray-500">
                Back
            </button>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-3 space-y-2 text-gray-700">
            <div v-for="(msg, i) in messages[selectedUser?.id] || []" :key="i"
                :class="msg.sender_id === props.loggedUser.id ? 'text-right' : 'text-left'">
                <span
                    :class="msg.sender_id === props.loggedUser.id
                        ? 'inline-block bg-blue-500 text-white px-3 py-1 rounded-lg'
                        : 'inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-lg'">
                    {{ msg.content }}
                </span>
                <div class="text-xs text-gray-400 mt-1">
                    {{ new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 border-t border-blue-200 flex items-center gap-2">
            <input v-model="newMessage" type="text" placeholder="Type a message..."
                class="flex-1 px-3 py-2 text-sm border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                @keyup.enter="sendMessage" />
            <button @click="sendMessage"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">
                Send
            </button>
        </div>
    </div>
</template>
