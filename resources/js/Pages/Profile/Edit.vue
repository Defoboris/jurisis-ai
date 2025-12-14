<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto space-y-6">


            <div class="py-12 mb-8">
                <h1 class="text-3xl font-bold text-slate-900 text-balance">Paramètres du compte</h1>
                <p class="mt-2 text-slate-600">Gérez les informations de votre profil et les paramètres de sécurité</p>
            </div>
            <!-- Profile Information Section -->
            <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Informations du profil</h2>
                            <p class="mt-1 text-sm text-slate-600">Mettez à jour les informations de votre profil et votre adresse e-mail</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                    <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                        <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                            class="max-w-xl" />
                    </div>

                    <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>

                    <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                        <DeleteUserForm class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
