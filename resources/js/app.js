import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Layout from './Pages/Layout/Layout.vue';
import MainContainer from './Pages/Shared/MainContainer.vue';
import 'boxicons'
createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = name.startsWith('Auth/') ? undefined : Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('MainContainer', MainContainer)
      .use(plugin)
      .use(ZiggyVue)
      .mount(el)
  },
})