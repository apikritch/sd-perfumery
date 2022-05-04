import Api from "@/services/Api";

const getOrder = (search) => {
  return Api().get("api/order", { params: { search: search } });
};

const getOrderById = (orderId) => {
  return Api().get(`api/order/${orderId}`);
};

const getOrderByEmail = (customerEmail) => {
  return Api().post("api/order/customer", customerEmail);
};

const getOrderDetailByEmail = (orderId, customerEmail) => {
  return Api().post(`api/order/customer/${orderId}`, customerEmail);
};

const postOrder = (data) => {
  return Api().post("api/order", data);
};

const putOrderById = (orderId, data) => {
  return Api().put(`api/order/${orderId}`, data);
};

const updateOrderNotificationById = (orderId, data) => {
  return Api().put(`api/order/notification/${orderId}`, data);
};

const postConfirmOrder = (data) => {
  return Api().post("api/order/confirmOrder", data);
};

export {
  getOrder,
  getOrderById,
  getOrderByEmail,
  getOrderDetailByEmail,
  postOrder,
  putOrderById,
  updateOrderNotificationById,
  postConfirmOrder,
};
