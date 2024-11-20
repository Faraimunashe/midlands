<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Target Details" />
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header and Breadcrumb -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800">Target Details</h2>
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
                    <li>Edit</li>
                </ol>
            </nav>
        </div>

        <!-- User Details Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">Target Information</h3>
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
                <!-- Title -->
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Title:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.title"
                            @blur="updateTarget"
                            type="text"
                            :class="{'border-red-500': form.errors.title}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.title }}</span>
                </div>

                <!-- Description -->
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Description:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.description"
                            @blur="updateTarget"
                            type="text"
                            :class="{'border-red-500': form.errors.description}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.description }}</span>
                </div>

                <!-- Start Date -->
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Start Date:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.start_date"
                            @blur="updateTarget"
                            type="date"
                            :class="{'border-red-500': form.errors.start_date}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.start_date" class="text-red-500">{{ form.errors.start_date }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.start_date }}</span>
                </div>

                <!-- End Date -->
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">End Date:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.end_date"
                            @blur="updateTarget"
                            type="date"
                            :class="{'border-red-500': form.errors.end_date}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.end_date" class="text-red-500">{{ form.errors.end_date }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.end_date }}</span>
                </div>

                <!-- Quarters -->
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Quarters:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <div class="mt-2 space-y-2">
                            <div
                                v-for="quarter in quarters"
                                :key="quarter.id"
                                class="flex items-center"
                            >
                                <input
                                    type="checkbox"
                                    :id="`quarter-${quarter.id}`"
                                    :value="quarter.id"
                                    v-model="form.quarters"
                                    @change="updateTarget"
                                    class="mr-2"
                                />
                                <label :for="`quarter-${quarter.id}`" class="text-gray-700">
                                    {{ quarter.name }}
                                </label>
                            </div>
                        </div>
                        <div v-if="form.errors.quarters" class="text-red-500">{{ form.errors.quarters }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">
                        {{ selectedQuarters }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSnackbar } from "vue3-snackbar";
import Layout from "../../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        target: {
            type: Object,
            required: true,
        },
        quarters: {
            type: Array,
            required: true,
        },
    },
    setup(props) {
        const snackbar = useSnackbar();
        const isEditing = ref(false);

        const form = useForm({
            title: props.target.title,
            description: props.target.description,
            start_date: props.target.start_date,
            end_date: props.target.end_date,
            quarters: props.target.quarters.map((q) => q.id),
        });

        const toggleEdit = () => {
            isEditing.value = !isEditing.value;
        };

        const updateTarget = () => {
            form.put(`/targets/${props.target.id}`, {
                preserveState: true,
                onSuccess: () => {
                    snackbar.add({
                        type: "success",
                        text: "Target was updated successfully.",
                    });
                    isEditing.value = false;
                },
                onError: () => {
                    snackbar.add({
                        type: "error",
                        text: form.errors.error ?? "An error occurred. Please try again.",
                    });
                },
            });
        };

        const selectedQuarters = computed(() => {
            return props.quarters
                .filter((quarter) => form.quarters.includes(quarter.id))
                .map((quarter) => quarter.name)
                .join(", ") || "No quarters selected.";
        });

        return {
            isEditing,
            form,
            toggleEdit,
            updateTarget,
            selectedQuarters,
        };
    },
};
</script>
