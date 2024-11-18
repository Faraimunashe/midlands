<template>
    <Head title="Login" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-r from-blue-500 to-purple-600">
      <!-- Login Card -->
      <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <!-- Title Section -->
        <div class="text-center mb-6">
          <h1 class="text-2xl font-bold text-purple-700 mb-1">Performance Monitoring</h1>
        </div>

        <!-- Welcome Message -->
        <div class="text-center mb-6">
          <h3 class="text-3xl font-semibold text-gray-800">Welcome Back</h3>
          <p class="text-gray-600">Please log in to your account</p>
        </div>

        <!-- Form Fields -->
        <form @submit.prevent="submit">
          <!-- Email Field -->
          <div class="mb-4 relative">
            <label for="email" class="text-gray-600 font-medium">Email</label>
            <input
              type="email"
              v-model="form.email"
              id="email"
              placeholder="Enter your email"
              :class="{'border-red-500': form.errors.email}"
              class="w-full px-12 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
            />
            <span class="absolute top-10 left-3 text-gray-400">
              <i class="fas fa-envelope"></i>
            </span>
            <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
          </div>

          <!-- Password Field -->
          <div class="mb-6 relative">
            <label for="password" class="text-gray-600 font-medium">Password</label>
            <input
              type="password"
              v-model="form.password"
              id="password"
              placeholder="Enter your password"
              :class="{'border-red-500': form.errors.password}"
              class="w-full px-12 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
            />
            <span class="absolute top-10 left-3 text-gray-400">
              <i class="fas fa-lock"></i>
            </span>
            <div v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</div>
          </div>

          <!-- Login Button -->
          <button
            :disabled="loading"
            type="submit"
            class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold text-lg transition duration-300 transform hover:bg-purple-700 hover:shadow-lg hover:-translate-y-1"
          >
            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span v-if="!loading">Log In</span>
            <span v-if="loading">Logging In...</span>
          </button>
        </form>

        <!-- Forgot Password -->
        <div class="text-center mt-4">
          <a href="#" class="text-sm text-purple-600 hover:text-purple-800">Forgot Password?</a>
        </div>
      </div>

      <!-- Footer -->
      <footer class="mt-6 text-center text-white text-sm">
        &copy; 2024 Midlands Province | Developed by
        <a href="#" class="text-sm text-gray-600 hover:text-gray-800">Faraimunashe</a>
      </footer>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    email: '',
    password: '',
  });

  const loading = ref(false);

  const submit = () => {
    loading.value = true;
    form.post('/login', {
      onFinish: () => (loading.value = false),
    });
  };
  </script>

  <style scoped>
  .invalid-feedback {
    display: block;
  }
  </style>
