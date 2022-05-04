<template>
  <div class="col-9 shop-shop col-9-self">
    <div
      v-if="loading || loading_2"
      class="d-flex align-items-center justify-content-center cover_loader "
    >
      <MoonLoader color="#985855" />
    </div>

    <div v-if="!loading && !loading_2">
      <div
        class="shop-d-flex d-flex justify-content-between align-items-center"
      >
        <h1 class="shop-header">{{ $route.name }}</h1>
        <div>
          <b-form-select
            v-model="selected"
            :options="options"
            class="sort-by-select"
            @change="changeSort(selected)"
          ></b-form-select>
        </div>
      </div>
      <!--Pagination-->
      <div
        class="row align-items-center product-padding-search-bar justify-content-between"
      >
        <div class="col-4">{{ found_product }} ITEMS FOUND</div>
        <div class="col-4 ms-auto">
          <div class="row align-items-center">
            <div class="col-5 per-page">
              <div class="d-flex justify-content-between align-items-center">
                <b-form-select
                  v-model="per_page"
                  :options="per_page_options"
                  class="product-select-form-per-page"
                ></b-form-select>
                per page
              </div>
            </div>
            <div class="col-7 page">
              <div class="d-flex justify-content-between align-items-center">
                <div
                  class="page-button d-flex align-items-center justify-content-center"
                  @click="previousPage"
                >
                  <font-awesome-icon icon="chevron-left" />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <input
                    type="number"
                    class="product-page-input"
                    v-model="current_page"
                  />
                  <div>of {{ all_pages }}</div>
                </div>
                <div
                  class="page-button d-flex align-items-center justify-content-center next-page"
                  @click="nextPage"
                >
                  <font-awesome-icon icon="chevron-right" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Pagination-->

      <!--Content-->
      <div
        v-if="loading"
        class="d-flex justify-content-center align-items-center loading-height"
      ></div>
      <div v-if="!loading">
        <div class="row">
          <div
            class="col-3 card-margin"
            v-for="(product, index) in pageAndFilter"
            :key="index"
          >
            <div class="shop-card-overflow">
              <!--Tag-->
              <div
                class="sold-out-tag d-flex align-items-center justify-content-center"
                v-if="product.stock <= 0"
              >
                Sold Out
              </div>
              <div
                class="percent-tag d-flex align-items-center justify-content-center"
                v-if="product.discount == '%' && product.stock > 0"
              >
                {{ product.discount_number }} % OFF
              </div>
              <div
                class="rs-tag d-flex align-items-center justify-content-center"
                v-if="product.discount == 'Rs.' && product.stock > 0"
              >
                SAVE Rs. {{ product.discount_number.toLocaleString() }}
              </div>
              <!--Tag-->

              <router-link
                :to="'/product/' + product.id"
                class="border shop-card-border d-flex align-items-start flex-column h-100"
              >
                <div
                  class="out-of-stock-filter"
                  v-if="product.stock <= 0"
                ></div>
                <img
                  :src="product.image"
                  width="100%"
                  class="shop-card-image b"
                />
                <h6 class="pt-1">
                  {{ product.title }} | {{ product.type }} |
                  {{ product.gender }} - {{ product.size }} ml
                </h6>
                <div class="mb-auto">by {{ product.brand }}</div>
                <!--Price-->
                <h5
                  class=" d-inline shop-card-price"
                  :class="product.discount == null ? null : 'line-through-sale'"
                  v-if="product.discount"
                >
                  Rs.
                  {{
                    product.price.toLocaleString(undefined, {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2,
                    })
                  }}
                </h5>
                <h5
                  class="d-inline shop-card-price"
                  :class="product.discount == null ? null : 'sale-show-text'"
                >
                  Rs.
                  {{
                    product.final_price.toLocaleString(undefined, {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2,
                    })
                  }}
                </h5>
                <!--Price-->
              </router-link>
              <div
                class="shop-hover-section"
                :class="product.stock <= 0 ? 'shop-hover-section-out' : null"
              >
                <div class="row h-100">
                  <div
                    class="d-flex justify-content-center align-items-center out-of-stock-field"
                    v-if="product.stock <= 0"
                  >
                    Out of Stock
                  </div>
                  <div class="col-6 h-100 ps-3" v-if="product.stock >= 1">
                    <div class="d-flex align-items-center h-100">
                      <div
                        class="circle-minus d-flex justify-content-between align-items-center"
                        @click="decreaseQty(product.quantity, index)"
                      >
                        <font-awesome-icon icon="minus" class="w-100" />
                      </div>
                      <div class="px-3 qty-text">
                        {{ product.quantity }}
                      </div>

                      <div
                        class="circle-plus d-flex justify-content-between align-items-center"
                        @click="increaseQty(product.quantity, index)"
                      >
                        <font-awesome-icon icon="plus" class="w-100" />
                      </div>
                    </div>
                  </div>
                  <div class="col-6 h-100 pe-3" v-if="product.stock >= 1">
                    <div
                      class="h-100 d-flex justify-content-end align-items-center"
                    >
                      <div
                        class="shop-add-button d-flex justify-content-end align-items-center"
                        @click="addItemToCart(product, product.quantity)"
                      >
                        <div class="add-button-text pe-1 d-inline">
                          ADD
                        </div>
                        <font-awesome-icon
                          icon="shopping-cart"
                          class="d-inline"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Content-->

      <!--Pagination-->
      <div class="row align-items-center product-padding-search-bar">
        <div class="col-4 ms-auto">
          <div class="row align-items-center">
            <div class="col-5 per-page">
              <div class="d-flex justify-content-between align-items-center">
                <b-form-select
                  v-model="per_page"
                  :options="per_page_options"
                  class="product-select-form-per-page"
                ></b-form-select>
                per page
              </div>
            </div>
            <div class="col-7 page">
              <div class="d-flex justify-content-between align-items-center">
                <div
                  class="page-button d-flex align-items-center justify-content-center"
                  @click="previousPage"
                >
                  <font-awesome-icon icon="chevron-left" />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <input
                    type="number"
                    class="product-page-input"
                    v-model="current_page"
                  />
                  <div>of {{ all_pages }}</div>
                </div>
                <div
                  class="page-button d-flex align-items-center justify-content-center next-page"
                  @click="nextPage"
                >
                  <font-awesome-icon icon="chevron-right" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Pagination-->
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getProducts } from "@/services/ProductService";
import { get20PerPageOptions } from "@/services/OptionService";

