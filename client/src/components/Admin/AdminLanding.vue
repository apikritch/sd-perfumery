<template>
  <div>
    <AdminLogin v-if="!$store.state.isUserLoggedIn && !haveCookies" />
    <AdminAccountSuspended
      v-if="
        $store.state.isUserLoggedIn &&
        $store.state.user.user_status == 'Suspended'
      " />
    <AdminNavbar
      v-if="
        $store.state.isUserLoggedIn && $store.state.user.user_status == 'Active'
      "
      :unReadOrder="unReadOrder"
      class="sticky-nav"></AdminNavbar>
    <div
      v-if="
        $store.state.isUserLoggedIn && $store.state.user.user_status == 'Active'
      "
      class="admin-side-and-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-3 admin-side-bar">
            <AdminSideBar></AdminSideBar>
          </div>
          <div
            class="col-9"
            :class="
              $route.name == 'UserList' &&
              $store.state.user.user_type == 'General User'
                ? 'gen_user_padding'
                : 'admin-content'
            ">
            <router-view :readOrder="readOrder" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AdminNavbar from "./Layout/AdminNavbar.vue";
import AdminSideBar from "./Layout/AdminSideBar.vue";
import AdminLogin from "./AdminLogin.vue";
import AdminAccountSuspended from "./AdminAccountSuspended.vue";

import { getOrder } from "@/services/OrderService";
import { updateOrderNotificationById } from "@/services/OrderService";
import { getUserByCookies } from "@/services/AdminUserService";
import CryptoJS from "crypto-js";
//import DeviceDetector from "device-detector-js";

export default {
  name: "AdminLanding",
  components: { AdminNavbar, AdminSideBar, AdminLogin, AdminAccountSuspended },
  data() {
    return {
      orders: [],
      user: {},
      haveCookies: false,
    };
  },
  computed: {
    unReadOrder() {
      let unread = [];
      for (let key in this.orders) {
        if (this.orders[key].notification == "Unread") {
          unread.push(this.orders[key]);
        }
      }
      return unread;
    },
  },
  async created() {
    if (this.$cookies.get("EM")) {
      this.haveCookies = true;

      const bytesEM = CryptoJS.AES.decrypt(
        this.$cookies.get("EM"),
        "secret_1234",
      );
      const dencryptedEM = bytesEM.toString(CryptoJS.enc.Utf8);
      const response = await getUserByCookies({
        email: dencryptedEM,
      });

      this.$store.dispatch("setUser", response.data);
      this.haveCookies = false;
    }
  },
  async mounted() {
    this.orders = (await getOrder()).data;

    //const deviceDetector = new DeviceDetector();

    //const device = deviceDetector.parse(navigator.userAgent);

    //console.log(device);

    //console.log(navigator.geolocation.getCurrentPosition);
  },
  methods: {
    async readOrder(orderId) {
      await updateOrderNotificationById(orderId, { notification: "Read" });
      this.orders = (await getOrder()).data;
    },
  },
};
</script>

<style scoped>
.admin-side-bar {
  background-color: #384648;
  color: #85b7bf;
  padding-right: unset;
  padding-left: unset;
  width: 20%;
  min-height: 93.75vh;
}

.admin-content {
  width: 80%;
  padding-right: calc(var(--bs-gutter-x) * 1);
  padding-left: calc(var(--bs-gutter-x) * 1);
}

.gen_user_padding {
  width: 80%;
  padding-right: unset;
  padding-left: unset;
  position: relative;
  bottom: 0;
}

.sticky-nav {
  position: -webkit-sticky;
  position: sticky;
  top: 0px;
  z-index: 10000;
}
</style>
