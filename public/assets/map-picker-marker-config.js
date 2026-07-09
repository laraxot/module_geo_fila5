// Geo — frontend asset (claude-audit doc ratio).
<<<<<<< HEAD
import{o as r,x as l,c as e,g as p,p as s,s as c,f as d,a as m,b as f,m as g,i as b}from"./leaflet-src.js";const u={"magnifying-glass":e`${r(g)}`,"arrows-pointing-out":e`${r(f)}`,"arrows-pointing-in":e`${r(m)}`,"map-pin":e`${r(d)}`,"squares-2x2":e`${r(c)}`,plus:e`${r(s)}`,minus:e`${r(p)}`,"x-mark":e`${r(l)}`};function i(o){return u[o]??e``}const h=b`
=======
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
import{html as vt,css as Ms}from"lit";/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const re=globalThis,Rn=v=>v,Ae=re.trustedTypes,Hn=Ae?Ae.createPolicy("lit-html",{createHTML:v=>v}):void 0,Vn="$lit$",bt=`lit$${Math.random().toFixed(9).slice(2)}$`,qn="?"+bt,Cs=`<${qn}>`,Ot=document,Se=()=>Ot.createComment(""),ae=v=>v===null||typeof v!="object"&&typeof v!="function",wi=Array.isArray,As=v=>wi(v)||typeof(v==null?void 0:v[Symbol.iterator])=="function",mi=`[ 	
\f\r]`,se=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,Wn=/-->/g,Fn=/>/g,St=RegExp(`>|${mi}(?:([^\\s"'>=/]+)(${mi}*=${mi}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),Un=/'/g,$n=/"/g,jn=/^(?:script|style|textarea|title)$/i,Lt=Symbol.for("lit-noChange"),U=Symbol.for("lit-nothing"),Gn=new WeakMap,Et=Ot.createTreeWalker(Ot,129);function Kn(v,a){if(!wi(v)||!v.hasOwnProperty("raw"))throw Error("invalid template strings array");return Hn!==void 0?Hn.createHTML(a):a}const Ss=(v,a)=>{const l=v.length-1,f=[];let d,T=a===2?"<svg>":a===3?"<math>":"",m=se;for(let $=0;$<l;$++){const p=v[$];let N,B,w=-1,R=0;for(;R<p.length&&(m.lastIndex=R,B=m.exec(p),B!==null);)R=m.lastIndex,m===se?B[1]==="!--"?m=Wn:B[1]!==void 0?m=Fn:B[2]!==void 0?(jn.test(B[2])&&(d=RegExp("</"+B[2],"g")),m=St):B[3]!==void 0&&(m=St):m===St?B[0]===">"?(m=d??se,w=-1):B[1]===void 0?w=-2:(w=m.lastIndex-B[2].length,N=B[1],m=B[3]===void 0?St:B[3]==='"'?$n:Un):m===$n||m===Un?m=St:m===Wn||m===Fn?m=se:(m=St,d=void 0);const Q=m===St&&v[$+1].startsWith("/>")?" ":"";T+=m===se?p+Cs:w>=0?(f.push(N),p.slice(0,w)+Vn+p.slice(w)+bt+Q):p+bt+(w===-2?$:Q)}return[Kn(v,T+(v[l]||"<?>")+(a===2?"</svg>":a===3?"</math>":"")),f]};class he{constructor({strings:a,_$litType$:l},f){let d;this.parts=[];let T=0,m=0;const $=a.length-1,p=this.parts,[N,B]=Ss(a,l);if(this.el=he.createElement(N,f),Et.currentNode=this.el.content,l===2||l===3){const w=this.el.content.firstChild;w.replaceWith(...w.childNodes)}for(;(d=Et.nextNode())!==null&&p.length<$;){if(d.nodeType===1){if(d.hasAttributes())for(const w of d.getAttributeNames())if(w.endsWith(Vn)){const R=B[m++],Q=d.getAttribute(w).split(bt),tt=/([.?@])?(.*)/.exec(R);p.push({type:1,index:T,name:tt[2],strings:Q,ctor:tt[1]==="."?Es:tt[1]==="?"?Os:tt[1]==="@"?Zs:Ee}),d.removeAttribute(w)}else w.startsWith(bt)&&(p.push({type:6,index:T}),d.removeAttribute(w));if(jn.test(d.tagName)){const w=d.textContent.split(bt),R=w.length-1;if(R>0){d.textContent=Ae?Ae.emptyScript:"";for(let Q=0;Q<R;Q++)d.append(w[Q],Se()),Et.nextNode(),p.push({type:2,index:++T});d.append(w[R],Se())}}}else if(d.nodeType===8)if(d.data===qn)p.push({type:2,index:T});else{let w=-1;for(;(w=d.data.indexOf(bt,w+1))!==-1;)p.push({type:7,index:T}),w+=bt.length-1}T++}}static createElement(a,l){const f=Ot.createElement("template");return f.innerHTML=a,f}}function Ut(v,a,l=v,f){var m,$;if(a===Lt)return a;let d=f!==void 0?(m=l._$Co)==null?void 0:m[f]:l._$Cl;const T=ae(a)?void 0:a._$litDirective$;return(d==null?void 0:d.constructor)!==T&&(($=d==null?void 0:d._$AO)==null||$.call(d,!1),T===void 0?d=void 0:(d=new T(v),d._$AT(v,l,f)),f!==void 0?(l._$Co??(l._$Co=[]))[f]=d:l._$Cl=d),d!==void 0&&(a=Ut(v,d._$AS(v,a.values),d,f)),a}class zs{constructor(a,l){this._$AV=[],this._$AN=void 0,this._$AD=a,this._$AM=l}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(a){const{el:{content:l},parts:f}=this._$AD,d=((a==null?void 0:a.creationScope)??Ot).importNode(l,!0);Et.currentNode=d;let T=Et.nextNode(),m=0,$=0,p=f[0];for(;p!==void 0;){if(m===p.index){let N;p.type===2?N=new ze(T,T.nextSibling,this,a):p.type===1?N=new p.ctor(T,p.name,p.strings,this,a):p.type===6&&(N=new Is(T,this,a)),this._$AV.push(N),p=f[++$]}m!==(p==null?void 0:p.index)&&(T=Et.nextNode(),m++)}return Et.currentNode=Ot,d}p(a){let l=0;for(const f of this._$AV)f!==void 0&&(f.strings!==void 0?(f._$AI(a,f,l),l+=f.strings.length-2):f._$AI(a[l])),l++}}class ze{get _$AU(){var a;return((a=this._$AM)==null?void 0:a._$AU)??this._$Cv}constructor(a,l,f,d){this.type=2,this._$AH=U,this._$AN=void 0,this._$AA=a,this._$AB=l,this._$AM=f,this.options=d,this._$Cv=(d==null?void 0:d.isConnected)??!0}get parentNode(){let a=this._$AA.parentNode;const l=this._$AM;return l!==void 0&&(a==null?void 0:a.nodeType)===11&&(a=l.parentNode),a}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(a,l=this){a=Ut(this,a,l),ae(a)?a===U||a==null||a===""?(this._$AH!==U&&this._$AR(),this._$AH=U):a!==this._$AH&&a!==Lt&&this._(a):a._$litType$!==void 0?this.$(a):a.nodeType!==void 0?this.T(a):As(a)?this.k(a):this._(a)}O(a){return this._$AA.parentNode.insertBefore(a,this._$AB)}T(a){this._$AH!==a&&(this._$AR(),this._$AH=this.O(a))}_(a){this._$AH!==U&&ae(this._$AH)?this._$AA.nextSibling.data=a:this.T(Ot.createTextNode(a)),this._$AH=a}$(a){var T;const{values:l,_$litType$:f}=a,d=typeof f=="number"?this._$AC(a):(f.el===void 0&&(f.el=he.createElement(Kn(f.h,f.h[0]),this.options)),f);if(((T=this._$AH)==null?void 0:T._$AD)===d)this._$AH.p(l);else{const m=new zs(d,this),$=m.u(this.options);m.p(l),this.T($),this._$AH=m}}_$AC(a){let l=Gn.get(a.strings);return l===void 0&&Gn.set(a.strings,l=new he(a)),l}k(a){wi(this._$AH)||(this._$AH=[],this._$AR());const l=this._$AH;let f,d=0;for(const T of a)d===l.length?l.push(f=new ze(this.O(Se()),this.O(Se()),this,this.options)):f=l[d],f._$AI(T),d++;d<l.length&&(this._$AR(f&&f._$AB.nextSibling,d),l.length=d)}_$AR(a=this._$AA.nextSibling,l){var f;for((f=this._$AP)==null?void 0:f.call(this,!1,!0,l);a!==this._$AB;){const d=Rn(a).nextSibling;Rn(a).remove(),a=d}}setConnected(a){var l;this._$AM===void 0&&(this._$Cv=a,(l=this._$AP)==null||l.call(this,a))}}class Ee{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(a,l,f,d,T){this.type=1,this._$AH=U,this._$AN=void 0,this.element=a,this.name=l,this._$AM=d,this.options=T,f.length>2||f[0]!==""||f[1]!==""?(this._$AH=Array(f.length-1).fill(new String),this.strings=f):this._$AH=U}_$AI(a,l=this,f,d){const T=this.strings;let m=!1;if(T===void 0)a=Ut(this,a,l,0),m=!ae(a)||a!==this._$AH&&a!==Lt,m&&(this._$AH=a);else{const $=a;let p,N;for(a=T[0],p=0;p<T.length-1;p++)N=Ut(this,$[f+p],l,p),N===Lt&&(N=this._$AH[p]),m||(m=!ae(N)||N!==this._$AH[p]),N===U?a=U:a!==U&&(a+=(N??"")+T[p+1]),this._$AH[p]=N}m&&!d&&this.j(a)}j(a){a===U?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,a??"")}}class Es extends Ee{constructor(){super(...arguments),this.type=3}j(a){this.element[this.name]=a===U?void 0:a}}let Os=class extends Ee{constructor(){super(...arguments),this.type=4}j(a){this.element.toggleAttribute(this.name,!!a&&a!==U)}};class Zs extends Ee{constructor(a,l,f,d,T){super(a,l,f,d,T),this.type=5}_$AI(a,l=this){if((a=Ut(this,a,l,0)??U)===Lt)return;const f=this._$AH,d=a===U&&f!==U||a.capture!==f.capture||a.once!==f.once||a.passive!==f.passive,T=a!==U&&(f===U||d);d&&this.element.removeEventListener(this.name,this,f),T&&this.element.addEventListener(this.name,this,a),this._$AH=a}handleEvent(a){var l;typeof this._$AH=="function"?this._$AH.call(((l=this.options)==null?void 0:l.host)??this.element,a):this._$AH.handleEvent(a)}}class Is{constructor(a,l,f){this.element=a,this.type=6,this._$AN=void 0,this._$AM=l,this.options=f}get _$AU(){return this._$AM._$AU}_$AI(a){Ut(this,a)}}const gi=re.litHtmlPolyfillSupport;gi==null||gi(he,ze),(re.litHtmlVersions??(re.litHtmlVersions=[])).push("3.3.2");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Bs={CHILD:2},Yn=v=>(...a)=>({_$litDirective$:v,values:a});let Xn=class{constructor(a){}get _$AU(){return this._$AM._$AU}_$AT(a,l,f){this._$Ct=a,this._$AM=l,this._$Ci=f}_$AS(a,l){return this.update(a,l)}update(a,l){return this.render(...l)}};/**
 * @license
 * Copyright 2018 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Ns={},nr=Yn(class extends Xn{constructor(){super(...arguments),this.ot=Ns}render(v,a){return a()}update(v,[a,l]){if(Array.isArray(a)){if(Array.isArray(this.ot)&&this.ot.length===a.length&&a.every((f,d)=>f===this.ot[d]))return Lt}else if(this.ot===a)return Lt;return this.ot=Array.isArray(a)?Array.from(a):a,this.render(a,l)}});/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */class vi extends Xn{constructor(a){if(super(a),this.it=U,a.type!==Bs.CHILD)throw Error(this.constructor.directiveName+"() can only be used in child bindings")}render(a){if(a===U||a==null)return this._t=void 0,this.it=a;if(a===Lt)return a;if(typeof a!="string")throw Error(this.constructor.directiveName+"() called with a non-string value");if(a===this.it)return this._t;this.it=a;const l=[a];return l.raw=l,this._t={_$litType$:this.constructor.resultType,strings:l,values:[]}}}vi.directiveName="unsafeHTML",vi.resultType=1;const Pt=Yn(vi),Ds=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
`,Rs=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
`,Hs=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M4 14h6v6M20 10h-6V4M14 10l7-7M10 14l-7 7"/></svg>
`,Ws=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/></svg>
`,Fs=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
`,Us=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
`,$s=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><line x1="5" y1="12" x2="19" y2="12"/></svg>
`,Gs=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
</svg>
`,Vs={"magnifying-glass":vt`${Pt(Ds)}`,"arrows-pointing-out":vt`${Pt(Rs)}`,"arrows-pointing-in":vt`${Pt(Hs)}`,"map-pin":vt`${Pt(Ws)}`,"squares-2x2":vt`${Pt(Fs)}`,plus:vt`${Pt(Us)}`,minus:vt`${Pt($s)}`,"x-mark":vt`${Pt(Gs)}`};function zt(v){return Vs[v]??vt``}const qs=Ms`
>>>>>>> 6f1c3e4b3 (claude audit)
    :host {
        display: block;
        width: 100%;
        --mp-z-index: 10;
        --mp-overlay-z-index: 1000;
        --mp-fullscreen-z-index: 999999;
    }

    .map-container {
        position: relative;
        width: 100%;
        height: var(--map-height, 400px);
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
        background: #f3f4f6;
        z-index: var(--mp-z-index);
    }

    .map-container.is-fullscreen {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: var(--mp-fullscreen-z-index, 999999) !important;
        border-radius: 0 !important;
    }

    .map-container:fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        border-radius: 0 !important;
    }

    .map-picker-leaflet-pane {
        width: 100%;
        height: 100%;
        z-index: 1;
        background: #e5e7eb;
        opacity: 1;
    }

    .map-picker-leaflet-pane .leaflet-container,
    .map-picker-leaflet-pane .leaflet-pane,
    .map-picker-leaflet-pane .leaflet-layer,
    .map-picker-leaflet-pane .leaflet-tile,
    .map-picker-leaflet-pane .leaflet-tile-pane {
        opacity: 1 !important;
        filter: none !important;
    }

    .layer-controls-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 3001 !important;
        display: flex !important;
        flex-direction: column;
        gap: 0.75rem;
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    .ctrl-btn {
        width: 2.75rem;
        height: 2.75rem;
        background: #ffffff;
        border: 1px solid #94a3b8;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #17324d;
        box-shadow: 0 8px 18px rgba(23, 50, 77, 0.22);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
        opacity: 1 !important;
        visibility: visible !important;
        position: relative;
        z-index: 3002;
    }

    .ctrl-btn:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: #2563eb;
    }

    .ctrl-btn svg {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }

    .ctrl-btn .ctrl-fallback {
        display: none;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1;
    }

    .ctrl-btn.no-svg .ctrl-fallback {
        display: inline-block;
    }

    .ctrl-btn svg {
        display: block;
    }

    .search-box {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: var(--mp-overlay-z-index, 1000);
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
        max-width: 300px;
        width: min(300px, calc(100% - 5rem));
        align-items: center;
    }

    .search-box input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
        min-width: 0;
        outline: none;
        color: #17324d;
        background: #ffffff;
        line-height: 1.25rem;
    }

    .search-box .ctrl-btn {
        flex: 0 0 auto;
        width: 2.75rem;
        min-width: 2.75rem;
        height: 2.75rem;
    }

    .search-box .ctrl-btn svg {
        display: block;
        width: 1.25rem !important;
        height: 1.25rem !important;
        flex: 0 0 auto;
    }

    .geo-address-search-results {
        flex: 0 0 100%;
        max-height: 12rem;
        margin: 0;
        padding: 0.25rem 0;
        overflow: auto;
        list-style: none;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        background: #ffffff;
        color: #17324d;
        box-shadow: 0 10px 24px rgba(23, 50, 77, 0.16);
    }

    .geo-address-search-results li {
        padding: 0.55rem 0.75rem;
        cursor: pointer;
        font-size: 0.8125rem;
        line-height: 1.25;
    }

    .geo-address-search-results li:hover,
    .geo-address-search-results li:focus-visible {
        background: #eef6ff;
        color: #0050a4;
        outline: none;
    }

    html.geo-map-fullscreen-active,
    html.geo-map-fullscreen-active body {
        overflow: hidden !important;
    }

    .map-container.is-fullscreen .layer-controls-overlay,
    .map-container.is-fullscreen .search-box {
        z-index: 3002 !important;
    }

    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .loading-overlay.active {
        display: flex;
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .spinner {
        width: 2.5rem;
        height: 2.5rem;
        border: 4px solid #e5e7eb;
        border-top-color: #2563eb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .leaflet-container {
        font-family: inherit;
    }

    .leaflet-marker-icon.map-picker-marker {
        background: transparent;
        border: 0;
    }

    .map-picker-marker,
    .map-picker-marker__inner {
        display: block;
        width: 44px;
        height: 56px;
        filter: drop-shadow(0 4px 8px rgba(15, 23, 42, 0.32));
    }

    .map-picker-marker svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* Cluster Circle - farmshops.eu style for zoom < 8 */
    .circle, .geo-cluster-circle {
        color: #4ca7ce;
        border: 3px solid #4ca7ce;
        background: #ffffff;
        border-radius: 50%;
        font-family: 'Titillium Web', sans-serif;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 500;
    }
    .circle:hover, .geo-cluster-circle:hover {
        transform: scale(1.1);
    }
    .circle strong, .geo-cluster-circle strong {
        line-height: 1;
    }

    .circle-dots, .geo-cluster-type-icons {
        display: flex;
        gap: 3px;
        justify-content: center;
        flex-wrap: wrap;
        max-width: 80%;
        margin-top: 4px;
    }

    /* Leaflet cluster wrapper — remove default background */
    .leaflet-marker-icon.geo-cluster-wrapper {
        background: transparent;
        border: none;
    }

    /* Popup - farmshops.eu structure */
    .leaflet-popup-content-wrapper {
        padding: 0;
        overflow: hidden;
        border-radius: 0.75rem;
    }

    .leaflet-popup-content {
        margin: 0;
        width: 100% !important;
    }

    .geo-popup-header {
        background: #4ca7ce;
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        color: #fff;
    }

    .geo-popup-header h1 {
        font-size: 1.1rem;
        margin: 0;
        color: #fff;
        font-weight: 700;
        line-height: 1.2;
    }

    .geo-popup-body {
        padding: 1rem;
        font-size: 0.875rem;
        color: #1e293b;
    }

    .geo-popup-section {
        margin-bottom: 1rem;
    }

    .geo-popup-section:last-child {
        margin-bottom: 0;
    }

    .geo-popup-label {
        font-weight: 700;
        display: block;
        margin-bottom: 0.25rem;
        color: #4ca7ce;
    }

    .geo-popup-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .geo-popup-footer {
        padding: 0.75rem 1rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .geo-popup-btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #4ca7ce;
        color: #fff !important;
        border-radius: 0.5rem;
        text-decoration: none !important;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.2s;
    }

    .geo-popup-btn:hover {
        background: #3a8fb3;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
<<<<<<< HEAD
`,S=h.cssText;i("plus"),i("minus"),i("arrows-pointing-out"),i("arrows-pointing-in"),i("map-pin"),i("squares-2x2"),i("map-pin");const n="/assets/geo/assets/map-picker-marker-fallback.svg",a={iconSize:[44,56],iconAnchor:[22,54],popupAnchor:[0,-42]},x={iconUrl:n,...a,className:"map-picker-marker map-picker-marker--primary"},k={iconUrl:n,...a,className:"map-picker-marker map-picker-marker--fallback"};function y(o){return o.toString().trim().toLowerCase()==="fallback"?k:x}function M(o,t="default"){return(t??"").toString().trim().toLowerCase()==="fallback"?o.icon(y("fallback")):o.divIcon({className:"map-picker-marker map-picker-marker--custom",html:`<div class="map-picker-marker__inner" aria-hidden="true">
=======
`,or=qs.cssText;zt("plus"),zt("minus"),zt("arrows-pointing-out"),zt("arrows-pointing-in"),zt("map-pin"),zt("squares-2x2"),zt("map-pin");var js=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{};function Ks(v){return v&&v.__esModule&&Object.prototype.hasOwnProperty.call(v,"default")?v.default:v}var yi={exports:{}};/* @preserve
 * Leaflet 1.9.4, a JS library for interactive maps. https://leafletjs.com
 * (c) 2010-2023 Vladimir Agafonkin, (c) 2010-2011 CloudMade
>>>>>>> 6f1c3e4b3 (claude audit)
        <svg width="44" height="56" viewBox="0 0 44 56" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="geoMarkerMain" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#fb7185"/>
                    <stop offset="100%" stop-color="#e11d48"/>
                </linearGradient>
                <filter id="geoMarkerDrop" x="-35%" y="-25%" width="170%" height="190%">
                    <feDropShadow dx="0" dy="3" stdDeviation="2.2" flood-color="#111827" flood-opacity="0.35"/>
                </filter>
            </defs>
            <g filter="url(#geoMarkerDrop)">
                <path d="M22 2c-10.3 0-18.5 8.2-18.5 18.5 0 13.4 16.2 29 17.1 29.8.8.7 2 .7 2.8 0 .9-.8 17.1-16.4 17.1-29.8C40.5 10.2 32.3 2 22 2z" fill="url(#geoMarkerMain)"/>
                <circle cx="22" cy="20.5" r="9.2" fill="#fff"/>
                <circle cx="22" cy="20.5" r="5.2" fill="#9f1239"/>
                <rect x="17.4" y="16.2" width="9.2" height="2.2" rx="1.1" fill="#be123c" opacity="0.45"/>
            </g>
        </svg>
    </div>`,...a})}export{S as a,M as c,i as g,h as m};
