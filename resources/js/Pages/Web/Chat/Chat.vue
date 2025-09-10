<template>
  <Header />
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-emerald-50/30">
    <div class="container px-4 py-8 mx-auto">
      <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
          <div class="flex items-center justify-center gap-3 mb-4">
            <div class="relative">
              <component :is="Bot" class="w-12 h-12 text-primary" />
              <component
                :is="Sparkles"
                class="absolute w-4 h-4 text-yellow-500 -top-1 -right-1"
              />
            </div>
            <h1 class="text-3xl font-bold font-heading text-foreground">
              Chat avec Jurisis AI
            </h1>
          </div>
          <p class="max-w-2xl mx-auto text-muted-foreground">
            Posez vos questions juridiques à notre assistant IA. Obtenez des
            réponses instantanées et des conseils personnalisés 24h/24.
          </p>
        </div>

        <!-- Chat Container -->
        <div
          class="h-[600px] flex flex-col bg-white rounded-lg border shadow-sm"
        >
          <!-- Messages -->
          <div
            class="flex-1 p-6 space-y-4 overflow-y-auto"
            ref="messagesContainer"
          >
            <div
              v-for="message in messages"
              :key="message.id"
              :class="[
                'flex gap-3',
                message.sender === 'user' ? 'justify-end' : 'justify-start',
              ]"
            >
              <!-- AI Avatar -->
              <div
                v-if="message.sender === 'ai'"
                class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-primary-foreground"
              >
                <component :is="Bot" class="w-4 h-4" />
              </div>

              <!-- Message Content -->
              <div
                :class="[
                  'max-w-[70%] rounded-lg px-4 py-2',
                  message.sender === 'user'
                    ? 'bg-primary text-primary-foreground'
                    : 'bg-slate-100',
                ]"
              >
                <p v-if="message.sender === 'user'" class="text-sm">
                  {{ message.content }}
                </p>

                <p
                  v-else
                  class="text-sm"
                  v-html="formatMessageContent(message.content)"
                ></p>

                <span class="block mt-1 text-xs opacity-70">
                  {{ formatTime(message.timestamp) }}
                </span>
              </div>

              <!-- User Avatar -->
              <div
                v-if="message.sender === 'user'"
                class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-200"
              >
                <component :is="User" class="w-4 h-4" />
              </div>
            </div>

            <!-- Typing Indicator -->
            <div v-if="isTyping" class="flex justify-start gap-3">
              <div
                class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-primary-foreground"
              >
                <component :is="Bot" class="w-4 h-4" />
              </div>
              <div class="px-4 py-2 rounded-lg bg-muted">
                <div class="flex gap-1">
                  <div
                    class="w-2 h-2 rounded-full bg-muted-foreground animate-bounce"
                  ></div>
                  <div
                    class="w-2 h-2 rounded-full bg-muted-foreground animate-bounce"
                    style="animation-delay: 0.1s"
                  ></div>
                  <div
                    class="w-2 h-2 rounded-full bg-muted-foreground animate-bounce"
                    style="animation-delay: 0.2s"
                  ></div>
                </div>
              </div>
            </div>

            <div ref="messagesEndRef" />
          </div>

          <!-- Quick Questions -->
          <div v-if="messages.length === 1" class="px-6 pb-4">
            <p class="mb-3 text-sm text-muted-foreground">
              Questions fréquentes :
            </p>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
              <button
                v-for="(question, index) in quickQuestions"
                :key="index"
                @click="inputValue = question"
                class="justify-start h-auto px-3 py-2 text-sm text-left bg-transparent border rounded-md border-input hover:bg-accent hover:text-accent-foreground"
              >
                {{ question }}
              </button>
            </div>
          </div>

          <!-- Input -->
          <div class="p-4 border-t">
            <div class="flex gap-2">
              <input
                v-model="inputValue"
                @keypress="handleKeyPress"
                :disabled="isTyping"
                placeholder="Tapez votre question juridique..."
                class="flex flex-1 w-full h-10 px-3 py-2 text-sm border rounded-md border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              />
              <button
                @click="handleSendMessage"
                :disabled="!inputValue.trim() || isTyping"
                class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium transition-colors rounded-md bg-primary text-primary-foreground hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
              >
                <component :is="Send" class="w-4 h-4" />
              </button>
            </div>
            <p class="mt-2 text-xs text-muted-foreground">
              Appuyez sur Entrée pour envoyer • Les réponses sont à titre
              informatif uniquement
            </p>
          </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-8 text-center">
          <p class="mb-4 text-muted-foreground">
            Besoin d'un conseil personnalisé ? Consultez nos experts.
          </p>
          <div class="flex justify-center gap-4">
            <Link
              :href="route('conversations')"
              class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md bg-primary text-primary-foreground hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
            >
              Parler à un Avocat
            </Link>
            <Link
              :href="route('lawyers')"
              class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors rounded-md bg-primary text-primary-foreground hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
            >
              Voir les Avocats Experts
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, nextTick, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { marked } from "marked";
import { Bot, Send, User, Sparkles } from "lucide-vue-next";
import Header from "@/Components/WebComponents/Header.vue";
import { toast } from "vue3-toastify";

