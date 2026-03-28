<script setup lang="ts">
import { Ref, ref } from 'vue';
import HealthCheckItem from './HealthCheckItem.vue';
import ICheckResult from './Interface/ICheckResult';
import IHealthCheck from './Interface/IHealthCheck';


const isLoading = ref(true);
const checkResults: Ref<ICheckResult[]> = ref([]);

const checkCallback = async (endpoint: string) => {
  return await fetch(`/health-check/${endpoint}`)
      .then((response: Response) => response.json())
      .then((json: ICheckResult) => json);
}

const checks: Array<IHealthCheck> = [
  {
    check: async () => {
      return checkCallback('php-version');
    }
  },
  {
    check: async () => {
      return checkCallback('symfony-version');
    }
  },
  {
    check: async () => {
      return checkCallback('database-connection');
    }
  },
  {
    check: async () => {
      return checkCallback('default-tables-exist');
    }
  },
];

const runChecks = async () => {
  for (const check of checks) {
    if (!isLoading.value) {
      continue;
    }

    await runCheck(check);
  }
}

const runCheck = async (check: IHealthCheck) => {
  await check.check().then((result: ICheckResult) => {
    checkResults.value.push(result);

    if (!result.success) {
      isLoading.value = false;
    }
  });
}

runChecks().then(() => {
  isLoading.value = false;
});
</script>

<template>
  <div class="bg-gray-900/50 rounded-2xl border border-gray-800 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800 bg-gray-800/30 flex justify-between items-center">
      <h2 class="text-sm font-bold tracking-widest uppercase text-gray-400">System Integrity</h2>
      <i v-if="isLoading" class="fa-duotone fa-spinner-third fa-spin text-indigo-400"></i>
    </div>

    <div class="p-4 space-y-3">
      <HealthCheckItem v-for="(item, index) in checkResults"
                       :key="index"
                       :result="item" />

      <div v-if="isLoading && checkResults.length < 4" class="p-4 border-2 border-dashed border-gray-800 rounded-xl animate-pulse flex items-center justify-center">
        <span class="text-gray-600 text-xs italic tracking-widest">Running Diagnostics...</span>
      </div>
    </div>
  </div>
</template>