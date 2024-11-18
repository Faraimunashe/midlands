<template>
    <Head title="Create User" />
    <div class="container mx-auto px-4 py-6">
      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">Create User</h2>
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
              <Link to="/authentication" class="hover:text-purple-600">Home</Link>
            </li>
            <li><span class="mx-2">/</span></li>
            <li>
              <Link to="/users" class="hover:text-purple-600">Users</Link>
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
            <li>This show that a field is <strong>required</strong> <code class="text-red-500">*</code> </li>
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
          <form @submit.prevent="createUser">
            <!-- Name -->
            <div class="mb-4">
              <label for="name" class="block text-sm font-semibold text-gray-700">Full Name <code class="text-red-500">*</code></label>
              <input
                v-model="form.name"
                type="text"
                id="name"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter full name"
              />
            </div>

            <!-- Email -->
            <div class="mb-4">
              <label for="email" class="block text-sm font-semibold text-gray-700">Email <code class="text-red-500">*</code></label>
              <input
                v-model="form.email"
                type="email"
                id="email"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter email address"
              />
            </div>

            <!-- Password -->
            <div class="mb-4">
              <label for="password" class="block text-sm font-semibold text-gray-700">Password <code class="text-red-500">*</code></label>
              <input
                v-model="form.password"
                type="password"
                id="password"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter password"
              />
            </div>

            <!-- Password Confirmation-->
            <div class="mb-4">
              <label for="password" class="block text-sm font-semibold text-gray-700">Confirm Password <code class="text-red-500">*</code></label>
              <input
                v-model="form.password_confirmation"
                type="password"
                id="password_confirmation"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter password confirmation"
              />
            </div>

            <!-- Role -->
            <div class="mb-6">
              <label for="role" class="block text-sm font-semibold text-gray-700">Role <code class="text-red-500">*</code></label>
              <select
                v-model="form.role"
                id="role"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              >
                <option value="" disabled>Select a role</option>
                <option value="Admin">Admin</option>
                <option value="Editor">Editor</option>
                <option value="User">User</option>
              </select>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4">
              <button
                type="button"
                @click="resetForm"
                class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
              >
                Reset
              </button>
              <button
                type="submit"
                class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200"
              >
                Create User
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script>
  import Layout from '../../../Shared/Layout.vue';
  export default {
    layout: Layout,
    data() {
      return {
        form: {
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
          role: "",
        },
      };
    },
    methods: {
      createUser() {
        if (this.form.name && this.form.email && this.form.password && this.form.role) {
          console.log("User created:", this.form);
          alert("User successfully created!");
          this.$router.push("/user-management");
        } else {
          alert("Please fill in all fields.");
        }
      },
      resetForm() {
        this.form = {
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
          role: "",
        };
      },
    },
  };
  </script>

  <style scoped>
  form label {
    margin-bottom: 0.5rem;
  }

  form input,
  form select {
    transition: all 0.2s ease-in-out;
  }

  form input:focus,
  form select:focus {
    box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.5);
  }
  </style>
