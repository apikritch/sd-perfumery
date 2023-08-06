<template>
  <div
    class="d-flex justify-content-center account-content edit-product-page h-100">
    <div class="account-width">
      <div class="account-header">Edit Product</div>
      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader">
        <MoonLoader color="#985855" />
      </div>
      <div v-if="!loading">
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">Preview:</div>
            <div class="col-9 information-input">
              <img
                :src="product.image"
                width="100%"
                class="preview-img"
                :class="product.image !== '' ? 'preview-frame' : null" />
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Image Link:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.product.image.$model"
                type="text"
                :class="[
                  $v.product.image.$error ? 'border-fail' : null,
                  $v.product.image.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.product.image.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.image.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.product.image.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Title:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.product.title.$model"
                type="text"
                :class="[
                  $v.product.title.$error ? 'border-fail' : null,
                  $v.product.title.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.product.title.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.title.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.product.title.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Brand:
            </div>
            <div class="col-9 information-input">
              <b-form-select
                v-model.trim="$v.product.brand.$model"
                :options="brand_options"
                class="add-select-form"
                :class="[
                  $v.product.brand.$error ? 'select-fail' : null,
                  $v.product.brand.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.product.brand.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.brand.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.product.brand.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Type:
            </div>
            <div class="col-9 information-input">
              <b-form-select
                v-model.trim="$v.product.type.$model"
                :options="type_options"
                class="add-select-form"
                :class="[
                  $v.product.type.$error ? 'select-fail' : null,
                  $v.product.type.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.product.type.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.type.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-center justify-content-end account-row"
            :class="$v.product.type.$error ? 'padding_fail' : null">
            <div class="col-3 information-head text-end unique-label">
              <div class="text-danger d-inline">*</div>
              Size:
            </div>
            <div class="col-4 information-input unique-row-left">
              <div class="input-group">
                <input
                  v-model.trim="$v.product.size.$model"
                  type="text"
                  class="form-control form-icon"
                  :class="[
                    $v.product.size.$error ? 'border-fail' : null,
                    $v.product.size.required ? 'border-success' : null,
                  ]" />
                <span
                  class="input-group-text"
                  :class="$v.product.size.$error ? 'only-border' : null"
                  >ml</span
                >
              </div>
            </div>
            <div
              class="col-1 information-head text-end unique-label-cover text-end unique_mandatory"
              :class="$v.product.type.$error ? 'padding_fail' : null">
              <div>
                <div class="text-danger d-inline">*</div>
                Gender:
              </div>
            </div>
            <div class="col-4 information-input unique-row-right">
              <b-form-select
                v-model.trim="$v.product.gender.$model"
                :options="gender_options"
                class="add-select-form"
                :class="[
                  $v.product.gender.$error ? 'select-fail' : null,
                  $v.product.gender.required && $v.product.size.numeric
                    ? 'border-success'
                    : null,
                ]" />
            </div>
            <div class="col-4 offset-3 unique-row-right">
              <div
                v-if="$v.product.size.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.size.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.product.size.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
            <div class="col-4 offset-unique unique-row-right">
              <div
                v-if="$v.product.gender.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.gender.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div
            class="row align-items-start justify-content-end account-row"
            :class="
              $v.product.size.$error || $v.product.gender.$error
                ? 'padding_fail'
                : null
            ">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Description:
            </div>
            <div class="col-9 information-input textarea-height">
              <textarea
                v-model.trim="$v.product.description.$model"
                type="text"
                class="description-size"
                :class="[
                  $v.product.description.$error ? 'border-fail' : null,
                  $v.product.description.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.product.description.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.description.required"
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
                v-model.trim="$v.product.stock.$model"
                type="text"
                :class="[
                  $v.product.stock.$error ? 'border-fail' : null,
                  $v.product.stock.required && $v.product.stock.numeric
                    ? 'border-success'
                    : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.product.stock.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.stock.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.product.stock.numeric"
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
                v-model="product.discount"
                :options="discount_options"
                class="add-select-form"></b-form-select>
            </div>
            <div class="col-2 information-input">
              <input
                v-if="enable_discount"
                v-model.trim="$v.product.discount_number.$model"
                type="text"
                :class="[
                  $v.product.discount_number.$error ? 'border-fail' : null,
                  $v.product.discount_number.required &&
                  $v.product.discount_number.decimal
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
                  :class="$v.product.price.$error ? 'only-border' : null"
                  >Rs.</span
                >
                <input
                  v-model.trim="$v.product.price.$model"
                  type="text"
                  class="form-control form-icon text-end"
                  :class="[
                    $v.product.price.$error ? 'border-fail' : null,
                    $v.product.price.required && $v.product.price.decimal
                      ? 'border-success'
                      : null,
                  ]" />
              </div>
            </div>
            <div class="col-2 offset-discount">
              <div
                v-if="$v.product.discount_number.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.discount_number.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.product.discount_number.decimal"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
            <div class="col-4 offset-price">
              <div
                v-if="$v.product.price.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.product.price.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.product.price.decimal"
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
                  :class="product.discount ? 'is-discount' : null">
                  {{ product.final_price }}
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
import { getProductById, putProductById } from "@/services/ProductService";
import { validationMixin } from "vuelidate";
import { required, numeric, decimal } from "vuelidate/lib/validators";
import {
  getTypeOptions,
  getGenderOptions,
  getBrandOptions,
  getDiscountOptions,
} from "@/services/AdminOptionService";

