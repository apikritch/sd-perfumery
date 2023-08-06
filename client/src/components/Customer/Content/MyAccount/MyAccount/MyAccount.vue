<template>
  <div class="col-12 col-lg-9 d-flex justify-content-center account-content">
    <div class="container">
      <div class="account-header">My Information</div>

      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader">
        <MoonLoader color="#985855" />
      </div>

      <div v-if="!loading">
        <div class="padding-account-section">
          <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center account-topic-padding">
            <div class="account-topic mb-2 mb-sm-0">Personal Information</div>
            <div
              v-if="!personal_information"
              class="edit-text align-self-end"
              @click="editPersonal">
              <div class="circle-icon-my-account">
                <font-awesome-icon icon="pen" />
              </div>
              Edit
            </div>
            <div
              v-if="personal_information"
              class="align-self-end">
              <div class="d-flex">
                <div
                  class="cancel-button"
                  @click="cancelUpdate">
                  Cancel
                </div>
                <div
                  class="save-button ms-2"
                  @click="saveInformation">
                  Save
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              First Name:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.first_name.$model"
                type="text"
                :disabled="!personal_information"
                :class="[
                  $v.customer.first_name.$error
                    ? 'border-fail'
                    : 'input_border',
                  $v.customer.first_name.required ? 'border-success' : null,
                  !personal_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.first_name.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.first_name.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              Last Name:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.last_name.$model"
                type="text"
                :disabled="!personal_information"
                :class="[
                  $v.customer.last_name.$error ? 'border-fail' : 'input_border',
                  $v.customer.last_name.required ? 'border-success' : null,
                  !personal_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.last_name.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.last_name.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="padding-account-section">
          <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center account-topic-padding">
            <div class="account-topic mb-2 mb-sm-0">Contact Information</div>
            <div
              v-if="!contact_information"
              class="edit-text align-self-end"
              @click="editContact">
              <div class="circle-icon-my-account">
                <font-awesome-icon icon="pen" />
              </div>
              Edit
            </div>
            <div
              v-if="contact_information"
              class="align-self-end">
              <div class="d-flex">
                <div
                  class="cancel-button"
                  @click="cancelUpdate">
                  Cancel
                </div>
                <div
                  class="save-button ms-2"
                  @click="saveInformation">
                  Save
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              Email:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <div class="not-input-my-account">{{ customer.email }}</div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              Phone:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.phone.$model"
                type="text"
                :disabled="!contact_information"
                :class="[
                  $v.customer.phone.$error ? 'border-fail' : 'input_border',
                  $v.customer.phone.required && $v.customer.phone.numeric
                    ? 'border-success'
                    : null,
                  !contact_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.phone.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.phone.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.customer.phone.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              Address 1:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.address_1.$model"
                type="text"
                :disabled="!contact_information"
                :class="[
                  $v.customer.address_1.$error ? 'border-fail' : 'input_border',
                  $v.customer.address_1.required ? 'border-success' : null,
                  !contact_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.address_1.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.address_1.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              Address 2:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model="customer.address_2"
                type="text"
                :disabled="!contact_information"
                :class="!contact_information ? 'disable-input' : null" />
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              Town / City:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.city.$model"
                type="text"
                :disabled="!contact_information"
                :class="[
                  $v.customer.city.$error ? 'border-fail' : 'input_border',
                  $v.customer.city.required ? 'border-success' : null,
                  !contact_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.city.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.city.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              District / State:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.state.$model"
                type="text"
                :disabled="!contact_information"
                :class="[
                  $v.customer.state.$error ? 'border-fail' : 'input_border',
                  $v.customer.state.required ? 'border-success' : null,
                  !contact_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.state.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.state.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              <div class="text-danger d-inline">*</div>
              Postcode:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <input
                v-model.trim="$v.customer.postcode.$model"
                type="text"
                :disabled="!contact_information"
                :class="[
                  $v.customer.postcode.$error ? 'border-fail' : 'input_border',
                  $v.customer.postcode.required && $v.customer.postcode.numeric
                    ? 'border-success'
                    : null,
                  !contact_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.customer.postcode.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.customer.postcode.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.customer.postcode.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              Country:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <div class="not-input-my-account">{{ customer.country }}</div>
            </div>
          </div>
        </div>

        <div class="padding-account-section">
          <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center account-topic-padding">
            <div class="account-topic mb-2 mb-sm-0">Account Information</div>

            <div
              v-if="account_information"
              class="align-self-end">
              <div class="d-flex">
                <div
                  class="cancel-button"
                  @click="cancelUpdate">
                  Cancel
                </div>
                <div
                  class="save-button ms-2"
                  @click="savePassword">
                  Save
                </div>
              </div>
            </div>
          </div>

          <div
            class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
            <div
              class="col-12 col-sm-5 information-head text-start text-sm-end">
              Username:
            </div>
            <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
              <div class="not-input-my-account">{{ customer.email }}</div>
            </div>
          </div>

          <div
            v-if="!account_information"
            class="d-flex align-items-center justify-content-center account-row">
            <div
              class="change-password-button"
              @click="editAccount">
              Change Password
            </div>
          </div>

          <div v-if="account_information">
            <div
              class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
              <div
                class="col-12 col-sm-5 information-head text-start text-sm-end">
                <div class="text-danger d-inline">*</div>
                Current Password:
              </div>
              <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
                <input
                  v-model.trim="$v.current_password.$model"
                  type="password"
                  :class="[
                    $v.current_password.$error ? 'border-fail' : null,
                    $v.current_password.required && $v.current_password.isUnique
                      ? 'border-success'
                      : null,
                  ]" />
              </div>
              <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
                <div
                  v-if="$v.current_password.$dirty"
                  class="position-relative">
                  <div
                    v-if="!$v.current_password.required"
                    class="error">
                    Required
                  </div>
                  <div
                    v-if="!$v.current_password.isUnique"
                    class="error">
                    Incorrect Password
                  </div>
                </div>
              </div>
            </div>
            <div class="new-password">
              <div
                class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
                <div
                  class="col-12 col-sm-5 information-head text-start text-sm-end">
                  <div class="text-danger d-inline">*</div>
                  New Password:
                </div>
                <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
                  <input
                    v-model.trim="$v.new_password.$model"
                    type="password"
                    :disabled="!account_information"
                    :class="[
                      $v.new_password.$error ? 'border-fail' : null,
                      $v.new_password.required && $v.new_password.minLength
                        ? 'border-success'
                        : null,
                    ]" />
                </div>
                <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
                  <div
                    v-if="$v.new_password.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.new_password.required"
                      class="error">
                      Required
                    </div>
                    <div
                      v-if="!$v.new_password.minLength"
                      class="error">
                      Password must have at least 6 letters
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="row flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end account-row">
                <div
                  class="col-12 col-sm-5 information-head text-start text-sm-end">
                  <div class="text-danger d-inline">*</div>
                  Confirm New Password:
                </div>
                <div class="col-12 col-sm-7 information-input mt-1 mt-sm-0">
                  <input
                    v-model.trim="$v.confirm_new_password.$model"
                    type="password"
                    :class="[
                      $v.confirm_new_password.$error ? 'border-fail' : null,
                      $v.confirm_new_password.required &&
                      $v.confirm_new_password.sameAsNewPassword
                        ? 'border-success'
                        : null,
                    ]" />
                </div>
                <div class="col-12 col-sm-7 offset-5 offset_unique_my_ac">
                  <div
                    v-if="$v.confirm_new_password.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.confirm_new_password.required"
                      class="error">
                      Required
                    </div>
                    <div
                      v-if="!$v.confirm_new_password.sameAsNewPassword"
                      class="error">
                      Passwords must be identical
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="sent_box"
        :class="success ? 'visible' : 'hidden'">
        <font-awesome-icon
          icon="check"
          class="me-2" />Your password has been changed successfully!
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { validationMixin } from "vuelidate";
import { required, minLength, sameAs, numeric } from "vuelidate/lib/validators";
import {
  getCustomerById,
  putCustomerById,
  changePassword,
} from "@/services/CustomerService";
export default {
  name: "MyAccount",
  components: { MoonLoader },
  mixins: [validationMixin],

  data() {
    return {
      customer: {
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        address_1: "",
        address_2: "",
        city: "",
        state: "",
        postcode: "",
        country: "",
        password: "",
      },
      personal_information: false,
      contact_information: false,
      account_information: false,
      current_password: "",
      new_password: "",
      confirm_new_password: "",
      incorrect_current_password: false,
      success: false,
      loading: true,
    };
  },
  validations: {
    customer: {
      first_name: { required },
      last_name: { required },
      phone: { required, numeric },
      address_1: { required },
      city: { required },
      state: { required },
      postcode: { required, numeric },
    },
    current_password: {
      required,
      isUnique(value) {
        if (value !== "" && this.incorrect_current_password) {
          return false;
        } else {
          return true;
        }
      },
    },
    new_password: { required, minLength: minLength(6) },
    confirm_new_password: {
      required,
      sameAsNewPassword: sameAs("new_password"),
    },
  },
  watch: {
    "customer.first_name"() {
      this.$v.customer.first_name.$reset();
    },
    "customer.last_name"() {
      this.$v.customer.last_name.$reset();
    },
    "customer.phone"() {
      this.$v.customer.phone.$reset();
    },
    "customer.address_1"() {
      this.$v.customer.address_1.$reset();
    },
    "customer.city"() {
      this.$v.customer.city.$reset();
    },
    "customer.state"() {
      this.$v.customer.state.$reset();
    },
    "customer.postcode"() {
      this.$v.customer.postcode.$reset();
    },
    current_password() {
      this.incorrect_current_password = false;
      this.$v.current_password.$reset();
    },
    new_password() {
      this.$v.new_password.$reset();
    },
    confirm_new_password() {
      this.$v.confirm_new_password.$reset();
    },
  },
  async mounted() {
    const customerId = this.$store.state.customer.id;
    this.customer = (await getCustomerById(customerId)).data;
    this.loading = false;
  },
  methods: {
    async saveInformation() {
      if (this.personal_information == true) {
        this.$v.customer.first_name.$touch();
        this.$v.customer.last_name.$touch();
        if (
          this.$v.customer.first_name.$anyError ||
          this.$v.customer.last_name.$anyError
        ) {
          return;
        }
      }

      if (this.contact_information == true) {
        this.$v.customer.phone.$touch();
        this.$v.customer.address_1.$touch();
        this.$v.customer.city.$touch();
        this.$v.customer.state.$touch();
        this.$v.customer.postcode.$touch();
        if (
          this.$v.customer.phone.$anyError ||
          this.$v.customer.address_1.$anyError ||
          this.$v.customer.city.$anyError ||
          this.$v.customer.state.$anyError ||
          this.$v.customer.postcode.$anyError
        ) {
          return;
        }
      }

      const customerId = this.$store.state.customer.id;
      this.personal_information = false;
      this.contact_information = false;
      await putCustomerById(customerId, this.customer);
      this.resetAll();
    },
    async savePassword() {
      this.$v.current_password.$touch();
      this.$v.new_password.$touch();
      this.$v.confirm_new_password.$touch();

      if (
        this.$v.current_password.$anyError ||
        this.$v.new_password.$anyError ||
        this.$v.confirm_new_password.$anyError
      ) {
        return;
      }

      const customerId = this.$store.state.customer.id;

      const response = await changePassword(customerId, {
        current_password: this.current_password,
        new_password: this.new_password,
      });

      if (response.data.message !== "Fail") {
        this.account_information = false;

        this.success = true;
        this.account_information = false;
        setTimeout(() => {
          this.success = false;
          this.resetAll();
        }, 3000);
      } else {
        this.incorrect_current_password = true;
      }
    },
    async cancelUpdate() {
      this.personal_information = false;
      this.contact_information = false;
      this.account_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const customerId = this.$store.state.customer.id;
      this.customer = (await getCustomerById(customerId)).data;
      this.resetAll();
    },
    async editPersonal() {
      this.personal_information = true;
      this.contact_information = false;
      this.account_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const customerId = this.$store.state.customer.id;
      this.customer = (await getCustomerById(customerId)).data;
      this.resetAll();
    },
    async editContact() {
      this.contact_information = true;
      this.personal_information = false;
      this.account_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const customerId = this.$store.state.customer.id;
      this.customer = (await getCustomerById(customerId)).data;
      this.resetAll();
    },
    async editAccount() {
      this.account_information = true;
      this.personal_information = false;
      this.contact_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const customerId = this.$store.state.customer.id;
      this.customer = (await getCustomerById(customerId)).data;
      this.resetAll();
    },
    resetAll() {
      this.$v.customer.first_name.$reset();
      this.$v.customer.last_name.$reset();
      this.$v.customer.phone.$reset();
      this.$v.customer.address_1.$reset();
      this.$v.customer.city.$reset();
      this.$v.customer.state.$reset();
      this.$v.customer.postcode.$reset();
      this.$v.current_password.$reset();
      this.$v.new_password.$reset();
      this.$v.confirm_new_password.$reset();
    },
  },
};
</script>

