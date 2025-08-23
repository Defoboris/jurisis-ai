<template>
    <footer class="w-full py-16 bg-foreground text-background">
      <div class="px-8 mx-auto">
        <div class="grid gap-8 mb-12 md:grid-cols-2 lg:grid-cols-4">
          <div>
            <div class="flex items-center gap-2 mb-6">
              <Bot class="w-8 h-8 text-secondary" />
              <span class="text-2xl font-bold font-heading">Jurisis</span>
            </div>
            <p class="mb-6 leading-relaxed font-body text-background/80">
              Jurisis est une plateforme d'IA qui fournit des réponses juridiques contextualisées via un chat
              intelligent. Révolutionnons ensemble l'accès au droit.
            </p>
            <div class="flex gap-4">
              <button size="icon" variant="ghost" class="text-background hover:text-secondary">
                <Facebook class="w-5 h-5" />
              </button>
              <button size="icon" variant="ghost" class="text-background hover:text-secondary">
                <Twitter class="w-5 h-5" />
              </button>
              <button size="icon" variant="ghost" class="text-background hover:text-secondary">
                <Linkedin class="w-5 h-5" />
              </button>
              <button size="icon" variant="ghost" class="text-background hover:text-secondary">
                <Mail class="w-5 h-5" />
              </button>
            </div>
          </div>

          <div>
            <h3 class="mb-4 text-lg font-semibold font-heading">Parler à Jurisis</h3>
            <ul class="space-y-2 font-body">
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  Parler à un expert
                </a>
              </li>
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  Comment ça marche
                </a>
              </li>
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  Nous soutenir
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h3 class="mb-4 text-lg font-semibold font-heading">Formation IA pour avocats</h3>
            <ul class="space-y-2 font-body">
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  Jurisis pour votre cabinet
                </a>
              </li>
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  Jurisis Pro (Professionnel)
                </a>
              </li>
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  EU ACT
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h3 class="mb-4 text-lg font-semibold font-heading">Actualités</h3>
            <ul class="space-y-2 font-body">
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  FAQ
                </a>
              </li>
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  RGPD
                </a>
              </li>
              <li>
                <a href="#" class="transition-colors text-background/80 hover:text-secondary">
                  Termes et conditions
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="pt-8 border-t border-background/20">
          <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
            <p class="text-sm font-body text-background/60">Jurisis © 2024, tous droits réservés</p>
            <div class="flex gap-6 text-sm font-body">
              <a href="#" class="transition-colors text-background/60 hover:text-secondary">
                Legal
              </a>
              <a href="#" class="transition-colors text-background/60 hover:text-secondary">
                Cookies
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
</template>
<script setup>
import { Bot, Facebook, Twitter, Linkedin, Mail } from 'lucide-vue-next';

</script>
<style scoped>

</style>
