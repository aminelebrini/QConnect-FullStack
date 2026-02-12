<template>
  <div class="min-h-screen flex bg-[#f8fafc] font-['Plus_Jakarta_Sans']">
    
    <aside class="w-[280px] bg-[#0f172a] p-8 flex flex-col fixed h-full z-50 text-white">
      <div class="flex items-center gap-3 text-2xl font-extrabold tracking-tight mb-12 ml-2">
          <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg text-white">
              AD
          </div>
          Admin Panel
      </div>

      <nav class="flex-1 space-y-2">
          <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mb-4 ml-4">Management</p>
          <router-link to="/admin" class="flex items-center gap-4 px-5 py-4 bg-indigo-500/10 text-indigo-400 font-bold rounded-2xl transition-all border border-indigo-500/20">
              <i class="fa-solid fa-chart-pie text-lg"></i> 
              <span>Statistiques</span>
          </router-link>
          <router-link to="/" class="flex items-center gap-4 px-5 py-4 text-slate-400 font-bold rounded-2xl hover:bg-slate-800 transition-all group">
              <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i> 
              <span>Retour au Site</span>
          </router-link>
      </nav>

      <div class="pt-6 border-t border-slate-800">
          <button @click="logout" class="w-full flex items-center gap-4 px-5 py-4 text-rose-400 font-bold rounded-2xl hover:bg-rose-500/10 transition-all">
              <i class="fa-solid fa-power-off"></i>
              <span>Déconnexion</span>
          </button>
      </div>
    </aside>

    <main class="flex-1 ml-[280px]">
      
      <header class="h-20 bg-white border-b border-slate-100 px-10 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-4 text-slate-400">
           <i class="fa-solid fa-magnifying-glass text-sm"></i>
           <input type="text" placeholder="Rechercher une question..." class="bg-transparent outline-none text-sm font-medium w-64">
        </div>
        
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-[20px] font-bold text-[#0f172a]">{{ currentUser?.fullname }}</p>
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Administrator</p>
            </div>
            <div class="w-10 h-10 bg-slate-100 rounded-xl text-[25px] flex items-center justify-center font-black text-indigo-600">
                {{ currentUser?.fullname?.charAt(0) }}
            </div>
        </div>
      </header>

      <div class="p-10 space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
          <div class="bg-indigo-600 p-8 rounded-[32px] shadow-xl shadow-indigo-100 flex items-center justify-between relative overflow-hidden group">
            <div class="relative z-10">
              <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest mb-1">Total Questions</p>
              <h3 class="text-4xl font-black">{{ stats.total_questions }}</h3>
            </div>
            <i class="fa-solid fa-clipboard-question text-6xl text-indigo-500/50 absolute -right-4 -bottom-4 rotate-12 group-hover:rotate-0 transition-transform duration-500"></i>
          </div>

          <div class="bg-emerald-600 p-8 rounded-[32px] shadow-xl shadow-emerald-100 flex items-center justify-between relative overflow-hidden group">
            <div class="relative z-10">
              <p class="text-emerald-100 text-xs font-bold uppercase tracking-widest mb-1">Total Réponses</p>
              <h3 class="text-4xl font-black">{{ stats.total_reponses }}</h3>
            </div>
            <i class="fa-solid fa-comments text-6xl text-emerald-500/50 absolute -right-4 -bottom-4 rotate-12 group-hover:rotate-0 transition-transform duration-500"></i>
          </div>

          <div class="bg-amber-500 p-8 rounded-[32px] shadow-xl shadow-amber-100 flex items-center justify-between relative overflow-hidden group">
            <div class="relative z-10">
              <p class="text-amber-50 text-xs font-bold uppercase tracking-widest mb-1">Total Users</p>
              <h3 class="text-4xl font-black">{{ stats.total_users }}</h3>
            </div>
            <i class="fa-solid fa-city text-6xl text-amber-400/50 absolute -right-4 -bottom-4 rotate-12 group-hover:rotate-0 transition-transform duration-500"></i>
          </div>
        </div>

        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
          <div class="p-8 flex justify-between items-center">
            <div>
              <h2 class="text-2xl font-black text-[#0f172a]">Gestion des Données</h2>
              <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Supervision globale du flux</p>
            </div>
            <button @click="getAdminStats" class="flex items-center gap-2 px-6 py-3 bg-slate-50 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all">
                <i class="fa-solid fa-rotate text-xs"></i> Actualiser
            </button>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr class="bg-slate-50/50">
                  <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Auteur</th>
                  <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Contenu Question</th>
                  <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ville</th>
                  <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Engagement</th>
                  <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                <tr v-for="q in questions" :key="q.id" class="hover:bg-slate-50/50 transition-all group">
                  <td class="px-8 py-6">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-sm">
                        {{ q.user?.fullname?.charAt(0) }}
                      </div>
                      <span class="font-bold text-slate-700">{{ q.user?.fullname }}</span>
                    </div>
                  </td>
                  <td class="px-8 py-6">
                    <p class="font-bold text-[#0f172a] text-sm truncate max-w-[200px]">{{ q.titre }}</p>
                    <p class="text-xs text-slate-400 truncate max-w-[200px]">{{ q.description }}</p>
                  </td>
                  <td class="px-8 py-6">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-500 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                      {{ q.city || q.location }}
                    </span>
                  </td>
                  <td class="px-8 py-6 text-center">
                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-black">
                        {{ q.reponses?.length || 0 }} Rép
                    </span>
                  </td>
                  <td class="px-8 py-6 text-right">
                    <button @click="deleteQuestion(q.id)" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-300 hover:bg-rose-500 hover:text-white transition-all">
                      <i class="fa-solid fa-trash-can text-sm"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import api from '@/services/api';
import { useRouter } from 'vue-router';
const router = useRouter();

const questions = ref([]);
const stats = reactive({
    total_questions: 0,
    total_reponses: 0,
    total_villes: 0
});
const currentUser = ref(null);

const getAdminStats = async () => {
    try {
        const response = await api.get('/Admin', {
            headers: { Authorization: `Bearer ${localStorage.getItem('auth_token')}` }
        });
        
        questions.value = response.data.questions;
        stats.total_questions = response.data.questionstot;
        stats.total_reponses = response.data.reponses; 
        stats.total_users = response.data.users;     
    } catch (error) {
        console.error("Erreur Admin:", error);
    }
};
onMounted(() => {
    const data = localStorage.getItem('user_data');

    if(data)
    {
        currentUser.value = JSON.parse(data);
    }

     getAdminStats();
});

const logout = async () => {
    try {
        await api.post('/logout', {}, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('auth_token')}`
            }
        });
    } catch (error) {
        console.error("Erreur Backend Logout:", error);
    } finally {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_data');

        router.push('/');
    }
};
</script>