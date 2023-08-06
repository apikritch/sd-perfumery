<template>
  <div>
    <div class="search-bar-section">
      <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
          <div class="col-3 d-none d-md-block">
            <router-link
              to="/"
              class="d-flex align-items-center">
              <div class="logo-circle me-3"></div>
              Sd Perfumery</router-link
            >
          </div>
          <div class="col-12 col-sm-11 col-md-9">
            <input
              v-model="search"
              type="text"
              class="form-control search-bar-form-nav"
              placeholder="Search" />
          </div>
        </div>
      </div>
    </div>
    <div class="container shop-layout">
      <div class="shop-breadcrum d-flex">
        <div>Home</div>
        <div class="mx-3">/</div>
        <div>{{ camelCasedRoute }}</div>
      </div>
      <div class="row">
        <router-view
          :changeValuePrice="changeValuePrice"
          :changeValueSize="changeValueSize"
          :changeValueGender="changeValueGender"
          :changeValueType="changeValueType"
          :changeValueBrand="changeValueBrand"></router-view>
        <router-view
          name="shop_content"
          :products="products"
          :addItemToCart="addItemToCart"
          :valueSliderPrice="valueSliderPrice"
          :valueSliderSize="valueSliderSize"
          :valueGender="valueGender"
          :valueType="valueType"
          :valueBrand="valueBrand"
          :changeValueGender="changeValueGender"></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import camelCase from "camelcase";

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
  computed: {
    camelCasedRoute() {
      return camelCase(this.$route.name, { pascalCase: true });
    },
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

.container {
  max-width: 100%;
}

@media (min-width: 375px) {
}

@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }

  .shop-shop .page {
    width: 55%;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 720px;
  }
}

@media (min-width: 992px) {
  .container {
    max-width: 960px;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 1140px;
  }
}

@media (min-width: 1400px) {
  .container {
    max-width: 1320px;
  }
}
</style>
