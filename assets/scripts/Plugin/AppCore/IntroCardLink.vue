<script setup lang="ts">
interface IProps
{
  url: string;
  text: string;
}

withDefaults(defineProps<IProps>(), {
  url: '#',
  text: 'Link',
});
</script>

<template>
  <a :href="url" class="text-white font-medium hover:underline">
    {{ text }}
  </a>
</template>