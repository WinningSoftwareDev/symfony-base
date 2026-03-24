<script setup lang="ts">
import AuthForm from './AuthForm.vue';
import {computed, reactive} from 'vue';
import IFormField from '../Interface/IFormField';
import FormField from './FormField.vue';
import IAuthFormInternalProps from '../Interface/IAuthFormInternalProps';
import FormSubmit from './FormSubmit.vue';

const formFields = reactive<Record<string, IFormField>>({
  'password': {
    value: '',
    errors: [],
  },
  'confirm_password': {
    value: '',
    errors: [],
  }
});
const password = computed({
  get: () => formFields.password.value,
  set: (val: string) => {
    formFields.password.value = val;
  }
});
const confirmPassword = computed({
  get: () => formFields.confirm_password.value,
  set: (val: string) => {
    formFields.confirm_password.value = val;
  }
});

const getFormData = (): Record<string, IFormField> => {
  return formFields;
}

const clearValidationErrors = () => {
  formFields.email.errors = [];
  formFields.password.errors = [];
  formFields.confirm_password.errors = [];
}

const validate = (): boolean => {
  if (formFields.password.value.length < 8) {
    formFields.password.errors.push('Password must contain a minimum of 8 characters.');
  }

  if (formFields.password.value !== formFields.confirm_password.value) {
    formFields.password.errors.push('Passwords do not match.');
    formFields.confirm_password.errors.push('Passwords do not match.');
  }

  return !(formFields.password.errors.length || formFields.confirm_password.errors.length);
}
const handleSubmit = async (): Promise<boolean> => {
  clearValidationErrors();

  return validate();
}
const handleFailedSubmit = (errors: Record<string, string[]>) => {
  if (errors.email !== undefined) {
    formFields.email.errors.push(...errors.email);
  }
}

withDefaults(defineProps<IAuthFormInternalProps>(), {
  name: 'registration_form',
  title: 'Reset Your Password',
});
</script>

<template>
  <AuthForm :title="title"
            text="If you've forgotten your password, no problem. Enter your email address, and we'll email you a link that will allow you to choose a new one."
            endpoint="/auth/reset-password"
            :handler="handleSubmit"
            @submission:failed="handleFailedSubmit"
            :name="name"
            :data="getFormData()">
    <FormField type="password"
               label="Password"
               v-model="password"
               :name="`${name}[password]`"
               :id="`${name}_password`"
               :required="true"
               :errors="formFields.password.errors"
               placeholder="Enter Your Password"
               @input="clearValidationErrors" />
    <FormField type="password"
               label="Confirm Password"
               v-model="confirmPassword"
               :name="`${name}[confirm_password]`"
               :id="`${name}_confirm_password`"
               :required="true"
               :errors="formFields.confirm_password.errors"
               placeholder="Confirm Your Password"
               @input="clearValidationErrors" />
    <FormSubmit :text="title" />
  </AuthForm>
</template>

<style scoped>

</style>