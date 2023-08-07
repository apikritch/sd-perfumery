import axios from "axios";

export default () => {
  return axios.create({
    baseURL: "https://portfolio.apikritch.com/server/2",
  });
};
