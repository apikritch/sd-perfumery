import Api from "@/services/Api";

const getOrderedProducts = () => {
  return Api().get("api/ordered_product");
};

const getOrderedProductById = (orderId) => {
  return Api().get(`api/ordered_product/${orderId}`);
};

const postOrderedProduct = (data) => {
  return Api().post("api/ordered_product", data);
};

export { getOrderedProducts, getOrderedProductById, postOrderedProduct };
