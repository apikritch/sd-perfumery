<template>
  <div class="container-lg body-5-section">
    <div class="text-center">RECOMMENDED FRAGRANCES</div>
    <VueSlickCarousel
      v-if="sortProducts.length > 0"
      v-bind="settings">
      <div
        v-for="(product, index) in sortProducts"
        :key="index"
        class="d-flex justify-content-center">
        <router-link :to="'/product/' + product.id">
          <img
            :src="product.image"
            width="100%"
            class="img_home"
        /></router-link>
      </div>
    </VueSlickCarousel>
  </div>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import { getProducts } from "@/services/ProductService";
export default {
  name: "HomeBody5",
  components: { VueSlickCarousel },
  data: function () {
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
        arrows: true,
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 4,
            },
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
            },
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 3,
              arrows: false,
            },
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 2,
              dots: false,
              arrows: false,
            },
          },
        ],
      },
      products: [],
    };
  },
  computed: {
    sortProducts() {
      return this.sliceProducts(this.sortProductsByPrice(this.products));
    },
  },
  async mounted() {
    this.products = (await getProducts()).data;
  },
  methods: {
    sliceProducts(products) {
      return products.slice(0, 10);
    },
    sortProductsByPrice(products) {
      return [...products].sort((p1, p2) => {
        if (p1["price"] - p1["final_price"] < p2["price"] - p2["final_price"]) {
          return 1;
        }

        if (p1["price"] - p1["final_price"] > p2["price"] - p2["final_price"]) {
          return -1;
        }

        return 0;
      });
    },
  },
};
</script>

<style>
.img_home:hover {
  opacity: 0.75;
}
.body-5-section .slick-prev:before {
  color: rgba(0, 0, 0, 0.75) !important;
  font-family: "Font Awesome 5 Free" !important;
  content: "\f053" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1.75rem !important;
}

.body-5-section .slick-next:before {
  color: rgba(0, 0, 0, 0.75) !important;

  font-family: "Font Awesome 5 Free" !important;
  content: "\f054" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1.75rem !important;
}

.body-5-section {
  padding-top: 4rem;
  padding-bottom: 4rem;
  padding-right: var(--bs-gutter-x, 2rem) !important;
  padding-left: var(--bs-gutter-x, 2rem) !important;
}

.body-5-section .text-center {
  font-size: 1.8rem;
  font-weight: 400;
  margin-bottom: 3rem;
}

.body-5-section .slick-dots li button:before {
  font-size: 0.7rem !important;
}

.body-5-section .slick-dots li {
  margin: 0.1rem !important;
}

.body-5-section .slick-dots {
  bottom: -40px !important;
}

.img_home {
  object-fit: cover;
  width: 100%;
  height: 15rem;
}

@media (max-width: 1200px) {
  .img_home {
    height: 13rem;
  }
}

@media (max-width: 992px) {
  .img_home {
    height: 12rem;
  }
}

@media (max-width: 768px) {
  .img_home {
    height: 11rem;
  }
}

@media (max-width: 576px) {
  .img_home {
    height: 9rem;
  }
}
</style>
