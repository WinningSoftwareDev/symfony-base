<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AdminTable from '../../Component/AdminTable.vue';

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

    <AdminTable :items="responseData.data" :loading="loading" :pagination="responseData.meta" @changePage="fetchUsers">
      <template #headings>
        <th class="p-4 font-bold">Email</th>
        <th class="p-4 font-bold">Roles</th>
        <th class="p-4 font-bold text-right">Actions</th>
      </template>
      <template #row="{ item: user }">
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
          <button class="text-orange-400 hover:text-white transition-colors text-sm font-semibold cursor-pointer">
            Edit
          </button>
        </td>
      </template>
    </AdminTable>
  </div>
</template>