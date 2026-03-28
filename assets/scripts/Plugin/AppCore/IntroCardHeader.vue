<script setup lang="ts">
interface IProps
{
  name: string;
}

withDefaults(defineProps<IProps>(), {
  name: 'My App',
});
</script>

<template>
  <div class="mb-6">
    <h1 class="text-5xl font-bold">🚀 {{ name }}</h1>
  </div>
</template>