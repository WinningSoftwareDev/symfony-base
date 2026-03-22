<script setup lang="ts">
interface IProps
{
  type: string;
  label: string;
  placeholder: string;
  name: string;
  id: string;
  required?: boolean;
}

withDefaults(defineProps<IProps>(), {
  placeholder: 'Enter',
  required: false
});
</script>

<template>
  <div>
    <label class="font-semibold">{{ label }}</label>
    <input :type="type"
           class="mt-1 p-2 block w-full rounded-md border font-bold placeholder-gray-500 focus:outline-none focus:ring-primary focus:ring focus:border-primary/40"
           :name="name"
           :id="id"
           :placeholder="placeholder"
           v-bind="{ required }" />
  </div>
</template>