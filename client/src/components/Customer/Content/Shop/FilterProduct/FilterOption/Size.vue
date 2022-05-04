<template>
  <div class="filter-size">
    <b-button
      class="d-flex justify-content-between align-items-center w-100 size-collapse-button"
      aria-controls="collapse-size"
      :aria-expanded="visible ? 'true' : 'false'"
      @click="visible = !visible"
      :class="visible ? null : 'collapsed'"
    >
      <div class="filter-size-header">Size</div>
      <font-awesome-icon icon="chevron-down" class="rotate-chevron" />
    </b-button>
    <b-collapse id="collapse-size" v-model="visible" class="size-collapse-area">
      <div class="padding-size" v-if="max > 0">
        <VueSlider
          :interval="1"
          :min="min"
          :max="max"
          v-model="value"
          @change="changeValueSize(value)"
        />
      </div>
      <div class="d-flex justify-content-between" v-if="max > 0">
        <div>{{ value[0] }} ml</div>
        <div>{{ value[1] }} ml</div>
      </div>
    </b-collapse>
  </div>
</template>

<script>
import { getProducts } from "@/services/ProductService";

export default {
  name: "MySize",
  props: { changeValueSize: Function },
  data() {
    return {
      visible: false,
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
      this.products.map((product) => product.size)
    );

    this.value = [
      0,
      await Math.max.apply(
        Math,
        this.products.map((product) => product.size)
      ),
    ];
  },
};
</script>

<style>
.filter-size .rotate-chevron {
  transition: all 0.3s ease;
  font-size: 1.25rem;
  color: #985855;
}

.filter-size .size-collapse-button.collapsed .rotate-chevron {
  transform: rotate(-90deg);
}

.filter-size .size-collapse-button {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
  padding: unset;
}

.filter-size .size-collapse-button:hover {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-size .size-collapse-button:focus {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-size .btn-check:checked + .btn-secondary:focus,
.filter-size .btn-check:active + .btn-secondary:focus,
.filter-size .btn-secondary:active:focus,
.filter-size .btn-secondary.active:focus,
.filter-size .show > .btn-secondary.dropdown-toggle:focus {
  box-shadow: unset !important;
}

.filter-size .filter-size-header {
  font-weight: 500;
  font-size: 1.1rem;
}

.filter-size {
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
}

.filter-size .padding-size {
  padding-top: 0.5rem;
}

.filter-size .vue-slider-process {
  background-color: #f3cabc;
}

.filter-size .vue-slider-dot-handle {
  background-color: #985855;
  box-shadow: 0.5px 0.5px 2px 1px rgba(0, 0, 0, 0.25);
}

.filter-size .padding-size {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}

.filter-size .vue-slider-dot-tooltip-inner {
  border-color: #985855;
  background-color: #985855;
}
</style>
