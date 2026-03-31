<script setup lang="ts">
import { Ref, ref, ShallowRef, shallowRef } from 'vue';
import FormToggle from '../Component/FormToggle.vue';
import IAuthFormInternalProps from '../Interface/IAuthFormInternalProps';
import LoginForm from '../Form/LoginForm.vue';
import RegistrationForm from '../Form/RegistrationForm.vue';

interface IProps
{
  form: string|null;
  loginToken: string;
  registrationToken: string;
}

type AuthenticationFormComponent = typeof LoginForm | typeof RegistrationForm;

const props = withDefaults(defineProps<IProps>(), {});
const activeComponent: ShallowRef<AuthenticationFormComponent> = shallowRef(
    props.form === 'LoginForm' ? LoginForm : RegistrationForm
);
const componentProps: Record<string, IAuthFormInternalProps> = {
  RegistrationForm: {
    name: 'registration_form',
    title: 'Register',
    csrfToken: props.registrationToken
  },
  LoginForm: {
    name: 'login_form',
    title: 'Login',
    csrfToken: props.loginToken
  }
}
const activeComponentProps: Ref<IAuthFormInternalProps> = ref<IAuthFormInternalProps>(props.form === 'LoginForm' ? componentProps.LoginForm : componentProps.RegistrationForm);

const setActiveComponent = (component: AuthenticationFormComponent): void => {
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
  <div class="bg-gray-800/40 backdrop-blur-sm border border-gray-700/50 rounded-2xl overflow-hidden w-[96vw] mx-auto sm:w-[500px] min-h-[580px] shadow-2xl mt-12">
    <div class="flex border-b border-gray-700/50 bg-gray-900/20">
      <FormToggle text="Login"
                  :active="activeComponent === LoginForm"
                  @click="setActiveComponent(LoginForm)" />
      <FormToggle text="Register"
                  :active="activeComponent === RegistrationForm"
                  @click="setActiveComponent(RegistrationForm)" />
    </div>
    <div class="py-10 px-10">
      <component :is="activeComponent" v-bind="activeComponentProps" />
    </div>
  </div>
</template>