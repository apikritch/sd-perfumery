<template>
  <div class="container product-layout pb-4 mb-2">
    <div class="product-breadcrum d-flex">
      <div>Home</div>
      <div class="mx-2">/</div>
      <div>Shop</div>
      <div class="mx-2">/</div>
      <div>{{ product.gender }}</div>
    </div>

    <div
      v-if="loading"
      class="d-flex align-items-center justify-content-center cover_loader">
      <MoonLoader color="#985855" />
    </div>

    <div v-if="!loading">
      <router-link
        :to="'/admin/product/' + product.id + '/edit'"
        class="edit_product_admin">
        <div
          v-if="
            $store.state.isUserLoggedIn &&
            $store.state.user.user_status == 'Active'
          ">
          <div class="edit-text">
            <div class="edit-button">
              <font-awesome-icon icon="pen" />
            </div>
            Edit
          </div>
        </div>
      </router-link>
      <div
        class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
        <div class="col-12 col-sm-6">
          <div class="d-flex justify-content-center align-items-center">
            <img
              :src="product.image"
              class="product-image" />
          </div>
        </div>
        <div class="col-lg-6">
          <div class="product-title mt-4 mb-3">{{ product.title }}</div>
          <div class="pb-2">
            <div class="product-type-topic d-inline">Type:</div>
            <div class="product-type d-inline">{{ product.type }}</div>
          </div>
          <div class="pb-2">
            <div class="product-size-topic d-inline">Size:</div>
            <div class="product-size d-inline">{{ product.size }} ml</div>
          </div>
          <div class="pb-2">
            <div class="product-gender-topic d-inline">Gender:</div>
            <div class="product-gender d-inline">{{ product.gender }}</div>
          </div>
          <div class="pb-2">
            <div class="product-brand-topic d-inline">Brand:</div>
            <div class="product-brand d-inline">{{ product.brand }}</div>
          </div>
          <div class="d-flex align-items-center pt-2 pb-4">
            <div class="product-price">Rs. {{ price_string }}</div>
            <div
              class="ms-auto product-stock"
              :class="{
                'product-sold-out': sold_out,
                'product-last-one': last_one,
                'product-remain': remain,
                'product-instock': instock,
              }">
              {{ stock_status }}
            </div>
          </div>

          <div class="d-flex align-items-center pb-4">
            <div
              v-if="button_on"
              class="d-flex align-items-center h-100">
              <div
                class="circle-minus d-flex justify-content-between align-items-center"
                @click="decreaseQty(product.quantity)">
                <font-awesome-icon
                  icon="minus"
                  class="w-100" />
              </div>
              <div class="px-3 qty-text">
                <div class="product-input-qty">
                  <div class="qty-move">{{ product.quantity }}</div>
                </div>
              </div>
              <div
                class="circle-plus d-flex justify-content-between align-items-center"
                @click="increaseQty(product.quantity)">
                <font-awesome-icon
                  icon="plus"
                  class="w-100" />
              </div>
            </div>
            <div
              v-if="button_on"
              class="product-add-button ms-auto"
              @click="addItemToCart(product, product.quantity)">
              <font-awesome-icon
                icon="shopping-cart"
                class="d-inline" />
              <div class="d-inline ms-2">ADD TO CART</div>
            </div>
            <div
              v-if="button_off"
              class="disable-product-add-button">
              <div>Out of Stock</div>
            </div>
          </div>

          <hr class="mt-2" />

          <div class="mt-4">
            <div class="product-description-topic">Product Description:</div>
            <div class="product-description">{{ product.description }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getProductById } from "@/services/ProductService";

export default {
  name: "MyProduct",
  components: { MoonLoader },
  props: { addItemToCart: Function },
  data() {
    return {
      product: {
        id: "",
        title: "",
        size: "",
        brand: "",
        price: "",
        gender: "",
        type: "",
        quantity: "",
        stock: "",
        image: "",
      },
      stock_status: "",
      sold_out: false,
      last_one: false,
      remain: false,
      instock: false,
      button_on: true,
      button_off: false,
      price_string: "",
      loading: true,
    };
  },
  async mounted() {
    const productId = this.$store.state.route.params.productId;
    this.product = (await getProductById(productId)).data;
    this.$set(this.product, "quantity", 1);

    if (this.product.stock >= 2 && this.product.stock <= 10) {
      this.stock_status = `Only ${this.product.stock} Left`;
      this.remain = true;
    } else if (this.product.stock == 1) {
      this.stock_status = "The Last One";
      this.last_one = true;
    } else if (this.product.stock <= 0) {
      this.stock_status = "Sold Out";
      this.sold_out = true;
      this.button_on = false;
      this.button_off = true;
    } else {
      this.stock_status = "In Stock";
      this.instock = true;
    }

    if (this.product.discount !== null) {
      this.price_string = this.product.final_price.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
    } else {
      this.price_string = this.product.price.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
    }
    this.loading = false;
  },
  methods: {
    decreaseQty(quantity) {
      if (quantity <= 1) {
        this.product.quantity = 1;
      } else {
        this.product.quantity -= 1;
      }
    },
    increaseQty(quantity) {
      if (quantity >= this.product.stock) {
        this.product.quantity = this.product.stock;
      } else {
        this.product.quantity += 1;
      }
    },
  },
};
</script>

