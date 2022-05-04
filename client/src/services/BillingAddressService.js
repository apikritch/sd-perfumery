import Api from "@/services/Api";

//const getOrder = () => { };
//
//const getOrderbyId = (productId) => { };

const getBillingAddressById = (orderId) => {
  return Api().get(`api/billing_address/${orderId}`);
};

const postBillingAddress = (data) => {
  return Api().post("api/billing_address", data);
};

export { postBillingAddress, getBillingAddressById };
