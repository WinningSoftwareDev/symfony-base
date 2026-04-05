<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import SidePanel from './Theme/SidePanel.vue';

const currentRoute = useRoute();
const pageTitle = computed(() => currentRoute.meta.title || 'Administration Panel');
</script>
<template>
  <div class="flex h-screen overflow-hidden bg-page text-light-text">
    <SidePanel app-name="Symfony Base" />

    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
      <header class="h-16 border-b border-gray-800 flex justify-between items-center px-8 bg-page/50 backdrop-blur-md sticky top-0">
        <h2 class="font-semibold text-lg">{{ pageTitle }}</h2>

        <div class="flex items-center gap-4">
          <button class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-bell"></i>
          </button>
          <a href="/authenticate/logout" class="text-xs bg-gray-800 hover:bg-gray-700 px-3 py-1.5 rounded transition-colors">Logout</a>
        </div>
      </header>

      <div class="p-8">
        <router-view />
      </div>
    </main>
  </div>
</template>