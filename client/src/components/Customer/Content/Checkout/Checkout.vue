<template>
  <div>
    <div class="checkout-top shadow-sm">
      <div class="container h-100 checkout-padding d-flex align-items-center">
        <div>SD Perfumery</div>
      </div>
    </div>
    <div class="container h-100 checkout-padding">
      <div class="row checkout-body-padding">
        <div class="col-12 col-xl-7 checkout-right-padding order-1 order-xl-0">
          <div class="checkout-header">Checkout</div>
          <div
            v-if="!$store.state.isCustomerLoggedIn"
            class="d-flex align-items-start flex-column checkout-sign-in-section">
            <div>Already have an account?</div>
            <div
              class="checkout-sign-in-button"
              @click="showSignIn">
              Sign In
            </div>
          </div>
          <div class="shipping-section-padding">
            <div class="checkout-topic">1. Shipping Address</div>
            <div class="checkout-row">
              <div class="shipping-label">Email:</div>
              <input
                v-model.trim="$v.email.$model"
                type="text"
                class="shipping-long-input email"
                :class="[
                  $v.email.$error ? 'border-fail' : null,
                  $v.email.required && $v.email.email ? 'border-success' : null,
                ]"
                :disabled="$store.state.isCustomerLoggedIn" />
              <div
                v-if="$v.email.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.email.required"
                  class="error">
                  Email is required.
                </div>
                <div
                  v-if="!$v.email.email"
                  class="error">
                  Invalid email format.
                </div>
              </div>
            </div>
            <div
              v-if="
                !$store.state.isCustomerLoggedIn || !$store.state.customer.email
              "
              class="checkout-row">
              <div class="shipping-label">Confirm Email:</div>
              <input
                v-model.trim="$v.confirm_email.$model"
                type="text"
                class="shipping-long-input"
                :class="[
                  $v.confirm_email.$error ? 'border-fail' : null,
                  $v.confirm_email.required &&
                  $v.confirm_email.email &&
                  $v.confirm_email.sameAsEmail
                    ? 'border-success'
                    : null,
                ]" />
              <div
                v-if="$v.confirm_email.$dirty"
                class="position-relative">
                <div
                  v-if="
                    !$v.confirm_email.sameAsEmail &&
                    $v.confirm_email.required &&
                    $v.confirm_email.email
                  "
                  class="error">
                  Emails must be identical.
                </div>
                <div
                  v-if="!$v.confirm_email.email"
                  class="error">
                  Invalid email format.
                </div>
                <div
                  v-if="!$v.confirm_email.required"
                  class="error">
                  Confirm Email is required.
                </div>
              </div>
            </div>
            <div class="checkout-row">
              <div class="row">
                <div class="col-6">
                  <div class="shipping-label">First Name:</div>
                  <input
                    v-model.trim="$v.first_name.$model"
                    type="text"
                    class="shipping-long-input"
                    :class="[
                      $v.first_name.$error ? 'border-fail' : null,
                      $v.first_name.required ? 'border-success' : null,
                    ]" />
                  <div
                    v-if="$v.first_name.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.first_name.required"
                      class="error">
                      Required.
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="shipping-label">Last Name:</div>
                  <input
                    v-model.trim="$v.last_name.$model"
                    type="text"
                    class="shipping-long-input"
                    :class="[
                      $v.last_name.$error ? 'border-fail' : null,
                      $v.last_name.required ? 'border-success' : null,
                    ]" />
                  <div
                    v-if="$v.last_name.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.last_name.required"
                      class="error">
                      Required.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="checkout-row">
              <div class="row">
                <div class="col-6">
                  <div class="shipping-label">Phone:</div>
                  <input
                    v-model.trim="$v.phone.$model"
                    type="text"
                    class="shipping-long-input"
                    :class="[
                      $v.phone.$error ? 'border-fail' : null,
                      $v.phone.required && $v.phone.numeric
                        ? 'border-success'
                        : null,
                    ]" />
                  <div
                    v-if="$v.phone.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.phone.required"
                      class="error">
                      Required.
                    </div>
                    <div
                      v-if="!$v.phone.numeric"
                      class="error">
                      Invalid value.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="checkout-row">
              <div class="shipping-label">Country:</div>
              <div class="country-input">Sri Lanka</div>
            </div>
            <div class="checkout-row">
              <div class="row">
                <div class="col-6">
                  <div class="shipping-label">Address 1:</div>
                  <input
                    v-model.trim="$v.address_1.$model"
                    type="text"
                    class="shipping-long-input"
                    :class="[
                      $v.address_1.$error ? 'border-fail' : null,
                      $v.address_1.required ? 'border-success' : null,
                    ]" />
                  <div
                    v-if="$v.address_1.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.address_1.required"
                      class="error">
                      Required.
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="shipping-label">Adress 2:</div>
                  <input
                    v-model="address_2"
                    type="text"
                    class="shipping-long-input" />
                </div>
              </div>
            </div>
            <div class="checkout-row">
              <div class="shipping-label">Town / City:</div>
              <input
                v-model.trim="$v.city.$model"
                type="text"
                class="shipping-long-input"
                :class="[
                  $v.city.$error ? 'border-fail' : null,
                  $v.city.required ? 'border-success' : null,
                ]" />
              <div
                v-if="$v.city.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.city.required"
                  class="error">
                  Required.
                </div>
              </div>
            </div>
            <div class="checkout-row">
              <div class="shipping-label">District / State:</div>
              <input
                v-model.trim="$v.state.$model"
                type="text"
                class="shipping-long-input"
                :class="[
                  $v.state.$error ? 'border-fail' : null,
                  $v.state.required ? 'border-success' : null,
                ]" />
              <div
                v-if="$v.state.$dirty"
                class="position-relative">
                <div
                  v-if="!$v.state.required"
                  class="error">
                  Required.
                </div>
              </div>
            </div>
            <div class="checkout-row">
              <div class="row">
                <div class="col-6">
                  <div class="shipping-label">Postcode:</div>
                  <input
                    v-model.trim="$v.postcode.$model"
                    type="text"
                    class="shipping-long-input"
                    :class="[
                      $v.postcode.$error ? 'border-fail' : null,
                      $v.postcode.required && $v.postcode.numeric
                        ? 'border-success'
                        : null,
                    ]" />
                  <div
                    v-if="$v.postcode.$dirty"
                    class="position-relative">
                    <div
                      v-if="!$v.postcode.required"
                      class="error">
                      Required.
                    </div>
                    <div
                      v-if="!$v.postcode.numeric"
                      class="error">
                      Invalid value.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="shipping-section-padding">
            <div
              class="checkout-topic"
              :class="no_shipping_method ? 'text-danger' : null">
              2. Shipping Method
            </div>
            <div class="checkout-row">
              <div class="row">
                <div class="col-12 col-sm-8 col-lg-7">
                  <div>
                    <div
                      v-for="(shipment, index) in shipments"
                      :key="index"
                      class="form-check shipping_method_hover d-flex align-items-center"
                      :class="[
                        no_shipping_method ? 'border-danger text-danger' : null,
                        shipment.shipping_method == shipping_method
                          ? 'shipping-method-color'
                          : null,
                        {
                          'shipping-method-color':
                            shipping_method == null && index == 0,
                        },
                        {
                          'shipping-method-0':
                            shipments.length == 1 && index == 0,
                        },
                        {
                          'shipping-method-1':
                            shipments.length !== 1 && index == 0,
                        },
                        {
                          'shipping-method-2':
                            index !== shipments.length - 1 && index !== 0,
                        },
                        {
                          'shipping-method-3':
                            shipments.length !== 1 &&
                            index == shipments.length - 1,
                        },
                      ]">
                      <input
                        :id="shipment.shipping_method"
                        class="form-check-input"
                        type="radio"
                        name="radio-shipping-method"
                        :value="shipment.shipping_method"
                        @change="chooseShipping(index)" />
                      <label
                        class="form-check-label w-50"
                        :for="shipment.shipping_method">
                        {{ shipment.shipping_method }}
                      </label>
                      <div class="w-50 d-flex justify-content-end">
                        <div class="pe-3">
                          Rs.
                          {{
                            shipment.shipping_fee.toLocaleString(undefined, {
                              minimumFractionDigits: 2,
                              maximumFractionDigits: 2,
                            })
                          }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="shipping-section-padding">
            <div class="checkout-topic">3. Billing Address</div>
            <div
              class="form-check checkout-same-check-box d-flex align-items-center">
              <input
                id="same-address-check-box"
                v-model="same_address"
                class="form-check-input"
                type="checkbox" />
              <label
                class="form-check-label adjust-center-box"
                for="same-address-check-box">
                My Billing address is the same as my Shipping address
              </label>
            </div>

            <div
              v-if="
                same_address &&
                first_name &&
                last_name &&
                phone &&
                address_1 &&
                city &&
                state &&
                postcode
              ">
              <div class="billing-address-text billing-name">
                {{ first_name }} {{ last_name }}
              </div>
              <div class="billing-address-text">{{ phone }}</div>
              <div class="billing-address-text">
                {{ address_1 }}, {{ address_2 }}
              </div>
              <div class="billing-address-text">
                {{ city }}, {{ state }} {{ postcode }} / Sri Lanka
              </div>
            </div>
            <div v-if="!same_address">
              <div class="checkout-row">
                <div class="row">
                  <div class="col-6">
                    <div class="shipping-label">First Name:</div>
                    <input
                      v-model.trim="$v.billing_first_name.$model"
                      type="text"
                      class="shipping-long-input"
                      :class="[
                        $v.billing_first_name.$error ? 'border-fail' : null,
                        $v.billing_first_name.required
                          ? 'border-success'
                          : null,
                      ]" />
                    <div
                      v-if="$v.billing_first_name.$dirty"
                      class="position-relative">
                      <div
                        v-if="!$v.billing_first_name.required"
                        class="error">
                        Required.
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="shipping-label">Last Name:</div>
                    <input
                      v-model.trim="$v.billing_last_name.$model"
                      type="text"
                      class="shipping-long-input"
                      :class="[
                        $v.billing_last_name.$error ? 'border-fail' : null,
                        $v.billing_last_name.required ? 'border-success' : null,
                      ]" />
                    <div
                      v-if="$v.billing_last_name.$dirty"
                      class="position-relative">
                      <div
                        v-if="!$v.billing_last_name.required"
                        class="error">
                        Required.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="checkout-row">
                <div class="row">
                  <div class="col-6">
                    <div class="shipping-label">Phone:</div>
                    <input
                      v-model.trim="$v.billing_phone.$model"
                      type="text"
                      class="shipping-long-input"
                      :class="[
                        $v.billing_phone.$error ? 'border-fail' : null,
                        $v.billing_phone.required && $v.billing_phone.numeric
                          ? 'border-success'
                          : null,
                      ]" />
                    <div
                      v-if="$v.billing_phone.$dirty"
                      class="position-relative">
                      <div
                        v-if="!$v.billing_phone.required"
                        class="error">
                        Required.
                      </div>
                      <div
                        v-if="!$v.billing_phone.numeric"
                        class="error">
                        Invalid value.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="checkout-row">
                <div class="shipping-label">Country:</div>
                <div class="country-input">Sri Lanka</div>
              </div>
              <div class="checkout-row">
                <div class="row">
                  <div class="col-6">
                    <div class="shipping-label">Address 1:</div>
                    <input
                      v-model.trim="$v.billing_address_1.$model"
                      type="text"
                      class="shipping-long-input"
                      :class="[
                        $v.billing_address_1.$error ? 'border-fail' : null,
                        $v.billing_address_1.required ? 'border-success' : null,
                      ]" />
                    <div
                      v-if="$v.billing_address_1.$dirty"
                      class="position-relative">
                      <div
                        v-if="!$v.billing_address_1.required"
                        class="error">
                        Required.
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="shipping-label">Adress 2:</div>
                    <input
                      v-model="billing_address_2"
                      type="text"
                      class="shipping-long-input" />
                  </div>
                </div>
              </div>
              <div class="checkout-row">
                <div class="shipping-label">Town / City:</div>
                <input
                  v-model.trim="$v.billing_city.$model"
                  type="text"
                  class="shipping-long-input"
                  :class="[
                    $v.billing_city.$error ? 'border-fail' : null,
                    $v.billing_city.required ? 'border-success' : null,
                  ]" />
                <div
                  v-if="$v.billing_city.$dirty"
                  class="position-relative">
                  <div
                    v-if="!$v.billing_city.required"
                    class="error">
                    Required.
                  </div>
                </div>
              </div>
              <div class="checkout-row">
                <div class="shipping-label">District / State:</div>
                <input
                  v-model.trim="$v.billing_state.$model"
                  type="text"
                  class="shipping-long-input"
                  :class="[
                    $v.billing_state.$error ? 'border-fail' : null,
                    $v.billing_state.required ? 'border-success' : null,
                  ]" />
                <div
                  v-if="$v.billing_state.$dirty"
                  class="position-relative">
                  <div
                    v-if="!$v.billing_state.required"
                    class="error">
                    Required.
                  </div>
                </div>
              </div>
              <div class="checkout-row">
                <div class="row">
                  <div class="col-6">
                    <div class="shipping-label">Postcode:</div>
                    <input
                      v-model.trim="$v.billing_postcode.$model"
                      type="text"
                      class="shipping-long-input"
                      :class="[
                        $v.billing_postcode.$error ? 'border-fail' : null,
                        $v.billing_postcode.required &&
                        $v.billing_postcode.numeric
                          ? 'border-success'
                          : null,
                      ]" />
                    <div
                      v-if="$v.billing_postcode.$dirty"
                      class="position-relative">
                      <div
                        v-if="!$v.billing_postcode.required"
                        class="error">
                        Required.
                      </div>
                      <div
                        v-if="!$v.billing_postcode.numeric"
                        class="error">
                        Invalid value.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="shipping-section-padding">
            <div
              class="checkout-topic"
              :class="no_payment_method ? 'text-danger' : null">
              4. Payment Method
            </div>
            <div class="checkout-row">
              <div
                class="form-check payment-1 d-flex align-items-center"
                :class="[
                  no_payment_method ? 'border-danger text-danger' : null,
                  payment_method == 'bank-a' || payment_method == null
                    ? 'payment-color'
                    : null,
                ]">
                <input
                  id="bank-a"
                  v-model="payment_method"
                  class="form-check-input"
                  type="radio"
                  name="radio-payment"
                  value="bank-a" />
                <label
                  class="form-check-label"
                  for="bank-a">
                  Direct Deposit / Transfer - Commercial Bank of Ceylon
                </label>
              </div>
              <div
                class="form-check payment-2 d-flex align-items-center"
                :class="[
                  no_payment_method ? 'border-danger text-danger' : null,
                  payment_method == 'bank-b' ? 'payment-color' : null,
                ]">
                <input
                  id="bank-b"
                  v-model="payment_method"
                  class="form-check-input"
                  type="radio"
                  name="radio-payment"
                  value="bank-b" />
                <label
                  class="form-check-label"
                  for="bank-b">
                  Direct Deposit / Transfer - Sampath Bank Plc
                </label>
              </div>
              <div
                class="form-check payment-3 d-flex align-items-center"
                :class="[
                  no_payment_method ? 'border-danger text-danger' : null,
                  payment_method == 'bank-c' ? 'payment-color' : null,
                ]">
                <input
                  id="bank-c"
                  v-model="payment_method"
                  class="form-check-input"
                  type="radio"
                  name="radio-payment"
                  value="bank-c" />
                <label
                  class="form-check-label"
                  for="bank-c">
                  Direct Deposit / Transfer - Hatton National Bank
                </label>
              </div>
            </div>
            <div
              v-if="payment_method"
              class="checkout-description">
              <div class="pb-4">
                Please use the following details to make a direct deposit or
                transfer your total order value:
              </div>
              <div class="pb-4">
                <div class="thin-label">
                  Bank:
                  <div class="d-inline checkout-bank-account">
                    {{ payment_bank }}
                  </div>
                </div>
                <div class="thin-label">
                  Account Name:
                  <div class="d-inline checkout-bank-account">
                    {{ payment_account_name }}
                  </div>
                </div>
                <div class="thin-label">
                  Account Detail:
                  <div class="d-inline checkout-bank-account">
                    {{ payment_account_detail }}
                  </div>
                </div>
              </div>
              <div class="pb-2">
                Please use your
                <div class="d-inline checkout-important-oreder-number">
                  ORDER NUMBER
                </div>
                as the reference/deposit detail. Your order will not ship until
                we receive payment in the above account.
              </div>
              <div class="pb-2">
                Bank transfer may take up to 2 working days to show in our
                account.
              </div>
              <div class="checkout-important">
                ORDER WILL BE CANCELLED AFTER 7 DAYS WHEN FUNDS HAVE NOT
                RECEIVED.
              </div>
            </div>
          </div>
          <div class="position-relative">
            <div
              class="sent_box_2"
              :class="success ? 'visible' : 'hidden'">
              Your order successfully placed!
            </div>
            <div
              v-if="place_order_loading"
              class="sent_box_3"></div>
            <div
              class="place-order-button"
              @click="placeOrder">
              <div v-if="!place_order_loading">PLACE ORDER</div>
              <BeatLoader
                :loading="place_order_loading"
                color="#fff"
                size="0.5rem"
                class="text-center"></BeatLoader>
            </div>
            <div
              class="sent_box"
              :class="no_item ? 'visible' : 'hidden'">
              You have no items in your shopping cart.
            </div>
            <div
              class="sent_box"
              :class="no_payment_method ? 'visible' : 'hidden'">
              Please select payment method.
            </div>
            <div
              class="sent_box"
              :class="no_shipping_method ? 'visible' : 'hidden'">
              Please select shipping method.
            </div>
            <div
              class="sent_box"
              :class="
                $v.email.$anyError ||
                $v.confirm_email.$anyError ||
                $v.first_name.$anyError ||
                $v.last_name.$anyError ||
                $v.phone.$anyError ||
                $v.address_1.$anyError ||
                $v.city.$anyError ||
                $v.state.$anyError ||
                $v.postcode.$anyError ||
                $v.billing_first_name.$anyError ||
                $v.billing_last_name.$anyError ||
                $v.billing_phone.$anyError ||
                $v.billing_address_1.$anyError ||
                $v.billing_city.$anyError ||
                $v.billing_state.$anyError ||
                $v.billing_postcode.$anyError
                  ? 'visible'
                  : 'hidden'
              ">
              Please fill in a valid value for all required fields.
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-5 checkout-left-padding order-0 order-xl-1">
          <div class="summary-card mb-4 mb-xl-0">
            <div class="d-flex justify-content-between summary-head-section">
              <div class="summary-header">Order Summary</div>
              <router-link to="/cart">
                <div class="edit-text">
                  <div class="edit-button">
                    <font-awesome-icon icon="pen" />
                  </div>
                  Edit
                </div></router-link
              >
            </div>
            <div class="max-height-summary-item">
              <div
                v-for="(item, index) in cart"
                :key="index"
                class="d-flex flex-column flex-sm-row justify-content-between align-items-center summary-item-detail">
                <div class="img-width">
                  <img
                    :src="item.product.image"
                    width="100%"
                    class="img-size" />
                </div>
                <div class="d-flex d-sm-none align-items-center">
                  <div class="sub-summary-qty">{{ item.qty }}</div>
                  <div class="sub-summary-multiply">
                    <font-awesome-icon icon="times" />
                  </div>
                  <div class="sub-summary-title">
                    {{ item.product.title }} | {{ item.product.type }} |
                    {{ item.product.gender }} - {{ item.product.size }} ml by
                    {{ item.product.brand }}
                  </div>
                  <div class="sub-summary-total">
                    Rs.
                    {{
                      (item.qty * item.product.final_price).toLocaleString(
                        undefined,
                        {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2,
                        },
                      )
                    }}
                  </div>
                </div>
                <div class="summary-qty d-none d-sm-block">{{ item.qty }}</div>
                <div class="summary-multiply d-none d-sm-block">
                  <font-awesome-icon icon="times" />
                </div>
                <div class="summary-title d-none d-sm-block">
                  {{ item.product.title }} | {{ item.product.type }} |
                  {{ item.product.gender }} - {{ item.product.size }} ml by
                  {{ item.product.brand }}
                </div>
                <div class="summary-total d-none d-sm-block">
                  Rs.
                  {{
                    (item.qty * item.product.final_price).toLocaleString(
                      undefined,
                      {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      },
                    )
                  }}
                </div>
              </div>
            </div>
            <div class="summary-total-padding">
              <div class="d-flex justify-content-between summary-total-between">
                <div>Subtotal:</div>

                <div class="shipping-fee-font">
                  Rs.
                  {{
                    cartTotal.toLocaleString(undefined, {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2,
                    })
                  }}
                </div>
              </div>
              <div
                class="d-flex justify-content-between align-items-center summary-total-between">
                <div>Shipping:</div>
                <div
                  v-if="!shipping_method"
                  class="shipping-fee-font checkout-important">
                  Please Select Shipping Method
                </div>
                <div
                  v-if="shipping_fee == 0"
                  class="shipping-fee-font">
                  Free
                </div>

                <div
                  v-if="shipping_fee > 0"
                  class="shipping-fee-font">
                  Rs.
                  {{ shipping_fee }}
                </div>
              </div>
            </div>
            <div
              class="d-flex justify-content-between align-items-end summary-grand-padding">
              <div>Total:</div>
              <div
                v-if="!shipping_method"
                class="summary-grand-total">
                Rs.
                {{
                  cartTotal.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  })
                }}
              </div>
              <div
                v-if="shipping_method"
                class="summary-grand-total">
                Rs.
                {{
                  (cartTotal + shipping_fee).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                  })
                }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { postOrder, postConfirmOrder } from "@/services/OrderService";
