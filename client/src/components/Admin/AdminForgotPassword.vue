<template>
  <div>
    <div class="admin-login-bg">
      <div class="d-flex justify-content-center align-items-end h-100">
        <div class="d-flex flex-column">
          <div class="admin-forgot-head">Forgot Password</div>
          <div class="admin-forgot-details">
            Enter your email address. You will receive an email with a link to
            reset you password.
          </div>
        </div>
      </div>
    </div>
    <div class="admin-forgot-half">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="d-flex flex-column">
          <input
            v-model.trim="$v.forgot_password.$model"
            type="text"
            placeholder="Email"
            :class="[
              $v.forgot_password.$error ? 'border_fail_2' : null,
              $v.forgot_password.required &&
              $v.forgot_password.email &&
              $v.forgot_password.isUnique
                ? 'border-success'
                : null,
            ]" />
          <div v-if="$v.forgot_password.$dirty">
            <div
              v-if="!$v.forgot_password.required"
              class="error_2">
              Email is required.
            </div>
            <div
              v-if="!$v.forgot_password.email"
              class="error_2">
              Invalid email format.
            </div>
            <div
              v-if="!$v.forgot_password.isUnique"
              class="error_2">
              No account found with that email address.
            </div>
          </div>
          <div v-if="success">
            <div class="success">
              Password reset link has been sent to your email account, Please
              check your email.
            </div>
          </div>

          <div
            class="d-flex justify-content-center align-irems-center login-button"
            @click="forgot">
            <div v-if="!forgot_loading">Send</div>
            <div>
              <BeatLoader
                class="text-center"
                :loading="forgot_loading"
                color="#fff"
                size="0.5rem"></BeatLoader>
            </div>
          </div>
          <div
            class="d-flex justify-content-center align-irems-center back-to-button">
            <router-link to="/admin">
              <div class="text-button">Back to Log In</div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
import { forgetPassword } from "@/services/AdminUserService";
import BeatLoader from "vue-spinner/src/BeatLoader.vue";

export default {
  name: "AdminForgotPassword",
  components: { BeatLoader },
  mixins: [validationMixin],
  data() {
    return {
      forgot_password: "",
      forgot_loading: false,
      no_email: false,
      success: false,
    };
  },
  validations: {
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
    forgot_password() {
      this.no_email = false;
      this.$v.forgot_password.$reset();
    },
  },
  methods: {
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
          this.$router.push({
            name: "DashBoard",
          });
        }, 7000);
      } else {
        this.no_email = true;
        this.forgot_loading = false;
      }
    },
  },
};
</script>

<style scoped>
.admin-login-bg {
  background-color: #7e989c;
  height: 50vh;
  width: 100vw;
  padding-bottom: 1.75rem;
}

.admin-forgot-head {
  text-align: center;
  color: #fff;
  font-size: 1.75rem;
  padding-bottom: 1.25rem;
}

input {
  border: 1px solid #384648;
  padding: 0.25rem 1rem;
  margin-bottom: 0.5rem;
  width: 400px;
}

input:focus-visible {
  border: 1px solid #384648;
  outline: inherit;
}

.login-button {
  background-color: #985855;
  color: #fff;
  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  cursor: pointer;
  user-select: none;
  margin-top: 0.5rem;
}

.login-button:hover {
  background-color: #814643;
}

.back-to-button {
  background-color: #fff;
  color: #985855;
  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  user-select: none;
  margin-top: 0.5rem;
}

.text-button {
  cursor: pointer;
  color: #985855;
}

.text-button:hover {
  text-decoration: underline;
}

.forgot-admin {
  text-align: right;
  color: #fff;
  font-size: 0.9rem;
  margin-top: 1rem;
}

.admin-forgot-details {
  width: 400px;
  color: #fff;
  font-size: 0.9rem;
}

.admin-forgot-half {
  padding-top: 1.75rem;
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

.success {
  position: relative;
  width: 400px;
  color: #fff;
  background-color: #639551;
  font-size: 0.9rem;
  text-align: center;
}
</style>
