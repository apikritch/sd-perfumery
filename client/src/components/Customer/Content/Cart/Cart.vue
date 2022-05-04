<template>
  <div class="container-lg cart-page">
    <div class="d-flex justify-content-between cart-title align-items-center">
      <div class="cart-header">
        TOTAL
        <div class="px-1 d-inline cart-item-number">{{ cartQty }}</div>
        ITEMS IN CART
      </div>
      <div>
        <router-link to="/shop">
          <div class="continue-shopping-button d-inline me-3">
            CONTINUE SHPOPING
          </div>
        </router-link>
        <router-link to="/checkout">
          <div class="proceed-checkout-button d-inline">
            PROCEED TO CHECKOUT
          </div>
        </router-link>
      </div>
    </div>
    <div class="row order-detail-section-padding">
      <div class="col-8 order-detail-section-border-left">
        <div class="d-flex justify-content-between label-row">
          <div class="text-center item-col">Item</div>
          <div class="text-center order-price">Price</div>
          <div class="text-center qty-area">Quantity</div>
          <div class="text-center order-total">Total</div>
          <div class="text-center order-action"></div>
        </div>
        <div
          class="d-flex justify-content-between align-items-center padding-item-detail"
          v-for="(item, index) in cart"
          :key="index"
        >
          <div class="item-col">
            <div class="d-flex align-items-center">
              <div class="order-image-col">
                <img :src="item.product.image" width="100%" />
              </div>
              <div class="order-title-col">
                {{ item.product.title }} | {{ item.product.type }} |
                {{ item.product.gender }} - {{ item.product.size }} ml by
                {{ item.product.brand }}
              </div>
            </div>
          </div>
          <div class="text-center order-price-list">
            <div class="font-not-discount" v-if="item.product.discount">
              {{
                item.product.price.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
              }}
            </div>
            <div
              class="font-discount"
              :class="item.product.discount ? 'total-saving' : null"
            >
              {{
                item.product.final_price.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
              }}
            </div>
          </div>
          <div class="text-center qty-area-list">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div
                class="circle-minus d-flex justify-content-center align-items-center"
                @click="deleteItemInCart(index)"
              >
                <font-awesome-icon icon="minus" class="w-100" />
              </div>
              <div class="px-3 qty-text">
                <div class="product-input-qty">
                  <div class="qty-move">{{ item.qty }}</div>
                </div>
              </div>
              <div
                class="circle-plus d-flex justify-content-center align-items-center"
                @click="addItemToCart(item.product, 1)"
              >
                <font-awesome-icon icon="plus" class="w-100" />
              </div>
            </div>
          </div>
          <div class="text-center order-total-list">
            <div class="order-total-no-discount" v-if="item.product.discount">
              {{
                (item.qty * item.product.price).toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
              }}
            </div>
            <div
              class="order-total-discount"
              :class="item.product.discount ? 'total-saving' : null"
            >
              {{
                (item.qty * item.product.final_price).toLocaleString(
                  undefined,
                  {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  }
                )
              }}
            </div>
          </div>
          <div class="text-center order-action-list">
            <div
              class="cart-remove-item d-flex justify-content-center align-items-center"
              @click="removeItemInCart(index)"
            >
              <font-awesome-icon icon="times" />
            </div>
          </div>
        </div>
      </div>
      <div class="col-4 order-detail-section-border-right">
        <div class="d-flex justify-content-between">
          <div>Subtotal:</div>
          <div class="total-summary">
            Rs.
            {{
              total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
            }}
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div>Total Savings:</div>
          <div
            class="total-summary"
            :class="total - cartTotal !== 0 ? 'total-saving' : null"
          >
            Rs.
            {{
              (total - cartTotal).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
            }}
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div>Shipping:</div>
          <div class="total-shipping">Calculated at checkout</div>
        </div>
        <div class="d-flex justify-content-between summary-price-border">
          <div>Order Total:</div>
          <div class="grand-total-summary">
            Rs.
            <div class="d-inline ps-1 summary-price-color">
              {{
                cartTotal.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
              }}
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end proceed-checkout-button-bottom">
          <router-link to="/checkout">
            <div class="proceed-checkout-button proceed-checkout-button">
              PROCEED TO CHECKOUT
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MyCart",
  props: {
    cart: Array,
    total: Number,
    cartQty: Number,
    cartTotal: Number,
    addItemToCart: Function,
    deleteItemInCart: Function,
    removeItemInCart: Function,
  },
};
</script>

