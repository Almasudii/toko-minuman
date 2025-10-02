<template>
  <div class="home">
    <header class="home-header">
      <img 
        class="logo" 
        alt="Logo" 
        src="https://minuman.com/cdn/shop/products/3.Occasion_500x.jpg?v=1683005995"
      />
      <h1 class="title">Yang Cepat Mabuk Gausa Beli</h1>
      <p class="subtitle">
        21+
      </p>
    </header>
    <div class="home-content">
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
};
</script>

<style scoped>
.home {
  font-family: Arial, sans-serif;
  color: #333;
  text-align: center;
  padding: 20px;
}

.home-header {
  background-color: #000000;
  padding: 40px 20px;
  border-bottom: 2px solid #ddd;
}

.logo {
  width: 500px;
  margin-bottom: 20px;
}

.title {
  font-size: 2.5rem;
  margin: 10px 0;
}

.subtitle {
  font-size: 1.2rem;
  color: #666;
}

.home-content {
  margin: 40px auto;
  max-width: 800px;
}

.highlight {
  background: #fff3e0;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.highlight h2 {
  color: #d2691e;
}

.explore-btn {
  margin-top: 15px;
  padding: 10px 20px;
  background-color: #d2691e;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.explore-btn:hover {
  background-color: #a0522d;
}
</style>
