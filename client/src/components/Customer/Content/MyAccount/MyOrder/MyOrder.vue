<template
  ><div class="col-9 d-flex justify-content-center orders-content">
    <div class="orders-width">
      <div class="row head-search-orders">
        <div class="col-6 orders-header">My Orders</div>
        <div class="col-6 align-self-end orders-search-box">
          <input
            type="text"
            class="orders-search"
            placeholder="Search your orders"
          />
        </div>
      </div>

      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader "
      >
        <MoonLoader color="#985855" />
      </div>

      <div v-if="!loading">
        <div
          class="padding-orders-section"
          v-for="(order, index) in orders"
          :key="index"
        >
          <div class="orders-box">
            <div class="orders-box-title">
              <div class="d-inline pe-2">Order Number:</div>
              <div class="d-inline orders-box-number">{{ order.id }}</div>
            </div>
            <div class="row orders-detail-box">
              <div
                class="col-4 d-flex orders-detail-padding flex-column text-center"
              >
                <div>Order Date:</div>
                <div class="orders-date-and-total">{{ order.order_date }}</div>
              </div>
              <div
                class="col-4 d-flex orders-detail-padding flex-column text-center"
              >
                <div>Order Total:</div>
                <div class="orders-date-and-total">
                  Rs.
                  {{
                    order.order_total.toLocaleString(undefined, {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2,
                    })
                  }}
                </div>
              </div>
              <div
                class="col-4 d-flex orders-detail-padding flex-column text-center"
              >
                <div>Order Status:</div>
                <div class="orders-status">{{ order.order_status }}</div>
              </div>

              <div
                class="col-12 d-flex justify-content-center orders-detail-padding"
              >
                <div class="pe-2">Tracking Number:</div>
                <div class="orders-tracking-number">
                  {{ order.tracking_number }}
                </div>
              </div>
            </div>
          </div>
          <router-link :to="'/myaccount/order/' + order.id">
            <div class="orders-view-button">
              VIEW ORDER DETAILS
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getOrderByEmail } from "@/services/OrderService";
export default {
  name: "MyOrder",
  components: { MoonLoader },
  data() {
    return {
      orders: [],
      loading: true,
    };
  },
  async mounted() {
    const customerEmail = this.$store.state.customer.email;
    this.orders = (await getOrderByEmail({ email: customerEmail })).data;
    this.loading = false;
  },
};
</script>

<style scoped>
.orders-content {
  padding-top: 3rem;
  padding-bottom: 3rem;
  width: 80%;
}

.orders-header {
  font-size: 2.25rem;
  font-weight: 500;
  padding-bottom: 1.75rem;
  letter-spacing: 0.25px;
  padding-right: unset;
  padding-left: unset;
}

.padding-orders-section {
  padding-top: 1.75rem;
  padding-bottom: 2.5rem;
  border-bottom: 1px solid #b9b9b9;
}

.orders-width {
  width: 50%;
}

.head-search-orders {
  border-bottom: 1px solid #384648;
  margin-left: unset;
  margin-right: unset;
}

.orders-search {
  border-radius: 2.5rem;
  border: 1px solid #384648;
  width: 80%;
  padding: 0.2rem 1.25rem;
  font-size: 0.95rem;
}

.orders-search:focus-visible {
  border: 1px solid #384648;
  outline: none;
}

.orders-search-box {
  padding-bottom: 1rem;
  text-align: right;
  padding-right: unset;
  padding-left: unset;
}

.orders-view-button {
  background: #985855;
  border-radius: 0.5rem;
  text-align: center;
  color: #fff;
  font-size: 1.2rem;
  font-weight: 500;
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
}

.orders-box {
  border: 1px solid #384648;
  border-radius: 0.5rem;
  margin-bottom: 0.75rem;
}

.orders-box-title {
  border-bottom: 1px solid #384648;
  padding: 0.5rem 0 0.5rem 1rem;
  background-color: #fff9fb;
  border-radius: 0.5rem 0.5rem 0 0;
  font-weight: 700;
  font-size: 1.1rem;
}

.orders-detail-padding {
  padding-bottom: 0.75rem;
}

.orders-box-number {
  color: #985855;
}

.orders-detail-box {
  padding: 0.75rem 1rem 0 1rem;
}

.orders-tracking-number {
  color: #3665f3;
}

.orders-date-and-total {
  color: #985855;
  font-weight: 500;
}

.orders-status {
  font-weight: 500;
  color: #62832d;
}

.cover_loader {
  height: 100%;
}
</style>
