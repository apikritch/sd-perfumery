<template>
  <div class="admin-login-bg">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="d-flex flex-column">
        <div class="admin-forgot-head">Admin Login</div>

        <input
          v-model.trim="$v.email.$model"
          type="text"
          placeholder="Email"
          :class="[
            $v.email.$error || !$v.password.isUnique ? 'border_fail_2' : null,
            $v.email.required && $v.email.email && $v.password.isUnique
              ? 'border-success'
              : null,
          ]" />

        <input
          v-model="password"
          v-model.trim="$v.password.$model"
          type="password"
          placeholder="Password"
          :class="[
            $v.password.$error ? 'border_fail_2' : null,
            $v.password.required && $v.password.isUnique
              ? 'border-success'
              : null,
          ]" />
        <div class="position-relative d-flex flex-column">
          <div
            v-if="$v.password.$dirty"
            class="w-100"
            :class="
              $v.email.required && $v.email.email
                ? 'position-relative'
                : 'position-absolute'
            ">
            <div
              v-if="!$v.password.required"
              class="error_2">
              Please Enter Your Password.
            </div>
            <div
              v-if="!$v.password.isUnique"
              class="error_2">
              Incorrect Email or Password.
            </div>
          </div>
          <div
            v-if="$v.email.$dirty"
            class="position-relative w-100">
            <div
              v-if="!$v.email.required"
              class="error_2">
              Please Enter Your Email.
            </div>
            <div
              v-if="!$v.email.email"
              class="error_2">
              Invalid Email Format.
            </div>
          </div>
        </div>
        <div
          class="d-flex justify-content-center align-irems-center login-button"
          @click="signIn">
          <div v-if="!sign_in_loading">Log in</div>
          <div>
            <BeatLoader
              class="text-center"
              :loading="sign_in_loading"
              color="#fff"
              size="0.5rem"></BeatLoader>
          </div>
        </div>
        <div class="d-flex justify-content-end forgot-admin-padding">
          <router-link to="admin/forgot_password">
            <div class="forgot-admin">Forgot Password?</div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
import { signIn } from "@/services/AdminUserService";
import BeatLoader from "vue-spinner/src/BeatLoader.vue";
import CryptoJS from "crypto-js";

export default {
  name: "AdminLogin",
  components: { BeatLoader },
  mixins: [validationMixin],
  data() {
    return {
      sign_in_loading: false,

      email: "",
      password: "",
      incorrect_sign_in_password: false,
    };
  },
  validations: {
    email: { required, email },
    password: {
      required,
      isUnique(value) {
        if (value !== "" && this.incorrect_sign_in_password) {
          return false;
        } else {
          return true;
        }
      },
    },
  },
  watch: {
    email() {
      this.incorrect_sign_in_password = false;
      this.$v.email.$reset();
      this.$v.password.$reset();
    },
    password() {
      this.incorrect_sign_in_password = false;
      this.$v.password.$reset();
      this.$v.email.$reset();
    },
  },
  methods: {
    async signIn() {
      this.sign_in_loading = true;

      this.$v.email.$touch();
      this.$v.password.$touch();
      if (this.$v.email.$anyError || this.$v.password.$anyError) {
        this.sign_in_loading = false;
        return;
      }

      const response = await signIn({
        email: this.email,
        password: this.password,
      });

      if (response.data.message !== "Fail") {
        this.incorrect_sign_in_password = false;
        this.$store.dispatch("setUser", response.data);
        this.sign_in_loading = false;

        const encryptedEM = CryptoJS.AES.encrypt(
          response.data.email,
          "secret_1234",
        ).toString();

        this.$cookies.set("EM", encryptedEM, "1m", null, null, true);
      } else {
        this.incorrect_sign_in_password = true;
        this.sign_in_loading = false;
      }
    },
  },
};
</script>

<style scoped>
.admin-login-bg {
  background-color: #7e989c;
  height: 100vh;
  width: 100vw;
}

.admin-forgot-head {
  text-align: center;
  color: #fff;
  font-size: 1.75rem;
  padding-bottom: 1.25rem;
}

.admin-login-bg input {
  border: 1px solid #384648;
  padding: 0.25rem 1rem;
  margin-bottom: 0.5rem;
  width: 400px;
}

.admin-login-bg input:focus-visible {
  border: 1px solid #384648;
  outline: inherit;
}

.admin-login-bg .login-button {
  background-color: #985855;
  color: #fff;
  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  cursor: pointer;
  user-select: none;
  margin-top: 0.5rem;
}

.forgot-admin {
  color: #fff;
  font-size: 0.9rem;
}

.forgot-admin:hover {
  text-decoration: underline;
}

.forgot-admin-padding {
  padding-top: 1rem;
}

.login-button:hover {
  background-color: #814643;
}

.error_2 {
  position: relative;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.9rem;
  text-align: center;
  width: 100%;
}

.border_fail_2 {
  border: 1px solid #dc3545 !important;
}

.border-success {
  border: 1px solid #198754 !important;
}
</style>
