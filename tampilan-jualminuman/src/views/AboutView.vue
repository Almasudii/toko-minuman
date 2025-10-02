<template>
  <div class="about container py-5">
    <!-- Hero Section -->
    <section class="text-center mb-5">
      <h1 class="display-4 fw-bold text-primary">Tentang Kami</h1>
      <p class="lead text-muted">
      </p>
    </section>

    <!-- Content Section -->
    <section class="row align-items-center">
      <div class="col-md-6">
        <h2 class="fw-bold">Siapa Kami?</h2>
        <p>
          Kami adalah penyedia minuman keras premium yang berdedikasi untuk menghadirkan produk terbaik dari seluruh dunia. 
          Dengan beragam pilihan mulai dari anggur, wiski, hingga koktail eksklusif, kami memastikan setiap pelanggan mendapatkan 
          pengalaman yang memuaskan.
        </p>
        <ul class="list-unstyled">
          <li>
            <i class="bi bi-check-circle text-success me-2"></i> Produk asli berkualitas tinggi
          </li>
          <li>
            <i class="bi bi-check-circle text-success me-2"></i> Pelayanan pelanggan yang ramah
          </li>
          <li>
            <i class="bi bi-check-circle text-success me-2"></i> Pengiriman cepat dan aman
          </li>
        </ul>
      </div>
      <div class="col-md-6">
        <img
          src="https://minuman.com/cdn/shop/products/JOHNNIE-WALKER-RED-LABEL_500x.jpg?v=1683005995"
          alt="Minuman Keras Premium"
          class="img-fluid rounded shadow"
        />
      </div>
    </section>

    <!-- Our Values Section -->
    <section class="mt-5 text-center">
      <h2 class="fw-bold text-primary">Nilai Kami</h2>
      <p class="text-muted">
        Kami percaya bahwa setiap tegukan minuman adalah seni. Itulah sebabnya kami berkomitmen untuk menghadirkan:
      </p>
      <div class="row">
        <div class="col-md-4">
          <div class="p-4 bg-light rounded shadow-sm">
            <i class="bi bi-stars text-warning display-4 mb-3"></i>
            <h5 class="fw-bold">Kualitas Premium</h5>
            <p>Setiap produk dipilih dengan cermat untuk menjamin kepuasan pelanggan.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 bg-light rounded shadow-sm">
            <i class="bi bi-heart-fill text-danger display-4 mb-3"></i>
            <h5 class="fw-bold">Pelayanan Ramah</h5>
            <p>Tim kami selalu siap membantu Anda dalam memilih produk terbaik.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 bg-light rounded shadow-sm">
            <i class="bi bi-box-seam text-primary display-4 mb-3"></i>
            <h5 class="fw-bold">Pengiriman Aman</h5>
            <p>Kami memastikan produk Anda tiba dalam kondisi terbaik.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="text-center mt-5">
      <h3 class="fw-bold text-primary">Siap Mencoba?</h3>
      <p>
        Temukan koleksi minuman keras kami dan nikmati pengalaman premium hanya dengan beberapa klik.
      </p>
      <a href="/products" class="btn btn-primary btn-lg">
        Jelajahi Produk
      </a>
    </section>
  </div>
</template>

<script>
export default {
  name: "AboutView",
};
</script>

<style scoped>
.about {
  background-color: #f8f9fa;
  min-height: 100vh;
}

h1,
h2,
h3 {
  color: #2c3e50;
}

.list-unstyled li {
  font-size: 1.1rem;
}
</style>
