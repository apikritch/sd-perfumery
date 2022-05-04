<template>
  <div>
    <!--Sign In Modal-->
    <div
      class="modal-container-sign-in d-flex justify-content-center align-items-center"
      v-if="display_sign_in"
    >
      <div class="modal-overelay" @click="hide"></div>
      <div class="modal-content">
        <div class="row h-100 no-margin">
          <div class="col-8">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div>
                <div class="d-flex justify-content-center">
                  <div class="registration-head">Sign In</div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="input-width">
                    <div class="form-group position-relative">
                      <input
                        type="text"
                        placeholder="Email"
                        v-model.trim="$v.sign_in_email.$model"
                        :class="[
                          $v.sign_in_email.$error ||
                          !$v.sign_in_password.isUnique
                            ? 'border_fail_2'
                            : null,
                          $v.sign_in_email.required &&
                          $v.sign_in_email.email &&
                          $v.sign_in_password.isUnique
                            ? 'border-success'
                            : null,
                        ]"
                      />
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="input-width position-relative">
                    <input
                      type="password"
                      placeholder="Password"
                      v-model.trim="$v.sign_in_password.$model"
                      :class="[
                        $v.sign_in_password.$error ? 'border_fail_2' : null,
                        $v.sign_in_password.required &&
                        $v.sign_in_password.isUnique
                          ? 'border-success'
                          : null,
                      ]"
                    />
                    <div
                      v-if="$v.sign_in_password.$dirty"
                      class="w-100"
                      :class="
                        $v.sign_in_email.required && $v.sign_in_email.email
                          ? 'position-relative'
                          : 'position-absolute'
                      "
                    >
                      <div class="error_2" v-if="!$v.sign_in_password.required">
                        Please Enter Your Password.
                      </div>
                      <div class="error_2" v-if="!$v.sign_in_password.isUnique">
                        Incorrect Email or Password.
                      </div>
                    </div>
                    <div
                      v-if="$v.sign_in_email.$dirty"
                      class="position-relative w-100"
                    >
                      <div class="error_2" v-if="!$v.sign_in_email.required">
                        Please Enter Your Email.
                      </div>
                      <div class="error_2" v-if="!$v.sign_in_email.email">
                        Invalid Email Format.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <div class="forgot-text" @click="showForgotPassword_2">
                    Forgot password?
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="modal-red-button" @click="signIn">
                    <div v-if="!sign_in_loading">Sign In</div>
                    <BeatLoader
                      class="text-center"
                      :loading="sign_in_loading"
                      color="#fff"
                      size="0.5rem"
                    ></BeatLoader>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            class="col-4 bg-small-side justify-content-center align-items-center"
          >
            <div
              class="close-icon d-flex justify-content-center align-items-center"
              @click="hide"
            >
              <font-awesome-icon icon="times" />
            </div>
            <div
              class="d-flex flex-column justify-content-center align-items-center h-100 font-small-side"
            >
              <div class="text-center mb-2">Don't have an account?</div>
              <div class="small-side-button mt-2" @click="showSignUp_2">
                Sign Up
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Sign In Modal-->

    <!--Sign Up Modal-->
    <div
      class="modal-container-sign-in d-flex justify-content-center align-items-center"
      v-if="display_sign_up"
    >
      <div class="modal-overelay" @click="hide"></div>
      <div class="modal-content">
        <div class="row h-100 no-margin">
          <div
            class="col-4 bg-small-side justify-content-center align-items-center"
          >
            <div
              class="close-icon-dark d-flex justify-content-center align-items-center"
              @click="hide"
            >
              <font-awesome-icon icon="times" />
            </div>
            <div
              class="d-flex flex-column justify-content-center align-items-center h-100 font-small-side"
            >
              <div class="text-center mb-2">Already have an account?</div>
              <div class="small-side-button mt-2" @click="showSignIn_2">
                Sign In
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div>
                <div class="d-flex justify-content-center">
                  <div class="registration-head">Create Account</div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="input-width">
                    <input
                      type="text"
                      placeholder="Email"
                      v-model.trim="$v.email.$model"
                      :class="[
                        $v.email.$error ? 'border_fail_2' : null,
                        $v.email.required && $v.email.email && $v.email.isUnique
                          ? 'border-success'
                          : null,
                      ]"
                    />
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="input-width position-relative">
                    <input
                      type="password"
                      placeholder="Password"
                      v-model.trim="$v.password.$model"
                      :class="[
                        $v.password.$error || !$v.email.isUnique
                          ? 'border_fail_2'
                          : null,
                        $v.password.required &&
                        $v.password.minLength &&
                        $v.email.isUnique
                          ? 'border-success'
                          : null,
                      ]"
                    />
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="input-width position-relative">
                    <input
                      type="password"
                      placeholder="Confirm Password"
                      v-model.trim="$v.confirm_password.$model"
                      :class="[
                        $v.confirm_password.$error || !$v.email.isUnique
                          ? 'border_fail_2'
                          : null,
                        $v.confirm_password.sameAsPassword &&
                        $v.confirm_password.required &&
                        $v.email.isUnique
                          ? 'border-success'
                          : null,
                      ]"
                    />
                    <div v-if="$v.confirm_password.$dirty">
                      <div
                        class="error_2"
                        v-if="
                          !$v.confirm_password.required &&
                          $v.email.required &&
                          $v.email.email &&
                          $v.password.required &&
                          $v.password.minLength
                        "
                      >
                        Confirm Password is required.
                      </div>
                      <div
                        class="error_2"
                        v-if="
                          !$v.confirm_password.sameAsPassword &&
                          $v.password.minLength &&
                          $v.confirm_password.required &&
                          $v.email.required &&
                          $v.email.email &&
                          $v.password.required
                        "
                      >
                        Passwords must be identical.
                      </div>
                    </div>
                    <div v-if="$v.password.$dirty">
                      <div
                        class="error_2"
                        v-if="
                          !$v.password.required &&
                          $v.email.required &&
                          $v.email.email
                        "
                      >
                        Password is required.
                      </div>
                      <div
                        class="error_2"
                        v-if="!$v.password.minLength && $v.email.required"
                      >
                        Password must have at least 6 letters.
                      </div>
                    </div>
                    <div v-if="$v.email.$dirty" class="position-relative">
                      <div class="error_2" v-if="!$v.email.required">
                        Email is required.
                      </div>
                      <div class="error_2" v-if="!$v.email.email">
                        Invalid email format.
                      </div>
                      <div class="error_2" v-if="!$v.email.isUnique">
                        Email already exists.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <div class="modal-red-button" @click="signUp">
                    <div v-if="!sign_up_loading">Sign Up</div>
                    <BeatLoader
                      class="text-center"
                      :loading="sign_up_loading"
                      color="#fff"
                      size="0.5rem"
                    ></BeatLoader>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Sign Up Modal-->

    <!--Forgot Password Modal-->
    <div
      class="modal-container-sign-in d-flex justify-content-center align-items-center"
      v-if="display_forgot_password"
    >
      <div class="modal-overelay" @click="hide"></div>
      <div class="modal-content">
        <div
          class="d-flex flex-column justify-content-end align-items-center h-50 no-margin modal-bg-half-top forgot-padding"
          :class="after_sent ? 'pb-5' : null"
        >
          <div
            class="close-icon d-flex justify-content-center align-items-center"
            @click="hide"
          >
            <font-awesome-icon icon="times" />
          </div>
          <div class="registration-head">Forgot Password</div>
          <div class="forgot-details" v-if="!after_sent">
            Enter the email address associated with your account and we’ll send
            you a link to reset your password.
          </div>
        </div>
        <div
          class="d-flex flex-column h-50 justify-content-center align-items-center no-margin forgot-padding"
          v-if="after_sent"
        >
          <div class="text-center">
            Password reset link has been sent to your email account, Please
            check your email.
          </div>

          <div class="w-100 text-center modal-red-button_2" @click="hide">
            <div>Close</div>
          </div>
        </div>
        <div
          class="d-flex flex-column h-50 justify-content-center align-items-center no-margin forgot-padding"
          v-if="!after_sent"
        >
          <div class="w-100 pt-4 position-relative">
            <input
              type="text"
              placeholder="Email"
              v-model.trim="$v.forgot_password.$model"
              :class="[
                $v.forgot_password.$error ? 'border_fail_2' : null,
                $v.forgot_password.required &&
                $v.forgot_password.email &&
                $v.forgot_password.isUnique
                  ? 'border-success'
                  : null,
              ]"
            />
            <div v-if="$v.forgot_password.$dirty">
              <div class="error_2" v-if="!$v.forgot_password.required">
                Email is required.
              </div>
              <div class="error_2" v-if="!$v.forgot_password.email">
                Invalid email format.
              </div>
              <div class="error_2" v-if="!$v.forgot_password.isUnique">
                No account found with that email address.
              </div>
            </div>
            <div class="success" v-if="success">
              We have e-mailed your password reset link!
            </div>
          </div>

          <!--<div class="position-relative w-100 text-center">
            <div class="sent_box" :class="success ? 'visible' : 'hidden'">
              
            </div>
          </div>-->

          <div class="w-100 text-center modal-red-button_2" @click="forgot">
            <div v-if="!forgot_loading">Send</div>
            <BeatLoader
              class="text-center"
              :loading="forgot_loading"
              color="#fff"
              size="0.5rem"
            ></BeatLoader>
          </div>

          <div class="mt-auto w-100 text-center text-end-size">
            Don’t have an account?
            <div class="d-inline sign-up-color" @click="showSignUp_2">
              Sign up
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Forgot Password Modal-->

    <div class="navbar-section">
      <div
        class="container-lg d-flex align-items-center justify-content-between h-100"
      >
        <div>Call us 0012804227</div>
        <div class="d-flex nav-text-color">
          <div class="d-flex align-items-center nav-text-color_2">
            <router-link to="/">Home</router-link>
            <router-link to="/shop" class="ms-4">Shop</router-link>
            <router-link to="/contactus" class="ms-4">Contact Us</router-link>
          </div>
          <div
            class="d-flex align-items-center ms-4 border-on-nav"
            v-if="!$store.state.isCustomerLoggedIn"
          >
            <button @click="showSignIn_2" class="ms-4 registration-button">
              Sign In
            </button>
            <button @click="showSignUp" class="ms-4 navbar-signup-button">
              Sign Up
            </button>
          </div>

          <!--User Icon-->
          <div
            class="d-flex align-items-center ms-4 border-on-nav"
            v-if="$store.state.isCustomerLoggedIn"
          >
            <router-link to="/myaccount" class="ms-4">
              <div class="d-flex align-items-center">
                <div class="admin-circle">
                  {{ $store.state.customer.email.toUpperCase().charAt(0) }}
                </div>
                <div class="admin-nav-text">
                  {{ $store.state.customer.email }}
                </div>
              </div>
            </router-link>

            <button @click="signOut" class="ms-4 navbar-signout-button">
              Sign Out
            </button>
          </div>
          <!--User Icon-->

          <!--Shopping Cart-->
          <div class="ms-4 position-relative cart-icon-button">
            <div
              class="d-flex align-items-center h-100 cart-button"
              @click="showCart"
            >
              <font-awesome-icon
                icon="shopping-cart"
                class="nav-shopping-cart"
              />
              <div class="nav-cart-qty">
                {{ cartQty }}
              </div>
            </div>
          </div>
          <!--Shopping Cart-->
        </div>
      </div>
    </div>
    <!--Cart Overlay-->
    <div
      class="modal-overelay-cart"
      @click="hideCart"
      v-if="display_cart"
    ></div>
    <div class="container position-relative">
      <div
        class="modal-content-cart"
        :class="display_cart ? 'slide-cart-1' : 'slide-cart'"
      >
        <div class="d-flex justify-content-between">
          <div class="cart-header">Cart</div>
          <div
            class="close_header d-flex justify-content-center align-items-center"
          >
            <font-awesome-icon
              icon="times"
              class="big_close_cart"
              @click="hideCart"
            />
          </div>
        </div>

        <div class="cover-max-height">
          <div class="max-height-mini-cart">
            <div v-if="!cart.length" class="d-flex justify-content-center">
              Your shopping cart is empty
            </div>
            <div v-if="cart.length">
              <div
                class="row item-in-mini-cart align-items-center"
                v-for="(item, index) in cart"
                :key="index"
              >
                <div class="col-2 mini-image-padding">
                  <img
                    :src="item.product.image"
                    width="100%"
                    class="mini-cart-image"
                  />
                </div>
                <div class="col-10">
                  <div class="row">
                    <div class="col-11 mini-cart-title">
                      {{ item.product.title }} | {{ item.product.type }} for
                      {{ item.product.gender }} - {{ item.product.size }} ml by
                      {{ item.product.brand }}
                    </div>
                    <div class="col-1 mini-close">
                      <div
                        class="new_mini_close d-flex- justify-content-center align-items-center"
                      >
                        <font-awesome-icon
                          icon="times"
                          class="mini-close-size"
                          @click="removeItemInCart(index)"
                        />
                      </div>
                    </div>
                  </div>
                  <div
                    class="row pt-1 justify-content-between align-items-center"
                  >
                    <div class="col-4 mini-qty">
                      <div
                        class="d-flex justify-content-between align-items-center h-100"
                      >
                        <div
                          class="circle-minus d-flex justify-content-between align-items-center"
                          @click="deleteItemInCart(index)"
                        >
                          <font-awesome-icon icon="minus" class="w-100" />
                        </div>
                        <div class="px-2 qty-text">
                          {{ item.qty }}
                        </div>

                        <div
                          class="circle-plus d-flex justify-content-between align-items-center"
                          @click="addItemToCart(item.product, 1)"
                        >
                          <font-awesome-icon icon="plus" class="w-100" />
                        </div>
                      </div>
                    </div>
                    <div
                      class="col-3 mini-discount-total"
                      v-if="item.product.discount"
                    >
                      Rs.
                      {{
                        (item.qty * item.product.price).toLocaleString(
                          undefined,
                          {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                          }
                        )
                      }}
                    </div>
                    <div class="col-5 mini-total">
                      <div
                        :class="
                          item.product.discount ? 'discount-text-mini' : null
                        "
                      >
                        Rs.
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="pt-3 text-end">
          <div class="d-flex justify-content-end align-items-end">
            <div class="mini-subtotal">Subtotal:</div>
            <div class="ps-2 mini-sub-price">
              Rs.
              {{
                cartTotal.toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
              }}
            </div>
          </div>
        </div>

        <div
          class="mt-2 mini-check-button"
          v-if="cart.length"
          @click="display_cart_redirect"
        >
          CHECKOUT NOW
        </div>
      </div>
    </div>

    <!--Cart Overlay-->
  </div>
