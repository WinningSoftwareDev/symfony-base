<script setup lang="ts">
import ICheckResult from './Interface/ICheckResult';

interface IHealthCheckItemProps
{
  result: ICheckResult;
}

withDefaults(defineProps<IHealthCheckItemProps>(), {});
</script>

<template>
  <div class="my-2 italic w-full flex text-sm flex-col gap-2 items-center py-4 px-3 rounded-md"
       :class="{'text-red-300 bg-red-100/20': !result.success, 'text-green-300 bg-green-100/20': result.success}">
    <i class="fa-duotone fa-2x fa-light" :class="{'fa-octagon-xmark': !result.success, 'fa-octagon-check': result.success}" />
    <span>{{ result.message }}</span>
  </div>
</template>