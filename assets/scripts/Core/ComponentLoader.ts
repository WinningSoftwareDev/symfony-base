import { components } from '../_components';
import { App, createApp } from 'vue';

export default class ComponentLoader
{
    public static watch(): void
    {
        Object.entries(components).forEach(([name, component]): void => {
            const elements: NodeListOf<HTMLElement> = document.querySelectorAll(name);

            elements.forEach((el: HTMLElement): void => {
                createApp(component, { ...el.dataset }).mount(el);
            });
        });
    }
}