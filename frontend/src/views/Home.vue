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

      <button @click.prevent="submit" :disabled="isLoading"
        class="w-full py-3 mt-4 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold hover:scale-105 transition disabled:opacity-50">
        {{ isLoading ? "Sabre..." : (isLogin ? "Login" : "Register") }}
      </button>

      <p v-if="error" class="text-red-300 text-center mt-3 font-semibold">{{ error }}</p>

      <p class="text-white text-center mt-5 text-sm">
        <span v-if="isLogin">
          No account? 
          <a @click="isLogin=false" class="underline cursor-pointer font-bold">Sign up</a>
        </span>
        <span v-else>
          Already registered? 
          <a @click="isLogin=true" class="underline cursor-pointer font-bold">Login</a>
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
      error: "",
      isLoading: false
    };
  },
  methods: {
    async submit() {
      this.error = "";
      this.isLoading = true;

      try {
        let response;

        if (this.isLogin) {
          response = await api.post('/login', {
            email: this.email,
            password: this.password
          });
        } else {
          response = await api.post('/register', {
            full_name: this.full_name,
            city: this.city,
            email: this.email,
            password: this.password
          });
        }

        console.log("Success!", response.data);

        if (response.data.token) {
          localStorage.setItem('auth_token', response.data.token);
        }

        console.log(localStorage.getItem('auth_token'));

        const userData = response.data.result || response.data.user || response.data;
        localStorage.setItem('user_data', JSON.stringify(userData));

        if (userData.role === 'admin') {
          this.$router.push('/Admindash');
        } else {
          this.$router.push('/Affichage');
        }

      } catch (err) {
        console.error("Erreur detaillée:", err);
        if (err.response) {
          if (err.response.status === 401) {
            this.error = "Email awla Password ghaltin!";
          } else if (err.response.status === 422) {
            this.error = "Dakchi li dkhlti ma m9adch (Email déjà utilisé?).";
          } else {
            this.error = "Mochkil f serveur (Erreur " + err.response.status + ")";
          }
        } else {
          this.error = "Mochkil f connexion m3a l-backend.";
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
.input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}
</style>