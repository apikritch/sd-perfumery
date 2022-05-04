<template>
  <div class="h-100">
    <AdminNotAuthorized v-if="$store.state.user.user_type == 'General User'" />
    <div
      class="padding-under-pagination user-list-page h-100"
      v-if="$store.state.user.user_type !== 'General User'"
    >
      <div class="d-flex justify-content-between admin-product-padding">
        <div class="d-flex align-items-center admin-product-header">Users</div>
        <div class="d-flex align-items-end">
          <router-link class="admin-product-add" to="/admin/user/add">
            <font-awesome-icon icon="plus" class="me-1" /> Add User
          </router-link>
        </div>
      </div>

      <div
        v-if="loading || loading_2"
        class="d-flex align-items-center justify-content-center cover_loader"
      >
        <MoonLoader color="#985855" />
      </div>
      <div v-if="!loading && !loading_2">
        <!--Filter Row 1-->
        <div class="row pt-3">
          <div class="col-medium-select">
            <div>User Type:</div>
            <b-form-select
              v-model="user_type"
              :options="user_type_options"
              class="product-select-form"
            ></b-form-select>
          </div>
          <div class="col-medium-select">
            <div>User Status:</div>
            <b-form-select
              v-model="user_status"
              :options="user_status_options"
              class="product-select-form"
            ></b-form-select>
          </div>
        </div>
        <!--Filter Row 1-->
        <div class="row align-items-center product-padding-search-bar">
          <!--Search-->
          <div class="col-4">
            <input
              type="text"
              class="form-control admin-product-search-bar"
              placeholder="Search by keyword"
              v-model="search"
            />
          </div>
          <div class="col-4">{{ found_user }} USERS FOUND</div>
          <!--Search-->

          <!--Pagination-->
          <div class="col-4 ms-auto">
            <div class="row align-items-center">
              <div class="col-5 per-page">
                <div class="d-flex justify-content-between align-items-center">
                  <b-form-select
                    v-model="per_page"
                    :options="per_page_options"
                    class="product-select-form-per-page"
                  ></b-form-select>
                  per page
                </div>
              </div>
              <div class="col-7 page">
                <div class="d-flex justify-content-between align-items-center">
                  <div
                    class="page-button d-flex align-items-center justify-content-center"
                    @click="previousPage"
                  >
                    <font-awesome-icon icon="chevron-left" />
                  </div>
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <input
                      type="number"
                      class="product-page-input"
                      v-model="current_page"
                    />
                    <div>of {{ all_pages }}</div>
                  </div>
                  <div
                    class="page-button d-flex align-items-center justify-content-center next-page"
                    @click="nextPage"
                  >
                    <font-awesome-icon icon="chevron-right" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--Pagination-->
        </div>
        <div
          v-if="loading"
          class="d-flex justify-content-center align-items-center loading-height"
        ></div>

        <div v-if="!loading">
          <!--Label-->
          <div class="d-flex admin-product-label">
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table-label label-1 d-flex align-items-center justify-content-between px-2"
            >
              <div>ID</div>

              <div class="caret-cover" @click="sortId">
                <div
                  class="caret-up"
                  :class="
                    sortBy == 'id' && sortDirection == 'asc'
                      ? 'sort-white'
                      : null
                  "
                />

                <div
                  class="caret-down"
                  :class="
                    sortBy == 'id' && sortDirection == 'desc'
                      ? 'sort-white'
                      : null
                  "
                />
              </div>
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table-label label-2 d-flex align-items-center justify-content-between px-2"
            >
              <div>First Name</div>
              <div class="caret-cover" @click="sortFirstName">
                <div
                  class="caret-up"
                  :class="
                    sortBy == 'first_name' && sortDirection == 'asc'
                      ? 'sort-white'
                      : null
                  "
                />

                <div
                  class="caret-down"
                  :class="
                    sortBy == 'first_name' && sortDirection == 'desc'
                      ? 'sort-white'
                      : null
                  "
                />
              </div>
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table-label label-2 d-flex align-items-center justify-content-between px-2"
            >
              <div>Last Name</div>
              <div class="caret-cover" @click="sortLastName">
                <div
                  class="caret-up"
                  :class="
                    sortBy == 'last_name' && sortDirection == 'asc'
                      ? 'sort-white'
                      : null
                  "
                />

                <div
                  class="caret-down"
                  :class="
                    sortBy == 'last_name' && sortDirection == 'desc'
                      ? 'sort-white'
                      : null
                  "
                />
              </div>
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table-label label-3 d-flex align-items-center justify-content-between px-2"
            >
              <div>Email</div>
              <div class="caret-cover" @click="sortEmail">
                <div
                  class="caret-up"
                  :class="
                    sortBy == 'email' && sortDirection == 'asc'
                      ? 'sort-white'
                      : null
                  "
                />

                <div
                  class="caret-down"
                  :class="
                    sortBy == 'email' && sortDirection == 'desc'
                      ? 'sort-white'
                      : null
                  "
                />
              </div>
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table-label label-4 d-flex align-items-center justify-content-center"
            >
              Phone
            </div>
            <div
              :class="[
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null,
                $store.state.user.user_type == 'Owner'
                  ? 'border-right-product-table-label'
                  : null,
              ]"
              class="label-5 d-flex align-items-center justify-content-center"
            >
              User Type
            </div>
            <div
              class="border-right-product-table-label label-6 d-flex align-items-center justify-content-center"
              v-if="$store.state.user.user_type !== 'Admin'"
            >
              User Status
            </div>

            <div
              class="last-product-table-label label-7"
              v-if="$store.state.user.user_type !== 'Admin'"
            ></div>
          </div>
          <!--Label-->

          <!--Table-->
          <div
            class="d-flex admin-product-detail"
            v-for="(user, index) in pageAndFilter"
            :key="index"
          >
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table detail-1 d-flex align-items-center justify-content-center"
            >
              {{ user.id }}
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table detail-2 d-flex align-items-center"
            >
              {{ user.first_name }}
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table detail-2 d-flex align-items-center"
            >
              {{ user.last_name }}
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table detail-3 d-flex align-items-center"
            >
              {{ user.email }}
            </div>
            <div
              :class="
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null
              "
              class="border-right-product-table detail-4 d-flex align-items-center justify-content-center"
            >
              {{ user.phone }}
            </div>
            <div
              :class="[
                $store.state.user.user_type == 'Admin' ? 'hide_admin' : null,
                $store.state.user.user_type == 'Owner'
                  ? 'border-right-product-table'
                  : null,
              ]"
              class="detail-5 d-flex align-items-center justify-content-center"
            >
              {{ user.user_type }}
            </div>
            <div
              v-if="$store.state.user.user_type !== 'Admin'"
              class="border-right-product-table detail-6 d-flex align-items-center justify-content-center"
            >
              {{ user.user_status }}
            </div>

            <div
              class="detail-7 d-flex align-items-center justify-content-center"
              v-if="
                $store.state.user.user_type !== 'Admin' &&
                user.user_type !== 'Owner'
              "
            >
              <div class="w-100" @click="suspendAction(index, user.id)">
                <div class="d-flex justify-content-center align-items-center">
                  <div class="form-check form-switch">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="flexSwitchCheckChecked"
                      v-model="user.suspend_switch"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--Table-->

          <!--Pagination-->
          <div class="row align-items-center product-padding-search-bar">
            <div class="col-4 ms-auto">
              <div class="row align-items-center">
                <div class="col-5 per-page">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <b-form-select
                      v-model="per_page"
                      :options="per_page_options"
                      class="product-select-form-per-page"
                    ></b-form-select>
                    per page
                  </div>
                </div>
                <div class="col-7 page">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <div
                      class="page-button d-flex align-items-center justify-content-center"
                      @click="previousPage"
                    >
                      <font-awesome-icon icon="chevron-left" />
                    </div>
                    <div
                      class="d-flex justify-content-between align-items-center"
                    >
                      <input
                        type="number"
                        class="product-page-input"
                        v-model="current_page"
                      />
                      <div>of {{ all_pages }}</div>
                    </div>
                    <div
                      class="page-button d-flex align-items-center justify-content-center next-page"
                      @click="nextPage"
                    >
                      <font-awesome-icon icon="chevron-right" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Pagination-->
      </div>
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import { getUsers, putUserById } from "@/services/AdminUserService";
import {
  getPerPageOptions,
  getUserTypeOptions,
  getUserStatusOptions,
} from "@/services/AdminOptionService";
import AdminNotAuthorized from "./../../AdminNotAuthorized.vue";

