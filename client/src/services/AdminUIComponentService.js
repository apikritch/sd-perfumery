import Api from "@/services/Api";

//const getCarousels = () => {
//  const carousels = [
//    {
//      id: 1,
//      image:
//        "https://www.zataru.com/wp-content/uploads/2021/04/Perfume-Brand-Banner-Desktop.jpg",
//      sequence: "1",
//    },
//    {
//      id: 2,
//      image:
//        "https://cdn.shopify.com/s/files/1/0128/1225/5289/files/Luxurt_Perfumes_Banner-1_1920x.jpg",
//      sequence: "2",
//    },
//    {
//      id: 3,
//      image: "https://www.nichestory.eu/wp-content/uploads/2021/06/1.jpg",
//      sequence: "3",
//    },
//  ];
//
//  return carousels;
//};

const getCarousels = () => {
  return Api().get("api/component");
};

const getCarouselById = (carouselId) => {
  return Api().get(`api/component/${carouselId}`);
};

const postCarousel = (data) => {
  return Api().post("api/component", data);
};

const putCarouselById = (carouselId, data) => {
  return Api().put(`api/component/${carouselId}`, data);
};

const deleteCarouselById = (carouselId) => {
  return Api().delete(`api/component/${carouselId}`);
};

export {
  getCarousels,
  getCarouselById,
  postCarousel,
  putCarouselById,
  deleteCarouselById,
};