<style scoped>
.account-content {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.padding-account-section {
  padding-top: 1.75rem;
  padding-bottom: 2.5rem;
  border-bottom: 1px solid #b9b9b9;
}

.account-topic {
  font-weight: 700;
  font-size: 1.1rem;
  letter-spacing: 0.1px;
  padding-top: 0.25rem;
  padding-bottom: 0.25rem;
}

.account-width {
  width: 50%;
}

.account-row {
  padding-top: 0.75rem;
}

.new-password {
  padding-top: 2rem;
}

.information-input input:focus-visible {
  border: 1px solid #b9b9b9;
  outline: none;
}

.account-content .circle-icon-my-account {
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

.account-content .edit-text align-self-end {
  cursor: pointer;
  color: #639551;
}

.account-content .save-button {
  background: #985855;
  border-radius: 0.5rem;
  text-align: center;
  color: #fff;
  font-size: 0.95rem;
  font-weight: 500;
  padding: 0.3rem 0rem 0.2rem 0rem;
  width: 4rem;
  cursor: pointer;
}

.account-content .cancel-button {
  background: #fff;
  border-radius: 0.5rem;
  text-align: center;
  color: #985855;
  font-size: 0.95rem;
  font-weight: 500;
  border: 1px solid #985855;
  padding: 0.3rem 0rem 0.2rem 0rem;
  width: 4rem;
  cursor: pointer;
}

.account-content .change-password-button {
  background: #fff;
  border-radius: 0.5rem;
  text-align: center;
  color: #985855;
  font-size: 0.95rem;
  font-weight: 500;
  border: 1px solid #985855;
  padding: 0.3rem 0.75rem 0.2rem 0.75rem;
  margin-top: 1rem;
  cursor: pointer;
}

.information-input .disable-input:disabled {
  background-color: #eeeeee;
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
  background: transparent url("./../../../../../assets/caret-down-solid.svg")
    no-repeat right 0.5rem center/20px 20px !important;
}

.border-fail:focus {
  border: 1px solid #b9b9b9 !important;
  outline: none !important;
  background-color: unset;
}

.offset_unique_my_ac {
  margin-left: 40%;
  width: 60%;
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

.visible {
  visibility: visible;
  display: block;
  opacity: 1;
  transition: opacity 0s linear;
}

.hidden {
  visibility: hidden;
  opacity: 0;
  transition:
    visibility 0s 1s,
    opacity 1s linear;
}

.cover_loader {
  height: 100%;
}

.container {
  max-width: 295px;
}

.information-input input {
  border-radius: 0.5rem;
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.25rem 0.5rem;
  overflow: hidden;
}

.not-input-my-account {
  border-radius: 0.5rem;
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.3rem 0rem 0.2rem 0.5rem;
  background-color: #eeeeee;
  user-select: none;
  overflow: hidden;
}

.information-input {
  flex: 0 0 auto;
  width: 100%;
  padding-left: calc(var(--bs-gutter-x) * 0.25);
}

.information-head {
  font-weight: 400;
  font-size: 1rem;
  flex: 0 0 auto;
  width: 100%;
  padding-right: calc(var(--bs-gutter-x) * 0.25);
}

.account-header {
  font-size: 2rem;
  font-weight: 500;
  padding-bottom: 1.75rem;
  border-bottom: 1px solid #384648;
  letter-spacing: 0.25px;
}

.account-topic-padding {
  padding-bottom: unset;
}

@media (min-width: 375px) {
  .container {
    max-width: 350px;
  }

  .account-header {
    font-size: 2.25rem;
  }
}

@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }

  .information-input input {
    padding: 0.25rem 1rem;
  }

  .not-input-my-account {
    padding: 0.3rem 0rem 0.2rem 1rem;
  }
  .information-input {
    padding-left: calc(var(--bs-gutter-x) * 0.5);
    width: 60%;
  }

  .information-head {
    padding-right: calc(var(--bs-gutter-x) * 0.5);
  }

  .information-head {
    width: 40%;
  }

  .account-topic-padding {
    padding-bottom: 0.5rem;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 720px;
  }
}

@media (min-width: 992px) {
  .container {
    max-width: 700px;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 850px;
  }
}

@media (min-width: 1400px) {
  .container {
    max-width: 1000px;
  }
}
</style>
