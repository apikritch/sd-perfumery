<template>
  <div
    class="d-flex justify-content-center account-content edit-component-page h-100">
    <div class="account-width">
      <div class="account-header">Edit Carousel Image</div>
      <div
        v-if="loading"
        class="d-flex align-items-center justify-content-center cover_loader">
        <MoonLoader color="#985855" />
      </div>
      <div v-if="!loading">
        <div class="padding-account-section">
          <div
            class="row align-items-center justify-content-start sequence-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Sequence:
            </div>

            <div class="col-9 information-input">
              <input
                v-model.trim="$v.carousel.sequence.$model"
                type="text"
                class="text-center w-25"
                :class="[
                  $v.carousel.sequence.$error ? 'border-fail' : null,
                  $v.carousel.sequence.required && $v.carousel.sequence.numeric
                    ? 'border-success'
                    : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.carousel.sequence.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.carousel.sequence.required"
                  class="error">
                  Required
                </div>
                <div
                  v-if="!$v.carousel.sequence.numeric"
                  class="error">
                  Invalid value
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Image Link:
            </div>

            <div class="col-9 information-input textarea-height">
              <textarea
                v-model.trim="$v.carousel.link_address.$model"
                type="text"
                class="carousel-input"
                :class="[
                  $v.carousel.link_address.$error ? 'border-fail' : null,
                  $v.carousel.link_address.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.carousel.link_address.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.carousel.link_address.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex flex-column justify-content-center">
            <div class="text-center preview">Preview</div>
            <img
              :src="carousel.link_address"
              width="100%"
              class="preview-img"
              :class="carousel.link_address !== '' ? 'preview-frame' : null" />
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

<script scoped>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { validationMixin } from "vuelidate";
import { required, numeric } from "vuelidate/lib/validators";

import {
  getCarouselById,
  putCarouselById,
} from "@/services/AdminUIComponentService";

export default {
  name: "EditUIComponent",
  components: { MoonLoader },
  mixins: [validationMixin],
  data() {
    return {
      carousel: {
        sequence: "",
        link_address: "",
      },
      loading: true,
    };
  },
  validations: {
    carousel: { sequence: { required, numeric }, link_address: { required } },
  },
  watch: {
    "carousel.sequence"() {
      this.$v.carousel.sequence.$reset();
    },
    "carousel.link_address"() {
      this.$v.carousel.link_address.$reset();
    },
  },
  async mounted() {
    try {
      const carouselId = this.$store.state.route.params.carouselId;
      this.carousel = (await getCarouselById(carouselId)).data;
      this.loading = false;
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    backPage() {
      this.$router.push({
        name: "UIComponent",
      });
    },
    async saveItem() {
      this.$v.carousel.sequence.$touch();
      this.$v.carousel.link_address.$touch();

      if (
        this.$v.carousel.sequence.$anyError ||
        this.$v.carousel.link_address.$anyError
      ) {
        return;
      }

      const carouselId = this.$store.state.route.params.carouselId;
      try {
        await putCarouselById(carouselId, this.carousel);
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
  padding-bottom: 1.25rem;
  border-bottom: 1px solid #b9b9b9;
  margin-right: unset;
  margin-left: unset;
}

.sequence-row {
  padding-top: 0.75rem;
  margin-right: unset;
  margin-left: unset;
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

.preview {
  padding-top: 0.75rem;
  padding-bottom: 0.5rem;
  font-size: 1.5rem;
  font-weight: 500;
}

.carousel-input:focus-visible {
  border: 1px solid #b9b9b9 !important;
  outline: none !important;
}

.carousel-input {
  border: 1px solid #b9b9b9;
  height: 100%;
  width: 100%;
  resize: none;
  word-break: break-all;
}

.preview-img {
  object-fit: cover;
  height: 9.6rem;
}

.preview-frame {
  border: 1px solid #b9b9b9;
}

.edit-component-page .loading-height {
  height: 70vh;
}

.textarea-height {
  height: 5rem;
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