</template>

<script>
import { signUp, signIn, forgetPassword } from "@/services/CustomerService";
import { validationMixin } from "vuelidate";
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";
import BeatLoader from "vue-spinner/src/BeatLoader.vue";

export default {
  name: "MyNavbar",
  props: {
    cart: Array,
    cartQty: Number,
    cartTotal: Number,
    addItemToCart: Function,
    deleteItemInCart: Function,
    removeItemInCart: Function,
    display_cart: Boolean,
    hideCart: Function,
    showCart: Function,
    display_cart_redirect: Function,
    display_sign_in: Boolean,
    display_sign_up: Boolean,
    display_forgot_password: Boolean,
    showSignIn: Function,
    showSignUp: Function,
    hideAll: Function,
    showForgotPassword: Function,
  },
  components: { BeatLoader },
  data() {
    return {
      email: "",
      password: "",
      confirm_password: "",
      customer: "",
      sign_in_email: "",
      sign_in_password: "",
      forgot_password: "",
      sign_up_loading: false,
      sign_in_loading: false,
      forgot_loading: false,
      incorrect_sign_in_password: false,
      email_exist: false,
      no_email: false,
      success: false,
      after_sent: false,
    };
  },
  mixins: [validationMixin],
  validations: {
    email: {
      required,
      email,
      isUnique(value) {
        if (value !== "" && this.email_exist) {
          return false;
        } else {
          return true;
        }
      },
    },
    password: {
      required,
      minLength: minLength(6),
    },
    confirm_password: {
      required,
      sameAsPassword: sameAs("password"),
    },
    sign_in_email: {
      required,
      email,
    },
    sign_in_password: {
      required,
      isUnique(value) {
        if (value !== "" && this.incorrect_sign_in_password) {
          return false;
        } else {
          return true;
        }
      },
    },
    forgot_password: {
      required,
      email,
      isUnique(value) {
        if (value !== "" && this.no_email) {
          return false;
        } else {
          return true;
        }
      },
    },
  },
  watch: {
    email() {
      this.email_exist = false;
      this.$v.email.$reset();
      this.$v.password.$reset();
      this.$v.confirm_password.$reset();
    },
    password() {
      this.$v.email.$reset();
      this.$v.password.$reset();
      this.$v.confirm_password.$reset();
    },
    confirm_password() {
      this.$v.email.$reset();
      this.$v.password.$reset();
      this.$v.confirm_password.$reset();
    },
    sign_in_email() {
      this.incorrect_sign_in_password = false;
      this.$v.sign_in_email.$reset();
      this.$v.sign_in_password.$reset();
    },
    sign_in_password() {
      this.incorrect_sign_in_password = false;
      this.$v.sign_in_password.$reset();
      this.$v.sign_in_email.$reset();
    },
    forgot_password() {
      this.no_email = false;
      this.$v.forgot_password.$reset();
    },
  },
  methods: {
    async signUp() {
      this.sign_up_loading = true;

      this.$v.email.$touch();
      this.$v.password.$touch();
      this.$v.confirm_password.$touch();
      if (
        this.$v.email.$anyError ||
        this.$v.password.$anyError ||
        this.$v.confirm_password.$anyError
      ) {
        this.sign_up_loading = false;
        return;
      }

      let customer = {
        email: this.email,
        password: this.password,
      };

      const response = await signUp(customer);
      if (response.data.message !== "Fail") {
        this.email_exist = false;
        this.$store.dispatch("setCustomer", response.data);
        this.customer = response.data;
        this.sign_up_loading = false;
        this.hide();
      } else {
        this.email_exist = true;
        this.sign_up_loading = false;
      }
    },
    async signIn() {
      this.sign_in_loading = true;

      this.$v.sign_in_email.$touch();
      this.$v.sign_in_password.$touch();
      if (
        this.$v.sign_in_email.$anyError ||
        this.$v.sign_in_password.$anyError
      ) {
        this.sign_in_loading = false;
        return;
      }

      const response = await signIn({
        email: this.sign_in_email,
        password: this.sign_in_password,
      });

      if (response.data.message !== "Fail") {
        this.incorrect_sign_in_password = false;
        this.$store.dispatch("setCustomer", response.data);
        this.customer = response.data;
        this.sign_in_loading = false;
        this.hide();
      } else {
        this.incorrect_sign_in_password = true;
        this.sign_in_loading = false;
      }
    },
    async signOut() {
      this.$store.dispatch("setCustomer", null);

      if (this.$route.name !== "Home") {
        this.$router.push({
          name: "Home",
        });
      }
      this.hide();
    },
    async forgot() {
      this.forgot_loading = true;

      this.$v.forgot_password.$touch();
      if (this.$v.forgot_password.$anyError) {
        this.forgot_loading = false;
        return;
      }

      const response = await forgetPassword({
        email: this.forgot_password,
      });

      if (response.data.message !== "Fail") {
        this.no_email = false;
        this.forgot_loading = false;
        this.success = true;
        setTimeout(() => {
          this.success = false;
          this.after_sent = true;
          this.clearForm();
          this.$v.$reset();
        }, 3000);
      } else {
        this.no_email = true;
        this.forgot_loading = false;
      }
    },
    hide() {
      this.hideAll();
      this.clearForm();
      this.$v.$reset();
      this.after_sent = false;
    },
    clearForm() {
      this.email = "";
      this.password = "";
      this.confirm_password = "";
      this.sign_in_email = "";
      this.sign_in_password = "";
      this.forgot_password = "";
    },
    showSignIn_2() {
      this.hide();
      this.showSignIn();
    },
    showSignUp_2() {
      this.hide();
      this.showSignUp();
    },
    showForgotPassword_2() {
      this.hide();
      this.showForgotPassword();
    },
  },
};
</script>

