<script setup lang="ts">
interface IProps
{
  type: string;
  label: string;
  placeholder: string;
  name: string;
  id: string;
  required?: boolean;
  errors?: string[];
}

const model = defineModel<string>();

withDefaults(defineProps<IProps>(), {
  placeholder: 'Enter',
  required: false,
});
</script>

<template>
  <div>
    <label class="font-semibold">{{ label }}</label>
    <input :type="type"
           class="mt-1 p-2 block w-full rounded-md border font-bold placeholder-gray-500 focus:outline-none focus:ring-primary focus:ring focus:border-primary/40"
           :class="{'bg-red-200/10': errors?.length}"
           :name="name"
           :id="id"
           :placeholder="placeholder"
           v-model="model"
           v-bind="{ required }" />
    <div v-if="errors?.length" class="text-red-300">
      <p v-for="err in errors" class="text-sm mt-1 first:mt-2">
        {{ err }}
      </p>
    </div>
  </div>
</template>