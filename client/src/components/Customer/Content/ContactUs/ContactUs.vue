<template>
  <div class="contact-us-page">
    <div class="container-lg">
      <div class="row padding-contact-us-page">
        <div class="col-6 px-5">
          <div class="d-flex align-items-center h-100">
            <div class="w-100">
              <div class="contact-info-title">Contact Info</div>
              <div class="row pb-2">
                <div class="col-1 text-center">
                  <div class="contact-icon-circle-envelope">
                    <font-awesome-icon
                      :icon="['far', 'envelope']"
                      class="contact-icon-envelope"
                    />
                  </div>
                </div>

                <div class="col-11 ps-4 contact-detail align-self-center">
                  info@sdperfumery.lk
                </div>
              </div>
              <div class="row">
                <div class="col-1 text-center">
                  <div class="contact-icon-circle-map">
                    <font-awesome-icon
                      icon="map-marker-alt"
                      class="contact-icon-map"
                    />
                  </div>
                </div>
                <div class="col-11 ps-4 contact-detail align-self-center">
                  Sri Lanka
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 px-5">
          <div class="contact-form-box">
            <div class="position-relative">
              <div class="contact-form-header">Contact Us</div>
              <div class="between_input">
                <input
                  type="text"
                  class="contact-form-small"
                  v-model.trim="$v.name.$model"
                  placeholder="Name"
                  :class="[
                    $v.name.$error ? 'border-fail' : null,
                    $v.name.required ? 'border-success' : null,
                  ]"
                />
              </div>
              <div class="between_input">
                <input
                  type="text"
                  class="contact-form-small"
                  v-model.trim="$v.email.$model"
                  placeholder="Email"
                  :class="[
                    $v.email.$error ? 'border-fail' : null,
                    $v.email.required && $v.email.email
                      ? 'border-success'
                      : null,
                  ]"
                />
              </div>
              <div class="between_input position-relative cover_big">
                <textarea
                  class="contact-form-big"
                  v-model.trim="$v.message.$model"
                  placeholder="Enter Your Message Here..."
                  :class="[
                    $v.message.$error ? 'border-fail' : null,
                    $v.message.required ? 'border-success' : null,
                  ]"
                />
              </div>
              <div class="position-relative text-white">
                <div v-if="$v.message.$dirty">
                  <div
                    class="error_2"
                    v-if="
                      !$v.message.required &&
                        $v.name.required &&
                        $v.email.required &&
                        $v.email.email
                    "
                  >
                    Please enter your message.
                  </div>
                </div>
                <div v-if="$v.email.$dirty">
                  <div
                    class="error_2"
                    v-if="!$v.email.required && $v.name.required"
                  >
                    Email is required.
                  </div>
                  <div
                    class="error_2"
                    v-if="
                      !$v.email.email && $v.name.required && $v.email.required
                    "
                  >
                    Invalid email format.
                  </div>
                </div>
                <div v-if="$v.name.$dirty">
                  <div class="error_2" v-if="!$v.name.required">
                    Please enter your name.
                  </div>
                </div>
              </div>

              <div class="position-relative">
                <div
                  class="sent_box position-absolute d-flex justify-content-center"
                  :class="success ? 'visible' : 'hidden'"
                >
                  <div>Your message has been sent.</div>
                </div>
                <div :class="send_loading ? 'no_click' : null"></div>
                <div class="send-message-button" @click="sendMessage">
                  <div v-if="!send_loading">SEND MESSAGE</div>
                  <BeatLoader
                    class="text-center "
                    :loading="send_loading"
                    color="#fff"
                    size="0.5rem"
                  ></BeatLoader>
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
  data() {
    return {
      name: "",
      email: "",
      message: "",
      send_loading: false,
      success: false,
    };
  },
  mixins: [validationMixin],
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

.contact-us-page .container-lg {
  position: relative;
}

.padding-contact-us-page {
  padding-top: 5rem;
  padding-bottom: 5rem;
}

.contact-us-page .contact-info-title {
  font-weight: 700;
  font-size: 1.6rem;
  padding-bottom: 1.2rem;
}

.contact-us-page .contact-detail {
  font-size: 1.4rem;
}

.contact-us-page .contact-icon-circle-envelope {
  width: 2.5rem;
  border-radius: 50%;
  font-size: 2.5rem;
  color: #384648;
}

.contact-us-page .contact-icon-circle-map {
  width: 2.5rem;
  height: 2.5rem;
  background-color: #384648;
  border-radius: 50%;
  font-size: 1.65rem;
  color: #fff;
  padding-top: 0.15rem;
}

.contact-form-box {
  background-color: #384648;
  border-radius: 0.5rem;
  padding: 3rem;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
}

.contact-form-header {
  color: #fff;
  font-size: 1.8rem;
  font-weight: 400;
  padding-bottom: 2rem;
  letter-spacing: 0.5px;
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

.cover_big {
  height: 10rem;
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
  transition: visibility 0s 1s, opacity 1s linear;
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
</style>
