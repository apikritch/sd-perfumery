<template>
  <div class="padding-under-pagination product-list-page h-100">
    <div class="d-flex justify-content-between admin-product-padding">
      <div class="d-flex align-items-center admin-product-header">Products</div>
      <div class="d-flex align-items-end">
        <router-link class="admin-product-add" to="/admin/product/add">
          <font-awesome-icon icon="plus" class="me-1" /> Add Product
        </router-link>
      </div>
    </div>
    <div
      v-if="loading || loading_2"
      class="d-flex align-items-center justify-content-center cover_loader "
    >
      <MoonLoader color="#985855" />
    </div>
    <div v-if="!loading && !loading_2">
      <div class="row pt-3">
        <div class="col-long-select">
          <div>Brand:</div>
          <b-form-select
            v-model="brand"
            :options="brand_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-medium-select">
          <div>Type:</div>
          <b-form-select
            v-model="type"
            :options="type_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-small-select">
          <div>Size:</div>
          <div class="row product-label-small-row">
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Min"
                v-model="size[0]"
              />
            </div>
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Max"
                v-model="size[1]"
              />
            </div>
          </div>
        </div>
        <div class="col-medium-select">
          <div>Gender:</div>
          <b-form-select
            v-model="gender"
            :options="gender_options"
            class="product-select-form"
          ></b-form-select>
        </div>
      </div>
      <div class="row pt-3">
        <div class="col-small-select">
          <div>Quantity:</div>
          <div class="row product-label-small-row">
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Min"
                v-model="stock[0]"
              />
            </div>
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Max"
                v-model="stock[1]"
              />
            </div>
          </div>
        </div>
        <div class="col-small-select">
          <div>Price:</div>
          <div class="row product-label-small-row">
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Min"
                v-model="price[0]"
              />
            </div>
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Max"
                v-model="price[1]"
              />
            </div>
          </div>
        </div>
        <div class="col-medium-select">
          <div>Discount Type:</div>
          <b-form-select
            v-model="discount_type"
            :options="discount_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-small-select">
          <div>Discount:</div>
          <div class="row product-label-small-row">
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Min"
                v-model="discount[0]"
              />
            </div>
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Max"
                v-model="discount[1]"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="row pt-3 justify-content-between">
        <div class="col-small-select">
          <div>Final Price:</div>
          <div class="row product-label-small-row">
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Min"
                v-model="final_price[0]"
              />
            </div>
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Max"
                v-model="final_price[1]"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="row align-items-center product-padding-search-bar">
        <div class="col-4">
          <input
            type="text"
            class="form-control admin-product-search-bar"
            placeholder="Search by keyword"
            v-model="search"
          />
        </div>
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
                  class="page_button_layout d-flex align-items-center justify-content-center"
                  @click="previousPage"
                  :class="current_page == 1 ? 'disable_page' : 'page-button'"
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
                  class="page_button_layout d-flex align-items-center justify-content-center next-page"
                  @click="nextPage"
                  :class="
                    current_page == all_pages ? 'disable_page' : 'page-button'
                  "
                >
                  <font-awesome-icon icon="chevron-right" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="loading"
        class="d-flex justify-content-center align-items-center loading-height"
      ></div>
      <div v-if="!loading">
        <div class="d-flex admin-product-label">
          <div
            class="border-right-product-table-label id-label d-flex align-items-center justify-content-between px-2"
          >
            <div>ID</div>
            <div class="caret-cover" @click="sortId">
              <div
                class="caret-up"
                :class="
                  sortBy == 'id' && sortDirection == 'asc' ? 'sort-white' : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'id' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label image-label d-flex align-items-center justify-content-center"
          >
            Image
          </div>
          <div
            class="border-right-product-table-label title-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Title</div>
            <div class="caret-cover" @click="sortTitle">
              <div
                class="caret-up"
                :class="
                  sortBy == 'title' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'title' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label brand-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Brand</div>
            <div class="caret-cover" @click="sortBrand">
              <div
                class="caret-up"
                :class="
                  sortBy == 'brand' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'brand' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label type-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Type</div>
            <div class="caret-cover" @click="sortType">
              <div
                class="caret-up"
                :class="
                  sortBy == 'type' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'type' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label size-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Size</div>
            <div class="caret-cover" @click="sortSize">
              <div
                class="caret-up"
                :class="
                  sortBy == 'size' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'size' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label gender-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Gender</div>
            <div class="caret-cover" @click="sortGender">
              <div
                class="caret-up"
                :class="
                  sortBy == 'gender' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'gender' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label quantity-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Qty</div>
            <div class="caret-cover" @click="sortStock">
              <div
                class="caret-up"
                :class="
                  sortBy == 'stock' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'stock' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label price-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Price</div>
            <div class="caret-cover" @click="sortPrice">
              <div
                class="caret-up"
                :class="
                  sortBy == 'price' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'price' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label discount-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Discount</div>
            <div class="caret-cover" @click="sortDiscountNumber">
              <div
                class="caret-up"
                :class="
                  sortBy == 'discount_number' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'discount_number' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>

          <div
            class="border-right-product-table-label final-label d-flex align-items-center justify-content-between px-2"
          >
            <div>Final Pric</div>
            <div class="caret-cover" @click="sortFinalPrice">
              <div
                class="caret-up"
                :class="
                  sortBy == 'final_price' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'final_price' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div
            class="border-right-product-table-label description-label d-flex align-items-center justify-content-center"
          >
            Description
          </div>
          <div class="action-label"></div>
        </div>
        <div
          class="d-flex admin-product-detail"
          v-for="(product, index) in pageAndFilter"
          :key="index"
        >
          <div
            class="border-right-product-table id-detail d-flex align-items-center justify-content-center"
          >
            {{ product.id }}
          </div>
          <div
            class="border-right-product-table image-detail d-flex align-items-center justify-content-center"
          >
            <img :src="product.image" height="100%" />
          </div>
          <div
            class="border-right-product-table title-detail d-flex align-items-center"
          >
            {{ product.title }}
          </div>
          <div
            class="border-right-product-table brand-detail d-flex align-items-center"
          >
            {{ product.brand }}
          </div>
          <div
            class="border-right-product-table type-detail d-flex align-items-center"
          >
            {{ product.type }}
          </div>
          <div
            class="border-right-product-table size-detail d-flex align-items-center justify-content-center"
          >
            {{ product.size }}
          </div>
          <div
            class="border-right-product-table gender-detail d-flex align-items-center justify-content-center"
          >
            {{ product.gender }}
          </div>
          <div
            class="border-right-product-table quantity-detail d-flex align-items-center justify-content-center"
          >
            {{ product.stock }}
          </div>
          <div
            class="border-right-product-table price-detail d-flex align-items-center justify-content-center"
          >
            {{
              product.price.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
            }}
          </div>
          <div
            class="border-right-product-table discount-type-detail d-flex align-items-center justify-content-center"
          >
            {{ product.discount }}
          </div>
          <div
            v-if="product.discount_number == null"
            class="border-right-product-table discount-detail d-flex align-items-center justify-content-center"
          ></div>
          <div
            v-if="product.discount_number !== null"
            class="border-right-product-table discount-detail d-flex align-items-center justify-content-center"
          >
            {{
              product.discount_number.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
            }}
          </div>

          <div
            class="border-right-product-table discount-price-detail d-flex align-items-center justify-content-center"
            :class="product.discount ? 'discount-text' : null"
          >
            {{
              product.final_price.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
            }}
          </div>
          <div class="border-right-product-table description-detail py-1">
            {{ product.description }}
          </div>
          <div
            class="action-detail d-flex align-items-center justify-content-center"
          >
            <div
              class="after_action d-flex align-items-center justify-content-center"
              @click="showAction(index)"
              :class="product.display_action == 1 ? 'after_action_click' : null"
            >
              <font-awesome-icon icon="ellipsis-h" />
            </div>
            <!--Mini Menu-->
            <div class="action" v-if="product.display_action == 1">
              <div class="modal-overelay" @click="hideAction(index)"></div>
              <div class="modal-content">
                <div
                  class="d-flex flex-column justify-content-start align-items-center h-100 text-start"
                >
                  <router-link
                    class="w-100 action-options border-action ps-2"
                    :to="'/product/' + product.id"
                  >
                    <div class="row align-items-center">
                      <div class="col-4 padding-right-text-action">
                        <div class="d-flex justify-content-center">
                          <font-awesome-icon :icon="['far', 'eye']" />
                        </div>
                      </div>
                      <div class="col-8 padding-left-text-action">View</div>
                    </div>
                  </router-link>
                  <router-link
                    class="w-100 action-options border-action ps-2"
                    :to="'/admin/product/' + product.id + '/edit'"
                  >
                    <div class="row align-items-center">
                      <div class="col-4 padding-right-text-action">
                        <div class="d-flex justify-content-center">
                          <font-awesome-icon icon="pencil-alt" />
                        </div>
                      </div>
                      <div class="col-8 padding-left-text-action">Edit</div>
                    </div>
                  </router-link>
                  <button
                    class="w-100 action-delete-options border-action ps-2"
                    @click="deleteItem(index, product.id)"
                  >
                    <div class="row align-items-center">
                      <div class="col-4 padding-right-text-action">
                        <div class="d-flex justify-content-center">
                          <font-awesome-icon :icon="['far', 'trash-alt']" />
                        </div>
                      </div>
                      <div class="col-8 padding-left-text-action">Delete</div>
                    </div>
                  </button>
                </div>
              </div>
            </div>
            <!--Mini Menu-->
          </div>
        </div>
      </div>

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
                  class="page_button_layout d-flex align-items-center justify-content-center"
                  @click="previousPage"
                  :class="current_page == 1 ? 'disable_page' : 'page-button'"
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
                  class="page_button_layout d-flex align-items-center justify-content-center next-page"
                  @click="nextPage"
                  :class="
                    current_page == all_pages ? 'disable_page' : 'page-button'
                  "
                >
                  <font-awesome-icon icon="chevron-right" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getProducts, deleteProductById } from "@/services/ProductService";
