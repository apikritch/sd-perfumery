<template>
  <div class="padding-under-pagination h-100">
    <div
      class="d-flex justify-content-between align-items-center admin-Order-head"
    >
      Orders
    </div>

    <div
      v-if="loading || loading_2"
      class="d-flex align-items-center justify-content-center cover_loader"
    >
      <MoonLoader color="#985855" />
    </div>
    <div v-if="!loading && !loading_2">
      <div class="row pt-3">
        <div class="col-small-select">
          <div>Order Total:</div>
          <div class="row product-label-small-row">
            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Min"
                v-model="order_total[0]"
              />
            </div>

            <div class="col-6">
              <input
                type="text"
                class="w-100 product-small-input"
                placeholder="Max"
                v-model="order_total[1]"
              />
            </div>
          </div>
        </div>
        <div class="col-medium-select">
          <div>Order Status:</div>
          <b-form-select
            v-model="order_status"
            :options="order_status_options"
            class="product-select-form"
          ></b-form-select>
        </div>
        <div class="col-medium-select">
          <div>Shipment Status:</div>
          <b-form-select
            v-model="shipment_status"
            :options="shipment_status_options"
            class="product-select-form"
          ></b-form-select>
        </div>

        <div class="col-medium-select">
          <div>Order Date:</div>
          <input
            type="date"
            class="w-100 product-small-input marrgin-025"
            v-model="order_date"
          />
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
        <div class="col-4">{{ found_order }} ORDERS FOUND</div>
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
          <div>Order Total</div>
          <div class="caret-cover" @click="sortOrdetTotal">
            <div
              class="caret-up"
              :class="
                sortBy == 'order_total' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'order_total' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>
        <div
          class="border-right-product-table-label label-4 d-flex align-items-center justify-content-center"
        >
          Order Status
        </div>
        <div
          class="border-right-product-table-label label-5 d-flex align-items-center justify-content-center"
        >
          Shipment Status
        </div>
        <div
          class="border-right-product-table-label label-6 d-flex align-items-center justify-content-center"
        >
          Tracking Number
        </div>
        <div
          class="border-right-product-table-label label-7 d-flex align-items-center justify-content-between px-2"
        >
          <div>Order Date</div>
          <div class="caret-cover" @click="sortOrdetDate">
            <div
              class="caret-up"
              :class="
                sortBy == 'reform_date' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'reform_date' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>

        <div
          class="border-right-product-table-label label-8 d-flex align-items-center justify-content-between px-2"
        >
          <div>Order Time</div>
          <div class="caret-cover" @click="sortOrdetTime">
            <div
              class="caret-up"
              :class="
                sortBy == 'reform_time' && sortDirection == 'asc'
                  ? 'sort-white'
                  : null
              "
            />

            <div
              class="caret-down"
              :class="
                sortBy == 'reform_time' && sortDirection == 'desc'
                  ? 'sort-white'
                  : null
              "
            />
          </div>
        </div>

        <div class="label-9"></div>
      </div>
      <!--Label-->

      <!--Table-->
      <div
        class="d-flex admin-product-detail"
        v-for="(order, index) in pageAndFilter"
        :key="index"
      >
        <div
          class="border-right-product-table detail-1 d-flex align-items-center justify-content-center"
        >
          <div class="d-flex flex-column align-items-center">
            <div
              :class="order.notification == 'Unread' ? 'unread-order' : null"
            >
              {{ order.id }}
            </div>
          </div>
        </div>
        <div
          class="border-right-product-table detail-2 d-flex align-items-center"
        >
          {{ order.first_name }}
        </div>
        <div
          class="border-right-product-table detail-2 d-flex align-items-center"
        >
          {{ order.last_name }}
        </div>
        <div
          class="border-right-product-table detail-3 d-flex align-items-center"
        >
          Rs.
          {{
            order.order_total.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            })
          }}
        </div>
        <div
          class="border-right-product-table detail-4 d-flex align-items-center justify-content-center"
        >
          {{ order.order_status }}
        </div>
        <div
          class="border-right-product-table detail-5 d-flex align-items-center justify-content-center"
        >
          {{ order.shippment_status }}
        </div>
        <div
          class="border-right-product-table detail-6 d-flex align-items-center justify-content-center"
        >
          {{ order.tracking_number }}
        </div>
        <div
          class="border-right-product-table detail-7 d-flex align-items-center justify-content-center"
        >
          {{ order.order_date }}
        </div>
        <div
          class="border-right-product-table detail-8 d-flex align-items-center justify-content-center"
        >
          {{ order.order_time }}
        </div>

        <div class="detail-9 d-flex align-items-center justify-content-center">
          <router-link :to="'/admin/order/' + order.id">
            <div
              class="after_action d-flex align-items-center justify-content-center"
            >
              <font-awesome-icon icon="search" />
            </div>
          </router-link>
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
import { getOrder } from "@/services/OrderService";
import moment from "moment-timezone";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import {
  getPerPageOptions,
  getOrderStatusOptions,
  getShipmentStatusOptions,
} from "@/services/AdminOptionService";