export default {
  name: "EditProduct",
  components: { MoonLoader },
  mixins: [validationMixin],

  data() {
    return {
      product: {
        image: "",
        title: "",
        brand: "",
        type: "",
        size: "",
        gender: "",
        description: "",
        stock: "",
        price: "",
        discount: "",
        discount_number: "",
        final_price: "",
      },
      type_options: [],
      gender_options: [],
      brand_options: [{ value: null, text: "Select" }],
      discount_options: [],
      enable_discount: false,
      loading: true,
      loading_2: true,
    };
  },
  validations: {
    product: {
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
  },
  watch: {
    "product.image"() {
      this.$v.product.image.$reset();
    },
    "product.title"() {
      this.$v.product.title.$reset();
    },
    "product.brand"() {
      this.$v.product.brand.$reset();
    },
    "product.type"() {
      this.$v.product.type.$reset();
    },
    "product.size"() {
      this.$v.product.size.$reset();
    },
    "product.gender"() {
      this.$v.product.gender.$reset();
    },
    "product.description"() {
      this.$v.product.description.$reset();
    },
    "product.stock"() {
      this.$v.product.stock.$reset();
    },
    "product.discount": function (val) {
      this.$v.product.discount_number.$reset();
      if (val == "%") {
        this.enable_discount = true;
        this.product.final_price =
          this.product.price -
          (this.product.discount_number / 100) * this.product.price;
      } else if (val == "Rs.") {
        this.enable_discount = true;
        this.product.final_price =
          this.product.price - this.product.discount_number;
      } else {
        this.enable_discount = false;
        this.product.final_price = this.product.price;
        this.product.discount_number = null;
      }
    },
    "product.discount_number": function (val) {
      this.$v.product.discount_number.$reset();
      if (this.product.discount == "%") {
        this.product.final_price =
          this.product.price - (val / 100) * this.product.price;
      } else if (this.product.discount == "Rs.") {
        this.product.final_price = this.product.price - val;
      }
    },
    "product.price": function (val) {
      this.$v.product.price.$reset();

      if (
        this.product.discount == null &&
        this.product.discount_number == null &&
        val !== null
      ) {
        this.product.final_price = val;
      } else if (this.product.discount == "%" && val !== null) {
        this.product.final_price =
          val - (this.product.discount_number / 100) * val;
      } else if (this.product.discount == "Rs." && val !== null) {
        this.product.final_price = val - this.product.discount_number;
      }
    },
  },
  async mounted() {
    const productId = this.$store.state.route.params.productId;
    this.product = (await getProductById(productId)).data;

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
    this.loading = false;
  },

  methods: {
    backPage() {
      this.$router.push({
        name: "ProductList",
      });
    },
    async saveItem() {
      this.$v.product.image.$touch();
      this.$v.product.title.$touch();
      this.$v.product.brand.$touch();
      this.$v.product.type.$touch();
      this.$v.product.size.$touch();
      this.$v.product.gender.$touch();
      this.$v.product.description.$touch();
      this.$v.product.stock.$touch();
      this.$v.product.price.$touch();

      if (this.product.discount !== null) {
        this.$v.product.discount_number.$touch();
        if (this.$v.product.discount_number.$anyError) {
          return;
        }
      }

      if (
        this.$v.product.image.$anyError ||
        this.$v.product.title.$anyError ||
        this.$v.product.brand.$anyError ||
        this.$v.product.type.$anyError ||
        this.$v.product.size.$anyError ||
        this.$v.product.gender.$anyError ||
        this.$v.product.description.$anyError ||
        this.$v.product.stock.$anyError ||
        this.$v.product.price.$anyError
      ) {
        return;
      }

      const productId = this.$store.state.route.params.productId;
      try {
        await putProductById(productId, this.product);
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
  height: 6rem;
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

.edit-product-page .loading-height {
  height: 70vh;
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

.select-fail {
  border: 1px solid #dc3545 !important;
  background: #fcedf2 url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px !important;
}

.select-fail:focus {
  border: 1px solid #b9b9b9 !important;
  background: #fff url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px !important;
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

.cover_loader {
  height: 75%;
}
</style>
