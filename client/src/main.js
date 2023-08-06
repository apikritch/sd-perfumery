import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "@/store/store";
import { sync } from "vuex-router-sync";
import { BootstrapVue } from "bootstrap-vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.js";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";
import VueSlider from "vue-slider-component";
import Vuelidate from "vuelidate";
import "vue-slider-component/theme/default.css";
import VueCookies from "vue-cookies";
import "@fortawesome/fontawesome-free/css/all.css";

import {
  faShoppingCart,
  faChevronDown,
  faMinus,
  faPlus,
  faMapMarkerAlt,
  faTimes,
  faPen,
  faBell,
  faChartBar,
  faBox,
  faStore,
  faUsers,
  faColumns,
  faUserCircle,
  faUserCog,
  faChevronRight,
  faChevronLeft,
  faEllipsisH,
  faSave,
  faPencilAlt,
  faEdit,
  faLock,
  faUserLock,
  faTh,
  faTruck,
  faEnvelopeOpen,
  faExclamationTriangle,
  faQuestionCircle,
  faEyeSlash,
  faCoins,
  faFire,
  faCheckCircle,
  faFingerprint,
  faCheck,
  faSearch,
} from "@fortawesome/free-solid-svg-icons";
import {
  faEnvelope,
  faEye,
  faTrashAlt,
  faTimesCircle,
} from "@fortawesome/free-regular-svg-icons";

library.add(
  faShoppingCart,
  faChevronDown,
  faMinus,
  faPlus,
  faEnvelope,
  faMapMarkerAlt,
  faTimes,
  faPen,
  faBell,
  faChartBar,
  faBox,
  faStore,
  faUsers,
  faColumns,
  faUserCircle,
  faUserCog,
  faChevronRight,
  faChevronLeft,
  faEllipsisH,
  faSave,
  faTimesCircle,
  faEye,
  faPencilAlt,
  faTrashAlt,
  faEdit,
  faLock,
  faUserLock,
  faTh,
  faTruck,
  faEnvelopeOpen,
  faExclamationTriangle,
  faQuestionCircle,
  faEyeSlash,
  faCoins,
  faFire,
  faCheckCircle,
  faFingerprint,
  faCheck,
  faSearch,
);

sync(store, router);

Vue.use(VueCookies);
Vue.use(BootstrapVue);
Vue.use(Vuelidate);
Vue.component("VueSlider", VueSlider);
Vue.component("FontAwesomeIcon", FontAwesomeIcon);
Vue.config.productionTip = false;

new Vue({
  render: (h) => h(App),
  router,
  store,
}).$mount("#app");
