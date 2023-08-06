<template>
  <div class="contact-us-page">
    <div class="container">
      <div class="row padding-contact-us-page">
        <div
          class="col-12 col-lg-6 padding-contact info-css order-1 order-lg-0">
          <div class="d-flex align-items-center h-100 justify-content-center">
            <div>
              <div class="contact-info-title">Contact Info</div>
              <div class="d-flex pb-0">
                <div class="contact-icon-circle-envelope">
                  <font-awesome-icon
                    :icon="['far', 'envelope']"
                    class="contact-icon-envelope" />
                </div>

                <div class="ps-3 contact-detail align-self-center">
                  info@sdperfumery.lk
                </div>
              </div>
              <div class="d-flex">
                <div
                  class="contact-icon-circle-map d-flex align-items-center justify-content-center">
                  <font-awesome-icon
                    icon="map-marker-alt"
                    class="contact-icon-map" />
                </div>
                <div class="ps-3 contact-detail align-self-center">
                  Sri Lanka
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 padding-contact order-0 order-lg-1">
          <div class="contact-form-box">
            <div class="position-relative">
              <div class="contact-form-header">Contact Us</div>
              <div class="between_input">
                <input
                  v-model.trim="$v.name.$model"
                  type="text"
                  class="contact-form-small"
                  placeholder="Name"
                  :class="[
                    $v.name.$error ? 'border-fail' : null,
                    $v.name.required ? 'border-success' : null,
                  ]" />
              </div>
              <div class="between_input">
                <input
                  v-model.trim="$v.email.$model"
                  type="text"
                  class="contact-form-small"
                  placeholder="Email"
                  :class="[
                    $v.email.$error ? 'border-fail' : null,
                    $v.email.required && $v.email.email
                      ? 'border-success'
                      : null,
                  ]" />
              </div>
              <div class="between_input position-relative cover_big">
                <textarea
                  v-model.trim="$v.message.$model"
                  class="contact-form-big"
                  placeholder="Enter Your Message Here..."
                  :class="[
                    $v.message.$error ? 'border-fail' : null,
                    $v.message.required ? 'border-success' : null,
                  ]" />
              </div>
              <div class="position-relative text-white">
                <div v-if="$v.message.$dirty">
                  <div
                    v-if="
                      !$v.message.required &&
                      $v.name.required &&
                      $v.email.required &&
                      $v.email.email
                    "
                    class="error_2">
                    Please enter your message.
                  </div>
                </div>
                <div v-if="$v.email.$dirty">
                  <div
                    v-if="!$v.email.required && $v.name.required"
                    class="error_2">
                    Email is required.
                  </div>
                  <div
                    v-if="
                      !$v.email.email && $v.name.required && $v.email.required
                    "
                    class="error_2">
                    Invalid email format.
                  </div>
                </div>
                <div v-if="$v.name.$dirty">
                  <div
                    v-if="!$v.name.required"
                    class="error_2">
                    Please enter your name.
                  </div>
                </div>
              </div>

              <div class="position-relative">
                <div
                  class="sent_box position-absolute d-flex justify-content-center"
                  :class="success ? 'visible' : 'hidden'">
                  <div>Your message has been sent.</div>
                </div>
                <div :class="send_loading ? 'no_click' : null"></div>
                <div
                  class="send-message-button"
                  @click="sendMessage">
                  <div v-if="!send_loading">SEND MESSAGE</div>
                  <BeatLoader
                    class="text-center"
                    :loading="send_loading"
                    color="#fff"
                    size="0.5rem"></BeatLoader>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { contactUs } from "@/services/CustomerService";
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
import BeatLoader from "vue-spinner/src/BeatLoader.vue";

export default {
  name: "ContactUs",
  components: { BeatLoader },
  mixins: [validationMixin],
  data() {
    return {
      name: "",
      email: "",
      message: "",
      send_loading: false,
      success: false,
    };
  },
  validations: {
    email: {
      required,
      email,
    },
    name: {
      required,
    },
    message: {
      required,
    },
  },
  watch: {
    email() {
      this.$v.email.$reset();
    },
    name() {
      this.$v.name.$reset();
    },
    message() {
      this.$v.message.$reset();
    },
  },
  methods: {
    async sendMessage() {
      this.send_loading = true;

      this.$v.email.$touch();
      this.$v.name.$touch();
      this.$v.message.$touch();

      if (
        this.$v.email.$anyError ||
        this.$v.name.$anyError ||
        this.$v.message.$anyError
      ) {
        this.send_loading = false;
        return;
      }

      const response = (
        await contactUs({
          email: this.email,
          name: this.name,
          message: this.message,
        })
      ).data;

      if (response.message == "Success") {
        this.send_loading = false;
        this.success = true;
        this.name = "";
        this.email = "";
        this.message = "";
        setTimeout(() => {
          this.success = false;
        }, 3000);
      } else {
        this.send_loading = false;
      }
    },
  },
};
</script>

<style scoped>
.contact-us-page {
  position: relative;
  color: #384648;
}

