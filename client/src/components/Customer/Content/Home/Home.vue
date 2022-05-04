<template>
  <div>
    <HomeBody1></HomeBody1>
    <HomeBody2></HomeBody2>
    <HomeBody3></HomeBody3>
    <HomeBody4></HomeBody4>
    <HomeBody5></HomeBody5>
  </div>
</template>

<script>
import HomeBody1 from "./HomeBody1/HomeBody1.vue";
import HomeBody2 from "./HomeBody2/HomeBody2.vue";
import HomeBody3 from "./HomeBody3/HomeBody3.vue";
import HomeBody4 from "./HomeBody4/HomeBody4.vue";
import HomeBody5 from "./HomeBody5/HomeBody5.vue";

export default {
  name: "MyHome",
  components: { HomeBody1, HomeBody2, HomeBody3, HomeBody4, HomeBody5 },
};
</script>

<style scoped></style>
