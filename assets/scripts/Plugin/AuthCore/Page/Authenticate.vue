<script setup lang="ts">
import LoginForm from '../Form/LoginForm.vue';
import RegistrationForm from '../Form/RegistrationForm.vue';
import FormToggle from '../Component/FormToggle.vue';
import { ComponentInstance, Ref, ref, ShallowRef, shallowRef } from 'vue';

interface IFormProps
{
  name: string;
  title: string;
}

const activeComponent: ShallowRef<ComponentInstance<any>> = shallowRef(RegistrationForm);
const activeComponentProps: Ref<IFormProps> = ref<IFormProps>({
  name: '',
  title: ''
});

const componentProps: Record<string, IFormProps> = {
  RegistrationForm: {
    name: 'registration_form',
    title: 'Register'
  },
  LoginForm: {
    name: 'login_form',
    title: 'Login',
  }
}

const setActiveComponent = (component: ComponentInstance<any>): void => {
  activeComponent.value = component;
  const name = component.__name;

  Object.entries(componentProps).forEach((n) => {
    if (n[0] === name) {
      activeComponentProps.value = n[1];
    }
  });
}
setActiveComponent(RegistrationForm);
</script>

<template>
  <div class="border-2 border-gray-800 rounded-md overflow-hidden w-[600px]">
    <div class="flex border-b border-gray-700">
      <FormToggle text="Login"
                  :active="activeComponent === LoginForm"
                  @click="setActiveComponent(LoginForm)" />
      <FormToggle text="Register"
                  :active="activeComponent === RegistrationForm"
                  @click="setActiveComponent(RegistrationForm)" />
    </div>
    <div class="py-4 px-8">
      <component :is="activeComponent"
                 v-bind="activeComponentProps" />
    </div>
  </div>
</template>