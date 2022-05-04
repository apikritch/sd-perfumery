<template>
  <div class="padding-under-pagination user-list-page brand-list h-100">
    <div class="d-flex justify-content-between pt-2 admin-product-padding">
      <div class="d-flex align-items-center admin-product-header">
        Dashboard
      </div>
      <div class="d-flex align-items-end"></div>
    </div>
    <div
      v-if="loading"
      class="d-flex align-items-center justify-content-center cover_loader"
    >
      <MoonLoader color="#985855" />
    </div>
    <div class="cover_dash_content" v-if="!loading">
      <div class="row">
        <div class="col-3">
          <div class="shadow_card">
            <div class="card_dash_header">Customers</div>
            <div class="d-flex justify-content-between pt-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="users" />
              </div>
              <div class="text_dash">{{ customers.length }}</div>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="shadow_card">
            <div class="card_dash_header">Users</div>
            <div class="d-flex justify-content-between pt-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="user-circle" />
              </div>
              <div class="text_dash">{{ users.length }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <div class="shadow_card">
            <div class="card_dash_header">Orders</div>
            <div class="d-flex justify-content-between pt-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="store" />
              </div>
              <div class="text_dash">{{ orders.length }}</div>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="shadow_card">
            <div class="card_dash_header">Completed Orders</div>
            <div class="d-flex justify-content-between pt-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="check-circle" />
              </div>
              <div class="text_dash">{{ completedOrders.length }}</div>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="shadow_card">
            <div class="card_dash_header">Product Sold</div>
            <div class="d-flex justify-content-between pt-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="box" />
              </div>
              <div class="text_dash">{{ orderedProducts }}</div>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="shadow_card">
            <div class="card_dash_header">Sales</div>
            <div class="d-flex justify-content-between pt-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="coins" />
              </div>
              <div class="text_dash">Rs. {{ sales }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="shadow_card_top">
            <div class="card_dash_header d-flex mb-2">
              <div>
                <font-awesome-icon class="icon_dash_size" icon="fire" />
              </div>
              <div class="ps-3">Top 5 Sales</div>
            </div>
            <div class="pt-2 align-items-center">
              <div class="mb-2 top_head_dash border-bottom">
                <div class="row">
                  <div class="col-1 text-center">ID</div>
                  <div class="col-9 text-center">Products</div>
                  <div class="col-2 text-center">Sold</div>
                </div>
              </div>
              <div
                class="row detail_text_dash"
                v-for="(product, index) in topFiveProducts"
                :key="index"
              >
                <div class="col-1 text-center">{{ product.product.id }}</div>
                <div class="col-9">
                  <div>
                    {{ product.product.title }} | {{ product.product.type }} |
                    {{ product.product.genger }} - {{ product.product.size }} ml
                    by
                    {{ product.product.brand }}
                  </div>
                </div>
                <div class="col-2 text-end text_dash text-center">
                  <div>{{ product.qty }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="shadow_card">
            <div class="card_dash_header mb-3 d-flex justify-content-between">
              <div>Weekly Sales</div>
              <div>
                <font-awesome-icon
                  icon="chevron-left"
                  class="me-2 cursor_pointer"
                  @click="goBackWeek"
                />
                <font-awesome-icon
                  icon="chevron-right"
                  class="ms-2 cursor_pointer"
                  @click="goNextWeek"
                />
              </div>
            </div>
            <div v-if="orders.length > 0 && timestamp_1">
              <LineChartWeek
                :orders="orders"
                :timestamp="timestamp_1"
              ></LineChartWeek>
            </div>
          </div>
        </div>
        <div class="col-8">
          <div class="shadow_card">
            <div class="card_dash_header mb-3 d-flex justify-content-between">
              <div>Mouthly Sales</div>
              <div>
                <font-awesome-icon
                  icon="chevron-left"
                  class="me-2 cursor_pointer"
                  @click="goBackMonth"
                />
                <font-awesome-icon
                  icon="chevron-right"
                  class="ms-2 cursor_pointer"
                  @click="goNextMonth"
                />
              </div>
            </div>
            <div v-if="orders.length > 0 && timestamp_2">
              <LineChartMonth
                :orders="orders"
                :timestamp="timestamp_2"
              ></LineChartMonth>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="shadow_card">
            <div class="card_dash_header">Annual Sales</div>
            <div v-if="dashboard_year.length > 0">
              <LineChartYear :dashboard_year="dashboard_year"></LineChartYear>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getUsers } from "@/services/AdminUserService";
import { getCustomers } from "@/services/CustomerService";
import { getOrder } from "@/services/OrderService";
import { getOrderedProducts } from "@/services/OrderedProductService";
import { getYearly } from "@/services//DashboardService";
import LineChartYear from "./LineChartYear.vue";
import LineChartWeek from "./LineChartWeek.vue";
import LineChartMonth from "./LineChartMonth.vue";
import moment from "moment-timezone";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

export default {
  name: "DashBoard",
  components: { LineChartYear, LineChartWeek, LineChartMonth, MoonLoader },
  //components: { MoonLoader },

  data() {
    return {
      users: [],
      customers: [],
      orders: [],
      ordered_products: [],
      sum_ordered_products: 0,
      sum_sales: 0,
      sum_products: [],
      dashboard_year: [],
      timestamp_1: "",
      timestamp_2: "",
      loading: true,
    };
  },
  computed: {
    orderedProducts() {
      return this.quantityOrderedProducts(this.ordered_products);
    },
    sales() {
      return this.sumSales(this.orders);
    },
    completedOrders() {
      return this.findCompltedOrders(this.orders);
    },
    topFiveProducts() {
      return this.sliceProducts(
        this.sortProductsByQty(this.findTopFiveProducts(this.ordered_products))
      );
    },
  },
  methods: {
    goNextWeek() {
      const time_now = new Date(this.timestamp_1);
      var next_week = moment(time_now.setDate(time_now.getDate() + 7)).format(
        "YYYY,MM,DD"
      );
      var to_time_stamp = new Date(next_week);
      this.timestamp_1 = Number(to_time_stamp);
    },

    goBackWeek() {
      const time_now = new Date(this.timestamp_1);
      var last_week = moment(time_now.setDate(time_now.getDate() - 7)).format(
        "YYYY,MM,DD"
      );
      var to_time_stamp = new Date(last_week);
      this.timestamp_1 = Number(to_time_stamp);
    },
    goNextMonth() {
      const time_now = new Date(this.timestamp_2);
      var next_month = new Date(
        time_now.getFullYear(),
        time_now.getMonth() + 1,
        1
      );
      var to_time_stamp = new Date(moment(next_month).format("YYYY,MM,DD"));
      this.timestamp_2 = Number(to_time_stamp);
    },

    goBackMonth() {
      const time_now = new Date(this.timestamp_2);
      var last_month = new Date(
        time_now.getFullYear(),
        time_now.getMonth() - 1,
        1
      );
      var to_time_stamp = new Date(moment(last_month).format("YYYY,MM,DD"));
      this.timestamp_2 = Number(to_time_stamp);
    },

    quantityOrderedProducts(ordered_products) {
      for (let i = 0; i < ordered_products.length; i++) {
        this.sum_ordered_products =
          this.sum_ordered_products + ordered_products[i].quantity;
      }
      return this.sum_ordered_products;
    },
    sumSales(orders) {
      for (let i = 0; i < orders.length; i++) {
        this.sum_sales = this.sum_sales + orders[i].order_total;
      }
      return this.sum_sales.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
    },
    findCompltedOrders(orders) {
      return orders.filter((order) => order.order_status == "Completed");
    },
    findTopFiveProducts(ordered_products) {
      for (let i = 0; i < ordered_products.length; i++) {
        var whichProduct;

        var existing = this.sum_products.filter((item, index) => {
          if (
            item.product.product_id == Number(ordered_products[i].product_id)
          ) {
            whichProduct = index;
            return true;
          } else {
            return false;
          }
        });

        if (existing.length) {
          this.sum_products[whichProduct].qty =
            this.sum_products[whichProduct].qty + ordered_products[i].quantity;
        } else {
          this.sum_products.push({
            product: ordered_products[i],
            qty: ordered_products[i].quantity,
          });
        }
      }
      return this.sum_products;
    },
    sliceProducts(sum_products) {
      return sum_products.slice(0, 5);
    },
    sortProductsByQty(sum_products) {
      return [...sum_products].sort((p1, p2) => {
        if (p1["qty"] < p2["qty"]) {
          return 1;
        }

        if (p1["qty"] > p2["qty"]) {
          return -1;
        }

        return 0;
      });
    },
  },

  async mounted() {
    this.timestamp_1 = Date.now();
    this.timestamp_2 = Date.now();
    this.users = (await getUsers()).data;
    this.customers = (await getCustomers()).data;
    this.orders = (await getOrder()).data;
    this.ordered_products = (await getOrderedProducts()).data;
    this.dashboard_year = (await getYearly()).data;
    this.loading = false;
  },
};
</script>

<style scoped>
.shadow_card {
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
  margin-top: calc(var(--bs-gutter-x) * 0.5);
  margin-bottom: calc(var(--bs-gutter-x) * 0.5);
  padding: 1rem;
}

.shadow_card_top {
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
  margin-top: calc(var(--bs-gutter-x) * 0.5);
  margin-bottom: calc(var(--bs-gutter-x) * 0.5);
  padding: 1rem 1rem 0.5rem 1rem;
}

.cover_dash_content {
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.card_dash_header {
  font-weight: 700;
  font-size: 1.25rem;
}

.icon_dash_size {
  font-size: 2rem;
}
.text_dash {
  font-size: 1.1rem;
  font-weight: 500;
  color: #985855;
}

.top_head_dash {
  font-weight: 500;
}

.detail_text_dash {
  padding-bottom: 0.5rem;
}

.cursor_pointer {
  cursor: pointer;
}

.cover_loader {
  height: 75%;
}
</style>
