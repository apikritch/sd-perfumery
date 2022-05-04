<template>
  <div class="padding-under-pagination user-list-page brand-list h-100">
    <div class="d-flex justify-content-between admin-product-padding">
      <div class="d-flex align-items-center admin-product-header">Brands</div>
      <div class="d-flex align-items-end">
        <router-link class="admin-product-add" to="/admin/brand/add">
          <font-awesome-icon icon="plus" class="me-1" /> Add Brand
        </router-link>
      </div>
    </div>

    <div
      v-if="loading || loading_2"
      class="d-flex align-items-center justify-content-center cover_loader"
    >
      <MoonLoader color="#985855" />
    </div>
    <div v-if="!loading && !loading_2">
      <div class="row align-items-center product-padding-search-bar">
        <!--Search-->
        <div class="col-4">
          <input
            type="text"
            class="form-control admin-product-search-bar"
            placeholder="Search by keyword"
            v-model="search"
          />
        </div>
        <div class="col-4">{{ found_brand }} BRANDS FOUND</div>
        <!--Search-->

        <!--Pagination-->
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
        <!--Pagination-->
      </div>

      <div v-if="!loading">
        <!--Label-->
        <div class="d-flex admin-product-label">
          <div
            class="border-right-product-table-label label-1 d-flex align-items-center justify-content-between px-2"
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
            class="border-right-product-table-label label-2 d-flex align-items-center justify-content-between px-2"
          >
            <div>Brand</div>
            <div class="caret-cover" @click="sortText">
              <div
                class="caret-up"
                :class="
                  sortBy == 'text' && sortDirection == 'asc'
                    ? 'sort-white'
                    : null
                "
              />

              <div
                class="caret-down"
                :class="
                  sortBy == 'text' && sortDirection == 'desc'
                    ? 'sort-white'
                    : null
                "
              />
            </div>
          </div>
          <div class="last-product-table-label label-3"></div>
        </div>
        <!--Label-->

        <!--Table-->
        <div
          class="d-flex admin-product-detail"
          v-for="(brand, index) in pageAndFilter"
          :key="brand.id"
        >
          <div
            class="border-right-product-table detail-1 d-flex align-items-center justify-content-center"
          >
            {{ brand.id }}
          </div>
          <div
            class="border-right-product-table detail-2 d-flex align-items-center"
          >
            {{ brand.text }}
          </div>
          <div
            class="detail-3 d-flex align-items-center justify-content-center"
          >
            <div
              class="after_action d-flex align-items-center justify-content-center"
              @click="showAction(index)"
              :class="brand.display_action == 1 ? 'after_action_click' : null"
            >
              <font-awesome-icon icon="ellipsis-h" />
            </div>

            <!--Mini Menu-->
            <div class="action" v-if="brand.display_action == 1">
              <div class="modal-overelay" @click="hideAction(index)"></div>
              <div class="modal-content">
                <div
                  class="d-flex flex-column justify-content-end align-items-center h-100 text-start"
                >
                  <router-link
                    class="w-100 action-options border-action ps-2"
                    :to="'/admin/brand/' + brand.id + '/edit'"
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
                    @click="deleteItem(index, brand.id)"
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
        <!--Table-->

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
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
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
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import {
  getPerPageOptions,
  getBrandOptions,
  deleteBrandById,
} from "@/services/AdminOptionService";

