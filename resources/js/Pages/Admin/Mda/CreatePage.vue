<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Create MDA" />
    <div class="container mx-auto px-4 py-6">
      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">Create New MDA</h2>
          <!-- Back Button -->
          <Link
            href="/mdas"
            class="flex items-center bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
          >
            <i class="fas fa-arrow-left mr-2"></i>
            Back to MDAs
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
              <Link href="/mdas" class="hover:text-purple-600">MDAs</Link>
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
          <h3 class="text-xl font-semibold text-gray-800 mb-4">How to Add an MDA</h3>
          <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li>This show that a field is <strong>required</strong> <code class="text-red-500">*</code></li>
            <li>Select the department of the MDA in the <strong>Department</strong> field.</li>
            <li>Select the title of the MDA in the <strong>Title</strong> field.</li>
            <li>Fill out the firstnames of the MDA in the <strong>Firstnames</strong> field.</li>
            <li>Fill out the surname of the MDA in the <strong>Surname</strong> field.</li>
            <li>Fill out the phone of the MDA in the <strong>Phone</strong> field.</li>
            <li>Fill out the address of the MDA in the <strong>Address</strong> field.</li>
            <li>Provide a valid email address in the <strong>Email</strong> field.</li>
            <li>Click the <strong>Create MDA</strong> button to save the MDA.</li>
            <li>Use the <strong>Reset</strong> button if you need to clear all fields.</li>
          </ul>
        </div>

        <!-- Form Section -->
        <div class="w-1/2 bg-white shadow-lg rounded-lg p-6">

          <form @submit.prevent="submit">
            <div class="mb-6">
              <label for="department_id" class="block text-sm font-semibold text-gray-700">Department <code class="text-red-500">*</code></label>
              <select
                v-model="form.department_id"
                :disabled="form.processing"
                id="department_id"
                :class="{'border-red-500': form.errors.department_id}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              >
                <option value="" disabled>Select a department</option>
                <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
              </select>
              <div v-if="form.errors.department_id" class="text-red-500">{{ form.errors.department_id }}</div>
            </div>

            <div class="mb-6">
              <label for="title" class="block text-sm font-semibold text-gray-700">Title <code class="text-red-500">*</code></label>
              <select
                v-model="form.title"
                :disabled="form.processing"
                id="title"
                :class="{'border-red-500': form.errors.title}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              >
                <option value="" disabled>Select a title</option>
                <option v-for="title in titles" :key="title.id" :value="title.name">{{ title.name }}</option>
              </select>
              <div v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</div>
            </div>


            <div class="mb-4">
              <label for="firstnames" class="block text-sm font-semibold text-gray-700">Firstnames <code class="text-red-500">*</code></label>
              <input
                v-model="form.firstnames"
                :disabled="form.processing"
                type="text"
                id="firstnames"
                :class="{'border-red-500': form.errors.firstnames}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter firstnames"
              />
              <div v-if="form.errors.firstnames" class="text-red-500">{{ form.errors.firstnames }}</div>
            </div>

            <div class="mb-4">
              <label for="surname" class="block text-sm font-semibold text-gray-700">Surname <code class="text-red-500">*</code></label>
              <input
                v-model="form.surname"
                :disabled="form.processing"
                type="text"
                id="surname"
                :class="{'border-red-500': form.errors.surname}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter surname"
              />
              <div v-if="form.errors.surname" class="text-red-500">{{ form.errors.surname }}</div>
            </div>

            <div class="mb-4">
              <label for="phone" class="block text-sm font-semibold text-gray-700">Phone <code class="text-red-500">*</code></label>
              <input
                v-model="form.phone"
                :disabled="form.processing"
                type="text"
                id="phone"
                :class="{'border-red-500': form.errors.phone}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter phone"
              />
              <div v-if="form.errors.phone" class="text-red-500">{{ form.errors.phone }}</div>
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

            <div class="mb-4">
              <label for="address" class="block text-sm font-semibold text-gray-700">Address <code class="text-red-500">*</code></label>
              <input
                v-model="form.address"
                :disabled="form.processing"
                type="text"
                id="address"
                :class="{'border-red-500': form.errors.address}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter address"
              />
              <div v-if="form.errors.address" class="text-red-500">{{ form.errors.address }}</div>
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
                <span v-if="form.processing">Creating MDA ...</span>
                <span v-else>Create MDA</span>
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
        departments: Array,
        titles: Array
    },
};
</script>


<script setup>

    import { watch } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { useSnackbar } from "vue3-snackbar";

    const form = useForm({
        department_id: '',
        title: '',
        firstnames: '',
        surname: '',
        phone: '',
        email: '',
        address: '',
    });

    const snackbar = useSnackbar();

    watch(() => form.wasSuccessful, (wasSuccessful) => {
        if (wasSuccessful) {
            snackbar.add({
                type: 'success',
                text: 'MDA was created successfully'
            })
        }
    });

    watch(() => form.errors.error, (error) => {
        if (error) {
            snackbar.add({
                type: 'error',
                text: error ?? 'An error occured please try again later!'
            })
        }
    });

    const resetForm = () => {
        if (form.processing) return;
        form.reset();
    };

    const submit = () => {
        form.post('/mdas', {
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
