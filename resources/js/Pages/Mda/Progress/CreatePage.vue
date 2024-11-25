<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Upload Progress" />
    <div class="container mx-auto px-4 py-6">
      <!-- Page Header -->
      <div class="mb-6">
        <div class="flex justify-between items-center">
          <h2 class="text-3xl font-semibold text-gray-800">Upload Progress</h2>
          <Link
            href="/targets"
            class="flex items-center bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
          >
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Targets
          </Link>
        </div>
      </div>

      <!-- Main Content -->
      <div class="flex space-x-6">
        <!-- Instructions Section -->
        <div class="w-1/2 bg-gray-50 p-6 rounded-lg shadow">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">How to Upload Progress</h3>
          <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li>Fill in the progress percentage in the <strong>Progress Percent</strong> field.</li>
            <li>Provide a brief description of the progress in the <strong>Description</strong> field.</li>
            <li>Attach any supporting evidence files using the <strong>Evidence</strong> upload field.</li>
            <li>Click the <strong>Upload Progress</strong> button to save the progress.</li>
          </ul>
        </div>

        <!-- Form Section -->
        <div class="w-1/2 bg-white shadow-lg rounded-lg p-6">
          <form @submit.prevent="submit">
            <!-- Progress Percent -->
            <div class="mb-6">
              <label for="progress_percent" class="block text-sm font-semibold text-gray-700">Progress Percent <code class="text-red-500">*</code></label>
              <input
                v-model="form.progress_percent"
                type="number"
                id="progress_percent"
                :class="{'border-red-500': form.errors.progress_percent}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter progress percentage"
              />
              <div v-if="form.errors.progress_percent" class="text-red-500">{{ form.errors.progress_percent }}</div>
            </div>

            <!-- Description -->
            <div class="mb-6">
              <label for="description" class="block text-sm font-semibold text-gray-700">Description <code class="text-red-500">*</code></label>
              <textarea
                v-model="form.description"
                id="description"
                :class="{'border-red-500': form.errors.description}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                placeholder="Enter progress description"
                rows="4"
              ></textarea>
              <div v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</div>
            </div>

            <!-- Evidence Upload -->
            <div class="mb-6">
              <label for="evidence" class="block text-sm font-semibold text-gray-700">Evidence <code class="text-red-500">*</code></label>
              <input
                @input="form.evidence = Array.from($event.target.files)"
                type="file"
                id="evidence"
                multiple
                :class="{'border-red-500': form.errors.evidence}"
                class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
              />
              <div v-if="form.errors.evidence" class="text-red-500">{{ form.errors.evidence }}</div>
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
                <span v-if="form.processing">Uploading...</span>
                <span v-else>Upload Progress</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

<script>
  import Layout from "../../../Shared/Layout.vue";
  import { ref, watch } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import { useSnackbar } from "vue3-snackbar";

  export default {
    layout: Layout,
    props: {
      targetId: {
        type: String,
        required: true,
      },
    },
    setup(props) {
      const snackbar = useSnackbar();

      const form = useForm({
        progress_percent: "",
        description: "",
        evidence: null,
      });

      const submit = () => {
        form.post(`/targets/${props.targetId}/progress`, {
            preserveScroll: true,
            onSuccess: () => {
                snackbar.add({
                    type: "success",
                    text: "Progress uploaded successfully!",
                });
                form.reset();
            },
            onError: () => {
                snackbar.add({
                    type: "error",
                    text: form.errors.error ?? "An error occurred. Please try again.",
                });
            },
        });
    };

      const resetForm = () => {
        form.reset();
        document.getElementById("evidence").value = "";
      };

      return {
        form,
        submit,
        resetForm,
        snackbar,
      };
    },
  };
</script>
