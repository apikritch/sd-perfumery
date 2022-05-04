<template>
  <div class="padding-under-pagination h-100">
    <div
      class="d-flex justify-content-between align-items-center admin-Order-head"
    >
      Customers
    </div>

    <div
      v-if="loading || loading_2"
      class="d-flex align-items-center justify-content-center cover_loader"
    >
      <MoonLoader color="#985855" />
    </div>

    <div v-if="!loading && !loading_2">
      <div class="row pt-3">
        <div class="col-medium-select">
          <div>First Name:</div>
          <b-form-select
            v-model="first_name"
            :options="first_name_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-medium-select">
          <div>Last Name:</div>
          <b-form-select
            v-model="last_name"
            :options="last_name_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-medium-select">
          <div>City:</div>
          <b-form-select
            v-model="city"
            :options="city_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-medium-select">
          <div>State:</div>
          <b-form-select
            v-model="state"
            :options="state_options"
            class="product-select-form"
          ></b-form-select>
        </div>
      </div>

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
        <div class="col-4">{{ found_customer }} CUSTOMERS FOUND</div>

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
                sortBy == 'id' && sortDirection == 'desc' ? 'sort-white' : null
              "
            />
          </div>
        </div>
        <div
          class="border-right-product-table-label label-2 d-flex align-items-center justify-content-between px-2"
        >
          <div>First Name</div>
          <div class="caret-cover" @click="sortFirstName">
            <div
              class="caret-up"
              :class="
                sortBy == 'first_name' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'first_name' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>
        <div
          class="border-right-product-table-label label-2 d-flex align-items-center justify-content-between px-2"
        >
          <div>Last Name</div>
          <div class="caret-cover" @click="sortLastName">
            <div
              class="caret-up"
              :class="
                sortBy == 'last_name' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'last_name' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>
        <div
          class="border-right-product-table-label label-3 d-flex align-items-center justify-content-between px-2"
        >
          <div>Email</div>
          <div class="caret-cover" @click="sortEmail">
            <div
              class="caret-up"
              :class="
                sortBy == 'email' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'email' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>
        <div
          class="border-right-product-table-label label-4 d-flex align-items-center justify-content-center"
        >
          Phone
        </div>
        <div
          class="border-right-product-table-label label-5 d-flex align-items-center justify-content-center"
        >
          Address 1
        </div>
        <div
          class="border-right-product-table-label label-6 d-flex align-items-center justify-content-center"
        >
          Address 2
        </div>
        <div
          class="border-right-product-table-label label-7 d-flex align-items-center justify-content-between px-2"
        >
          <div>City</div>
          <div class="caret-cover" @click="sortCity">
            <div
              class="caret-up"
              :class="
                sortBy == 'city' && sortDirection == 'asc' ? 'sort-white' : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'city' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>
        <div
          class="border-right-product-table-label label-8 d-flex align-items-center justify-content-between px-2"
        >
          <div>State</div>
          <div class="caret-cover" @click="sortState">
            <div
              class="caret-up"
              :class="
                sortBy == 'state' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'state' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>

        <div class="label-9 d-flex align-items-center justify-content-center">
          Postcode
        </div>
      </div>
      <!--Label-->

      <!--Table-->
      <div
        class="d-flex admin-product-detail"
        v-for="(customer, index) in pageAndFilter"
        :key="index"
      >
        <div
          class="border-right-product-table detail-1 d-flex align-items-center justify-content-center"
        >
          {{ customer.id }}
        </div>
        <div
          class="border-right-product-table detail-2 d-flex align-items-center"
        >
          {{ customer.first_name }}
        </div>
        <div
          class="border-right-product-table detail-2 d-flex align-items-center"
        >
          {{ customer.last_name }}
        </div>
        <div
          class="border-right-product-table detail-3 d-flex align-items-center"
        >
          {{ customer.email }}
        </div>
        <div
          class="border-right-product-table detail-4 d-flex align-items-center justify-content-center"
        >
          {{ customer.phone }}
        </div>
        <div
          class="border-right-product-table detail-5 d-flex align-items-center"
        >
          {{ customer.address_1 }}
        </div>
        <div
          class="border-right-product-table detail-6 d-flex align-items-center"
        >
          {{ customer.address_2 }}
        </div>
        <div
          class="border-right-product-table detail-7 d-flex align-items-center justify-content-center"
        >
          {{ customer.city }}
        </div>
        <div
          class="border-right-product-table detail-8 d-flex align-items-center justify-content-center"
        >
          {{ customer.state }}
        </div>

        <div class="detail-9 d-flex align-items-center justify-content-center">
          {{ customer.postcode }}
        </div>
      </div>
      <!--Table-->

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
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getCustomers } from "@/services/CustomerService";
import { getPerPageOptions } from "@/services/AdminOptionService";

