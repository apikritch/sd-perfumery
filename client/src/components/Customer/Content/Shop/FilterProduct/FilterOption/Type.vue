<template>
  <div class="filter-type">
    <b-button
      class="d-flex justify-content-between align-items-center w-100 type-collapse-button"
      aria-controls="collapse-type"
      :aria-expanded="visible ? 'true' : 'false'"
      @click="visible = !visible"
      :class="visible ? null : 'collapsed'"
    >
      <div class="filter-type-header">Type</div>
      <font-awesome-icon icon="chevron-down" class="rotate-chevron" />
    </b-button>
    <b-collapse id="collapse-type" v-model="visible" class="type-collapse-area">
      <div class="padding-type">
        <div class="form-check" v-for="(type, index) in types" :key="index">
          <input
            class="form-check-input"
            type="checkbox"
            :value="type.title"
            :id="`${type.text}-check-box`"
            v-model="selected"
            @change="changeValueType(selected)"
          />
          <label class="form-check-label" :for="`${type.text}-check-box`">
            {{ type.title }}
          </label>
        </div>
      </div>
    </b-collapse>
  </div>
</template>

<script>
import { getFilterTypeOptions } from "@/services/OptionService";
export default {
  name: "MyType",
  props: { changeValueType: Function },
  data() {
    return {
      visible: false,
      selected: [],
      types: [],
    };
  },
  async mounted() {
    this.types = await getFilterTypeOptions();
  },
};
</script>

<style scoped>
.filter-type .rotate-chevron {
  transition: all 0.3s ease;
  font-size: 1.25rem;
  color: #985855;
}

.filter-type .type-collapse-button.collapsed .rotate-chevron {
  transform: rotate(-90deg);
}

.filter-type .type-collapse-button {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
  padding: unset;
}

.filter-type .type-collapse-button:hover {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-type .type-collapse-button:focus {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-type .btn-check:checked + .btn-secondary:focus,
.filter-type .btn-check:active + .btn-secondary:focus,
.filter-type .btn-secondary:active:focus,
.filter-type .btn-secondary.active:focus,
.filter-type .show > .btn-secondary.dropdown-toggle:focus {
  box-shadow: unset !important;
}

.filter-type .filter-type-header {
  font-weight: 500;
  font-size: 1.1rem;
}

.filter-type {
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
}

.filter-type .padding-type {
  padding-top: 0.5rem;
}

.filter-type .form-check-input:checked {
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
