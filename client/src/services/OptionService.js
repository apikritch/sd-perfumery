//For Pagination
const get20PerPageOptions = () => {
  const per_page_options = [
    { value: 20, text: "20" },
    { value: 40, text: "40" },
    { value: 60, text: "60" },
    { value: 100, text: "100" },
  ];
  return per_page_options;
};
//For Pagination

const getFilterGenderOptions = () => {
  const genders = [
    {
      title: "Women",
      text: "women",
    },
    {
      title: "Men",
      text: "men",
    },
    {
      title: "Unisex",
      text: "unisex",
    },
  ];

  return genders;
};

const getFilterTypeOptions = () => {
  const types = [
    {
      title: "Parfum (Perfume)",
      text: "p",
    },
    {
      title: "Eau De Parfum (EDP)",
      text: "edp",
    },
    {
      title: "Eau De Toilette (EDT)",
      text: "edt",
    },
    {
      title: "Eau De Cologne (EDC)",
      text: "edc",
    },
    {
      title: "Eau Fraiche",
      text: "ef",
    },
    {
      title: "Perfume Oils",
      text: "po",
    },
  ];

  return types;
};

export { get20PerPageOptions, getFilterGenderOptions, getFilterTypeOptions };