export default {
  name: "UserList",
  components: { MoonLoader, AdminNotAuthorized },

  data() {
    return {
      user_type: null,
      user_type_options: [],
      user_status: null,
      user_status_options: [],
      users: [],
      page: 0,
      current_page: 1,
      all_pages: null,
      per_page: 10,
      per_page_options: [],
      loading: true,
      loading_2: true,

      found_user: "",
      search: "",
      sortBy: "id",
      sortDirection: "asc",
    };
  },
  computed: {
    pageAndFilter() {
      return this.pageUsers(
        this.sortUsers(this.filterUserType(this.filterUserStatus(this.users)))
      );
    },
  },
  watch: {
    current_page: function (val) {
      if (val < 1) {
        this.page = 0;
      } else {
        this.page = val - 1;
      }

      this.current_page =
        Math.abs(this.current_page) >= 1 &&
        Math.abs(this.current_page) <= this.all_pages
          ? Math.abs(this.current_page)
          : null;
    },
    per_page: function () {
      this.checkAll();
    },
    users: function () {
      this.checkAll();
    },
    search() {
      const route = {
        name: "UserList",
      };
      if (this.search !== "") {
        route.query = {
          search: this.search,
        };
      }
      this.$router.push(route);
    },
    "$route.query.search": {
      immediate: true,
      async handler(value) {
        this.users = (await getUsers(value)).data;
        for (let i = 0; i < this.users.length; i++) {
          if (this.users[i].user_status == "Active") {
            this.$set(this.users[i], "suspend_switch", true);
          } else {
            this.$set(this.users[i], "suspend_switch", false);
          }
        }
        this.checkAll();
        this.loading = false;
      },
    },
    user_type() {
      this.checkAll();
    },
    user_status() {
      this.checkAll();
    },
  },
  methods: {
    nextPage() {
      if (this.current_page >= this.all_pages) {
        this.current_page == this.all_pages;
      } else {
        this.current_page++;
      }
    },
    previousPage() {
      if (this.current_page <= 1) {
        this.current_page == 1;
      } else {
        this.current_page--;
      }
    },
    showAction(index) {
      if (this.pageAndFilter[index].display_action == 0) {
        this.pageAndFilter[index].display_action = 1;
      } else {
        this.pageAndFilter[index].display_action = 0;
      }
    },
    hideAction(index) {
      if (this.pageAndFilter[index].display_action == 1) {
        this.pageAndFilter[index].display_action = 0;
      } else {
        this.pageAndFilter[index].display_action = 1;
      }
    },
    async suspendAction(index, id) {
      if (this.pageAndFilter[index].user_status == "Active") {
        this.pageAndFilter[index].suspend_switch = false;
        this.pageAndFilter[index].user_status = "Suspended";

        await putUserById(id, this.pageAndFilter[index]);
      } else if (this.pageAndFilter[index].user_status == "Suspended") {
        this.pageAndFilter[index].suspend_switch = true;
        this.pageAndFilter[index].user_status = "Active";

        await putUserById(id, this.pageAndFilter[index]);
      }
    },
    pageUsers(users) {
      return users.slice(
        this.page * this.per_page,
        this.page * this.per_page + this.per_page
      );
    },
    filterUserType(users) {
      if (this.user_type == null) {
        return users;
      } else {
        return users.filter((user) => this.user_type.includes(user.user_type));
      }
    },
    filterUserStatus(users) {
      if (this.user_status == null) {
        return users;
      } else {
        return users.filter((user) =>
          this.user_status.includes(user.user_status)
        );
      }
    },
    sortId() {
      if (this.sortBy == "id" && this.sortDirection == "asc") {
        this.sortBy = "id";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "id";
        this.sortDirection = "asc";
      }
    },
    sortFirstName() {
      if (this.sortBy == "first_name" && this.sortDirection == "asc") {
        this.sortBy = "first_name";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "first_name";
        this.sortDirection = "asc";
      }
    },
    sortLastName() {
      if (this.sortBy == "last_name" && this.sortDirection == "asc") {
        this.sortBy = "last_name";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "last_name";
        this.sortDirection = "asc";
      }
    },
    sortEmail() {
      if (this.sortBy == "email" && this.sortDirection == "asc") {
        this.sortBy = "email";
        this.sortDirection = "desc";
      } else {
        this.sortBy = "email";
        this.sortDirection = "asc";
      }
    },
    sortUsers(users) {
      return [...users].sort((p1, p2) => {
        let modifier = 1;

        if (this.sortDirection === "desc") {
          modifier = -1;
        }

        if (p1[this.sortBy] < p2[this.sortBy]) {
          return -1 * modifier;
        }

        if (p1[this.sortBy] > p2[this.sortBy]) {
          return 1 * modifier;
        }

        return 0;
      });
    },
    checkAll() {
      const item_length = this.filterUserType(
        this.filterUserStatus(this.users)
      ).length;

      this.found_user = item_length;
      if (Math.ceil(item_length / this.per_page) < 1) {
        this.all_pages = 1;
      } else {
        this.all_pages = Math.ceil(item_length / this.per_page);
      }
      if (Math.ceil(item_length / this.per_page) < this.current_page) {
        this.current_page = this.all_pages;
      }
    },
  },
  async mounted() {
    this.per_page_options = await getPerPageOptions();
    this.user_type_options = await getUserTypeOptions();
    this.user_status_options = await getUserStatusOptions();
    this.loading_2 = false;
  },
};
</script>

