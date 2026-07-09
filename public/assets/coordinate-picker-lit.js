// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
<<<<<<< HEAD
var G=Object.defineProperty;var j=(e,t,r)=>t in e?G(e,t,{enumerable:!0,configurable:!0,writable:!0,value:r}):e[t]=r;var S=(e,t,r)=>j(e,typeof t!="symbol"?t+"":t,r);import{o as l,c as o,x as H,g as Z,p as D,s as K,f as Q,a as V,b as W,m as Y,i as X,L as h,d as J,e as x}from"./leaflet-src.js";const ee=`version https://git-lfs.github.com/spec/v1
oid sha256:914656f036fbf631ea655e7e52ba2193fb23572c2bb4f493f9d6321035693471
size 488
`,te=`version https://git-lfs.github.com/spec/v1
oid sha256:6c474ff8eae96de7d099374db278ebd48363e2d8910c7b91ef02b4580ba97a67
size 655
`,re=`version https://git-lfs.github.com/spec/v1
oid sha256:a2cc3edc1e6c150c2c6db5136f6ca35ad3cd3d0ac3a83c633e6bdbc90e5fc3b6
size 601
`,ae=`version https://git-lfs.github.com/spec/v1
oid sha256:5287e3645dfb7c059018a63415e17aec7d31724102187669e83b1730f42fc07e
size 830
`,ne=`version https://git-lfs.github.com/spec/v1
oid sha256:49d82543c83b40e9486b3f2d2ba13d6147da0a8accbe4478d95065c4a9ba5af2
size 497
`,ie=`version https://git-lfs.github.com/spec/v1
oid sha256:4a86b5de8f41b466a624ec70c5b00b624481ed59a92a067229295eb98c429064
size 400
`,oe=`version https://git-lfs.github.com/spec/v1
oid sha256:39b64fe05524f200c0f40de72e271ed96046c241c9f8d340e824424d160882b0
size 694
`,se=`version https://git-lfs.github.com/spec/v1
oid sha256:0ff7a6d9efcc4acc641132cd8fbcfa5f3c43e826629f201fc64e5038836c7262
size 636
`,le=`version https://git-lfs.github.com/spec/v1
oid sha256:db8ceec9867b8dcb63efb1da7afaf6c66729e93f0e94b4352e97d6249d83680f
size 429
`,ce=`version https://git-lfs.github.com/spec/v1
oid sha256:71f9dc980c507b7cfd044b7b322790f826e69cffcb6b06802c898502328a85b5
size 501
`,pe=`version https://git-lfs.github.com/spec/v1
oid sha256:0187052648b5683b4f3dc671ee861039f6476325f08a666cc5abf1d5381d202f
size 418
`,de={"magnifying-glass":o`${l(Y)}`,"arrows-pointing-out":o`${l(W)}`,"arrows-pointing-in":o`${l(V)}`,"map-pin":o`${l(Q)}`,"squares-2x2":o`${l(K)}`,plus:o`${l(D)}`,minus:o`${l(Z)}`,"x-mark":o`${l(H)}`,"light-bulb":o`${l(ee)}`,trash:o`${l(te)}`,wrench:o`${l(re)}`,sparkles:o`${l(ae)}`,"archive-box":o`${l(ne)}`,"building-office":o`${l(ie)}`,"globe-alt":o`${l(oe)}`,truck:o`${l(se)}`,"shield-check":o`${l(le)}`,"document-text":o`${l(ce)}`,"question-mark-circle":o`${l(pe)}`};function c(e){return de[e]??o``}const ue=X`
=======
// Geo — frontend asset (claude-audit doc ratio).
var yr=Object.defineProperty;var wr=(s,r,a)=>r in s?yr(s,r,{enumerable:!0,configurable:!0,writable:!0,value:a}):s[r]=a;var ro=(s,r,a)=>wr(s,typeof r!="symbol"?r+"":r,a);/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Ne=globalThis,Ii=Ne.ShadowRoot&&(Ne.ShadyCSS===void 0||Ne.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,Bi=Symbol(),ao=new WeakMap;let So=class{constructor(r,a,u){if(this._$cssResult$=!0,u!==Bi)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=r,this.t=a}get styleSheet(){let r=this.o;const a=this.t;if(Ii&&r===void 0){const u=a!==void 0&&a.length===1;u&&(r=ao.get(a)),r===void 0&&((this.o=r=new CSSStyleSheet).replaceSync(this.cssText),u&&ao.set(a,r))}return r}toString(){return this.cssText}};const br=s=>new So(typeof s=="string"?s:s+"",void 0,Bi),Pr=(s,...r)=>{const a=s.length===1?s[0]:r.reduce((u,l,_)=>u+(p=>{if(p._$cssResult$===!0)return p.cssText;if(typeof p=="number")return p;throw Error("Value passed to 'css' function must be a 'css' function result: "+p+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(l)+s[_+1],s[0]);return new So(a,s,Bi)},xr=(s,r)=>{if(Ii)s.adoptedStyleSheets=r.map(a=>a instanceof CSSStyleSheet?a:a.styleSheet);else for(const a of r){const u=document.createElement("style"),l=Ne.litNonce;l!==void 0&&u.setAttribute("nonce",l),u.textContent=a.cssText,s.appendChild(u)}},ho=Ii?s=>s:s=>s instanceof CSSStyleSheet?(r=>{let a="";for(const u of r.cssRules)a+=u.cssText;return br(a)})(s):s;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Lr,defineProperty:Tr,getOwnPropertyDescriptor:Sr,getOwnPropertyNames:kr,getOwnPropertySymbols:Mr,getPrototypeOf:Cr}=Object,St=globalThis,lo=St.trustedTypes,Er=lo?lo.emptyScript:"",Si=St.reactiveElementPolyfillSupport,ce=(s,r)=>s,Ai={toAttribute(s,r){switch(r){case Boolean:s=s?Er:null;break;case Object:case Array:s=s==null?s:JSON.stringify(s)}return s},fromAttribute(s,r){let a=s;switch(r){case Boolean:a=s!==null;break;case Number:a=s===null?null:Number(s);break;case Object:case Array:try{a=JSON.parse(s)}catch{a=null}}return a}},ko=(s,r)=>!Lr(s,r),uo={attribute:!0,type:String,converter:Ai,reflect:!1,useDefault:!1,hasChanged:ko};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),St.litPropertyMetadata??(St.litPropertyMetadata=new WeakMap);let qt=class extends HTMLElement{static addInitializer(r){this._$Ei(),(this.l??(this.l=[])).push(r)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(r,a=uo){if(a.state&&(a.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(r)&&((a=Object.create(a)).wrapped=!0),this.elementProperties.set(r,a),!a.noAccessor){const u=Symbol(),l=this.getPropertyDescriptor(r,u,a);l!==void 0&&Tr(this.prototype,r,l)}}static getPropertyDescriptor(r,a,u){const{get:l,set:_}=Sr(this.prototype,r)??{get(){return this[a]},set(p){this[a]=p}};return{get:l,set(p){const b=l==null?void 0:l.call(this);_==null||_.call(this,p),this.requestUpdate(r,b,u)},configurable:!0,enumerable:!0}}static getPropertyOptions(r){return this.elementProperties.get(r)??uo}static _$Ei(){if(this.hasOwnProperty(ce("elementProperties")))return;const r=Cr(this);r.finalize(),r.l!==void 0&&(this.l=[...r.l]),this.elementProperties=new Map(r.elementProperties)}static finalize(){if(this.hasOwnProperty(ce("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(ce("properties"))){const a=this.properties,u=[...kr(a),...Mr(a)];for(const l of u)this.createProperty(l,a[l])}const r=this[Symbol.metadata];if(r!==null){const a=litPropertyMetadata.get(r);if(a!==void 0)for(const[u,l]of a)this.elementProperties.set(u,l)}this._$Eh=new Map;for(const[a,u]of this.elementProperties){const l=this._$Eu(a,u);l!==void 0&&this._$Eh.set(l,a)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(r){const a=[];if(Array.isArray(r)){const u=new Set(r.flat(1/0).reverse());for(const l of u)a.unshift(ho(l))}else r!==void 0&&a.push(ho(r));return a}static _$Eu(r,a){const u=a.attribute;return u===!1?void 0:typeof u=="string"?u:typeof r=="string"?r.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var r;this._$ES=new Promise(a=>this.enableUpdating=a),this._$AL=new Map,this._$E_(),this.requestUpdate(),(r=this.constructor.l)==null||r.forEach(a=>a(this))}addController(r){var a;(this._$EO??(this._$EO=new Set)).add(r),this.renderRoot!==void 0&&this.isConnected&&((a=r.hostConnected)==null||a.call(r))}removeController(r){var a;(a=this._$EO)==null||a.delete(r)}_$E_(){const r=new Map,a=this.constructor.elementProperties;for(const u of a.keys())this.hasOwnProperty(u)&&(r.set(u,this[u]),delete this[u]);r.size>0&&(this._$Ep=r)}createRenderRoot(){const r=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return xr(r,this.constructor.elementStyles),r}connectedCallback(){var r;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(r=this._$EO)==null||r.forEach(a=>{var u;return(u=a.hostConnected)==null?void 0:u.call(a)})}enableUpdating(r){}disconnectedCallback(){var r;(r=this._$EO)==null||r.forEach(a=>{var u;return(u=a.hostDisconnected)==null?void 0:u.call(a)})}attributeChangedCallback(r,a,u){this._$AK(r,u)}_$ET(r,a){var _;const u=this.constructor.elementProperties.get(r),l=this.constructor._$Eu(r,u);if(l!==void 0&&u.reflect===!0){const p=(((_=u.converter)==null?void 0:_.toAttribute)!==void 0?u.converter:Ai).toAttribute(a,u.type);this._$Em=r,p==null?this.removeAttribute(l):this.setAttribute(l,p),this._$Em=null}}_$AK(r,a){var _,p;const u=this.constructor,l=u._$Eh.get(r);if(l!==void 0&&this._$Em!==l){const b=u.getPropertyOptions(l),g=typeof b.converter=="function"?{fromAttribute:b.converter}:((_=b.converter)==null?void 0:_.fromAttribute)!==void 0?b.converter:Ai;this._$Em=l;const $=g.fromAttribute(a,b.type);this[l]=$??((p=this._$Ej)==null?void 0:p.get(l))??$,this._$Em=null}}requestUpdate(r,a,u,l=!1,_){var p;if(r!==void 0){const b=this.constructor;if(l===!1&&(_=this[r]),u??(u=b.getPropertyOptions(r)),!((u.hasChanged??ko)(_,a)||u.useDefault&&u.reflect&&_===((p=this._$Ej)==null?void 0:p.get(r))&&!this.hasAttribute(b._$Eu(r,u))))return;this.C(r,a,u)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(r,a,{useDefault:u,reflect:l,wrapped:_},p){u&&!(this._$Ej??(this._$Ej=new Map)).has(r)&&(this._$Ej.set(r,p??a??this[r]),_!==!0||p!==void 0)||(this._$AL.has(r)||(this.hasUpdated||u||(a=void 0),this._$AL.set(r,a)),l===!0&&this._$Em!==r&&(this._$Eq??(this._$Eq=new Set)).add(r))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(a){Promise.reject(a)}const r=this.scheduleUpdate();return r!=null&&await r,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var u;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[_,p]of this._$Ep)this[_]=p;this._$Ep=void 0}const l=this.constructor.elementProperties;if(l.size>0)for(const[_,p]of l){const{wrapped:b}=p,g=this[_];b!==!0||this._$AL.has(_)||g===void 0||this.C(_,void 0,p,g)}}let r=!1;const a=this._$AL;try{r=this.shouldUpdate(a),r?(this.willUpdate(a),(u=this._$EO)==null||u.forEach(l=>{var _;return(_=l.hostUpdate)==null?void 0:_.call(l)}),this.update(a)):this._$EM()}catch(l){throw r=!1,this._$EM(),l}r&&this._$AE(a)}willUpdate(r){}_$AE(r){var a;(a=this._$EO)==null||a.forEach(u=>{var l;return(l=u.hostUpdated)==null?void 0:l.call(u)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(r)),this.updated(r)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(r){return!0}update(r){this._$Eq&&(this._$Eq=this._$Eq.forEach(a=>this._$ET(a,this[a]))),this._$EM()}updated(r){}firstUpdated(r){}};qt.elementStyles=[],qt.shadowRootOptions={mode:"open"},qt[ce("elementProperties")]=new Map,qt[ce("finalized")]=new Map,Si==null||Si({ReactiveElement:qt}),(St.reactiveElementVersions??(St.reactiveElementVersions=[])).push("2.1.2");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const de=globalThis,co=s=>s,De=de.trustedTypes,fo=De?De.createPolicy("lit-html",{createHTML:s=>s}):void 0,Mo="$lit$",Tt=`lit$${Math.random().toFixed(9).slice(2)}$`,Co="?"+Tt,Ar=`<${Co}>`,$t=document,_e=()=>$t.createComment(""),pe=s=>s===null||typeof s!="object"&&typeof s!="function",Ri=Array.isArray,zr=s=>Ri(s)||typeof(s==null?void 0:s[Symbol.iterator])=="function",ki=`[ 	
\f\r]`,le=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,_o=/-->/g,po=/>/g,zt=RegExp(`>|${ki}(?:([^\\s"'>=/]+)(${ki}*=${ki}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),mo=/'/g,go=/"/g,Eo=/^(?:script|style|textarea|title)$/i,Or=s=>(r,...a)=>({_$litType$:s,strings:r,values:a}),C=Or(1),bt=Symbol.for("lit-noChange"),q=Symbol.for("lit-nothing"),vo=new WeakMap,Ot=$t.createTreeWalker($t,129);function Ao(s,r){if(!Ri(s)||!s.hasOwnProperty("raw"))throw Error("invalid template strings array");return fo!==void 0?fo.createHTML(r):r}const Zr=(s,r)=>{const a=s.length-1,u=[];let l,_=r===2?"<svg>":r===3?"<math>":"",p=le;for(let b=0;b<a;b++){const g=s[b];let $,N,P=-1,H=0;for(;H<g.length&&(p.lastIndex=H,N=p.exec(g),N!==null);)H=p.lastIndex,p===le?N[1]==="!--"?p=_o:N[1]!==void 0?p=po:N[2]!==void 0?(Eo.test(N[2])&&(l=RegExp("</"+N[2],"g")),p=zt):N[3]!==void 0&&(p=zt):p===zt?N[0]===">"?(p=l??le,P=-1):N[1]===void 0?P=-2:(P=p.lastIndex-N[2].length,$=N[1],p=N[3]===void 0?zt:N[3]==='"'?go:mo):p===go||p===mo?p=zt:p===_o||p===po?p=le:(p=zt,l=void 0);const it=p===zt&&s[b+1].startsWith("/>")?" ":"";_+=p===le?g+Ar:P>=0?(u.push($),g.slice(0,P)+Mo+g.slice(P)+Tt+it):g+Tt+(P===-2?b:it)}return[Ao(s,_+(s[a]||"<?>")+(r===2?"</svg>":r===3?"</math>":"")),u]};class me{constructor({strings:r,_$litType$:a},u){let l;this.parts=[];let _=0,p=0;const b=r.length-1,g=this.parts,[$,N]=Zr(r,a);if(this.el=me.createElement($,u),Ot.currentNode=this.el.content,a===2||a===3){const P=this.el.content.firstChild;P.replaceWith(...P.childNodes)}for(;(l=Ot.nextNode())!==null&&g.length<b;){if(l.nodeType===1){if(l.hasAttributes())for(const P of l.getAttributeNames())if(P.endsWith(Mo)){const H=N[p++],it=l.getAttribute(P).split(Tt),nt=/([.?@])?(.*)/.exec(H);g.push({type:1,index:_,name:nt[2],strings:it,ctor:nt[1]==="."?Ir:nt[1]==="?"?Br:nt[1]==="@"?Rr:Fe}),l.removeAttribute(P)}else P.startsWith(Tt)&&(g.push({type:6,index:_}),l.removeAttribute(P));if(Eo.test(l.tagName)){const P=l.textContent.split(Tt),H=P.length-1;if(H>0){l.textContent=De?De.emptyScript:"";for(let it=0;it<H;it++)l.append(P[it],_e()),Ot.nextNode(),g.push({type:2,index:++_});l.append(P[H],_e())}}}else if(l.nodeType===8)if(l.data===Co)g.push({type:2,index:_});else{let P=-1;for(;(P=l.data.indexOf(Tt,P+1))!==-1;)g.push({type:7,index:_}),P+=Tt.length-1}_++}}static createElement(r,a){const u=$t.createElement("template");return u.innerHTML=r,u}}function jt(s,r,a=s,u){var p,b;if(r===bt)return r;let l=u!==void 0?(p=a._$Co)==null?void 0:p[u]:a._$Cl;const _=pe(r)?void 0:r._$litDirective$;return(l==null?void 0:l.constructor)!==_&&((b=l==null?void 0:l._$AO)==null||b.call(l,!1),_===void 0?l=void 0:(l=new _(s),l._$AT(s,a,u)),u!==void 0?(a._$Co??(a._$Co=[]))[u]=l:a._$Cl=l),l!==void 0&&(r=jt(s,l._$AS(s,r.values),l,u)),r}class $r{constructor(r,a){this._$AV=[],this._$AN=void 0,this._$AD=r,this._$AM=a}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(r){const{el:{content:a},parts:u}=this._$AD,l=((r==null?void 0:r.creationScope)??$t).importNode(a,!0);Ot.currentNode=l;let _=Ot.nextNode(),p=0,b=0,g=u[0];for(;g!==void 0;){if(p===g.index){let $;g.type===2?$=new ve(_,_.nextSibling,this,r):g.type===1?$=new g.ctor(_,g.name,g.strings,this,r):g.type===6&&($=new Nr(_,this,r)),this._$AV.push($),g=u[++b]}p!==(g==null?void 0:g.index)&&(_=Ot.nextNode(),p++)}return Ot.currentNode=$t,l}p(r){let a=0;for(const u of this._$AV)u!==void 0&&(u.strings!==void 0?(u._$AI(r,u,a),a+=u.strings.length-2):u._$AI(r[a])),a++}}class ve{get _$AU(){var r;return((r=this._$AM)==null?void 0:r._$AU)??this._$Cv}constructor(r,a,u,l){this.type=2,this._$AH=q,this._$AN=void 0,this._$AA=r,this._$AB=a,this._$AM=u,this.options=l,this._$Cv=(l==null?void 0:l.isConnected)??!0}get parentNode(){let r=this._$AA.parentNode;const a=this._$AM;return a!==void 0&&(r==null?void 0:r.nodeType)===11&&(r=a.parentNode),r}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(r,a=this){r=jt(this,r,a),pe(r)?r===q||r==null||r===""?(this._$AH!==q&&this._$AR(),this._$AH=q):r!==this._$AH&&r!==bt&&this._(r):r._$litType$!==void 0?this.$(r):r.nodeType!==void 0?this.T(r):zr(r)?this.k(r):this._(r)}O(r){return this._$AA.parentNode.insertBefore(r,this._$AB)}T(r){this._$AH!==r&&(this._$AR(),this._$AH=this.O(r))}_(r){this._$AH!==q&&pe(this._$AH)?this._$AA.nextSibling.data=r:this.T($t.createTextNode(r)),this._$AH=r}$(r){var _;const{values:a,_$litType$:u}=r,l=typeof u=="number"?this._$AC(r):(u.el===void 0&&(u.el=me.createElement(Ao(u.h,u.h[0]),this.options)),u);if(((_=this._$AH)==null?void 0:_._$AD)===l)this._$AH.p(a);else{const p=new $r(l,this),b=p.u(this.options);p.p(a),this.T(b),this._$AH=p}}_$AC(r){let a=vo.get(r.strings);return a===void 0&&vo.set(r.strings,a=new me(r)),a}k(r){Ri(this._$AH)||(this._$AH=[],this._$AR());const a=this._$AH;let u,l=0;for(const _ of r)l===a.length?a.push(u=new ve(this.O(_e()),this.O(_e()),this,this.options)):u=a[l],u._$AI(_),l++;l<a.length&&(this._$AR(u&&u._$AB.nextSibling,l),a.length=l)}_$AR(r=this._$AA.nextSibling,a){var u;for((u=this._$AP)==null?void 0:u.call(this,!1,!0,a);r!==this._$AB;){const l=co(r).nextSibling;co(r).remove(),r=l}}setConnected(r){var a;this._$AM===void 0&&(this._$Cv=r,(a=this._$AP)==null||a.call(this,r))}}class Fe{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(r,a,u,l,_){this.type=1,this._$AH=q,this._$AN=void 0,this.element=r,this.name=a,this._$AM=l,this.options=_,u.length>2||u[0]!==""||u[1]!==""?(this._$AH=Array(u.length-1).fill(new String),this.strings=u):this._$AH=q}_$AI(r,a=this,u,l){const _=this.strings;let p=!1;if(_===void 0)r=jt(this,r,a,0),p=!pe(r)||r!==this._$AH&&r!==bt,p&&(this._$AH=r);else{const b=r;let g,$;for(r=_[0],g=0;g<_.length-1;g++)$=jt(this,b[u+g],a,g),$===bt&&($=this._$AH[g]),p||(p=!pe($)||$!==this._$AH[g]),$===q?r=q:r!==q&&(r+=($??"")+_[g+1]),this._$AH[g]=$}p&&!l&&this.j(r)}j(r){r===q?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,r??"")}}class Ir extends Fe{constructor(){super(...arguments),this.type=3}j(r){this.element[this.name]=r===q?void 0:r}}let Br=class extends Fe{constructor(){super(...arguments),this.type=4}j(r){this.element.toggleAttribute(this.name,!!r&&r!==q)}};class Rr extends Fe{constructor(r,a,u,l,_){super(r,a,u,l,_),this.type=5}_$AI(r,a=this){if((r=jt(this,r,a,0)??q)===bt)return;const u=this._$AH,l=r===q&&u!==q||r.capture!==u.capture||r.once!==u.once||r.passive!==u.passive,_=r!==q&&(u===q||l);l&&this.element.removeEventListener(this.name,this,u),_&&this.element.addEventListener(this.name,this,r),this._$AH=r}handleEvent(r){var a;typeof this._$AH=="function"?this._$AH.call(((a=this.options)==null?void 0:a.host)??this.element,r):this._$AH.handleEvent(r)}}class Nr{constructor(r,a,u){this.element=r,this.type=6,this._$AN=void 0,this._$AM=a,this.options=u}get _$AU(){return this._$AM._$AU}_$AI(r){jt(this,r)}}const Mi=de.litHtmlPolyfillSupport;Mi==null||Mi(me,ve),(de.litHtmlVersions??(de.litHtmlVersions=[])).push("3.3.3");const Dr=(s,r,a)=>{const u=(a==null?void 0:a.renderBefore)??r;let l=u._$litPart$;if(l===void 0){const _=(a==null?void 0:a.renderBefore)??null;u._$litPart$=l=new ve(r.insertBefore(_e(),_),_,void 0,a??{})}return l._$AI(s),l};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Zt=globalThis;let fe=class extends qt{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var a;const r=super.createRenderRoot();return(a=this.renderOptions).renderBefore??(a.renderBefore=r.firstChild),r}update(r){const a=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(r),this._$Do=Dr(a,this.renderRoot,this.renderOptions)}connectedCallback(){var r;super.connectedCallback(),(r=this._$Do)==null||r.setConnected(!0)}disconnectedCallback(){var r;super.disconnectedCallback(),(r=this._$Do)==null||r.setConnected(!1)}render(){return bt}};var To;fe._$litElement$=!0,fe.finalized=!0,(To=Zt.litElementHydrateSupport)==null||To.call(Zt,{LitElement:fe});const Ci=Zt.litElementPolyfillSupport;Ci==null||Ci({LitElement:fe});(Zt.litElementVersions??(Zt.litElementVersions=[])).push("4.2.2");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Hr={CHILD:2},zo=s=>(...r)=>({_$litDirective$:s,values:r});let Oo=class{constructor(r){}get _$AU(){return this._$AM._$AU}_$AT(r,a,u){this._$Ct=r,this._$AM=a,this._$Ci=u}_$AS(r,a){return this.update(r,a)}update(r,a){return this.render(...a)}};/**
 * @license
 * Copyright 2018 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Fr={},Ur=zo(class extends Oo{constructor(){super(...arguments),this.ot=Fr}render(s,r){return r()}update(s,[r,a]){if(Array.isArray(r)){if(Array.isArray(this.ot)&&this.ot.length===r.length&&r.every((u,l)=>u===this.ot[l]))return bt}else if(this.ot===r)return bt;return this.ot=Array.isArray(r)?Array.from(r):r,this.render(r,a)}});/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */class zi extends Oo{constructor(r){if(super(r),this.it=q,r.type!==Hr.CHILD)throw Error(this.constructor.directiveName+"() can only be used in child bindings")}render(r){if(r===q||r==null)return this._t=void 0,this.it=r;if(r===bt)return r;if(typeof r!="string")throw Error(this.constructor.directiveName+"() called with a non-string value");if(r===this.it)return this._t;this.it=r;const a=[r];return a.raw=a,this._t={_$litType$:this.constructor.resultType,strings:a,values:[]}}}zi.directiveName="unsafeHTML",zi.resultType=1;const j=zo(zi),Wr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
`,qr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
`,jr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M4 14h6v6M20 10h-6V4M14 10l7-7M10 14l-7 7"/></svg>
`,Gr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/></svg>
`,Vr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
`,Kr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
`,Yr=`<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><line x1="5" y1="12" x2="19" y2="12"/></svg>
`,Xr=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
</svg>
`,Jr=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
</svg>
`,Qr=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
</svg>
`,ta=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z"/>
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z"/>
</svg>
`,ea=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/>
</svg>
`,ia=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
</svg>
`,na=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
</svg>
`,oa=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
</svg>
`,sa=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
</svg>
`,ra=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
</svg>
`,aa=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
</svg>
`,ha=`<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>
</svg>
`,la={"magnifying-glass":C`${j(Wr)}`,"arrows-pointing-out":C`${j(qr)}`,"arrows-pointing-in":C`${j(jr)}`,"map-pin":C`${j(Gr)}`,"squares-2x2":C`${j(Vr)}`,plus:C`${j(Kr)}`,minus:C`${j(Yr)}`,"x-mark":C`${j(Xr)}`,"light-bulb":C`${j(Jr)}`,trash:C`${j(Qr)}`,wrench:C`${j(ta)}`,sparkles:C`${j(ea)}`,"archive-box":C`${j(ia)}`,"building-office":C`${j(na)}`,"globe-alt":C`${j(oa)}`,truck:C`${j(sa)}`,"shield-check":C`${j(ra)}`,"document-text":C`${j(aa)}`,"question-mark-circle":C`${j(ha)}`};function K(s){return la[s]??C``}const ua=Pr`
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

    /* Ritaglio solo i tile Leaflet: search/controlli restano sibling fuori dal clipping. */
    .map-picker-viewport {
        position: absolute;
        inset: 0;
        overflow: hidden;
        border-radius: inherit;
        z-index: 0;
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

    /* Fallback emoji/text solo se il pulsante non ha ancora un <svg> (icons da ?raw). */
    .ctrl-btn .ctrl-fallback {
        display: none !important;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1;
    }

    .ctrl-btn:not(:has(svg)) .ctrl-fallback {
        display: inline-block !important;
    }

    .ctrl-btn svg {
        display: block;
    }

    .search-box {
        position: absolute;
        top: 1rem;
        right: 1rem;
        /* Sopra overlay controlli (3001) e overlay loading (2000), sotto fullscreen chrome */
        z-index: 3200 !important;
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

    /* Cluster Circle - farmshops.eu style (no transform hover: fa "scappare" dal anchor Leaflet) */
    .circle, .geo-cluster-circle {
        color: #17324d;
        border: 3px solid #007a52;
        background: #ffffff;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        font-family: 'Titillium Web', sans-serif;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }
    .circle:hover, .geo-cluster-circle:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.22);
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

    .geo-cluster-type-icons svg,
    .geo-cluster-type-icons img,
    .geo-cluster-type-dot {
        display: block !important;
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
        min-width: 14px !important;
        min-height: 14px !important;
        flex: 0 0 auto !important;
        object-fit: contain;
    }

    .geo-cluster-type-tile {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 5px;
        background: #fff;
        border: 1px solid #d9e2f0;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.12);
        flex: 0 0 auto;
    }

    .geo-cluster-type-tile img {
        width: 14px !important;
        height: 14px !important;
        filter: none !important;
        opacity: 1 !important;
    }

    .geo-map-legend {
        background: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        font-size: 13px;
        line-height: 1.4;
        max-height: min(220px, 40vh);
        overflow-y: auto;
        pointer-events: auto;
    }

    .geo-map-legend-title {
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #5c6f82;
    }

    .geo-map-legend-items {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .geo-map-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .geo-map-legend-color {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .geo-map-legend-label {
        font-size: 12px;
        color: #17324d;
        line-height: 1.2;
    }

    /* Leaflet cluster wrapper — anchor stabile, no transform */
    .leaflet-marker-icon.geo-cluster-wrapper {
        background: transparent !important;
        border: none !important;
    }
    .leaflet-marker-icon.geo-cluster-wrapper > div {
        transform-origin: center center;
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
`,me=ue.cssText;c("plus"),c("minus"),c("arrows-pointing-out"),c("arrows-pointing-in"),c("map-pin"),c("squares-2x2"),c("map-pin");function d(e,t=[0]){if(typeof e._refreshMapSize=="function"){e._refreshMapSize(t);return}t.forEach(r=>{setTimeout(()=>{var n;return(n=e._map)==null?void 0:n.invalidateSize()},r)})}function he(e){const t=e.labels||{},r=!e.isFullscreen,n=r?t.fullscreen||"Fullscreen":t.close_fullscreen||"Chiudi";return o`
        <button class="ctrl-btn" type="button"
            @click=${()=>O(e)}
            aria-label="${n}"
            title="${n}">
            ${c(r?"arrows-pointing-out":"arrows-pointing-in")}
        </button>
    `}async function O(e){var n;const t=M(e),r=!e.isFullscreen;if(t){if(r){if(e._previousBodyOverflow=document.body.style.overflow||"",e._previousHtmlOverflow=document.documentElement.style.overflow||"",document.documentElement.classList.add("geo-map-fullscreen-active"),document.body.style.overflow="hidden",document.documentElement.style.overflow="hidden",t.requestFullscreen&&!document.fullscreenElement)try{await t.requestFullscreen()}catch{g(e)}}else{if(document.fullscreenElement&&document.exitFullscreen)try{await document.exitFullscreen()}catch{}g(e)}e.isFullscreen=r,(n=e.requestUpdate)==null||n.call(e),e.dispatchEvent(new CustomEvent("fullscreen-changed",{detail:{isFullscreen:e.isFullscreen},bubbles:!0,composed:!0})),d(e,[0,160,380,700])}}function fe(e){var n;const t=M(e),r=document.fullscreenElement===t;document.fullscreenElement&&!r||(e.isFullscreen!==r&&(e.isFullscreen=r,(n=e.requestUpdate)==null||n.call(e)),r||g(e),d(e,[0,160,380]))}function M(e){var t,r,n;return((r=(t=e.renderRoot)==null?void 0:t.querySelector)==null?void 0:r.call(t,".map-container"))||((n=e.querySelector)==null?void 0:n.call(e,".map-container"))||null}function g(e){document.documentElement.classList.remove("geo-map-fullscreen-active"),document.body.style.overflow=e._previousBodyOverflow||"",document.documentElement.style.overflow=e._previousHtmlOverflow||""}function F(e){e._map&&(e._map.zoomIn(),d(e,[150]))}function A(e){e._map&&(e._map.zoomOut(),d(e,[150]))}function ge(e){const t=e.labels||{};return o`
        <button class="ctrl-btn" type="button"
            @click=${()=>F(e)}
            aria-label="${t.zoom_in||"Zoom In"}"
            title="${t.zoom_in||"Zoom In"}">
            ${c("plus")}
        </button>
    `}function be(e){const t=e.labels||{};return o`
        <button class="ctrl-btn" type="button"
            @click=${()=>A(e)}
            aria-label="${t.zoom_out||"Zoom Out"}"
            title="${t.zoom_out||"Zoom Out"}">
            ${c("minus")}
        </button>
<<<<<<< HEAD
    `}function ye(e){return o`${ge(e)}${be(e)}`}const f=["street","humanitarian","satellite","topo"];function T(e){if(!e._map||!e._layers)return;const t=f.indexOf(e._currentLayer),r=f[(t+1)%f.length],n=e._layers[e._currentLayer];n&&e._map.removeLayer(n);const a=e._layers[r];a&&!a._map&&a.addTo(e._map),e._currentLayer=r,d(e,[0,120,300])}function _e(e){var t,r;return o`<button class="ctrl-btn" type="button"
        @click=${()=>T(e)}
        aria-label="${((t=e.labels)==null?void 0:t.switch_layer)||"Cambia Layer"}"
        title="${((r=e.labels)==null?void 0:r.switch_layer)||"Cambia Layer"}">
        ${c("squares-2x2")}
    </button>`}function _(e,t={}){const{showLoading:r=!0}=t;navigator.geolocation&&(e.isLocating||e._geolocRequested&&!r||(e._geolocRequested=!0,r&&(e.isLocating=!0,e.requestUpdate()),navigator.geolocation.getCurrentPosition(n=>{var s;const a=n.coords.latitude,i=n.coords.longitude;if(typeof e._handleMapInteraction=="function"&&e._handleMapInteraction(a,i,"geolocation"),e.geolocated=!0,r&&(e.isLocating=!1),(s=e.requestUpdate)==null||s.call(e),e._map){const p=Number.isFinite(e.zoom)?Math.max(e.zoom,14):15;e._map.setView([a,i],p,{animate:!1}),e._isUserCentered=!0,d(e,[150])}},()=>{var n;e._geolocRequested=!1,r&&(e.isLocating=!1),(n=e.requestUpdate)==null||n.call(e),e.geolocated=!1},{enableHighAccuracy:!0,timeout:1e4,maximumAge:3e5})))}function ve(e){var t,r;return o`<button class="ctrl-btn" type="button"
        @click=${()=>_(e)}
        ?disabled=${e.isLocating}
        aria-label="${((t=e.labels)==null?void 0:t.use_location)||"Mia posizione"}"
        title="${((r=e.labels)==null?void 0:r.use_location)||"Mia posizione"}">
        ${e.isLocating?o`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:c("map-pin")}
    </button>`}const C=3,we=350,ke="https://nominatim.openstreetmap.org/search";function Se(e){const t=e.renderRoot??e,r=typeof t.querySelector=="function"?t.querySelector.bind(t):null;if(!r)return;let n=r(".map-picker-search-input");if(!n){const a=r(".search-box");n=(a==null?void 0:a.querySelector("input"))??null}n&&typeof n.focus=="function"&&(n.focus(),document.activeElement!==n&&setTimeout(()=>n.focus(),50))}function I(e){var r,n;if(e.showSearch===!1)return;const t=e._searchOpen;e._searchOpen=!e._searchOpen,e._searchOpen||(e.searchQuery="",e.searchResults=[],e.showSearchResults=!1),(r=e.requestUpdate)==null||r.call(e),e._searchOpen&&!t&&((n=e.updateComplete)==null||n.then(()=>Se(e)))}function v(e){var t;e._searchOpen=!1,e.searchQuery="",e.searchResults=[],e.showSearchResults=!1,(t=e.requestUpdate)==null||t.call(e)}function ze(e,t){if(t.key==="Escape"){v(e);return}t.key==="Enter"&&(t.preventDefault(),w(e,{selectFirst:!0}))}function $e(e,t){var r;e.searchQuery=t||"",e.showSearchResults=!1,e._searchDebounce&&clearTimeout(e._searchDebounce),e.searchQuery.trim().length>=C?e._searchDebounce=setTimeout(()=>{w(e,{selectFirst:!1})},we):e.searchResults=[],(r=e.requestUpdate)==null||r.call(e)}async function w(e,t={}){var n,a,i;const r=String(e.searchQuery||"").trim();if(r.length<C){e.searchResults=[],e.showSearchResults=!1,(n=e.requestUpdate)==null||n.call(e);return}e.isSearching=!0,(a=e.requestUpdate)==null||a.call(e);try{const s=await Le(e,r);e.searchResults=Array.isArray(s)?s:[],e.showSearchResults=e.searchResults.length>0,t.selectFirst&&e.searchResults[0]&&q(e,e.searchResults[0])}catch(s){console.warn("[map-search] Address search failed",s),e.searchResults=[],e.showSearchResults=!1}finally{e.isSearching=!1,(i=e.requestUpdate)==null||i.call(e)}}function q(e,t){var s;const r=Number.parseFloat(t.lat),n=Number.parseFloat(t.lon??t.lng);if(!Number.isFinite(r)||!Number.isFinite(n))return;const a=t.display_name||`${r}, ${n}`,i=Re(t,r,n,a);e.searchQuery=a,e.searchResults=[],e.showSearchResults=!1,typeof e._handleSearchSelection=="function"?e._handleSearchSelection(t,r,n,i):typeof e._handleMapInteraction=="function"?e._handleMapInteraction(r,n,"search"):e._map&&e._map.setView([r,n],Math.max(e._map.getZoom(),16)),(s=e.requestUpdate)==null||s.call(e)}function Re(e,t,r,n){const a=e&&typeof e.address=="object"&&e.address!==null?e.address:{},i=(...s)=>{for(const p of s)if(typeof p=="string"&&p.trim()!=="")return p;return null};return{lat:t,lng:r,latitude:t,longitude:r,address:n,display_name:(e==null?void 0:e.display_name)??n,provider:"nominatim",place_id:(e==null?void 0:e.place_id)??null,osm_type:(e==null?void 0:e.osm_type)??null,osm_id:(e==null?void 0:e.osm_id)??null,licence:(e==null?void 0:e.licence)??null,importance:typeof(e==null?void 0:e.importance)=="number"?e.importance:null,type:(e==null?void 0:e.type)??null,class:(e==null?void 0:e.class)??null,boundingbox:Array.isArray(e==null?void 0:e.boundingbox)?e.boundingbox:null,street:i(a.road,a.pedestrian,a.footway,a.path,a.residential,a.highway),street_number:i(a.house_number),zip:i(a.postcode),postcode:i(a.postcode),city:i(a.city,a.town,a.village,a.municipality,a.hamlet,a.county),suburb:i(a.suburb,a.neighbourhood,a.quarter,a.city_district),province:i(a.province,a.county,a.state_district),state:i(a.state,a.region),country:i(a.country),country_code:i(a.country_code),address_details:a,raw:e}}async function Le(e,t){if(typeof e.searchAddress=="function")return e.searchAddress(t);const r=new URL(ke);r.searchParams.set("format","json"),r.searchParams.set("addressdetails","1"),r.searchParams.set("limit","5"),r.searchParams.set("q",t);const n=await fetch(r.toString(),{headers:{"Accept-Language":document.documentElement.lang||"it"}});if(!n.ok)throw new Error(`HTTP ${n.status}`);return n.json()}const P=Object.freeze({updateSearchQuery:$e,handleSearchKeydown:ze,executeAddressSearch:w,selectSearchResult:q,closeSearch:v,toggleSearch:I});function Ee(e,t=P){const r=e.labels||{},n=r.search_placeholder||"Cerca indirizzo...",a=Array.isArray(e.searchResults)?e.searchResults:[],i=!!(e.showSearchResults&&a.length>0);return o`
=======
    `}function ma(s){return C`${_a(s)}${pa(s)}`}const Ei=["street","humanitarian","satellite","topo"];function Ro(s){if(!s._map||!s._layers)return;const r=Ei.indexOf(s._currentLayer),a=Ei[(r+1)%Ei.length],u=s._layers[s._currentLayer];u&&s._map.removeLayer(u);const l=s._layers[a];l&&!l._map&&l.addTo(s._map),s._currentLayer=a,Gt(s,[0,120,300])}function ga(s){var r,a;return C`<button class="ctrl-btn" type="button"
        @click=${()=>Ro(s)}
        aria-label="${((r=s.labels)==null?void 0:r.switch_layer)||"Cambia Layer"}"
        title="${((a=s.labels)==null?void 0:a.switch_layer)||"Cambia Layer"}">
        ${K("squares-2x2")}
    </button>`}function Ni(s,r={}){const{showLoading:a=!0}=r;navigator.geolocation&&(s.isLocating||s._geolocRequested&&!a||(s._geolocRequested=!0,a&&(s.isLocating=!0,s.requestUpdate()),navigator.geolocation.getCurrentPosition(u=>{var p;const l=u.coords.latitude,_=u.coords.longitude;if(typeof s._handleMapInteraction=="function"&&s._handleMapInteraction(l,_,"geolocation"),s.geolocated=!0,a&&(s.isLocating=!1),(p=s.requestUpdate)==null||p.call(s),s._map){const b=Number.isFinite(s.zoom)?Math.max(s.zoom,14):15;s._map.setView([l,_],b,{animate:!1}),s._isUserCentered=!0,Gt(s,[150])}},()=>{var u;s._geolocRequested=!1,a&&(s.isLocating=!1),(u=s.requestUpdate)==null||u.call(s),s.geolocated=!1},{enableHighAccuracy:!0,timeout:1e4,maximumAge:3e5})))}function va(s){var r,a;return C`<button class="ctrl-btn" type="button"
        @click=${()=>Ni(s)}
        ?disabled=${s.isLocating}
        aria-label="${((r=s.labels)==null?void 0:r.use_location)||"Mia posizione"}"
        title="${((a=s.labels)==null?void 0:a.use_location)||"Mia posizione"}">
        ${s.isLocating?C`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:K("map-pin")}
>>>>>>> 6f1c3e4b3 (claude audit)
        <div class="search-box geo-address-search geo-search-expanded"
             @click="${s=>s.stopPropagation()}">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${n}"
                aria-label="${n}"
                autocomplete="off"
                .value="${e.searchQuery||""}"
                @input="${s=>t.updateSearchQuery(e,s.target.value)}"
                @keydown="${s=>t.handleSearchKeydown(e,s)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${r.search||"Cerca"}"
                title="${r.search||"Cerca"}"
                @click="${()=>t.executeAddressSearch(e,{selectFirst:!0})}"
            >
                ${e.isSearching?o`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:c("magnifying-glass")}
            </button>
            <button
                class="ctrl-btn geo-search-close"
                type="button"
                aria-label="${r.close_search||"Chiudi ricerca"}"
                title="${r.close_search||"Chiudi ricerca"}"
                @click="${()=>t.closeSearch(e)}"
            >
                ${c("x-mark")}
            </button>

            ${i?o`
                <ul class="geo-address-search-results" role="listbox">
                    ${a.map(s=>o`
                        <li
                            role="option"
                            @click="${()=>t.selectSearchResult(e,s)}"
                            title="${s.display_name||""}"
                        >
                            ${s.display_name||`${s.lat}, ${s.lon}`}
                        </li>
                    `)}
                </ul>
            `:""}
        </div>
    `}function Oe(e){var r,n;return e.showSearch!==!1?o`
        <button class="ctrl-btn" type="button"
            @click=${a=>{a.stopPropagation(),I(e)}}
            aria-label="${((r=e.labels)==null?void 0:r.search)||"Cerca indirizzo"}"
            title="${((n=e.labels)==null?void 0:n.search)||"Cerca indirizzo"}">
            ${c("magnifying-glass")}
        </button>
    `:o``}const Me=[Oe,he,ve,_e,ye];function Fe(e){return o`
        <div class="layer-controls-overlay">
            ${Me.map(t=>t(e))}
        </div>
<<<<<<< HEAD
    `}const z=32;function Ae(e){const t=String(e||"").trim();return t===""||!t.startsWith("/")||/["'<>]/.test(t)?null:t}function Te(e,t=z,r={}){const n=Ae(e);if(!n)return"";const a=Number(t)||z,i=r.monochrome===!0?"filter:brightness(0) saturate(100%);opacity:0.88;":"";return`<img src="${n}" alt="" class="geo-map-marker-glyph geo-map-marker-glyph--img" width="${a}" height="${a}" loading="lazy" decoding="async" style="width:${a}px;height:${a}px;max-width:${a}px;max-height:${a}px;${i}" />`}const Ce=/^#[0-9a-f]{3}([0-9a-f]{3})?$/i,$=40,b=40,Ie=b,qe=26,Pe=.94,Ue=.38;function U(e,t="#0066cc"){return Ce.test(String(e||""))?e:t}function R(e,t=1){const r=U(e).replace("#",""),n=r.length===3?r.split("").map(m=>m+m).join(""):r,a=Number.parseInt(n,16);if(!Number.isFinite(a))return`rgba(96, 125, 139, ${t})`;const i=a>>16&255,s=a>>8&255,p=a&255;return`rgba(${i}, ${s}, ${p}, ${t})`}function Ne(e){return`<span class="geo-map-marker-card__initial" aria-hidden="true">${String(e||"?").trim().charAt(0).toUpperCase()||"?"}</span>`}function Be(e,t="#0066cc",r=null,n=""){const a=U(t),i=R(t,Pe),s=R(t,Ue),p=Te(r,qe,{monochrome:!0}),m=p?"":Ne(n);return e.divIcon({html:`<div class="geo-map-marker-card geo-map-marker-card--square" style="--status-color:${a};--status-fill:${i};--status-glow:${s}" aria-hidden="true">
=======
    `}function Ea(s){return s&&s.__esModule&&Object.prototype.hasOwnProperty.call(s,"default")?s.default:s}var ue={exports:{}};/* @preserve
 * Leaflet 1.9.4, a JS library for interactive maps. https://leafletjs.com
 * (c) 2010-2023 Vladimir Agafonkin, (c) 2010-2011 CloudMade
>>>>>>> 6f1c3e4b3 (claude audit)
            <div class="geo-map-marker-card__shell">
                <div class="geo-map-marker-card__inner">
                    <div class="geo-map-marker-card__glyph">${p}${m}</div>
                </div>
            </div>
<<<<<<< HEAD
        </div>`,className:"geo-map-marker-wrapper geo-map-marker-wrapper--card",iconSize:[$,Ie],iconAnchor:[$/2,b/2],popupAnchor:[0,-b/2]})}function Ge(e){return{street:e.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19}),humanitarian:e.tileLayer("https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",{maxZoom:19}),satellite:e.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",{maxZoom:19}),topo:e.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}",{maxZoom:19})}}function je(e,t,r){[0,50,150,300,500,800,1200].forEach(n=>{setTimeout(()=>{e.offsetParent===null||!t||(t.invalidateSize({animate:!1}),He(e,t,n))},n)})}function He(e,t,r){var a,i;if(!e._shouldRecenterAfterResize||!e._marker)return;const n=(i=(a=e._marker).getLatLng)==null?void 0:i.call(a);n&&(t.setView(n,t.getZoom(),{animate:!1}),r>=800&&(e._shouldRecenterAfterResize=!1))}function u(e){e._map&&je(e,e._map)}function Ze(e){const{resizeObserver:t,mutationObserver:r}=Ke(e,()=>u(e));e._resizeObserver=t,e._mutationObserver=r}function De(e){e._resizeObserver&&(e._resizeObserver.disconnect(),e._resizeObserver=null),e._mutationObserver&&(e._mutationObserver.disconnect(),e._mutationObserver=null)}function Ke(e,t){const r=new ResizeObserver(t);r.observe(e);const n=new MutationObserver(()=>{e.offsetParent!==null&&t()});let a=e.parentElement;for(let i=0;i<20&&a;i++)n.observe(a,{attributes:!0,attributeFilter:["class","style","hidden"]}),a=a.parentElement;return{resizeObserver:r,mutationObserver:n}}function L(e){return!e||typeof e!="object"?{lat:null,lng:null}:{lat:e.lat??e.latitude??null,lng:e.lng??e.longitude??null}}function Qe(e,t){const r=Number.parseFloat(Number.parseFloat(e).toFixed(6)),n=Number.parseFloat(Number.parseFloat(t).toFixed(6));return!Number.isFinite(r)||!Number.isFinite(n)?null:{lat:r,lng:n}}const Ve="https://nominatim.openstreetmap.org/reverse";async function We(e,t){const r=new URL(Ve);r.searchParams.set("format","json"),r.searchParams.set("lat",String(e)),r.searchParams.set("lon",String(t)),r.searchParams.set("addressdetails","1"),r.searchParams.set("zoom","18");const n=await fetch(r.toString(),{headers:{"Accept-Language":document.documentElement.lang||"it"}});if(!n.ok)throw new Error(`HTTP ${n.status}`);const a=await n.json(),i=a==null?void 0:a.display_name;return typeof i!="string"||i.trim()===""?null:{display_name:i.trim(),raw:a}}const Ye=420;function Xe(e,t,r,n){n!=="search"&&(e._reverseGeocodeTimer&&clearTimeout(e._reverseGeocodeTimer),e._reverseGeocodeTimer=setTimeout(()=>{e._reverseGeocodeTimer=null,(async()=>{var a;try{const i=await We(t,r);if(!i)return;e.state={...e.state||{},address:i.display_name,display_name:i.display_name,provider:"nominatim",raw:i.raw},(a=e.requestUpdate)==null||a.call(e),e.dispatchEvent(new CustomEvent("coords-changed",{detail:{lat:t,lng:r,latitude:t,longitude:r,address:i.display_name,display_name:i.display_name,source:`${n}-reverse`},bubbles:!0,composed:!0}))}catch(i){console.warn("[map-events] reverse geocode failed",i)}})()},Ye))}function k(e,t,r,n="manual"){e._isProgrammaticUpdate=!0;const a=Qe(t,r);if(!a){e._isProgrammaticUpdate=!1;return}const i=n==="search";e.state={...e.state||{},lat:a.lat,lng:a.lng,latitude:a.lat,longitude:a.lng,...i?{}:{address:null,display_name:null}},e._shouldRecenterAfterResize=!0,e._updateMarker(a.lat,a.lng),e.dispatchEvent(new CustomEvent("coords-changed",{detail:{lat:a.lat,lng:a.lng,latitude:a.lat,longitude:a.lng,source:n,...i?{}:{address:null,display_name:null}},bubbles:!0,composed:!0})),Xe(e,a.lat,a.lng,n),window.setTimeout(()=>{e._isProgrammaticUpdate=!1},100)}function N(e,t,r){e._map&&(e._marker?e._marker.setLatLng([t,r]):(e._marker=h.marker([t,r],{draggable:!0,icon:Be(h)}).addTo(e._map),e._marker.on("dragend",n=>{const a=n.target.getLatLng();k(e,a.lat,a.lng,"dragend")})))}function y(e){if(!e._map)return;const t=e._lat,r=e._lng;N(e,t,r),e._shouldRecenterAfterResize=!0,e._map.setView([t,r],Math.max(e._map.getZoom(),e.zoom)),u(e)}function E(e){const t=e.querySelector(".map-picker-leaflet-pane");if(!t||e._map)return;e._layers=e._layers??{},e._currentLayer=e._currentLayer??"street";const r=e._lat!=null&&e._lng!=null,n=r?e._lat:41.9028,a=r?e._lng:12.4964;e._map=h.map(t,{center:[n,a],zoom:e.zoom,zoomControl:!1,attributionControl:!1}),e._layers=Ge(h),e._layers.street.addTo(e._map),e._map.on("click",i=>k(e,i.latlng.lat,i.latlng.lng,"click")),r?y(e):window.setTimeout(()=>{e._lat==null&&e._lng==null&&_(e,{showLoading:!0})},300),u(e)}class B extends J{get _lat(){return L(this.state).lat}get _lng(){return L(this.state).lng}createRenderRoot(){return this}constructor(){super(),this.state=null,this.zoom=13,this.height="400px",this.isLocating=!1,this.isFullscreen=!1,this.geolocateWhenEmpty=!1,this.geolocated=!1,this.labels={},this.provider="osm",this.showSearch=!0,this.searchQuery="",this.searchResults=[],this.showSearchResults=!1,this.isSearching=!1,this._searchOpen=!1,this._isProgrammaticUpdate=!1,this._reverseGeocodeTimer=null,this._layers={},this._marker=null,this._map=null,this._lastMeasuredSize=null,this._debounceTimeout=null,this._boundRefreshMapSize=null,this._resizeObserver=null,this._mutationObserver=null,this._currentLayer="street"}render(){return this.labels,o`
=======
>>>>>>> 6f1c3e4b3 (claude audit)
            <style>
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${me}
                .map-container { min-height: 200px; }
                .map-container.is-fullscreen,
                .map-container:fullscreen { position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; border: none !important; border-radius: 0 !important; z-index: 999999 !important; }
                .map-container.is-fullscreen .map-picker-leaflet-pane,
                .map-container:fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
            </style>
            <div class="map-container ${this.isFullscreen?"is-fullscreen":""}" style="--map-height: ${this.height}">
                <div class="map-picker-viewport">
                    ${x([],()=>o`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
                </div>
                ${this.showSearch!==!1&&this._searchOpen?Ee(this,P):""}
                ${Fe(this)}
                <div class="loading-overlay ${this.isLocating?"active":""}">
                    <div class="spinner"></div>
                </div>
            </div>
<<<<<<< HEAD
        `}firstUpdated(){E(this),this._boundRefreshMapSize=()=>u(this),Ze(this),this._handleFullscreenChange=()=>{console.log("[coordinate-picker] Fullscreen change event detected"),fe(this)},document.addEventListener("fullscreenchange",this._handleFullscreenChange),this._handleEscapeKey=t=>{if(t.key==="Escape"){if(this._searchOpen){v(this);return}this.isFullscreen&&this._toggleFullscreen()}},document.addEventListener("keydown",this._handleEscapeKey)}disconnectedCallback(){super.disconnectedCallback(),this._reverseGeocodeTimer&&(clearTimeout(this._reverseGeocodeTimer),this._reverseGeocodeTimer=null),this._map&&(this._map.remove(),this._map=null),De(this),this._handleEscapeKey&&document.removeEventListener("keydown",this._handleEscapeKey),this._handleFullscreenChange&&document.removeEventListener("fullscreenchange",this._handleFullscreenChange)}updated(t){t.has("state")&&!this._isProgrammaticUpdate&&this._map&&this._lat!=null&&this._lng!=null&&y(this)}_switchLayer(){T(this)}_toggleFullscreen(){O(this)}_zoomIn(){F(this)}_zoomOut(){A(this)}_requestGeolocation(){_(this)}_handleMapInteraction(t,r,n){k(this,t,r,n)}_updateMarker(t,r){N(this,t,r)}_syncMarkerToProperties(){y(this)}_refreshMapSize(){u(this)}_initMap(){E(this)}_handleSearchSelection(t,r,n,a=null){var s,p;const i=a&&typeof a=="object"?a:{lat:r,lng:n,latitude:r,longitude:n,address:(t==null?void 0:t.display_name)||((s=this.state)==null?void 0:s.address)||"",provider:"nominatim",raw:t};this.state={...this.state||{},...i},this._handleMapInteraction(r,n,"search"),(p=this._map)==null||p.setView([r,n],Math.max(this._map.getZoom(),16))}setCoordinates(t,r,n="programmatic"){var a;this._handleMapInteraction(t,r,n),(a=this._map)==null||a.setView([t,r],Math.max(this._map.getZoom(),this.zoom))}}S(B,"properties",{state:{type:Object},zoom:{type:Number},height:{type:String},isLocating:{type:Boolean,state:!0},isFullscreen:{type:Boolean,state:!0},geolocateWhenEmpty:{type:Boolean,attribute:"geolocate-when-empty"},labels:{type:Object},provider:{type:String},showSearch:{type:Boolean,attribute:"show-search"},searchQuery:{type:String,state:!0},searchResults:{type:Array,state:!0},showSearchResults:{type:Boolean,state:!0},isSearching:{type:Boolean,state:!0},_isProgrammaticUpdate:{type:Boolean,state:!0},_searchOpen:{type:Boolean,state:!0}});typeof customElements<"u"&&!customElements.get("coordinate-picker-lit")&&customElements.define("coordinate-picker-lit",B);
=======
>>>>>>> 6f1c3e4b3 (claude audit)
