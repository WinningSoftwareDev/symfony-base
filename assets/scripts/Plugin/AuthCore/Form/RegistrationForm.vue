<script setup lang="ts">
import AuthForm from './AuthForm.vue';
import FormSubmit from './FormSubmit.vue';
import FormField from './FormField.vue';
import {reactive} from 'vue';

interface IProps
{
  name: string;
  title: string;
}

const formFields = reactive({
  email: {
    value: '',
    error: null,
  },
  password: {
    value: '',
    error: null,
  },
  confirmPassword: {
    value: '',
    error: null,
  }
})

withDefaults(defineProps<IProps>(), {
  name: 'registration_form',
  title: 'Register',
});
</script>

<template>
  <AuthForm title="Register"
            text="Register to create your own account and access members-only features."
            endpoint="/auth/register">
    <FormField type="email"
               label="Email"
               :name="`${name}[email]`"
               :id="`${name}_email`"
               :required="true"
               placeholder="Enter Your Email Address" />
    <FormField type="password"
               label="Password"
               :name="`${name}[password]`"
               :id="`${name}_password`"
               :required="true"
               placeholder="Enter Your Password" />
    <FormField type="password"
               label="Confirm Password"
               :name="`${name}[confirm_password]`"
               :id="`${name}_confirm_password`"
               :required="true"
               placeholder="Confirm Your Password" />
    <FormSubmit :text="title"></FormSubmit>
  </AuthForm>
</template>