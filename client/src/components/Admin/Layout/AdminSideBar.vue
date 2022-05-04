<template>
  <div>
    <div class="admin-side-bar-header">
      Menu
    </div>

    <router-link to="/admin">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="$route.path == '/admin' ? 'text-white' : null"
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="chart-bar" class="option-icon" />
        </div>
        <div class="col side-bar-text">Dashboard</div>
      </div>
    </router-link>
    <router-link to="/admin/product">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="
          $route.path == '/admin/product' ||
          $route.path == '/admin/product/add' ||
          $route.matched[1].path == '/admin/product/:productId/edit'
            ? 'text-white'
            : null
        "
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="box" class="option-icon" />
        </div>
        <div class="col side-bar-text">Products</div>
      </div>
    </router-link>
    <router-link to="/admin/brand">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="
          $route.path == '/admin/brand' ||
          $route.path == '/admin/brand/add' ||
          $route.matched[1].path == '/admin/brand/:brandId/edit'
            ? 'text-white'
            : null
        "
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="th" class="option-icon" />
        </div>
        <div class="col side-bar-text">Brands</div>
      </div>
    </router-link>
    <router-link to="/admin/order">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="$route.path == '/admin/order' ? 'text-white' : null"
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="store" class="option-icon" />
        </div>
        <div class="col side-bar-text">Orders</div>
      </div>
    </router-link>
    <router-link to="/admin/shipment">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="
          $route.path == '/admin/shipment' ||
          $route.path == '/admin/shipment/add' ||
          $route.matched[1].path == '/admin/shipment/:shipmentId/edit'
            ? 'text-white'
            : null
        "
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="truck" class="option-icon" />
        </div>
        <div class="col side-bar-text">Shipment</div>
      </div>
    </router-link>
    <router-link to="/admin/customer">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="$route.path == '/admin/customer' ? 'text-white' : null"
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="users" class="option-icon" />
        </div>
        <div class="col side-bar-text">Customers</div>
      </div>
    </router-link>
    <router-link to="/admin/uicomponent">
      <div
        class="row admin-side-bar-option align-items-center"
        :class="
          $route.path == '/admin/uicomponent' ||
          $route.path == '/admin/uicomponent/add' ||
          $route.matched[1].path == '/admin/uicomponent/:carouselId/edit'
            ? 'text-white'
            : null
        "
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="columns" class="option-icon" />
        </div>
        <div class="col side-bar-text">UI Component</div>
      </div>
    </router-link>
    <router-link
      to="/admin/user"
      v-if="$store.state.user.user_type !== 'General User'"
    >
      <div
        class="row admin-side-bar-option align-items-center"
        :class="
          $route.path == '/admin/user' || $route.path == '/admin/user/add'
            ? 'text-white'
            : null
        "
      >
        <div class="col-2 side-bar-icon text-center">
          <font-awesome-icon icon="user-circle" class="option-icon" />
        </div>
        <div class="col side-bar-text">Users</div>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "AdminSideBar",
};
</script>

<style scoped>
.admin-side-bar-header {
  padding: 2.5rem 2rem;
  font-weight: 500;
  letter-spacing: 0.25px;
  font-size: 1.25rem;
}

.admin-side-bar-option {
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  padding-left: 4rem;
  font-weight: 400;
  color: #85b7bf;
}

.option-icon {
  font-size: 1rem;
}

.side-bar-icon {
  padding-right: unset;
  text-align: right;
  padding-left: unset;
}

.side-bar-text {
  padding-right: unset;
  padding-left: unset;
}

.user-cog {
  font-size: 0.5rem;
}

.admin-side-bar-option:hover {
  color: #d8e5e7;
}
</style>
