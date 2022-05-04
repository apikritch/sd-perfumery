<template>
  <div class="admin-login-bg">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="d-flex flex-column">
        <div class="d-flex justify-content-center reset-logo">
          <font-awesome-icon icon="lock" />
        </div>
        <div class="admin-forgot-head">
          Reset Password
        </div>
        <div class="pb_reset">
          <input
            type="password"
            v-model.trim="$v.password.$model"
            placeholder="New Password"
            :class="[
              $v.password.$error ? 'border-fail' : null,
              $v.password.required && $v.password.minLength
                ? 'border-success'
                : null,
            ]"
          />
        </div>
        <div class="pb_reset">
          <input
            type="password"
            v-model.trim="$v.confirm_password.$model"
            placeholder="Confirm New Password"
            :class="[
              $v.confirm_password.$error ? 'border-fail' : null,
              $v.confirm_password.sameAsPassword && $v.password.required
                ? 'border-success'
                : null,
            ]"
          />
        </div>
        <div class="position-relative d-flex flex-column">
          <div v-if="$v.confirm_password.$dirty">
            <div
              class="error"
              v-if="
                !$v.confirm_password.sameAsPassword &&
                  $v.password.minLength &&
                  $v.password.required
              "
            >
              Passwords must be identical.
            </div>
          </div>
          <div v-if="$v.password.$dirty">
            <div class="error" v-if="!$v.password.required">
              Please enter your new password.
            </div>
            <div class="error" v-if="!$v.password.minLength">
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
        <div>
          <div class="login-button" @click="reset">
            <div v-if="!reset_loading">Reset Password</div>
            <BeatLoader
              :loading="reset_loading"
              color="#fff"
              size="0.5rem"
              class="text-center "
            ></BeatLoader>
          </div>
          <div class="login-button_2" @click="goHome">Home</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { resetPassword } from "@/services/CustomerService";
import { validationMixin } from "vuelidate";
import { required, minLength, sameAs } from "vuelidate/lib/validators";
import BeatLoader from "vue-spinner/src/BeatLoader.vue";

export default {
  name: "ResetPassword",
  components: { BeatLoader },
  data() {
    return {
      password: null,
      confirm_password: null,
      token: "",
      reset_loading: false,
      expire_link: false,
      success: false,
    };
  },
  mixins: [validationMixin],
  validations: {
    password: {
      required,
      minLength: minLength(6),
    },
    confirm_password: {
      required,
      sameAsPassword: sameAs("password"),
    },
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
      this.reset_loading = true;

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
        this.reset_loading = false;
        this.success = true;
        setTimeout(() => {
          this.success = false;
          this.$router.push({
            name: "Home",
          });
        }, 5000);
      } else {
        this.expire_link = true;
        this.reset_loading = false;
      }
    },
    goHome() {
      this.$router.push({
        name: "Home",
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

.sent_box {
  margin-top: 0.5rem;
  background-color: #fcdbd8;
  color: #dc3545;
  border: 2px solid #dc3545;
  font-size: 0.8rem;
  text-align: center;
  font-weight: 500;
  width: 400px;
  position: absolute;
}

.sent_box_2 {
  background-color: #e7f7e1;
  color: #639551;
  border: 2px solid #639551;
  font-size: 0.9rem;
  text-align: center;
  font-weight: 500;
  width: 400px;
  position: absolute;

  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  cursor: pointer;
  user-select: none;
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

.error {
  position: relative;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.9rem;
  text-align: center;
  width: 100%;
}

.pb_reset {
  padding-bottom: 0.55rem;
}

.border-fail {
  border: 1px solid #dc3545 !important;
}

.border-success {
  border: 2px solid #198754 !important;
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
</style>
