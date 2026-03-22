<script setup lang="ts">
import AuthForm from './AuthForm.vue';
import FormSubmit from './FormSubmit.vue';
import FormField from './FormField.vue';
import {Ref, ref} from 'vue';
import IAuthFormInternalProps from '../Interface/IAuthFormInternalProps';

interface IFormField
{
  type: string;
  label: string;
  name: string;
  id: string;
  placeholder: string;
}

const newFormField = (name: string, type: string, label: string, placeholder: string): IFormField => {
  return {
    type: type,
    label: label,
    placeholder: placeholder,
    name: `${props.name}[${name}]`,
    id: `${props.name}_${name}`
  };
}

const props = withDefaults(defineProps<IAuthFormInternalProps>(), {});
const formFields: Ref<IFormField[]> = ref([
  newFormField('email', 'email', 'Email', 'Enter Your Email Address'),
  newFormField('password', 'password', 'Password', 'Enter Your Password'),
]);
const handleSubmit = (event: SubmitEvent) => {
  console.log(event);
  event.preventDefault();
}
</script>

<template>
  <AuthForm :title="title"
            text="Welcome back. Sign in to your account to access your information and members-only features."
            endpoint="/auth/login">
    <FormField v-for="item in formFields"
               :type="item.type"
               :label="item.label"
               :name="item.name"
               :id="item.id"
               :placeholder="item.placeholder"/>
    <FormSubmit :text="title" @click="handleSubmit" />
  </AuthForm>
</template>