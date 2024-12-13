<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Create User" />
    <div class="container mx-auto px-4 py-6">
      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">Create New User</h2>
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
            <li>Create</li>
          </ol>
        </nav>
      </div>

      <!-- Main Content: Instructions + Form -->
      <div class="flex space-x-6">
        <!-- Instructions Section -->
        <div class="w-1/2 bg-gray-50 p-6 rounded-lg shadow">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">How to Add a User</h3>
          <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li>This show that a field is <strong>required</strong> <code class="text-red-500">*</code></li>
            <li>Fill out the full name of the user in the <strong>Full Name</strong> field.</li>
            <li>Provide a valid email address in the <strong>Email</strong> field.</li>
            <li>Set a secure password for the user in the <strong>Password</strong> field.</li>
            <li>Choose the appropriate role for the user from the <strong>Role</strong> dropdown.</li>
            <li>Click the <strong>Create User</strong> button to save the user.</li>
            <li>Use the <strong>Reset</strong> button if you need to clear all fields.</li>
          </ul>
        </div>

        <!-- Form Section -->
        <div class="w-1/2 bg-white shadow-lg rounded-lg p-6">
            <div v-if="form.errors.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
                <strong class="font-bold">Success! </strong>
                <span class="block sm:inline">{{ form.errors.success }}</span>
            </div>

          <form @submit.prevent="submit">
            <!-- Name -->
            <div class="mb-4">
              <label for="name" class="block text-sm font-semibold text-gray-700">Full Name <code class="text-red-500">*</code></label>
              <input
                v-model="form.name"
                :disabled="form.processing"
                type="text"
                id="name"
                :class="{'border-red-500': form.errors.name}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter full name"
              />
              <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
            </div>

            <!-- Email -->
            <div class="mb-4">
              <label for="email" class="block text-sm font-semibold text-gray-700">Email <code class="text-red-500">*</code></label>
              <input
                v-model="form.email"
                :disabled="form.processing"
                type="email"
                id="email"
                :class="{'border-red-500': form.errors.email}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter email address"
              />
              <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
            </div>

            <!-- Password -->
            <div class="mb-4">
              <label for="password" class="block text-sm font-semibold text-gray-700">Password <code class="text-red-500">*</code></label>
              <input
                v-model="form.password"
                :disabled="form.processing"
                type="password"
                id="password"
                :class="{'border-red-500': form.errors.password}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter password"
              />
              <div v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</div>
            </div>

            <!-- Password Confirmation -->
            <div class="mb-4">
              <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password <code class="text-red-500">*</code></label>
              <input
                v-model="form.password_confirmation"
                :disabled="form.processing"
                type="password"
                id="password_confirmation"
                :class="{'border-red-500': form.errors.password_confirmation}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter password confirmation"
              />
              <div v-if="form.errors.password_confirmation" class="text-red-500">{{ form.errors.password_confirmation }}</div>
            </div>

            <!-- Role -->
            <div class="mb-6">
              <label for="role" class="block text-sm font-semibold text-gray-700">Role <code class="text-red-500">*</code></label>
              <select
                v-model="form.role"
                :disabled="form.processing"
                id="role"
                :class="{'border-red-500': form.errors.role}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              >
                <option value="" disabled>Select a role</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.display_name }}</option>
              </select>
              <div v-if="form.errors.role" class="text-red-500">{{ form.errors.role }}</div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4">
              <button
                type="button"
                @click="resetForm"
                :disabled="form.processing"
                class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
              >
                Reset
              </button>
              <button
                type="submit"
                :disabled="form.processing"
                class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200"
              >
                <span v-if="form.processing">Creating user ...</span>
                <span v-else>Create User</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
import Layout from "../../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        roles: Array
    },
};
</script>


<script setup>

    import { watch } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { useSnackbar } from "vue3-snackbar";

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '',
    });

    const snackbar = useSnackbar();

    watch(() => form.wasSuccessful, (wasSuccessful) => {
        if (wasSuccessful) {
            snackbar.add({
                type: 'success',
                text: 'User created successfully'
            })
        }
    });

    watch(() => form.errors.error, (error) => {
        if (error) {
            snackbar.add({
                type: 'error',
                text: error
            })
        }
    });

    const resetForm = () => {
        if (form.processing) return;
        form.reset();
    };

    const submit = () => {
        form.post('/users', {
        onFinish: () => form.reset(),
        });
    };
</script>

<style scoped>
    .spinner-border {
        width: 1rem;
        height: 1rem;
        border: 2px solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner 0.75s linear infinite;
    }

    @keyframes spinner {
        to {
        transform: rotate(360deg);
        }
    }
</style>
