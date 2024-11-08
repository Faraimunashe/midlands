<template>
    <div class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

      <!-- Top Navigation -->
      <nav class="bg-white border-b border-gray-200 fixed w-full z-10 top-0 shadow-md">
        <div class="container mx-auto px-4">
          <div class="flex items-center justify-between h-16">

            <!-- Logo Section -->
            <div class="flex items-center">
              <router-link to="/" class="text-lg font-semibold text-gray-800 flex items-center space-x-2">
                <i class="fas fa-tachometer-alt text-purple-600"></i>
                <span>Dashboard</span>
              </router-link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-4">
              <router-link to="/" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                <i class="fas fa-home"></i>
                <span>Home</span>
              </router-link>
              <router-link to="/analytics" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
              </router-link>
              <router-link to="/reports" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
              </router-link>

              <!-- Settings Dropdown -->
              <div class="relative" @click.outside="closeDropdown">
                <button @click="toggleDropdown" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2 focus:outline-none">
                  <i class="fas fa-cog"></i>
                  <span>Settings</span>
                  <i class="fas fa-chevron-down"></i>
                </button>
                <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-20">
                  <router-link to="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</router-link>
                  <router-link to="/account" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Account Settings</router-link>
                  <router-link to="/notifications" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Notifications</router-link>
                  <router-link to="/logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Log Out</router-link>
                </div>
              </div>
            </div>

            <!-- User Profile Dropdown -->
            <div class="flex items-center space-x-2">
              <div class="relative">
                <button class="flex items-center focus:outline-none transform transition hover:scale-105">
                  <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="User Profile">
                </button>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="flex-1 pt-24 pb-6">
        <div class="container mx-auto px-4">

          <!-- Page Header and Breadcrumb -->
          <div class="mb-6">
            <div class="flex justify-between items-center">
              <h2 class="text-3xl font-semibold text-gray-800">Dashboard Overview</h2>
            </div>
            <!-- Breadcrumb -->
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

            <!-- Card with Hover Animation -->
            <div class="bg-white shadow-lg rounded-lg p-4 transform transition duration-300 hover:scale-105 hover:shadow-xl">
              <div class="flex items-center space-x-3">
                <i class="fas fa-dollar-sign text-green-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">Total Sales</h3>
              </div>
              <p class="text-gray-600 mt-2">Overview of all sales.</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-4 transform transition duration-300 hover:scale-105 hover:shadow-xl">
              <div class="flex items-center space-x-3">
                <i class="fas fa-users text-blue-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">User Engagement</h3>
              </div>
              <p class="text-gray-600 mt-2">User interactions on your platform.</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-4 transform transition duration-300 hover:scale-105 hover:shadow-xl">
              <div class="flex items-center space-x-3">
                <i class="fas fa-server text-red-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">Server Usage</h3>
              </div>
              <p class="text-gray-600 mt-2">CPU and Memory stats.</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-4 transform transition duration-300 hover:scale-105 hover:shadow-xl">
              <div class="flex items-center space-x-3">
                <i class="fas fa-chart-bar text-purple-500 text-2xl"></i>
                <h3 class="text-lg font-semibold text-gray-800">Revenue</h3>
              </div>
              <p class="text-gray-600 mt-2">Monthly revenue details.</p>
            </div>

          </div>

          <!-- Data Table -->
          <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">Recent Transactions</h3>
            </div>
            <table class="min-w-full bg-white">
              <thead>
                <tr>
                  <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">ID</th>
                  <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Date</th>
                  <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Customer</th>
                  <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Amount</th>
                  <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm uppercase font-semibold">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="transaction in transactions" :key="transaction.id" class="hover:bg-gray-50 transition-colors">
                  <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ transaction.id }}</td>
                  <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ transaction.date }}</td>
                  <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ transaction.customer }}</td>
                  <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">{{ transaction.amount }}</td>
                  <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-800">
                    <span :class="statusClass(transaction.status)">
                      <i :class="statusIcon(transaction.status)"></i>
                      {{ transaction.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <!-- Footer -->
      <footer class="bg-white text-center text-gray-600 py-4 border-t border-gray-200">
        &copy; {{ currentYear }} Midlands Province Performance Monitoring | Developed by Faraimunashe Manjeese
      </footer>

    </div>
  </template>

  <script>
  export default {
    name: "Dashboard",
    data() {
      return {
        transactions: [
          { id: 1, date: "2024-11-01", customer: "John Doe", amount: "$150", status: "Completed" },
          { id: 2, date: "2024-11-02", customer: "Jane Smith", amount: "$250", status: "Pending" },
          { id: 3, date: "2024-11-03", customer: "Mark Brown", amount: "$100", status: "Failed" },
          // Add more transactions as needed
        ]
      };
    },
    computed: {
      currentYear() {
        return new Date().getFullYear();
      }
    },
    methods: {
      statusClass(status) {
        return {
          "text-green-600": status === "Completed",
          "text-yellow-500": status === "Pending",
          "text-red-500": status === "Failed"
        };
      },
      statusIcon(status) {
        return {
          "fas fa-check-circle": status === "Completed",
          "fas fa-hourglass-half": status === "Pending",
          "fas fa-times-circle": status === "Failed"
        };
      }
    }
  };
  </script>

  <style scoped>
  /* Optional additional styling */
  </style>
