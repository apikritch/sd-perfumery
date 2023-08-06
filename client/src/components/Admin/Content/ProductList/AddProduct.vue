<template>
  <div class="d-flex justify-content-center account-content">
    <div class="account-width">
      <form @submit.prevent="addItem">
        <div class="account-header">Add Product</div>
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">Preview:</div>
            <div class="col-9 information-input">
              <img
                :src="image"
                width="100%"
                class="preview-img"
                :class="image !== '' ? 'preview-frame' : null" />
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Image Link:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.image.$model"
                type="text"
                :class="[
                  $v.image.$error ? 'border-fail' : null,
                  $v.image.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.image.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.image.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.image.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Title:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.title.$model"
                type="text"
                :class="[
                  $v.title.$error ? 'border-fail' : null,
                  $v.title.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.title.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.title.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.title.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Brand:
            </div>
            <div class="col-9 information-input">
              <b-form-select
                v-model.trim="$v.brand.$model"
                :options="brand_options"
                class="add-select-form"
                :class="[
                  $v.brand.$error ? 'select-fail' : null,
                  $v.brand.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.brand.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.brand.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.brand.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Type:
            </div>
            <div class="col-9 information-input">
              <b-form-select
                v-model.trim="$v.type.$model"
                :options="type_options"
                class="add-select-form"
                :class="[
                  $v.type.$error ? 'select-fail' : null,
                  $v.type.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.type.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.type.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.type.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end unique-label">
              <div class="text-danger d-inline">*</div>
              Size:
            </div>
            <div class="col-4 information-input unique-row-left">
              <div class="input-group">
                <input
                  v-model.trim="$v.size.$model"
                  type="text"
                  class="form-control form-icon"
                  :class="[
                    $v.size.$error ? 'border-fail' : null,
                    $v.size.requiredv && $v.size.numeric
                      ? 'border-success'
                      : null,
                  ]" />
                <span
                  class="input-group-text"
                  :class="$v.size.$error ? 'only-border' : null"
                  >ml</span
                >
              </div>
            </div>

            <div
              class="col-1 information-head text-end unique-label-cover text-end unique_mandatory"
              :class="$v.type.$error ? 'padding_fail' : null">
              <div>
                <div class="text-danger d-inline">*</div>
                Gender:
              </div>
            </div>
            <div class="col-4 information-input unique-row-right">
              <b-form-select
                v-model.trim="$v.gender.$model"
                :options="gender_options"
                class="add-select-form"
                :class="[
                  $v.gender.$error ? 'select-fail' : null,
                  $v.gender.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-4 offset-3 unique-row-right">
              <div
                v-if="$v.size.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.size.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.size.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
            <div class="col-4 offset-unique unique-row-right">
              <div
                v-if="$v.gender.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.gender.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-start justify-content-end account-row"
            :class="$v.size.$error || $v.gender.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Description:
            </div>
            <div class="col-9 information-input textarea-height">
              <textarea
                v-model.trim="$v.description.$model"
                type="text"
                class="description-size"
                :class="[
                  $v.description.$error ? 'border-fail' : null,
                  $v.description.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.description.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.description.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end unique-label">
              <div class="text-danger d-inline">*</div>
              Quantity:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.stock.$model"
                type="text"
                :class="[
                  $v.stock.$error ? 'border-fail' : null,
                  $v.stock.required && $v.stock.numeric
                    ? 'border-success'
                    : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.stock.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.stock.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.stock.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">Discount:</div>
            <div class="col-2 information-input">
              <b-form-select
                v-model="discount"
                :options="discount_options"
                class="add-select-form"></b-form-select>
            </div>
            <div class="col-2 information-input">
              <input
                v-if="enable_discount"
                v-model.trim="$v.discount_number.$model"
                type="text"
                :class="[
                  $v.discount_number.$error ? 'border-fail' : null,
                  $v.discount_number.required && $v.discount_number.decimal
                    ? 'border-success'
                    : null,
                ]" />
              <input
                v-if="!enable_discount"
                type="text"
                disabled
                class="disabled-discount" />
            </div>
            <div
              class="col-1 information-head text-end unique-label-cover-2 text-end unique_mandatory">
              <div>
                <div class="text-danger d-inline">*</div>
                Price:
              </div>
            </div>
            <div class="col-4 information-input unique-row-right">
              <div class="input-group">
                <span
                  class="input-group-text"
                  :class="$v.price.$error ? 'only-border' : null"
                  >Rs.</span
                >
                <input
                  v-model.trim="$v.price.$model"
                  type="text"
                  class="form-control form-icon text-end"
                  :class="[
                    $v.price.$error ? 'border-fail' : null,
                    $v.price.required && $v.price.decimal
                      ? 'border-success'
                      : null,
                  ]" />
              </div>
            </div>
            <div class="col-2 offset-discount">
              <div
                v-if="$v.discount_number.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.discount_number.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.discount_number.decimal"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
            <div class="col-4 offset-price">
              <div
                v-if="$v.price.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.price.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.price.decimal"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">Final Price:</div>

            <div class="col-9 information-input">
              <div class="input-group">
                <span class="input-group-text">Rs.</span>
                <div
                  class="show-discount text-end"
                  :class="discount ? 'is-discount' : null">
                  {{ final_price }}
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
        class="me-2" />Product successfully added!
    </div>
  </div>
