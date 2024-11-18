<template>
    <Head title="Users" />
    <div class="container mx-auto px-4">

      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">User Management</h2>
          <!-- Add User Button -->
          <a
            href="/users/create"
            class="flex items-center bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200 transform hover:scale-105"
          >
            <i class="fas fa-user-plus mr-2"></i>
            Add User
            </a>
        </div>
        <!-- Breadcrumb -->
        <nav class="text-gray-500 text-sm mt-2">
          <ol class="list-reset flex">
            <li>
              <router-link to="/" class="hover:text-purple-600">Home</router-link>
            </li>
            <li><span class="mx-2">/</span></li>
            <li>User Management</li>
          </ol>
        </nav>
      </div>

      <!-- User List Table -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-800">Users and Roles</h3>
        </div>
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">ID</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Name</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Email</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Role</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="user in users.data"
              :key="user.id"
              class="hover:bg-gray-50 transition-colors"
            >
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ user.id }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ user.name }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ user.email }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ user.roles }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800 flex space-x-2">
                <button
                  @click="editUser(user.id)"
                  class="flex items-center text-blue-600 hover:text-blue-700 transition-colors"
                >
                  <i class="fas fa-edit mr-1"></i>Edit
                </button>
                <button
                  @click="deleteUser(user.id)"
                  class="flex items-center text-red-600 hover:text-red-700 transition-colors"
                >
                  <i class="fas fa-trash-alt mr-1"></i>Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script>
  import Layout from "../../Shared/Layout.vue";

  export default {
    layout: Layout,
    props: {
        users: Array
    },
    methods: {
      addUser() {
        console.log("Add User button clicked");
      },
      editUser(userId) {
        console.log("Edit User button clicked for user:", userId);
      },
      deleteUser(userId) {
        console.log("Delete User button clicked for user:", userId);
      },
    },
  };
  </script>

  <style scoped>
  table th {
    background-color: #f8f8f8;
  }

  button {
    transition: transform 0.2s ease;
  }
  </style>
