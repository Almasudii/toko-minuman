<template>
  <div id="app">
    <AppNavbar />

    <main>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import AppNavbar from './AppNavbar.vue'
</script>
