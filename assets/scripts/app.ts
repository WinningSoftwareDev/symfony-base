import '../styles/app.css';
import '@awesome.me/fa-pro/all.js';
import ComponentLoader from './Core/ComponentLoader';
import FlashHandler from './Core/FlashHandler';

new FlashHandler();
ComponentLoader.watch();