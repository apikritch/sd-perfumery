import Api from "@/services/Api";

const getProducts = (search) => {
  return Api().get("api/product", { params: { search: search } });
};

const getProductById = (productId) => {
  return Api().get(`api/product/${productId}`);
};

const postProduct = (data) => {
  return Api().post("api/product", data);
};

const putProductById = (productId, data) => {
  return Api().put(`api/product/${productId}`, data);
};

const deleteProductById = (productId) => {
  return Api().delete(`api/product/${productId}`);
};

export {
  getProducts,
  getProductById,
  postProduct,
  putProductById,
  deleteProductById,
};
