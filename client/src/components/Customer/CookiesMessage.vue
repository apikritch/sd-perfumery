<template>
  <div v-if="isOpen" class="cover_cookie">
    <div class="row align-items-center">
      <div class="col-10">
        <div class="cookie_message">
          We use cookies to offer you a better experience, analyze site traffic,
          and serve targeted advertisements. By continuing to use the website,
          you consent to the use of cookies in accordance with our Cookie Policy
        </div>
      </div>
      <div
        class="col-2 d-flex justify-content-center align-items-center"
        @click="accept"
      >
        Accept
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CookieMessage",
  data() {
    return {
      isOpen: true,
    };
  },
  created() {
    if (localStorage.getItem("cookies_accept") == "true") {
      this.isOpen = false;
    }
  },
  methods: {
    accept() {
      this.isOpen = false;
      localStorage.setItem("cookies_accept", true);
    },
  },
};
</script>

<style scoped>
.cover_cookie {
  position: fixed;
  bottom: 0vh;
  background-color: rgba(0, 0, 0, 0.75);
  width: 100%;
  padding: 0.75rem;
}

.cover_cookie .row {
  margin: unset;
}

.cover_cookie .col-10 {
  color: #fff;
  font-weight: 300;
}

.cover_cookie .col-2 {
  background: #000;
  color: #fff;
  height: 2rem;
  cursor: pointer;
  user-select: none;
}

.cover_cookie .col-2:hover {
  background: rgb(22, 22, 22);
}

.cookie_message {
  width: 75%;
  font-size: 0.8rem;
}
</style>
