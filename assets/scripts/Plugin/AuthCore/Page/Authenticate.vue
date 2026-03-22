<script setup lang="ts">
import LoginForm from '../Form/LoginForm.vue';
import RegistrationForm from '../Form/RegistrationForm.vue';
import FormToggle from '../Component/FormToggle.vue';
import { ComponentInstance, Ref, ref, ShallowRef, shallowRef } from 'vue';
import IAuthFormInternalProps from '../Interface/IAuthFormInternalProps';

interface IProps
{
  form: string|null;
}

const props = withDefaults(defineProps<IProps>(), {});
const activeComponent: ShallowRef<ComponentInstance<any>> = shallowRef(props.form === 'LoginForm' ? LoginForm : RegistrationForm);
const componentProps: Record<string, IAuthFormInternalProps> = {
  RegistrationForm: {
    name: 'registration_form',
    title: 'Register'
  },
  LoginForm: {
    name: 'login_form',
    title: 'Login',
  }
}
const activeComponentProps: Ref<IAuthFormInternalProps> = ref<IAuthFormInternalProps>(props.form === 'LoginForm' ? componentProps.LoginForm : componentProps.RegistrationForm);

const setActiveComponent = (component: ComponentInstance<any>): void => {
  activeComponent.value = component;

  Object.entries(componentProps).forEach((c: [string, IAuthFormInternalProps]) => {
    if (c[0] === component.__name) {
      activeComponentProps.value = c[1];
    }
  });
}
setActiveComponent(props.form === 'LoginForm' ? LoginForm : RegistrationForm);
</script>

<template>
  <div class="border-2 border-gray-800 rounded-md overflow-hidden w-[96vw] mx-auto sm:w-[500px] min-h-[580px]">
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