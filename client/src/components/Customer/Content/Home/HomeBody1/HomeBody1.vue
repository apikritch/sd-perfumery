<template>
  <div class="carousel-section">
    <VueSlickCarousel v-bind="settings" v-if="images.length > 0"
      ><div v-for="(image, index) in sort" :key="index">
        <img :src="image.link_address" width="100%" /></div
    ></VueSlickCarousel>
  </div>
</template>

<script>
import { getCarousels } from "@/services/AdminUIComponentService";
import VueSlickCarousel from "vue-slick-carousel";

export default {
  name: "HomeBody1",
  components: { VueSlickCarousel },

  data: function() {
    return {
      settings: {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: true,
      },
      images: [],
    };
  },
  computed: {
    sort() {
      return this.sortCarousel(this.images);
    },
  },
  methods: {
    sortCarousel(images) {
      return [...images].sort((p1, p2) => {
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
    this.images = (await getCarousels()).data;
  },
};
</script>

<style>
.carousel-section img {
  height: 400px;
  object-fit: cover;
}

.carousel-section .slick-prev:before {
  color: rgba(255, 255, 255, 1) !important;
  font-family: "Font Awesome 5 Free" !important;
  content: "\f053" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1.75rem !important;
  margin-left: -5px !important;
}

.carousel-section .slick-next:before {
  color: rgba(255, 255, 255, 1) !important;
  font-family: "Font Awesome 5 Free" !important;
  content: "\f054" !important;
  display: inline-block;
  font-weight: 900;
  font-size: 1.75rem !important;
  margin-right: -5px !important;
}

.carousel-section .slick-dots li button:before {
  font-size: 0.7rem !important;
}

.carousel-section .slick-dots li {
  margin: 0.7rem !important;
}

.carousel-section .slick-dots li.slick-active button:before {
  opacity: 1;
  color: white !important;
  width: 50px !important;
  background-color: white !important;
}

.carousel-section .slick-dots li button:before {
  opacity: 0.55;
  color: black !important;
  width: 50px !important;
  background-color: black !important;
  position: unset !important;
  padding-left: 15px;
  padding-right: 15px;
  font-size: 0.4rem !important;
}

.slick-dots li button {
  height: 1px !important;
}

.carousel-section .slick-dots {
  bottom: 20px !important;
  display: flex !important;
  justify-content: center !important;
  left: -15px !important;
}

.carousel-section .slick-prev {
  left: 50px !important;
  z-index: 100 !important;
  background-color: rgba(0, 0, 0, 0.5) !important;
  width: 2.25rem;
  height: 2.25rem;
  border-radius: 100%;
}
.carousel-section .slick-next {
  right: 50px !important;
  z-index: 100 !important;
  background-color: rgba(0, 0, 0, 0.5) !important;
  width: 2.25rem;
  height: 2.25rem;
  border-radius: 100%;
}
</style>
