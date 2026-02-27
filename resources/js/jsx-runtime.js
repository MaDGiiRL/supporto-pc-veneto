const isNode = (value) => value instanceof Node;

export function Fragment({ children = [] }) {
    return children;
}

export function h(tag, props, ...children) {
    if (typeof tag === 'function') {
        return tag({ ...(props ?? {}), children: flatten(children) });
    }

    const element = document.createElement(tag);
    const attributes = props ?? {};

    Object.entries(attributes).forEach(([key, value]) => {
        if (value == null || key === 'children') return;

        if (key === 'className') {
            element.setAttribute('class', value);
            return;
        }

        if (key.startsWith('on') && typeof value === 'function') {
            element.addEventListener(key.slice(2).toLowerCase(), value);
            return;
        }

        if (key === 'style' && typeof value === 'object') {
            Object.assign(element.style, value);
            return;
        }

        element.setAttribute(key, value);
    });

    appendChildren(element, flatten(children));
    return element;
}

export function render(node, container) {
    if (!container) return;
    container.innerHTML = '';
    appendChildren(container, [node]);
}

function appendChildren(parent, children) {
    children.forEach((child) => {
        if (Array.isArray(child)) {
            appendChildren(parent, child);
            return;
        }

        if (child == null || child === false || child === true) return;

        if (isNode(child)) {
            parent.appendChild(child);
            return;
        }

        parent.appendChild(document.createTextNode(String(child)));
    });
}

function flatten(items) {
    return items.flatMap((item) => (Array.isArray(item) ? flatten(item) : item));
}
