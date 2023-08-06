module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    "eslint:recommended",
    "plugin:vue/recommended",
    "plugin:prettier/recommended",
  ],
  parser: "vue-eslint-parser",
  parserOptions: {
    parser: "@babel/eslint-parser",
    sourceType: "module",
  },
  plugins: ["prettier", "vue"],
  rules: {
    "vue/multi-word-component-names": "off",
    "vue/attribute-hyphenation": "off",
    "vue/v-on-event-hyphenation": "off",
    "vue/require-prop-types": "off",
    "vue/no-v-html": "off",
    "vue/require-default-prop": "off",
    "vue/prop-name-casing": "off",
    "prettier/prettier": [
      "error",
      {
        singleAttributePerLine: true,
        vueIndentScriptAndStyle: false,
        bracketSameLine: true,
      },
    ],
  },
  globals: {
    bootstrap: true,
  },
};
