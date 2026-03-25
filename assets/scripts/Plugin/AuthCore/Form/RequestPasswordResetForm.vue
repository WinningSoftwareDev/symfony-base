<script setup lang="ts">
import AuthForm from './AuthForm.vue';
import {computed, reactive} from 'vue';
import IFormField from '../Interface/IFormField';
import FormField from './FormField.vue';
import IAuthFormInternalProps from '../Interface/IAuthFormInternalProps';
import FormSubmit from './FormSubmit.vue';

const formFields = reactive<Record<string, IFormField>>({
  'email': {
    value: 'danielwinning@proton.me',
    errors: [],
  },
});
const email = computed({
  get: () => formFields.email.value,
  set: (val: string) => {
    formFields.email.value = val;
  }
});

const getFormData = (): Record<string, IFormField> => {
  return formFields;
}
const clearValidationErrors = () => {
  formFields.email.errors = [];
}
const validate = (): boolean => {
  return true;
}
const handleSubmit = async (): Promise<boolean> => {
  clearValidationErrors();

  return validate();
}

withDefaults(defineProps<IAuthFormInternalProps>(), {
  name: 'request_password_reset_link_form',
  title: 'Reset Your Password',
});
</script>

<template>
  <AuthForm :title="title"
            text="If you've forgotten your password, no problem. Enter your email address, and we'll email you a link that will allow you to choose a new one."
            endpoint="/authenticate/password-reset"
            :handler="handleSubmit"
            @submission:failed="() => {}"
            :name="name"
            :data="getFormData()">
    <FormField type="email"
               label="Email"
               v-model="email"
               :name="`${name}[email]`"
               :id="`${name}_email`"
               :required="true"
               :errors="formFields.email.errors"
               placeholder="Enter Your Email Address"
               @input="clearValidationErrors" />
    <FormSubmit :text="title" />
  </AuthForm>
</template>