module.exports = {
    testEnvironment: "jsdom",
    testRegex: "resources/js/tests/.*.spec.*",
    moduleFileExtensions: ["js", "json", "vue", "ts"],
    transform: {
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest",
        ".*\\.(vue)$": "@vue/vue3-jest",
        // "^.+\\.tsx?$": "ts-jest",
    },
};
