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
    <h1 class="text-4xl font-bold"><a href="/">🚀 {{ name }}</a></h1>
  </div>
</template>