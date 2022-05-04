<template>
  <div>
    <div class="first-footer-section">
      <div class="container-lg">
        <div class="row justify-content-end">
          <div class="col-4 d-flex justify-content-center">
            <div>
              <h6>SHOP</h6>
              <p>Women's</p>
              <p>Men's</p>
              <p>Unisex</p>
              <p>Brands</p>
              <p>New Arrivals</p>
              <p>Sale</p>
            </div>
          </div>
          <div class="col-4 d-flex justify-content-center">
            <div>
              <h6>ABOUT US</h6>
              <p>Terms & Conditions</p>
              <p>Privacy Policy</p>
              <p>About Us</p>
            </div>
          </div>
          <div class="col-4 d-flex justify-content-center">
            <div>
              <h6>CUSTOMER SERVICE</h6>
              <p>Help</p>
              <p>Payment</p>
              <p>Order Status</p>
              <p>Shipping Information</p>
              <p>How to Return</p>
              <p>Contact Us</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="second-footer-section justify-content-center d-flex align-items-center"
    >
      Copyright © 2021 SDPerfumerry.lk All Rights Reserved.
    </div>
  </div>
</template>

<script>
export default {
  name: "MyFooter",
};
</script>

<style>
.first-footer-section {
  background-color: #7e989c;
  color: #ffffff;
  padding-bottom: 3rem;
  padding-top: 3rem;
}

.first-footer-section .col-4 p {
  font-size: 0.8rem;
  font-weight: 300;
  margin-bottom: 0.3rem;
}

.first-footer-section .col-4 h6 {
  margin-bottom: 1rem;
}

.second-footer-section {
  background-color: #384648;
  height: 40px;
  color: #ffffff;
  font-size: 0.9rem;
}
</style>