<style scoped>
.cart-page {
  padding-top: 2.5rem;
  padding-bottom: 3rem;
}

.cart-title {
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #384648;
}

.cart-header {
  font-size: 1.6rem;
  font-weight: 500;
}

.cart-item-number {
  color: #e7717d;
}

.proceed-checkout-button {
  background: #985855;
  border-radius: 0.5rem;
  text-align: center;
  color: #fff;
  font-size: 0.95rem;
  font-weight: 500;
  padding: 0.6rem 1rem 0.5rem 1rem;
}

.proceed-checkout-button:hover {
  background: #814643;
}

.continue-shopping-button {
  background: #fff;
  border-radius: 0.5rem;
  text-align: center;
  color: #985855;
  font-size: 0.95rem;
  font-weight: 500;
  border: 1px solid #985855;
  padding: 0.6rem 1rem 0.5rem 1rem;
}

.continue-shopping-button:hover {
  background: #fff9fb;
}

.label-row {
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
  font-weight: 500;
}

.item-col {
  width: 45%;
}

.order-total {
  width: 17.5%;
}

.order-price {
  width: 17.5%;
}

.qty-area {
  width: 15%;
}

.order-action {
  width: 5%;
}

.order-total-list {
  width: 17.5%;
  font-size: 1rem;
  font-weight: 500;
}

.order-total-no-discount {
  font-size: 0.85rem;
  font-weight: 400;
  text-decoration: line-through;
}

.order-total-discount {
  font-size: 1rem;
  font-weight: 500;
}

.order-price-list {
  width: 17.5%;
}

.font-discount {
  font-size: 0.95rem;
}

.font-not-discount {
  font-size: 0.75rem;
  text-decoration: line-through;
}

.qty-area-list {
  width: 15%;
  font-size: 0.9rem;
}

.order-action-list {
  width: 5%;
  font-size: 0.95rem;
  font-weight: 500;
}

.padding-item-detail {
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #384648;
}

.order-image-col {
  width: 25%;
}

.order-image-col img {
  object-fit: cover;
  height: 5.5rem;
}

.order-title-col {
  padding-left: 0.5rem;
  width: 75%;
  font-size: 0.95rem;
  font-weight: 500;
}

.circle-minus,
.circle-plus {
  width: 1.1rem;
  height: 1.1rem;
  font-size: 0.7rem;
  border-radius: 50%;
  border: 1px solid rgba(0, 0, 0, 0.25);
  background-color: white;
  color: #985855;
  cursor: pointer;
  user-select: none;
}

.circle-minus:hover,
.circle-plus:hover {
  background-color: #fcedf2;
}

.qty-text {
  font-weight: 500;
  font-size: 1.1rem;
  user-select: none;
}

.product-input-qty {
  width: 2.5rem;
  height: 1.6rem;
  border-radius: 0.5rem;
  outline: unset;
  border: 1px solid #384648;
  text-align: center;
  background-color: rgba(239, 239, 239, 0.3);
  color: rgb(84, 84, 84);
  font-size: 0.95rem;
  padding-top: 0.1rem;
}

.qty-move {
  position: relative;
}

.cart-remove-item {
  color: #384648;
  border-radius: 10px;
  display: inline-block;
  width: 1.1rem;
  height: 1.1rem;
  font-size: 0.65rem;
  cursor: pointer;
}

.cart-remove-item:hover {
  background-color: #ecf3ff;
}

.order-detail-section-border-left {
  padding-right: calc(var(--bs-gutter-x) * 1);
  border-right: 1px solid #384648;
}

.order-detail-section-border-right {
  padding-left: calc(var(--bs-gutter-x) * 1);
}

.order-detail-section-padding {
  padding-top: 1.75rem;
}

.total-summary {
  font-weight: 500;
  margin-bottom: 1.25rem;
}

.total-shipping {
  font-weight: 400;
  margin-bottom: 1.25rem;
  color: #6c757d;
}

.grand-total-summary {
  font-weight: 700;
  font-size: 1.5rem;
}

.summary-price-color {
  color: #985855;
}

.summary-price-border {
  border-bottom: 1px solid #384648;
}

.proceed-checkout-button-bottom {
  padding-top: 1.5rem;
}

.total-saving {
  color: #f44336;
}
</style>
