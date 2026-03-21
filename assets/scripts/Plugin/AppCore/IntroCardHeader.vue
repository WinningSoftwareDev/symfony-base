<script setup lang="ts">
interface IProps
{
  name: string;
}

const props = withDefaults(defineProps<IProps>(), {
  name: 'My App',
});

console.log(props);
</script>

<template>
  <div class="text-gray-900">
    <h1 class="text-3xl font-bold">🎯 {{ name }}</h1>
    <p class="my-3">Welcome to your new Symfony application.</p>
  </div>
</template>

<style scoped>

</style>