<template>
    <Head title="Targets" />
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header and Breadcrumb -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800">Targets</h2>
                <!-- Add Target Button -->
                <Link
                    href="/targets/create"
                    class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700 transition duration-200"
                >
                    <i class="fas fa-plus mr-2"></i>
                    Add Target
                </Link>
            </div>
            <!-- Breadcrumb -->
            <nav class="text-gray-500 text-sm mt-2">
                <ol class="list-reset flex">
                    <li>
                        <Link href="/authentication" class="hover:text-purple-600">Home</Link>
                    </li>
                    <li><span class="mx-2">/</span></li>
                    <li>Targets</li>
                </ol>
            </nav>
        </div>

        <!-- Targets as Cards -->
        <div v-if="targets.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="target in targets.data"
                :key="target.id"
                class="bg-white shadow-lg rounded-lg p-6 relative hover:shadow-xl transition duration-300"
            >
                <!-- Status Badge -->
                <div class="absolute top-4 right-4">
                    <span
                        :class="statusClass(target.status)"
                        class="inline-flex items-center px-3 py-1 rounded-full text-white text-sm font-medium shadow-md"
                    >
                        <i
                            :class="statusIcon(target.status)"
                            class="mr-2"
                        ></i>
                        {{ target.status }}
                    </span>
                </div>

                <!-- Card Header -->
                <div class="mb-4">
                    <h3 class="text-2xl font-bold text-gray-900 flex items-center mb-2">
                        {{ target.title }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        Created on: {{ new Date(target.created_at).toLocaleDateString() }}
                    </p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-4"></div>

                <!-- Card Body -->
                <div class="space-y-3 text-gray-700">
                    <p class="flex items-center text-base">
                        <strong class="mr-2">Department:</strong> {{ target.department.name }}
                    </p>
                    <p class="flex items-center text-base">
                        <strong class="mr-2">Start Date:</strong> {{ new Date(target.start_date).toLocaleDateString() }}
                    </p>
                    <p class="flex items-center text-base">
                        <strong class="mr-2">End Date:</strong>
                        {{ target.end_date ? new Date(target.end_date).toLocaleDateString() : "N/A" }}
                    </p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-4"></div>

                <!-- Card Footer -->
                <div class="flex justify-between items-center">
                    <Link
                        :href="`/targets/${target.id}`"
                        class="flex items-center text-blue-600 font-medium hover:underline"
                    >
                        <i class="fas fa-eye mr-2"></i>
                        View Details
                    </Link>
                    <div class="flex space-x-4">
                        <Link
                            :href="`/targets/${target.id}/edit`"
                            class="flex items-center text-gray-600 font-medium hover:underline"
                        >
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </Link>
                        <button
                            type="button"
                            @click="deleteTarget(target.id)"
                            class="flex items-center text-gray-600 font-medium hover:underline"
                        >
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>


        </div>

        <!-- Empty State -->
        <div v-else class="text-center text-gray-600 py-6">
            No targets found. <Link href="/targets/create" class="text-purple-600 hover:underline">Add a new target</Link>.
        </div>
    </div>
</template>



<script>
import Layout from "../../Shared/Layout.vue";

export default {
    layout: Layout,
    props: {
        targets: {
            type: Array,
            required: true,
        },
    },
    setup(props) {

        const statusClass = (status) => {
            switch (status) {
                case "Completed":
                    return "bg-green-500";
                case "In Progress":
                    return "bg-yellow-500";
                case "Stalled":
                    return "bg-red-500";
                default:
                    return "bg-gray-500";
            }
        };

        const statusIcon = (status) => {
            switch (status) {
                case "Completed":
                    return "fas fa-check-circle";
                case "In Progress":
                    return "fas fa-spinner";
                case "Stalled":
                    return "fas fa-exclamation-circle";
                default:
                    return "fas fa-question-circle";
            }
        };

        return {
            statusClass,
            statusIcon
        };
    },
};
</script>


