<script setup lang="ts">
import { ref } from 'vue';

const hovered = ref<boolean>(false);
</script>
<template>
  <a class="fixed top-4 left-4 py-2 px-4 rounded-2xl bg-primary text-dark-text transition duration-150 hover:bg-accent transition duration-150"
     href="/" @mouseenter="hovered = true" @mouseleave="hovered = false">
    <i v-if="hovered" class="fa fa-arrow-left"></i>
    <i class="fa-duotone fa-solid fa-house"></i>
  </a>
</template>