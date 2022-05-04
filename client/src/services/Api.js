import axios from "axios";

export default () => {
  return axios.create({
    baseURL: "http://3.24.204.164:8083/",
  });
};
