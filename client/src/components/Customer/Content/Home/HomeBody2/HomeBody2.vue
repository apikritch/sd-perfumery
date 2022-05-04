<template>
  <div class="container-lg body-2-section">
    <div class="row justify-content-center">
      <div class="col-3">
        <div class="sha_cate">
          <router-link to="/shop/women">
            <img
              src="https://d3r2zleywq7959.cloudfront.net/media/catalog/product/cache/1/image/675x/9df78eab33525d08d6e5fb8d27136e95/6/4/64818_xlarge.jpg"
            />
            <div class="text-under-category">WOMEN'S</div>
          </router-link>
        </div>
      </div>
      <div class="col-3">
        <div class="sha_cate">
          <router-link to="/shop/men">
            <img
              src="https://d3r2zleywq7959.cloudfront.net/media/catalog/product/cache/1/image/675x/9df78eab33525d08d6e5fb8d27136e95/6/4/64816_xlarge.jpg"
            />
            <div class="text-under-category">MEN'S</div>
          </router-link>
        </div>
      </div>
      <div class="col-3">
        <div class="sha_cate">
          <router-link to="/shop/unisex">
            <img
              src="https://d3r2zleywq7959.cloudfront.net/media/catalog/product/cache/1/image/675x/9df78eab33525d08d6e5fb8d27136e95/1/6/16728_xlarge.jpg"
            />
            <div class="text-under-category">UNISEX</div>
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
  padding-left: 5rem;
  padding-right: 5rem;
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
</style>
