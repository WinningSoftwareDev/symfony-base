<script setup lang="ts">
import ICheckResult from './Interface/ICheckResult';

interface IHealthCheckItemProps
{
  result: ICheckResult;
}

withDefaults(defineProps<IHealthCheckItemProps>(), {});
</script>

<template>
  <div
      class="group flex items-center gap-4 p-3 rounded-xl border transition-all"
      :class="[
      result.success
        ? 'bg-gray-800/20 border-gray-700/50 hover:bg-gray-800/40'
        : 'bg-red-500/5 border-red-500/30'
    ]"
  >
    <div
        class="flex-shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors"
        :class="[
        result.success
          ? 'border-green-500/50 bg-green-500/10 text-green-500'
          : 'border-red-500 bg-red-500 text-white animate-pulse'
      ]"
    >
      <i :class="['fa-solid text-[10px]', result.success ? 'fa-check' : 'fa-xmark']"></i>
    </div>

    <div class="flex flex-col min-w-0">
      <p class="text-sm font-semibold tracking-tight"
         :class="result.success ? 'text-gray-300' : 'text-red-400'">
        {{ result.message }}
      </p>
    </div>
  </div>
</template>