<template>
  <div class="d-flex justify-content-center account-content add-user-page">
    <div class="account-width">
      <form @submit.prevent="addItem">
        <div class="account-header">Add User</div>
        <div class="padding-account-section">
          <div class="account-topic">Personal Information</div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              First Name:
            </div>
            <div class="col-8 information-input">
              <input
                type="text"
                v-model.trim="$v.first_name.$model"
                :class="[
                  $v.first_name.$error ? 'border-fail' : 'input_border',
                  $v.first_name.required ? 'border-success' : null,
                ]"
              />
            </div>
            <div class="col-8 offset-4">
              <div v-if="$v.first_name.$dirty" class="position-relative">
                <div class="error" v-if="!$v.first_name.required">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Last Name:
            </div>
            <div class="col-8 information-input">
              <input
                type="text"
                v-model.trim="$v.last_name.$model"
                :class="[
                  $v.last_name.$error ? 'border-fail' : 'input_border',
                  $v.last_name.required ? 'border-success' : null,
                ]"
              />
            </div>
            <div class="col-8 offset-4">
              <div v-if="$v.last_name.$dirty" class="position-relative">
                <div class="error" v-if="!$v.last_name.required">
                  Required
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="padding-account-section">
          <div class="account-topic">Contact Information</div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Email:
            </div>
            <div class="col-8 information-input">
              <input
                type="text"
                v-model.trim="$v.email.$model"
                :class="[
                  $v.email.$error ? 'border-fail' : 'input_border',
                  $v.email.required && $v.email.email && $v.email.isUnique
                    ? 'border-success'
                    : null,
                ]"
              />
            </div>
            <div class="col-8 offset-4">
              <div v-if="$v.email.$dirty" class="position-relative">
                <div class="error" v-if="!$v.email.required">
                  Required
                </div>
                <div class="error" v-if="!$v.email.email">
                  Invalid email format
                </div>
                <div class="error" v-if="!$v.email.isUnique">
                  Email already exists. Please try with another one.
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Phone:
            </div>
            <div class="col-8 information-input">
              <input
                type="text"
                v-model.trim="$v.phone.$model"
                :class="[
                  $v.phone.$error ? 'border-fail' : 'input_border',
                  $v.phone.required && $v.phone.numeric
                    ? 'border-success'
                    : null,
                ]"
              />
            </div>
            <div class="col-8 offset-4">
              <div v-if="$v.phone.$dirty" class="position-relative">
                <div class="error" v-if="!$v.phone.required">
                  Required
                </div>
                <div class="error" v-if="!$v.phone.numeric">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
          <div class="padding-account-section">
            <div class="account-topic">Account Information</div>
            <div class="row align-items-center justify-content-end account-row">
              <div class="col-4 information-head text-end">
                <div class="text-danger d-inline">*</div>
                User Type:
              </div>
              <div class="col-8 information-input">
                <b-form-select
                  :options="user_type_options"
                  class="add-select-form"
                  v-model.trim="$v.user_type.$model"
                  :class="[
                    $v.user_type.$error ? 'select-fail' : null,
                    $v.user_type.required ? 'border-success' : null,
                  ]"
                />
              </div>
              <div class="col-8 offset-4">
                <div v-if="$v.user_type.$dirty" class="position-relative">
                  <div class="error" v-if="!$v.user_type.required">
                    Required
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">Username:</div>
            <div class="col-8 information-input">
              <div class="username-display">{{ email }}</div>
            </div>
          </div>
          <div class="new-password">
            <div class="row align-items-center justify-content-end account-row">
              <div class="col-4 information-head text-end">
                <div class="text-danger d-inline">*</div>
                Password:
              </div>
              <div class="col-8 information-input">
                <input
                  type="password"
                  v-model.trim="$v.password.$model"
                  :class="[
                    $v.password.$error ? 'border-fail' : null,
                    $v.password.required && $v.password.minLength
                      ? 'border-success'
                      : null,
                  ]"
                />
              </div>
              <div class="col-8 offset-4">
                <div v-if="$v.password.$dirty" class="position-relative">
                  <div class="error" v-if="!$v.password.required">
                    Required
                  </div>
                  <div class="error" v-if="!$v.password.minLength">
                    Password must have at least 6 letters
                  </div>
                </div>
              </div>
            </div>
            <div class="row align-items-center justify-content-end account-row">
              <div class="col-4 information-head text-end">
                <div class="text-danger d-inline">*</div>
                Confirm Password:
              </div>
              <div class="col-8 information-input">
                <input
                  type="password"
                  v-model.trim="$v.confirm_password.$model"
                  :class="[
                    $v.confirm_password.$error ? 'border-fail' : null,
                    $v.confirm_password.required &&
                    $v.confirm_password.sameAsPassword
                      ? 'border-success'
                      : null,
                  ]"
                />
              </div>
              <div class="col-8 offset-4">
                <div
                  v-if="$v.confirm_password.$dirty"
                  class="position-relative"
                >
                  <div class="error" v-if="!$v.confirm_password.required">
                    Required
                  </div>
                  <div
                    class="error"
                    v-if="
                      !$v.confirm_password.sameAsPassword &&
                        $v.confirm_password.required
                    "
                  >
                    Passwords must be identical
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="row pt-4">
            <div class="col-6">
              <button type="reset" @click="clearForm" class="button-cancel">
                Clear
              </button>
            </div>
            <div class="col-6">
              <button type="submit" class="button-save">Save</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="sent_box" :class="success ? 'visible' : 'hidden'">
      <font-awesome-icon icon="check" class="me-2" />User successfully added!
    </div>
    <div class="sent_box_2" :class="email_exist ? 'visible' : 'hidden'">
      <font-awesome-icon icon="check" class="me-2" />Email already exists.
      Please try with another one.
    </div>
  </div>
