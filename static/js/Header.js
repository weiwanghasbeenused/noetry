(function(){
    const elementFactories = {
        menu: () => createDiv(['menu-toggle', 'menu-icon', 'icon', 'button']),
        search: () => createDiv(['search-icon', 'icon', 'button'], { 'data-href': '/search' }),
        generate: () => createDiv(['wand-icon', 'icon', 'button'], { 'data-href': '/review' }),
        add: () => createDiv(['plus-icon', 'icon', 'button'], { 'data-href': '/add-diary' }),
        'next-step-text': () => createDiv(['next-step-button', 'text-button', 'button', 'small'], { 'data-href': '', 'data-status': '0' }, '下一步'),
        'edit-text': () => createDiv(['edit-button', 'text-button', 'button', 'small'], { 'data-href': '', 'data-status': '1' }, '編輯'),
        'cancel-text': () => createDiv(['cancel-button', 'text-button', 'button', 'small'], { 'data-href': '', 'data-status': '1' }, '取消'),
        esc: () => createDiv(['esc-icon', 'icon', 'button'], { 'data-href': '' }),
        locator: () => createDiv(['locator-icon', 'icon', 'button']),
        more: () => createDiv(['more-icon', 'icon', 'button'])
    };

    function createDiv(classList, attributes = {}, text = '') {
        const el = document.createElement('div');
        el.className = classList.join(' ');
        Object.keys(attributes).forEach((key) => {
            el.setAttribute(key, attributes[key]);
        });
        if (text) {
            el.textContent = text;
        }
        return el;
    }

    function renderHeader(config = {}, colorTheme='light', id = '', cls = []) {
        const header = document.createElement('header');
        const classes = Array.isArray(cls)
            ? cls.slice()
            : (typeof cls === 'string' && cls ? [cls] : []);
        classes.push('header');
        header.className = classes.join(' ');
        if (id) {
            header.id = id;
        }
        header.setAttribute('data-color-theme', colorTheme);
        const layout = {
            left: document.createElement('div'),
            right: document.createElement('div'),
            title: document.createElement('div')
        };
        layout.left.className = 'header-left header-section';
        layout.right.className = 'header-right header-section';
        layout.title.className = 'header-center header-section';

        Object.keys(config || {}).forEach((key) => {
            if (key === 'title') {
                const titleContent = config[key];
                const title = document.createElement('h1');
                title.className = 'title page-title medium bold';
                title.textContent = titleContent != null ? `${titleContent}` : '';
                layout.title.appendChild(title);
                return;
            }

            const elements = Array.isArray(config[key]) ? config[key] : [config[key]];
            const target = layout[key];
            if (!target) {
                return;
            }
            elements.forEach((item) => {
                const factory = elementFactories[item];
                if (factory) {
                    target.appendChild(factory());
                }
            });
        });

        header.appendChild(layout.left);
        header.appendChild(layout.title);
        header.appendChild(layout.right);

        return header;
    }

    window.renderHeader = renderHeader;
})();
