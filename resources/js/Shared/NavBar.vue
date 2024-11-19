<template>
    <nav class="bg-white border-b border-gray-200 fixed w-full z-10 top-0 shadow-md">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <!-- Logo Section -->
          <div class="flex items-center">
            <Link href="/" class="text-lg font-semibold text-gray-800 flex items-center space-x-2">
              <i class="fas fa-tachometer-alt text-purple-600"></i>
              <span>Dashboard</span>
            </Link>
          </div>

          <!-- Navigation Links -->

            <component v-if="role === 'admin'" class="hidden md:flex items-center space-x-4">
                <Link href="/authentication" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </Link>
                <Link href="/analytics" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </Link>
                <Link href="/departments" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-building"></i>
                    <span>Departments</span>
                </Link>
                <Link href="/mdas" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-user-tie"></i>
                    <span>MDAs</span>
                </Link>
                <Link href="/quarters" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Quarters</span>
                </Link>
                <Link href="/users" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                <i class="fas fa-users"></i>
                <span>Users</span>
                </Link>
            </component>

            <component v-if="role === 'mda'" class="hidden md:flex items-center space-x-4">
                <Link href="/authentication" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </Link>
                <Link href="/analytics" class="text-gray-800 hover:text-purple-600 flex items-center space-x-2">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </Link>
            </component>


          <div class="flex items-center space-x-4">

            <div class="text-right mr-2">
              <p class="text-gray-800 font-semibold">{{ username }}</p>
            </div>

            <div class="relative">
              <button
                @click="toggleDropdown"
                class="text-gray-800 hover:text-purple-600 flex items-center space-x-2 focus:outline-none"
              >
                <i class="fas fa-cog"></i>
                <span>Settings</span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div
                v-show="dropdownOpen"
                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-20"
              >
                <Link
                  href="/profile"
                  class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                  @click="closeDropdown"
                >Profile</Link>
                <Link href="/logout" method="post"
                  class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                  @click="closeDropdown"
                >Log Out</Link>
              </div>
            </div>
            <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="User Profile">
          </div>
        </div>
      </div>
    </nav>
  </template>

  <script>
  export default {
    props:{
        username: String,
        role: String
    },
    data() {
      return {
        dropdownOpen: false,
      };
    },
    methods: {
      toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
      },
      closeDropdown() {
        this.dropdownOpen = false;
      },
      handleClickOutside(event) {
        if (!this.$el.contains(event.target)) {
          this.closeDropdown();
        }
      },
    },
    mounted() {
      document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
      document.removeEventListener('click', this.handleClickOutside);
    },
  };
  </script>