import { postShippingAddress } from "@/services/ShippingAddressService";
import { postBillingAddress } from "@/services/BillingAddressService";
import { postOrderedProduct } from "@/services/OrderedProductService";
import { getShipment } from "@/services/ShipmentService";
import {
  getYearly,
  postYearly,
  putYearlyById,
} from "@/services//DashboardService";
import { validationMixin } from "vuelidate";
import { required, email, sameAs, numeric } from "vuelidate/lib/validators";
import BeatLoader from "vue-spinner/src/BeatLoader.vue";
import moment from "moment-timezone";

export default {
  name: "MyCheckout",
  components: { BeatLoader },
  mixins: [validationMixin],
  props: {
    cart: Array,
    total: Number,
    cartTotal: Number,
    clearCart: Function,
    showSignIn: Function,
  },
  data() {
    return {
      shipments: [],

      first_name: "",
      last_name: "",
      email: null,
      subtotal: "",
      shipping_method: null,
      shipping_fee: null,
      payment_account_name: "",
      payment_account_detail: "",

      confirm_email: "",
      payment_method: null,

      phone: "",
      address_1: "",
      address_2: "",
      city: "",
      state: "",
      postcode: "",

      same_address: true,

      billing_first_name: "",
      billing_last_name: "",
      billing_phone: "",
      billing_address_1: "",
      billing_address_2: "",
      billing_city: "",
      billing_state: "",
      billing_postcode: "",

      place_order_loading: false,
      no_item: false,
      no_payment_method: false,
      no_shipping_method: false,
      success: false,
    };
  },
  validations: {
    email: { required, email },
    confirm_email: { required, email, sameAsEmail: sameAs("email") },
    first_name: { required },
    last_name: { required },
    phone: { required, numeric },
    address_1: { required },
    city: { required },
    state: { required },
    postcode: { required, numeric },
    billing_first_name: { required },
    billing_last_name: { required },
    billing_phone: { required, numeric },
    billing_address_1: { required },
    billing_city: { required },
    billing_state: { required },
    billing_postcode: { required, numeric },
  },
  watch: {
    shipping_method() {
      if (this.shipping_method !== null) {
        this.no_shipping_method = false;
      }
    },
    email() {
      this.$v.email.$reset();
    },
    confirm_email() {
      this.$v.confirm_email.$reset();
    },
    first_name() {
      this.$v.first_name.$reset();
    },
    last_name() {
      this.$v.last_name.$reset();
    },
    phone() {
      this.$v.phone.$reset();
    },
    address_1() {
      this.$v.address_1.$reset();
    },
    city() {
      this.$v.city.$reset();
    },
    state() {
      this.$v.state.$reset();
    },
    postcode() {
      this.$v.postcode.$reset();
    },
    billing_first_name() {
      this.$v.billing_first_name.$reset();
    },
    billing_last_name() {
      this.$v.billing_last_name.$reset();
    },
    billing_phone() {
      this.$v.billing_phone.$reset();
    },
    billing_address_1() {
      this.$v.billing_address_1.$reset();
    },
    billing_city() {
      this.$v.billing_city.$reset();
    },
    billing_state() {
      this.$v.billing_state.$reset();
    },
    billing_postcode() {
      this.$v.billing_postcode.$reset();
    },
    payment_method: function (val) {
      if (this.payment_method !== null) {
        this.no_payment_method = false;
      }
      if (val == "bank-a") {
        this.payment_bank = "Commercial Bank of Ceylon";
        this.payment_account_name = "SD Perfumery";
        this.payment_account_detail = "063066 20295636";
      } else if (val == "bank-b") {
        this.payment_bank = "Sampath Bank Plc";
        this.payment_account_name = "SD Perfumery";
        this.payment_account_detail = "076621 84696985";
      } else if (val == "bank-c") {
        this.payment_bank = "Hatton National Bank";
        this.payment_account_name = "SD Perfumery";
        this.payment_account_detail = "081436 21530156";
      }
    },
    "$store.state.isCustomerLoggedIn": {
      immediate: true,
      async handler() {
        if (this.$store.state.isCustomerLoggedIn == true) {
          this.email = this.$store.state.customer.email;
          this.first_name = this.$store.state.customer.first_name;
          this.last_name = this.$store.state.customer.last_name;
          this.phone = this.$store.state.customer.phone;
          this.address_1 = this.$store.state.customer.address_1;
          this.address_2 = this.$store.state.customer.address_2;
          this.city = this.$store.state.customer.city;
          this.state = this.$store.state.customer.state;
          this.postcode = this.$store.state.customer.postcode;
        } else {
          this.email = null;
          this.first_name = null;
          this.last_name = null;
          this.phone = null;
          this.address_1 = null;
          this.address_2 = null;
          this.city = null;
          this.state = null;
          this.postcode = null;
        }
      },
    },
  },
  async mounted() {
    this.shipments = (await getShipment()).data;
    if (
      this.$store.state.isCustomerLoggedIn &&
      this.$store.state.customer.email
    ) {
      this.email = this.$store.state.customer.email;
    }
  },
  methods: {
    chooseShipping(index) {
      this.shipping_method = this.shipments[index].shipping_method;
      this.shipping_fee = this.shipments[index].shipping_fee;
    },
    clearAfterPlace() {
      this.first_name = null;
      this.last_name = null;
      this.email = null;
      this.subtotal = null;
      this.shipping_method = null;
      this.shipping_fee = null;
      this.payment_account_name = null;
      this.payment_account_detail = null;
      this.confirm_email = null;
      this.payment_method = null;
      this.phone = null;
      this.address_1 = null;
      this.address_2 = null;
      this.city = null;
      this.state = null;
      this.postcode = null;
      this.same_address = true;
      this.billing_first_name = null;
      this.billing_last_name = null;
      this.billing_phone = null;
      this.billing_address_1 = null;
      this.billing_address_2 = null;
      this.billing_city = null;
      this.billing_state = null;
      this.billing_postcode = null;
    },
    async placeOrder() {
      this.place_order_loading = true;

      if (
        !this.$store.state.isCustomerLoggedIn ||
        !this.$store.state.customer.email
      ) {
        this.$v.email.$touch();
        this.$v.confirm_email.$touch();
        if (this.$v.email.$anyError || this.$v.confirm_email.$anyError) {
          this.place_order_loading = false;
          return;
        }
      }

      this.$v.first_name.$touch();
      this.$v.last_name.$touch();
      this.$v.phone.$touch();
      this.$v.address_1.$touch();
      this.$v.city.$touch();
      this.$v.state.$touch();
      this.$v.postcode.$touch();

      if (
        this.$v.first_name.$anyError ||
        this.$v.last_name.$anyError ||
        this.$v.phone.$anyError ||
        this.$v.address_1.$anyError ||
        this.$v.city.$anyError ||
        this.$v.state.$anyError ||
        this.$v.postcode.$anyError
      ) {
        this.place_order_loading = false;
        return;
      }

      if (this.same_address == false) {
        this.$v.billing_first_name.$touch();
        this.$v.billing_last_name.$touch();
        this.$v.billing_phone.$touch();
        this.$v.billing_address_1.$touch();
        this.$v.billing_city.$touch();
        this.$v.billing_state.$touch();
        this.$v.billing_postcode.$touch();
        if (
          this.$v.billing_first_name.$anyError ||
          this.$v.billing_last_name.$anyError ||
          this.$v.billing_phone.$anyError ||
          this.$v.billing_address_1.$anyError ||
          this.$v.billing_city.$anyError ||
          this.$v.billing_state.$anyError ||
          this.$v.billing_postcode.$anyError
        ) {
          this.place_order_loading = false;
          return;
        }
      }

      if (this.shipping_fee == null || this.shipping_method == null) {
        this.no_shipping_method = true;
        this.place_order_loading = false;
        return;
      } else {
        this.no_shipping_method = false;
      }

      if (this.payment_method == null) {
        this.no_payment_method = true;
        this.place_order_loading = false;
        return;
      } else {
        this.no_payment_method = false;
      }

      if (this.cart.length < 1) {
        this.no_item = true;
        this.place_order_loading = false;
        return;
      } else {
        this.no_item = false;
      }

      const timestamp = Date.now();
      const time_now = new Date(timestamp);
      const date = moment(time_now).tz("Asia/Colombo").format("DD/MM/YYYY");
      const time = moment(time_now).tz("Asia/Colombo").format("HH:mm:ss A");

      const total_saving = this.total - this.cartTotal;
      const order_total = this.cartTotal + this.shipping_fee;

      let order = {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        subtotal: this.total,
        total_saving: total_saving,
        shipping_method: this.shipping_method,
        shipping_fee: this.shipping_fee,
        order_total: order_total,
        payment_bank: this.payment_bank,
        payment_account_name: this.payment_account_name,
        payment_account_detail: this.payment_account_detail,
        order_date: date,
        order_time: time,
      };
      const order_response = (await postOrder(order)).data;

      const order_id = order_response.id;

      let shipping_address = {
        order_id: order_id,
        first_name: this.first_name,
        last_name: this.last_name,
        phone: this.phone,
        address_1: this.address_1,
        address_2: this.address_2,
        city: this.city,
        state: this.state,
        postcode: this.postcode,
      };
      await postShippingAddress(shipping_address);

      if (this.same_address == true) {
        await postBillingAddress(shipping_address);
      } else if (this.same_address == false) {
        let billing_address = {
          order_id: order_id,
          first_name: this.billing_first_name,
          last_name: this.billing_last_name,
          phone: this.billing_phone,
          address_1: this.billing_address_1,
          address_2: this.billing_address_2,
          city: this.billing_city,
          state: this.billing_state,
          postcode: this.billing_postcode,
        };
        await postBillingAddress(billing_address);
      }

      let ordered_items = [];
      for (let i = 0; i < this.cart.length; i++) {
        let order_item = {
          order_id: order_id,
          product_id: this.cart[i].product.id,
          image: this.cart[i].product.image,
          title: this.cart[i].product.title,
          brand: this.cart[i].product.brand,
          type: this.cart[i].product.type,
          size: this.cart[i].product.size,
          gender: this.cart[i].product.gender,
          price: this.cart[i].product.price,
          discount: this.cart[i].product.discount,
          discount_number: this.cart[i].product.discount_number,
          quantity: this.cart[i].qty,
          final_price: this.cart[i].product.final_price,
          total: this.cart[i].product.final_price * this.cart[i].qty,
        };
        ordered_items.push(order_item);
      }
      let ordered_products = {
        ordered_items: ordered_items,
      };

      await postOrderedProduct(ordered_products);
      await postConfirmOrder({ order_id: order_id });
      //Dashboard Year
      const year = moment(time_now).tz("Asia/Colombo").format("YYYY");
      const month = moment(time_now).tz("Asia/Colombo").format("MM");
      const yearly_detail = {
        year: year,
        month: month,
        total: order_total,
      };
      var yearly = (await getYearly()).data;
      if (yearly.length < 1) {
        await postYearly(yearly_detail);
      } else if (yearly.length > 0) {
        for (let i = 0; i < yearly.length; i++) {
          var whichYear;
          var existing = yearly.filter((item, index) => {
            if (
              item.year == yearly_detail.year &&
              item.month == yearly_detail.month
            ) {
              whichYear = index;
              return true;
            } else {
              return false;
            }
          });
          if (existing.length) {
            const yearly_detail_put = {
              year: yearly[whichYear].year,
              month: yearly[whichYear].month,
              total: yearly[whichYear].total + order_total,
            };
            await putYearlyById(yearly[whichYear].id, yearly_detail_put);
          } else {
            await postYearly(yearly_detail);
            break;
          }
        }
      }
      //Dashboard Year

      this.clearAfterPlace();
      this.clearCart();
      this.place_order_loading = false;
      this.success = true;
      setTimeout(() => {
        this.success = false;
        setTimeout(() => {
          this.$router.push({
            name: "ThankYou",
          });
        }, 1000);
      }, 3000);
    },
  },
};
</script>

