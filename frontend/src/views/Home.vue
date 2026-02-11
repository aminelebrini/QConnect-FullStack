<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-400 via-pink-400 to-red-400">
    <div class="bg-white/30 backdrop-blur-xl p-10 rounded-3xl shadow-2xl w-96 border border-white/20">

      <h1 class="text-3xl font-bold text-center text-white mb-6">
        {{ isLogin ? "Login" : "Sign Up" }}
      </h1>

      <div v-if="!isLogin">
        <input v-model="full_name" placeholder="Full name" class="input"/>
        <input v-model="city" placeholder="City" class="input"/>
      </div>

      <input v-model="email" placeholder="Email" class="input"/>
      <input v-model="password" type="password" placeholder="Password" class="input"/>

      <button @click="submit"
        class="w-full py-3 mt-4 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold hover:scale-105 transition">
        {{ isLogin ? "Login" : "Register" }}
      </button>

      <p v-if="error" class="text-red-300 text-center mt-3">{{ error }}</p>

      <p class="text-white text-center mt-5 text-sm">
        <span v-if="isLogin">
          No account? 
          <a @click="isLogin=false" class="underline cursor-pointer">Sign up</a>
        </span>
        <span v-else>
          Already registered? 
          <a @click="isLogin=true" class="underline cursor-pointer">Login</a>
        </span>
      </p>

    </div>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: "Home",
  data() {
    return {
      isLogin: true,
      full_name: "",
      city: "",
      email: "",
      password: "",
      error: ""
    };
  },
  methods: {

    async submit() {
      this.error = "";
      this.isLoading = true;

      try {
        const response = await api.post('/login', {
          email: this.email,
          password: this.password
        });

        console.log("Success!", response.data);

        localStorage.setItem('user_data', JSON.stringify(response.data));

        if(response.data.role === 'admin')
        {
          this.$router.push('/Admindash')
        }else{
          this.$router.push('/Affichage')
        }

      } catch (err) {

        if (err.response && err.response.status === 401) {
          this.error = "Identifiant incorrect a sahbi!";
        } else if (err.response && err.response.status === 422) {
          this.error = "Dakchi li dkhlti ma m9adch.";
        } else {
          this.error = "Mochkil f serveur.";
        }

      } finally {
        this.isLoading = false;
      }
    }

  }

};
</script>

<style scoped>
.input {
  width: 100%;
  padding: 12px;
  margin-bottom: 16px;
  border-radius: 12px;
  background: rgba(255,255,255,0.2);
  border: 1px solid rgba(255,255,255,0.3);
  color: white;
  outline: none;
}
</style>
