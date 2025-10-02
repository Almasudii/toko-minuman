<template>
  <nav class="navbar">
    <ul>
      <!-- Jika belum login -->
      <template v-if="!isLoggedIn">
        <li>
          <router-link to="/" exact>Home</router-link>
        </li>
        <li>
          <router-link to="/about">About</router-link>
        </li>
        <li>
          <button @click="goToLogin" class="login-btn">Login</button>
        </li>
      </template>

      <!-- Jika sudah login -->
      <template v-else>
        <li>
          <router-link to="/dashboard">Minuman</router-link>
        </li>
        <li>
          <router-link to="/kategori">Kategori</router-link>
        </li>
        <li>
          <button @click="handleLogout" class="logout-btn">Logout</button>
        </li>
        <li class="user-greeting">
          Halo, <strong>{{ userName }}</strong>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isLoggedIn = ref(false)
const userName = ref('')

// 🟡 Ambil token & nama dari localStorage saat komponen dimuat
onMounted(() => {
  const token = localStorage.getItem('token')
  const name = localStorage.getItem('user_name')

  if (token && name) {
    isLoggedIn.value = true
    userName.value = name
  }
})

// 🔵 Fungsi ke halaman login
const goToLogin = () => {
  router.push('/login')
}

// 🔴 Fungsi logout
const handleLogout = async () => {
  try {
    const token = localStorage.getItem('token')
    await fetch('http://localhost:8000/api/logout', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
    })

    // Hapus data localStorage
    localStorage.removeItem('token')
    localStorage.removeItem('user_name')

    isLoggedIn.value = false
    userName.value = ''
    router.push('/')
  } catch (error) {
    console.error('Gagal logout:', error)
  }
}
</script>

<style scoped>
.navbar {
  background-color: #2c3e50;
  padding: 15px 0;
}

.navbar ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
}

.navbar li {
  display: inline;
}

.navbar a {
  font-weight: bold;
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.navbar a:hover {
  background-color: #3d597a;
}

.navbar a.router-link-exact-active {
  background-color: #020202;
}

/* Tombol Login */
.login-btn {
  background-color: #0d2eec;
  color: white;
  padding: 10px 15px;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.login-btn:hover {
  background-color: #2b47ff;
}

/* Tombol Logout */
.logout-btn {
  background-color: #e63946;
  color: white;
  padding: 10px 15px;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.logout-btn:hover {
  background-color: #c1121f;
}

/* Halo Nama */
.user-greeting {
  color: white;
  font-weight: bold;
}
</style>