.contact-us-page:before {
  background-image: url("./../../../../assets/gplaypattern_@2X.png");
  background-size: 10rem;
  opacity: 0.5;
  content: "";
  display: block;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.contact-us-page .container {
  position: relative;
}

.contact-us-page .contact-detail {
  font-size: 1rem;
}

.contact-us-page .contact-icon-circle-envelope {
  font-size: 2rem;
  color: #384648;
  width: 2.5rem;
  text-align: center;
}

.contact-us-page .contact-icon-circle-map {
  width: 2.5rem;
  height: 2.5rem;
  background-color: #384648;
  border-radius: 50%;
  font-size: 1.5rem;
  color: #fff;
  padding-top: 0.15rem;
}

.contact-form-small {
  border-radius: 0.25rem;
  border: 0.5px solid #dee2e6;
  padding: 0.4rem 0.75rem;
  width: 100%;
  font-size: 1rem;
}

.contact-form-small:focus-visible,
.contact-form-big:focus-visible {
  border: 0.5px solid #dee2e6;
  outline: none;
}

.contact-form-small::placeholder,
.contact-form-big::placeholder {
  color: #384648;
  opacity: 0.75;
}

.contact-form-big {
  border-radius: 0.25rem;
  border: 0.5px solid #dee2e6;
  padding: 0.4rem 0.75rem;
  width: 100%;
  font-size: 1rem;
  height: 100%;
  overflow: auto;
  resize: none;
  position: relative;
}

.send-message-button {
  background-color: #985855;
  color: #fff;
  border-radius: 0.25rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  width: 100%;
  user-select: none;
  cursor: pointer;
  text-align: center;
  font-size: 1rem;
  letter-spacing: 0.25px;
  font-weight: 500;
}

.send-message-button:hover {
  background-color: #814643;
}

.no_click {
  background-color: #814643;
  border-radius: 0.25rem;
  user-select: none;
  cursor: pointer;
  position: absolute;
  height: 100%;
  width: 100%;
}

.sent_box {
  background-color: #e7f7e1;
  color: #639551;
  text-align: center;
  border: 2px solid #639551;
  border-radius: 0.25rem;
  position: absolute;
  width: 100%;
  padding-top: 0.45rem;
  padding-bottom: 0.45rem;
  user-select: none;
  cursor: pointer;
  font-size: 1rem;
  letter-spacing: 0.25px;
  font-weight: 500;
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
  border: 1px solid #dc3545 !important;
  border-radius: 0.25rem;
}

.border-success {
  border: 2px solid #198754 !important;
}

.error {
  position: absolute;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.8rem;
  border-radius: 0.25rem;
  width: 100%;
  text-align: center;
}

.between_input {
  margin-bottom: 0.75rem;
}

.error_2 {
  position: relative;
  color: #fff;
  background-color: #dc3545;
  font-size: 0.9rem;
  border-radius: 0.25rem;
  width: 100%;
  text-align: center;
  margin-bottom: 0.75rem;
}

.success {
  position: relative;
  color: #fff;
  background-color: #639551;
  font-size: 0.9rem;
  border-radius: 0.25rem;
  width: 100%;
  text-align: center;
  margin-bottom: 0.75rem;
}
.cover_big {
  height: 5rem;
}

.contact-form-box {
  background-color: #384648;
  border-radius: 0.5rem;
  padding: 1.75rem;
  padding-top: 1rem;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
}

.contact-form-header {
  color: #fff;
  font-size: 1.8rem;
  font-weight: 400;
  padding-bottom: 0.75rem;
  letter-spacing: 0.5px;
}

.padding-contact-us-page {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.info-css {
  margin-top: 3rem;
}

.contact-us-page .contact-info-title {
  font-weight: 700;
  font-size: 1.6rem;
  padding-bottom: 0.25rem;
}

.container {
  max-width: 320px;
}

@media (min-width: 375px) {
  .container {
    max-width: 350px;
  }
}

@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }

  .padding-contact {
    padding-left: 4.25rem;
    padding-right: 4.25rem;
  }
  .cover_big {
    height: 8rem;
  }
  .padding-contact-us-page {
    padding-top: 4rem;
    padding-bottom: 4rem;
  }

  .info-css {
    margin-top: 4rem;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 720px;
  }

  .cover_big {
    height: 10rem;
  }

  .padding-contact {
    padding-left: 8.5rem;
    padding-right: 8.5rem;
  }
}

@media (min-width: 992px) {
  .container {
    max-width: 960px;
  }

  .cover_big {
    height: 9rem;
  }

  .padding-contact {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }

  .info-css {
    margin-top: 0rem;
  }

  .padding-contact-us-page {
    padding-top: 5rem;
    padding-bottom: 5rem;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 1140px;
  }

  .cover_big {
    height: 10rem;
  }

  .padding-contact {
    padding-left: 4rem;
    padding-right: 4rem;
  }
}

@media (min-width: 1400px) {
  .container {
    max-width: 1320px;
  }
  .padding-contact {
    padding-left: 6.25rem;
    padding-right: 6.25rem;
  }
}
</style>
