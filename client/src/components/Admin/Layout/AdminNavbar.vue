<template>
  <div class="admin-navbar bg-admin-nav">
    <div class="container-lg h-100">
      <div class="d-flex justify-content-between align-items-center h-100">
        <router-link to="/admin">
          <div class="admin-logo">SD Perfumery</div>
        </router-link>

        <div class="d-flex justify-content-end align-items-center">
          <div class="admin-notification">
            <div
              class="d-flex justify-content-center align-items-center cursor_notification"
              :class="notification_display ? 'active_notification' : null"
              @click="showNotification">
              <div class="admin-bell"><font-awesome-icon icon="bell" /></div>
              <div class="admin-notification-number">
                {{ unReadOrder.length }}
              </div>
            </div>

            <!--Notification-->
            <div
              v-if="notification_display"
              class="notification_action">
              <div
                class="notification_overlay"
                @click="hideNotification"></div>
              <div class="notification_content">
                <div class="notification_header">Notifications</div>
                <div
                  v-if="unReadOrder.length == 0"
                  class="d-flex flex-column align-items-center justify-content-center border_empty_noti">
                  <font-awesome-icon
                    icon="envelope-open"
                    class="noti_empty_icon" />
                  <div class="noti_empty_text">No Current Notifications</div>
                </div>
                <div
                  v-for="(notification, index) in unReadOrder"
                  :key="index">
                  <div
                    class="d-flex align-items-center noti_order"
                    @click="goToDetail(notification.id)">
                    <div class="noti_right_pad">
                      <div class="notification_circle">
                        {{ notification.email.toUpperCase().charAt(0) }}
                      </div>
                    </div>
                    <div class="noti_left_pad">
                      <div class="noti_name d-inline">
                        {{ notification.first_name }}
                        {{ notification.last_name }}
                      </div>
                      <div class="noti_text d-inline">placed new order</div>
                      <div class="noti_date">
                        {{ notification.order_date }} |
                        {{ notification.order_time }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Notification-->
          </div>
          <div class="d-flex align-items-center">
            <router-link to="/admin/myaccount">
              <div
                class="d-flex align-items-center hover_email"
                :class="
                  $route.path == '/admin/myaccount' ? 'selected_email' : null
                ">
                <div class="admin-circle">
                  <div class="position_letter">
                    {{ $store.state.user.email.toUpperCase().charAt(0) }}
                  </div>
                </div>

                <div class="admin-nav-text">
                  {{ $store.state.user.email }}
                </div>
              </div>
            </router-link>

            <button
              class="ms-4 navbar-signout-button"
              @click="signOut">
              Log Out
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminNavbar",
  props: { unReadOrder: Array },
  data() {
    return {
      notification_display: false,
    };
  },
  methods: {
    async signOut() {
      this.$store.dispatch("setUser", null);
      this.$cookies.remove("EM");
      this.$router.push({
        name: "DashBoard",
      });
    },
    showNotification() {
      this.notification_display = true;
    },
    hideNotification() {
      this.notification_display = false;
    },
    goToDetail(id) {
      this.notification_display = false;
      this.$router.push({
        name: "AdminOrderDetails",
        params: { orderId: id },
      });
    },
  },
};
</script>

<style>
.bg-admin-nav {
  background-color: #fff;
}

.admin-navbar {
  height: 50px;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}

.admin-logo {
  font-weight: 500;
  font-size: 1.5rem;
  color: #384648;
}

.admin-notification {
  padding-right: 1.5rem;
  border-right: 2px solid#384648;
  margin-right: 1.5rem;
}

.admin-bell {
  font-size: 1.25rem;
  color: #7e989c;
  padding-right: 0.5rem;
}

.admin-notification-number {
  height: 1.3rem;
  min-width: 1.3rem;
  background-color: #f44336;
  color: #ffffff;
  font-size: 0.85rem;
  padding: 0.05rem 0.4rem 0 0.35rem;
  font-weight: 700;
  border-radius: 50rem;
  text-align: center;
}

.admin-circle {
  height: 2rem;
  min-width: 2rem;
  background-color: #779ecb;
  color: #ffffff;
  font-size: 1.5rem;
  border: 1px solid #384648;
  font-weight: 400;
  border-radius: 50%;
  text-align: center;
  margin-right: 0.5rem;
}

.admin-nav-text {
  font-weight: 500;
  color: #384648;
}

.navbar-signout-button {
  color: #ffffff;
  background-color: #6c757d;
  border-radius: 0.25rem;
  padding: 0.2rem 0.6rem 0.125rem 0.6rem;
  font-weight: 300;
  font-size: 0.9rem;
  border: unset;
}

.navbar-signout-button:hover {
  background-color: #5a6168;
}

.notification_action {
  position: absolute;

  z-index: 999;
}

.notification_overlay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  opacity: 1;
}

.notification_content {
  position: relative;
  box-sizing: border-box;
  top: 0.75rem;
  width: 22.5vw;
  max-height: 85vh;
  border-radius: 0.5rem;
  background-color: #fff;
  box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.25);
  padding: 0.75rem 1rem;
  overflow: auto;
}

.cursor_notification {
  cursor: pointer;
  padding: 0rem 0.5rem;
  border: 1px solid #fff;
}

.cursor_notification:hover {
  background-color: #f2f3f5;
  border-radius: 1rem;
  border: 1px solid #fff;
}

.active_notification {
  background-color: #ecf3ff;
  border: 1px solid #aac9ff;
  border-radius: 1rem;
}

.notification_header {
  font-size: 1.25rem;
  font-weight: 500;
  padding-bottom: 0.25rem;
  border-bottom: 1px solid #384648;
}

.notification_circle {
  height: 2.25rem;
  width: 2.25rem;
  background-color: #000;
  color: #ffffff;
  font-size: 1.5rem;
  border: 1px solid #384648;
  font-weight: 400;
  border-radius: 50%;
  text-align: center;
}

.noti_left_pad {
  padding-left: 1rem;
}

.noti_order {
  padding: 0.5rem 0.5rem;
  border-bottom: 1px solid #b9b9b9;
  cursor: pointer;
}

.noti_order:hover {
  background-color: rgba(0, 0, 0, 0.05);
}

.noti_name {
  font-size: 0.9rem;
  font-weight: 500;
  color: #384648;
}

.noti_text {
  font-size: 0.9rem;
  color: #384648;
}

.noti_date {
  font-size: 0.75rem;
  color: #3665f3;
  font-weight: 700;
}

.noti_empty_icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: #b9b9b9;
}

.noti_empty_text {
  font-weight: 500;
  color: #b9b9b9;
}

.border_empty_noti {
  border-bottom: 1px solid #b9b9b9;
  padding: 1rem 0rem 0.75rem 0rem;
}

.hover_email {
  border: 1px solid #fff;
  padding: 0.25rem;
}

.hover_email:hover {
  background-color: #f2f3f5;
  border-radius: 10rem;
}

.selected_email {
  background-color: #ecf3ff;
  border: 1px solid #aac9ff;
  border-radius: 10rem;
}

.position_letter {
  position: relative;
  top: -0.2rem;
}
</style>
