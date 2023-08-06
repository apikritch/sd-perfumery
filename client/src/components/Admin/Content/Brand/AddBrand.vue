<template>
  <div class="d-flex justify-content-center account-content add-user-page">
    <div class="account-width">
      <form @submit.prevent="addItem">
        <div class="account-header">Add Brand</div>
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Brand:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.brand_name.$model"
                type="text"
                :class="[
                  $v.brand_name.$error ? 'border-fail' : 'input_border',
                  $v.brand_name.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.brand_name.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.brand_name.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="row pt-4">
            <div class="col-6">
              <button
                type="reset"
                class="button-cancel"
                @click="clearForm">
                Clear
              </button>
            </div>
            <div class="col-6">
              <button
                type="submit"
                class="button-save">
                Save
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div
      class="sent_box"
      :class="success ? 'visible' : 'hidden'">
      <font-awesome-icon
        icon="check"
        class="me-2" />Brand successfully added!
    </div>
  </div>
</template>

<script>
import { postBrand } from "@/services/AdminOptionService";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "AddBrand",
  mixins: [validationMixin],
  data() {
    return {
      brand_name: "",
      success: false,
    };
  },
  validations: {
    brand_name: { required },
  },
  watch: {
    brand_name() {
      this.$v.brand_name.$reset();
    },
  },
  methods: {
    async addItem() {
      this.$v.brand_name.$touch();
      if (this.$v.brand_name.$anyError) {
        return;
      }

      const brand = {
        value: this.brand_name,
        text: this.brand_name,
      };

      try {
        const response = (await postBrand(brand)).data;
        if (response.message == "Success") {
          this.success = true;
          setTimeout(() => {
            this.success = false;
          }, 3000);
        }
      } catch (error) {
        console.log(error);
      }

      this.clearForm();
    },
    clearForm() {
      this.brand_name = null;
    },
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
  width: 100%;
  padding: 0.25rem 0.5rem;
}

.information-input input:focus {
  outline: unset;
}

.border-fail:focus {
  border-color: #b9b9b9;
  background-color: unset;
}

.account-width {
  width: 50%;
}

.account-row {
  padding-top: 0.75rem;
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

.border-fail {
  border: 1px solid #dc3545;
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
.input_border {
  border: 1px solid #b9b9b9;
}
</style>
