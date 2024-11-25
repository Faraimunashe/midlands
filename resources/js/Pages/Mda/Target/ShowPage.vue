<template>
    <Head title="Target Details" />
    <div class="container mx-auto px-4 py-6">
      <!-- Page Header and Breadcrumb -->
      <div class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <!-- Title -->
            <h2 class="text-3xl font-semibold text-gray-800">Target Details</h2>

            <!-- Dropdown Menu -->
            <div class="relative">
                <!-- Settings Icon -->
                <button
                    @click="toggleDropdown"
                    class="bg-gray-600 text-white p-2 rounded-full shadow hover:bg-gray-700 transition duration-200"
                >
                    <i class="fas fa-cog"></i>
                    Menu Options
                </button>

                <!-- Dropdown Options -->
                <div
                v-if="dropdownOpen"
                class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10"
                >
                <Link :href="'/targets/'+target.id+'/progress'"
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-200 flex items-center"
                >
                    <i class="fas fa-sync-alt mr-2"></i>
                    Update Progress
                </Link>
                <button
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600 transition duration-200 flex items-center"
                >
                    <i class="fas fa-plus mr-2"></i>
                    Add Milestone
                </button>
                <button
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600 transition duration-200 flex items-center"
                >
                    <i class="fas fa-print mr-2"></i>
                    Print
                </button>
                <button
                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-200 flex items-center"
                >
                    <i class="fas fa-file-pdf mr-2"></i>
                    Export PDF
                </button>
                </div>
            </div>
        </div>


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
            <li>Target Details</li>
          </ol>
        </nav>
      </div>

      <!-- Target Information -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Target Information Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-800">Target Information</h3>
            <Link
                href="/targets/edit"
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition duration-200"
            >
                <i class="fas fa-edit mr-2"></i>
                Edit Target
            </Link>
            </div>
            <div class="divide-y divide-gray-200">
                <div class="py-4">
                    <p class="text-sm text-gray-500">Title</p>
                    <p class="text-lg font-semibold text-gray-800">{{ target.title }}</p>
                </div>
                <div class="py-4">
                    <p class="text-sm text-gray-500">Description</p>
                    <p class="text-lg font-semibold text-gray-800 break-words">{{ target.description }}</p>
                </div>
                <div class="py-4">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-lg font-semibold text-gray-800">{{ target.status }}</p>
                </div>
                <div class="flex justify-between py-4 space-x-6">
                    <!-- Start Date -->
                    <div>
                        <p class="text-sm text-gray-500">Start Date</p>
                        <p class="text-lg font-semibold text-gray-800">{{ target.start_date }}</p>
                    </div>

                    <!-- End Date -->
                    <div>
                        <p class="text-sm text-gray-500">End Date</p>
                        <p class="text-lg font-semibold text-gray-800">{{ target.end_date || 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Approved Progress</h3>

            <!-- Circle Progress Bar -->
            <div class="relative w-40 h-40 mb-4">
                <svg class="w-full h-full">
                <!-- Background Circle -->
                <circle
                    class="text-gray-200"
                    stroke-width="8"
                    fill="transparent"
                    r="60"
                    cx="80"
                    cy="80"
                />
                <!-- Progress Circle -->
                <circle
                    class="text-green-500"
                    stroke-width="8"
                    fill="transparent"
                    r="60"
                    cx="80"
                    cy="80"
                    :style="{
                    strokeDasharray: circumference,
                    strokeDashoffset: progressOffset
                    }"
                    stroke-linecap="round"
                />
                </svg>
                <!-- Progress Percentage in the Center -->
                <div
                class="absolute inset-0 flex flex-col items-center justify-center text-green-500"
                >
                <span class="text-4xl font-bold">{{ last_progress }}%</span>
                <span class="text-sm text-gray-500">Completed</span>
                </div>
            </div>

            <!-- Description -->
            <p class="text-center text-gray-600">
                This progress reflects the latest approved updates for your target.
            </p>
        </div>

      </div>



      <!-- Related Quarters -->
      <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-2xl font-semibold text-gray-800">Related Quarters</h3>
        </div>
        <table class="table-auto w-full text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Start Date</th>
              <th class="px-4 py-2">End Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="quarter in target.quarters" :key="quarter.id" class="border-b">
              <td class="px-4 py-2">{{ quarter.name }}</td>
              <td class="px-4 py-2">{{ quarter.start_date }}</td>
              <td class="px-4 py-2">{{ quarter.end_date }}</td>
            </tr>
          </tbody>
        </table>
      </div>

            <!-- Milestones -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-semibold text-gray-800">Milestones</h3>
            <button
            v-if="target.milestones.length > 0"
            @click="addMilestone"
            class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition duration-200"
            >
            <i class="fas fa-plus mr-2"></i>
            Add Milestone
            </button>
        </div>

        <!-- Milestones Table -->
        <div v-if="target.milestones.length > 0">
            <table class="table-auto w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Due Date</th>
                <th class="px-4 py-2">Completed Date</th>
                <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="milestone in target.milestones" :key="milestone.id" class="border-b">
                <td class="px-4 py-2">{{ milestone.title }}</td>
                <td class="px-4 py-2">{{ milestone.status }}</td>
                <td class="px-4 py-2">{{ milestone.due_date }}</td>
                <td class="px-4 py-2">{{ milestone.completed_date || 'N/A' }}</td>
                <td class="px-4 py-2">
                    <button
                    @click="editMilestone(milestone.id)"
                    class="text-blue-600 hover:underline mr-2"
                    >
                    <i class="fas fa-edit"></i>
                    Edit
                    </button>
                    <button
                    @click="deleteMilestone(milestone.id)"
                    class="text-red-600 hover:underline"
                    >
                    <i class="fas fa-trash"></i>
                    Delete
                    </button>
                </td>
                </tr>
            </tbody>
            </table>
        </div>

        <!-- No Milestones Label -->
        <div v-else class="text-gray-600 text-center py-6">
            <p class="text-lg font-medium">This target does not use milestones.</p>
        </div>
        </div>


      <div class="bg-white shadow-lg rounded-lg p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-800">Progress Overview</h3>
            <Link
            :href="'/targets/' + target.id + '/progress'"
            class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition duration-200">
            <i class="fas fa-plus mr-2"></i>
            Update Progress
            </Link>
        </div>

        <!-- Progress Entries -->
        <div class="divide-y divide-gray-200">
            <div
            v-for="entry in target.progress"
            :key="entry.id"
            class="py-6">

            <!-- Progress Details -->
            <div class="mb-4">
                <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ entry.created_at }}</p>
                    <p class="text-sm text-gray-500 mt-1">Progress: {{ entry.progress_percent }}%</p>
                </div>
                <span
                    :class="entry.is_approved ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'"
                    class="px-3 py-1 text-sm font-medium rounded-full">
                    {{ entry.is_approved ? 'Approved' : 'Pending' }}
                </span>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ entry.progress_description }}</p>
            </div>

            <!-- Evidence Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                v-for="evidence in entry.evidence"
                :key="evidence.id"
                class="relative bg-gray-50 border border-gray-200 rounded-lg shadow-md overflow-hidden">

                <!-- File Preview -->
                <div class="p-4">
                    <template v-if="evidence.file_type === 'image'">
                    <img
                        :src="evidence.file_path"
                        alt="Evidence"
                        class="w-full h-48 object-cover rounded-md" />
                    </template>
                    <template v-else-if="evidence.file_type === 'pdf'">
                    <div class="flex items-center justify-center w-full h-48 bg-red-100 rounded-md">
                        <i class="fas fa-file-pdf text-red-500 text-6xl"></i>
                    </div>
                    </template>
                    <template v-else-if="evidence.file_type === 'zip'">
                    <div class="flex items-center justify-center w-full h-48 bg-gray-100 rounded-md">
                        <i class="fas fa-file-archive text-gray-500 text-6xl"></i>
                    </div>
                    </template>
                    <template v-else>
                    <div class="flex items-center justify-center w-full h-48 bg-gray-100 rounded-md">
                        <i class="fas fa-file-alt text-gray-500 text-6xl"></i>
                    </div>
                    </template>

                    <!-- File Details -->
                    <div class="mt-4">
                    <h4 class="text-lg font-semibold text-gray-800 truncate">
                        {{ evidence.description || 'No Description Provided' }}
                    </h4>
                    <p class="text-sm text-gray-500 truncate">
                        <strong>Type:</strong> {{ evidence.file_type }}
                    </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="absolute top-2 right-2 flex space-x-2">
                    <a
                    :href="evidence.file_path"
                    target="_blank"
                    class="bg-blue-600 text-white p-2 rounded-full shadow hover:bg-blue-700 transition duration-200"
                    title="View File">
                    <i class="fas fa-eye"></i>
                    </a>
                    <button
                    @click="deleteEvidence(evidence.id)"
                    class="bg-red-600 text-white p-2 rounded-full shadow hover:bg-red-700 transition duration-200"
                    title="Delete File">
                    <i class="fas fa-trash"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

    </div>
  </template>

