<script setup lang="ts">
interface IProps
{
  appName: string;
}

withDefaults(defineProps<IProps>(), {});
</script>

<template>
  <aside class="w-64 bg-secondary-bg border-r border-gray-800 flex flex-col">
    <a class="p-6 flex items-center gap-3" href="/">
      🚀 <span class="font-bold text-xl tracking-tight">{{ appName }}</span>
    </a>

    <nav class="flex-1 px-4 space-y-1 mt-4">
      <router-link
          to="/admin"
          class="nav-link"
          active-class="active-nav">
        <i class="fas fa-chart-pie w-5"></i> Dashboard
      </router-link>

      <router-link
          to="/admin/users"
          class="nav-link"
          active-class="active-nav">
        <i class="fas fa-users w-5"></i> Users
      </router-link>

      <router-link
          to="/admin/settings"
          class="nav-link"
          active-class="active-nav">
        <i class="fa-solid fa-dial"></i> Settings
      </router-link>
    </nav>

    <div class="p-4 border-t border-gray-800 bg-black/20">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-orange-400 flex items-center justify-center text-xs font-bold text-black">
          <i class="fa-solid fa-user"></i>
        </div>
        <div class="overflow-hidden">
          <p class="text-xs font-medium truncate">testuser@example.com</p>
          <p class="text-[10px] text-gray-400 uppercase">Administrator</p>
        </div>
      </div>
    </div>
  </aside>
</template>

<style scoped>
@reference 'tailwindcss/theme';
.nav-link {
  @apply flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all;
}
.active-nav {
  @apply bg-orange-400/10 text-orange-400;
}
</style>