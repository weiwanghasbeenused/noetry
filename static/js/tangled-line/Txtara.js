class Txtara {
    constructor(container, target){
        this.initialized = false;
        this.container = container;
        this.target = target;
        this.textarea = null;
        this.timer = null;
        this.word_count = 0;
        this.weight = 1;
        this.nextStepButton = document.querySelector('#main-header .next-step-button');
        this.init();
    }
    init(){
        if(this.initialized) return
        this.renderElements();
        this.adjustHeight();
        this.addListeners();
        this.initialized = false;
    }
    renderElements(){
        this.textarea = document.createElement('textarea');
        this.textarea.className = 'line-controller';
        this.textarea.id = 'input';
        this.textarea.placeholder = '寫下一些生活的吉光片羽';
        this.container.appendChild(this.textarea);
    }
    adjustHeight(){

    }
    addListeners(){
        this.textarea.addEventListener('input', (e) => {
            if(this.nextStepButton) {
                if(e.target.value.trim() == '') {
                    this.nextStepButton.setAttribute('data-status', '0');
                } else {
                    this.nextStepButton.setAttribute('data-status', '1');
                }
            }
            
            if(this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            
            this.word_count = this.getWordCount(e.target.value);
            this.target.onThinking(this.word_count);
            this.timer = setTimeout(()=>{
                this.target.onPause();
            }, 1000);
        });
    }
    getWordCount(val){
        return parseInt(val.split('').length / this.weight) + 2;
    }
}