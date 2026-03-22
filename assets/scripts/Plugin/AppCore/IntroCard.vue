<script setup lang="ts">
import IntroCardHeader from './IntroCardHeader.vue';
import AppHealthCheck from '../AppHealthCheck/AppHealthCheck.vue';
import {onMounted, ref} from 'vue';
import IntroCardLink from './IntroCardLink.vue';

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
  <div class="text-center border-3 border-primary rounded-lg shadow-lg px-4 py-8 max-w-[400px] min-w-[380px] w-full">
    <IntroCardHeader :name="name" />
    <AppHealthCheck />

    <div v-if="isLoading" class="text-center mt-5">
      <i class="fa-duotone fa-light mx-auto fa-fan fa-spin fa-3x mt-2"></i>
    </div>
    <div v-if="user">
      <div>
        <p class="my-3">
          Logged in as <strong>{{ user.email }}</strong>
        </p>
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
      <p class="my-3">
        <IntroCardLink url="/authenticate?form=LoginForm" text="Login" />
        or <IntroCardLink url="/authenticate?form=RegistrationForm" text="Register" />
        to access your application
      </p>
    </div>
    <div class="mt-6 pt-6 text-sm text-blue-100 border-t border-gray-700">
      <p>Built with the Symfony Framework</p>
    </div>
  </div>
</template>

<style scoped>

</style>