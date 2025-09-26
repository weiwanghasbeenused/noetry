(function(){
    class LargePopup {
        constructor({
            id = '',
            content = '',
            header = {},
            headerId = '',
            headerClasses = ['sticky', 'large-popup-header'],
            headerColorTheme = 'light',
            mount = document.body,
            hidden = true,
            fixedAlign = 'bottom',
            loading = {}
        } = {}) {
            this.id = id;
            console.log(content);
            this.content = content;
            this.headerConfig = header;
            this.headerId = headerId;
            this.headerClasses = headerClasses;
            this.headerColorTheme = headerColorTheme;
            this.hidden = hidden;
            this.fixedAlign = fixedAlign;
            this.mountNode = typeof mount === 'string' ? document.querySelector(mount) : mount;
            if (!this.mountNode) {
                throw new Error('LargePopup mount node not found.');
            }

            const defaultLoading = { id: 'locating-loading', buttons: ['cancel'], text: '定位中...' };
            this.loadingConfig = loading === null ? null : Object.assign({}, defaultLoading, loading);

            this.root = null;
            this.headerElement = null;
            this.bodyElement = null;
            this.loadingElement = null;
            this.mask = null;

            this.render();
            this.addListeners();
        }

        render() {
            if (this.root && this.root.parentNode) {
                this.root.parentNode.removeChild(this.root);
            }
            if (this.mask && this.mask.parentNode) {
                this.mask.parentNode.removeChild(this.mask);
            }

            this.root = document.createElement('div');
            this.root.className = 'large-popup full-vw fixed';
            if (this.id) {
                this.root.id = this.id;
            }
            this.root.setAttribute('data-hidden', this.hidden ? '1' : '0');
            this.root.setAttribute('data-fixed-align', this.fixedAlign);

            const headerRenderer = typeof window.renderHeader === 'function' ? window.renderHeader : null;
            // console.log(headerRenderer);
            if (!headerRenderer) {
                throw new Error('renderHeader is not defined.');
            }

            this.headerElement = headerRenderer(this.headerConfig, this.headerColorTheme, this.headerId, this.headerClasses);
            // console.log(this.headerElement)
            this.closeButton = this.headerElement.querySelectorAll('.esc-icon, .cancel-button');
            this.root.appendChild(this.headerElement);

            this.bodyElement = document.createElement('div');
            this.bodyElement.className = 'large-popup-body';
            this.bodyElement.innerHTML = this.content;
            this.root.appendChild(this.bodyElement);

            this.mountNode.appendChild(this.root);

            if (this.loadingConfig) {
                if (this.loadingElement && this.loadingElement.parentNode) {
                    this.loadingElement.parentNode.removeChild(this.loadingElement);
                }
                this.loadingElement = this.createLoading(this.loadingConfig);
                this.mountNode.appendChild(this.loadingElement);
            }

            this.mask = this.createMask();
            this.mountNode.appendChild(this.mask);
            this.setMaskHidden(this.hidden);
        }

        setContent(html = '') {
            this.content = html;
            if (this.bodyElement) {
                this.bodyElement.innerHTML = html;
            }
        }

        updateHeader(config = this.headerConfig, headerId = this.headerId, headerClasses = this.headerClasses) {
            this.headerConfig = config;
            this.headerId = headerId;
            this.headerClasses = headerClasses;
            if (!this.root || typeof window.renderHeader !== 'function') {
                return;
            }
            const newHeader = window.renderHeader(this.headerConfig, 'dark', this.headerId, this.headerClasses);
            this.root.replaceChild(newHeader, this.headerElement);
            this.headerElement = newHeader;
        }

        show() {
            if (this.root) {
                this.root.setAttribute('data-hidden', '0');
            }
            // if (this.mask) {
            //     this.mask.setAttribute('data-rel', this.id || '');
            // }
            this.setMaskHidden(false);
            this.hidden = false;
        }

        hide() {
            if (this.root) {
                this.root.setAttribute('data-hidden', '1');
            }
            this.setMaskHidden(true);
            this.hidden = true;
        }

        showLoading() {
            if (this.loadingElement) {
                this.loadingElement.setAttribute('data-hidden', '0');
            }
        }

        hideLoading() {
            if (this.loadingElement) {
                this.loadingElement.setAttribute('data-hidden', '1');
            }
        }

        destroy() {
            if (this.root && this.root.parentNode) {
                this.root.parentNode.removeChild(this.root);
            }
            if (this.loadingElement && this.loadingElement.parentNode) {
                this.loadingElement.parentNode.removeChild(this.loadingElement);
            }
            if (this.mask && this.mask.parentNode) {
                this.mask.parentNode.removeChild(this.mask);
            }
            this.root = null;
            this.headerElement = null;
            this.bodyElement = null;
            this.loadingElement = null;
            this.mask = null;
        }

        createMask() {
            const mask = document.createElement('div');
            mask.className = 'full-vw full-vh fixed';
            mask.setAttribute('data-hidden', '1');
            mask.setAttribute('data-rel', this.id || '');
            mask.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            mask.style.top = '0';
            mask.style.left = '0';
            mask.style.zIndex = '1050';
            mask.style.transition = 'opacity 0.3s ease-in-out';
            return mask;
        }

        setMaskHidden(isHidden) {
            if (!this.mask) {
                return;
            }
            this.mask.setAttribute('data-hidden', isHidden ? '1' : '0');
            this.mask.style.opacity = isHidden ? '0' : '1';
            this.mask.style.pointerEvents = isHidden ? 'none' : 'auto';
        }

        createLoading({ id = '', buttons = [], text = '載入中...' }) {
            const container = document.createElement('div');
            if (id) {
                container.id = id;
            }
            container.className = 'full-vw full-vh fixed loading-container';
            container.setAttribute('data-hidden', '1');

            const icon = document.createElement('div');
            icon.className = 'loading-icon full-center-icon icon';
            container.appendChild(icon);

            const message = document.createElement('div');
            message.className = 'loading-message body';
            message.textContent = text;
            container.appendChild(message);

            const buttonList = Array.isArray(buttons) ? buttons : [];
            if (buttonList.length) {
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'loading-buttons';
                buttonList.forEach((button) => {
                    const spec = typeof button === 'string' ? { type: button } : button;
                    const buttonEl = this.createLoadingButton(spec.type || spec.action || '');
                    if (buttonEl) {
                        buttonWrapper.appendChild(buttonEl);
                    }
                });
                if (buttonWrapper.childNodes.length) {
                    container.appendChild(buttonWrapper);
                }
            }

            return container;
        }

        createLoadingButton(type) {
            if (type === 'cancel') {
                const cancelButton = document.createElement('div');
                cancelButton.className = 'loading-button bar-button button';
                cancelButton.setAttribute('data-action', 'cancel');
                cancelButton.textContent = '取消';
                return cancelButton;
            }
            if (type === 'quit' || type === 'leave') {
                const quitButton = document.createElement('div');
                quitButton.className = 'loading-button bar-button button red';
                quitButton.setAttribute('data-action', 'leave');
                quitButton.textContent = '放棄';
                return quitButton;
            }
            return null;
        }
        addListeners(){
            if(this.closeButton.length)
                for(const button of this.closeButton)
                    button.addEventListener('click', this.hide.bind(this));
        }
    }

    window.LargePopup = LargePopup;
})();
