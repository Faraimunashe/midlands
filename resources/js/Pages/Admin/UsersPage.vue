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

      <!-- Search Input -->
      <div class="mb-4">
            <input
                v-model="search"
                type="text"
                placeholder="Search users..."
                class="w-full lg:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600"
            />
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
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Roles</th>
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
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">
                <span
                  v-for="role in user.roles"
                  :key="role.id"
                  class="inline-block px-2 mr-1 text-xs font-medium text-white bg-gray-600 rounded-full"
                >
                  {{ role.display_name }}
                </span>
              </td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800 flex space-x-2">
                <Link
                  :href="'/users/'+user.id+'/edit'"
                  class="flex items-center text-blue-600 hover:text-blue-700 transition-colors"
                >
                  <i class="fas fa-edit mr-1"></i>Edit
                </Link>
                <button
                  @click="showDeleteModal(user.id)"
                  class="flex items-center text-red-600 hover:text-red-700 transition-colors"
                >
                  <i class="fas fa-trash-alt mr-1"></i>Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination :links="users.links" />

      <!-- Delete Confirmation Modal -->
      <div
        v-if="isModalVisible"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50"
      >
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
          <h3 class="text-lg font-semibold text-gray-800">Confirm Delete</h3>
          <p class="text-gray-600 mt-4">Are you sure you want to delete this user?</p>
          <div class="mt-6 flex justify-end space-x-4">
            <button
              @click="isModalVisible = false"
              class="bg-gray-200 px-4 py-2 rounded text-gray-800 hover:bg-gray-300"
            >
              Cancel
            </button>
            <button
              @click="handleDelete"
              class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>

<script>
  import { ref, watch } from "vue";
  import { router } from "@inertiajs/vue3";
  import Layout from "../../Shared/Layout.vue";
  import Pagination from "../../Shared/Pagination.vue";

  export default {
    layout: Layout,
    props: {
      users: Object,
    },
    components: {
        Pagination
    },
    setup() {
      const search = ref("");
      const isModalVisible = ref(false);
      const userIdToDelete = ref(null);

      const showDeleteModal = (userId) => {
        userIdToDelete.value = userId;
        isModalVisible.value = true;
      };

      const handleDelete = () => {
        router.delete(`/users/${userIdToDelete.value}`, {
          preserveState: true,
          onFinish: () => {
            isModalVisible.value = false;
            userIdToDelete.value = null;
          },
        });
      };

      watch(search, (value) => {
        router.get(
          "/users",
          { search: value },
          {
            preserveState: true,
            preserveScroll: true,
            replace: true,
          }
        );
      });

      return {
        search,
        isModalVisible,
        userIdToDelete,
        showDeleteModal,
        handleDelete,
      };
    },
  };
  </script>

  <style scoped>
  .fixed {
    z-index: 50;
  }
  </style>
