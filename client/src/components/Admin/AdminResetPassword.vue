<template>
  <div class="admin-login-bg">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="d-flex flex-column">
        <div class="d-flex justify-content-center reset-logo">
          <font-awesome-icon icon="user-lock" />
        </div>
        <div class="admin-forgot-head">
          Reset User Account Password
        </div>
        <input
          type="password"
          placeholder="New Password"
          v-model.trim="$v.password.$model"
          :class="[
            $v.password.$error || expire_link ? 'border_fail_2' : null,
            $v.password.required && $v.password.minLength && !expire_link
              ? 'border-success'
              : null,
          ]"
        />
        <input
          type="password"
          v-model.trim="$v.confirm_password.$model"
          placeholder="Confirm New Password"
          :class="[
            $v.confirm_password.$error || expire_link ? 'border_fail_2' : null,
            $v.confirm_password.sameAsPassword &&
            $v.password.required &&
            !expire_link
              ? 'border-success'
              : null,
          ]"
        />
        <div class="position-relative d-flex flex-column">
          <div
            v-if="$v.confirm_password.$dirty"
            class=" w-100"
            :class="
              $v.password.required && $v.password.minLength
                ? 'position-relative'
                : 'position-absolute'
            "
          >
            <div class="error_2" v-if="!$v.confirm_password.required">
              Please confirm your new password.
            </div>
            <div
              class="error_2"
              v-if="
                !$v.confirm_password.sameAsPassword &&
                  $v.password.minLength &&
                  $v.confirm_password.required
              "
            >
              Passwords must be identical.
            </div>
          </div>
          <div v-if="$v.password.$dirty" class=" position-relative w-100">
            <div class="error_2" v-if="!$v.password.required">
              Please enter your new password.
            </div>
            <div class="error_2" v-if="!$v.password.minLength">
              Password must have at least 6 letters.
            </div>
          </div>
          <div v-if="success">
            <div class="success">
              Your password successfully changed!
            </div>
          </div>
          <div v-if="expire_link">
            <div class="expire">
              Sorry, your reset password link expired or has already been used.
            </div>
          </div>
        </div>
        <div class="login-button" @click="reset">Reset Password</div>
        <div class="login-button_2" @click="goHome">Login</div>
      </div>
    </div>
  </div>
</template>

<script>
import { resetPassword } from "@/services/AdminUserService";
import { validationMixin } from "vuelidate";
import { required, minLength, sameAs } from "vuelidate/lib/validators";

export default {
  name: "AdminResetPassword",
  data() {
    return {
      password: null,
      confirm_password: null,
      token: "",
      expire_link: false,
      success: false,
    };
  },
  mixins: [validationMixin],
  validations: {
    password: { required, minLength: minLength(6) },
    confirm_password: { required, sameAsPassword: sameAs("password") },
  },
  watch: {
    password() {
      this.$v.password.$reset();
      this.$v.confirm_password.$reset();
    },
    confirm_password() {
      this.$v.password.$reset();
      this.$v.confirm_password.$reset();
    },
  },
  methods: {
    async reset() {
      this.$v.password.$touch();
      this.$v.confirm_password.$touch();
      if (this.$v.password.$anyError || this.$v.confirm_password.$anyError) {
        this.reset_loading = false;
        return;
      }

      const response = await resetPassword(this.token, {
        password: this.password,
      });

      if (response.data.message !== "Fail") {
        this.expire_link = false;
        this.success = true;

        setTimeout(() => {
          this.$router.push({
            name: "DashBoard",
          });
        }, 5000);
      } else {
        this.expire_link = true;
      }
    },
    goHome() {
      this.$router.push({
        name: "DashBoard",
      });
    },
  },
  async mounted() {
    this.token = await this.$store.state.route.params.token;
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
  border-bottom: 1px solid #fff;
  margin-bottom: 1.5rem;
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
  text-align: center;
  margin-top: 0.5rem;
}

.admin-login-bg .login-button_2 {
  color: #fff;
  font-weight: 300;
  cursor: pointer;
  user-select: none;
  text-align: center;
  margin-top: 1rem;
}

.admin-login-bg .login-button_2:hover {
  text-decoration: underline;
}

.forgot-admin {
  text-align: right;
  color: #fff;
  font-size: 0.9rem;
  margin-top: 1rem;
}

.reset-logo {
  font-size: 4rem;
  color: #fff;
  padding-bottom: 2rem;
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

.expire {
  position: relative;
  width: 400px;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.9rem;
  text-align: center;
}
</style>
