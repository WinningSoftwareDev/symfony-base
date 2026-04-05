<script setup>
import { ref, onMounted } from 'vue';

const loading = ref(true);
const responseData = ref({ data: [], meta: {} });

const fetchUsers = async (page = 1) => {
  try {
    const params = new URLSearchParams({ page: page.toString(), limit: '10' });
    const response = await fetch(`/api/admin/users?${params}`);
    responseData.value = await response.json();
  } catch (error) {
    console.error("Failed to load users", error);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchUsers);
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">User Management</h1>
      <div v-if="loading" class="text-xs text-orange-400 animate-pulse uppercase tracking-widest font-bold">
        Updating...
      </div>
    </div>

    <div class="bg-secondary-bg rounded-xl border border-gray-800 overflow-hidden shadow-sm">
      <table class="w-full">
        <thead>
        <tr class="bg-black/20 text-left text-xs uppercase text-gray-500 border-b border-gray-800">
          <th class="p-4 font-bold">Email</th>
          <th class="p-4 font-bold">Roles</th>
          <th class="p-4 font-bold text-right">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
        <tr v-if="!loading && responseData.data.length === 0">
          <td colspan="3" class="p-8 text-center text-gray-500 italic">No users found.</td>
        </tr>
        <tr v-for="user in responseData.data" :key="user.id" class="hover:bg-white/[0.02] transition-colors">
          <td class="p-4 text-sm font-medium">{{ user.email }}</td>
          <td class="p-4">
            <div class="flex gap-1">
                <span v-for="role in user.roles" :key="role"
                      class="text-[10px] bg-gray-800/50 text-gray-300 border border-gray-700 px-2 py-0.5 rounded uppercase tracking-tighter">
                  {{ role.replace('ROLE_', '') }}
                </span>
            </div>
          </td>
          <td class="p-4 text-right">
            <button class="text-accent hover:text-primary transition-colors text-sm font-semibold cursor-pointer">
              Edit
            </button>
          </td>
        </tr>
        </tbody>
      </table>

      <div v-if="responseData.meta?.last_page > 1"
           class="bg-black/10 px-4 py-3 border-t border-gray-800 flex items-center justify-between">
        <div class="text-xs text-gray-500">
          Showing <span class="text-gray-300">{{ responseData.data.length }}</span>
          of <span class="text-gray-300">{{ responseData.meta.total }}</span> users
        </div>

        <div class="flex gap-2">
          <button @click="fetchUsers(responseData.meta.current_page - 1)"
                  :disabled="responseData.meta.current_page === 1 || loading"
                  class="px-3 py-1.5 rounded-md border border-gray-700 text-xs font-medium transition-all disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-800">
            Previous
          </button>

          <div class="flex items-center gap-1">
            <button v-for="page in responseData.meta.last_page" :key="page"
                    @click="fetchUsers(page)"
                    :class="[
                  'w-8 h-8 rounded-md text-xs font-bold transition-all border',
                  responseData.meta.current_page === page
                    ? 'bg-orange-400/10 border-orange-400/50 text-orange-400 shadow-[0_0_10px_rgba(255,179,102,0.1)]'
                    : 'border-transparent text-gray-500 hover:border-gray-700 hover:text-gray-300'
                ]">
              {{ page }}
            </button>
          </div>

          <button @click="fetchUsers(responseData.meta.current_page + 1)"
                  :disabled="responseData.meta.current_page === responseData.meta.last_page || loading"
                  class="px-3 py-1.5 rounded-md border border-gray-700 text-xs font-medium transition-all disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-800">
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>