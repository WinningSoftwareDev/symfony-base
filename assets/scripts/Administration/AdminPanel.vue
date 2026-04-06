<script setup lang="ts">
import { useRoute } from 'vue-router';
import SidePanel from './Theme/SidePanel.vue';
import AdminHeader from './Theme/AdminHeader.vue';

const currentRoute = useRoute();
</script>
<template>
  <div class="flex h-screen overflow-hidden bg-page text-light-text">
    <SidePanel app-name="Symfony Base" />

    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
      <AdminHeader :pageTitle="(currentRoute.meta.title as string)" />

      <div class="p-8">
        <router-view />
      </div>
    </main>
  </div>
</template>