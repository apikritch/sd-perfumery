<template>
  <div class="admin-login-bg">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="d-flex flex-column notfound-width">
        <div class="d-flex justify-content-center reset-logo">
          <font-awesome-icon icon="question-circle" />
        </div>
        <div class="admin-forgot-head">
          <div>ERROR - 404 PAGE NOT FOUND</div>
          <div class="unau_text">
            The requested URL was not found on this server.
          </div>
        </div>

        <div
          class="login-button"
          @click="getBack">
          GO BACK
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "NotFound",
  data() {
    return {};
  },
  methods: {
    async getBack() {
      this.$router.go(-1);
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

.admin-login-bg .login-button {
  background-color: #985855;
  color: #fff;
  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  cursor: pointer;
  user-select: none;
  text-align: center;
  margin-top: 0.5rem;
}

.notfound-width {
  width: 16.25rem;
}

@media (min-width: 375px) {
  .notfound-width {
    width: auto;
  }
}

@media (min-width: 576px) {
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
