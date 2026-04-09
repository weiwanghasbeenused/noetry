class Popup {
    constructor({ id, text = '', buttons = [], mount = document.body, hidden = true } = {}) {
        this.id = id || `popup-${Date.now()}`;
        this.text = text;
        this.buttons = Array.isArray(buttons) ? buttons : [];
        this.callbacks = {};
        this.mountNode = typeof mount === 'string' ? document.querySelector(mount) : mount;
        if (!this.mountNode) {
            throw new Error('Warning mount node not found.');
        }
        this.hidden = hidden;
        this.wrapper = null;
        this.container = null;
        this.buttonContainer = null;
        this.handleWrapperClick = this.handleWrapperClick.bind(this);
        this.render();
    }

    render() {
        this.wrapper = document.createElement('div');
        this.wrapper.className = 'popup-wrapper full-vw full-vh fixed';
        this.wrapper.dataset.hidden = this.hidden ? '1' : '0';
        this.wrapper.setAttribute('data-popup-wrapper', this.id);

        this.container = document.createElement('div');
        this.container.className = 'popup-container';
        this.container.id = this.id;

        const message = document.createElement('div');
        message.className = 'popup-message body small';
        message.innerHTML = this.text;
        this.container.appendChild(message);

        if (this.buttons.length) {
            this.buttonContainer = document.createElement('div');
            this.buttonContainer.className = 'popup-buttons';
            this.buttons.forEach((spec) => this.addButton(spec));
            this.container.appendChild(this.buttonContainer);
        }

        this.wrapper.appendChild(this.container);
        this.mountNode.appendChild(this.wrapper);

        this.wrapper.addEventListener('click', this.handleWrapperClick);
        this.container.addEventListener('click', (event) => event.stopPropagation());
    }

    addButton({ display, slug, callback }) {
        if (!slug) {
            throw new Error('Warning button spec requires a slug.');
        }
        const label = display || slug;
        const button = document.createElement('div');
        button.className = `popup-button bar-button fit-parent button popup-button-${slug}`;
        button.dataset.action = slug;
        button.textContent = label;

        const extraClasses = this.getExtraButtonClasses(slug);
        if (extraClasses.length) {
            button.classList.add(...extraClasses);
        }

        const handler = typeof callback === 'function' ? callback : this.getDefaultCallback(slug);
        this.callbacks[slug] = handler;

        button.addEventListener('click', (event) => {
            event.stopPropagation();
            if (this.callbacks[slug]) {
                this.callbacks[slug](this, event);
            }
        });

        if (!this.buttonContainer) {
            this.buttonContainer = document.createElement('div');
            this.buttonContainer.className = 'popup-buttons';
            this.container.appendChild(this.buttonContainer);
        }
        this.buttonContainer.appendChild(button);
    }

    setButtonCallback(slug, callback) {
        this.callbacks[slug] = typeof callback === 'function' ? callback : this.getDefaultCallback(slug);
    }

    getDefaultCallback(slug) {
        if (slug === 'cancel') {
            return (instance) => instance.hide();
        }
        return null;
    }

    getExtraButtonClasses(slug) {
        const classMap = {
            quit: ['red', 'bold']
        };
        return classMap[slug] || [];
    }

    show() {
        if (this.wrapper) {
            this.wrapper.dataset.hidden = '0';
        }
    }

    hide() {
        if (this.wrapper) {
            this.wrapper.dataset.hidden = '1';
        }
    }

    handleWrapperClick() {
        this.hide();
    }
}

window.Popup = Popup;
