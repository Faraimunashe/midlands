<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="MDA Details" />
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header and Breadcrumb -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800">MDA Details</h2>
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
                    <li>Edit</li>
                </ol>
            </nav>
        </div>

        <!-- User Details Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">MDA Information</h3>
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
                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Department:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <select
                            v-model="form.department_id"
                            @blur="updateMda"
                            :class="{'border-red-500': form.errors.department_id}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        >
                            <option value="" disabled>Select a department</option>
                            <option v-for="department in departments" :key="department.id" :value="department.id">
                                {{ department.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.department_id" class="text-red-500">{{ form.errors.department_id }}</div>
                    </div>
                    <span v-else class="text-gray-800">{{ selectedDepartment }}</span>
                </div>

                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Title:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <select
                            v-model="form.title"
                            @blur="updateMda"
                            :class="{'border-red-500': form.errors.title}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        >
                            <option value="" disabled>Select a title</option>
                            <option v-for="title in titles" :key="title.id" :value="title.name">
                                {{ title.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</div>
                    </div>
                    <span v-else class="text-gray-800">{{ form.title }}</span>
                </div>

                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Firstnames:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.firstnames"
                            @blur="updateMda"
                            type="text"
                            :class="{'border-red-500': form.errors.firstnames}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.firstnames" class="text-red-500">{{ form.errors.firstnames }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.firstnames }}</span>
                </div>

                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Surname:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.surname"
                            @blur="updateMda"
                            type="text"
                            :class="{'border-red-500': form.errors.surname}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.surname" class="text-red-500">{{ form.errors.surname }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.surname }}</span>
                </div>

                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Phone:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.phone"
                            @blur="updateMda"
                            type="text"
                            :class="{'border-red-500': form.errors.phone}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.phone" class="text-red-500">{{ form.errors.phone }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.phone }}</span>
                </div>

                <div class="flex items-center border-b border-gray-300 pb-2">
                    <span class="text-gray-600 font-medium w-1/4">Address:</span>
                    <div v-if="isEditing" class="w-3/4">
                        <input
                            v-model="form.address"
                            @blur="updateMda"
                            type="text"
                            :class="{'border-red-500': form.errors.address}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-purple-500 focus:border-purple-500"
                        />
                        <div v-if="form.errors.address" class="text-red-500">{{ form.errors.address }}</div>
                    </div>
                    <span v-else class="text-gray-800 font-semibold">{{ form.address }}</span>
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
        mda: {
            type: Object,
            required: true,
        },
        departments: {
            type: Array,
            required: true,
        },
        titles: {
            type: Array,
            required: true,
        }
    },
    setup(props) {
        const snackbar = useSnackbar();
        const isEditing = ref(false);


        const form = useForm({
            department_id: props.mda.department?.id || "",
            title: props.mda.title,
            firstnames: props.mda.firstnames,
            surname: props.mda.surname,
            phone: props.mda.phone,
            address: props.mda.address,
        });

        // Get selected department
        const selectedDepartment = computed(() => {
            const department = props.departments.find((d) => d.id === form.department_id);
            return department ? department.name : "N/A";
        });

        // Toggle edit mode
        const toggleEdit = () => {
            isEditing.value = !isEditing.value;
        };

        // Update user details
        const updateMda = () => {
            if (!isEditing.value) return;

            form.put(`/mdas/${props.mda.id}`, {
                preserveState: true,
                onSuccess: () => {
                    snackbar.add({
                        type: "success",
                        text: "MDA was updated successfully.",
                    });
                    isEditing.value = false;
                },
                onError: () => {
                    snackbar.add({
                        type: "error",
                        text: form.errors.error ?? 'An error occured please try again later!',
                    });
                },
            });
        };

        return {
            isEditing,
            form,
            toggleEdit,
            updateMda,
            selectedDepartment,
        };
    },
};
</script>
