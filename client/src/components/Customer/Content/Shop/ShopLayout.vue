<template>
  <div>
    <div class="search-bar-section">
      <div class="container-lg h-100">
        <div class="row h-100 align-items-center">
          <div class="col-3">
            <router-link to="/" class="d-flex align-items-center">
              <div class="logo-circle me-3"></div>
              Sd Perfumery</router-link
            >
          </div>
          <div class="col-9">
            <input
              type="text"
              class="form-control search-bar-form-nav"
              placeholder="Search"
              v-model="search"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="container-lg shop-layout">
      <div class="shop-breadcrum d-flex">
        <div>Home</div>
        <div class="mx-3">/</div>
        <div>{{ $route.name }}</div>
      </div>
      <div class="row">
        <router-view
          :changeValuePrice="changeValuePrice"
          :changeValueSize="changeValueSize"
          :changeValueGender="changeValueGender"
          :changeValueType="changeValueType"
          :changeValueBrand="changeValueBrand"
        ></router-view>
        <router-view
          name="shop_content"
          :products="products"
          :addItemToCart="addItemToCart"
          :valueSliderPrice="valueSliderPrice"
          :valueSliderSize="valueSliderSize"
          :valueGender="valueGender"
          :valueType="valueType"
          :valueBrand="valueBrand"
          :changeValueGender="changeValueGender"
        ></router-view>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ShopLayout",
  props: [
    "products",
    "addItemToCart",
    "changeValuePrice",
    "valueSliderPrice",
    "changeValueSize",
    "valueSliderSize",
    "changeValueGender",
    "valueGender",
    "changeValueType",
    "valueType",
    "changeValueBrand",
    "valueBrand",
  ],
  data() {
    return {
      search: "",
    };
  },
  watch: {
    search() {
      const route = {
        name: this.$route.name,
      };
      if (this.search !== "") {
        route.query = {
          search: this.search,
        };
      }
      this.$router.push(route);
    },
    "$route.query.search": {
      immediate: true,
      handler(value) {
        this.search = value;
      },
    },
  },
};
</script>

<style scoped>
.shop-layout .shop-breadcrum {
  padding-top: 1.25rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648 !important;
  font-weight: 500;
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
}

.search-bar-section {
  background-color: #fff9fb;
  height: 100px;
}

.logo-circle {
  width: 50px;
  height: 50px;
  background-color: #ffffff;
  border-radius: 50%;
  border: 2px solid #384648;
}

.search-bar-form-nav {
  border-radius: 1.5rem;
  border: 1px solid #384648;
}
</style>
