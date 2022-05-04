<template>
  <div id="app">
    <div>
      <!--
    <font-awesome-icon icon="user-secret" />
    <font-awesome-icon :icon="['fas', 'user-secret']" />
    -->
      <router-view
        :addItemToCart="addItemToCart"
        :deleteItemInCart="deleteItemInCart"
        :removeItemInCart="removeItemInCart"
        :cart="cart"
        :cartQty="cartQty"
        :total="total"
        :cartTotal="cartTotal"
        :products="products"
        :changeValuePrice="changeValuePrice"
        :valueSliderPrice="valueSliderPrice"
        :changeValueSize="changeValueSize"
        :valueSliderSize="valueSliderSize"
        :changeValueGender="changeValueGender"
        :valueGender="valueGender"
        :changeValueType="changeValueType"
        :valueType="valueType"
        :changeValueBrand="changeValueBrand"
        :valueBrand="valueBrand"
        :display_cart="display_cart"
        :hideCart="hideCart"
        :showCart="showCart"
        :display_cart_redirect="display_cart_redirect"
        :clearCart="clearCart"
      />
    </div>
  </div>
</template>

<script>
import { getProducts } from "@/services/ProductService";

export default {
  name: "App",
  data() {
    return {
      cart: [],
      products: null,
      valueSliderPrice: [],
      valueSliderSize: [],
      valueGender: [],
      valueType: [],
      valueBrand: [],
      display_cart: false,
    };
  },
  methods: {
    display_cart_redirect() {
      this.display_cart = false;
      if (this.$route.name !== "Cart") {
        this.$router.push({
          name: "Cart",
        });
      }
    },
    addItemToCart(product, qty) {
      var whichProduct;
      var existing = this.cart.filter((item, index) => {
        if (item.product.id == Number(product.id)) {
          whichProduct = index;
          return true;
        } else {
          return false;
        }
      });

      if (existing.length) {
        this.cart[whichProduct].qty = this.cart[whichProduct].qty + qty;
      } else {
        this.cart.push({ product: product, qty: qty });
      }
      if (this.$route.name !== "Cart") {
        this.display_cart = true;
      }
    },
    deleteItemInCart(index) {
      if (this.cart[index].qty > 1) {
        this.cart[index].qty--;
      } else {
        this.cart[index].qty = 1;
      }
    },
    removeItemInCart(index) {
      this.cart.splice(index, 1);
    },
    changeValuePrice(value) {
      this.valueSliderPrice = value;
    },
    changeValueSize(value) {
      this.valueSliderSize = value;
    },
    changeValueGender(value) {
      this.valueGender = value;
    },
    changeValueType(value) {
      this.valueType = value;
    },
    changeValueBrand(value) {
      this.valueBrand = value;
    },
    hideCart() {
      this.display_cart = false;
    },
    showCart() {
      this.display_cart = true;
    },
    clearCart() {
      this.cart = [];
    },
  },
  computed: {
    cartTotal() {
      let sum = 0;
      for (let key in this.cart) {
        if (!this.cart[key].product.final_price) {
          sum = sum + this.cart[key].product.price * this.cart[key].qty;
        } else if (this.cart[key].product.final_price) {
          sum = sum + this.cart[key].product.final_price * this.cart[key].qty;
        }
      }
      return sum;
    },
    total() {
      let sum = 0;
      for (let key in this.cart) {
        if (!this.cart[key].product.price) {
          sum = sum + this.cart[key].product.price * this.cart[key].qty;
        } else if (this.cart[key].product.price) {
          sum = sum + this.cart[key].product.price * this.cart[key].qty;
        }
      }
      return sum;
    },
    cartQty() {
      let qty = 0;
      for (let key in this.cart) {
        qty = qty + this.cart[key].qty;
      }
      return qty;
    },
  },
  async mounted() {
    this.products = (await getProducts()).data;

    this.valueSliderPrice = [
      0,
      await Math.max.apply(
        Math,
        this.products.map((product) => product.price)
      ),
    ];

    this.valueSliderSize = [
      0,
      await Math.max.apply(
        Math,
        this.products.map((product) => product.size)
      ),
    ];
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");

html,
body {
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #384648;
}

#app {
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #384648;
}

p {
  margin: unset;
}

hr {
  margin: unset;
}

a {
  text-decoration: unset !important;
}

.form-control:focus {
  border-color: unset !important;
  box-shadow: unset !important;
}
</style>
