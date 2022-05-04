<template>
  <div class="col-3 shop-filter col-3-self">
    <div class="filter-header">FILTER BY</div>
    <div>
      <Price :changeValuePrice="changeValuePrice" />
      <Gender
        :changeValueGender="changeValueGender"
        v-if="$route.name == 'SHOP'"
      />
      <Size :changeValueSize="changeValueSize" />
      <Type :changeValueType="changeValueType" />
      <Brand :changeValueBrand="changeValueBrand" />
    </div>
  </div>
</template>

<script>
import Price from "./FilterOption/Price.vue";
import Gender from "./FilterOption/Gender.vue";
import Size from "./FilterOption/Size.vue";
import Type from "./FilterOption/Type.vue";
import Brand from "./FilterOption/Brand.vue";

export default {
  name: "FilterProduct",
  props: [
    "changeValuePrice",
    "changeValueSize",
    "changeValueGender",
    "changeValueType",
    "changeValueBrand",
  ],
  components: { Price, Gender, Size, Type, Brand },
};
</script>

<style scoped>
.shop-filter .filter-header {
  padding-bottom: 0.5rem;
  color: rgba(0, 0, 0, 0.35);
  border-bottom: 1px solid #384648;
  font-weight: 700;
  font-size: 1.15rem;
}

.shop-filter.col-3-self {
  width: 20%;
  flex: 0 0 auto;
}

.shop-filter {
  border-right: 1px solid #384648;
  padding-right: 1.5rem;
}
</style>