<style scoped>
.navbar-section {
  height: 50px;
  background: #b7dde3;
  filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
  font-weight: 500;
  font-size: 1rem;
  padding: unset;
}

.navbar-section .border-on-nav {
  border-left: 2px solid #384648 !important;
}

.navbar-signup-button {
  color: #ffffff !important;
  background-color: #384648;
  border-radius: 0.25rem;
  padding: 0.17rem 0.5rem 0.1rem 0.5rem;
  font-weight: 300;
  border: unset;
}

.navbar-signup-button:hover {
  background-color: #4b5b5e;
}

.navbar-signout-button {
  color: #ffffff;
  background-color: #6c757d;
  border-radius: 0.25rem;
  padding: 0.2rem 0.6rem 0.125rem 0.6rem;
  font-weight: 300;
  font-size: 0.9rem;
  border: unset;
}

.navbar-signout-button:hover {
  background-color: #384648;
}

.nav-text-color a {
  color: #384648;
}

.nav-text-color_2 a:hover {
  text-decoration: underline !important;
}

.nav-shopping-cart {
  font-size: 1.25rem;
}

.cart-button {
  cursor: pointer;
}

.nav-cart-qty {
  width: 1.3rem;
  height: 1.3rem;
  background-color: #f44336;
  color: #ffffff;
  font-size: 0.8rem;
  padding-top: 0.1rem;
  font-weight: 300;
  margin-left: 0.25rem;
  border-radius: 50%;
  text-align: center;
}