<script>
import Layout from '../../../Shared/Layout.vue';
  export default {
    layout: Layout,
    props: {
        target: Object,
        last_progress: String
    },
    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },
        addQuarter() {
        console.log("Add Quarter clicked");
        },
        editQuarter(id) {
        console.log(`Edit Quarter ${id} clicked`);
        },
        deleteQuarter(id) {
        console.log(`Delete Quarter ${id} clicked`);
        },
        addMilestone() {
        console.log("Add Milestone clicked");
        },
        editMilestone(id) {
        console.log(`Edit Milestone ${id} clicked`);
        },
        deleteMilestone(id) {
        console.log(`Delete Milestone ${id} clicked`);
        },
        addEvidence() {
        console.log("Add Evidence clicked");
        },
        addEvidence() {
            console.log("Add Evidence clicked");
            // Implement the logic to open a form/modal for adding new evidence.
        },
        deleteEvidence(id) {
            console.log(`Delete Evidence ${id} clicked`);
            // Implement the logic to delete the evidence.
        },
    },
    computed: {
        circumference() {
            // Circumference of the circle (2 * π * radius)
            return 2 * Math.PI * this.radius;
        },
        progressOffset() {
            // Calculate the offset for the circular progress bar
            return this.circumference * (1 - this.lastProgress / 100);
        },
    },
  };
</script>
