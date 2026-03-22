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
          class="w-full py-2 px-4 cursor-pointer bg-primary text-white rounded-lg hover:bg-purple-800">
    {{ text }}
  </button>
</template>

<style scoped>

</style>