</template>

<script>
import { postUser } from "@/services/AdminUserService";
import { validationMixin } from "vuelidate";
import {
  required,
  email,
  minLength,
  sameAs,
  numeric,
} from "vuelidate/lib/validators";
import { getNewUserTypeOptions } from "@/services/AdminOptionService";

export default {
  name: "AddProduct",
  data() {
    return {
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      user_type: null,
      password: "",
      confirm_password: "",
      user_type_options: [],
      success: false,
      email_exist: false,
    };
  },
  mixins: [validationMixin],
  validations: {
    first_name: { required },
    last_name: { required },
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
    phone: { required, numeric },
    user_type: { required },
    password: { required, minLength: minLength(6) },
    confirm_password: { required, sameAsPassword: sameAs("password") },
  },
  watch: {
    first_name() {
      this.$v.first_name.$reset();
    },
    last_name() {
      this.$v.last_name.$reset();
    },
    email() {
      this.email_exist = false;
      this.$v.email.$reset();
    },
    phone() {
      this.$v.phone.$reset();
    },
    user_type() {
      this.$v.user_type.$reset();
    },
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
    async addItem() {
      this.$v.first_name.$touch();
      this.$v.last_name.$touch();
      this.$v.email.$touch();
      this.$v.phone.$touch();
      this.$v.user_type.$touch();
      this.$v.password.$touch();
      this.$v.confirm_password.$touch();

      if (
        this.$v.first_name.$anyError ||
        this.$v.last_name.$anyError ||
        this.$v.email.$anyError ||
        this.$v.phone.$anyError ||
        this.$v.user_type.$anyError ||
        this.$v.password.$anyError ||
        this.$v.confirm_password.$anyError
      ) {
        return;
      }

      let user = {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        phone: this.phone,
        user_type: this.user_type,
        password: this.password,
      };

      const response = (await postUser(user)).data;
      if (response.message !== "Fail") {
        this.email_exist = false;
        this.success = true;
        setTimeout(() => {
          this.success = false;
        }, 3000);
        this.clearForm();
      } else {
        this.email_exist = true;
      }
    },
    async init() {
      this.user_type_options = await getNewUserTypeOptions();
      this.$v.user_type.$reset();
    },
    clearForm() {
      this.first_name = null;
      this.last_name = null;
      this.email = null;
      this.phone = null;
      this.user_type = null;
      this.password = null;
      this.confirm_password = null;
      this.init();
    },
  },
  async mounted() {
    this.init();
  },
};
</script>

