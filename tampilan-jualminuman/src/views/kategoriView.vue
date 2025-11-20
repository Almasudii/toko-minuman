<template>
  <div class="kategori-wrapper">
    <!-- 🌄 Background Overlay -->
    <div class="bg-overlay"></div>

    <div class="kategori-container">
      <!-- Header Section -->
      <div class="header-card">
        <h1 class="title">🍹 Kategori Minuman</h1>
        <p class="subtitle">Kelola kategori minuman dengan gaya modern & elegan</p>
        <button class="btn btn-primary add-btn" @click="showAddModal = true">
          <i class="bi bi-plus-lg"></i> Tambah Kategori
        </button>
      </div>

      <!-- Table Section -->
      <div class="table-card shadow-lg">
        <table class="table modern-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="kategori in kategoriMinuman" :key="kategori.id">
              <td>{{ kategori.id }}</td>
              <td class="text-primary fw-bold">{{ kategori.nama_kategori }}</td>
              <td>{{ kategori.deskripsi || '-' }}</td>
              <td>
                <button
                  class="btn btn-warning btn-sm me-2"
                  @click="openEditModal(kategori)"
                >
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button
                  class="btn btn-danger btn-sm"
                  @click="deleteKategori(kategori.id)"
                >
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
            <tr v-if="kategoriMinuman.length === 0">
              <td colspan="4" class="text-center text-muted p-4">
                Tidak ada kategori ditemukan 😔
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Tambah -->
    <div v-if="showAddModal" class="custom-modal-overlay">
      <div class="custom-modal">
        <div class="modal-header">
          <h5>Tambah Kategori</h5>
          <button class="close-btn" @click="showAddModal = false">✕</button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="addKategori">
            <div class="mb-3">
              <label>Nama Kategori</label>
              <input
                type="text"
                class="form-control"
                v-model="newKategori.nama_kategori"
                required
              />
              <div v-if="errors.nama_kategori" class="text-danger small">
                {{ errors.nama_kategori[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label>Deskripsi</label>
              <textarea
                class="form-control"
                v-model="newKategori.deskripsi"
                rows="3"
              ></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showAddModal = false">Batal</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edit -->
    <div v-if="showEditModal" class="custom-modal-overlay">
      <div class="custom-modal">
        <div class="modal-header">
          <h5>Edit Kategori</h5>
          <button class="close-btn" @click="showEditModal = false">✕</button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="updateKategori">
            <div class="mb-3">
              <label>Nama Kategori</label>
              <input
                type="text"
                class="form-control"
                v-model="selectedKategori.nama_kategori"
                required
              />
            </div>
            <div class="mb-3">
              <label>Deskripsi</label>
              <textarea
                class="form-control"
                v-model="selectedKategori.deskripsi"
                rows="3"
              ></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showEditModal = false">Batal</button>
              <button type="submit" class="btn btn-success">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";

export default {
  data() {
    return {
      kategoriMinuman: [],
      showAddModal: false,
      showEditModal: false,
      newKategori: {
        nama_kategori: "",
        deskripsi: "",
      },
      selectedKategori: {},
      errors: {},
    };
  },
  mounted() {
    this.fetchKategoriMinuman();
  },
  methods: {
    fetchKategoriMinuman() {
      axios
        .get("http://127.0.0.1:8000/api/kategori-minuman")
        .then((res) => (this.kategoriMinuman = res.data))
        .catch((err) => console.error(err));
    },
    addKategori() {
      axios
        .post("http://127.0.0.1:8000/api/kategori-minuman", this.newKategori)
        .then((res) => {
          this.kategoriMinuman.push(res.data.data);
          this.newKategori = { nama_kategori: "", deskripsi: "" };
          this.errors = {};
          this.showAddModal = false;
        })
        .catch((err) => {
          if (err.response?.status === 400) this.errors = err.response.data.errors;
        });
    },
    openEditModal(kategori) {
      this.selectedKategori = { ...kategori };
      this.showEditModal = true;
    },
    updateKategori() {
      axios
        .put(
          `http://127.0.0.1:8000/api/kategori-minuman/${this.selectedKategori.id}`,
          this.selectedKategori
        )
        .then((res) => {
          const idx = this.kategoriMinuman.findIndex((k) => k.id === this.selectedKategori.id);
          if (idx !== -1) this.kategoriMinuman.splice(idx, 1, res.data.data);
          this.showEditModal = false;
        })
        .catch((err) => console.error(err));
    },
    deleteKategori(id) {
      if (confirm("Yakin ingin menghapus kategori ini?")) {
        axios.delete(`http://127.0.0.1:8000/api/kategori-minuman/${id}`).then(() => {
          this.kategoriMinuman = this.kategoriMinuman.filter((k) => k.id !== id);
        });
      }
    },
  },
};
</script>

<style scoped>
/* 🌄 Full Background */
.kategori-wrapper {
  position: relative;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 40px 20px;
  overflow: hidden;
}
.bg-overlay {
  background: url('https://images.unsplash.com/photo-1527168027773-0cc890c4f42d?auto=format&fit=crop&w=1600&q=80')
    center/cover no-repeat;
  filter: blur(8px) brightness(0.6);
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -2;
}
.kategori-container {
  width: 100%;
  max-width: 1000px;
  backdrop-filter: blur(8px);
  background: rgba(255, 255, 255, 0.85);
  border-radius: 16px;
  padding: 25px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

/* Header */
.header-card {
  background: linear-gradient(135deg, #007bff, #00c6ff);
  color: white;
  padding: 25px;
  border-radius: 14px;
  text-align: center;
  margin-bottom: 25px;
}
.header-card .title {
  font-size: 28px;
  font-weight: 700;
}
.header-card .subtitle {
  font-size: 14px;
  opacity: 0.9;
  margin-bottom: 10px;
}
.add-btn {
  background: white;
  color: #007bff;
  font-weight: 600;
  border-radius: 8px;
  transition: 0.3s;
}
.add-btn:hover {
  background: #f1f1f1;
}

/* Table */
.table-card {
  background: white;
  border-radius: 14px;
  padding: 15px;
}
.modern-table th {
  background-color: #f8f9fa;
  font-weight: 600;
}
.modern-table tr:hover {
  background-color: #f4f9ff;
  transition: 0.2s;
}

/* Modal */
.custom-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.custom-modal {
  background: white;
  border-radius: 14px;
  width: 400px;
  max-width: 90%;
  padding: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  animation: fadeIn 0.25s ease;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}
.close-btn {
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
}
.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 8px;
  margin-top: 10px;
}

@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
</style>
