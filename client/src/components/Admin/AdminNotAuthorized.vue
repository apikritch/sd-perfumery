<template>
  <div class="admin-login-bg d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-center reset-logo">
        <font-awesome-icon icon="eye-slash" />
      </div>
      <div class="admin-forgot-head">
        <div>ERROR - 401 UNAUTHORIZED</div>
        <div class="unau_text">You are not authorized to access this page.</div>
      </div>

      <div class="login-button" @click="goToDashBoard">
        GO TO HOME PAGE
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminNotAuthorized",

  methods: {
    async goToDashBoard() {
      this.$router.push({
        name: "DashBoard",
      });
    },
  },
};
</script>

<style scoped>
.admin-login-bg {
  background-color: #7e989c;
  height: 100%;
  width: 100%;
}

.admin-forgot-head {
  text-align: center;
  color: #fff;
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

.reset-logo {
  font-size: 5rem;
  color: #fff;
  padding-bottom: 2rem;
}

.unau_text {
  font-size: 1rem;
  font-weight: 300;
}
</style>
