<template>
  <div class="col-9 d-flex justify-content-center order-detail-content">
    <div
      v-if="loading"
      class="d-flex align-items-center justify-content-center cover_loader "
    >
      <MoonLoader color="#985855" />
    </div>

    <div v-if="!loading">
      <div class="order-detail-width">
        <div class="order-detail-header">
          <div class="d-inline pe-3">Order Number:</div>
          <div class="d-inline order-detail-header-number">{{ order.id }}</div>
        </div>

        <div class="row order-detail-box">
          <div
            class="col-4 d-flex order-detail-padding flex-column text-center"
          >
            <div>Order Date:</div>
            <div class="order-date">{{ order.order_date }}</div>
          </div>
          <div
            class="col-4 d-flex order-detail-padding flex-column text-center"
          >
            <div>Shipment Status:</div>
            <div class="order-ship-status">{{ order.shippment_status }}</div>
          </div>
          <div
            class="col-4 d-flex order-detail-padding flex-column text-center"
          >
            <div>Order Status:</div>
            <div class="order-ship-status">{{ order.order_status }}</div>
          </div>

          <div class="col-12 text-center order-detail-padding">
            <div class="pe-2">Tracking Number:</div>
            <div class="order-tracking-number">{{ order.tracking_number }}</div>
          </div>
        </div>
        <div class="order-detail-section">
          <div class="d-flex justify-content-between label-row">
            <div class="text-center item-col">
              Item
            </div>
            <div class="text-center order-price">Price</div>
            <div class="text-center qty-area">Quantity</div>
            <div class="text-center order-total">Total</div>
          </div>
          <div
            class="d-flex justify-content-between align-items-center padding-item-detail"
            v-for="(product, index) in ordered_product"
            :key="index"
          >
            <div class="item-col">
              <div class="d-flex align-items-center">
                <div class="order-image-col">
                  <img :src="product.image" />
                </div>
                <div class="order-title-col">
                  {{ product.title }} | {{ product.type }} |
                  {{ product.gender }} - {{ product.size }} by
                  {{ product.brand }}
                </div>
              </div>
            </div>
            <div class="text-center order-price-list ">
              <div v-if="product.discount" class="small-full-price ">
                Rs.
                {{
                  product.price.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  })
                }}
              </div>
              <div :class="product.discount ? 'red-text' : null">
                Rs.
                {{
                  product.final_price.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  })
                }}
              </div>
            </div>
            <div class="text-center qty-area-list ">{{ product.quantity }}</div>
            <div class="text-center order-total-list ">
              <div v-if="product.discount" class="big-full-price">
                Rs.
                {{
                  (product.quantity * product.price).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  })
                }}
              </div>
              <div :class="product.discount ? 'red-text' : null">
                Rs.
                {{
                  product.total.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  })
                }}
              </div>
            </div>
          </div>
        </div>

        <div class="row order-summary-box">
          <div class="col-6 order-summary-padding order-summary-padding-left">
            <div class="summary-header">Shipping Method</div>
            <div>{{ order.shipping_method }}</div>
            <div class="border-method">
              <div class="summary-header">Payment Method</div>
              <div class="d-flex">
                <div class="thin-method">
                  Bank:
                </div>
                <div class="ms-2">{{ order.payment_bank }}</div>
              </div>
              <div class="d-flex">
                <div class="thin-method">
                  Account Name:
                </div>
                <div class="ms-2">{{ order.payment_account_name }}</div>
              </div>
              <div class="d-flex">
                <div class="thin-method">
                  Account Details:
                </div>
                <div class="ms-2">{{ order.payment_account_detail }}</div>
              </div>
            </div>
          </div>
          <div
            class="col-6 order-summary-padding-2 order-summary-padding-right"
          >
            <div class="h-100 d-flex align-content-between flex-wrap">
              <div class="w-100">
                <div class="summary-header">Order Total</div>
                <div class="d-flex justify-content-between">
                  <div class="summary-small-label">Subtotal:</div>
                  <div>
                    Rs.
                    {{
                      order.subtotal.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      })
                    }}
                  </div>
                </div>
                <div class="d-flex justify-content-between">
                  <div class="summary-small-label">Total Savings:</div>
                  <div :class="order.total_saving > 0 ? 'red-text' : null">
                    Rs.
                    {{
                      order.total_saving.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      })
                    }}
                  </div>
                </div>
                <div class="d-flex justify-content-between">
                  <div class="summary-small-label">Shipping:</div>
                  <div>
                    Rs.
                    {{
                      order.shipping_fee.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      })
                    }}
                  </div>
                </div>
              </div>
              <div class="w-100">
                <div class="d-flex justify-content-between summary-total">
                  <div>Total:</div>
                  <div class="summary-total-color">
                    Rs.
                    {{
                      order.order_total.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      })
                    }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row order-summary-box">
          <div class="col-6 order-summary-padding order-summary-padding-left">
            <div class="summary-header">Delivery Address</div>
            <div>
              {{ shipping_address.first_name }} {{ shipping_address.last_name }}
            </div>
            <div>{{ shipping_address.phone }}</div>
            <div>
              {{ shipping_address.address_1 }}, {{ shipping_address.address_2 }}
            </div>
            <div>
              {{ shipping_address.city }}, {{ shipping_address.state }}
              {{ shipping_address.postcode }}
            </div>
            <div>{{ shipping_address.country }}</div>
          </div>
          <div
            class="col-6 order-summary-padding-2 order-summary-padding-right"
          >
            <div class="summary-header">Billing Address</div>
            <div>
              {{ billing_address.first_name }} {{ billing_address.last_name }}
            </div>
            <div>{{ billing_address.phone }}</div>
            <div>
              {{ billing_address.address_1 }}, {{ billing_address.address_2 }}
            </div>
            <div>
              {{ billing_address.city }}, {{ billing_address.state }}
              {{ billing_address.postcode }}
            </div>
            <div>{{ billing_address.country }}</div>
          </div>
        </div>
        <router-link to="/myaccount/order">
          <div class="back-to-order-button">
            BACK TO MY ORDERS
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getOrderDetailByEmail } from "@/services/OrderService";
import { getOrderedProductById } from "@/services/OrderedProductService";
import { getShippingAddressById } from "@/services/ShippingAddressService";
import { getBillingAddressById } from "@/services/BillingAddressService";

