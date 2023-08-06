<template>
  <div class="padding-under-pagination product-list-page h-100">
    <div class="d-flex justify-content-between admin-product-padding">
      <div class="d-flex align-items-center admin-product-header">
        Order Details
      </div>
      <div
        v-if="!order_information"
        class="d-flex align-items-end">
        <div
          class="admin-order-update"
          @click="editOrder">
          <font-awesome-icon
            icon="pen"
            class="me-1" />
          Update Order
        </div>
      </div>
      <div
        v-if="order_information"
        class="d-flex align-items-end padding_update_save">
        <div
          class="cancel-button"
          @click="cancelUpdate">
          Cancel
        </div>
        <div
          class="save-button ms-2"
          @click="saveOrderInformation">
          Save
        </div>
      </div>
    </div>
    <div
      v-if="loading"
      class="d-flex align-items-center justify-content-center cover_loader">
      <MoonLoader color="#985855" />
    </div>

    <div v-if="!loading">
      <div class="d-flex justify-content-center admin-order-detail-content">
        <div class="order-detail-width">
          <div class="order-detail-header-admin">
            <div class="d-inline pe-3">Order Number:</div>
            <div class="d-inline order-detail-header-number">
              {{ order.id }}
            </div>
          </div>

          <div class="row order-detail-box">
            <div
              class="col-4 d-flex order-detail-padding flex-column text-center">
              <div>Order Date:</div>
              <div class="order-date">{{ order.order_date }}</div>
            </div>
            <div
              class="col-4 d-flex order-detail-padding flex-column text-center">
              <div>Shipment Status:</div>
              <div
                v-if="!order_information"
                class="order-ship-status">
                {{ order.shippment_status }}
              </div>
              <b-form-select
                v-if="order_information"
                v-model="shipment_status"
                :options="shipment_status_options"
                class="product-select-form order_input_select"></b-form-select>
            </div>
            <div
              class="col-4 d-flex order-detail-padding flex-column text-center">
              <div>Order Status:</div>
              <div
                v-if="!order_information"
                class="order-ship-status">
                {{ order.order_status }}
              </div>
              <b-form-select
                v-if="order_information"
                v-model="order_status"
                :options="order_status_options"
                class="product-select-form order_input_select"></b-form-select>
            </div>

            <div class="col-12 text-center order-detail-padding">
              <div class="pe-2">Tracking Number:</div>
              <div
                v-if="!order_information"
                class="order-tracking-number">
                {{ order.tracking_number }}
              </div>
              <input
                v-if="order_information"
                v-model="tracking_number"
                type="text"
                class="tracking_number_input" />
            </div>
          </div>
          <div class="order-detail-section">
            <div class="d-flex justify-content-between label-row">
              <div class="text-center item-col">Item</div>
              <div class="text-center order-price">Price</div>
              <div class="text-center qty-area">Quantity</div>
              <div class="text-center order-total">Total</div>
            </div>
            <div
              v-for="(product, index) in ordered_product"
              :key="index"
              class="d-flex justify-content-between align-items-center padding-item-detail">
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
              <div class="text-center order-price-list">
                <div
                  v-if="product.discount"
                  class="small-full-price">
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
              <div class="text-center qty-area-list">
                {{ product.quantity }}
              </div>
              <div class="text-center order-total-list">
                <div
                  v-if="product.discount"
                  class="big-full-price">
                  Rs.
                  {{
                    (product.quantity * product.price).toLocaleString(
                      undefined,
                      {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      },
                    )
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
              <div class="summary-header">Customer Name:</div>
              <div>{{ order.first_name }} {{ order.last_name }}</div>
            </div>
            <div
              class="col-6 order-summary-padding-2 order-summary-padding-right">
              <div class="summary-header">Email</div>
              <div>
                {{ order.email }}
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
                  <div class="thin-method">Bank:</div>
                  <div class="ms-2">{{ order.payment_bank }}</div>
                </div>
                <div class="d-flex">
                  <div class="thin-method">Account Name:</div>
                  <div class="ms-2">{{ order.payment_account_name }}</div>
                </div>
                <div class="d-flex">
                  <div class="thin-method">Account Details:</div>
                  <div class="ms-2">{{ order.payment_account_detail }}</div>
                </div>
              </div>
            </div>
            <div
              class="col-6 order-summary-padding-2 order-summary-padding-right">
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
                {{ shipping_address.first_name }}
                {{ shipping_address.last_name }}
              </div>
              <div>{{ shipping_address.phone }}</div>
              <div>
                {{ shipping_address.address_1 }},
                {{ shipping_address.address_2 }}
              </div>
              <div>
                {{ shipping_address.city }}, {{ shipping_address.state }}
                {{ shipping_address.postcode }}
              </div>
              <div>{{ shipping_address.country }}</div>
            </div>
            <div
              class="col-6 order-summary-padding-2 order-summary-padding-right">
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
          <router-link to="/admin/order">
            <div class="back-to-order-button">BACK TO MY ORDERS</div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getOrderById, putOrderById } from "@/services/OrderService";
import { getOrderedProductById } from "@/services/OrderedProductService";
import { getShippingAddressById } from "@/services/ShippingAddressService";
import { getBillingAddressById } from "@/services/BillingAddressService";
import {
  getUpdateShipmentStatusOptions,
  getUpdateOrderStatusOptions,
} from "@/services/AdminOptionService";

export default {
  name: "OrderDetail",
  components: { MoonLoader },
  props: { readOrder: Function },

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
      order_information: false,
      order_status: null,
      order_status_options: [],
      shipment_status: null,
      shipment_status_options: [],
      tracking_number: "",
      ordetId: "",
      loading: true,
    };
  },
  watch: {
    async $route() {
      this.orderId = this.$store.state.route.params.orderId;
      this.order = (await getOrderById(this.orderId)).data;
      this.ordered_product = (await getOrderedProductById(this.orderId)).data;
      this.shipping_address = (await getShippingAddressById(this.orderId)).data;
      this.billing_address = (await getBillingAddressById(this.orderId)).data;

      this.order_status = this.order.order_status;
      this.order_status_options = await getUpdateOrderStatusOptions();
      this.shipment_status = this.order.shippment_status;
      this.shipment_status_options = await getUpdateShipmentStatusOptions();
      this.tracking_number = this.order.tracking_number;

      this.readOrder(this.orderId);
    },
  },
  async mounted() {
    this.orderId = this.$store.state.route.params.orderId;

    this.order = (await getOrderById(this.orderId)).data;
    this.ordered_product = (await getOrderedProductById(this.orderId)).data;
    this.shipping_address = (await getShippingAddressById(this.orderId)).data;
    this.billing_address = (await getBillingAddressById(this.orderId)).data;

    this.order_status = this.order.order_status;
    this.order_status_options = await getUpdateOrderStatusOptions();
    this.shipment_status = this.order.shippment_status;
    this.shipment_status_options = await getUpdateShipmentStatusOptions();
    this.tracking_number = this.order.tracking_number;

    this.readOrder(this.orderId);
    this.loading = false;
  },
  methods: {
    async editOrder() {
      this.order_information = true;
    },
    async cancelUpdate() {
      this.order_information = false;
      this.order_status = this.order.order_status;
      this.shipment_status = this.order.shippment_status;
      this.tracking_number = this.order.tracking_number;
    },
    async saveOrderInformation() {
      const orderId = this.$store.state.route.params.orderId;
      this.order.order_status = this.order_status;
      this.order.shippment_status = this.shipment_status;
      this.order.tracking_number = this.tracking_number;
      await putOrderById(orderId, this.order);
    },
  },
};
</script>

