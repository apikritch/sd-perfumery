<template>
  <div
    class="d-flex justify-content-center account-content edit-product-page h-100">
    <div class="account-width">
      <div class="account-header">Edit Shipment</div>
      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader">
        <MoonLoader color="#985855" />
      </div>
      <div v-if="!loading">
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-4 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Shipping Method:
            </div>
            <div class="col-8 information-input">
              <input
                v-model.trim="$v.shipment.shipping_method.$model"
                type="text"
                :class="[
                  $v.shipment.shipping_method.$error ? 'border-fail' : null,
                  $v.shipment.shipping_method.required
                    ? 'border-success'
                    : null,
                ]" />
            </div>
            <div class="col-8 offset-4">
              <div
                v-if="$v.shipment.shipping_method.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.shipment.shipping_method.required"
                  class="error">
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
            <div class="col-8 information-input">
              <input
                v-model.trim="$v.shipment.shipping_fee.$model"
                type="text"
                :class="[
                  $v.shipment.shipping_fee.$error ? 'border-fail' : null,
                  $v.shipment.shipping_fee.required &&
                  $v.shipment.shipping_fee.decimal
                    ? 'border-success'
                    : null,
                ]" />
            </div>
            <div class="col-8 offset-4">
              <div
                v-if="$v.shipment.shipping_fee.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.shipment.shipping_fee.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.shipment.shipping_fee.decimal"
                  class="error">
                  Invalid value
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
                @click="backPage">
                Back
              </button>
            </div>
            <div class="col-6">
              <button
                class="button-save"
                @click="saveItem">
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getShipmentbyId, putShipmentById } from "@/services/ShipmentService";
import { validationMixin } from "vuelidate";
import { required, decimal } from "vuelidate/lib/validators";

export default {
  name: "EditShipment",
  components: { MoonLoader },
  mixins: [validationMixin],

  data() {
    return {
      shipment: {
        shipping_method: "",
        shipping_fee: "",
      },
      loading: true,
    };
  },
  validations: {
    shipment: {
      shipping_method: { required },
      shipping_fee: { required, decimal },
    },
  },
  watch: {
    "shipment.shipping_method"() {
      this.$v.shipment.shipping_method.$reset();
    },
    "shipment.shipping_fee"() {
      this.$v.shipment.shipping_fee.$reset();
    },
  },
  async mounted() {
    const shipmentId = this.$store.state.route.params.shipmentId;
    this.shipment = (await getShipmentbyId(shipmentId)).data;
    this.loading = false;
  },
  methods: {
    backPage() {
      this.$router.push({
        name: "Shipment",
      });
    },
    async saveItem() {
      this.$v.shipment.shipping_method.$touch();
      this.$v.shipment.shipping_fee.$touch();

      if (
        this.$v.shipment.shipping_method.$anyError ||
        this.$v.shipment.shipping_fee.$anyError
      ) {
        return;
      }

      const shipmentId = this.$store.state.route.params.shipmentId;
      try {
        await putShipmentById(shipmentId, this.shipment);
        this.$router.go(-1);
      } catch (error) {
        console.log(error);
      }
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

.preview-img {
  object-fit: cover;
  height: 31rem;
}

.preview-frame {
  border: 1px solid #b9b9b9;
}

.edit-product-page .loading-height {
  height: 70vh;
}

.information-input .border-fail {
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

.information-input input {
  border: 1px solid #b9b9b9;
  width: 100%;
  padding: 0.25rem 0.5rem;
}

.cover_loader {
  height: 75%;
}
</style>
