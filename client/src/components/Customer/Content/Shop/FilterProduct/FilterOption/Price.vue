<template>
  <div class="filter-price">
    <div class="filter-price-header">Price</div>
    <div
      v-if="max > 0"
      class="padding-slider">
      <VueSlider
        v-model="value"
        :interval="1"
        :min="min"
        :max="max"
        @change="changeValuePrice(value)" />
    </div>
    <div
      v-if="max > 0"
      class="d-flex justify-content-between">
      <div>Rs. {{ value[0] }}</div>
      <div>Rs. {{ value[1] }}</div>
    </div>
  </div>
</template>

<script>
import { getProducts } from "@/services/ProductService";

export default {
  name: "MyPrice",
  props: { changeValuePrice: Function },
  data() {
    return {
      products: [],
      min: null,
      max: null,
      value: [],
    };
  },
  async mounted() {
    this.products = (await getProducts()).data;

    this.min = 0;

    this.max = await Math.max.apply(
      Math,
      this.products.map((product) => product.final_price),
    );

    this.value = [
      0,
      await Math.max.apply(
        Math,
        this.products.map((product) => product.final_price),
      ),
    ];
  },
};
</script>

<style>
.filter-price .vue-slider-process {
  background-color: #f3cabc;
}

.filter-price .vue-slider-dot-handle {
  background-color: #985855;
  box-shadow: 0.5px 0.5px 2px 1px rgba(0, 0, 0, 0.25);
}

.filter-price {
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
}

.filter-price .padding-slider {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}

.filter-price .filter-price-header {
  font-weight: 500;
  font-size: 1.1rem;
}

.filter-price .vue-slider-dot-tooltip-inner {
  border-color: #985855;
  background-color: #985855;
}
</style>