<style scoped>
.admin-Order-head {
  height: 9rem;
  border-bottom: 1px solid #384648;
  font-size: 2.5rem;
  font-weight: 500;
}

.col-long-select {
  flex: 0 0 auto;
  width: 22.5%;
}

.col-medium-select {
  flex: 0 0 auto;
  width: 17.5%;
}

.col-small-select {
  flex: 0 0 auto;
  width: 25%;
}

.col-date-select {
  flex: 0 0 auto;
  width: 30%;
}

.product-select-form {
  width: 100%;
  padding: 0.5rem 0.5rem 0.4rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  background: #fff url("../../../../assets/caret-down-solid.svg") no-repeat
    right 0.5rem center/20px 20px;
  border: 1px solid #384648;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  margin-top: 0.25rem;
  cursor: pointer;
}

.product-select-form:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.product-small-input {
  width: 100%;
  padding: 0.5rem 0.5rem 0.4rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
}

.product-small-input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.product-label-small-row {
  margin-top: 0.25rem;
}

.product-padding-search-bar {
  margin-top: 2rem;
}

.admin-product-search-bar {
  border-radius: 1.5rem;
  border: 1px solid #384648;
  padding: 0.25rem 1rem 0.1rem 1rem;
  width: 100%;
  font-size: 0.9rem;
}

