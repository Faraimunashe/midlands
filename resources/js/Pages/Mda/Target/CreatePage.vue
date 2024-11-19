<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Create Target" />
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header and Breadcrumb -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800">Create New Target</h2>
                <!-- Back Button -->
                <Link
                    href="/targets"
                    class="flex items-center bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Targets
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
                        <Link href="/targets" class="hover:text-purple-600">Targets</Link>
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
                <h3 class="text-xl font-semibold text-gray-800 mb-4">How to Add a Target</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Fields marked with <code class="text-red-500">*</code> are required.</li>
                    <li>Select the department related to this target in the <strong>Department</strong> field.</li>
                    <li>Provide the title and description of the target.</li>
                    <li>Select a status for the target, e.g., "In Progress" or "Completed".</li>
                    <li>Provide a start date, and optionally, an end date.</li>
                    <li>Click <strong>Create Target</strong> to save the target.</li>
                    <li>Use <strong>Reset</strong> to clear all fields.</li>
                </ul>
            </div>

            <!-- Form Section -->
            <div class="w-1/2 bg-white shadow-lg rounded-lg p-6">

                <form @submit.prevent="submit">

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-semibold text-gray-700">Title <code class="text-red-500">*</code></label>
                        <input
                            v-model="form.title"
                            :disabled="form.processing"
                            type="text"
                            id="title"
                            :class="{'border-red-500': form.errors.title}"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                            placeholder="Enter target title"
                        />
                        <div v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700">Description <code class="text-red-500">*</code></label>
                        <textarea
                            v-model="form.description"
                            :disabled="form.processing"
                            id="description"
                            :class="{'border-red-500': form.errors.description}"
                            class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                            placeholder="Enter target description"
                            rows="4"
                        ></textarea>
                        <div v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</div>
                    </div>

                    <!-- Start Date -->
                    <div class="mb-6">
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

                    <!-- End Date -->
                    <div class="mb-6">
                        <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date</label>
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
                            <span v-if="form.processing">Creating Target...</span>
                            <span v-else>Create Target</span>
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
import { watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSnackbar } from "vue3-snackbar";

const form = useForm({
    title: "",
    description: "",
    start_date: "",
    end_date: "",
});

const snackbar = useSnackbar();

watch(
    () => form.wasSuccessful,
    (wasSuccessful) => {
        if (wasSuccessful) {
            snackbar.add({
                type: "success",
                text: "Target created successfully",
            });
        }
    }
);

const resetForm = () => {
    if (form.processing) return;
    form.reset();
};

const submit = () => {
    form.post("/targets", {
        onFinish: () => form.reset(),
    });
};
</script>
