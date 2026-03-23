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
  <button type="submit"
          class="w-full py-2 px-4 cursor-pointer bg-primary font-semibold text-dark-text rounded-lg hover:bg-accent hover:text-light-text transition duration-150">
    {{ text }}
  </button>
</template>

<style scoped>

</style>