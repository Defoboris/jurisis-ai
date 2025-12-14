<template>
  <header
    class="flex justify-center sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 dark:bg-background/20 dark:supports-[backdrop-filter]:bg-background/30">

    <div class="container flex items-center justify-between h-16">
      <div class="flex items-center gap-2">
        <Bot class="w-8 h-8 text-primary dark:text-primary/80" />
        <Link href="/"
          class="text-2xl font-bold transition-colors font-heading text-primary hover:text-primary/80 dark:text-primary/80 dark:hover:text-primary/60">
          Jurisis
        </Link>
      </div>

      <nav class="items-center hidden gap-6 md:flex">
        <Link href="/" :class="page.url === '/' ? 'text-primary font-extrabold' : ''"
          class="font-medium transition-colors text-foreground hover:text-primary dark:text-foreground/90 dark:hover:text-primary/80">
          Accueil
        </Link>
        <Link :href="route('chat')"
          class="flex items-center gap-1 font-medium transition-colors text-foreground hover:text-primary"
          :class="page.url === '/chat' ? 'text-primary font-extrabold' : ''">
          <MessageSquare class="w-4 h-4" /> Parler à Jurisis
        </Link>
        <Link :href="route('conversations')"
          class="flex items-center gap-1 font-medium transition-colors text-foreground hover:text-primary"
          :class="page.url === '/conversations' ? 'text-primary font-extrabold' : ''">
          <Users class="w-4 h-4" /> Conversations
        </Link>
        <Link :href="route('lawyers')"
          class="font-medium transition-colors text-foreground hover:text-primary dark:text-foreground/90 dark:hover:text-primary/80"
          :class="page.url === '/lawyers' ? 'text-primary font-extrabold' : ''">
          Avocats Experts
        </Link>
        <Link :href="route('subscriptions-plans')"
          class="flex items-center gap-1 font-medium transition-colors text-foreground hover:text-primary"
          :class="page.url === '/subscriptions-plans' ? 'text-primary font-extrabold' : ''">
          <Podcast class="w-4 h-4" /> Abonnements
        </Link>
      </nav>

      <!-- USER AREA -->
      <div v-if="page.props.auth.user">
        <!-- Admin / Lawyer -->
        <div v-if="['admin', 'Lawyer'].includes(page.props.auth.user.role)" class="flex items-center gap-4">
          <Link :href="route('dashboard')" v-if="page.props.auth.user.role === 'lawyer'">
            <button class="inline-flex items-center font-medium hover:text-primary">
              <User class="w-5 h-5 mr-2" /> Dashboard
            </button>
          </Link>
          <Link :href="route('super-admin.dashboard')" v-if="page.props.auth.user.role === 'admin'">
            <button class="inline-flex items-center font-medium hover:text-primary">
              <User class="w-5 h-5 mr-2" /> Dashboard
            </button>
          </Link>
        </div>

        <!-- Visitor / Member -->
        <Dropdown v-else-if="['visitor', 'member'].includes(page.props.auth.user.role)" align="right" width="48">
          <template #trigger>
            <span class="inline-flex items-center font-medium hover:text-primary">
              <button type="button" class="inline-flex items-center px-3 py-2 text-sm">
                <User class="w-5 h-5 mr-2" />
                {{ page.props.auth.user.name }}
                <svg class="ms-2 -me-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </span>
          </template>

          <template #content>
            <DropdownLink :href="route('profile.edit')" as="button"> Profile </DropdownLink>
            <DropdownLink :href="route('logout')" method="post" as="button"> Se déconnecter </DropdownLink>
          </template>
        </Dropdown>
      </div>

      <!-- Not Logged In -->
      <div v-else class="flex items-center gap-4">
        <Link :href="route('login')">
          <button class="inline-flex items-center font-medium hover:text-primary">
            <LogIn class="w-5 h-5 mr-2" /> Connecter
          </button>
        </Link>
      </div>
    </div>

    <!-- Language Selector -->
    <div class="flex items-center gap-2 pl-3">
      <button @click="isLanguageDropdownOpen = !isLanguageDropdownOpen"
        class="flex items-center px-3 py-2 space-x-2 rounded-lg hover:bg-white/10">
        <img :src="`assets/images/photos/${currentLanguage}.png`" class="w-5 h-5"
          :alt="languages[currentLanguage]" />
        <span class="text-sm font-medium">{{ languages[currentLanguage] }}</span>
        <i :class="['ri-arrow-down-s-line transition-transform', isLanguageDropdownOpen ? 'rotate-180' : '']"></i>
      </button>

      <!-- Language Dropdown Menu -->
      <div v-show="isLanguageDropdownOpen"
        class="absolute right-0 w-48 py-2 mt-1 bg-white border border-gray-100 rounded-lg shadow-lg top-full">
        <a v-for="(name, code) in languages" :key="code" href="#"
          @click.prevent="changeLanguage(code)"
          class="flex items-center px-4 py-2 text-sm hover:bg-gray-50"
          :class="currentLanguage === code ? 'text-blue-600 bg-blue-50 font-medium' : 'text-gray-700'">
          <img :src="`assets/images/photos/${code}.png`" class="w-5 h-5 mr-3" :alt="name" />
          {{ name }}
        </a>
      </div>
    </div>

    <!-- Google Translate hidden container -->
    <div id="google_translate_element" class="hidden"></div>

    <Loader ref="loader" />
  </header>
</template>

<script setup>
import { ref } from "vue";
import { usePage, Link } from "@inertiajs/vue3";

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Loader from '@/Components/Loader.vue';

import {
  Bot, Menu, User, MessageSquare, Users, Podcast, LogIn
} from "lucide-vue-next";

const page = usePage();

/* -------------------------------
   GOOGLE TRANSLATE FUNCTIONALITY
-------------------------------- */

const isLanguageDropdownOpen = ref(false);
const currentLanguage = ref("fr");

const languages = {
  fr: "Français",
  en: "English",
};

// Prevent double-loading
let googleScriptLoaded = false;

// Load Google script once
function loadGoogleTranslateScript() {
  if (googleScriptLoaded) return;
  googleScriptLoaded = true;

  const script = document.createElement("script");
  script.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateInit";
  document.head.appendChild(script);
}

// Required global callback
window.googleTranslateInit = function () {
  new window.google.translate.TranslateElement(
    { pageLanguage: "en", autoDisplay: false },
    "google_translate_element"
  );
};

// Apply translation safely
function applyTranslation(lang) {
  const interval = setInterval(() => {
    const combo = document.querySelector(".goog-te-combo");
    if (combo) {
      combo.value = lang;
      combo.dispatchEvent(new Event("change"));
      clearInterval(interval);
    }
  }, 300);
}

function changeLanguage(lang) {
  currentLanguage.value = lang;
  loadGoogleTranslateScript();

  setTimeout(() => applyTranslation(lang), 800);

  isLanguageDropdownOpen.value = false;
}
</script>