.registration-button {
  background-color: unset;
  border: unset;
  padding: 0.17rem 0.5rem 0.1rem 0.5rem;
}

.registration-button:hover {
  background-color: #cde8ec;
  border-radius: 0.25rem;
}

.admin-circle {
  height: 2.5rem;
  min-width: 2.5rem;
  background-color: #779ecb;
  color: #ffffff;
  font-size: 1.5rem;
  padding-top: 0.1rem;
  border: 1px solid #384648;
  font-weight: 400;
  border-radius: 50%;
  text-align: center;
  margin-right: 0.5rem;
}

.admin-nav-text {
  font-weight: 400;
}

/*Moadl*/
.modal-container-sign-in {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100%;
  height: 100vh;
  z-index: 999;
}

.modal-overelay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100%;
  height: 100vh;
  background: rgba(0, 0, 0, 0.2);
  opacity: 1;
}

.modal-content {
  position: relative;
  overflow: hidden;
  box-sizing: border-box;
  background-color: white;
  box-shadow: 0 20px 60px -2px rgba(27, 33, 58, 0.4);
  width: 550px;
  height: 350px;
  border-radius: 0.5rem;
  border: unset;
}

.modal-content .bg-small-side {
  background-color: #7e989c;
  color: #fff;
  padding-left: calc(var(--bs-gutter-x) * 1.75);
  padding-right: calc(var(--bs-gutter-x) * 1.75);
}

