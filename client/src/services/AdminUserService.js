import Api from "@/services/Api";

const getUsers = (search) => {
  return Api().get("api/user", { params: { search: search } });
};

const getUserById = (userId) => {
  return Api().get(`api/user/${userId}`);
};

const getUserByCookies = (credentials) => {
  return Api().post("api/user/cookies", credentials);
};

const postUser = (data) => {
  return Api().post("api/user", data);
};

const putUserById = (userId, data) => {
  return Api().put(`api/user/${userId}`, data);
};

const deleteUserById = (userId) => {
  return Api().delete(`api/user/${userId}`);
};

const signIn = (credentials) => {
  return Api().post("api/user/signin", credentials);
};

const changePassword = (userId, credentials) => {
  return Api().post(`api/user/changepassword/${userId}`, credentials);
};

const forgetPassword = (userEmail) => {
  return Api().post("api/user/forget/password", userEmail);
};

const resetPassword = (token, credentials) => {
  return Api().post(`api/user/reset/password/${token}`, credentials);
};

export {
  getUsers,
  getUserById,
  postUser,
  putUserById,
  deleteUserById,
  signIn,
  changePassword,
  forgetPassword,
  resetPassword,
  getUserByCookies,
};
