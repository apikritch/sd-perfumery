<template
  ><div class="col-3 account-side-bar">
    <div class="side-bar-header">My Account</div>
    <router-link
      to="/myaccount"
      class="d-block side-bar-option"
      :class="$route.path == '/myaccount' ? 'active-menu' : null"
      >My Information</router-link
    >
    <router-link
      to="/myaccount/order"
      class="d-block side-bar-option"
      :class="
        $route.path == '/myaccount/order'
          ? 'active-menu'
          : null || $route.matched[2].path == '/myaccount/order/:orderId'
          ? 'active-menu'
          : null
      "
      >My Orders</router-link
    >
  </div>
</template>

<script>
export default {
  name: "SideBar",
};
</script>

<style scoped>
.account-side-bar {
  background-color: #384648;
  color: #fff;
  padding-right: unset;
  padding-left: unset;
  width: 20%;
  min-height: 55vh;
}

.account-side-bar a {
  color: #fff;
}

.account-side-bar .side-bar-header {
  padding: 2.5rem 2rem;
  font-weight: 500;
  letter-spacing: 0.25px;
}

.account-side-bar .side-bar-option {
  padding-left: 4rem;
  padding-top: 1rem;
  padding-bottom: 1rem;
  font-weight: 300;
}

.account-side-bar .side-bar-option:hover {
  background-color: #7e989c;
}

.active-menu {
  background-color: #515f61;
}
</style>