<style scoped>
.checkout-body-padding {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.checkout-sign-in-button {
  background-color: #985855;
  color: #fff;
  font-weight: 400;
  font-size: 1.1rem;
  padding: 0.45rem 1.5rem 0.4rem 1.5rem;
  border-radius: 0.25rem;
  cursor: pointer;
  user-select: none;
  margin-top: 1rem;
}

.checkout-sign-in-button:hover {
  background-color: #814643;
}

.checkout-header {
  font-weight: 500;
  font-size: 2.5rem;
  padding-bottom: 1.4rem;
  border-bottom: 1px solid #384648;
}

.checkout-sign-in-section {
  padding: 1.75rem 0;
  border-bottom: 1px solid #b9b9b9;
}

.shipping-section-padding {
  padding-top: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #b9b9b9;
}

.checkout-topic {
  font-size: 1.5rem;
  font-weight: 500;
  padding-bottom: 0.75rem;
}

.shipping-label {
  font-weight: 500;
}

.shipping-long-input {
  width: 100%;
  border-radius: 0.25rem;
  padding: 0.4rem 0 0.3rem 1rem;
  border: 1px solid #b9b9b9;
}

.country-input {
  width: 100%;
  height: 100%;
  border-radius: 0.25rem;
  padding: 0.5rem 0 0.35rem 1rem;
  border: 1px solid #b9b9b9;
  background-color: #dee2e6;
}

input.shipping-long-input:focus-visible {
  border: 1px solid #b9b9b9;
  outline: unset;
}

.checkout-row {
  margin-bottom: 0.25rem;
}

.form-check-input:checked {
  background-color: #985855;
  border-color: #985855;
  width: 1.1rem;
  height: 1.1rem;
}

.form-check-input:focus {
  border-color: rgba(0, 0, 0, 0.25);
  outline: unset;
  box-shadow: unset;
}

.checkout-same-check-box {
  margin-bottom: 1rem;
}

.adjust-center-box {
  padding-top: 0.15rem;
}

.shipping-method-color {
  background-color: #f6edee;
}

.shipping-method-0 {
  border: 1px solid #384648;
  margin-bottom: unset;
  padding-left: 2.5rem;
  border-radius: 0.25rem;
}

.shipping-method-1 {
  border: 1px solid #384648;
  margin-bottom: unset;
  padding-left: 2.5rem;
  border-radius: 0.25rem 0.25rem 0 0;
}

.shipping-method-2 {
  border: 1px solid #384648;
  margin-bottom: unset;
  padding-left: 2.5rem;
  border-top: unset;
}

.shipping-method-3 {
  border: 1px solid #384648;
  margin-bottom: unset;
  border-top: unset;
  padding-left: 2.5rem;
  border-radius: 0 0 0.25rem 0.25rem;
}

.form-check-input:checked[type="radio"] {
  background-color: #fff;
  background-image: url(./../../../../assets/radio.svg);
}

.form-check-input[data-v-793196f8]:focus {
  border-color: #985855;
  outline: unset;
  box-shadow: unset;
}

.billing-address-text {
  font-weight: 500;
}

.billing-name {
  margin-bottom: 0.25rem;
}

.payment-1 {
  border: 1px solid #384648;
  margin-bottom: unset;
  padding-left: 2.5rem;
  border-radius: 0.25rem 0.25rem 0 0;
}

.payment-color {
  background-color: #f6edee;
}

.payment-2 {
  border: 1px solid #384648;
  margin-bottom: unset;
  border-top: unset;
  padding-left: 2.5rem;
}

.payment-3 {
  border: 1px solid #384648;
  margin-bottom: unset;
  border-top: unset;
  padding-left: 2.5rem;
  border-radius: 0 0 0.25rem 0.25rem;
}

.payment-1:hover,
.payment-2:hover,
.payment-3:hover {
  background-color: #f7e5e7;
}

.checkout-description {
  font-size: 0.85rem;
  font-weight: 500;
}

.checkout-important {
  color: #f44336;
}

.checkout-important-oreder-number {
  color: #f44336;
  text-decoration: underline;
}

.checkout-bank-account {
  color: #985855;
  font-weight: 500;
}

.place-order-button {
  background: #985855;
  border-radius: 0.25rem;
  text-align: center;
  color: #fff;
  font-size: 1.2rem;
  font-weight: 500;
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
  user-select: none;
  cursor: pointer;
  margin-top: 1.5rem;
}

.place-order-button:hover {
  background: #814643;
}

.summary-header {
  font-weight: 500;
  font-size: 1.2rem;
}

.edit-button {
  width: 1.75rem;
  height: 1.75rem;
  background-color: #639551;
  color: #ffffff;
  font-size: 0.9rem;
  padding-top: 0.25rem;
  border-radius: 50%;
  text-align: center;
  display: inline-block;
}

.edit-text:hover .edit-button {
  background-color: #477237;
}

.edit-text {
  color: #639551;
  padding: 0.25rem;
  border-radius: 50rem;
}

.edit-text:hover {
  color: #477237;
  background-color: #e7f7e1;
}

.summary-head-section {
  border-bottom: 1px solid #384648;
  padding-bottom: 0.75rem;
}

.img-size {
  object-fit: cover;
  height: 3rem;
}

.summary-qty {
  width: 7.5%;
  font-size: 0.85rem;
  padding-left: 0.4rem;
}

.summary-multiply {
  width: 5%;
  font-size: 0.6rem;
  padding-left: 0.4rem;
}

.summary-total {
  font-size: 0.85rem;
  width: 30%;
  padding-left: 0.4rem;
  text-align: right;
}

.summary-title {
  width: 45%;
  font-size: 0.8rem;
  padding-left: 0.4rem;
  padding-right: 0.4rem;
}

.summary-item-detail {
  padding-top: 0.35rem;
  padding-bottom: 0.35rem;
  border-bottom: 1px solid #b9b9b9;
}

.summary-total-padding {
  padding: 1rem 0 1rem 0;
  border-top: 1px solid #384648;
  border-bottom: 1px solid #b9b9b9;
  margin-top: -1px;
  font-size: 0.9rem;
}

.summary-total-between {
  padding: 0.2rem 0 0.2rem 0;
}

.summary-grand-padding {
  padding-top: 0.5rem;
  font-weight: 500;
  font-size: 1.25rem;
}

.summary-grand-total {
  font-size: 1.5rem;
  font-weight: 800;
  color: #985855;
}

.max-height-summary-item {
  max-height: 12.5rem;
  overflow: auto;
  margin: 1rem 0rem 1rem 0rem;
}

.thin-label {
  font-weight: 400;
}

.shipping_method_hover:hover {
  background-color: #f7e5e7;
}

.form-check-label {
  width: 100%;
  height: 100%;
  padding: 0.4rem 0.75rem;
}

.form-check-input {
  margin: unset;
  padding: unset !important;
}

.border-fail {
  border: 1px solid #dc3545 !important;
  border-radius: 0.25rem !important;
}

.border-success {
  border: 1px solid #198754 !important;
}

.error {
  position: relative;
  color: #dc3545;
  font-size: 0.7rem;
  border-radius: 0 0 0.25rem 0.25rem;
  width: 100%;
}

.email:disabled {
  background-color: #dee2e6;
}

.sent_box_2 {
  background-color: #e7f7e1;
  color: #639551;
  border: 2px solid #639551;
  font-size: 1rem;
  text-align: center;
  font-weight: 500;
  width: 100%;
  position: absolute;
  padding: 0.4rem 1.25rem 0.4rem 1.25rem;
  cursor: pointer;
  user-select: none;
  border-radius: 0.25rem;
}

.sent_box_3 {
  background-color: transparent;
  width: 100%;
  position: absolute;
  cursor: pointer;
  user-select: none;
  border-radius: 0.25rem;
  height: 100%;
}

.visible {
  visibility: visible;
  display: block;
  opacity: 1;
  transition: opacity 0s linear;
}

.hidden {
  visibility: hidden;
  opacity: 0;
  transition:
    visibility 0s 1s,
    opacity 1s linear;
}

.container {
  max-width: 320px;
}

.summary-card {
  box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.25);
  border-radius: 0.5rem;
  padding: 1.25rem 1.25rem 1rem 1.25rem;
  max-height: 28rem;
  top: 75px;
}