export default {
  name: "SHOP",
  props: {
    addItemToCart: Function,
    valueSliderPrice: Array,
    valueSliderSize: Array,
    valueGender: Array,
    valueType: Array,
    valueBrand: Array,
    changeValueGender: Function,
  },
  components: { MoonLoader },
  data() {
    return {
      selected: "id_asc",
      sortBy: "id",
      sortDirection: "asc",
      options: [
        { value: "id_asc", text: "Sort by" },
        { value: "price_asc", text: "Price: Low to High" },
        { value: "price_desc", text: "Price: High to Low" },
        { value: "brand_asc", text: "Brand: A to Z" },
        { value: "brand_desc", text: "Brand: Z to A" },
        { value: "title_asc", text: "Title: A to Z" },
        { value: "title_desc", text: "Title: Z to A" },
      ],
      loading: true,
      loading_2: true,
      products: [],
      page: 0,
      current_page: 1,
      all_pages: null,
      per_page: 20,
      per_page_options: [],
      found_product: "",
    };
  },
  computed: {
    pageAndFilter() {
      return this.pageProducts(
        this.sortProducts(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          )
        )
      );
    },
  },
  watch: {
    current_page: function(val) {
      if (val < 1) {
        this.page = 0;
      } else {
        this.page = val - 1;
      }

      this.current_page =
        Math.abs(this.current_page) >= 1 &&
        Math.abs(this.current_page) <= this.all_pages
          ? Math.abs(this.current_page)
          : null;
    },
    per_page: function() {
      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    products: function() {
      //this.products = val;

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    valueSliderPrice: function() {
      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    valueSliderSize: function() {
      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    valueGender: function() {
      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    valueType: function() {
      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    valueBrand: function() {
      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < 1
      ) {
        this.all_pages = 1;
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      } else {
        this.all_pages = Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        );
        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;
      }

      if (
        Math.ceil(
          this.filterProductPrice(
            this.filterProductSize(
              this.filterProductGender(
                this.filterProductType(this.filterProductBrand(this.products))
              )
            )
          ).length / this.per_page
        ) < this.current_page
      ) {
        this.current_page = this.all_pages;
      }
    },
    "$route.name": {
      immediate: true,
      async handler() {
        if (this.$route.name == "SHOP") {
          this.changeValueGender([]);
        }
      },
    },
    "$route.query.search": {
      immediate: true,
      async handler(value) {
        if (this.$route.name == "WOMEN") {
          this.changeValueGender(["Women"]);
        }

        if (this.$route.name == "MEN") {
          this.changeValueGender(["Men"]);
        }

        if (this.$route.name == "UNISEX") {
          this.changeValueGender(["Unisex"]);
        }

        this.products = (await getProducts(value)).data;
        for (let i = 0; i < this.products.length; i++) {
          this.$set(this.products[i], "quantity", 1);
        }

        this.found_product = this.filterProductPrice(
          this.filterProductSize(
            this.filterProductGender(
              this.filterProductType(this.filterProductBrand(this.products))
            )
          )
        ).length;

        this.loading = false;
      },
    },
  },
  methods: {
    decreaseQty(quantity, index) {
      const quantityInt = parseInt(quantity, 10);
      this.pageAndFilter[index].quantity = quantityInt;

      if (quantityInt <= 1) {
        this.pageAndFilter[index].quantity = 1;
      } else {
        this.pageAndFilter[index].quantity -= 1;
      }
    },
    increaseQty(quantity, index) {
      const quantityInt = parseInt(quantity, 10);
      this.pageAndFilter[index].quantity = quantityInt;
      if (quantityInt == 0) {
        this.pageAndFilter[index].quantity = this.pageAndFilter[index].stock;
      } else if (quantityInt >= this.pageAndFilter[index].stock) {
        this.pageAndFilter[index].quantity = this.pageAndFilter[index].stock;
      } else {
        this.pageAndFilter[index].quantity += 1;
      }
    },
    nextPage() {
      if (this.current_page >= this.all_pages) {
        this.current_page == this.all_pages;
      } else {
        this.current_page++;
      }
    },
    previousPage() {
      if (this.current_page <= 1) {
        this.current_page == 1;
      } else {
        this.current_page--;
      }
    },
    pageProducts(products) {
      return products.slice(
        this.page * this.per_page,
        this.page * this.per_page + this.per_page
      );
    },
    filterProductPrice(products) {
      return products.filter(
        (product) =>
          product.final_price >= this.valueSliderPrice[0] &&
          product.final_price <= this.valueSliderPrice[1]
      );
    },
    filterProductSize(products) {
      return products.filter(
        (product) =>
          product.size >= this.valueSliderSize[0] &&
          product.size <= this.valueSliderSize[1]
      );
    },
    filterProductGender(products) {
      if (!this.valueGender.length) {
        return products;
      } else {
        return products.filter((product) =>
          this.valueGender.includes(product.gender)
        );
      }
    },
    filterProductType(products) {
      if (!this.valueType.length) {
        return products;
      } else {
        return products.filter((product) =>
          this.valueType.includes(product.type)
        );
      }
    },
    filterProductBrand(products) {
      if (!this.valueBrand.length) {
        return products;
      } else {
        return products.filter((product) =>
          this.valueBrand.includes(product.brand)
        );
      }
    },
    changeSort(s) {
      if (s == "id_asc") {
        this.sortBy = "id";
        this.sortDirection = "asc";
      } else if (s == "price_asc") {
        this.sortBy = "final_price";
        this.sortDirection = "asc";
      } else if (s == "price_desc") {
        this.sortBy = "final_price";
        this.sortDirection = "desc";
      } else if (s == "title_asc") {
        this.sortBy = "title";
        this.sortDirection = "asc";
      } else if (s == "title_desc") {
        this.sortBy = "title";
        this.sortDirection = "desc";
      } else if (s == "brand_asc") {
        this.sortBy = "brand";
        this.sortDirection = "asc";
      } else if (s == "brand_desc") {
        this.sortBy = "brand";
        this.sortDirection = "desc";
      }
    },
    sortProducts(products) {
      return [...products].sort((p1, p2) => {
        let modifier = 1;

        if (this.sortDirection === "desc") {
          modifier = -1;
        }

        if (p1[this.sortBy] < p2[this.sortBy]) {
          return -1 * modifier;
        }

        if (p1[this.sortBy] > p2[this.sortBy]) {
          return 1 * modifier;
        }

        return 0;
      });
    },
  },
  async mounted() {
    this.per_page_options = await get20PerPageOptions();
    this.loading_2 = false;
  },
};
</script>

<style scoped>
.shop-shop {
  padding-left: 1.5rem;
}

.shop-shop.col-9-self {
  width: 80%;
  flex: 0 0 auto;
}

.shop-shop select:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.shop-shop .sort-by-select {
  width: 12rem;
  height: 2.25rem;
  padding: 0.15rem 0 0 0.9rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #384648;
  background: #fff url("./../../../../../assets/caret-down-solid.svg") no-repeat
    right 0.75rem center/20px 20px;
  border: 1px solid #384648;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}

.shop-shop .shop-header {
  margin-bottom: unset;
}

.shop-shop .shop-d-flex {
  padding-bottom: 1rem;
}

.shop-shop .shop-card-image {
  width: 100%;
  height: 13rem;
  object-fit: cover;
}

.shop-shop .shop-card-overflow {
  overflow: hidden;
  position: relative;
  height: 100%;
}

.shop-shop .shop-hover-section {
  position: absolute;
  width: 100%;
  background-color: #fff;
  height: 3rem;
  color: #384648;
  transition: all 0.3s ease-in-out;
  bottom: -3rem;
  border: 1px solid #dee2e6;
  padding-right: 0.75rem;
  padding-left: 0.75rem;
}

.shop-shop .shop-card-overflow:hover .shop-hover-section {
  bottom: 0rem;
}

.shop-shop .shop-hover-section-out {
  border-top: unset !important;
  border-left: unset !important;
  border-right: unset !important;
  border-bottom: unset !important;
}

.shop-shop .shop-card-price {
  padding-top: 0.75rem;
  font-weight: 700;
}

.shop-shop .card-margin {
  margin-bottom: 1.5rem;
}

.shop-shop h6.pt-1 {
  font-weight: 700;
  margin-bottom: 0.25rem;
}

.shop-shop .shop-hover-section .circle-minus,
.shop-shop .shop-hover-section .circle-plus {
  width: 1.25rem;
  height: 1.25rem;
  font-size: 0.7rem;
  border-radius: 50%;
  border: 1px solid rgba(0, 0, 0, 0.25);
  background-color: white;
  color: #985855;
  cursor: pointer;
  user-select: none;
}

.shop-shop .shop-hover-section .qty-text {
  font-weight: 500;
  font-size: 1.1rem;
}

.shop-shop .shop-hover-section .add-button-text {
  margin: unset;
  position: relative;
  top: 0.05rem;
  font-weight: 500;
  font-size: 0.95rem;
}

.shop-shop .shop-hover-section .shop-add-button {
  border: 1px solid #88b143;
  padding: 0.25rem 0.9rem;
  border-radius: 10rem;
  background-color: #88b143;
  color: #fff;
  cursor: pointer;
  user-select: none;
}

.shop-shop .shop-hover-section .shop-add-button:hover {
  border: 1px solid #698a30;
  background-color: #698a30;
}

.shop-shop .out-of-stock-field {
  background-color: #6c757d;
  color: #fff;
  font-weight: 500;
  cursor: default;
  user-select: none;
}

.shop-shop .out-of-stock-filter {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #000;
  opacity: 0.1;
  top: 0px;
  left: 0px;
}

.shop-shop .sold-out-tag {
  position: absolute;
  right: -2.3rem;
  top: 1.2rem;
  transform: rotate(45deg);
  background-color: #6c757d;
  color: #fff;
  width: 150px;
  font-weight: 500;
  font-size: 0.85rem;
  z-index: 1;
  height: 40px;
  user-select: none;
}

.shop-shop .percent-tag {
  position: absolute;
  right: -2.3rem;
  top: 1.2rem;
  transform: rotate(45deg);
  background-color: #f44336;
  color: #fff;
  width: 150px;
  font-weight: 500;
  font-size: 01rem;
  z-index: 1;
  height: 40px;
  user-select: none;
}

.shop-shop .rs-tag {
  position: absolute;
  right: -2.3rem;
  top: 1.2rem;
  transform: rotate(45deg);
  background-color: #f44336;
  color: #fff;
  width: 150px;
  font-weight: 500;
  font-size: 0.8rem;
  z-index: 1;
  height: 40px;
  user-select: none;
}

.shop-shop a.shop-card-border img,
.shop-shop a.shop-card-border h6,
.shop-shop a.shop-card-border div,
.shop-shop a.shop-card-border h5 {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}

.shop-shop .shop-card-overflow a.shop-card-border {
  padding-top: 0.5rem;
  padding-bottom: 0.25rem;
  color: #384648;
}

.percent-text {
  font-size: 1.25rem;
}

.line-through-sale {
  text-decoration: line-through;
  font-size: 1rem;
  color: #b9b9b9;
  font-weight: 400 !important;
}

.sale-show-text {
  color: #f44336;
  font-size: 1.3rem !important;
}

.shop-card-price h5 {
  font-weight: 700;
  padding-right: unset !important;
  padding-left: unset !important;
}

.shop-shop .per-page {
  font-size: 0.9rem;
  border-right: 1px solid #384648;
  font-weight: 500;
  width: 45%;
}

.shop-shop .page {
  font-size: 0.9rem;
  font-weight: 500;
  width: 55%;
}

.shop-shop .product-select-form-per-page {
  width: 50%;
  padding: 0.35rem 0.5rem 0.25rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  background: #fff url("./../../../../../assets/caret-down-solid.svg") no-repeat
    right 0.4rem center/20px 20px;
  border: 1px solid #384648;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  cursor: pointer;
}

.shop-shop .product-select-form-per-page:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.shop-shop .page-button {
  height: 2rem;
  min-width: 2rem;
  background-color: #eeeeee;
  color: #384648;
  font-size: 1.1rem;
  border: 1px solid #384648;
  cursor: pointer;
}

.shop-shop .product-page-input {
  text-align: center;
  width: 2rem;
  height: 2rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
  margin-right: 0.5rem;
}

.shop-shop .product-page-input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.shop-shop .product-padding-search-bar {
  margin-bottom: 1.5rem;
}

.circle-minus:hover,
.circle-plus:hover {
  background-color: #fcedf2 !important;
}

.cover_loader {
  position: relative;
  top: 12.5%;
  height: 75%;
}
</style>
