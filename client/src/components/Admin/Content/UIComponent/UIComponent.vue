<template>
  <div class="padding-under-pagination h-100">
    <div class="d-flex justify-content-between admin-product-padding">
      <div class="d-flex align-items-center admin-product-header">
        UI Component
      </div>
      <div class="d-flex align-items-end">
        <router-link class="admin-product-add" to="/admin/uicomponent/add">
          <font-awesome-icon icon="plus" class="me-1" /> Add File
        </router-link>
      </div>
    </div>

    <div
      v-if="loading"
      class="d-flex align-items-center justify-content-center cover_loader"
    >
      <MoonLoader color="#985855" />
    </div>

    <div v-if="!loading">
      <div class="carousel-sample">Carousel Section</div>
      <div
        v-if="loading"
        class="d-flex justify-content-center align-items-center loading-height"
      ></div>
      <div v-if="!loading">
        <!--Sample Carousel-->
        <div class="d-flex justify-content-center">
          <div class="carousel-sample-width">
            <VueSlickCarousel v-bind="settings" v-if="carousels.length > 0"
              ><div v-for="(carousel, index) in sort" :key="index">
                <img :src="carousel.link_address" width="100%" /></div
            ></VueSlickCarousel>
          </div>
        </div>
        <!--Sample Carousel-->

        <!--Label-->
        <div class="d-flex ui-product-label">
          <div class="border-right-product-table-label label-1">Sequence</div>
          <div class="border-right-product-table-label label-2">Thumbnail</div>
          <div class="border-right-product-table-label label-3">
            Link Address
          </div>
          <div class="label-4"></div>
        </div>
        <!--Label-->

        <!--Table-->
        <div
          class="d-flex admin-product-detail component-mini-action"
          v-for="(carousel, index) in sort"
          :key="index"
        >
          <div
            class="border-right-product-table detail-1 d-flex align-items-center justify-content-center"
          >
            {{ carousel.sequence }}
          </div>
          <div
            class="border-right-product-table detail-2 d-flex align-items-center justify-content-center"
          >
            <img :src="carousel.link_address" width="100%" />
          </div>
          <div
            class="border-right-product-table detail-3 d-flex align-items-center"
          >
            {{ carousel.link_address }}
          </div>
          <div
            class="detail-4 d-flex align-items-center justify-content-center"
          >
            <div
              class="after_action d-flex align-items-center justify-content-center"
              @click="showAction(index)"
              :class="
                carousel.display_action == 1 ? 'after_action_click' : null
              "
            >
              <font-awesome-icon icon="ellipsis-h" />
            </div>
            <!--Mini Menu-->
            <div class="action" v-if="carousel.display_action == 1">
              <div class="modal-overelay" @click="hideAction(index)"></div>
              <div class="modal-content">
                <div
                  class="d-flex flex-column justify-content-end align-items-center h-100 text-start"
                >
                  <router-link
                    class="w-100 action-options border-action ps-2"
                    :to="'/admin/uicomponent/' + carousel.id + '/edit'"
                  >
                    <div class="row align-items-center">
                      <div class="col-4 padding-right-text-action">
                        <div class="d-flex justify-content-center">
                          <font-awesome-icon icon="pencil-alt" />
                        </div>
                      </div>
                      <div class="col-8 padding-left-text-action">Edit</div>
                    </div>
                  </router-link>
                  <button
                    class="w-100 action-delete-options border-action ps-2"
                    @click="deleteItem(index, carousel.id)"
                  >
                    <div class="row align-items-center">
                      <div class="col-4 padding-right-text-action">
                        <div class="d-flex justify-content-center">
                          <font-awesome-icon :icon="['far', 'trash-alt']" />
                        </div>
                      </div>
                      <div class="col-8 padding-left-text-action">Delete</div>
                    </div>
                  </button>
                </div>
              </div>
            </div>
            <!--Mini Menu-->
          </div>
        </div>
      </div>
      <!--Table-->
    </div>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import {
  getCarousels,
  deleteCarouselById,
} from "@/services/AdminUIComponentService";
import { getPerPageOptions } from "@/services/AdminOptionService";
import VueSlickCarousel from "vue-slick-carousel";

