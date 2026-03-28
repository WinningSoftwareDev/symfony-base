<script setup lang="ts">
interface IProps
{
  text: string;
}

withDefaults(defineProps<IProps>(), {
  text: '',
});
</script>

<template>
  <button class="w-full cursor-pointer flex items-center justify-center gap-2 bg-primary hover:bg-accent text-dark-text hover:text-light-text px-8 py-3 rounded-xl font-bold transition-all transform hover:-translate-y-0.5 shadow-lg shadow-primary/20 mt-6">
    {{ text }}
  </button>
</template>