export default {
  name: "OderList",
  components: { MoonLoader },

  data() {
    return {
      order_status: null,
      order_status_options: [],
      shipment_status: null,
      shipment_status_options: [],

      orders: [],
      page: 0,
      current_page: 1,
      all_pages: null,
      per_page: 10,
      per_page_options: [],

      order_date: null,
      order_total: ["", ""],
      order_total_max: null,

      found_order: "",
      search: "",
      sortBy: "id",
      sortDirection: "asc",

      loading: true,
      loading_2: true,
    };
  },
  computed: {
    pageAndFilter() {
      return this.pageOrders(
        this.sortOrders(
          this.filterOrderStatus(
            this.filterShipmentStatus(
              this.filterOrderTotal(this.filterOrderDate(this.orders))
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
    orders: function () {
      this.checkAll();
    },
    search() {
      const route = {
        name: "OrderList",
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
        this.orders = (await getOrder(value)).data;
        for (let i = 0; i < this.orders.length; i++) {
          this.$set(
            this.orders[i],
            "reform_date",
            Number(
              moment(this.orders[i].order_date, "DD/MM/YYYY").format("YYYYMMDD")
            )
          );
          this.$set(
            this.orders[i],
            "reform_time",
            Number(
              moment(this.orders[i].order_time, "HH:mm:ss A").format("HHmmss")
            )
          );
        }
        this.order_total_max = await Math.max.apply(
          Math,
          this.orders.map((order) => order.order_total)
        );

        this.checkAll();
        this.loading_2 = false;
      },
    },
    order_status() {
      this.checkAll();
    },
    shipment_status() {
      this.checkAll();
    },
    order_date() {
      this.checkAll();
    },
    order_total() {
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

    pageOrders(orders) {
      return orders.slice(
        this.page * this.per_page,
        this.page * this.per_page + this.per_page
      );
    },
    filterOrderStatus(orders) {
      if (this.order_status == null) {
        return orders;
      } else {
        return orders.filter(
          (order) => order.order_status == this.order_status
        );
      }
    },
    filterShipmentStatus(orders) {
      if (this.shipment_status == null) {
        return orders;
      } else {
        return orders.filter(
          (order) => order.shippment_status == this.shipment_status
        );
      }
    },
    filterOrderTotal(orders) {
      if (this.order_total[0] == "" && this.order_total[1] == "") {
        return orders.filter(
          (shipment) =>
            shipment.order_total >= 0 &&
            shipment.order_total <= this.order_total_max
        );
      } else if (this.order_total[0] == "" && this.order_total[1] !== "") {
        return orders.filter(
          (shipment) =>
            shipment.order_total >= 0 &&
            shipment.order_total <= this.order_total[1]
        );
      } else if (this.order_total[0] !== "" && this.order_total[1] == "") {
        return orders.filter(
          (shipment) =>
            shipment.order_total >= this.order_total[0] &&
            shipment.order_total <= this.order_total_max
        );
      } else {
        return orders.filter(
          (shipment) =>
            shipment.order_total >= this.order_total[0] &&
            shipment.order_total <= this.order_total[1]
        );
      }
    },
    filterOrderDate(orders) {
      var new_date = Number(
        moment(this.order_date, "YYYY-MM-DD").format("YYYYMMDD")
      );
      if (this.order_date == null) {
        return orders;
      } else {
        return orders.filter((order) => order.reform_date == new_date);
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
    sortOrdetTotal() {
      if (this.sortBy == "order_total" && this.sortDirection == "asc") {
        this.sortBy = "order_total";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "order_total";
        this.sortDirection = "asc";
      }
    },
    sortOrdetDate() {
      if (this.sortBy == "reform_date" && this.sortDirection == "asc") {
        this.sortBy = "reform_date";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "reform_date";
        this.sortDirection = "asc";
      }
    },
    sortOrdetTime() {
      if (this.sortBy == "reform_time" && this.sortDirection == "asc") {
        this.sortBy = "reform_time";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "reform_time";
        this.sortDirection = "asc";
      }
    },
    sortOrders(orders) {
      return [...orders].sort((p1, p2) => {
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
      const item_length = this.filterOrderStatus(
        this.filterShipmentStatus(
          this.filterOrderTotal(this.filterOrderDate(this.orders))
        )
      ).length;

      this.found_order = item_length;
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
    this.order_status_options = await getOrderStatusOptions();
    this.shipment_status_options = await getShipmentStatusOptions();
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

.marrgin-025 {
  margin-top: 0.25rem;
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
  text-align: center;
  width: 7%;
}

.label-2 {
  text-align: center;
  width: 11%;
}

.label-3 {
  text-align: center;
  width: 9.5%;
}

.label-4 {
  text-align: center;
  width: 12%;
}

.label-5 {
  text-align: center;
  width: 11%;
}

.label-6 {
  text-align: center;
  width: 17%;
}

.label-7 {
  text-align: center;
  width: 9.5%;
}

.label-8 {
  text-align: center;
  width: 9.5%;
}

.label-9 {
  text-align: center;
  width: 2.5%;
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
  width: 9.5%;
  height: 4.5rem;
}

.detail-4 {
  width: 12%;
  height: 4.5rem;
}

.detail-5 {
  width: 11%;
  height: 4.5rem;
}

.detail-6 {
  width: 17%;
  height: 4.5rem;
}

.detail-7 {
  width: 9.5%;
  height: 4.5rem;
}

.detail-8 {
  width: 9.5%;
  height: 4.5rem;
}

.detail-9 {
  width: 2.5%;
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

.action {
  position: absolute;
  right: 0.8rem;
  z-index: 999;
}

.modal-overelay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  opacity: 1;
}

.modal-content {
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
  background-color: #fbfbfb;
  border: 1px solid #7e989c;
  position: relative;
  right: 7.5px;
  top: 25px;
  box-sizing: border-box;
  width: 100px;
  height: 30px;
  overflow: hidden;
}

.action-options {
  padding: 0.31rem;
  color: #384648;
}

.padding-left-text-action {
  padding-left: unset;
  text-align: left;
}

.padding-right-text-action {
  padding-right: unset;
}

.action-delete-options {
  padding: 0.31rem 0rem;
  color: #384648;
  background-color: unset;
  border: unset;
}

.unread-order {
  background-color: #f44336;
  color: #fff;
  height: 1.3rem;
  width: 1.3rem;
  border-radius: 50rem;
  text-align: center;
  padding-top: 0.1rem;
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

.after_action:hover {
  background-color: #e9e9e9;
  border-radius: 1rem;
  border: 1px solid #fff;
}

.after_action {
  cursor: pointer;
  border: 1px solid #fff;
  border-radius: 1rem;
  width: 1.25rem;
  height: 1.25rem;
  color: #384648;
}

.cover_loader {
  height: 75%;
}
</style>
