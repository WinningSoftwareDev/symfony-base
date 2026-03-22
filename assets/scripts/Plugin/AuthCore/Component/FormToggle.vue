<script setup lang="ts">
import { Component } from 'vue';

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
        :class="{'bg-primary hover:bg-pink-700': active, 'hover:bg-pink-200/10': !active}">
    {{ text }}
  </span>
</template>