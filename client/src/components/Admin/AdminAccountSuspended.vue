<template>
  <div class="admin-login-bg">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="d-flex flex-column">
        <div class="d-flex justify-content-center reset-logo">
          <font-awesome-icon icon="exclamation-triangle" />
        </div>
        <div class="admin-forgot-head">
          <div>Account Suspended</div>
        </div>

        <div
          class="login-button"
          @click="signOut">
          RETURN TO LOGIN
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminAccountSuspended",
  data() {
    return {};
  },
  methods: {
    async signOut() {
      this.$store.dispatch("setUser", null);
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
  height: 100vh;
  width: 100vw;
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
</style>
