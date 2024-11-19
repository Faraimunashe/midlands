<template>
    <Head title="Quarters" />
    <div class="container mx-auto px-4">
      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">Quarter Management</h2>
          <!-- Add User Button -->
          <a
            href="/quarters/create"
            class="flex items-center bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200 transform hover:scale-105"
          >
            <i class="fas fa-user-plus mr-2"></i>
            Add Quarter
          </a>
        </div>
        <!-- Breadcrumb -->
        <nav class="text-gray-500 text-sm mt-2">
          <ol class="list-reset flex">
            <li>
              <Link href="/authentication" class="hover:text-purple-600">Home</Link>
            </li>
            <li><span class="mx-2">/</span></li>
            <li>Quarters</li>
          </ol>
        </nav>
      </div>

      <!-- Search Input -->
      <div class="mb-4">
            <input
                v-model="search"
                type="text"
                placeholder="Search quarters ..."
                class="w-full lg:w-1/2 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600"
            />
        </div>


      <!-- User List Table -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-800">Quarters</h3>
        </div>
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">ID</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Name</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Start Date</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">End Date</th>
              <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="quarter in quarters.data"
              :key="quarter.id"
              class="hover:bg-gray-50 transition-colors"
            >
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ quarter.id }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ quarter.name }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ quarter.start_date }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ quarter.end_date }}</td>
              <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800 flex space-x-2">
                <Link
                  :href="'/quarters/'+quarter.id+'/edit'"
                  class="flex items-center text-blue-600 hover:text-blue-700 transition-colors"
                >
                  <i class="fas fa-edit mr-1"></i>Edit
                </Link>
                <button
                  @click="showDeleteModal(quarter.id)"
                  class="flex items-center text-red-600 hover:text-red-700 transition-colors"
                >
                  <i class="fas fa-trash-alt mr-1"></i>Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination :links="quarters.links" />

      <!-- Delete Confirmation Modal -->
      <div
        v-if="isModalVisible"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50"
      >
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
          <h3 class="text-lg font-semibold text-gray-800">Confirm Delete</h3>
          <p class="text-gray-600 mt-4">Are you sure you want to delete this quarter?</p>
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
              Yes Delete
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
      quarters: Object,
    },
    components: {
        Pagination
    },
    setup() {
      const search = ref("");
      const isModalVisible = ref(false);
      const quarterIdToDelete = ref(null);

      const showDeleteModal = (userId) => {
        quarterIdToDelete.value = userId;
        isModalVisible.value = true;
      };

      const handleDelete = () => {
        router.delete(`/quarters/${quarterIdToDelete.value}`, {
          preserveState: true,
          onFinish: () => {
            isModalVisible.value = false;
            quarterIdToDelete.value = null;
          },
        });
      };

      watch(search, (value) => {
        router.get(
          "/quarters",
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
        quarterIdToDelete,
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
