<template>
  <Header />
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-emerald-50/30">
    <div class="container px-4 py-8 mx-auto">
      <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
          <div class="flex items-center justify-center gap-3 mb-4">
            <Users class="w-12 h-12 text-primary" />
            <h1 class="text-3xl font-bold font-heading text-foreground">
              Conversations avec les Avocats
            </h1>
          </div>
          <p class="max-w-2xl mx-auto text-muted-foreground">
            Consultez directement nos avocats experts pour des conseils
            juridiques personnalisés et confidentiels.
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[600px]">
          <!-- Conversations List -->
          <div class="flex flex-col bg-white border rounded-lg shadow lg:col-span-1">
            <div class="p-4 border-b">
              <h3 class="font-semibold">Mes Conversations</h3>
            </div>

            <div class="flex-1 overflow-y-auto">
              <div v-for="conv in conversations" :key="conv.id" @click="loadMessages(conv.id)"
                class="p-4 transition-colors border-b cursor-pointer hover:bg-slate-50"
                :class="selectedConversation === conv.id ? 'bg-slate-100' : ''">
                <div class="flex items-start gap-3">
                  <div class="relative">
                    <img :src="conv.lawyerAvatar" :alt="conv.lawyerName" class="object-cover w-10 h-10 rounded-full" />
                    <div class="absolute w-3 h-3 border-2 border-white rounded-full -bottom-1 -right-1"
                      :class="getStatusColor(conv.status)" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                      <h4 class="text-sm font-medium truncate">
                        {{ conv.lawyerName }}
                      </h4>
                      <span v-if="conv.unreadCount > 0"
                        class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ conv.unreadCount }}</span>
                    </div>
                    <p class="mb-1 text-xs text-muted-foreground">
                      {{ conv.lawyerSpecialty }}
                    </p>
                    <p class="text-xs truncate text-muted-foreground">
                      {{ conv.lastMessage }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Available Lawyers -->
              <div class="p-4 border-b">
                <h4 class="mb-3 text-sm font-medium">Avocats Disponibles</h4>
                <div class="space-y-3">
                  <div v-for="lawyer in availableLawyers" :key="lawyer.id" class="flex items-center gap-3">
                    <div class="relative">
                      <img :src="lawyer.profile" :alt="lawyer.user.name" class="w-8 h-8 rounded-full" />
                      <div class="absolute -bottom-1 -right-1 w-2.5 h-2.5 rounded-full border border-white"
                        :class="getStatusColor(lawyer.status)" />
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-medium truncate">
                        {{ lawyer.user.name }}
                      </p>
                      <p class="text-xs text-muted-foreground">
                        {{ lawyer.specialty }}
                      </p>
                    </div>
                    <button class="px-2 py-1 text-xs border rounded hover:bg-slate-50"
                      @click="startConversationWithLawyer(lawyer)">
                      Contacter
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Chat Area -->
          <div class="lg:col-span-2">
            <div v-if="selectedConversation" class="flex flex-col h-full bg-white border rounded-lg shadow">
              <!-- Chat Header -->
              <div class="flex items-center gap-3 p-4 border-b">
                <template v-if="
                  conversations.find((c) => c.id === selectedConversation)
                ">
                  <img :src="conversations.find((c) => c.id === selectedConversation)
                    .lawyerAvatar
                    " class="w-10 h-10 rounded-full" />
                  <div>
                    <h3 class="font-semibold">
                      {{
                        conversations.find((c) => c.id === selectedConversation)
                          .lawyerName
                      }}
                    </h3>
                    <p class="text-sm text-muted-foreground">
                      {{
                        conversations.find((c) => c.id === selectedConversation)
                          .lawyerSpecialty
                      }}
                      •
                      {{
                        getStatusText(
                          conversations.find(
                            (c) => c.id === selectedConversation
                          ).status
                        )
                      }}
                    </p>
                  </div>
                </template>
              </div>

              <!-- Messages -->
              <div class="flex-1 p-4 space-y-4 overflow-y-auto max-h-[450px]">
                <div v-for="message in conversationMessages[selectedConversation]" :key="message.id" class="flex gap-3"
                  :class="message.sender === 'user' ? 'justify-end' : 'justify-start'
                    ">
                  <template v-if="message.sender === 'lawyer'">
                    <img :src="conversations.find((c) => c.id === selectedConversation)
                      ?.lawyerAvatar
                      " class="w-8 h-8 rounded-full" />
                  </template>

                  <div class="max-w-[70%]  rounded-lg px-4 py-2" :class="message.sender === 'user'
                    ? 'bg-primary text-white'
                    : 'bg-slate-100'
                    ">
                    <p class="text-sm">{{ message.content }}</p>
                    <span class="block mt-1 text-xs opacity-70">
                      {{
                        new Date(message.timestamp).toLocaleTimeString("fr-FR", {
                          hour: "2-digit",
                      minute: "2-digit",
                      })
                      }}
                    </span>

                  </div>

                  <template v-if="message.sender === 'user'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-200">
                      <User class="w-4 h-4" />
                    </div>
                  </template>
                </div>
                <div ref="messagesEndRef"></div>
              </div>

              <!-- Input -->
              <div class="p-4 border-t">
                <div class="flex gap-2">
                  <input v-model="inputValue" @keypress="handleKeyPress" placeholder="Tapez votre message..."
                    class="flex-1 px-3 py-2 border rounded-md" />
                  <button @click="handleSendMessage" :disabled="!inputValue.trim()"
                    class="flex items-center justify-center w-10 h-10 text-white rounded-md bg-primary hover:bg-primary/90 disabled:opacity-50">
                    <Send class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>

            <div v-else class="flex items-center justify-center h-full bg-white border rounded-lg shadow">
              <div class="text-center">
                <MessageCircle class="w-12 h-12 mx-auto mb-4 text-muted-foreground" />
                <h3 class="mb-2 font-semibold">
                  Sélectionnez une conversation
                </h3>
                <p class="text-muted-foreground">
                  Choisissez une conversation existante ou contactez un avocat
                  disponible
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="mt-8 text-center">
          <p class="mb-4 text-muted-foreground">
            Besoin d'un conseil personnalisé ? Consultez nos experts.
          </p>
          <Link :href="route('lawyers')"
            class="inline-block px-4 py-2 text-white rounded-md bg-primary hover:bg-primary/90">
          Voir les Avocats Experts
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, nextTick } from "vue";
import { Send, User, MessageCircle, Users } from "lucide-vue-next";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import axios from "axios";

