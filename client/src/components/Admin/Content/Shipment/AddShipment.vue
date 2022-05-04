<template>
  <div class="d-flex justify-content-center account-content add-user-page">
    <div class="account-width">
      <form @submit.prevent="addItem">
        <div class="account-header">Add Shipment</div>
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Shipping Method:
            </div>
            <div class="col-8 information-input">
              <input
                type="text"
                v-model.trim="$v.shipping_method.$model"
                :class="[
                  $v.shipping_method.$error ? 'border-fail' : 'input_border',
                  $v.shipping_method.required ? 'border-success' : null,
                ]"
              />
            </div>
            <div class="col-8 offset-4">
              <div v-if="$v.shipping_method.$dirty" class="position-relative">
                <div class="error" v-if="!$v.shipping_method.required">
                  Required
                </div>
              </div>
            </div>
          </div>

          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Shipping Fee:
            </div>

            <div class="col-8 information-input ">
              <div class="input-group">
                <span class="input-group-text">Rs.</span>
                <input
                  type="text"
                  class="form-control form-icon text-end"
                  v-model.trim="$v.shipping_fee.$model"
                  :class="[
                    $v.shipping_fee.$error ? 'border-fail' : 'input_border',
                    $v.shipping_fee.required && $v.shipping_fee.decimal
                      ? 'border-success'
                      : null,
                  ]"
                />
              </div>
            </div>
            <div class="col-8 offset-4">
              <div v-if="$v.shipping_fee.$dirty" class="position-relative">
                <div class="error" v-if="!$v.shipping_fee.required">
                  Required
                </div>
                <div class="error" v-if="!$v.shipping_fee.decimal">
                  Invalid value
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
      <font-awesome-icon icon="check" class="me-2" />Shipment successfully
      added!
    </div>
  </div>
</template>

<script>
import { postShipment } from "@/services/ShipmentService";
import { validationMixin } from "vuelidate";
import { required, decimal } from "vuelidate/lib/validators";

export default {
  name: "AddShipment",
  data() {
    return {
      shipping_method: "",
      shipping_fee: "",
      success: false,
    };
  },
  mixins: [validationMixin],
  validations: {
    shipping_method: { required },
    shipping_fee: { required, decimal },
  },
  watch: {
    shipping_method() {
      this.$v.shipping_method.$reset();
    },
    shipping_fee() {
      this.$v.shipping_fee.$reset();
    },
  },
  methods: {
    async addItem() {
      this.$v.shipping_method.$touch();
      this.$v.shipping_fee.$touch();
      if (this.$v.shipping_method.$anyError || this.$v.shipping_fee.$anyError) {
        return;
      }

      const shipment = {
        shipping_method: this.shipping_method,
        shipping_fee: this.shipping_fee,
      };

      try {
        const response = (await postShipment(shipment)).data;
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
      this.shipping_method = null;
      this.shipping_fee = null;
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

.information-input input {
  width: 100%;
  padding: 0.25rem 0.5rem;
}

.information-input input.form-icon {
  width: 1%;
  border-radius: unset;
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
  transition: visibility 0s 1s, opacity 1s linear;
}

.border-fail {
  border: 1px solid #dc3545;
  background-color: #fcedf2;
}

.border-fail:focus {
  border: 1px solid #b9b9b9 !important;
  background-color: unset !important;
  outline: unset;
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
  outline: unset;
}

.input_border:focus {
  border: 1px solid #b9b9b9 !important;
}

.information-input span.input-group-text {
  border-radius: unset;
  padding: 0.25rem 0.5rem;
  border: 1px solid #b9b9b9;
}
</style>
