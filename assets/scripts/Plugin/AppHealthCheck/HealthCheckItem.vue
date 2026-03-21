<script setup lang="ts">
import ICheckResult from './Interface/ICheckResult';

interface IHealthCheckItemProps
{
  result: ICheckResult;
}

withDefaults(defineProps<IHealthCheckItemProps>(), {});
</script>

<template>
  <div class="my-1 italic w-full flex text-sm flex-col gap-2 items-center bg-red-100/10 py-4 px-3" :class="{'text-red-300': !result.success, 'text-green-500': result.success}">
    <i class="fa-duotone fa-2x fa-light" :class="{'fa-octagon-xmark': !result.success, 'fa-octagon-check': result.success}"></i>
    <span>{{ result.message }}</span>
  </div>
</template>

<style scoped>

</style>