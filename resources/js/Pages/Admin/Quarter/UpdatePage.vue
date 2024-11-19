<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Quarter Details" />
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header and Breadcrumb -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800">Quarter Details</h2>
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
                    <li>Details</li>
                </ol>
            </nav>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">Quarter Information</h3>
                <!-- Actions -->
                <div class="flex space-x-4 ml-auto">
                    <button
                        @click="toggleEdit"
                        class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200"
                    >
                        <i class="fas fa-edit mr-2"></i>
                        {{ isEditing ? 'Cancel' : 'Edit' }}
                    </button>
                </div>
            </div>
            <div class="mt-6 space-y-4">
                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Name:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.name"
                            @blur="updateQuarter"
                            type="text"
                            :class="{'border-red-500': form.errors.name}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.name }}</span>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Start Date:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.start_date"
                            @blur="updateQuarter"
                            type="date"
                            :class="{'border-red-500': form.errors.start_date}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.name" class="text-red-500">{{ form.errors.start_date }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.start_date }}</span>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">End Date:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.end_date"
                            @blur="updateQuarter"
                            type="date"
                            :class="{'border-red-500': form.errors.end_date}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.name" class="text-red-500">{{ form.errors.end_date }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.end_date }}</span>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Created At:</span>
                    <span class="text-gray-800">{{ new Date(quarter.created_at).toLocaleDateString() }}</span>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-600 font-medium w-1/4">Last Updated:</span>
                    <span class="text-gray-800">{{ new Date(quarter.updated_at).toLocaleDateString() }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSnackbar } from "vue3-snackbar";
import Layout from "../../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        quarter: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        const snackbar = useSnackbar();
        const isEditing = ref(false);
        const form = useForm({
            name: props.quarter.name,
            start_date: props.quarter.start_date,
            end_date: props.quarter.end_date,
        });

        const toggleEdit = () => {
            isEditing.value = !isEditing.value;
        };

        const updateQuarter = () => {
            if (!isEditing.value) return;

            form.put(`/quarters/${props.quarter.id}`, {
                onSuccess: () => {
                    isEditing.value = false;
                    snackbar.add({
                        type: "success",
                        text: "Quarter updated successfully.",
                    });
                },
                onError: () => {
                    snackbar.add({
                        type: "error",
                        text: form.errors.error ?? "Failed to update the quarter. Please try again.",
                    });
                },
            });
        };

        return {
            isEditing,
            form,
            toggleEdit,
            updateQuarter,
        };
    },
};
</script>

<style scoped>
/* Optional: Add spinner styles if needed */
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