export default {
  name: "CustomerList",
  components: { MoonLoader },
  data() {
    return {
      customers: [],
      page: 0,
      current_page: 1,
      all_pages: null,
      per_page: 10,
      per_page_options: [],

      first_name: null,
      last_name: null,
      city: null,
      state: null,

      loading: true,
      loading_2: true,

      first_name_options: [
        {
          value: null,
          text: "All",
        },
        {
          value: "Not Null",
          text: "Not Null",
        },
        {
          value: "Null",
          text: "Null",
        },
      ],
      last_name_options: [
        {
          value: null,
          text: "All",
        },
        {
          value: "Not Null",
          text: "Not Null",
        },
        {
          value: "Null",
          text: "Null",
        },
      ],
      city_options: [
        {
          value: null,
          text: "All",
        },
        {
          value: "Not Null",
          text: "Not Null",
        },
        {
          value: "Null",
          text: "Null",
        },
      ],
      state_options: [
        {
          value: null,
          text: "All",
        },
        {
          value: "Not Null",
          text: "Not Null",
        },
        {
          value: "Null",
          text: "Null",
        },
      ],

      found_customer: "",
      search: "",
      sortBy: "id",
      sortDirection: "asc",
    };
  },
  computed: {
    pageAndFilter() {
      return this.pageCustomers(
        this.sortCustomers(
          this.filterFirstName(
            this.filterLastName(
              this.filterCity(this.filterState(this.customers))
            )
          )
        )
      );
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
    customers: function () {
      this.checkAll();
    },
    search() {
      const route = {
        name: "CustomerList",
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
        this.customers = (await getCustomers(value)).data;

        this.checkAll();
        this.loading = false;
      },
    },
    first_name() {
      this.checkAll();
    },
    last_name() {
      this.checkAll();
    },
    city() {
      this.checkAll();
    },
    state() {
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
    pageCustomers(customers) {
      return customers.slice(
        this.page * this.per_page,
        this.page * this.per_page + this.per_page
      );
    },
    filterFirstName(customers) {
      if (this.first_name == null) {
        return customers;
      } else if (this.first_name == "Not Null") {
        return customers.filter((customer) => customer.first_name !== null);
      } else {
        return customers.filter((customer) => customer.first_name == null);
      }
    },
    filterLastName(customers) {
      if (this.last_name == null) {
        return customers;
      } else if (this.last_name == "Not Null") {
        return customers.filter((customer) => customer.last_name !== null);
      } else {
        return customers.filter((customer) => customer.last_name == null);
      }
    },
    filterCity(customers) {
      if (this.city == null) {
        return customers;
      } else if (this.city == "Not Null") {
        return customers.filter((customer) => customer.city !== null);
      } else {
        return customers.filter((customer) => customer.city == null);
      }
    },
    filterState(customers) {
      if (this.state == null) {
        return customers;
      } else if (this.state == "Not Null") {
        return customers.filter((customer) => customer.state !== null);
      } else {
        return customers.filter((customer) => customer.state == null);
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
    sortFirstName() {
      if (this.sortBy == "first_name" && this.sortDirection == "asc") {
        this.sortBy = "first_name";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "first_name";
        this.sortDirection = "asc";
      }
    },
    sortLastName() {
      if (this.sortBy == "last_name" && this.sortDirection == "asc") {
        this.sortBy = "last_name";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "last_name";
        this.sortDirection = "asc";
      }
    },
    sortEmail() {
      if (this.sortBy == "email" && this.sortDirection == "asc") {
        this.sortBy = "email";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "email";
        this.sortDirection = "asc";
      }
    },
    sortCity() {
      if (this.sortBy == "city" && this.sortDirection == "asc") {
        this.sortBy = "city";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "city";
        this.sortDirection = "asc";
      }
    },
    sortState() {
      if (this.sortBy == "state" && this.sortDirection == "asc") {
        this.sortBy = "state";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "state";
        this.sortDirection = "asc";
      }
    },
    sortCustomers(customers) {
      return [...customers].sort((p1, p2) => {
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
      const item_length = this.filterFirstName(
        this.filterLastName(this.filterCity(this.filterState(this.customers)))
      ).length;

      this.found_customer = item_length;
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
    this.per_page_options = await getPerPageOptions();
    this.loading_2 = false;
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

.page-button {
  height: 2rem;
  min-width: 2rem;
  background-color: #eeeeee;
  color: #384648;
  font-size: 1.1rem;
  border: 1px solid #384648;
  cursor: pointer;
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

.border-right-product-table-label {
  border-right: 1px solid #384648;
  height: 2.5rem;
}

.label-1 {
  width: 7%;
}

.label-2 {
  width: 11%;
}

.label-3 {
  width: 14%;
}

.label-4 {
  width: 7.5%;
}

.label-5 {
  width: 16%;
}

.label-6 {
  width: 9%;
}

.label-7 {
  width: 9%;
}

.label-8 {
  width: 9%;
}

.label-9 {
  width: 6.5%;
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
  height: 4.5rem;
}

.detail-2 {
  padding-left: 0.25rem;
  width: 11%;
  height: 4.5rem;
}

.detail-3 {
  padding-left: 0.25rem;
  width: 14%;
  height: 4.5rem;
}

.detail-4 {
  width: 7.5%;
  height: 4.5rem;
}

.detail-5 {
  padding-left: 0.25rem;
  width: 16%;
  height: 4.5rem;
}

.detail-6 {
  padding-left: 0.25rem;
  width: 9%;
  height: 4.5rem;
}

.detail-7 {
  width: 9%;
  height: 4.5rem;
}

.detail-8 {
  width: 9%;
  height: 4.5rem;
}

.detail-9 {
  width: 6.5%;
  height: 4.5rem;
}

.page input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.padding-under-pagination {
  padding-bottom: 2rem;
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

.cover_loader {
  height: 75%;
}
</style>
