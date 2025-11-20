<template>
  <div class="container">
    <h1 class="title">🥂 Dashboard Minuman</h1>

    <!-- ✅ Form Create / Edit -->
    <form @submit.prevent="handleSubmit" class="form-box">
      <div class="form-grid">
        <div class="form-group">
          <label>Nama Minuman</label>
          <input v-model="form.nama" type="text" class="input" required />
        </div>

        <div class="form-group">
          <label>Stok</label>
          <input v-model="form.stok" type="number" min="0" class="input" required />
        </div>

        <div class="form-group">
          <label>Kategori</label>
          <select v-model="form.kategori_id" class="input" required>
            <option disabled value="">-- Pilih Kategori --</option>
            <option v-for="kat in kategoriList" :key="kat.id" :value="kat.id">
              {{ kat.nama_kategori }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <label>Gambar</label>
          <input type="file" @change="handleFileUpload" ref="fileInput" />
        </div>
      </div>

      <div class="form-buttons">
        <button type="submit" class="btn btn-green">
          {{ editingId ? 'Update' : 'Tambah' }} Minuman
        </button>
        <button
          v-if="editingId"
          @click="resetForm"
          type="button"
          class="btn btn-gray"
        >
          Batal
        </button>
      </div>
    </form>

    <!-- ✅ List Data -->
    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Stok</th>
          <th>Kategori</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="m in minumanList" :key="m.id">
          <td>{{ m.id }}</td>
          <td>{{ m.nama }}</td>
          <td>{{ m.stok }}</td>
          <td>{{ m.kategori?.nama_kategori }}</td>
          <td>
            <img
              v-if="m.gambar"
              :src="`${API_URL.replace('/api','')}/storage/${m.gambar}`"
              alt="gambar"
              class="thumb"
            />
          </td>
          <td>
            <button @click="editMinuman(m)" class="btn btn-yellow">Edit</button>
            <button @click="deleteMinuman(m.id)" class="btn btn-red">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const API_URL = 'http://localhost:8000/api'

const minumanList = ref([])
const kategoriList = ref([])
const editingId = ref(null)
const fileInput = ref(null)

const form = ref({
  nama: '',
  stok: '',
  kategori_id: '',
  gambar: null,
})

onMounted(() => {
  fetchMinuman()
  fetchKategori()
})

function fetchMinuman() {
  fetch(`${API_URL}/minuman`)
    .then(res => res.json())
    .then(data => (minumanList.value = data))
}

function fetchKategori() {
  fetch(`${API_URL}/kategori-minuman`)
    .then(res => res.json())
    .then(data => (kategoriList.value = data))
}

function handleFileUpload(e) {
  form.value.gambar = e.target.files[0]
}

function handleSubmit() {
  const stok = Number(form.value.stok)

  // 🚫 Validasi stok minimal
  if (stok <= 0) {
    alert('Minimal stok 1')
    return
  }

  // 🚫 Validasi stok maksimal
  if (stok > 1000) {
    alert('Stok maksimal 1000')
    return
  }

  const formData = new FormData()
  formData.append('nama', form.value.nama)
  formData.append('stok', form.value.stok)
  formData.append('kategori_id', form.value.kategori_id)
  if (form.value.gambar) {
    formData.append('gambar', form.value.gambar)
  }

  const method = editingId.value ? 'POST' : 'POST'
  const url = editingId.value
    ? `${API_URL}/minuman/${editingId.value}?_method=PUT`
    : `${API_URL}/minuman`

  fetch(url, { method, body: formData })
    .then(async res => {
      if (!res.ok) {
        const data = await res.json()
        alert(data.message || 'Terjadi kesalahan')
        throw new Error(data.message)
      }
      return res.json()
    })
    .then(() => {
      fetchMinuman()
      resetForm()
      if (editingId.value) {
        alert('Minuman berhasil diperbarui')
      } else {
        alert('Minuman berhasil ditambahkan')
      }
    })
    .catch(err => console.error(err))
}

function editMinuman(m) {
  editingId.value = m.id
  form.value.nama = m.nama
  form.value.stok = m.stok
  form.value.kategori_id = m.kategori_id
  form.value.gambar = null
}

function resetForm() {
  editingId.value = null
  form.value = { nama: '', stok: '', kategori_id: '', gambar: null }
  if (fileInput.value) fileInput.value.value = ''
}

function deleteMinuman(id) {
  if (confirm('Yakin ingin menghapus?')) {
    fetch(`${API_URL}/minuman/${id}`, { method: 'DELETE' }).then(() =>
      fetchMinuman()
    )
  }
}
</script>

<style scoped>
/* 🌿 Layout dasar */
.container {
  max-width: 900px;
  margin: 30px auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

/* 📝 Form */
.form-box {
  background: #f5f5f5;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 25px;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: bold;
}

.input {
  padding: 8px;
  border: 1px solid #0571ff;
  border-radius: 4px;
}

.form-buttons {
  margin-top: 15px;
}

/* 🧭 Tombol */
.btn {
  padding: 8px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 5px;
  font-size: 14px;
}

.btn-green {
  background-color: #008cff;
  color: white;
}

.btn-gray {
  background-color: #6c757d;
  color: white;
}

.btn-yellow {
  background-color: #07a4ff;
  color: black;
}

.btn-red {
  background-color: #dc3545;
  color: white;
}

.btn:hover {
  opacity: 0.85;
}

/* 📊 Tabel */
.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table th,
.data-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.data-table th {
  background-color: #008cff;
  font-weight: bold;
  color: white;
}

.data-table tr:hover {
  background-color: #ffffff;
}

.thumb {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 4px;
  border: 1px solid #000000;
}
</style>