.user-list-page .per-page {
  font-size: 0.9rem;
  border-right: 1px solid #384648;
  font-weight: 500;
  width: 45%;
}

.user-list-page .page {
  font-size: 0.9rem;
  font-weight: 500;
  width: 55%;
}

.user-list-page .product-select-form-per-page {
  width: 50%;
  padding: 0.35rem 0.5rem 0.25rem 0.5rem;
  font-size: 0.85rem;
  color: #384648;
  background: #fff url("./../../../../assets/caret-down-solid.svg") no-repeat
    right 0.4rem center/20px 20px;
  border: 1px solid #384648;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  cursor: pointer;
}

.user-list-page .product-select-form-per-page:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.user-list-page .page-button {
  height: 2rem;
  min-width: 2rem;
  background-color: #eeeeee;
  color: #384648;
  font-size: 1.1rem;
  border: 1px solid #384648;
  cursor: pointer;
}

.user-list-page .product-page-input {
  text-align: center;
  width: 2rem;
  height: 2rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
  margin-right: 0.5rem;
}

.user-list-page .product-page-input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.admin-product-label {
  background-color: #985855;
  border-style: solid;
  border-color: #384648;
  border-width: 0 1px 1px 1px;
  color: #fff;
  font-weight: 400;
  font-size: 0.9rem;
  margin-top: 2rem;
}

.border-right-product-table-label {
  border-right: 1px solid #384648;
  height: 2.5rem;
}

.last-product-table-label {
  height: 2.5rem;
  padding-top: 0.65rem;
}

.label-1 {
  text-align: center;
  width: 7%;
}

.label-2 {
  text-align: center;
  width: 17%;
}

.label-3 {
  text-align: center;
  width: 19%;
}

.label-4 {
  text-align: center;
  width: 10%;
}

.label-5 {
  text-align: center;
  width: 10%;
}

.label-6 {
  text-align: center;
  width: 10%;
}

.label-7 {
  text-align: center;
  width: 10%;
}