.modal-content .close-icon {
  position: absolute;
  right: 0.75rem;
  top: 0.4rem;
  font-size: 0.9rem;
  cursor: pointer;
  color: #fff;
  width: 1rem;
  height: 1rem;
}

.modal-content .close-icon:hover {
  background-color: #93abaf;
  border-radius: 50rem;
}

.modal-content .font-small-side {
  font-weight: 400;
  font-size: 0.95rem;
}

.modal-content .small-side-button {
  padding: 0.3rem 0.75rem 0.3rem 0.75rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
  border: 1px solid #fff;
  background-color: #7e989c;
}

.modal-content .small-side-button:hover {
  background-color: #8aa3a7;
}

.modal-content .registration-head {
  font-size: 1.4rem;
  padding-bottom: 0.75rem;
}

.modal-content input {
  border-radius: 0.25rem;
  border: 1px solid #384648;
  width: 100%;
  padding: 0.3rem 0.5rem;
  font-size: 0.8rem;
}

.modal-content input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.modal-content .input-width {
  width: 250px;
  padding-bottom: 0.5rem;
}

.modal-content .no-margin {
  margin-right: calc(var(--bs-gutter-x) * -0.1);
  margin-left: calc(var(--bs-gutter-x) * -0.1);
}

.modal-content .forgot-text {
  text-align: right;
  font-size: 0.8rem;
  font-weight: 400;
  margin-bottom: 0.75rem;
  cursor: pointer;
  user-select: none;
}