import Header from "@/Components/WebComponents/Header.vue";

// Props from Laravel
defineProps({
  availableLawyers: Array,
  conversations: Array,
});

// State
const selectedConversation = ref(null);
const conversationMessages = reactive({});
const messagesEndRef = ref(null);
const inputValue = ref("");

const page = usePage();

// Scroll to bottom helper
const scrollToBottom = () => {
  nextTick(() => {
    messagesEndRef.value?.scrollIntoView({ behavior: "smooth" });
  });
};

// Load messages using named route

const loadMessages = async (conversationId) => {
  selectedConversation.value = conversationId;

  try {
    const res = await fetch(route("conversations.show", conversationId), {
      headers: { Accept: "application/json" },
    });
    const data = await res.json();
    conversationMessages[conversationId] = data.map(msg => ({
      ...msg,
      timestamp: new Date(msg.timestamp),
    }));
    scrollToBottom();
  } catch (error) {
    console.error("Failed to load messages:", error);
  }
};

// Send a new message
const handleSendMessage = async () => {
  if (!inputValue.value.trim() || !selectedConversation.value) return;

  try {
    const { data } = await axios.post(
      route("messages.store", selectedConversation.value),
      { content: inputValue.value }
    );

    if (!conversationMessages[selectedConversation.value]) {
      conversationMessages[selectedConversation.value] = [];
    }
    conversationMessages[selectedConversation.value].push(data.message);

    
    inputValue.value = "";
    // Update conversation preview
    const idx = conversations.findIndex(
      (c) => c.id === selectedConversation.value
    );
    if (idx !== -1) {
      conversations[idx].lastMessage = data.message.content;
      conversations[idx].lastMessageTime = data.message.timestamp;
    }

    inputValue.value = "";
    scrollToBottom();
  } catch (error) {
    console.error("Message failed:", error.response?.data || error);
  }
};

// Press Enter to send
const handleKeyPress = (e) => {
  if (e.key === "Enter" && !e.shiftKey) {
    e.preventDefault();
    handleSendMessage();
  }
};

// Start a new conversation with a lawyer
const startConversationWithLawyer = (lawyer) => {
  if (!page.props.auth.user) {
    router.visit(route("login"));
    return;
  }
  const form = useForm(lawyer);
  form.post(route("conversations.store", lawyer.id), {
    onSuccess: () => {

      toast.success("Conversation started successfully", {
        autoClose: 3000,
        position: "top-right",
      });
      router.visit(route("conversations"))
    },
    onError: (errors) => console.error("Failed to start conversation:", errors),
  });
};

// Helpers for status colors / text
const getStatusColor = (status) => {
  switch (status) {
    case "online":
      return "bg-green-500";
    case "busy":
      return "bg-yellow-500";
    default:
      return "bg-gray-400";
  }
};

const getStatusText = (status) => {
  switch (status) {
    case "online":
      return "En ligne";
    case "busy":
      return "Occupé";
    default:
      return "Hors ligne";
  }
};
</script>
