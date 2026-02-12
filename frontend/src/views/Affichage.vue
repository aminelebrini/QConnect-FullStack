<template>
  <div class="min-h-screen flex bg-[#fdfdfd] font-['Plus_Jakarta_Sans']">
    
    <aside class="w-[280px] bg-white border-r border-slate-100 p-8 flex flex-col fixed h-full z-50">
      <a href="#" class="flex items-center gap-3 text-2xl font-extrabold text-[#0f172a] tracking-tight mb-12 ml-2">
          <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 text-white">
              {{ 'QConnect'.charAt(0) + 'QConnect'.charAt(1) }}
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
            <button @click="logout" class="text-slate-300 hover:text-red-500 transition-colors p-2">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
          </div>
      </div>
    </aside>

    <main class="flex-1 ml-[280px] bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:30px_30px]">
      <header class="sticky top-0 z-40 backdrop-blur-md px-[5%] py-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-[#0f172a] tracking-tight">Dashboard</h1>
      </header>

      <div class="max-w-[800px] mx-auto px-10 pt-10 pb-20">
        <transition name="fade-slide">
            <div v-if="isFormVisible" id="formModal" class="bg-white p-8 rounded-[32px] shadow-xl shadow-slate-200/40 border border-slate-50 mb-12 relative overflow-hidden">
                <button @click="isFormVisible = false" class="absolute top-6 right-6 text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-circle-xmark text-2xl"></i>
                </button>

                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-bold text-xl">QC</div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-[#0f172a] tracking-tight">{{ form.id ? 'Modifier la question' : 'Question à poser' }}</h1>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Partagez votre curiosité</p>
                    </div>
                </div>

                <form @submit.prevent="submitQuestion" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-extrabold text-[#0f172a] uppercase tracking-wide text-[11px]">Titre</label>
                            <input v-model="form.titre" type="text" placeholder="Ex : 1337" class="input-field">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-extrabold text-[#0f172a] uppercase tracking-wide text-[11px]">Ville</label>
                            <input v-model="form.city" type="text" placeholder="Ex : Khouribga" class="input-field">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-extrabold text-[#0f172a] uppercase tracking-wide text-[11px]">Détails</label>
                        <textarea v-model="form.description" rows="3" class="input-field resize-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="isFormVisible = false" class="px-8 py-4 rounded-2xl font-extrabold text-slate-400 hover:bg-slate-50 transition-all">Annuler</button>
                        <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-extrabold shadow-lg shadow-indigo-100 hover:scale-[1.03] transition-all flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane text-xs"></i> {{ form.id ? 'Mettre à jour' : 'Publier' }}
                        </button>
                    </div>
                </form>
            </div>
        </transition>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <h2 class="text-2xl font-extrabold text-[#0f172a]">Flux de questions</h2>
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-magnifying-glass text-sm"></i></span>
                    <input type="text" v-model="searchQuery" placeholder="Rechercher une ville..." class="w-full pl-11 pr-5 py-3 bg-white border border-slate-100 rounded-2xl outline-none focus:border-indigo-500/20 shadow-sm font-medium text-sm">
                </div>
                <button @click="openCreateModal" class="w-full sm:w-auto bg-indigo-600 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-plus text-xs"></i> POSER UNE QUESTION
                </button>
            </div>
        </div>
      
        <div class="space-y-8">
          <div v-for="item in questions" :key="item.id" class="bg-white p-8 rounded-[32px] shadow-xl shadow-slate-200/40 border border-slate-50 transition-all hover:scale-[1.01]">
            
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-extrabold text-xl uppercase">
                  {{ item.user?.fullname?.charAt(0) || '?' }}
                </div>
                <div>
                  <h3 class="font-extrabold text-[#0f172a]">{{ item.user?.fullname || 'Anonyme' }}</h3>
                  <div class="flex items-center gap-2 text-xs font-bold text-indigo-500 uppercase tracking-wider">
                    <i class="fa-solid fa-location-dot"></i> {{ item.location }}
                  </div>
                </div>
                <div class="flex gap-2">
                    <button 
                        @click.prevent="toggleFavoris(item.id)" 
                        class="w-11 h-11 rounded-xl bg-slate-50 text-slate-300 transition-all flex items-center justify-center border border-slate-100 group hover:bg-amber-50 hover:border-amber-100 hover:text-amber-500 hover:scale-105 active:scale-95">
                       <i class="fa-solid fa-star text-slate-300 transition-all group-hover:text-amber-500 group-hover:scale-125"></i>
                    </button>
                </div>
              </div>
            </div>

            <h2 class="text-xl font-extrabold text-[#0f172a] mb-3 leading-tight">{{ item.titre }}</h2>
            <p class="text-slate-500 font-medium leading-relaxed mb-8 italic border-l-4 border-slate-100 pl-4">" {{ item.description }} "</p>

            <div class="pt-6 border-t border-slate-50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Réponses</p>
                
                <div v-if="item.reponses && item.reponses.length" class="space-y-4 mb-6">
                    <div v-for="rep in item.reponses" :key="rep.id" class="flex gap-3 items-start">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-[14px] font-bold text-slate-400 uppercase shrink-0">
                            {{ rep.user?.fullname?.charAt(0) || '?' }}
                        </div>
                        <div class="flex-1 bg-slate-50/50 p-3 rounded-2xl rounded-tl-none border border-slate-100">
                            <p class="text-[17px] font-bold text-indigo-600 mb-1">{{ rep.user?.fullname }}</p>
                            <p class="text-[14px] text-slate-600 font-medium">{{ rep.content }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="text-xs text-slate-400 italic mb-4">Aucune réponse pour le moment...</p>
                <div v-if="currentUser?.id !== item.user?.id" class="relative mt-6 flex items-center gap-3 group">
                    <div class="relative flex-1">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-comment-dots text-sm"></i>
                        </span>
        
                        <input 
                            type="text" 
                            v-model="formRes.content"
                            name="commentaire" 
                            id="commentaire" 
                            placeholder="Ajouter un commentaire..."
                            class="w-full pl-11 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-[20px] outline-none focus:bg-white focus:border-indigo-500/20 focus:ring-4 focus:ring-indigo-500/5 transition-all font-semibold text-sm text-slate-700 placeholder:text-slate-400">
                        
                        <input type="hidden" v-model="formRes.user_id" name="user_id" id="user_id" value="{{ item.user?.id }}">
                        <input type="hidden" v-model="formRes.question_id" name="question_id" id="question_id" value="{{ item.id }}">
                    </div>

                    <button 
                        @click="sendReponse(item.id)" 
                        class="bg-indigo-600 text-white h-[52px] px-6 rounded-[20px] font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:scale-[1.03] active:scale-[0.97] transition-all flex items-center gap-2 whitespace-nowrap text-xs uppercase tracking-wider"
                    >
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Répondre</span>
                    </button>
                </div>         
            </div>
          </div>
        </div>
        <!--222-->
        <div class="space-y-10 hidden">
            <h1 class="text-[30px]">Mes Favoris</h1>
            <div v-for="item in favoris" :key="item.id" 
                class="group bg-white p-8 rounded-[32px] shadow-xl shadow-slate-200/40 border border-slate-50 transition-all hover:scale-[1.01] relative overflow-hidden">
        
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-400 to-amber-200"></div>

                <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-extrabold text-xl uppercase border-2 border-white shadow-sm">
                        {{ item.question?.user?.fullname.charAt(0) || '?' }}
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#0f172a] tracking-tight">
                            {{ item.question?.user?.fullname || 'Anonyme' }}
                        </h3>
                        <div class="flex items-center gap-2 text-[10px] font-black text-amber-500 uppercase tracking-[1.5px]">
                            <i class="fa-solid fa-star"></i> ENREGISTRÉ
                        </div>
                    </div>
                </div>

                <button @click.prevent="toggleFavoris(item.question_id)" 
                    class="w-10 h-10 rounded-xl bg-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all flex items-center justify-center border border-slate-100 group/btn">
                    <i class="fa-solid fa-trash-can text-sm transition-transform group-hover/btn:rotate-12"></i>
                </button>
            </div>

            <div class="space-y-3 mb-8">
                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase">
                    <i class="fa-solid fa-location-dot text-indigo-400"></i> {{ item.question?.city || 'Local' }}
                </div>
                <h2 class="text-xl font-extrabold text-[#0f172a] leading-tight group-hover:text-indigo-600 transition-colors">
                    {{ item.question?.titre }}
                </h2>
                <p class="text-slate-500 font-medium leading-relaxed italic border-l-4 border-amber-100 pl-4 text-sm">
                    " {{ item.question?.description }} "
                </p>
            </div>

            <div class="pt-6 border-t border-slate-50 bg-slate-50/30 -mx-8 -mb-8 px-8 pb-8 rounded-b-[32px]">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Discussion</p>
                    <span v-if="item.question?.reponses?.length" class="bg-indigo-100 text-indigo-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                        {{ item.question.reponses.length }} RÉPONSES
                    </span>
                </div>
            
                <div v-if="item.question?.reponses && item.question.reponses.length" class="space-y-4">
                    <div v-for="rep in item.question.reponses" :key="rep.id" class="flex gap-3 items-start">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-[10px] font-bold text-slate-400 uppercase shrink-0 shadow-sm border border-slate-100">
                            {{ rep.user?.fullname?.charAt(0) || '?' }}
                        </div>
                        <div class="flex-1 bg-white p-3 rounded-2xl rounded-tl-none border border-slate-100 shadow-sm">
                            <p class="text-[11px] font-bold text-indigo-600 uppercase mb-1">{{ rep.user?.fullname }}</p>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ rep.content }}</p>
                        </div>
                    </div>
                </div>
            
                <div v-else class="flex flex-col items-center py-4 text-center">
                    <i class="fa-solid fa-comments text-slate-200 text-xl mb-1"></i>
                    <p class="text-[11px] text-slate-400 font-bold italic uppercase tracking-wider">Soyez le premier à répondre</p>
                </div>       
            </div>
        </div>
        </div>
        <!---222-->
      </div>
    </main>
  </div>
</template>


<script setup>
    import api from '@/services/api';
    
    import { ref , onMounted, reactive } from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';
    const router = useRouter();

    const questions = ref([]);
    const currentUser = ref(null);
    const isFormVisible = ref(false);

    const form = reactive({
        titre: '',
        city: '',
        description: ''
    });

    const formRes = reactive({
        content: '',
        question_id: ''
    });

    const favoris = ref([]);

    const getQuestions = async ()=>{

        try{
            const response = await api.get('/questions');
            questions.value = response.data.questions;
            console.log(questions.value);
        }catch(error){
            console.log("error de recuperation!", error);
        }
    }

    const getFavoris = async () =>{
        try{
            const response = await api.get('/get',{
                headers: {
                Authorization: `Bearer ${localStorage.getItem('auth_token')}`
            }
            });
            favoris.value = response.data.favoris;
            console.log(favoris.value);

        }catch(error)
        {
            console.log("error de recuperation!", error);
        }
    }
    const submitQuestion = async ()=>{

        if (!form.titre || !form.city) return alert("3emmer ga3 l-blasat a sidi!");

        try{
            const reponse = await api.post('/questions',form,{
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            
            console.log(localStorage.getItem('auth_token'));
            form.titre = "",
            form.city = "",
            form.description = ""
            isFormVisible.value = false;

            await getQuestions();


        }catch(error){
            console.log(error);
        }

    }
    
    const sendReponse = async (questionId) => {
    if(!formRes.content) return alert("Le message est obligatoire !");

        try {
            await api.post('/responses', {
                content: formRes.content,
                question_id: questionId,
                user_id: currentUser.id
            }, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('auth_token')}`
                }
            });

            formRes.content = "";
            await getQuestions();
        } catch (error) {
            console.log(error.response?.data || error);
        }
    }
    const openCreateModal = () => {
        isFormVisible.value = true;
    };

    const toggleFavoris = async (question_Id) =>{
        try{
            await api.post(
            '/send',
            { question_id: question_Id},
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('auth_token')}`
                }
            }
        );
            await getQuestions();
            console.log(currentUser.value.id);
        }catch(error)
        {
            console.log(error);
        }

    }
    onMounted(() => {

        getQuestions();
        getFavoris();

        const data = localStorage.getItem('user_data');

        if(data)
        {
            currentUser.value = JSON.parse(data);
        }
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

