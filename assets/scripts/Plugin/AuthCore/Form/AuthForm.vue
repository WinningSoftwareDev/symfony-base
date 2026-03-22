<script setup lang="ts">
import {ref} from 'vue';
import IAuthFormProps from '../Interface/IAuthFormProps';

const isSubmitting = ref(false);

withDefaults(defineProps<IAuthFormProps>(), {});
</script>

<template>
  <h1 class="text-2xl font-bold text-center">{{ title }}</h1>
  <p class="my-3 text-center">
    {{ text }}
  </p>
  <form method="POST" class="space-y-5 mt-6" autocomplete="off" @submit.prevent>
    <slot v-if="!isSubmitting"></slot>
    <div v-if="isSubmitting" class="text-center">
      <i class="fa-duotone fa-light mx-auto fa-fan fa-spin fa-3x mt-2"></i>
    </div>
  </form>
</template>