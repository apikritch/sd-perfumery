<template>
  <div class="filter-brand">
    <b-button
      class="d-flex justify-content-between align-items-center w-100 brand-collapse-button"
      aria-controls="collapse-brand"
      :aria-expanded="visible ? 'true' : 'false'"
      :class="visible ? null : 'collapsed'"
      @click="visible = !visible">
      <div class="filter-brand-header">Brand</div>
      <font-awesome-icon
        icon="chevron-down"
        class="rotate-chevron" />
    </b-button>
    <b-collapse
      id="collapse-brand"
      v-model="visible"
      class="brand-collapse-area">
      <div class="padding-brand">
        <div
          v-for="(brand, index) in brands"
          :key="index"
          class="form-check">
          <input
            :id="`${brand.text}-check-box`"
            v-model="selected"
            class="form-check-input"
            type="checkbox"
            :value="brand.text"
            @change="changeValueBrand(selected)" />
          <label
            class="form-check-label"
            :for="`${brand.text}-check-box`">
            {{ brand.text }}
          </label>
        </div>
      </div>
    </b-collapse>
  </div>
</template>

<script>
import { getBrandOptions } from "@/services/AdminOptionService";

export default {
  name: "MyBrand",
  props: { changeValueBrand: Function },
  data() {
    return {
      visible: false,
      selected: [],
      brands: [],
    };
  },
  async mounted() {
    const allbrand = (await getBrandOptions()).data;
    const sort_all_brand = [...allbrand].sort((b1, b2) => {
      var brand_a = b1.text;
      var brand_b = b2.text;

      if (brand_a < brand_b) {
        return -1;
      }

      if (brand_a > brand_b) {
        return 1;
      }

      return 0;
    });
    this.brands = sort_all_brand;
  },
};
</script>

<style scoped>
.filter-brand .rotate-chevron {
  transition: all 0.3s ease;
  font-size: 1.25rem;
  color: #985855;
}

.filter-brand .brand-collapse-button.collapsed .rotate-chevron {
  transform: rotate(-90deg);
}

.filter-brand .brand-collapse-button {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
  padding: unset;
}

.filter-brand .brand-collapse-button:hover {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-brand .brand-collapse-button:focus {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-brand .btn-check:checked + .btn-secondary:focus,
.filter-brand .btn-check:active + .btn-secondary:focus,
.filter-brand .btn-secondary:active:focus,
.filter-brand .btn-secondary.active:focus,
.filter-brand .show > .btn-secondary.dropdown-toggle:focus {
  box-shadow: unset !important;
}

.filter-brand .filter-brand-header {
  font-weight: 500;
  font-size: 1.1rem;
}

.filter-brand {
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
}

.filter-brand .padding-brand {
  padding-top: 0.5rem;
}

.filter-brand .form-check-input:checked {
  background-color: #985855;
  border-color: #985855;
  width: 1rem;
  height: 1rem;
}

.form-check-input:focus {
  border-color: rgba(0, 0, 0, 0.25);
  outline: unset;
  box-shadow: unset;
}
</style>