.sub-summary-qty {
  width: 7.5%;
  font-size: 0.85rem;
  text-align: start;
}
.sub-summary-multiply {
  width: 7.5%;
  font-size: 0.6rem;
  text-align: start;
}
.sub-summary-title {
  width: 49%;
  font-size: 0.8rem;
  text-align: start;
  padding-right: 0.25rem;
}
.sub-summary-total {
  font-size: 0.85rem;
  width: 36%;
  text-align: right;
}

.shipping-fee-font {
  font-size: 0.85rem;
  font-weight: 400;
  text-align: end;
}

.img-width {
  width: 3.5rem;
}

.checkout-top {
  height: 150px;
  background-color: #7e989c;
  color: #fff;
  font-size: 3rem;
}

.sent_box {
  margin-top: 0.5rem;
  background-color: #fcdbd8;
  color: #dc3545;
  border: 2px solid #dc3545;
  font-size: 0.85rem;
  text-align: center;
  font-weight: 500;
  width: 100%;
  position: absolute;
  border-radius: 0.25rem;
}

@media (min-width: 375px) {
  .container {
    max-width: 350px;
  }

  .shipping-fee-font {
    font-size: 0.95rem;
  }
}

@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }

  .img-width {
    width: 12.5%;
  }

  .sent_box {
    font-size: 1rem;
  }

  .checkout-top {
    font-size: 4.5rem;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 720px;
  }

  .checkout-padding {
    padding-right: 5rem;
    padding-left: 5rem;
  }
}

@media (min-width: 992px) {
  .container {
    max-width: 960px;
  }

  .checkout-padding {
    padding-right: 7.5rem;
    padding-left: 7.5rem;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 1140px;
  }

  .summary-card {
    position: sticky;
  }
  .checkout-right-padding {
    border-right: 1px solid #384648;
    padding-right: calc(var(--bs-gutter-x) * 1);
  }

  .checkout-left-padding {
    padding-left: calc(var(--bs-gutter-x) * 1);
  }

  .checkout-padding {
    padding-right: 0rem;
    padding-left: 0rem;
  }
}

@media (min-width: 1400px) {
  .container {
    max-width: 1320px;
  }

  .checkout-padding {
    padding-right: 5rem;
    padding-left: 5rem;
  }
}
</style>
