<script setup lang="ts">
interface IProps
{
  url: string;
  text: string;
  classes?: string[];
}

withDefaults(defineProps<IProps>(), {
  url: '#',
  text: 'Link'
});
</script>

<template>
  <a :href="url"
     class="font-medium hover:text-accent transition duration-150">
    {{ text }}
  </a>
</template>