<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
  <GuestLayout>
    <Head title="Log in" />

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-[hsl(var(--primary))]"
    >
      {{ status }}
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      <!-- Email -->
      <div>
        <InputLabel for="email" value="Email" class="text-[hsl(var(--foreground))]" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full border border-[hsl(var(--border))] focus:ring-[hsl(var(--ring))]"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
        />

        <InputError class="mt-2 text-[hsl(var(--destructive))]" :message="form.errors.email" />
      </div>

      <!-- Password -->
      <div>
        <InputLabel for="password" value="Password" class="text-[hsl(var(--foreground))]" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full border border-[hsl(var(--border))] focus:ring-[hsl(var(--ring))]"
          v-model="form.password"
          required
          autocomplete="current-password"
        />

        <InputError class="mt-2 text-[hsl(var(--destructive))]" :message="form.errors.password" />
      </div>

      <!-- Remember -->
      <div class="block">
        <label class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ms-2 text-sm text-[hsl(var(--muted-foreground))]">
            Remember me
          </span>
        </label>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-between">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))]"
        >
          Forgot your password?
        </Link>

        <PrimaryButton
          class="ms-4 bg-[hsl(var(--primary))] text-[hsl(var(--primary-foreground))] hover:bg-[hsl(var(--ring))]"
          :class="{ 'opacity-50': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </PrimaryButton>
      </div>
      <div>
        <Link
          :href="route('register')"
          class=" text-sm text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))]"
        >
          I don't have an account?
        </Link>
        </div>
    </form>
  </GuestLayout>
</template>