import {
  getPerPageOptions,
  getSearchTypeOptions,
  getSearchGenderOptions,
  getBrandOptions,
  getSearchDiscountOptions,
} from "@/services/AdminOptionService";

export default {
  name: "ProductList",
  components: { MoonLoader },

  data() {
    return {
      brand_options: [{ value: null, text: "All" }],
      type_options: [],
      gender_options: [],
      stock_options: [],
      discount_options: [],
      per_page: 10,
      per_page_options: [],
      page: 0,
      current_page: 1,
      products: [],
      all_pages: null,
      loading: true,
      loading_2: true,

      brand: null,
      type: null,
      size: ["", ""],
      gender: null,
      stock: ["", ""],
      price: ["", ""],
      discount_type: null,
      discount: ["", ""],
      final_price: ["", ""],

      discount_max: null,
      final_price_max: null,
      price_max: null,
      size_max: null,
      stock_max: null,

      found_product: "",
      search: "",
      sortBy: "id",
      sortDirection: "asc",
    };
  },
  computed: {
    pageAndFilter() {
      return this.pageProducts(
        this.sortProducts(
          this.filterProductFinalPrice(
            this.filterProductPrice(
              this.filterProductDiscountType(
                this.filterProductSize(
                  this.filterProductStock(
                    this.filterProductBrand(
                      this.filterProductType(
                        this.filterProductGender(
                          this.filterProductDiscount(this.products)
                        )
                      )
                    )
                  )
                )
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
      this.checkAll();
    },
    products: function() {
      this.checkAll();
    },
    search() {
      const route = {
        name: "ProductList",
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
      async handler(value) {
        this.products = (await getProducts(value)).data;
        for (let i = 0; i < this.products.length; i++) {
          this.$set(this.products[i], "display_action", 0);
        }

        this.price_max = await Math.max.apply(
          Math,
          this.products.map((product) => product.price)
        );
        this.final_price_max = await Math.max.apply(
          Math,
          this.products.map((product) => product.final_price)
        );
        this.size_max = await Math.max.apply(
          Math,
          this.products.map((product) => product.size)
        );
        this.stock_max = await Math.max.apply(
          Math,
          this.products.map((product) => product.stock)
        );
        this.discount_max = await Math.max.apply(
          Math,
          this.products.map((product) => product.discount_number)
        );

        this.checkAll();
        this.loading_2 = false;
      },
    },
    brand: function() {
      this.checkAll();
    },
    type: function() {
      this.checkAll();
    },
    size: function() {
      this.checkAll();
    },
    gender: function() {
      this.checkAll();
    },
    stock: function() {
      this.checkAll();
    },
    price: function() {
      this.checkAll();
    },
    discount_type: function() {
      this.checkAll();
    },
    discount: function() {
      this.checkAll();
    },
    final_price: function() {
      this.checkAll();
    },
  },
  methods: {
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

    showAction(index) {
      if (this.pageAndFilter[index].display_action == 0) {
        this.pageAndFilter[index].display_action = 1;
      } else {
        this.pageAndFilter[index].display_action = 0;
      }
    },
    hideAction(index) {
      if (this.pageAndFilter[index].display_action == 1) {
        this.pageAndFilter[index].display_action = 0;
      } else {
        this.pageAndFilter[index].display_action = 1;
      }
    },
    async deleteItem(index, id) {
      try {
        this.pageAndFilter[index].display_action = 0;
        this.pageAndFilter.splice(index, 1);
        await deleteProductById(id);

        this.products = (await getProducts()).data;
        for (let i = 0; i < this.products.length; i++) {
          this.$set(this.products[i], "display_action", 0);
        }
      } catch (error) {
        console.log(error);
      }
    },
    pageProducts(products) {
      return products.slice(
        this.page * this.per_page,
        this.page * this.per_page + this.per_page
      );
    },
    filterProductPrice(products) {
      if (this.price[0] == "" && this.price[1] == "") {
        return products.filter(
          (product) => product.price >= 0 && product.price <= this.price_max
        );
      } else if (this.price[0] == "" && this.price[1] !== "") {
        return products.filter(
          (product) => product.price >= 0 && product.price <= this.price[1]
        );
      } else if (this.price[0] !== "" && this.price[1] == "") {
        return products.filter(
          (product) =>
            product.price >= this.price[0] && product.price <= this.price_max
        );
      } else {
        return products.filter(
          (product) =>
            product.price >= this.price[0] && product.price <= this.price[1]
        );
      }
    },
    filterProductFinalPrice(products) {
      if (this.final_price[0] == "" && this.final_price[1] == "") {
        return products.filter(
          (product) =>
            product.final_price >= 0 &&
            product.final_price <= this.final_price_max
        );
      } else if (this.final_price[0] == "" && this.final_price[1] !== "") {
        return products.filter(
          (product) =>
            product.final_price >= 0 &&
            product.final_price <= this.final_price[1]
        );
      } else if (this.final_price[0] !== "" && this.final_price[1] == "") {
        return products.filter(
          (product) =>
            product.final_price >= this.final_price[0] &&
            product.final_price <= this.final_price_max
        );
      } else {
        return products.filter(
          (product) =>
            product.final_price >= this.final_price[0] &&
            product.final_price <= this.final_price[1]
        );
      }
    },
    filterProductSize(products) {
      if (this.size[0] == "" && this.size[1] == "") {
        return products.filter(
          (product) => product.size >= 0 && product.size <= this.size_max
        );
      } else if (this.size[0] == "" && this.size[1] !== "") {
        return products.filter(
          (product) => product.size >= 0 && product.size <= this.size[1]
        );
      } else if (this.size[0] !== "" && this.size[1] == "") {
        return products.filter(
          (product) =>
            product.size >= this.size[0] && product.size <= this.size_max
        );
      } else {
        return products.filter(
          (product) =>
            product.size >= this.size[0] && product.size <= this.size[1]
        );
      }
    },
    filterProductDiscount(products) {
      if (this.discount[0] == "" && this.discount[1] == "") {
        return products.filter(
          (product) =>
            product.discount_number >= 0 &&
            product.discount_number <= this.discount_max
        );
      } else if (this.discount[0] == "" && this.discount[1] !== "") {
        return products.filter(
          (product) =>
            product.discount_number >= 0 &&
            product.discount_number <= this.discount[1]
        );
      } else if (this.discount[0] !== "" && this.discount[1] == "") {
        return products.filter(
          (product) =>
            product.discount_number >= this.discount[0] &&
            product.discount_number <= this.discount_max
        );
      } else {
        return products.filter(
          (product) =>
            product.discount_number >= this.discount[0] &&
            product.discount_number <= this.discount[1]
        );
      }
    },
    filterProductStock(products) {
      if (this.stock[0] == "" && this.stock[1] == "") {
        return products.filter(
          (product) => product.stock >= 0 && product.stock <= this.stock_max
        );
      } else if (this.stock[0] == "" && this.stock[1] !== "") {
        return products.filter(
          (product) => product.stock >= 0 && product.stock <= this.stock[1]
        );
      } else if (this.stock[0] !== "" && this.stock[1] == "") {
        return products.filter(
          (product) =>
            product.stock >= this.stock[0] && product.stock <= this.stock_max
        );
      } else {
        return products.filter(
          (product) =>
            product.stock >= this.stock[0] && product.stock <= this.stock[1]
        );
      }
    },
    filterProductDiscountType(products) {
      if (this.discount_type == null) {
        return products;
      } else if (this.discount_type == "No Discount") {
        return products.filter((product) => product.discount == null);
      } else {
        return products.filter((product) =>
          this.discount_type.includes(product.discount)
        );
      }
    },
    filterProductBrand(products) {
      if (this.brand == null) {
        return products;
      } else {
        return products.filter((product) => this.brand.includes(product.brand));
      }
    },
    filterProductType(products) {
      if (this.type == null) {
        return products;
      } else {
        return products.filter((product) => this.type.includes(product.type));
      }
    },
    filterProductGender(products) {
      if (this.gender == null) {
        return products;
      } else {
        return products.filter((product) =>
          this.gender.includes(product.gender)
        );
      }
    },
    sortId() {
      if (this.sortBy == "id" && this.sortDirection == "asc") {
        this.sortBy = "id";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "id";
        this.sortDirection = "asc";
      }
    },
    sortTitle() {
      if (this.sortBy == "title" && this.sortDirection == "asc") {
        this.sortBy = "title";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "title";
        this.sortDirection = "asc";
      }
    },
    sortBrand() {
      if (this.sortBy == "brand" && this.sortDirection == "asc") {
        this.sortBy = "brand";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "brand";
        this.sortDirection = "asc";
      }
    },
    sortType() {
      if (this.sortBy == "type" && this.sortDirection == "asc") {
        this.sortBy = "type";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "type";
        this.sortDirection = "asc";
      }
    },
    sortSize() {
      if (this.sortBy == "size" && this.sortDirection == "asc") {
        this.sortBy = "size";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "size";
        this.sortDirection = "asc";
      }
    },
    sortGender() {
      if (this.sortBy == "gender" && this.sortDirection == "asc") {
        this.sortBy = "gender";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "gender";
        this.sortDirection = "asc";
      }
    },
    sortStock() {
      if (this.sortBy == "stock" && this.sortDirection == "asc") {
        this.sortBy = "stock";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "stock";
        this.sortDirection = "asc";
      }
    },
    sortPrice() {
      if (this.sortBy == "price" && this.sortDirection == "asc") {
        this.sortBy = "price";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "price";
        this.sortDirection = "asc";
      }
    },
    sortDiscountNumber() {
      if (this.sortBy == "discount_number" && this.sortDirection == "asc") {
        this.sortBy = "discount_number";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "discount_number";
        this.sortDirection = "asc";
      }
    },
    sortFinalPrice() {
      if (this.sortBy == "final_price" && this.sortDirection == "asc") {
        this.sortBy = "final_price";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "final_price";
        this.sortDirection = "asc";
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
    checkAll() {
      const item_length = this.filterProductFinalPrice(
        this.filterProductPrice(
          this.filterProductDiscountType(
            this.filterProductSize(
              this.filterProductStock(
                this.filterProductBrand(
                  this.filterProductType(
                    this.filterProductGender(
                      this.filterProductDiscount(this.products)
                    )
                  )
                )
              )
            )
          )
        )
      ).length;
      this.found_product = item_length;
      if (Math.ceil(item_length / this.per_page) < 1) {
        this.all_pages = 1;
      } else {
        this.all_pages = Math.ceil(item_length / this.per_page);
      }
      if (Math.ceil(item_length / this.per_page) < this.current_page) {
        this.current_page = this.all_pages;
      }
    },
  },
  async mounted() {
    const allbrand = (await getBrandOptions()).data;
    const sort_all_brand = [...allbrand].sort((b1, b2) => {
      var brand_a = b1.text;
      var brand_b = b2.text;
      if (brand_a < brand_b) {
        return -1;
      }
      if (brand_a > brand_b) {
        return 1;
      }
      return 0;
    });
    this.brand_options.push(...sort_all_brand);
    this.per_page_options = await getPerPageOptions();
    this.type_options = await getSearchTypeOptions();
    this.gender_options = await getSearchGenderOptions();
    this.discount_options = await getSearchDiscountOptions();

    this.loading = false;
  },
};
</script>

<style scoped>
.admin-product-padding {
  height: 9rem;
  border-bottom: 1px solid #384648;
}

.admin-product-header {
  font-size: 2.5rem;
  font-weight: 500;
}

.admin-product-add {
  background-color: #985855;
  color: #fff;
  font-size: 1.05rem;
  padding: 0.6rem 1.25rem 0.45rem 1.25rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
  margin-bottom: 1rem;
}

.product-select-form {
  width: 100%;
  padding: 0.5rem 0.5rem 0.4rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  background: #fff url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px;
  border: 1px solid #384648;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  margin-top: 0.25rem;
  cursor: pointer;
}

.product-select-form:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.col-long-select {
  flex: 0 0 auto;
  width: 22.5%;
}

.col-medium-select {
  flex: 0 0 auto;
  width: 17.5%;
}

.col-small-select {
  flex: 0 0 auto;
  width: 25%;
}

.product-small-input {
  width: 100%;
  padding: 0.5rem 0.5rem 0.4rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
}

.product-small-input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.product-label-small-row {
  margin-top: 0.25rem;
}

.admin-product-search-bar {
  border-radius: 1.5rem;
  border: 1px solid #384648;
  padding: 0.25rem 1rem 0.1rem 1rem;
  width: 100%;
  font-size: 0.9rem;
}

.product-select-form-per-page {
  width: 50%;
  padding: 0.35rem 0.5rem 0.25rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  background: #fff url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.4rem center/20px 20px;
  border: 1px solid #384648;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  cursor: pointer;
}

.product-select-form-per-page:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.per-page {
  font-size: 0.9rem;
  border-right: 1px solid #384648;
  font-weight: 500;
  width: 45%;
}

.page {
  font-size: 0.9rem;
  font-weight: 500;
  width: 55%;
}

.product-page-input {
  text-align: center;
  width: 2rem;
  height: 2rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
  margin-right: 0.5rem;
}

.page input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.product-page-input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.admin-product-label {
  background-color: #985855;
  border-style: solid;
  border-color: #384648;
  border-width: 0 1px 1px 1px;
  color: #fff;
  font-weight: 400;
  font-size: 0.9rem;
  margin-top: 2rem;
}

.admin-product-detail {
  border-style: solid;
  border-color: #384648;
  border-width: 0 1px 1px 1px;
  font-size: 0.8rem;
}

.border-right-product-table {
  border-right: 1px solid #384648;
}

.admin-product-label .border-right-product-table-label {
  border-right: 1px solid #384648;
  height: 2.5rem;
}

.id-detail {
  text-align: center;
  width: 4.5%;
  height: 4.5rem;
}

.image-detail {
  text-align: center;
  width: 6.5%;
  height: 4.5rem;
  overflow: hidden;
}

.title-detail {
  padding-left: 0.1rem;
  width: 9%;
  height: 4.5rem;
  overflow: auto;
  resize: none;
}

.brand-detail {
  padding-left: 0.1rem;
  width: 9%;
  height: 4.5rem;
  overflow: auto;
  resize: none;
}

.type-detail {
  padding-left: 0.1rem;
  width: 7%;
  height: 4.5rem;
}

.size-detail {
  text-align: center;
  width: 5.5%;
  height: 4.5rem;
}

.gender-detail {
  text-align: center;
  width: 7%;
  height: 4.5rem;
}

.quantity-detail {
  text-align: center;
  width: 5%;
  height: 4.5rem;
}

.price-detail {
  text-align: center;
  width: 8.5%;
  height: 4.5rem;
}

.discount-type-detail {
  text-align: center;
  width: 2.5%;
  height: 4.5rem;
}

.discount-detail {
  text-align: center;
  width: 6.5%;
  height: 4.5rem;
}

.discount-price-detail {
  text-align: center;
  width: 8.5%;
  height: 4.5rem;
}

.description-detail {
  padding-left: 0.1rem;
  width: 18%;
  overflow: auto;
  resize: none;
  height: 4.5rem;
}

.action-detail {
  text-align: center;
  width: 2.5%;
  height: 4.5rem;
  position: relative;
}

.id-label {
  text-align: center;
  width: 4.5%;
}

.image-label {
  text-align: center;
  width: 6.5%;
}

.title-label {
  text-align: center;
  width: 9%;
}

.brand-label {
  text-align: center;
  width: 9%;
}

.type-label {
  text-align: center;
  width: 7%;
}

.size-label {
  text-align: center;
  width: 5.5%;
}

.gender-label {
  text-align: center;
  width: 7%;
}

.quantity-label {
  text-align: center;
  width: 5%;
}

.price-label {
  text-align: center;
  width: 8.5%;
}

.discount-label {
  text-align: center;
  width: 9%;
}

.final-label {
  text-align: center;
  width: 8.5%;
}

.description-label {
  text-align: center;
  width: 18%;
}

.action-label {
  text-align: center;
  width: 2.5%;
}

.product-padding-search-bar {
  margin-top: 2rem;
}

.border-right-product-table img {
  object-fit: cover;
}

.padding-under-pagination {
  padding-bottom: 2rem;
}

.action-detail .action {
  position: absolute;
  right: -8.5px;
  z-index: 999;
}

.action-detail .modal-overelay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  opacity: 1;
}

.action-detail .modal-content {
  border: 1px solid #7e989c;
  background-color: #fbfbfb;
  right: 0px;
  top: 57.5px;
  box-sizing: border-box;
  width: 125px;
  height: 90px;
  overflow: hidden;
}

.action-options {
  padding: 0.31rem 0rem;
  color: #384648;
}

.action-delete-options {
  padding: 0.31rem 0rem;
  color: #384648;
  background-color: unset;
  border: unset;
}

.border-action {
  border-bottom: 1px solid #7e989c;
}

.border-action:hover {
  background-color: #ececec;
}

.padding-left-text-action {
  padding-left: unset;
  text-align: left;
}

.padding-right-text-action {
  padding-right: unset;
}

.product-list-page .loading-height {
  height: 25vh;
}

.discount-text {
  color: #f44336;
}

.caret-cover {
  cursor: pointer;
}

.caret-up {
  width: 0.5rem;
  height: 0.5rem;

  display: block;
  padding-bottom: 0.1rem;
  mask: url("./../../../../assets/caret-up-white.svg") no-repeat center;
  background-color: #b9b9b9;
}

.caret-down {
  width: 0.5rem;
  height: 0.5rem;
  display: block;
  padding-top: 0.1rem;
  mask: url("./../../../../assets/caret-down-white.svg") no-repeat center;
  background-color: #b9b9b9;
}

.sort-white {
  background-color: #fff !important;
}

.after_action {
  cursor: pointer;
  border: 1px solid #fff;
  border-radius: 1rem;
  width: 1.25rem;
  height: 1.25rem;
}

.after_action:hover {
  background-color: #e9e9e9;
  border-radius: 1rem;
  border: 1px solid #fff;
}

.after_action_click {
  background-color: #e9e9e9;
  border-radius: 1rem;
  border: 1px solid #d1d1d1;
}

.cover_loader {
  height: 75%;
}

.admin-product-add:hover {
  background-color: #814643;
}

.page_button_layout {
  height: 2rem;
  min-width: 2rem;
  font-size: 1.1rem;
}

.page-button {
  background-color: #eeeeee;
  color: #384648;
  cursor: pointer;
  border: 1px solid #384648;
}

.page-button:hover {
  background-color: #dadde1;
}

.disable_page {
  color: #8d949e;
  background-color: #eeeeee;
  border: 1px solid #8d949e;
}

.disable_page:hover {
  background-color: none !important;
}
</style>
