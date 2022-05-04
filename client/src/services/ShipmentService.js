import Api from "@/services/Api";

const getShipment = (search) => {
  return Api().get("api/shipment", { params: { search: search } });
};

const getShipmentbyId = (shipmentId) => {
  return Api().get(`api/shipment/${shipmentId}`);
};

const postShipment = (data) => {
  return Api().post("api/shipment", data);
};

const putShipmentById = (shipmentId, data) => {
  return Api().put(`api/shipment/${shipmentId}`, data);
};

const deleteShipmentById = (shipmentId) => {
  return Api().delete(`api/shipment/${shipmentId}`);
};

export {
  getShipment,
  getShipmentbyId,
  postShipment,
  putShipmentById,
  deleteShipmentById,
};
