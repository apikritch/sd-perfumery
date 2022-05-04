import Api from "@/services/Api";

//For Pagination
const getPerPageOptions = () => {
  const per_page_options = [
    { value: 10, text: "10" },
    { value: 25, text: "25" },
    { value: 50, text: "50" },
    { value: 100, text: "100" },
  ];
  return per_page_options;
};
//For Pagination

//For Add
const getTypeOptions = () => {
  const types = [
    {
      value: null,
      text: "Select",
    },
    {
      value: "Parfum (Perfume)",
      text: "Parfum (Perfume)",
    },
    {
      value: "Eau De Parfum (EDP)",
      text: "Eau De Parfum (EDP)",
    },
    {
      value: "Eau De Toilette (EDT)",
      text: "Eau De Toilette (EDT)",
    },
    {
      value: "Eau De Cologne (EDC)",
      text: "Eau De Cologne (EDC)",
    },
    {
      value: "Eau Fraiche",
      text: "Eau Fraiche",
    },
    {
      value: "Perfume Oils",
      text: "Perfume Oils",
    },
  ];

  return types;
};

const getGenderOptions = () => {
  const genders = [
    {
      value: null,
      text: "Select",
    },
    {
      value: "Women",
      text: "Women",
    },
    {
      value: "Men",
      text: "Men",
    },
    {
      value: "Unisex",
      text: "Unisex",
    },
  ];

  return genders;
};

const getDiscountOptions = () => {
  const discounts = [
    {
      value: null,
      text: "---",
    },
    {
      value: "%",
      text: "%",
    },
    {
      value: "Rs.",
      text: "Rs.",
    },
  ];

  return discounts;
};
//For Add

//For Update
const getUpdateShipmentStatusOptions = () => {
  const shipment_status = [
    {
      value: "Shipped",
      text: "Shipped",
    },
    {
      value: "Awaiting",
      text: "Awaiting",
    },
    {
      value: "Cancel",
      text: "Cancel",
    },
  ];

  return shipment_status;
};

const getUpdateOrderStatusOptions = () => {
  const order_status = [
    {
      value: "Completed",
      text: "Completed",
    },
    {
      value: "Waiting for Payment",
      text: "Waiting for Payment",
    },
    {
      value: "Canceled",
      text: "Canceled",
    },
  ];

  return order_status;
};
//For Update

//For Search
const getSearchTypeOptions = () => {
  const types = [
    {
      value: null,
      text: "All",
    },
    {
      value: "Parfum (Perfume)",
      text: "Parfum (Perfume)",
    },
    {
      value: "Eau De Parfum (EDP)",
      text: "Eau De Parfum (EDP)",
    },
    {
      value: "Eau De Toilette (EDT)",
      text: "Eau De Toilette (EDT)",
    },
    {
      value: "Eau De Cologne (EDC)",
      text: "Eau De Cologne (EDC)",
    },
    {
      value: "Eau Fraiche",
      text: "Eau Fraiche",
    },
    {
      value: "Perfume Oils",
      text: "Perfume Oils",
    },
  ];

  return types;
};

const getSearchGenderOptions = () => {
  const genders = [
    {
      value: null,
      text: "All",
    },
    {
      value: "Women",
      text: "Women",
    },
    {
      value: "Men",
      text: "Men",
    },
    {
      value: "Unisex",
      text: "Unisex",
    },
  ];

  return genders;
};

const getSearchDiscountOptions = () => {
  const discounts = [
    {
      value: null,
      text: "All",
    },
    {
      value: "No Discount",
      text: "No Discount",
    },
    {
      value: "%",
      text: "%",
    },
    {
      value: "Rs.",
      text: "Rs.",
    },
  ];

  return discounts;
};

const getOrderStatusOptions = () => {
  const order_status = [
    {
      value: null,
      text: "All",
    },
    {
      value: "Completed",
      text: "Completed",
    },
    {
      value: "Waiting for Payment",
      text: "Waiting for Payment",
    },
    {
      value: "Canceled",
      text: "Canceled",
    },
  ];

  return order_status;
};

const getShipmentStatusOptions = () => {
  const shipment_status = [
    {
      value: null,
      text: "All",
    },
    {
      value: "Shipped",
      text: "Shipped",
    },
    {
      value: "Awaiting",
      text: "Awaiting",
    },
    {
      value: "Cancel",
      text: "Cancel",
    },
  ];

  return shipment_status;
};

const getUserTypeOptions = () => {
  const user_type_options = [
    {
      value: null,
      text: "All",
    },
    {
      value: "Admin",
      text: "Admin",
    },
    {
      value: "General",
      text: "General",
    },
  ];
  return user_type_options;
};

const getUserStatusOptions = () => {
  const user_status_options = [
    {
      value: null,
      text: "All",
    },
    {
      value: "Active",
      text: "Active",
    },
    {
      value: "Suspended",
      text: "Suspended",
    },
  ];
  return user_status_options;
};

const getNewUserTypeOptions = () => {
  const user_type_options = [
    {
      value: null,
      text: "Select",
    },
    {
      value: "Admin",
      text: "Admin",
    },
    {
      value: "General User",
      text: "General User",
    },
  ];
  return user_type_options;
};
//For Search

//For Brand
const getBrandOptions = (search) => {
  return Api().get("api/brand", { params: { search: search } });
};

const getBrandbyId = (brandId) => {
  return Api().get(`api/brand/${brandId}`);
};

const postBrand = (data) => {
  return Api().post("api/brand", data);
};

const putBrandById = (brandId, data) => {
  return Api().put(`api/brand/${brandId}`, data);
};

const deleteBrandById = (brandId) => {
  return Api().delete(`api/brand/${brandId}`);
};
//For Brand

export {
  getPerPageOptions,
  getTypeOptions,
  getGenderOptions,
  getBrandOptions,
  getDiscountOptions,
  getOrderStatusOptions,
  getShipmentStatusOptions,
  getUserTypeOptions,
  getUserStatusOptions,
  getNewUserTypeOptions,
  getSearchTypeOptions,
  getSearchGenderOptions,
  getSearchDiscountOptions,
  getUpdateOrderStatusOptions,
  getUpdateShipmentStatusOptions,
  postBrand,
  deleteBrandById,
  putBrandById,
  getBrandbyId,
};
