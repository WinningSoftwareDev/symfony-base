<script setup lang="ts">
import { onMounted, ref } from 'vue';
import AppHealthCheck from '../AppHealthCheck/AppHealthCheck.vue';
import IntroCardHeader from './IntroCardHeader.vue';
import IntroCardLink from './IntroCardLink.vue';
import IUser from '../AuthCore/Interface/IUser';
import WelcomeBlock from './WelcomeBlock.vue';

interface IProps
{
  name: string;
}

const user = ref<IUser|null>(null);
const isLoading = ref<boolean>(true);

withDefaults(defineProps<IProps>(), {});

onMounted(() => {
  fetch('/authenticate/current-user')
      .then((response: Response) => {
        return response.json();
      }).then((json: IUser) => {
        isLoading.value = false;
        if (!json.email.length) {
          return;
        }

        user.value = json;
      });
});
</script>

<style scoped>
@reference 'tailwindcss/theme';

.flex-center {
  @apply flex items-center;
}
</style>
<template>
  <div class="w-full max-w-6xl mx-auto mt-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

      <div class="lg:col-span-7 space-y-6">
        <div class="bg-gray-800/40 p-8 rounded-2xl border border-gray-700 shadow-xl">
          <WelcomeBlock />

          <div class="mt-8 pt-8 border-t border-gray-700/50">
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

            <div v-if="!isLoading && !user" >
              <div class="flex flex-col sm:flex-row gap-4">
                <a href="/authenticate?form=LoginForm"
                   class="flex items-center justify-center gap-2 bg-primary hover:bg-accent text-dark-text hover:text-light-text px-8 py-3 rounded-xl font-bold transition-all transform hover:-translate-y-0.5 shadow-lg shadow-primary/20">
                  <i class="fa-duotone fa-right-to-bracket"></i>
                  Login to Account
                </a>

                <a href="/authenticate?form=RegistrationForm"
                   class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 text-white border border-gray-600 px-8 py-3 rounded-xl font-bold transition-all">
                  <i class="fa-duotone fa-user-plus text-gray-400"></i>
                  Create Account
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-5">
        <AppHealthCheck />
      </div>
    </div>
  </div>
</template>