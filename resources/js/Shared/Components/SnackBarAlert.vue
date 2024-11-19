<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <button @click="successMessage">Show Success Snackbar</button>
</template>

<script>
export default {
    methods: {
        successMessage() {
            this.$snackbar.add({
                type: 'success',
                text: 'This is a snackbar message'
            });
        }
    }
};
</script>
