<template>
  <div class="admin-login-bg d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column">
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
      <div class="login-button" @click="goToHome">
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

.admin-forgot-head {
  text-align: center;
  color: #384648;
  font-size: 4rem;
  padding-bottom: 3rem;
  font-weight: 700;
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

.unau_text {
  font-size: 1.5rem;
  font-weight: 300;
}

.thank_you_detail {
  width: 450px;
  padding-bottom: 3rem;
  text-align: justify;
}
</style>
