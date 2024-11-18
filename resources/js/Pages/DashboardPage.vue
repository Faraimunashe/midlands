<template>
    <div class="container mx-auto px-4">

          <!-- Page Header -->
          <div class="mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Dashboard Overview</h2>
            <nav class="text-gray-500 text-sm mt-2">
              <ol class="list-reset flex">
                <li><router-link to="/" class="hover:text-purple-600">Home</router-link></li>
                <li><span class="mx-2">/</span></li>
                <li>Dashboard Overview</li>
              </ol>
            </nav>
          </div>

          <!-- Dashboard Cards with Icons -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white shadow-lg rounded-lg p-6 transform transition duration-300 hover:scale-105">
              <div class="flex items-center space-x-3">
                <i class="fas fa-bullseye text-green-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">Active Targets</h3>
              </div>
              <p class="text-4xl font-bold text-gray-700 mt-2">45</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 transform transition duration-300 hover:scale-105">
              <div class="flex items-center space-x-3">
                <i class="fas fa-flag-checkered text-blue-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">Completed Milestones</h3>
              </div>
              <p class="text-4xl font-bold text-gray-700 mt-2">23</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 transform transition duration-300 hover:scale-105">
              <div class="flex items-center space-x-3">
                <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">Overdue Targets</h3>
              </div>
              <p class="text-4xl font-bold text-gray-700 mt-2">5</p>
            </div>
          </div>

          <!-- Recent Activities -->
          <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
            <ul class="divide-y divide-gray-200">
              <li class="py-2 flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                Target #24 - Vaccination Rates updated by John Doe
              </li>
              <li class="py-2 flex items-center">
                <i class="fas fa-flag text-blue-500 mr-3"></i>
                Milestone completed: Infrastructure Improvement Phase 2
              </li>
              <li class="py-2 flex items-center">
                <i class="fas fa-file-alt text-yellow-500 mr-3"></i>
                Jane Smith submitted Q1 performance report
              </li>
            </ul>
          </div>

    </div>
</template>

<script>
import Layout from '../Shared/Layout.vue';

export default {
    layout: Layout,

};
</script>
