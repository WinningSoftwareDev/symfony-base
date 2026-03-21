import '../styles/app.scss';
import { createApp } from 'vue';
import Index from './Components/Page/Index.vue';

const components = {
    Index,
};

Object.entries(components).forEach(([name, component]): void => {
    const elements: NodeListOf<HTMLElement> = document.querySelectorAll(name);

    elements.forEach((el: HTMLElement): void => {
        const app = createApp(component);
        const props = { ...el.dataset };

        app.mount(el);
    });
});