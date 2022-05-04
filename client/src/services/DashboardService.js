import Api from "@/services/Api";

const getYearly = () => {
  return Api().get("api/dashboard/yearly");
};

//const getOrderedProductById = (orderId) => {
//  return Api().get(`api/ordered_product/${orderId}`);
//};

const postYearly = (data) => {
  return Api().post("api/dashboard/yearly", data);
};

const putYearlyById = (yearlyId, data) => {
  return Api().put(`api/dashboard/yearly/${yearlyId}`, data);
};

export { getYearly, postYearly, putYearlyById };
