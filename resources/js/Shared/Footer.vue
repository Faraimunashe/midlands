<template>
    <footer class="bg-white text-center text-gray-600 py-4 border-t border-gray-200">
        &copy; {{ currentYear }} Midlands Province Performance Monitoring | Developed by Faraimunashe
    </footer>
</template>
<script>
    export default {
        computed: {
            currentYear() {
                return new Date().getFullYear();
            }
        }
    }
</script>
