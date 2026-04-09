import MainHeader from "./MainHeader.js"
import Home from "./Home.js"
import Work from "./Work.js"
import NotFound from "./NotFound.js"
import SiteMeta from "../utils/SiteMeta.js"

export default class Nav {
    constructor(app, site_meta){
        this.app = app;
        this.endpoint_base = window.location.protocol + '//' + window.location.hostname + '/api';
        this.current = null;
        this.endpoints = {
            'home': this.endpoint_base + '/home',
            'detail': this.endpoint_base + '/detail'
        };
        this.works_limit = 5;
        this.kept_scroll_pos = 0;
        this.visited = {
            'home': null,
            'works': []
        };
        this.init(site_meta);
    }
    async init(site_meta){
        const parsed = this.parseUrl(window.location);
        this.notFound = new NotFound(this.app, parsed.path, {type: 'not-found'}, this);
        let [ page, visited ] = await this.getPageByURL()
        this.current = page;
        this.site_meta = new SiteMeta(site_meta, page);
        this.header = new MainHeader(this.current, this.current.type === 'home' ? '' : '/', this.site_meta.site_title, this);
        this.header.addTo(this.app);
        this.back_url = this.generateBackUrl(); // back_url = the current path
        this.current.on(parsed.hash, parsed.query, 0, true);
        this.sendPageView(this.current);
        window.addEventListener('popstate', () => {
            // browser back
            const path = window.location.pathname;
            this.navigate(path);
        });
    }
    parseUrl(url_str) {
        const url = url_str[0] === '/' ? new URL(url_str, window.location.origin) : new URL(url_str); // Use the current origin to resolve the relative URL
        return {
            path: url.pathname,         // Extracts "/category/project-1"
            query: url.search,          // Extracts "?test=1" (includes '?' if present)
            hash: url.hash              // Extracts "#body" (includes '#' if present)
        };
    }
    async navigate(dest){
        this.current.hide();
        let begin = Date.now();
        let next = null;
        let visited = false;
        const parsed = this.parseUrl(dest);
        const scroll_pos = this.kept_scroll_pos;
        if(parsed.path === '/') {
            if(this.visited['home']) {
                next = this.visited['home'];
                visited = true;
            } else {
                document.body.setAttribute('data-loading', 1);
                document.body.setAttribute('data-fetching', 1);
                const res = await fetch(this.endpoints['home']);
                const data = (await res.json())['data'];
                const page = new Home(this.app, parsed.path, data, this);
                this.visited['home'] = page;
                next = page;
            }
            /* reset scroll_pos */
            this.kept_scroll_pos = 0;
        } else {
            let page = this.visited['works'].find((work)=>{ return work.path === parsed.path; });
            if(page) {
                next = page;
                visited = true;
            } else {
                const uri = this.getUriByPath(parsed.path);
                const view_temp = this.getViewByUri(uri);
                if(view_temp === 'detail') {
                    document.body.setAttribute('data-loading', 1);
                    document.body.setAttribute('data-fetching', 1);
                    const res = await fetch(this.endpoints['detail'] + '?category=' + uri[1] + '&slug=' + uri[2]);
                    const data = (await res.json())['data'];
                    if(data) {
                        page = new Work(this.app, parsed.path, data, this);
                        this.visited['works'].push(page);
                        if(this.visited['works'].length > this.works_limit) this.visited['works'].shift();
                        next = page;
                    }
                    
                }
                
            }
            /* 
                keep the scroll position for the homepage 
                this current mechanism only works for one (homepage) to many (work), one direction.
            */
            if(this.current.path === '/') this.kept_scroll_pos = window.scrollY;
            else this.kept_scroll_pos = 0;
        }
        if(!next) {
            this.notFound.updateBackUrl(this.current.path);
            next = this.notFound;
        }
        this.header.update(next, this.back_url);
        let remain = this.current.hideTransition - (Date.now() - begin);
        if(remain <= 0) {
            this.arrive(next, visited, parsed.hash, parsed.query, scroll_pos);
        } else {
            setTimeout(()=>{
                this.arrive(next, visited, parsed.hash, parsed.query, scroll_pos);
            }, remain)
        }
    }
    arrive(next, visited, hash, query, scroll_pos){        
        document.body.setAttribute('data-fetching', 0);
        if(visited) next.on(hash, query, scroll_pos);
        else next.on(hash, query, scroll_pos);
        this.current = next;
        if(next.type !== '404'){
            window.history.pushState({}, '', next.path);
        } else {
            window.history.pushState({}, '', '/404');
        }
        this.site_meta.update(next);
        this.back_url = this.generateBackUrl(); // back_url = the current path
        this.sendPageView(next);
    }
    onPageShown(){
        this.header.onPageShown();
    }
    getUriByPath(path){
        let output = path.split('/');
        if(output.length > 2 && !output[output.length - 1])
            output.pop();
        return output;
    }
    getViewByUri(uri){
        const category_slugs = ['work', 'toys'];
        if(!uri[1]) {
            return 'home';
        } else if(
            uri.length === 3 && 
            category_slugs.includes(uri[1])
        )
            return 'detail';
        return '404';
    }
    sendPageView(page){
        if (window.dataLayer && Array.isArray(window.dataLayer)) {
            if(page.type !== '404'){
                console.log('sendPageView:', document.title);
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'page_view',
                    page_title: document.title,
                    page_location: window.location.href,
                    page_path: window.location.pathname
                });
            } else {
                console.log('sendPageView: 404');
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'page_view',
                    page_title: document.title,
                    page_location: window.location.href,
                    page_path: window.location.pathname
                });
            }
        } else {
            console.log('gtag is not defined...');
        }
    }
    generateBackUrl(){
        const { pathname, search, hash } = window.location;
        return `${pathname}${search}${hash}`;
    }
    async getPageByURL(url){
        if(!url) url = window.location;
        let visited = false;
        const parsed = this.parseUrl(url);
        const uri = this.getUriByPath(parsed.path);
        const view_temp = this.getViewByUri(uri);
        let page = null;
        if(view_temp === 'home') {
            if(this.visited['home']) {
                page = this.visited['home'];
                visited = true;
            } else {
                let data = await this.fetchData(this.endpoints['home']);
                if(data) {
                    page = new Home(this.app, parsed.path, data, this);
                    this.visited['home'] = page;
                }
            }
        } else if(view_temp === 'detail') {
            page = this.visited['works'].find((work)=>{ return work.path === parsed.path; });
            if(page) {
                visited = true;
            } else {
                let data = await this.fetchData(this.endpoints['detail'] + '?category=' + uri[1] + '&slug=' + uri[2]);
                if(data) {
                    
                    page = new Work(this.app, parsed.path, data, this);
                    this.visited['works'].push(page);
                    if(this.visited['works'].length > this.works_limit) this.visited['works'].shift();
                }
            }
        }
        if(!page) page = this.notFound;
        return [page, visited];
    }
    async fetchData(endpoint, enableLoading=true){
        if(enableLoading) {
            document.body.setAttribute('data-loading', 1);
            document.body.setAttribute('data-fetching', 1);
        }
        const res = await fetch(endpoint);
        const output = (await res.json())['data'];
        return output;
    }
}