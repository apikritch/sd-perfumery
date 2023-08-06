<template>
  <div class="d-flex justify-content-center account-content">
    <div class="account-width">
      <form @submit.prevent="addItem">
        <div class="account-header">Add Carousel Image</div>
        <div class="padding-account-section">
          <div class="row align-items-center justify-content-end account-row">
            <div class="col-3 information-head text-end">
              <div class="text-danger d-inline">*</div>
              Image Link:
            </div>
            <div class="col-9 information-input textarea-height">
              <textarea
                v-model.trim="$v.link_address.$model"
                type="text"
                class="carousel-input"
                :class="[
                  $v.link_address.$error ? 'border-fail' : 'input_border',
                  $v.link_address.required ? 'border-success' : null,
                ]" />
            </div>
            <div class="col-9 offset-3">
              <div
                v-if="$v.link_address.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.link_address.required"
                  class="error">
                  Required
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex flex-column justify-content-center">
            <div class="text-center preview">Preview</div>
            <img
              :src="link_address"
              width="100%"
              class="preview-img"
              :class="link_address !== '' ? 'preview-frame' : null" />
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
        class="me-2" />Carousel successfully added!
    </div>
  </div>
</template>

<script>
import { getCarousels, postCarousel } from "@/services/AdminUIComponentService";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "AddUIComponent",
  mixins: [validationMixin],
  data() {
    return {
      carousels: [],
      link_address: "",
      sequence: "",
      success: false,
    };
  },
  validations: {
    link_address: { required },
  },
  watch: {
    link_address() {
      this.$v.link_address.$reset();
    },
  },
  async mounted() {
    try {
      this.carousels = (await getCarousels()).data;
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    async addItem() {
      this.$v.link_address.$touch();
      if (this.$v.link_address.$anyError) {
        return;
      }

      this.sequence = this.carousels.length + 1;
      let ui_component = {
        link_address: this.link_address,
        sequence: this.sequence,
      };
      try {
        const response = (await postCarousel(ui_component)).data;
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
      //this.carousels = (await getCarousels()).data;
    },
    clearForm() {
      this.link_address = "";
      this.sequence = "";
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
  padding-bottom: 1.25rem;
  border-bottom: 1px solid #b9b9b9;
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

.border-fail:focus {
  border-color: #b9b9b9;
  background-color: unset;
}

.textarea-height {
  height: 5rem;
}
</style>