export default {
  name: "BrandList",
  components: { MoonLoader },

  data() {
    return {
      page: 0,
      current_page: 1,
      all_pages: null,
      per_page: 10,
      per_page_options: [],
      loading: true,
      loading_2: true,
      brands: [],

      found_brand: "",
      search: "",
      sortBy: "id",
      sortDirection: "asc",
    };
  },
  computed: {
    pageAndFilter() {
      return this.pageProducts(this.sortBrands(this.brands));
    },
  },
  watch: {
    current_page: function (val) {
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
    per_page: function () {
      this.checkAll();
    },
    brands: function () {
      this.checkAll();
    },
    search() {
      const route = {
        name: "BrandList",
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
        this.brands = (await getBrandOptions(value)).data;
        for (let i = 0; i < this.brands.length; i++) {
          this.$set(this.brands[i], "display_action", 0);
        }
        this.checkAll();
        this.loading_2 = false;
      },
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
        await deleteBrandById(id);
        this.brands = (await getBrandOptions()).data;
        for (let i = 0; i < this.brands.length; i++) {
          this.$set(this.brands[i], "display_action", 0);
        }
        this.checkAll();
      } catch (error) {
        console.log(error);
      }
    },
    pageProducts(brands) {
      return brands.slice(
        this.page * this.per_page,
        this.page * this.per_page + this.per_page
      );
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
    sortText() {
      if (this.sortBy == "text" && this.sortDirection == "asc") {
        this.sortBy = "text";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "text";
        this.sortDirection = "asc";
      }
    },
    sortBrands(brands) {
      return [...brands].sort((p1, p2) => {
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
      this.found_brand = this.brands.length;
      if (Math.ceil(this.brands.length / this.per_page) < 1) {
        this.all_pages = 1;
      } else {
        this.all_pages = Math.ceil(this.brands.length / this.per_page);
      }
      if (Math.ceil(this.brands.length / this.per_page) < this.current_page) {
        this.current_page = this.all_pages;
      }
    },
  },
  async mounted() {
    this.per_page_options = await getPerPageOptions();
    this.loading = false;
  },
};
</script>

<style scoped>
.admin-Order-head {
  height: 9rem;
  border-bottom: 1px solid #384648;
  font-size: 2.5rem;
  font-weight: 500;
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

.col-date-select {
  flex: 0 0 auto;
  width: 30%;
}

.product-select-form {
  width: 100%;
  padding: 0.5rem 0.5rem 0.4rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  background: #fff url("../../../../assets/caret-down-solid.svg") no-repeat
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

.product-padding-search-bar {
  margin-top: 2rem;
}

.admin-product-search-bar {
  border-radius: 1.5rem;
  border: 1px solid #384648;
  padding: 0.25rem 1rem 0.1rem 1rem;
  width: 100%;
  font-size: 0.9rem;
}

.user-list-page .per-page {
  font-size: 0.9rem;
  border-right: 1px solid #384648;
  font-weight: 500;
  width: 45%;
}

.user-list-page .page {
  font-size: 0.9rem;
  font-weight: 500;
  width: 55%;
}

.user-list-page .product-select-form-per-page {
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

.user-list-page .product-select-form-per-page:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.user-list-page .page-button {
  height: 2rem;
  min-width: 2rem;
  background-color: #eeeeee;
  color: #384648;
  font-size: 1.1rem;
  border: 1px solid #384648;
  cursor: pointer;
}

.user-list-page .product-page-input {
  text-align: center;
  width: 2rem;
  height: 2rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
  margin-right: 0.5rem;
}

.user-list-page .product-page-input:focus-visible {
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

.border-right-product-table-label {
  border-right: 1px solid #384648;
  height: 2.5rem;
}

.last-product-table-label {
  height: 2.5rem;
  padding-top: 0.65rem;
}

.label-1 {
  text-align: center;
  width: 7%;
}

.label-2 {
  text-align: center;
  width: 83%;
}

.label-3 {
  text-align: center;
  width: 10%;
}

.border-right-product-table {
  border-right: 1px solid #384648;
}

.admin-product-detail {
  border-style: solid;
  border-color: #384648;
  border-width: 0 1px 1px 1px;
  font-size: 0.8rem;
}

.detail-1 {
  width: 7%;
  height: 2.5rem;
}

.detail-2 {
  padding-left: 0.5rem;
  width: 83%;
  height: 2.5rem;
}

.detail-3 {
  width: 10%;
  height: 2.5rem;
  position: relative;
}

.page input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.padding-under-pagination {
  padding-bottom: 2rem;
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

.user-list-page .loading-height {
  height: 25vh;
}

.user-list-page .action {
  position: absolute;
  right: -8.5px;
  z-index: 999;
}

.user-list-page .modal-overelay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  opacity: 1;
}

.user-list-page .modal-content {
  border: 1px solid #7e989c;
  background-color: #fbfbfb;
  right: 0px;
  top: 42.5px;
  box-sizing: border-box;
  width: 125px;
  height: 60px;
  overflow: hidden;
}

.user-list-page .action-dot {
  cursor: pointer;
}

.user-list-page .padding-right-text-action {
  padding-right: unset;
}

.user-list-page .action-delete-options {
  padding: 0.31rem 0rem;
  background-color: unset;
  border: unset;
}

.action-options {
  padding: 0.31rem 0rem;
  color: #384648;
}

.border-action {
  border-bottom: 1px solid #7e989c;
}

.padding-left-text-action {
  padding-left: unset;
  text-align: left;
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

.border-action:hover {
  background-color: #ececec;
}

.cover_loader {
  height: 75%;
}
</style>