<style scoped>
.admin-order-detail-content {
  padding-top: 2rem;
  padding-bottom: 2rem;
}

.order-detail-width {
  width: 50%;
}

.order-detail-header-admin {
  font-size: 1.75rem;
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

.admin-order-update {
  background-color: #985855;
  color: #fff;
  padding: 0.5rem 1rem 0.4rem 1rem;
  cursor: pointer;
  user-select: none;
  margin-bottom: 0.75rem;
  border-radius: 0.5rem;
}

.save-button {
  background: #985855;
  border-radius: 0.5rem;
  text-align: center;
  color: #fff;
  font-size: 0.95rem;
  font-weight: 500;
  padding: 0.3rem 0rem 0.2rem 0rem;
  width: 4rem;
  cursor: pointer;
  border: 1px solid #985855;
}

.cancel-button {
  background: #fff;
  border-radius: 0.5rem;
  text-align: center;
  color: #985855;
  font-size: 0.95rem;
  font-weight: 500;
  border: 1px solid #985855;
  padding: 0.3rem 0rem 0.2rem 0rem;
  width: 4rem;
  cursor: pointer;
}

.padding_update_save {
  padding-bottom: 0.75rem;
}

.tracking_number_input {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.25rem 0.5rem;
  text-align: center;
}

.tracking_number_input:focus-visible {
  border: 1px solid #b9b9b9;
  outline: unset;
}

.order_input_select {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.45rem 0.5rem 0.4rem 0.5rem;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background: #fff url("../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px;
  font-size: 0.75rem;
}

.cover_loader {
  height: 75%;
}
</style>
