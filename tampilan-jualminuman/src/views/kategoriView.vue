<template>
  <div class="container">
    <h2 class="text-center bg-primary text-white p-3 rounded">Kategori Minuman</h2>

    <button class="btn btn-primary mb-3" @click="showAddModal = true">
      <i class="fas fa-plus"></i> Tambah Kategori
    </button>

    <table class="table table-striped table-hover table-bordered table-responsive">
      <thead class="thead-dark">
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
          <td>{{ kategori.nama_kategori }}</td>
          <td>{{ kategori.deskripsi }}</td>
          <td>
            <button class="btn btn-warning btn-sm me-2" @click="showEditModal = true; selectedKategori = kategori">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger btn-sm" @click="deleteKategori(kategori.id)">
              <i class="fas fa-trash"></i> Hapus
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Add Modal -->
    <div v-if="showAddModal" class="modal fade show" tabindex="-1" style="display: block;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center">Tambah Kategori</h5>
            <button type="button" class="btn-close" @click="showAddModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="addKategori">
              <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori:</label>
                <input type="text" class="form-control" id="nama_kategori" v-model="newKategori.nama_kategori" required />
                <div v-if="errors.nama_kategori" class="text-danger">{{ errors.nama_kategori[0] }}</div>
              </div>
              <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" v-model="newKategori.deskripsi"></textarea>
              </div>
              <button class="btn btn-success" type="submit">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div v-if="showEditModal" class="modal fade show" tabindex="-1" style="display: block;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center">Edit Kategori</h5>
            <button type="button" class="btn-close" @click="showEditModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateKategori">
              <div class="mb-3">
                <label for="edit_nama_kategori" class="form-label">Nama Kategori:</label>
                <input
                  type="text"
                  class="form-control"
                  id="edit_nama_kategori"
                  v-model="selectedKategori.nama_kategori"
                  required
                />
                <div v-if="errors.nama_kategori" class="text-danger">{{ errors.nama_kategori[0] }}</div>
              </div>
              <div class="mb-3">
                <label for="edit_deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="edit_deskripsi" v-model="selectedKategori.deskripsi"></textarea>
              </div>
              <button class="btn btn-success" type="submit">Update</button>
            </form>
          </div>
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
      selectedKategori: {
        id: null,
        nama_kategori: "",
        deskripsi: "",
      },
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
        .then((response) => {
          this.kategoriMinuman = response.data;
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    },
    addKategori() {
      axios
        .post("http://127.0.0.1:8000/api/kategori-minuman", this.newKategori)
        .then((response) => {
          this.kategoriMinuman.push(response.data.data);
          this.showAddModal = false;
          this.newKategori = { nama_kategori: "", deskripsi: "" };
          this.errors = {}; // Clear errors
        })
        .catch((error) => {
          if (error.response.status === 400) {
            this.errors = error.response.data.errors;
          } else {
            console.error("Error adding kategori:", error);
          }
        });
    },
    updateKategori() {
      axios
        .put(
          `http://127.0.0.1:8000/api/kategori-minuman/${this.selectedKategori.id}`,
          this.selectedKategori
        )
        .then((response) => {
          const index = this.kategoriMinuman.findIndex(
            (k) => k.id === this.selectedKategori.id
          );
          if (index !== -1) {
            this.kategoriMinuman.splice(index, 1, response.data.data);
          }
          this.showEditModal = false;
          this.errors = {}; // Clear errors
        })
        .catch((error) => {
          if (error.response.status === 400) {
            this.errors = error.response.data.errors;
          } else {
            console.error("Error updating kategori:", error);
          }
        });
    },
    deleteKategori(id) {
      if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
        axios
          .delete(`http://127.0.0.1:8000/api/kategori-minuman/${id}`)
          .then(() => {
            this.kategoriMinuman = this.kategoriMinuman.filter(
              (k) => k.id !== id
            );
          })
          .catch((error) => {
            console.error("Error deleting kategori:", error);
          });
      }
    },
  },
};
</script>

<style scoped>
.container {
  margin-top: 30px;
  font-family: "Roboto", sans-serif;
}

.modal-content {
  border-radius: 10px;
  padding: 20px;
}

.btn {
  font-size: 14px;
  font-weight: 500;
}

table th,
table td {
  text-align: center;
  vertical-align: middle;
}

.modal-header {
  background: #007bff;
  color: white;
}

.form-label {
  font-weight: bold;
}

.text-danger {
  font-size: 12px;
}
</style>
