<template>
  <div>
    <h1>Welcome to Inertia.js with Vue & Laravel</h1>
    <p>{{ message }}</p>
  </div>
</template>

<script setup>
defineProps({
  message: String
});
</script>
