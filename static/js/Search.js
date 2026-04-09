(function(){
    class Search {
        constructor({
            root = '.search-bar-wrapper',
            responsiveSection = '.tag-list',
            inputSelector = '.search-input',
            searchButtonSelector = '.search-button',
            removeButtonSelector = '.remove-input-content-button',
            tagSelector = '.tag',
            onKeywordSelect = null,
            onSearchButtonClick = null,
            placeholder="輸入關鍵字",
            search_button_display="搜尋"
        } = {}) {
            this.root = typeof root === 'string' ? document.querySelector(root) : root;
            if (!this.root) {
                throw new Error('Search root element not found.');
            }
            this.root.setAttribute('data-empty', 1);
            this.root.innerHTML = `<div class="search-input-wrapper">
                <input type="search" class="search-input tag border-less" placeholder="${placeholder}" />
                <div class="remove-input-content-button icon esc-small-icon" data-color="black"></div>
                </div>
                <div class="search-button bold">${search_button_display}</div>`;
            this.input = this.root.querySelector(inputSelector);
            this.searchButton = this.root.querySelector(searchButtonSelector);
            this.removeButton = this.root.querySelector(removeButtonSelector);
            this.responsiveSection = this.resolveElement(responsiveSection);
            this.responsiveSection.classList.add('search-responsive-section');
            this.tagSelector = tagSelector;
            this.onKeywordSelect = typeof onKeywordSelect === 'function' ? onKeywordSelect : null;
            this.onSearchButtonClick = typeof onSearchButtonClick === 'function' ? onSearchButtonClick : null;

            this.loadingTimer = null;
            this.loadingIndicator = null;

            this.setupResponsiveSection();
            this.init();
        }

        resolveElement(target) {
            if (!target) {
                return null;
            }
            if (target instanceof Element) {
                return target;
            }
            if (typeof target === 'string') {
                const withinRoot = this.root.parentElement ? this.root.parentElement.querySelector(target) : null;
                if (withinRoot) {
                    return withinRoot;
                }
                return document.querySelector(target);
            }
            return null;
        }

        setupResponsiveSection() {
            if (!this.responsiveSection) {
                return;
            }
            if (!this.responsiveSection.hasAttribute('data-loading')) {
                this.responsiveSection.setAttribute('data-loading', '0');
            }
            const existingIndicator = this.responsiveSection.querySelector('.partial-loading-icon');
            if (existingIndicator) {
                this.loadingIndicator = existingIndicator;
                return;
            }
            const indicator = document.createElement('div');
            indicator.className = 'partial-loading-icon full-center-icon icon';
            indicator.setAttribute('data-color', 'black');
            this.responsiveSection.appendChild(indicator);
            this.loadingIndicator = indicator;
        }

        init() {
            this.bindInputEvents();
            this.bindSearchButton();
            this.bindRemoveButton();
            this.bindTagClicks();
            this.updateEmptyState();
        }

        bindInputEvents() {
            if (!this.input) {
                return;
            }
            this.input.addEventListener('input', () => {
                this.updateEmptyState();
                this.setLoadingState(true);
                if (this.loadingTimer) {
                    clearTimeout(this.loadingTimer);
                }
                this.loadingTimer = window.setTimeout(() => {
                    this.loadingTimer = null;
                    this.setLoadingState(false);
                }, 300);
            });
        }

        bindSearchButton() {
            if (!this.searchButton) {
                return;
            }
            this.searchButton.addEventListener('click', () => {
                const keyword = this.input ? this.input.value : '';
                if (!keyword) {
                    return;
                }
                this.triggerKeywordSelect(keyword);
                if (this.onSearchButtonClick) {
                    this.onSearchButtonClick(keyword);
                }
            });
        }

        bindRemoveButton() {
            if (!this.removeButton) {
                return;
            }
            this.removeButton.addEventListener('click', () => {
                if (this.input) {
                    this.input.value = '';
                }
                this.updateEmptyState();
            });
        }

        bindTagClicks() {
            if (!this.responsiveSection) {
                return;
            }
            const tags = this.responsiveSection.querySelectorAll(this.tagSelector);
            tags.forEach((tag) => {
                tag.addEventListener('click', () => {
                    const keyword = (tag.innerText || '').trim();
                    if (!keyword) {
                        return;
                    }
                    this.triggerKeywordSelect(keyword);
                });
            });
        }

        triggerKeywordSelect(keyword) {
            if (!keyword) {
                return;
            }
            if (this.onKeywordSelect) {
                this.onKeywordSelect(keyword);
            }
        }

        updateEmptyState() {
            if (!this.root) {
                return;
            }
            const isEmpty = !this.input || this.input.value === '';
            this.root.setAttribute('data-empty', isEmpty ? '1' : '0');
        }

        setLoadingState(isLoading) {
            if (!this.responsiveSection) {
                return;
            }
            this.responsiveSection.setAttribute('data-loading', isLoading ? '1' : '0');
        }
    }

    window.Search = Search;
})();
