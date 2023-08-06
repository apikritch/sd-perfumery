<template>
  <div class="container-fluid remove-gap-container">
    <div
      v-if="!$store.state.isCustomerLoggedIn"
      class="row padding_hide">
      <RequireLogin :showSignIn="showSignIn"></RequireLogin>
    </div>
    <div
      v-if="$store.state.isCustomerLoggedIn"
      class="row">
      <router-view class="d-none d-lg-block"></router-view>
      <router-view name="my_account_content"></router-view>
    </div>
  </div>
</template>

<script>
import RequireLogin from "./../../RequireLogin.vue";
export default {
  name: "MyAccountLayout",
  components: { RequireLogin },
  props: ["showSignIn"],
};
</script>

<style scoped>
.padding_hide {
  padding-top: 20vh;
  padding-bottom: 20vh;
  bottom: 0px;
}
</style>