.modal-content .forgot-text:hover {
  text-decoration: underline;
}

.modal-content .modal-red-button {
  background-color: #985855;
  color: #fff;
  padding: 0.4rem 1.25rem 0.3rem 1.25rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
  margin-top: 0.25rem;
}

.modal-content .modal-red-button:hover {
  background-color: #814643;
}

.modal-content .modal-red-button_2 {
  background-color: #985855;
  color: #fff;
  padding: 0.4rem 1.25rem 0.3rem 1.25rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
  margin-top: 0.75rem;
}

.modal-content .modal-red-button_2:hover {
  background-color: #814643;
}

.modal-content .close-icon-dark {
  position: absolute;
  right: 0.75rem;
  top: 0.4rem;
  font-size: 0.9rem;
  cursor: pointer;
  color: #384648;
  width: 1rem;
  height: 1rem;
}

.modal-content .close-icon-dark:hover {
  background-color: #ecf3ff;
  border-radius: 50rem;
}

.modal-bg-half-top {
  background-color: #7e989c;
  color: #fff;
}

.forgot-padding {
  padding-left: 7rem;
  padding-right: 7rem;
}

.forgot-details {
  font-size: 0.8rem;
  padding-bottom: 2rem;
}

.sign-up-color {
  color: #985855;
  cursor: pointer;
}