const page = usePage();

const messages = ref([
  {
    id: "1",
    content:
      "Bonjour ! Je suis Jurisis, votre assistant juridique IA. Comment puis-je vous aider aujourd'hui ?",
    sender: "ai",
    timestamp: new Date(),
  },
]);

const inputValue = ref("");
const isTyping = ref(false);
const messagesEndRef = ref(null);

const quickQuestions = [
  "Comment divorcer par consentement mutuel ?",
  "Quels sont mes droits en cas de licenciement ?",
  "Comment rédiger un testament ?",
  "Que faire en cas de litige avec mon propriétaire ?",
];

const scrollToBottom = () => {
  nextTick(() => {
    messagesEndRef.value?.scrollIntoView({ behavior: "smooth" });
  });
};

const formatTime = (timestamp) =>
  timestamp.toLocaleTimeString("fr-FR", { hour: "2-digit", minute: "2-digit" });

const handleSendMessage = async () => {
  if (!page.props.auth.user) {
    router.visit(route("login"));
    return;
  }

  if (!inputValue.value.trim()) return;

  const userMessage = {
    id: Date.now().toString(),
    content: inputValue.value,
    sender: "user",
    timestamp: new Date(),
  };
  messages.value.push(userMessage);

  const currentInput = inputValue.value;
  inputValue.value = "";
  isTyping.value = true;

  const aiMessage = {
    id: (Date.now() + 1).toString(),
    content: "",
    sender: "ai",
    timestamp: new Date(),
  };
  messages.value.push(aiMessage);

  try {
    // First: check if the endpoint responds with JSON error
    const checkResponse = await fetch(
      route("chat.stream") + `?message=${encodeURIComponent(currentInput)}`
    );

    if (
      !checkResponse.ok ||
      checkResponse.headers.get("content-type")?.includes("application/json")
    ) {
      const errorData = await checkResponse.json().catch(() => null);
      toast.error(errorData?.message || "Something went wrong. Try again.");
      isTyping.value = false;
      return;
    }

    // If OK: switch to real stream (EventSource)
    const eventSource = new EventSource(
      route("chat.stream") + `?message=${encodeURIComponent(currentInput)}`
    );

    eventSource.onmessage = (event) => {
      if (event.data === "[DONE]") {
        isTyping.value = false;
        eventSource.close();
        return;
      }

      aiMessage.content += event.data;

      if (aiMessage.content.length < 5) {
        toast.warn(
          "Veuillez patienter, votre message est en cours de traitement",
          {
            autoClose: 3000,
            position: "top-right",
          }
        );
      }
    };

    eventSource.onerror = () => {
      toast.error("Stream interrupted. Please try again.");
      isTyping.value = false;
      eventSource.close();
    };
  } catch (err) {
    console.error(err);
    toast.error("Network error. Please try again.");
    isTyping.value = false;
  }
};

const handleKeyPress = (e) => {
  if (e.key === "Enter" && !e.shiftKey) {
    e.preventDefault();
    handleSendMessage();
  }
};

const formatMessageContent = (content) => {
  // Convert markdown to HTML
  return marked.parse(content);
};

watch(messages, () => scrollToBottom(), { deep: true });
watch(isTyping, () => {
  if (isTyping.value) scrollToBottom();
});
</script>
