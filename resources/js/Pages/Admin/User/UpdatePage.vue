<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="User Details" />
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header and Breadcrumb -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800">User Details</h2>
                <!-- Back Button -->
                <Link
                    href="/users"
                    class="flex items-center bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Users
                </Link>
            </div>
            <!-- Breadcrumb -->
            <nav class="text-gray-500 text-sm mt-2">
                <ol class="list-reset flex">
                    <li>
                        <Link href="/authentication" class="hover:text-purple-600">Home</Link>
                    </li>
                    <li><span class="mx-2">/</span></li>
                    <li>
                        <Link href="/users" class="hover:text-purple-600">Users</Link>
                    </li>
                    <li><span class="mx-2">/</span></li>
                    <li>Edit</li>
                </ol>
            </nav>
        </div>

        <!-- User Details Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">User Information</h3>
                <!-- Actions -->
                <div class="flex space-x-4 ml-auto">
                    <button
                        @click="toggleEdit"
                        class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200"
                    >
                        <i class="fas fa-edit mr-2"></i>
                        {{ isEditing ? 'Cancel' : 'Edit' }}
                    </button>
                </div>
            </div>
            <div class="mt-6 space-y-4">
                <!-- Full Name -->
                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Full Name:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.name"
                            @blur="updateUser"
                            type="text"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.name }}</span>
                </div>
                <!-- Email -->
                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Email:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.email"
                            @blur="updateUser"
                            type="email"
                            :class="{'border-red-500': form.errors.email}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.email }}</span>
                </div>
                <!-- Role -->
                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Role:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <select
                            v-model="form.role"
                            @blur="updateUser"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        >
                            <option value="" disabled>Select a role</option>
                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                {{ role.display_name }}
                            </option>
                        </select>
                    </div>
                    <span v-else class="text-gray-800">{{ selectedRole }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

---

### Script
```javascript
<script>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSnackbar } from "vue3-snackbar";
import Layout from "../../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        user: {
            type: Object,
            required: true,
        },
        roles: {
            type: Array,
            required: true,
        },
    },
    setup(props) {
        const snackbar = useSnackbar();
        const isEditing = ref(false);

        // Prepare form with user data
        const form = useForm({
            name: props.user.name,
            email: props.user.email,
            role: props.user.roles[0]?.id || "",
        });

        // Get selected role's display name
        const selectedRole = computed(() => {
            const role = props.roles.find((r) => r.id === form.role);
            return role ? role.display_name : "N/A";
        });

        // Toggle edit mode
        const toggleEdit = () => {
            isEditing.value = !isEditing.value;
        };

        // Update user details
        const updateUser = () => {
            if (!isEditing.value) return;

            form.put(`/users/${props.user.id}`, {
                preserveState: true,
                onSuccess: () => {
                    snackbar.add({
                        type: "success",
                        text: "User updated successfully.",
                    });
                    isEditing.value = false;
                },
                onError: () => {
                    snackbar.add({
                        type: "error",
                        text: form.errors.error,
                    });
                },
            });
        };

        return {
            isEditing,
            form,
            toggleEdit,
            updateUser,
            selectedRole,
        };
    },
};
</script>
