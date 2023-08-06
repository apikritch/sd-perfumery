<template>
  <div class="container-lg body-2-section">
    <div class="row justify-content-center">
      <div class="col-3">
        <div class="sha_cate">
          <router-link to="/shop/women">
            <div class="text-under-category rounded shadow-sm">WOMEN'S</div>
          </router-link>
        </div>
      </div>
      <div class="col-3">
        <div class="sha_cate">
          <router-link to="/shop/men">
            <div class="text-under-category rounded shadow-sm">MEN'S</div>
          </router-link>
        </div>
      </div>
      <div class="col-3">
        <div class="sha_cate">
          <router-link to="/shop/unisex">
            <div class="text-under-category rounded shadow-sm">UNISEX</div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeBody2",
};
</script>

<style scoped>
.body-2-section .row {
  padding-top: 8rem;
  padding-bottom: 4rem;
  padding-left: 0rem;
  padding-right: 0rem;
}

.body-2-section .col-3 {
  padding-left: 1.75rem;
  padding-right: 1.75rem;
}

.body-2-section .col-3 img {
  object-fit: cover;
  width: 100%;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

.body-2-section .col-3 .text-under-category {
  text-align: center;
  background-color: #384648;
  color: #ffffff;
  font-size: 1.5rem;
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
}

.sha_cate:hover {
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
}

.body-2-section {
  display: none;
}

@media (min-width: 992px) {
  .body-2-section {
    display: block;
  }
}

@media (min-width: 1200px) {
  .body-2-section .row {
    padding-top: 8rem;
    padding-bottom: 4rem;
    padding-left: 5rem;
    padding-right: 5rem;
  }
}
</style>