.sign-up-color:hover {
  text-decoration: underline;
}

.text-end-size {
  font-size: 0.8rem;
  padding-bottom: 1rem;
}
/*Moadl*/

.modal-overelay-cart {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100%;
  height: 100vh;
  opacity: 1;
  background: rgba(0, 0, 0, 0.2);
}

.modal-content-cart {
  position: fixed;
  top: 0;
  height: 100vh;
  width: 25%;
  overflow: hidden;
  box-sizing: border-box;
  background-color: white;
  padding: 0.75rem 1rem 1rem 1rem;
  transition: all 0.3s ease-in-out;
}

.slide-cart-1 {
  right: 0;
  filter: drop-shadow(0px 3px 10px rgba(0, 0, 0, 0.5));
}

.slide-cart {
  right: -25%;
}

.cart-header {
  font-size: 1.5rem;
  font-weight: 500;
  padding-bottom: 0.25rem;
}

.item-in-mini-cart {
  border-bottom: 1px solid #b9b9b9;
  padding: 0.5rem 0rem;
  margin-right: unset;
  margin-left: unset;
}

.mini-cart-image {
  object-fit: cover;
  height: 3.5rem;
}

.mini-image-padding {
  padding-left: unset;
  padding-right: unset;
}

.mini-cart-title {
  font-size: 0.7rem;
  font-weight: 400;
  padding-right: unset;
}

.mini-close {
  padding-right: unset;
  padding-left: unset;
}

.mini-close-size {
  font-size: 0.8rem;
  color: #b9b9b9;
  cursor: pointer;
  position: relative;
  top: -4px;
  right: -4px;
}

