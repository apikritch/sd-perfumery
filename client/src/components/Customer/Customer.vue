<template>
  <div>
    <Navbar
      :cart="cart"
      :cartQty="cartQty"
      :cartTotal="cartTotal"
      :addItemToCart="addItemToCart"
      :deleteItemInCart="deleteItemInCart"
      :removeItemInCart="removeItemInCart"
      :display_cart="display_cart"
      :hideCart="hideCart"
      :showCart="showCart"
      :display_cart_redirect="display_cart_redirect"
      :display_sign_in="display_sign_in"
      :display_sign_up="display_sign_up"
      :display_forgot_password="display_forgot_password"
      :hideAll="hideAll"
      :showSignIn="showSignIn"
      :showSignUp="showSignUp"
      :showForgotPassword="showForgotPassword"
      class="sticky-nav"
    ></Navbar>
    <router-view
      :cart="cart"
      :cartQty="cartQty"
      :total="total"
      :cartTotal="cartTotal"
      :products="products"
      :addItemToCart="addItemToCart"
      :deleteItemInCart="deleteItemInCart"
      :removeItemInCart="removeItemInCart"
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
      :clearCart="clearCart"
      :showSignIn="showSignIn"
    />
    <Footer></Footer>
    <CookieMessage></CookieMessage>
  </div>
</template>

<script>
import Navbar from "./Layout/Navbar.vue";
import Footer from "./Layout/Footer.vue";
import CookieMessage from "./CookiesMessage.vue";

export default {
  name: "MyCustomer",
  props: [
    "cart",
    "cartQty",
    "total",
    "cartTotal",
    "products",
    "addItemToCart",
    "deleteItemInCart",
    "removeItemInCart",
    "changeValuePrice",
    "valueSliderPrice",
    "changeValueSize",
    "valueSliderSize",
    "changeValueGender",
    "valueGender",
    "changeValueType",
    "valueType",
    "changeValueBrand",
    "valueBrand",
    "display_cart",
    "hideCart",
    "showCart",
    "display_cart_redirect",
    "clearCart",
  ],
  components: { Navbar, Footer, CookieMessage },
  data() {
    return {
      display_sign_in: false,
      display_sign_up: false,
      display_forgot_password: false,
    };
  },
  methods: {
    showSignIn() {
      this.display_sign_in = true;
      this.display_sign_up = false;
      this.display_forgot_password = false;
    },
    showSignUp() {
      this.display_sign_up = true;
      this.display_sign_in = false;
      this.display_forgot_password = false;
    },
    showForgotPassword() {
      this.display_forgot_password = true;
      this.display_sign_in = false;
      this.display_sign_up = false;
    },
    hideAll() {
      this.display_sign_in = false;
      this.display_sign_up = false;
      this.display_forgot_password = false;
    },
  },
};
</script>

<style scoped>
.sticky-nav {
  position: -webkit-sticky;
  position: sticky;
  top: 0px;
  z-index: 10000;
}
</style>
