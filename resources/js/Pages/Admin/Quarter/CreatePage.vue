<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Create Quarter" />
    <div class="container mx-auto px-4 py-6">
      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">Create New Quarter</h2>
          <!-- Back Button -->
          <Link
            href="/quarters"
            class="flex items-center bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
          >
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Quarters
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
              <Link href="/quarters" class="hover:text-purple-600">Quarters</Link>
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
          <h3 class="text-xl font-semibold text-gray-800 mb-4">How to Add a Quarter</h3>
          <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li>This show that a field is <strong>required</strong> <code class="text-red-500">*</code></li>
            <li>Fill out the full name of the quarter in the <strong>Name</strong> field.</li>
            <li>Pick a start date of the quarter in the <strong>Start Date</strong> field.</li>
            <li>Pick a end date of the quarter in the <strong>End Date</strong> field.</li>
            <li><strong>NB:</strong> <code class="text-red-500">Quarter dates must not overlap into other quarters!</code></li>
            <li>Click the <strong>Create Quarter</strong> button to save the quarter.</li>
            <li>Use the <strong>Reset</strong> button if you need to clear all fields.</li>
          </ul>
        </div>

        <!-- Form Section -->
        <div class="w-1/2 bg-white shadow-lg rounded-lg p-6">

          <form @submit.prevent="submit">
            <!-- Name -->
            <div class="mb-4">
              <label for="name" class="block text-sm font-semibold text-gray-700">Quarter Name <code class="text-red-500">*</code></label>
              <input
                v-model="form.name"
                :disabled="form.processing"
                type="text"
                id="name"
                :class="{'border-red-500': form.errors.name}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter department name"
              />
              <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
            </div>

            <div class="mb-4">
              <label for="start_date" class="block text-sm font-semibold text-gray-700">Start Date <code class="text-red-500">*</code></label>
              <input
                v-model="form.start_date"
                :disabled="form.processing"
                type="date"
                id="start_date"
                :class="{'border-red-500': form.errors.start_date}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              />
              <div v-if="form.errors.start_date" class="text-red-500">{{ form.errors.start_date }}</div>
            </div>

            <div class="mb-4">
              <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date <code class="text-red-500">*</code></label>
              <input
                v-model="form.end_date"
                :disabled="form.processing"
                type="date"
                id="end_date"
                :class="{'border-red-500': form.errors.end_date}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              />
              <div v-if="form.errors.end_date" class="text-red-500">{{ form.errors.end_date }}</div>
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
                <span v-if="form.processing">Creating quarter ...</span>
                <span v-else>Create Quarter</span>
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
};
</script>


<script setup>

    import { watch } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { useSnackbar } from "vue3-snackbar";

    const form = useForm({
        name: '',
        start_date: '',
        end_date: ''
    });

    const snackbar = useSnackbar();

    watch(() => form.wasSuccessful, (wasSuccessful) => {
        if (wasSuccessful) {
            snackbar.add({
                type: 'success',
                text: 'Quarter was created successfully'
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
        form.post('/quarters', {
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
