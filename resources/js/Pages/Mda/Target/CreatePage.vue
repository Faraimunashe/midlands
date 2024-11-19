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

        <!-- Wizard Navigation -->
        <div class="flex space-x-4 mb-6">
            <button
                v-for="(step, index) in steps"
                :key="index"
                @click="currentStep = index"
                :class="stepButtonClass(index)"
                class="px-4 py-2 rounded border transition duration-200"
            >
                {{ step.label }}
            </button>
        </div>

        <!-- Wizard Steps -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <form @submit.prevent="submit">
                <!-- Step 1: Title -->
                <div v-if="currentStep === 0">
                    <label for="title" class="block text-sm font-semibold text-gray-700">Title <code class="text-red-500">*</code></label>
                    <input
                        v-model="form.title"
                        :disabled="form.processing"
                        type="text"
                        id="title"
                        :class="inputClass(form.errors.title)"
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter target title"
                    />
                    <div v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</div>
                </div>

                <!-- Step 2: Description -->
                <div v-if="currentStep === 1">
                    <label for="description" class="block text-sm font-semibold text-gray-700">Description <code class="text-red-500">*</code></label>
                    <textarea
                        v-model="form.description"
                        :disabled="form.processing"
                        id="description"
                        :class="inputClass(form.errors.description)"
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter target description"
                        rows="4"
                    ></textarea>
                    <div v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</div>
                </div>

                <!-- Step 3: Start Date -->
                <div v-if="currentStep === 2">
                    <label for="start_date" class="block text-sm font-semibold text-gray-700">Start Date <code class="text-red-500">*</code></label>
                    <input
                        v-model="form.start_date"
                        :disabled="form.processing"
                        type="date"
                        id="start_date"
                        :class="inputClass(form.errors.start_date)"
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                    />
                    <div v-if="form.errors.start_date" class="text-red-500">{{ form.errors.start_date }}</div>
                </div>

                <!-- Step 4: End Date -->
                <div v-if="currentStep === 3">
                    <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date</label>
                    <input
                        v-model="form.end_date"
                        :disabled="form.processing"
                        type="date"
                        id="end_date"
                        :class="inputClass(form.errors.end_date)"
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                    />
                    <div v-if="form.errors.end_date" class="text-red-500">{{ form.errors.end_date }}</div>
                </div>

                <!-- Step 5: Quarters Selection -->
                <div v-if="currentStep === 4">
                    <label for="quarters" class="block text-sm font-semibold text-gray-700">Quarters <code class="text-red-500">*</code></label>
                    <div class="mt-2 space-y-2">
                        <div v-for="quarter in quarters" :key="quarter.id" class="flex items-center">
                            <input
                                type="checkbox"
                                :id="`quarter-${quarter.id}`"
                                :value="quarter.id"
                                v-model="form.quarters"
                                class="mr-2"
                            />
                            <label :for="`quarter-${quarter.id}`" class="text-gray-700">{{ quarter.name }}</label>
                        </div>
                    </div>
                    <div v-if="form.errors.quarters" class="text-red-500">{{ form.errors.quarters }}</div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-6">
                    <button
                        type="button"
                        @click="prevStep"
                        :disabled="currentStep === 0 || form.processing"
                        class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition duration-200"
                    >
                        Previous
                    </button>
                    <button
                        v-if="currentStep < steps.length - 1"
                        type="button"
                        @click="nextStep"
                        :disabled="form.processing"
                        class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200"
                    >
                        Next
                    </button>
                    <button
                        v-if="currentStep === steps.length - 1"
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
</template>

---

### Script

```javascript
<script>
import Layout from "../../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        quarters: Array,
    },
};
</script>
<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSnackbar } from "vue3-snackbar";

const form = useForm({
    title: "",
    description: "",
    start_date: "",
    end_date: "",
    quarters: [],
});

const snackbar = useSnackbar();
const currentStep = ref(0);

const steps = [
    { label: "Title" },
    { label: "Description" },
    { label: "Start Date" },
    { label: "End Date" },
    { label: "Quarters" },
];

const inputClass = (error) =>
    `w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500 ${
        error ? "border-red-500" : ""
    }`;

const stepButtonClass = (index) =>
    `px-4 py-2 rounded ${
        index === currentStep.value
            ? "bg-purple-600 text-white"
            : "bg-gray-200 text-gray-600"
    }`;

const nextStep = () => {
    if (currentStep.value < steps.length - 1) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
};

const submit = () => {
    form.post("/targets", {
        onSuccess: () => {
            snackbar.add({
                type: "success",
                text: "Target created successfully",
            });
            form.reset();
            currentStep.value = 0;
        },
        onError: () => {
            snackbar.add({
                type: "error",
                text: form.errors.error ?? "An error occured try again later!",
            });
        }
    });
};
</script>
