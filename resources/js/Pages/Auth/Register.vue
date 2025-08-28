<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit" class="space-y-6">
      <!-- Name -->
      <div>
        <InputLabel for="name" value="Name" class="text-[hsl(var(--foreground))]" />

        <TextInput
          id="name"
          type="text"
          class="mt-1 block w-full border border-[hsl(var(--border))] focus:ring-[hsl(var(--ring))]"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
        />

        <InputError class="mt-2 text-[hsl(var(--destructive))]" :message="form.errors.name" />
      </div>

      <!-- Email -->
      <div>
        <InputLabel for="email" value="Email" class="text-[hsl(var(--foreground))]" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full border border-[hsl(var(--border))] focus:ring-[hsl(var(--ring))]"
          v-model="form.email"
          required
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
          autocomplete="new-password"
        />

        <InputError class="mt-2 text-[hsl(var(--destructive))]" :message="form.errors.password" />
      </div>

      <!-- Password Confirmation -->
      <div>
        <InputLabel for="password_confirmation" value="Confirm Password" class="text-[hsl(var(--foreground))]" />

        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full border border-[hsl(var(--border))] focus:ring-[hsl(var(--ring))]"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
        />

        <InputError class="mt-2 text-[hsl(var(--destructive))]" :message="form.errors.password_confirmation" />
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-between">
        <Link
          :href="route('login')"
          class="underline text-sm text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))]"
        >
          Already registered?
        </Link>

        <PrimaryButton
          class="ms-4 bg-[hsl(var(--primary))] text-[hsl(var(--primary-foreground))] hover:bg-[hsl(var(--ring))]"
          :class="{ 'opacity-50': form.processing }"
          :disabled="form.processing"
        >
          Register
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>