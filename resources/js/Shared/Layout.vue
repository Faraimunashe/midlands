<template>
    <div class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

      <NavBar :username="username" />

      <div class="flex-1 pt-24 pb-6">
        <slot />
      </div>

      <Footer />
    </div>
  </template>

  <script>
import Footer from './Footer.vue';
import NavBar from './NavBar.vue';

export default {
    components: {
        Footer, NavBar
    },
    computed: {
        username() {
            return this.$page.props.auth.user.name
        }
    }
};
</script>
