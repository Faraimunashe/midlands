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

        <!-- Targets Table -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 border-b">Title</th>
                        <th class="px-4 py-2 border-b">Department</th>
                        <th class="px-4 py-2 border-b">Author</th>
                        <th class="px-4 py-2 border-b">Status</th>
                        <th class="px-4 py-2 border-b">Start Date</th>
                        <th class="px-4 py-2 border-b">End Date</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="target in targets" :key="target.id" class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ target.title }}</td>
                        <td class="px-4 py-2 border-b">{{ target.department.name }}</td>
                        <td class="px-4 py-2 border-b">{{ target.author.name }}</td>
                        <td class="px-4 py-2 border-b">
                            <span
                                :class="statusClass(target.status)"
                                class="px-2 py-1 rounded text-white text-sm"
                            >
                                {{ target.status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{ new Date(target.start_date).toLocaleDateString() }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{ target.end_date ? new Date(target.end_date).toLocaleDateString() : "N/A" }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            <Link
                                :href="`/targets/${target.id}`"
                                class="text-blue-600 hover:underline mr-2"
                            >
                                View
                            </Link>
                            <Link
                                :href="`/targets/${target.id}/edit`"
                                class="text-green-600 hover:underline mr-2"
                            >
                                Edit
                            </Link>
                            <button type="button"
                                class="text-red-600 hover:underline"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Empty State -->
            <div v-if="!targets" class="text-center text-gray-600 py-6">
                No targets found. <Link href="/targets/create" class="text-purple-600 hover:underline">Add a new target</Link>.
            </div>
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

        return {
            statusClass,
        };
    },
};
</script>
