<template>
  <div class="admin-login-bg d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column thank_you_page">
      <div class="admin-forgot-head">
        <div>Thank You!</div>
        <div class="unau_text">Your order was completed successfully.</div>
      </div>
      <div class="thank_you_detail">
        <div>
          An email receipt including the details about your order has been sent
          to the email address provided. Please keep it for your records
        </div>
        <div class="mt-4">
          You can visit the My Account page any time to check the sttus of your
          order.
        </div>
      </div>
      <div
        class="login-button"
        @click="goToHome">
        GO TO HOME PAGE
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ThankYou",
  methods: {
    goToHome() {
      this.$router.push({
        name: "Home",
      });
    },
  },
  //created() {
  //  setTimeout(() => this.$router.push({ path: "/" }), 5000);
  //},
};
</script>

<style scoped>
.admin-login-bg {
  padding-top: 5rem;
  padding-bottom: 5rem;
  height: 100%;
  width: 100%;
}

.admin-login-bg input {
  border: 1px solid #384648;
  padding: 0.25rem 1rem;
  margin-bottom: 0.5rem;
  width: 400px;
}

.admin-login-bg input:focus-visible {
  border: 1px solid #384648;
  outline: inherit;
}

.admin-login-bg .login-button {
  background-color: #985855;
  color: #fff;
  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  cursor: pointer;
  user-select: none;
  text-align: center;
  margin-top: 0.5rem;
}

.forgot-admin {
  text-align: right;
  color: #fff;
  font-size: 0.9rem;
  margin-top: 1rem;
}

.thank_you_detail {
  padding-bottom: 3rem;
  text-align: justify;
}

.thank_you_page {
  width: 300px;
}

.admin-forgot-head {
  text-align: center;
  color: #384648;
  font-size: 3.7rem;
  padding-bottom: 3rem;
  font-weight: 700;
}

.unau_text {
  font-size: 1.3rem;
  font-weight: 300;
}

@media (min-width: 375px) {
  .thank_you_page {
    width: 335px;
  }

  .admin-forgot-head {
    font-size: 3.8rem;
  }
}

@media (min-width: 576px) {
  .thank_you_page {
    width: 450px;
  }

  .admin-forgot-head {
    font-size: 4rem;
  }
}

@media (min-width: 768px) {
}

@media (min-width: 992px) {
}

@media (min-width: 1200px) {
}

@media (min-width: 1400px) {
}
</style>
