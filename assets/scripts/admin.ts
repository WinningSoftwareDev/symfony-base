import '../styles/app.scss';
import { createApp } from 'vue';
import { createRouter, createWebHistory, Router } from 'vue-router';
import AdminPanel from './Administration/AdminPanel.vue';
import Dashboard from './Administration/Page/Dashboard.vue';
import SettingsIndex from './Administration/Page/Settings/Index.vue';
import UserIndex from './Administration/Page/User/Index.vue';

const routes = [
    {path: '/admin', component: Dashboard, meta: {title: 'Dashboard'}},
    {path: '/admin/users', component: UserIndex, meta: {title: 'Users'}},
    {path: '/admin/settings', component: SettingsIndex, meta: {title: 'Settings'}},
];

const router: Router = createRouter({history: createWebHistory(), routes});
const app = createApp(AdminPanel);

app.use(router);
app.mount('#admin-root');