export default {
  name: "OrderDetail",
  components: { MoonLoader },
  data() {
    return {
      order: {
        id: "",
        order_date: "",
        shippment_status: "",
        order_status: "",
        tracking_number: "",
        shipping_method: "",
        payment_bank: "",
        payment_account_name: "",
        payment_account_detail: "",
        subtotal: "",
        total_saving: "",
        shipping_fee: "",
        order_total: "",
      },
      ordered_product: [],
      shipping_address: {
        address_1: "",
        address_2: "",
        city: "",
        country: "",
        first_name: "",
        id: "",
        last_name: "",
        order_id: "",
        phone: "",
        postcode: "",
        state: "",
      },
      billing_address: {
        address_1: "",
        address_2: "",
        city: "",
        country: "",
        first_name: "",
        id: "",
        last_name: "",
        order_id: "",
        phone: "",
        postcode: "",
        state: "",
      },
      loading: true,
    };
  },
  async mounted() {
    const orderId = this.$store.state.route.params.orderId;
    const customerEmail = this.$store.state.customer.email;
    this.order = (
      await getOrderDetailByEmail(orderId, { email: customerEmail })
    ).data;
    this.ordered_product = (await getOrderedProductById(orderId)).data;
    this.shipping_address = (await getShippingAddressById(orderId)).data;
    this.billing_address = (await getBillingAddressById(orderId)).data;
    this.loading = false;
  },
};
</script>

<style scoped>
.order-detail-content {
  padding-top: 3rem;
  padding-bottom: 3rem;
  width: 80%;
}

/*.order-detail-width {
  width: 50%;
}*/

.order-detail-header {
  font-size: 2.25rem;
  font-weight: 500;
  padding-bottom: 1.75rem;
  border-bottom: 1px solid #384648;
  letter-spacing: 0.25px;
}

.order-detail-header-number {
  color: #985855;
}

.order-detail-box {
  padding: 0rem 1rem 0 1rem;
  margin-right: unset;
  margin-left: unset;
  padding-left: unset;
  padding-right: unset;
}

.order-detail-padding {
  padding-bottom: 1rem;
  padding-top: 1rem;
  border-bottom: 1px solid #dee2e6;
}

.order-date {
  color: #985855;
  font-weight: 500;
}

.order-ship-status {
  font-weight: 500;
  color: #62832d;
}

.order-tracking-number {
  color: #3665f3;
}

.order-detail-section {
  padding: 1.5rem 0 1.5rem 0;
}

.label-row {
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
  font-weight: 500;
}

.item-col {
  width: 42.5%;
}

.order-total {
  width: 22.5%;
}

.order-price {
  width: 22.5%;
}

.qty-area {
  width: 12.5%;
}

.order-total-list {
  width: 22.5%;
  font-size: 0.9rem;
  font-weight: 500;
}

.order-price-list {
  width: 22.5%;
  font-size: 0.8rem;
}

.qty-area-list {
  width: 12.5%;
  font-size: 0.9rem;
}

.padding-item-detail {
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #dee2e6;
}

.order-image-col {
  width: 30%;
}

.order-image-col img {
  object-fit: cover;
  height: 4.5rem;
}

.order-title-col {
  padding-left: 0.5rem;
  width: 70%;
  font-size: 0.75rem;
  font-weight: 500;
}

.order-summary-padding-right {
  padding-right: unset;
  padding-left: calc(var(--bs-gutter-x) * 0.75);
}

.order-summary-padding-left {
  padding-left: unset;
  border-right: 1px solid #384648;
  padding-right: calc(var(--bs-gutter-x) * 0.75);
}

.order-summary-box {
  margin-right: unset;
  margin-left: unset;
  border-bottom: 1px solid #dee2e6;
  padding-bottom: 1.75rem;
  margin-bottom: 1.75rem;
}

.test {
  position: relative;
}

.summary-header {
  font-weight: 500;
  font-size: 1rem;
  padding-bottom: 0.75rem;
  color: #985855;
  font-weight: 700;
}

.order-summary-padding {
  font-size: 0.9rem;
  font-weight: 500;
}

.order-summary-padding-2 {
  font-size: 0.85rem;
  font-weight: 500;
}

.summary-small-label {
  font-weight: 400;
}

.summary-total {
  font-size: 1.1rem;
}

.summary-total-color {
  color: #985855;
}

.back-to-order-button {
  background: #985855;
  border-radius: 0.5rem;
  text-align: center;
  color: #fff;
  font-size: 1.2rem;
  font-weight: 500;
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
}

.border-method {
  border-top: 1px solid #dee2e6;
  padding-top: 0.5rem;
  margin-top: 0.5rem;
}

.thin-method {
  font-weight: 400;
}

.red-text {
  color: #f44336;
}

.small-full-price {
  font-size: 0.75rem;
  font-weight: 400;
  text-decoration: line-through;
}

.big-full-price {
  font-size: 0.85rem;
  font-weight: 400;
  text-decoration: line-through;
}

.cover_loader {
  height: 100%;
}
</style>
