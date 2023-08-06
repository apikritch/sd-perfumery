<template>
  <div class="d-flex justify-content-center account-content h-100">
    <div class="account-width">
      <div class="account-header">My Information</div>

      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader">
        <MoonLoader color="#985855" />
      </div>

      <div v-if="!loading">
        <div class="padding-account-section">
          <div
            class="d-flex justify-content-between align-items-center account-topic-padding">
            <div class="account-topic">Personal Information</div>
            <div
              v-if="!personal_information"
              class="edit-text"
              @click="editPersonal">
              <div class="circle-icon-my-account">
                <font-awesome-icon icon="pen" />
              </div>
              Edit
            </div>
            <div v-if="personal_information">
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

          <div class="row align-items-center justify-content-end account-row">
            <div class="col-5 information-head text-end">
              <div class="text-danger d-inline">*</div>
              First Name:
            </div>
            <div class="col-7 information-input">
              <input
                v-model.trim="$v.user.first_name.$model"
                type="text"
                :disabled="!personal_information"
                :class="[
                  $v.user.first_name.$error ? 'border-fail' : 'input_border',
                  $v.user.first_name.required ? 'border-success' : null,
                  !personal_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.user.first_name.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.user.first_name.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-5 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Last Name:
            </div>
            <div class="col-7 information-input">
              <input
                v-model.trim="$v.user.last_name.$model"
                type="text"
                :disabled="!personal_information"
                :class="[
                  $v.user.last_name.$error ? 'border-fail' : 'input_border',
                  $v.user.last_name.required ? 'border-success' : null,
                  !personal_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.user.last_name.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.user.last_name.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="padding-account-section">
          <div
            class="d-flex justify-content-between align-items-center account-topic-padding">
            <div class="account-topic">Contact Information</div>
            <div
              v-if="!contact_information"
              class="edit-text"
              @click="editContact">
              <div class="circle-icon-my-account">
                <font-awesome-icon icon="pen" />
              </div>
              Edit
            </div>
            <div v-if="contact_information">
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

          <div class="row align-items-center justify-content-end account-row">
            <div class="col-5 information-head text-end">Email:</div>
            <div class="col-7 information-input">
              <div class="not-input-my-account">{{ user.email }}</div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-5 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Phone:
            </div>
            <div class="col-7 information-input">
              <input
                v-model.trim="$v.user.phone.$model"
                type="text"
                :disabled="!contact_information"
                :class="[
                  $v.user.phone.$error ? 'border-fail' : 'input_border',
                  $v.user.phone.required && $v.user.phone.numeric
                    ? 'border-success'
                    : null,
                  !contact_information ? 'disable-input' : null,
                ]" />
            </div>
            <div class="col-7 offset-5 offset_unique_my_ac">
              <div
                v-if="$v.user.phone.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.user.phone.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.user.phone.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="padding-account-section">
          <div
            class="d-flex justify-content-between align-items-center account-topic-padding">
            <div class="account-topic">Account Information</div>

            <div v-if="account_information">
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

          <div class="row align-items-center justify-content-end account-row">
            <div class="col-5 information-head text-end">Username:</div>
            <div class="col-7 information-input">
              <div class="not-input-my-account">{{ user.email }}</div>
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
            <div class="row align-items-center justify-content-end account-row">
              <div class="col-5 information-head text-end">
                <div class="text-danger d-inline">*</div>
                Current Password:
              </div>
              <div class="col-7 information-input">
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
              <div class="col-7 offset-5 offset_unique_my_ac">
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
                class="row align-items-center justify-content-end account-row">
                <div class="col-5 information-head text-end">
                  <div class="text-danger d-inline">*</div>
                  New Password:
                </div>
                <div class="col-7 information-input">
                  <input
                    v-model.trim="$v.new_password.$model"
                    type="password"
                    :class="[
                      $v.new_password.$error ? 'border-fail' : null,
                      $v.new_password.required && $v.new_password.minLength
                        ? 'border-success'
                        : null,
                    ]" />
                </div>
                <div class="col-7 offset-5 offset_unique_my_ac">
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
                class="row align-items-center justify-content-end account-row">
                <div class="col-5 information-head text-end">
                  <div class="text-danger d-inline">*</div>
                  Confirm New Password:
                </div>
                <div class="col-7 information-input">
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
                <div class="col-7 offset-5 offset_unique_my_ac">
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
import {
  getUserById,
  putUserById,
  changePassword,
} from "@/services/AdminUserService";
import { validationMixin } from "vuelidate";
import { required, minLength, sameAs, numeric } from "vuelidate/lib/validators";
export default {
  name: "AdminMyAccount",
  components: { MoonLoader },
  mixins: [validationMixin],

  data() {
    return {
      user: {},
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
    user: {
      first_name: { required },
      last_name: { required },
      phone: { required, numeric },
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
    "user.first_name"() {
      this.$v.user.first_name.$reset();
    },
    "user.last_name"() {
      this.$v.user.last_name.$reset();
    },
    "user.phone"() {
      this.$v.user.phone.$reset();
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
    const userId = this.$store.state.user.id;
    this.user = (await getUserById(userId)).data;
    this.loading = false;
    //console.log(this.$route);
  },
  methods: {
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
      const userId = this.$store.state.user.id;
      const response = await changePassword(userId, {
        current_password: this.current_password,
        new_password: this.new_password,
      });

      if (response.data.message !== "Fail") {
        this.incorrect_current_password = false;

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
    async editContact() {
      this.contact_information = true;
      this.personal_information = false;
      this.account_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const userId = this.$store.state.user.id;
      this.user = (await getUserById(userId)).data;
      this.resetAll();
    },
    async editAccount() {
      this.account_information = true;
      this.personal_information = false;
      this.contact_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const userId = this.$store.state.user.id;
      this.user = (await getUserById(userId)).data;
      this.resetAll();
    },
    async editPersonal() {
      this.personal_information = true;
      this.contact_information = false;
      this.account_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const userId = this.$store.state.user.id;
      this.user = (await getUserById(userId)).data;
      this.resetAll();
    },
    async cancelUpdate() {
      this.personal_information = false;
      this.contact_information = false;
      this.account_information = false;
      this.current_password = "";
      this.new_password = "";
      this.confirm_new_password = "";

      const userId = this.$store.state.user.id;
      this.user = (await getUserById(userId)).data;

      this.resetAll();
    },
    async saveInformation() {
      if (this.personal_information == true) {
        this.$v.user.first_name.$touch();
        this.$v.user.last_name.$touch();
        if (
          this.$v.user.first_name.$anyError ||
          this.$v.user.last_name.$anyError
        ) {
          return;
        }
      }

      if (this.contact_information == true) {
        this.$v.user.phone.$touch();
        if (this.$v.user.phone.$anyError) {
          return;
        }
      }

      const userId = this.$store.state.user.id;
      this.personal_information = false;
      this.contact_information = false;
      await putUserById(userId, this.user);
      this.resetAll();
    },
    resetAll() {
      this.$v.user.first_name.$reset();
      this.$v.user.last_name.$reset();
      this.$v.user.phone.$reset();
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
  width: 100%;
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
  padding-bottom: 2.5rem;
  border-bottom: 1px solid #b9b9b9;
}

.account-topic {
  font-weight: 700;
  font-size: 1.1rem;
  letter-spacing: 0.1px;
  padding-bottom: 0.5rem;
}

.information-head {
  font-weight: 400;
  font-size: 1rem;
  flex: 0 0 auto;
  width: 40%;
}

.information-input input {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.25rem 1rem;
}

.information-input {
  flex: 0 0 auto;
  width: 60%;
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

.account-topic-padding {
  padding-bottom: 0.5rem;
}

.edit-text {
  cursor: pointer;
  color: #639551;
}

.circle-icon-my-account {
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

.save-button {
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

.cancel-button {
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

.disable-input:disabled {
  background-color: #eeeeee;
}

.not-input-my-account {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.3rem 0rem 0.2rem 1rem;
  background-color: #eeeeee;
  user-select: none;
}

.change-password-button {
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
  height: 75%;
}
</style>
