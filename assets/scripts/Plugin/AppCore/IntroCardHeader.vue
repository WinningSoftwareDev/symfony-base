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
    <h1 class="text-3xl font-bold">🎯 {{ name }}</h1>
    <p class="my-3">Welcome to your new Symfony application.</p>
  </div>
</template>