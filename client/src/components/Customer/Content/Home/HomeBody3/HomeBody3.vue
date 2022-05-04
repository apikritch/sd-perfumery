<template>
  <div class="container-lg body-3-section">
    <div class="text-center">BEST SELLERS</div>
    <VueSlickCarousel v-bind="settings" v-if="sortProducts.length > 0">
      <div
        v-for="(product, index) in sortProducts"
        :key="index"
        class="d-flex justify-content-center"
      >
        <router-link :to="'/product/' + product.product.product_id">
          <img :src="product.product.image" class="img_home"
        /></router-link>
      </div>
    </VueSlickCarousel>
  </div>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import { getOrderedProducts } from "@/services/OrderedProductService";
export default {
  name: "HomeBody3",
  components: { VueSlickCarousel },
  data: function() {
    return {
      settings: {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 5,
        slidesToScroll: 1,
        centerPadding: "100px",
        focusOnSelect: true,
        autoplay: true,
      },
      products: [],
      sum_products: [],
    };
  },
  computed: {
    sortProducts() {
      return this.sliceProducts(this.sortProductsByQty(this.sum_products));
    },
  },
  methods: {
    sliceProducts(sum_products) {
      return sum_products.slice(0, 10);
    },
    sortProductsByQty(sum_products) {
      return [...sum_products].sort((p1, p2) => {
        if (p1["qty"] < p2["qty"]) {
          return 1;
        }

        if (p1["qty"] > p2["qty"]) {
          return -1;
        }

        return 0;
      });
    },
  },
  async mounted() {
    this.products = (await getOrderedProducts()).data;
    for (let i = 0; i < this.products.length; i++) {
      var whichProduct;
      var existing = this.sum_products.filter((item, index) => {
        if (item.product.product_id == Number(this.products[i].product_id)) {
          whichProduct = index;
          return true;
        } else {
          return false;
        }
      });

      if (existing.length) {
        this.sum_products[whichProduct].qty =
          this.sum_products[whichProduct].qty + this.products[i].quantity;
      } else {
        this.sum_products.push({
          product: this.products[i],
          qty: this.products[i].quantity,
        });
      }
    }
  },
};
</script>

<style>
.img_home:hover {
  opacity: 0.75;
}
.body-3-section .slick-prev:before {
  color: rgba(0, 0, 0, 0.75) !important;
  font-family: "Font Awesome 5 Free" !important;
  content: "\f053" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1.75rem !important;
}

.body-3-section .slick-next:before {
  color: rgba(0, 0, 0, 0.75) !important;

  font-family: "Font Awesome 5 Free" !important;
  content: "\f054" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1.75rem !important;
}

.body-3-section {
  padding-top: 4rem;
  padding-bottom: 4rem;
  padding-right: var(--bs-gutter-x, 2rem) !important;
  padding-left: var(--bs-gutter-x, 2rem) !important;
}

.body-3-section .text-center {
  font-size: 1.8rem;
  font-weight: 400;
  margin-bottom: 3rem;
}

.body-3-section .slick-dots li button:before {
  font-size: 0.7rem !important;
}

.body-3-section .slick-dots li {
  margin: 0.1rem !important;
}

.body-3-section .slick-dots {
  bottom: -40px !important;
}

.img_home {
  object-fit: cover;
  width: 100%;
  height: 15rem;
}
</style>
