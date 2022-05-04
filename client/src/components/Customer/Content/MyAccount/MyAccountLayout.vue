<template>
  <div class="container-fluid remove-gap-container">
    <div class="row padding_hide" v-if="!$store.state.isCustomerLoggedIn">
      <RequireLogin :showSignIn="showSignIn"></RequireLogin>
    </div>
    <div class="row" v-if="$store.state.isCustomerLoggedIn">
      <router-view></router-view>
      <router-view name="my_account_content"></router-view>
    </div>
  </div>
</template>

<script>
import RequireLogin from "./../../RequireLogin.vue";
export default {
  name: "MyAccountLayout",
  props: ["showSignIn"],
  components: { RequireLogin },
};
</script>

<style scoped>
.padding_hide {
  padding-top: 20vh;
  padding-bottom: 20vh;
  bottom: 0px;
}
</style>
