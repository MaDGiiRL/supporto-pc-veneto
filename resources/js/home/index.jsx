import { render } from '../jsx-runtime';
import { HomeApp } from './App';

export function mountHomeApp() {
    const root = document.getElementById('home-app');
    if (!root) return;

    const content = {
        cartografieUrl: root.dataset.cartografieUrl,
        applicativiUrl: root.dataset.applicativiUrl,
        regioneImg: root.dataset.regioneImg,
        headerImg: root.dataset.headerImg,
        cartografieImg: root.dataset.cartografieImg,
        applicativiImg: root.dataset.applicativiImg,
    };

    render(<HomeApp content={content} />, root);
}
