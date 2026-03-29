<script setup lang="ts">
import IntroCardLink from './IntroCardLink.vue';
import IUser from '../AuthCore/Interface/IUser';

interface IProps
{
  user: IUser|null;
}

withDefaults(defineProps<IProps>(), {
  user: null
});
</script>

<template>
  <div v-if="user" class="space-y-4">
    <div class="flex items-center gap-3 text-green-400 bg-green-400/10 w-fit px-4 py-2 rounded-full text-sm font-medium">
      <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
      </span>
      Authenticated as {{ user.email }}
    </div>

    <div v-if="!user.verified" class="bg-amber-500/10 border border-amber-500/50 p-4 rounded-xl text-amber-200 text-sm">
      <i class="fa-duotone fa-triangle-exclamation mr-2"></i>
      Please check your inbox to verify your email address.
    </div>

    <div class="flex gap-4 items-center">
      <a href="/user/account"
         class="flex items-center gap-2 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 px-5 py-2 rounded-xl text-sm font-bold transition-all border border-indigo-500/20">
        <i class="fa-duotone fa-objects-column"></i>
        Go to Account Dashboard
      </a>
      <IntroCardLink url="/authenticate/logout" text="Logout" class="text-gray-400 hover:text-white" />
    </div>
  </div>
</template>