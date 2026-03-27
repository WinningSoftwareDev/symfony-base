<script setup lang="ts">
interface IProps
{
  text: string;
  active: boolean;
}

withDefaults(defineProps<IProps>(), {
  active: false
});
</script>

<template>
  <span class="px-5 py-3.5 cursor-pointer text-xl flex-1 text-center transition duration-150"
        :class="{'bg-primary hover:bg-accent hover:text-light-text text-dark-text': active, 'hover:bg-accent/30': !active}">
    {{ text }}
  </span>
</template>