<template>
    <div class="register-page">
      <div class="register-container">
        <!-- Header -->
        <div class="register-header">
          <h1>Buat Akun ✨</h1>
          <p>Silakan isi data untuk mendaftar</p>
        </div>
  
        <!-- Alert error -->
        <transition name="fade">
          <div v-if="errorMessage" class="alert-error">
            <span>{{ errorMessage }}</span>
            <button @click="errorMessage = ''" class="close-btn">✖</button>
          </div>
        </transition>
  
        <!-- Alert success -->
        <transition name="fade">
          <div v-if="successMessage" class="alert-success">
            <span>{{ successMessage }}</span>
            <button @click="successMessage = ''" class="close-btn">✖</button>
          </div>
        </transition>
  
        <!-- Form -->
        <form @submit.prevent="handleRegister" class="register-form">
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input
              type="text"
              v-model="name"
              required
              placeholder="Masukkan nama lengkap"
            />
          </div>
  
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              v-model="email"
              required
              placeholder="Masukkan email"
            />
          </div>
  
          <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="password"
                required
                placeholder="Masukkan password"
              />
              <button type="button" @click="togglePassword" class="eye-btn">
                <span v-if="showPassword">🙈</span>
                <span v-else>👁️</span>
              </button>
            </div>
          </div>
  
          <button type="submit" :disabled="loading" class="register-btn">
            <svg
              v-if="loading"
              class="spinner"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="spinner-circle"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="spinner-path"
                fill="currentColor"
                d="M4 12a8 8 0 018-8v8H4z"
              ></path>
            </svg>
            <span>{{ loading ? 'Memproses...' : 'Daftar' }}</span>
          </button>
        </form>
  
        <!-- Footer -->
        <div class="register-footer">
          Sudah punya akun?
          <router-link to="/login" class="login-link">
            Login di sini
          </router-link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  
  const name = ref('')
  const email = ref('')
  const password = ref('')
  const showPassword = ref(false)
  const loading = ref(false)
  const errorMessage = ref('')
  const successMessage = ref('')
  
  const togglePassword = () => {
    showPassword.value = !showPassword.value
  }
  
  const handleRegister = async () => {
    loading.value = true
    errorMessage.value = ''
    successMessage.value = ''
    try {
      const response = await axios.post('http://localhost:8000/api/register', {
        name: name.value,
        email: email.value,
        password: password.value,
      })
  
      successMessage.value = response.data.message
      // redirect ke login setelah sukses
      setTimeout(() => {
        router.push('/login')
      }, 2000)
    } catch (error) {
      if (error.response) {
        errorMessage.value = error.response.data.message || 'Registrasi gagal'
      } else {
        errorMessage.value = 'Terjadi kesalahan jaringan'
      }
    } finally {
      loading.value = false
    }
  }
  </script>
  
  <style scoped>
  /* Background */
  .register-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  }
  
  /* Container */
  .register-container {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 32px;
    animation: fadeIn 0.5s ease;
  }
  
  /* Header */
  .register-header {
    text-align: center;
    margin-bottom: 24px;
  }
  .register-header h1 {
    font-size: 26px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }
  .register-header p {
    color: #64748b;
    font-size: 14px;
  }
  
  /* Alerts */
  .alert-error,
  .alert-success {
    font-size: 14px;
    padding: 10px 14px;
    border-radius: 8px;
    margin-bottom: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
  }
  .alert-success {
    background-color: #dcfce7;
    color: #166534;
  }
  .close-btn {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
  }
  
  /* Form */
  .register-form .form-group {
    margin-bottom: 18px;
  }
  .register-form label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
    font-weight: 500;
  }
  .register-form input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s ease;
  }
  .register-form input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  }
  
  /* Password */
  .password-wrapper {
    position: relative;
  }
  .eye-btn {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
  }
  
  /* Button */
  .register-btn {
    width: 100%;
    background-color: #2563eb;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    padding: 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
  }
  .register-btn:hover {
    background-color: #1d4ed8;
  }
  .register-btn:disabled {
    background-color: #93c5fd;
    cursor: not-allowed;
  }
  
  /* Spinner */
  .spinner {
    animation: spin 1s linear infinite;
    height: 18px;
    width: 18px;
    margin-right: 8px;
  }
  .spinner-circle {
    opacity: 0.25;
  }
  .spinner-path {
    opacity: 0.75;
  }
  
  /* Footer */
  .register-footer {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #475569;
  }
  .login-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
  }
  .login-link:hover {
    text-decoration: underline;
  }
  
  /* Animations */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  
  @keyframes spin {
    100% {
      transform: rotate(360deg);
    }
  }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-15px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  </style>
  