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
  <span class="px-5 py-3.5 cursor-pointer text-xl flex-1 text-center"
        :class="{'bg-primary hover:bg-purple-800': active, 'hover:bg-purple-800/30': !active}">
    {{ text }}
  </span>
</template>