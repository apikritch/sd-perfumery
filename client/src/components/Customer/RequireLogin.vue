<template>
  <div class="admin-login-bg d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-center reset-logo">
        <font-awesome-icon icon="fingerprint" />
      </div>
      <div class="admin-forgot-head">
        <div>Authentication Required</div>
        <div class="unau_text">Please sign in to access this page.</div>
      </div>

      <div
        class="login-button_2"
        @click="showSignIn">
        SIGN IN
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
  name: "RequireLogin",
  props: {
    showSignIn: Function,
  },
  methods: {
    async goToHome() {
      this.$router.push({
        name: "Home",
      });
    },
  },
};
</script>

<style scoped>
.admin-login-bg {
  height: 100%;
  width: 100%;
}

.admin-forgot-head {
  text-align: center;
  color: #384648;
  font-size: 1.5rem;
  padding-bottom: 1.25rem;
  margin-bottom: 1.5rem;
  font-weight: 500;
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
  padding: 0.5rem 1.25rem 0.35rem 1.25rem;
  cursor: pointer;
  user-select: none;
  text-align: center;
  margin-top: 0.5rem;
}

.admin-login-bg .login-button_2 {
  border: 1px solid #985855;
  background-color: #fff;
  color: #985855;
  padding: 0.5rem 1.25rem 0.35rem 1.25rem;
  cursor: pointer;
  user-select: none;
  text-align: center;
  margin-top: 0.5rem;
}

.reset-logo {
  font-size: 5rem;
  color: #384648;
  padding-bottom: 2rem;
}

.unau_text {
  font-size: 1rem;
  font-weight: 300;
}
</style>
