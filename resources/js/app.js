import Vue from "vue";
import router from "./router/index";
import vuetify from "./plugins/vuetify";
import App from "./views/App";

const app = new Vue({
    vuetify,
    el: "#app",
    components: { App },
    router
});