export default {
  name: "UIComponent",
  components: { VueSlickCarousel, MoonLoader },

  data() {
    return {
      city: null,
      city_options: [],
      state: null,
      state_options: [],
      carousels: [],
      page: 0,
      current_page: 1,
      all_pages: null,
      per_page: 10,
      per_page_options: [],
      settings: {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: true,
      },
      loading: true,
    };
  },
  computed: {
    sort() {
      return this.sortCarousel(this.carousels);
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
    per_page: function (val) {
      this.all_pages = Math.ceil(this.carousels.length / val);

      if (Math.ceil(this.carousels.length / val) < this.current_page) {
        this.current_page = this.all_pages;
      }
    },
    carousels: function (val) {
      this.all_pages = Math.ceil(val.length / this.per_page);
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
      if (this.sort[index].display_action == 0) {
        this.sort[index].display_action = 1;
      } else {
        this.sort[index].display_action = 0;
      }
    },
    hideAction(index) {
      if (this.sort[index].display_action == 1) {
        this.sort[index].display_action = 0;
      } else {
        this.sort[index].display_action = 1;
      }
    },
    async deleteItem(index, id) {
      try {
        this.carousels.splice(index, 1);
        await deleteCarouselById(id);
      } catch (error) {
        console.log(error);
      }
    },
    sortCarousel(carousels) {
      return [...carousels].sort((p1, p2) => {
        if (p1["sequence"] < p2["sequence"]) {
          return -1;
        }

        if (p1["sequence"] > p2["sequence"]) {
          return 1;
        }

        return 0;
      });
    },
  },
  async mounted() {
    this.carousels = (await getCarousels()).data;
    this.per_page_options = await getPerPageOptions();
    for (let i = 0; i < this.carousels.length; i++) {
      this.$set(this.carousels[i], "display_action", 0);
    }
    this.loading = false;
  },
};
</script>

<style>
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

.carousel-select-form {
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

.per-page {
  font-size: 0.9rem;
  border-right: 1px solid #384648;
  font-weight: 500;
  width: 45%;
}

.page {
  font-size: 0.9rem;
  font-weight: 500;
  width: 55%;
}

.product-select-form-per-page {
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

.product-select-form-per-page:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.page-button {
  height: 2rem;
  min-width: 2rem;
  background-color: #eeeeee;
  color: #384648;
  font-size: 1.1rem;
  border: 1px solid #384648;
  cursor: pointer;
}

.product-page-input {
  text-align: center;
  width: 2rem;
  height: 2rem;
  font-size: 0.85rem;
  color: #384648;
  border: 1px solid #384648;
  margin-right: 0.5rem;
}

.product-page-input:focus-visible {
  outline: inherit;
  border-color: inherit;
}

.ui-product-label {
  background-color: #985855;
  border-style: solid;
  border-color: #384648;
  border-width: 0 1px 1px 1px;
  color: #fff;
  font-weight: 400;
  font-size: 0.9rem;
  margin-top: 1rem;
}

.ui-product-label .border-right-product-table-label {
  border-right: 1px solid #384648;
  height: 2.5rem;
  padding-top: 0.65rem;
}

.last-product-table-label {
  height: 2.5rem;
  padding-top: 0.65rem;
}

.label-1 {
  text-align: center;
  width: 10%;
}

.label-2 {
  text-align: center;
  width: 20%;
}

.label-3 {
  text-align: center;
  width: 60%;
}

.label-4 {
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
  width: 10%;
  height: 4.5rem;
}

.detail-2 {
  padding: 0.25rem;
  width: 20%;
  height: 4.5rem;
  overflow: hidden;
}

.detail-3 {
  padding-left: 0.25rem;
  width: 60%;
  height: 4.5rem;
  word-break: break-all;
}

.detail-4 {
  width: 10%;
  height: 4.5rem;
  position: relative;
}

.page input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.admin-product-padding {
  height: 9rem;
  border-bottom: 1px solid #384648;
}

.admin-product-header {
  font-size: 2.5rem;
  font-weight: 500;
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

.admin-product-add:hover {
  color: #fff;
}

.carousel-sample-width {
  width: 50%;
}

.carousel-sample-width img {
  height: 10rem;
  object-fit: cover;
}

.carousel-sample-width .slick-prev:before {
  color: rgba(255, 255, 255, 1) !important;
  font-family: "Font Awesome 5 Free" !important;
  content: "\f053" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1rem !important;
  margin-left: -2px !important;
}

.carousel-sample-width .slick-next:before {
  color: rgba(255, 255, 255, 1) !important;
  font-family: "Font Awesome 5 Free" !important;
  content: "\f054" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1rem !important;
  margin-right: -2px !important;
}

.carousel-sample-width .slick-dots li button:before {
  font-size: 0.25rem !important;
}

.carousel-sample-width .slick-dots li {
  margin: 0.25rem !important;
}

.carousel-sample-width .slick-dots li.slick-active button:before {
  opacity: 1;
  color: white !important;
  width: 50px !important;
  background-color: white !important;
}

.carousel-sample-width .slick-dots li button:before {
  opacity: 0.55;
  color: black !important;
  width: 50px !important;
  background-color: black !important;
  position: unset !important;
  padding-left: 10px;
  padding-right: 10px;
  font-size: 0.2rem !important;
}

.slick-dots li button {
  height: 1px !important;
}

.carousel-sample-width .slick-dots {
  bottom: 5px !important;
  display: flex !important;
  justify-content: center !important;
  left: -7.25px !important;
}

.carousel-sample-width .slick-prev {
  left: 17.5px !important;
  z-index: 100 !important;
  background-color: rgba(0, 0, 0, 0.5) !important;
  width: 1.25rem;
  height: 1.25rem;
  border-radius: 100%;
}
.carousel-sample-width .slick-next {
  right: 17.5px !important;
  z-index: 100 !important;
  background-color: rgba(0, 0, 0, 0.5) !important;
  width: 1.25rem;
  height: 1.25rem;
  border-radius: 100%;
}

.carousel-sample {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
  font-size: 1.6rem;
  font-weight: 500;
}

.padding-under-pagination {
  padding-bottom: 2rem;
}

.component-mini-action .action {
  position: absolute;
  right: -8.5px;
  z-index: 999;
}

.component-mini-action .modal-overelay {
  position: fixed;
  box-sizing: border-box;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  opacity: 1;
}

.component-mini-action .modal-content {
  border: 1px solid #7e989c;
  background-color: #fbfbfb;
  right: 0px;
  top: 42.5px;
  box-sizing: border-box;
  width: 125px;
  height: 60px;
  overflow: hidden;
}

.component-mini-action .action-options {
  padding: 0.31rem 0rem;
  color: #384648;
}

.component-mini-action .border-action {
  border-bottom: 1px solid #7e989c;
}

.component-mini-action .padding-left-text-action {
  padding-left: unset;
  text-align: left;
}

.component-mini-action .padding-right-text-action {
  padding-right: unset;
}

.action-delete-options {
  padding: 0.31rem 0rem;
  color: #384648;
  background-color: unset;
  border: unset;
}

.loading-height {
  height: 50vh;
}

.after_action {
  cursor: pointer;
  border: 1px solid #fff;
  border-radius: 1rem;
  width: 1.25rem;
  height: 1.25rem;
}

.after_action:hover {
  background-color: #e9e9e9;
  border-radius: 1rem;
  border: 1px solid #fff;
}

.after_action_click {
  background-color: #e9e9e9;
  border-radius: 1rem;
  border: 1px solid #d1d1d1;
}

.border-action:hover {
  background-color: #ececec;
}

.cover_loader {
  height: 75%;
}
</style>
