<script setup lang="ts">
import {Ref, ref} from 'vue';
import IHealthCheck from './Interface/IHealthCheck';
import ICheckResult from './Interface/ICheckResult';
import HealthCheckItem from './HealthCheckItem.vue';

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
      return checkCallback('database-connection');
    }
  },
  {
    check: async () => {
      return checkCallback('default-tables-exist');
    }
  }
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
  <div class="p-2 rounded-md bg-auth-primary/65">
    <h2 class="text-white font-bold mt-1">Application Health Check</h2>
    <div class="health-check-container">
      <HealthCheckItem v-for="item in checkResults" :result="item" />
      <i v-if="isLoading" class="fa-duotone fa-light fa-fan fa-spin fa-3x mt-2 text-blue-200"></i>
    </div>
  </div>
</template>

<style scoped>

</style>