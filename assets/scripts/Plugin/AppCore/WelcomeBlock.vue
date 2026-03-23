<script setup lang="ts">
const items = [
    'Symfony 7.3',
    'Latte Templating Engine',
    'TypeScript',
    'Vue 3',
    'SASS/SCSS',
    'Tailwind CSS',
    'Vite (with HMR support)',
    'Email Builder',
    'Authentication System; Login, Registration, Email Verification & Password Reset',
];
</script>
<template>
  <div class="text-left">
    <p class="my-3 italic">
      Welcome to <strong>Symfony on steroids</strong>.
    </p>
    <p class="my-3 italic">
      Your new app is ready to go with a load of powerful tools baked right in. Get ready to experience the combined
      power of:
    </p>
    <ul class="list-disc ml-12 my-4 italic space-y-1">
      <li v-for="item in items">
        {{ item }}
      </li>
    </ul>
    <p class="my-3 italic">
      Combine this with a development environment powered by <strong>Docker</strong> and <strong>Loom Spinner</strong>
      for an incredible development experience!
    </p>
  </div>
</template>