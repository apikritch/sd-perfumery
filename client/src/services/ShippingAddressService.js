import Api from "@/services/Api";

//const getOrder = () => { };
//
const getShippingAddressById = (orderId) => {
  return Api().get(`api/shipping_address/${orderId}`);
};

const postShippingAddress = (data) => {
  return Api().post("api/shipping_address", data);
};

export { postShippingAddress, getShippingAddressById };
