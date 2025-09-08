import "../css/app.css";
import "./bootstrap";
import "v-calendar/style.css";
import { createPinia } from "pinia"; // ✅ import Pinia
import PrimeVue from "primevue/config";
import Aura from "@primeuix/themes/aura";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/index.esm.js";
import Layout from "./Layouts/Layout.vue";
import { setupCalendar, Calendar, DatePicker } from "v-calendar";

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        const pinia = createPinia(); // ✅ create Pinia instance

        app.use(plugin)
            .use(PrimeVue, { unstyled: true })
            .use(pinia) // ✅ register Pinia
            .use(setupCalendar, {})
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .component("VCalendar", Calendar)
            .component("VDatePicker", DatePicker)
            .mount(el);
    },
    progress: {
        color: "#fff",
        includeCSS: true,
        showSpinner: true,
    },
});
