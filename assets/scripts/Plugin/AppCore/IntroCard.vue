<script setup lang="ts">
import IntroCardHeader from './IntroCardHeader.vue';
import AppHealthCheck from '../AppHealthCheck/AppHealthCheck.vue';
import {onMounted, ref} from 'vue';
import IntroCardLink from './IntroCardLink.vue';
import WelcomeBlock from './WelcomeBlock.vue';

interface IUser
{
  email: string;
  verified: boolean;
}

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

<template>
  <div class="text-center px-6 py-8 w-full mx-auto mt-12 md:w-[90vw] lg:w-[76vw]">
    <IntroCardHeader :name="name" />
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <AppHealthCheck />
      <div v-if="user">
        <div>
          <p class="bg-green-200/10 px-2 py-1.5 mb-3 rounded-md text-sm">
            Logged in as <strong>{{ user.email }}</strong>
          </p>
          <WelcomeBlock />
        </div>
        <div v-if="!user.verified" class="bg-yellow-500 p-2 rounded-md border-2 border-yellow-200">
          <p class="text-gray-900">
            Your email address is not yet verified.
          </p>
        </div>
        <div>
          <p class="my-3">
            <IntroCardLink url="/auth/logout" text="Logout" />
          </p>
        </div>
      </div>
      <div v-if="!user">
        <p class="bg-green-200/10 px-2 py-1.5 mb-3 rounded-md text-sm">
          You are not logged in
        </p>
        <WelcomeBlock />
        <p class="my-3 bg-primary py-2 px-1.5 text-dark-text">
          <IntroCardLink url="/authenticate?form=LoginForm" text="Login" :classes="['text-dark-text']" />
          or <IntroCardLink url="/authenticate?form=RegistrationForm" text="Register" />
          to access your application
        </p>
      </div>
    </div>
    <div class="mt-6 pt-6 text-sm text-blue-100 border-t border-gray-700">
      <p>Built with the Symfony Framework</p>
    </div>
  </div>
</template>

<style scoped>

</style>