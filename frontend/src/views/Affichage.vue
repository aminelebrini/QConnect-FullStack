<template>
  <div class="min-h-screen flex bg-[#fdfdfd] font-['Plus_Jakarta_Sans']">
    
    <aside class="w-[280px] bg-white border-r border-slate-100 p-8 flex flex-col fixed h-full z-50">
  
    <a href="#" class="flex items-center gap-3 text-2xl font-extrabold text-[#0f172a] tracking-tight mb-12 ml-2">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-street-view text-white -rotate-12"></i>
        </div>
        QConnect
    </a>

    <nav class="flex-1 space-y-3">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[2px] mb-4 ml-4">Main Menu</p>
    
        <a href="#" class="flex items-center gap-4 px-5 py-4 bg-indigo-600 text-white font-bold rounded-[20px] shadow-xl shadow-indigo-100 transition-all hover:scale-[1.02]">
            <i class="fa-solid fa-house text-lg"></i> 
        <span>QUESTIONS</span>
        </a>

        <a href="#" class="flex items-center gap-4 px-5 py-4 text-slate-500 font-bold rounded-[20px] hover:bg-slate-50 transition-all group">
            <i class="fa-solid fa-star text-lg group-hover:text-amber-400"></i> 
            <span>FAVORIS</span>
        </a>
    </nav>

    <div class="pt-6 border-t border-slate-100">
        <div class="flex items-center gap-4 p-2 rounded-[24px] hover:bg-slate-50 transition-colors cursor-pointer">
      
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl border-2 border-white shadow-sm uppercase">
            {{ currentUser?.fullname?.charAt(0) || '?' }}
        </div>

        <div class="flex-1 min-w-0">
            <h2 class="text-sm font-extrabold text-[#0f172a] truncate uppercase tracking-tight">
                {{ currentUser?.fullname || 'Anonyme' }}
            </h2>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">En ligne</span>
        </div>
        </div>

            <button class="text-slate-300 hover:text-red-500 transition-colors p-2">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>

        </div>
    </div>

    </aside>

    <main class="ml-[280px] flex-1 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:30px_30px]">
      
      <header class="sticky top-0 z-40 backdrop-blur-md px-[5%] py-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-[#0f172a] tracking-tight">Dashboard</h1>
      </header>

      <div class="max-w-[800px] mx-auto px-10 pt-10 pb-20">
        
        <div class="bg-white p-8 rounded-[32px] shadow-xl shadow-slate-200/40 border border-slate-50 mb-12">
          <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
              <i class="fa-solid fa-pen-to-square text-xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-[#0f172a] tracking-tight">Question à poser</h1>
          </div>

          <form @submit.prevent="submitQuestion" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="titre" class="block text-sm font-extrabold text-[#0f172a] ml-1">Titre</label>
                <input v-model="form.titre" type="text" id="titre" placeholder="Ex : 1337" 
                  class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:border-indigo-500/20 focus:bg-white transition-all outline-none font-semibold">
              </div>
              <div class="space-y-2">
                <label for="city" class="block text-sm font-extrabold text-[#0f172a] ml-1">City</label>
                <input v-model="form.city" type="text" id="city" placeholder="Ex : Khouribga" 
                  class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:border-indigo-500/20 focus:bg-white transition-all outline-none font-semibold">
              </div>
            </div>
            <div class="space-y-2">
              <label for="description" class="block text-sm font-extrabold text-[#0f172a] ml-1">Description</label>
              <textarea v-model="form.description" id="description" rows="3" placeholder="Ex : l'emplacement de 1337 Khouribga" 
                class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:border-indigo-500/20 focus:bg-white transition-all outline-none font-medium resize-none"></textarea>
            </div>
            <div class="flex justify-end">
              <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-extrabold shadow-lg shadow-indigo-100 hover:scale-105 transition-all">
                Publier la question
              </button>
            </div>
          </form>
        </div>

        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-extrabold text-[#0f172a]">Flux de questions</h2>
            <input type="text" placeholder="Rechercher une ville..." class="px-5 py-3 bg-white border border-slate-100 rounded-2xl w-60 outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm font-medium">
        </div>
        
        <div class="space-y-6">
          <div v-for="item in questions" :key="item.id" class="bg-white p-8 rounded-[32px] shadow-xl shadow-slate-200/40 border border-slate-50 transition-all hover:scale-[1.01]">
            <div class="flex items-center gap-4 mb-6">
              <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-extrabold text-xl uppercase">
                {{ item.user?.fullname?.charAt(0) || '?' }}
              </div>
              <div>
                <h3 class="font-extrabold text-[#0f172a]">{{ item.user?.fullname || 'Anonyme' }}</h3>
                <div class="flex items-center gap-2 text-xs font-bold text-indigo-500 uppercase tracking-wider">
                  <i class="fa-solid fa-location-dot"></i> {{ item.city }}
                </div>
              </div>
            </div>
            <h2 class="text-xl font-extrabold text-[#0f172a] mb-3 leading-tight">{{ item.titre }}</h2>
            <p class="text-slate-500 font-medium leading-relaxed mb-6 italic">" {{ item.description }} "</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
    import api from '@/services/api';
    
    import { ref , onMounted, reactive } from 'vue';
    import axios from 'axios';

    const questions = ref([]);
    const currentUser = ref(null);

    const form = reactive({
        titre: '',
        city: '',
        description: ''
    });

    const getQuestions = async ()=>{

        try{
            const response = await api.get('/questions');
            questions.value = response.data.questions;
            console.log(questions.value);
        }catch(error){
            console.log("error de recuperation!", error);
        }
    }

    const submitQuestion = async ()=>{

        if (!form.titre || !form.city) return alert("3emmer ga3 l-blasat a sidi!");

        try{
            const reponse = await api.post('/questions',form);
            form.titre = "",
            form.city = "",
            form.description = ""

            await getQuestions();

        }catch(error){
            console.log(error);
        }

    }
    onMounted(() => {

        getQuestions();

        const data = localStorage.getItem('user_data');

        if(data)
        {
            currentUser.value = JSON.parse(data);
        }
    });


</script>
