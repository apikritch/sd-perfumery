import axios from "axios";

export default () => {
  return axios.create({
    baseURL: "http://www.apikritch.com:8002/",
  });
};