<style scoped>
.product-layout .product-title {
  color: #985855;
  font-size: 1.75rem;
  font-weight: 500;
}

.product-layout .product-type-topic,
.product-layout .product-size-topic,
.product-layout .product-gender-topic,
.product-layout .product-brand-topic,
.product-description-topic {
  font-size: 1.1rem;
  font-weight: 500;
}

.product-layout .product-type,
.product-layout .product-size,
.product-layout .product-gender,
.product-layout .product-brand {
  font-size: 1rem;
  font-weight: 300;
  padding-left: 1rem;
}

.product-layout .product-price {
  font-weight: 700;
  font-size: 1.74rem;
}

.product-layout .product-stock {
  font-weight: 500;
  font-size: 1rem;
  background-color: #88b143;
  color: #fff;
  padding: 0.2rem 0.5rem 0.1rem 0.5rem;
  border-radius: 0.25rem;
  cursor: default;
  user-select: none;
}

.product-layout .product-description {
  text-align: justify;
  word-spacing: -2px;
  font-weight: 300;
  font-size: 1rem;
  padding-top: 0.5rem;
  hyphens: auto;
}

.product-layout .product-add-button {
  background-color: #985855;
  color: #fff;
  font-weight: 500;
  font-size: 1rem;
  padding: 0.6rem 1.25rem 0.45rem 1.25rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
}

.product-layout .product-add-button:hover {
  background-color: #814643;
}

.product-layout .disable-product-add-button {
  background-color: #6c757d;
  color: #fff;
  font-weight: 500;
  font-size: 1rem;
  padding: 0.6rem 1.25rem 0.45rem 1.25rem;
  border-radius: 0.25rem;
  cursor: default;
  user-select: none;
}

.product-layout .circle-minus,
.product-layout .circle-plus {
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

.product-layout .circle-minus:hover,
.product-layout .circle-plus:hover {
  background-color: #fcedf2;
}

.product-layout .qty-text {
  font-weight: 500;
  font-size: 1.1rem;
  user-select: none;
}

.product-layout .product-input-qty {
  width: 2.5rem;
  height: 1.6rem;
  border-radius: 0.25rem;
  outline: unset;
  border: 1px solid #384648;
  text-align: center;
  background-color: rgba(239, 239, 239, 0.3);
  color: rgb(84, 84, 84);
}

.qty-move {
  position: relative;
  top: -0.05rem;
}

.product-layout .product-instock {
  background-color: #88b143;
}

.product-layout .product-remain {
  background-color: #ffa500;
}

.product-layout .product-last-one {
  background-color: #dc3545;
}

.product-layout .product-sold-out {
  background-color: #6c757d;
}

.edit_product_admin {
  position: absolute;
  right: 0;
  top: 0;
}

.edit-button {
  width: 1.75rem;
  height: 1.75rem;
  background-color: #639551;
  color: #ffffff;
  font-size: 0.9rem;
  padding-top: 0.25rem;
  border-radius: 50%;
  text-align: center;
  display: inline-block;
}

.edit-text:hover .edit-button {
  background-color: #477237;
}

.edit-text {
  color: #639551;
  padding: 0.25rem;
  border-radius: 50rem;
}

.edit-text:hover {
  color: #477237;
  background-color: #e7f7e1;
}

.cover_loader {
  height: 50vh;
}

.product-layout .product-image {
  width: 100%;
  height: 90vw;
  object-fit: cover;
}

.product-layout .product-breadcrum {
  padding-top: 1.25rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648 !important;
  font-weight: 500;
  font-size: 1.1rem;
  margin-bottom: 0.75rem;
}

@media (min-width: 375px) {
  .product-layout .product-image {
    width: 15rem;
    height: 15rem;
  }
}

@media (min-width: 576px) {
  .product-layout .product-image {
    height: 17.5rem;
    width: 17.5rem;
  }
}

@media (min-width: 768px) {
  .product-layout .product-image {
    height: 22.5rem;
    width: 22.5rem;
  }
}

@media (min-width: 992px) {
}

@media (min-width: 1200px) {
}

@media (min-width: 1400px) {
}
</style>