<style scoped>
.account-content {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.account-header {
  font-size: 2.25rem;
  font-weight: 500;
  padding-bottom: 1.75rem;
  border-bottom: 1px solid #384648;
  letter-spacing: 0.25px;
}

.padding-account-section {
  padding-top: 1.75rem;
  padding-bottom: 2rem;
  border-bottom: 1px solid #b9b9b9;
}

.information-head {
  font-weight: 400;
  font-size: 1rem;
  flex: 0 0 auto;
}

.information-input input {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.25rem 0.5rem;
}

.information-input select {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.25rem 0.5rem;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background: #fff url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px;
}

.account-width {
  width: 50%;
}

.account-row {
  padding-top: 0.75rem;
}

.unique-label {
  width: 25%;
}

.unique-label-cover {
  width: 15%;
}

.unique-row-left {
  width: 30%;
}

.unique-row-right {
  width: 30%;
}

.description-size {
  width: 100%;
  height: 6rem;
  resize: none;
  border: 1px solid #b9b9b9;
  padding: 0.25rem 0.5rem;
}

.description-size:focus-visible,
.information-input input.form-icon:focus-visible,
.information-input input.form-icon:focus,
.information-input select:focus-visible,
.information-input input:focus-visible {
  border: 1px solid #b9b9b9 !important;
  outline: none !important;
}

.show-discount {
  border: 1px solid #b9b9b9;
  width: 1%;
  padding: 0.25rem 0.5rem;
  background-color: #dee2e6;
  user-select: none;
  color: red;
  flex: 1 1 auto;
}

.information-input input.form-icon {
  width: 1%;
  border-radius: unset;
}

.information-input span.input-group-text {
  border-radius: unset;
  padding: 0.25rem 0.5rem;
  border: 1px solid #b9b9b9;
}

.add-select-form {
  cursor: pointer;
}

.button-save {
  background-color: #985855;
  color: #fff;
  border: 1px solid #985855;
  border-radius: 0.25rem;
  padding-top: 0.55rem;
  padding-bottom: 0.5rem;
  width: 100%;
  cursor: pointer;
  text-align: center;
  font-size: 1rem;
  letter-spacing: 0.25px;
  font-weight: 500;
}

.button-cancel {
  background-color: #fff;
  color: #985855;
  border: 1px solid #985855;
  border-radius: 0.25rem;
  padding-top: 0.55rem;
  padding-bottom: 0.5rem;
  width: 100%;
  cursor: pointer;
  text-align: center;
  font-size: 1rem;
  letter-spacing: 0.25px;
  font-weight: 500;
}

.disabled-discount:disabled {
  background-color: #dee2e6;
}

.account-topic {
  font-weight: 700;
  font-size: 1.1rem;
  letter-spacing: 0.1px;
  padding-bottom: 0.5rem;
}

.new-password {
  padding-top: 2rem;
}

.add-user-page .username-display {
  border: 1px solid #b9b9b9;
  height: 2.1rem;
  width: 100%;
  padding: 0.25rem 0.5rem;
  background-color: #dee2e6;
  user-select: none;
  flex: 1 1 auto;
}

.sent_box {
  background-color: #d8eed0;
  color: #639551;
  padding: 0.2rem 0.5rem 0.1rem 0.5rem;
  border: 2px solid #639551;
  position: fixed;
  right: 1rem;
  top: 4rem;
}

.sent_box_2 {
  background-color: #fcdbd8;
  color: #dc3545;
  padding: 0.2rem 0.5rem 0.1rem 0.5rem;
  border: 2px solid #dc3545;
  position: fixed;
  right: 1rem;
  top: 4rem;
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

.select-fail {
  border: 1px solid #dc3545 !important;
  background: #fcedf2 url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px !important;
}

.select-fail:focus {
  border: 1px solid #dc3545 !important;
  background: transparent url("./../../../../assets/caret-down-solid.svg")
    no-repeat right 0.5rem center/20px 20px !important;
}

.padding_fail {
  padding-top: 0.25rem;
}

.border-fail {
  border: 1px solid #dc3545 !important;
  background-color: #fcedf2;
}

.border-success {
  border: 1px solid #198754 !important;
}

.error {
  position: relative;
  color: #dc3545;
  font-size: 0.7rem;
  height: 100%;
}

.select-fail:focus {
  border: 1px solid #dc3545 !important;
  background: transparent url("./../../../../assets/caret-down-solid.svg")
    no-repeat right 0.5rem center/20px 20px !important;
}

.border-fail:focus {
  border: 1px solid #b9b9b9 !important;
  outline: none !important;
  background-color: unset;
}
</style>
