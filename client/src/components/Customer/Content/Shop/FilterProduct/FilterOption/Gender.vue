<template>
  <div class="filter-gender">
    <b-button
      class="d-flex justify-content-between align-items-center w-100 gender-collapse-button"
      aria-controls="collapse-gender"
      :aria-expanded="visible ? 'true' : 'false'"
      :class="visible ? null : 'collapsed'"
      @click="visible = !visible">
      <div class="filter-gender-header">Gender</div>
      <font-awesome-icon
        icon="chevron-down"
        class="rotate-chevron" />
    </b-button>
    <b-collapse
      id="collapse-gender"
      v-model="visible"
      class="gender-collapse-area">
      <div class="padding-gender">
        <div
          v-for="(gender, index) in genders"
          :key="index"
          class="form-check">
          <input
            :id="`${gender.text}-check-box`"
            v-model="selected"
            class="form-check-input"
            type="checkbox"
            :value="gender.title"
            @change="changeValueGender(selected)" />
          <label
            class="form-check-label"
            :for="`${gender.text}-check-box`">
            {{ gender.title }}
          </label>
        </div>
      </div>
    </b-collapse>
  </div>
</template>

<script>
import { getFilterGenderOptions } from "@/services/OptionService";

export default {
  name: "MyGender",
  props: { changeValueGender: Function },
  data() {
    return {
      visible: false,
      selected: [],
      genders: [],
    };
  },
  async mounted() {
    this.genders = await getFilterGenderOptions();
  },
};
</script>

<style scoped>
.filter-gender .rotate-chevron {
  transition: all 0.3s ease;
  font-size: 1.25rem;
  color: #985855;
}

.filter-gender .gender-collapse-button.collapsed .rotate-chevron {
  transform: rotate(-90deg);
}

.filter-gender .gender-collapse-button {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
  padding: unset;
}

.filter-gender .gender-collapse-button:hover {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-gender .gender-collapse-button:focus {
  color: #384648;
  background-color: unset;
  border: unset;
  box-shadow: unset;
}

.filter-gender .btn-check:checked + .btn-secondary:focus,
.filter-gender .btn-check:active + .btn-secondary:focus,
.filter-gender .btn-secondary:active:focus,
.filter-gender .btn-secondary.active:focus,
.filter-gender .show > .btn-secondary.dropdown-toggle:focus {
  box-shadow: unset !important;
}

.filter-gender .filter-gender-header {
  font-weight: 500;
  font-size: 1.1rem;
}

.filter-gender {
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #384648;
}

.filter-gender .padding-gender {
  padding-top: 0.5rem;
}

.filter-gender .form-check-input:checked {
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