.new_mini_close {
  width: 1rem;
  height: 1rem;
  border-radius: 50rem;
}

.new_mini_close:hover {
  background-color: #ecf3ff;
}

.mini-total {
  font-size: 0.8rem;
  text-align: right;
  font-weight: 500;
  padding-left: unset;
  padding-right: unset;
  width: 37.5%;
}

.mini-discount-total {
  text-align: right;
  text-decoration: line-through;
  font-size: 0.7rem;
  font-weight: 400;
  padding-left: unset;
  padding-right: unset;
  width: 35%;
}

.cart-icon-button {
  z-index: 5000;
}

.cover-max-height {
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #384648;
  border-top: 2px solid #384648;
}

.max-height-mini-cart {
  max-height: 75vh;
  overflow: auto;
}

.cover-max-height .max-height-mini-cart::-webkit-scrollbar-track {
  background-color: #f3cabc;

  background-clip: padding-box;
  border-left: 10px solid rgba(0, 0, 0, 0);
}

.cover-max-height .max-height-mini-cart::-webkit-scrollbar {
  width: 15px;
}

.cover-max-height .max-height-mini-cart::-webkit-scrollbar-thumb {
  background-color: #985855;
  background-clip: padding-box;
  border-left: 10px solid rgba(0, 0, 0, 0);
}

.mini-qty {
  padding-right: unset;
  width: 27.5%;
}

.mini-check-button {
  background-color: #985855;
  color: #fff;
  border: 1px solid #985855;
  border-radius: 0.25rem;
  padding-top: 0.35rem;
  padding-bottom: 0.25rem;
  width: 100%;
  cursor: pointer;
  text-align: center;
  font-size: 1rem;
}

.mini-check-button:hover {
  background-color: #814643;
  border: 1px solid #814643;
}

.mini-subtotal {
  font-size: 0.8rem;
  padding-bottom: 0.05rem;
  font-weight: 500;
  color: #7e989c;
}

.mini-sub-price {
  font-size: 0.95rem;
  font-weight: 700;
}

.circle-minus,
.circle-plus {
  width: 0.9rem;
  height: 0.9rem;
  font-size: 0.5rem;
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
  font-size: 0.9rem;
}

.discount-text-mini {
  color: #f44336;
}

.close_header {
  width: 1.75rem;
  height: 1.75rem;
  border-radius: 50rem;
}

.close_header:hover {
  background-color: #ecf3ff;
}

.big_close_cart {
  font-size: 1.5rem;
  font-weight: 100;
  cursor: pointer;
}

.border-fail {
  border: 1px solid #dc3545 !important;
  border-radius: 0.25rem 0.25rem 0 0 !important;
}

.border_fail_2 {
  border: 1px solid #dc3545 !important;
  border-radius: 0.25rem !important;
}

.border-success {
  border: 1px solid #198754 !important;
}

.error {
  position: absolute;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.7rem;
  border-radius: 0 0 0.25rem 0.25rem;
  text-align: center;
  width: 100%;
}
.error_2 {
  position: relative;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.7rem;
  border-radius: 0.25rem;
  text-align: center;
  width: 100%;
  margin-top: 0.25rem;
}

.success {
  position: relative;
  color: #fff;
  background-color: #639551;
  font-size: 0.8rem;
  border-radius: 0.25rem;
  text-align: center;
  width: 100%;
  margin-top: 0.25rem;
}

.sent_box {
  margin-top: 0.25rem;
  background-color: #e7f7e1;
  color: #639551;
  padding: 0.1rem 0.5rem 0rem 0.5rem;
  border: 2px solid #639551;
  border-radius: 0.5rem;
  position: absolute;
  width: 100%;
  font-size: 0.75rem;
  font-weight: 500;
}

.visible {
  visibility: visible;
  display: block;
  opacity: 1;
  transition: opacity 0s linear;
}

.hidden {
  visibility: hidden;
  opacity: 0;
  transition: visibility 0s 1s, opacity 1s linear;
}
</style>
