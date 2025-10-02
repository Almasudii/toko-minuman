<template>
    <div class="login-page">
      <div class="login-container">
        <!-- Header -->
        <div class="login-header">
          <h1>Selamat Datang 👋</h1>
          <p>Silakan login untuk melanjutkan</p>
        </div>
  
        <!-- Alert error -->
        <transition name="fade">
          <div v-if="errorMessage" class="alert-error">
            <span>{{ errorMessage }}</span>
            <button @click="errorMessage = ''" class="close-btn">✖</button>
          </div>
        </transition>
  
        <!-- Form -->
        <form @submit.prevent="handleLogin" class="login-form">
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
  
          <button type="submit" :disabled="loading" class="login-btn">
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
            <span>{{ loading ? 'Memproses...' : 'Login' }}</span>
          </button>
        </form>
  
        <!-- Footer -->
        <div class="login-footer">
          Belum punya akun?
          <router-link to="/register" class="register-link">
            Daftar sekarang
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
  
  const email = ref('')
  const password = ref('')
  const showPassword = ref(false)
  const loading = ref(false)
  const errorMessage = ref('')
  
  const togglePassword = () => {
    showPassword.value = !showPassword.value
  }
  
  const handleLogin = async () => {
    loading.value = true
    errorMessage.value = ''
    try {
      const response = await axios.post('http://localhost:8000/api/login', {
        email: email.value,
        password: password.value,
      })
      localStorage.setItem('token', response.data.token)
    localStorage.setItem('user_name', response.data.data.name)
      router.push('/dashboard')
      window.location.reload()
    } catch (error) {
      if (error.response) {
        errorMessage.value = error.response.data.message || 'Login gagal'
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
  .login-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #4f46e5, #2563eb);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  }
  
  /* Container */
  .login-container {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 32px;
    position: relative;
    overflow: hidden;
    animation: fadeIn 0.5s ease;
  }
  
  /* Header */
  .login-header {
    text-align: center;
    margin-bottom: 24px;
  }
  .login-header h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }
  .login-header p {
    color: #64748b;
    font-size: 14px;
  }
  
  /* Error Alert */
  .alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
    font-size: 14px;
    padding: 10px 14px;
    border-radius: 8px;
    margin-bottom: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .close-btn {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: #b91c1c;
  }
  
  /* Form */
  .login-form .form-group {
    margin-bottom: 18px;
  }
  .login-form label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
    font-weight: 500;
  }
  .login-form input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s ease;
  }
  .login-form input:focus {
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
  .login-btn {
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
  .login-btn:hover {
    background-color: #1d4ed8;
  }
  .login-btn:disabled {
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
  .login-footer {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #475569;
  }
  .register-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
  }
  .register-link:hover {
    text-decoration: underline;
  }
  
  /* Fade animation for alert */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  
  /* Animations */
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
  