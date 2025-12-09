<template>
  <section id="contact" class="py-20 bg-gradient-to-br">
    <div class="container px-4 mx-auto">
      <div class="mb-16 text-center">
        <h2 class="mb-4 text-3xl font-bold font-heading lg:text-4xl text-foreground">
          Nous soutenir
        </h2>
        <p class="max-w-2xl mx-auto text-xl font-body text-muted-foreground">
          Rejoignez notre communauté et contribuez au développement d'une IA juridique accessible à tous.
        </p>
      </div>

      <div class="grid gap-12 lg:grid-cols-2">
        <div>
          <div class="mb-8 border-0 rounded-lg shadow-sm bg-card">
            <div class="p-6">
              <h3 class="mb-6 text-2xl font-heading">Démarrer avec l'expert</h3>
            </div>
            <div class="px-6 pb-6 space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <input 
                  v-model="form.firstName"
                  placeholder="Prénom" 
                  class="flex w-full h-10 px-3 py-2 text-sm border rounded-md border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                />
                <input 
                  v-model="form.lastName"
                  placeholder="Nom" 
                  class="flex w-full h-10 px-3 py-2 text-sm border rounded-md border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                />
              </div>
              <input 
                v-model="form.email"
                placeholder="Email" 
                type="email" 
                class="flex w-full h-10 px-3 py-2 text-sm border rounded-md border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              />
              <input 
                v-model="form.company"
                placeholder="Entreprise (optionnel)" 
                class="flex w-full h-10 px-3 py-2 text-sm border rounded-md border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              />
              <textarea 
                v-model="form.message"
                placeholder="Décrivez votre besoin juridique..." 
                class="flex w-full px-3 py-2 text-sm border rounded-md min-h-32 border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              ></textarea>
              <button 
                @click="submitForm"
                class="inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90"
              >
                Démarrer avec l'expert
              </button>

              <div class="pt-4 text-center">
                <p class="mb-2 text-sm text-muted-foreground">Ou essayez notre IA gratuitement</p>
                <Link 
                  :href="route('chat')"
                  class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-transparent border rounded-md whitespace-nowrap ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-accent hover:text-accent-foreground"
                >
                  <MessageSquare class="w-4 h-4 mr-2" />
                  Parler à Jurisis
                </Link>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div 
            v-for="(info, index) in contactInfo" 
            :key="index" 
            class="border-0 rounded-lg shadow-sm bg-card"
          >
            <div class="p-6">
              <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-primary/10">
                  <component :is="info.icon" class="w-5 h-5 text-primary" />
                </div>
                <div>
                  <h3 class="mb-2 text-lg font-semibold font-heading">{{ info.title }}</h3>
                  <p 
                    v-for="(detail, idx) in info.details" 
                    :key="idx" 
                    class="font-body text-muted-foreground"
                  >
                    {{ detail }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { MessageSquare, Phone, Mail, MapPin } from 'lucide-vue-next'
import { Link, router  } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";


const form = reactive({
  firstName: '',
  lastName: '',
  email: '',
  company: '',
  message: ''
})

const contactInfo = ref([
  {
    icon: MessageSquare,
    title: "Chat IA",
    details: ["Disponible 24h/24", "Réponses instantanées"],
  },
  {
    icon: Phone,
    title: "Support Expert",
    details: ["+32 2 123 45 67", "Lun-Ven: 9h00-18h00"],
  },
  {
    icon: Mail,
    title: "Email",
    details: ["contact@jurisis.be", "support@jurisis.be"],
  },
  {
    icon: MapPin,
    title: "Siège Social",
    details: ["Rue de la Loi 123", "1000 Bruxelles, Belgique"],
  },
])

const submitForm = () => {
  router.post(route('contact.store'), form, {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Merci pour votre message, nous vous contacterons sous peu", {
        autoClose: 3000,
        position: "top-right",
      });

      // Reset the form
      form.firstName = '';
      form.lastName = '';
      form.email = '';
      form.company = '';
      form.message = '';
    },
    onError: (errors) => {
      toast.error("Veuillez vérifier les informations du formulaire.", {
        autoClose: 3000,
        position: "top-right",
      });
      console.log(errors)
    }
  });
};

const startChat = () => {
  console.log('Starting chat with Jurisis AI')
  // Handle chat initiation logic here
}
</script>