.border-right-product-table {
  border-right: 1px solid #384648;
}

.admin-product-detail {
  border-style: solid;
  border-color: #384648;
  border-width: 0 1px 1px 1px;
  font-size: 0.8rem;
}

.detail-1 {
  width: 7%;
  height: 4.5rem;
}

.detail-2 {
  padding-left: 0.25rem;
  width: 17%;
  height: 4.5rem;
}

.detail-3 {
  padding-left: 0.25rem;
  width: 19%;
  height: 4.5rem;
  word-break: break-all;
}

.detail-4 {
  width: 10%;
  height: 4.5rem;
}

.detail-5 {
  padding-left: 0.25rem;
  width: 10%;
  height: 4.5rem;
}

.detail-6 {
  padding-left: 0.25rem;
  width: 10%;
  height: 4.5rem;
}

.detail-7 {
  width: 10%;
  height: 4.5rem;
}

.page input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.padding-under-pagination {
  padding-bottom: 2rem;
}

.admin-product-add {
  background-color: #985855;
  color: #fff;
  font-size: 1.05rem;
  padding: 0.6rem 1.25rem 0.45rem 1.25rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
  margin-bottom: 1rem;
}

.user-list-page .loading-height {
  height: 25vh;
}

.user-list-page .action {
  position: absolute;
  right: 3.75vw;
  z-index: 999;
}

.user-list-page .modal-overelay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  opacity: 1;
}

.user-list-page .modal-content {
  background: url(./../../../../assets/action_box_2.svg);
  position: relative;
  right: 0px;
  top: 40px;
  box-sizing: border-box;
  width: 125px;
  height: 70px;
  border: unset;
  overflow: hidden;
}

.user-list-page .action-dot {
  cursor: pointer;
}

.user-list-page .padding-right-text-action {
  padding-right: unset;
}

.user-list-page .padding-left-text-action {
  padding-left: unset;
  text-align: left;
}

.user-list-page .form-check {
  margin-bottom: unset;
}

.user-list-page .form-switch .form-check-input {
  width: 2rem;
  height: 1.1rem;
}

.user-list-page .form-check-input {
  background-color: #f44336;
  border: unset;
  background-image: url(./../../../../assets/switch.svg);
}

.user-list-page .form-check-input:checked {
  background-color: #639551;
  border: unset;
  background-image: url(./../../../../assets/switch.svg);
}

.user-list-page .form-check-input:focus {
  border: unset;
  outline: unset;
  box-shadow: unset;
  background-image: url(./../../../../assets/switch.svg);
}

.user-list-page .form-check-input:active {
  filter: unset;
}

.user-list-page .action-options {
  padding: 0.175rem 0rem;
}

.user-list-page .action-delete-options {
  padding: 0.31rem 0rem;
  background-color: unset;
  border: unset;
}

.caret-cover {
  cursor: pointer;
}

.caret-up {
  width: 0.5rem;
  height: 0.5rem;

  display: block;
  padding-bottom: 0.1rem;
  mask: url("./../../../../assets/caret-up-white.svg") no-repeat center;
  background-color: #b9b9b9;
}

.caret-down {
  width: 0.5rem;
  height: 0.5rem;
  display: block;
  padding-top: 0.1rem;
  mask: url("./../../../../assets/caret-down-white.svg") no-repeat center;
  background-color: #b9b9b9;
}

.sort-white {
  background-color: #fff !important;
}

.hide_admin.detail-1 {
  width: 10%;
  height: 4.5rem;
}

.hide_admin.detail-2 {
  padding-left: 0.25rem;
  width: 20%;
  height: 4.5rem;
}

.hide_admin.detail-3 {
  padding-left: 0.25rem;
  width: 20%;
  height: 4.5rem;
}

.hide_admin.detail-4 {
  width: 15%;
  height: 4.5rem;
}

.hide_admin.detail-5 {
  padding-left: 0.25rem;
  width: 15%;
  height: 4.5rem;
}

.hide_admin.label-1 {
  text-align: center;
  width: 10%;
}

.hide_admin.label-2 {
  text-align: center;
  width: 20%;
}

.hide_admin.label-3 {
  text-align: center;
  width: 20%;
}

.hide_admin.label-4 {
  text-align: center;
  width: 15%;
}

.hide_admin.label-5 {
  text-align: center;
  width: 15%;
}

.cover_loader {
  height: 75%;
}
</style>
