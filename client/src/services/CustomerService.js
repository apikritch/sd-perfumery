import Api from "@/services/Api";

const getCustomers = (search) => {
  return Api().get("api/customer", { params: { search: search } });
};

const getCustomerById = (customerId) => {
  return Api().get(`api/customer/${customerId}`);
};

const contactUs = (data) => {
  return Api().post("api/customer/contactus", data);
};

const putCustomerById = (customerId, data) => {
  return Api().put(`api/customer/${customerId}`, data);
};

const signUp = (credentials) => {
  return Api().post("api/customer/signup", credentials);
};

const signIn = (credentials) => {
  return Api().post("api/customer/signin", credentials);
};

const changePassword = (customerId, credentials) => {
  return Api().post(`api/customer/changepassword/${customerId}`, credentials);
};

const forgetPassword = (customerEmail) => {
  return Api().post("api/customer/forget/password", customerEmail);
};

const resetPassword = (token, credentials) => {
  return Api().post(`api/customer/reset/password/${token}`, credentials);
};

export {
  getCustomers,
  getCustomerById,
  contactUs,
  putCustomerById,
  signUp,
  signIn,
  changePassword,
  forgetPassword,
  resetPassword,
};
