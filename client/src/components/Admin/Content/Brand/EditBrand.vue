<template>
  <div
    class="d-flex justify-content-center account-content edit-product-page h-100">
    <div class="account-width">
      <div class="account-header">Edit Brand</div>
      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader">
        <MoonLoader color="#985855" />
      </div>
      <div v-if="!loading">
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Brand:
            </div>
            <div class="col-9 information-input">
              <input
                v-model.trim="$v.brand.text.$model"
                type="text"
                :class="[
                  $v.brand.text.$error ? 'border-fail' : null,
                  $v.brand.text.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.brand.text.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.brand.text.required"
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
import { getBrandbyId, putBrandById } from "@/services/AdminOptionService";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "EditBrand",
  components: { MoonLoader },
  mixins: [validationMixin],
  data() {
    return {
      brand: {
        text: "",
        value: "",
      },
      loading: true,
    };
  },
  validations: {
    brand: { text: { required } },
  },
  watch: {
    "brand.text"() {
      this.$v.brand.text.$reset();
    },
  },
  async mounted() {
    const brandId = this.$store.state.route.params.brandId;
    this.brand = (await getBrandbyId(brandId)).data;
    this.loading = false;
  },
  methods: {
    backPage() {
      this.$router.push({
        name: "BrandList",
      });
    },
    async saveItem() {
      this.$v.brand.text.$touch();

      if (this.$v.brand.text.$anyError) {
        return;
      }

      const brandId = this.$store.state.route.params.brandId;
      this.brand.value = this.brand.text;
      try {
        await putBrandById(brandId, this.brand);
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

.border-fail {
  border: 1px solid #dc3545 !important;
  background-color: #fcedf2;
}

.border-fail:focus {
  border: 1px solid #b9b9b9 !important;
  background-color: #fff;
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

.button-cancel:hover {
  background-color: #fff9fb;
}

.button-save:hover {
  background-color: #814643;
}

.cover_loader {
  height: 75%;
}
</style>
