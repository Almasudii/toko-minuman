<template>
    <div class="container mt-5">
      <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white text-center">
          <h1 class="mb-0">Daftar Minuman</h1>
        </div>
        <div class="card-body">
          <!-- Form Penambahan Produk -->
          <form @submit.prevent="createProduct" class="mb-4">
            <div class="input-group">
              <input
                type="text"
                id="product_name"
                v-model="newProduct.product_name"
                class="form-control rounded-start"
                placeholder="Masukkan nama minuman..."
                required
              />
              <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah
              </button>
            </div>
          </form>
  
          <!-- Tabel Produk -->
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
              <thead class="table-primary">
                <tr>
                  <th scope="col" class="text-center">#</th>
                  <th scope="col">Nama Minuman</th>
                  <th scope="col" class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products" :key="product.id">
                  <td class="text-center">{{ product.id }}</td>
                  <td>{{ product.product_name }}</td>
                  <td class="text-end">
                    <button
                      @click="editProduct(product)"
                      class="btn btn-warning btn-sm me-1"
                    >
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button
                      @click="deleteProduct(product.id)"
                      class="btn btn-danger btn-sm"
                    >
                      <i class="bi bi-trash3"></i> Hapus
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  
      <!-- Modal Edit -->
      <div
        class="modal fade"
        :class="{ show: showEditModal }"
        id="editModal"
        tabindex="-1"
        :style="{ display: showEditModal ? 'block' : 'none' }"
        aria-labelledby="editModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit Minuman</h5>
              <button
                type="button"
                class="btn-close"
                @click="closeEditModal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="updateProduct">
                <div class="mb-3">
                  <label for="edit_product_name" class="form-label"
                    >Nama Minuman:</label
                  >
                  <input
                    type="text"
                    id="edit_product_name"
                    v-model="editProductData.product_name"
                    class="form-control"
                  />
                </div>
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-save"></i> Simpan Perubahan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div
        class="modal-backdrop fade"
        :class="{ show: showEditModal }"
        v-if="showEditModal"
        @click="closeEditModal"
      ></div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import "bootstrap-icons/font/bootstrap-icons.css";
  
  export default {
    data() {
      return {
        products: [],
        newProduct: {
          product_name: "",
        },
        editProductData: {
          id: null,
          product_name: "",
        },
        showEditModal: false,
      };
    },
    mounted() {
      this.fetchProducts();
    },
    methods: {
      fetchProducts() {
        axios
          .get("http://127.0.0.1:8000/api/products")
          .then((response) => {
            this.products = response.data;
          })
          .catch((error) => {
            console.error(error);
          });
      },
      createProduct() {
        axios
          .post("http://127.0.0.1:8000/api/products", this.newProduct)
          .then((response) => {
            this.products.push(response.data);
            this.newProduct.product_name = "";
          })
          .catch((error) => {
            console.error(error);
          });
      },
      editProduct(product) {
        this.editProductData.id = product.id;
        this.editProductData.product_name = product.product_name;
        this.showEditModal = true;
      },
      updateProduct() {
        axios
          .put(
            `http://127.0.0.1:8000/api/products/${this.editProductData.id}`,
            this.editProductData
          )
          .then((response) => {
            const index = this.products.findIndex(
              (p) => p.id === this.editProductData.id
            );
            if (index !== -1) {
              this.products.splice(index, 1, response.data);
            }
            this.closeEditModal();
          })
          .catch((error) => {
            console.error(error);
          });
      },
      deleteProduct(productId) {
        if (confirm("Apakah Anda yakin ingin menghapus minuman ini?")) {
          axios
            .delete(`http://127.0.0.1:8000/api/products/${productId}`)
            .then(() => {
              this.products = this.products.filter((p) => p.id !== productId);
            })
            .catch((error) => {
              console.error(error);
            });
        }
      },
      closeEditModal() {
        this.showEditModal = false;
        this.editProductData = {
          id: null,
          product_name: "",
        };
      },
    },
  };
  </script>
  
  <style scoped>
  .card-header {
    background: linear-gradient(45deg, #007bff, #00c6ff);
  }
  .table {
    font-size: 0.9rem;
  }
  </style>
  