</template>

<script>
import { postProduct } from "@/services/ProductService";
import { validationMixin } from "vuelidate";
import { required, numeric, decimal } from "vuelidate/lib/validators";
import {
  getTypeOptions,
  getGenderOptions,
  getBrandOptions,
  getDiscountOptions,
} from "@/services/AdminOptionService";

export default {
  name: "AddProduct",
  mixins: [validationMixin],
  data() {
    return {
      image: "",
      title: "",
      brand: null,
      type: null,
      size: "",
      gender: null,
      description: "",
      stock: "",
      price: null,
      discount: null,
      discount_number: null,
      final_price: "",
      type_options: [],
      gender_options: [],
      brand_options: [{ value: null, text: "Select" }],
      discount_options: [],
      enable_discount: false,
      success: false,
    };
  },
  validations: {
    image: { required },
    title: { required },
    brand: { required },
    type: { required },
    size: { required, numeric },
    gender: { required },
    description: { required },
    stock: { required, numeric },
    discount_number: { required, decimal },
    price: { required, decimal },
  },
  watch: {
    image() {
      this.$v.image.$reset();
    },
    title() {
      this.$v.title.$reset();
    },
    brand() {
      this.$v.brand.$reset();
    },
    type() {
      this.$v.type.$reset();
    },
    size() {
      this.$v.size.$reset();
    },
    gender() {
      this.$v.gender.$reset();
    },
    description() {
      this.$v.description.$reset();
    },
    stock() {
      this.$v.stock.$reset();
    },
    discount(val) {
      this.$v.discount_number.$reset();
      if (val == "%") {
        this.enable_discount = true;
        this.final_price =
          this.price - (this.discount_number / 100) * this.price;
      } else if (val == "Rs.") {
        this.enable_discount = true;
        this.final_price = this.price - this.discount_number;
      } else if (val == null) {
        this.enable_discount = false;
        this.final_price = this.price;
        this.discount_number = null;
      }
    },
    discount_number(val) {
      this.$v.discount_number.$reset();
      if (this.discount == "%") {
        this.final_price = this.price - (val / 100) * this.price;
      } else if (this.discount == "Rs.") {
        this.final_price = this.price - val;
      }
    },
    price(val) {
      this.$v.price.$reset();
      if (
        this.discount == null &&
        this.discount_number == null &&
        val !== null
      ) {
        this.final_price = val;
      } else if (this.discount == "%" && val !== null) {
        this.final_price = val - (this.discount_number / 100) * val;
      } else if (this.discount == "Rs." && val !== null) {
        this.final_price = val - this.discount_number;
      }
    },
  },
  async mounted() {
    this.init();
  },

  methods: {
    async addItem() {
      this.$v.image.$touch();
      this.$v.title.$touch();
      this.$v.brand.$touch();
      this.$v.type.$touch();
      this.$v.size.$touch();
      this.$v.gender.$touch();
      this.$v.description.$touch();
      this.$v.stock.$touch();
      this.$v.price.$touch();

      if (this.discount !== null) {
        this.$v.discount_number.$touch();
        if (this.$v.discount_number.$anyError) {
          return;
        }
      }

      if (
        this.$v.image.$anyError ||
        this.$v.title.$anyError ||
        this.$v.brand.$anyError ||
        this.$v.type.$anyError ||
        this.$v.size.$anyError ||
        this.$v.gender.$anyError ||
        this.$v.description.$anyError ||
        this.$v.stock.$anyError ||
        this.$v.price.$anyError
      ) {
        return;
      }

      let product = {
        image: this.image,
        title: this.title,
        brand: this.brand,
        type: this.type,
        size: this.size,
        gender: this.gender,
        description: this.description,
        stock: this.stock,
        price: this.price,
        discount: this.discount,
        discount_number: this.discount_number,
        final_price: this.final_price,
      };

      const response = (await postProduct(product)).data;
      if (response.message == "Success") {
        this.success = true;
        setTimeout(() => {
          this.success = false;
        }, 3000);
      }

      this.clearForm();
      this.init();
    },
    clearForm() {
      this.image = "";
      this.title = null;
      this.brand = null;
      this.type = null;
      this.size = null;
      this.gender = null;
      this.description = null;
      this.stock = null;
      this.price = null;
      this.discount = null;
      this.discount_number = null;
      this.final_price = null;
    },
    async init() {
      const allbrand = (await getBrandOptions()).data;
      const sort_all_brand = [...allbrand].sort((b1, b2) => {
        var brand_a = b1.text;
        var brand_b = b2.text;

        if (brand_a < brand_b) {
          return -1;
        }

        if (brand_a > brand_b) {
          return 1;
        }

        return 0;
      });
      this.brand_options.push(...sort_all_brand);
      this.type_options = await getTypeOptions();
      this.gender_options = await getGenderOptions();
      this.discount_options = await getDiscountOptions();
      this.$v.brand.$reset();
      this.$v.type.$reset();
      this.$v.gender.$reset();
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

.unique-label-cover-2 {
  width: 11.65%;
}

.unique-row-left {
  width: 30%;
}

.unique-row-right {
  width: 30%;
}

.description-size {
  width: 100%;
  height: 100%;
  resize: none;
  border: 1px solid #b9b9b9;
  padding: 0.25rem 0.5rem;
}

.description-size:focus-visible,
.information-input input.form-icon:focus-visible,
.information-input input.form-icon:focus,
.information-input select:focus-visible,
.information-input input:focus-visible,
.border-fail:focus,
.select-fail:focus {
  border: 1px solid #b9b9b9 !important;
  outline: none !important;
  background-color: unset;
}

.show-discount {
  border: 1px solid #b9b9b9;
  width: 1%;
  padding: 0.25rem 0.5rem;
  background-color: #dee2e6;
  user-select: none;

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
  border-radius: 0.65rem;
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
  border-radius: 0.65rem;
  padding-top: 0.55rem;
  padding-bottom: 0.5rem;
  width: 100%;
  cursor: pointer;
  text-align: center;
  font-size: 1rem;
  letter-spacing: 0.25px;
  font-weight: 500;
}

.button-cancel:hover {
  background-color: #fff9fb;
}

.button-save:hover {
  background-color: #814643;
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

.is-discount {
  color: #f44336;
}

.textarea-height {
  height: 6rem;
}

.offset-unique {
  margin-left: 15%;
}

.offset-discount {
  margin-left: 41.66%;
}
.offset-price {
  margin-left: 11.65%;
  width: 30%;
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

.unique_mandatory {
  padding-left: unset;
}
</style>
