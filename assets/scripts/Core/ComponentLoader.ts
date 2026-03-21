import { components } from '../_components';
import { App, createApp } from 'vue';

export default class ComponentLoader
{
    public static watch(): void
    {
        Object.entries(components).forEach(([name, component]): void => {
            document.querySelectorAll(name).forEach((el: Element): void => {
                createApp(component, { ...(el as HTMLElement).dataset }).mount(el);
            });
        });
    }
}