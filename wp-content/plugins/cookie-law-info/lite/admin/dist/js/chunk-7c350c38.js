(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-7c350c38"],{"0235":function(t,e,n){},"2a43":function(t,e,n){"use strict";n("2ea8")},"2ea8":function(t,e,n){},"39fa":function(t,e,n){t.exports=n.p+"img/language.svg"},"5c78":function(t,e,n){"use strict";n("c05d")},"6aed":function(t,e,n){t.exports=n.p+"img/scan-history.svg"},"6c87":function(t,e,n){"use strict";n("b3ba")},"727a":function(t,e,n){"use strict";n("de21")},"7dcd":function(t,e,n){},"8e01":function(t,e,n){},"919d":function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.showConnectSuccess?n("div",{staticClass:"cky-connect-success",attrs:{id:"cky-connect-success"}},[t.syncing?n("div",{staticClass:"cky-connect-loader"},[n("cky-spinner"),n("h4",[t._v(" "+t._s(t.$i18n.__("Please wait while we connect your site to app.cookieyes.com","cookie-law-info"))+" ")])],1):n("div",{staticClass:"cky-connect-success-container"},[n("div",{staticClass:"cky-connect-success-icon"}),n("div",{staticClass:"cky-connect-success-message"},[t._t("message",(function(){return[n("h2",[t._v(" "+t._s(t.$i18n.__("Your website is connected to app.cookieyes.com","cookie-law-info"))+" ")]),n("p",[t._v(" "+t._s(t.$i18n.__("You can now continue to manage all your existing settings and access all free CookieYes features from your web app account","cookie-law-info"))+" ")])]}))],2),n("div",{staticClass:"cky-connect-success-actions"},[t._t("action",(function(){return[n("button",{staticClass:"cky-button cky-button-medium cky-external-link",on:{click:function(e){return t.redirectToApp()}}},[t._v(" "+t._s(t.$i18n.__("Go to CookieYes Web App","cookie-law-info"))+" ")])]}))],2)])]):t._e()},c=[],i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("span",{staticClass:"cky-spinner-loader"})},o=[],a={name:"CkySpinner",components:{}},r=a,l=(n("6c87"),n("2877")),u=Object(l["a"])(r,i,o,!1,null,null,null),d=u.exports,y={name:"CkyConnectSuccess",components:{CkySpinner:d},props:{timeout:{type:Number,default:6e3}},data(){return{showConnectSuccess:!1,syncing:!1}},methods:{showMessage(){this.showConnectSuccess=!0},redirectToApp(){this.$router.redirectToApp(),this.showConnectSuccess=!1,this.$router.redirectToDashboard(this.$route.name)}},created(){this.$root.$on("afterConnection",()=>{this.syncing=!0,this.showMessage()}),this.$root.$on("afterSyncing",async()=>{this.syncing=!1})}},k=y,g=(n("a209"),Object(l["a"])(k,s,c,!1,null,null,null));e["a"]=g.exports},"91db":function(t,e,n){t.exports=n.p+"img/regulation.svg"},"947c":function(t,e,n){t.exports=n.p+"img/banner-status.svg"},9573:function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"cky-section cky-section-dashboard cky-zero--padding cky-zero--margin"},[n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("notice-migration"),n("cky-connect-success"),n("cky-connect-notice")],1)]),t.loading?t._e():n("div",{staticClass:"cky-section-content"},[n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("cky-dashboard-overview")],1)]),t.account.connected&&!t.syncing?n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-7"},[n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("cky-scan-summary")],1)])]),n("div",{staticClass:"cky-col-5"},[n("cky-consent-chart")],1)]):t._e()])])},c=[],i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("cky-card",{attrs:{title:t.$i18n.__("Cookie Summary","cookie-law-info"),loading:t.cardLoader},scopedSlots:t._u([{key:"body",fn:function(){return[n("div",{staticClass:"cky-stats-section"},t._l(t.statistics,(function(t){return n("cky-stats-card",{key:t.slug,attrs:{statistics:t}})})),1)]},proxy:!0}])})},o=[],a=n("f9c4"),r=n("9610"),l=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"cky-stats-col"},[t.statistics.icon?n("div",{staticClass:"cky-stats-icon"},[n("cky-icon",{attrs:{icon:t.statistics.icon,width:t.iconWidth,color:t.iconColor}})],1):t._e(),n("div",{staticClass:"cky-stats-title"},[t._v(t._s(t.statistics.title))]),n("div",{staticClass:"cky-stats-count"},[t._v(t._s(t.statistics.count))])])},u=[],d=n("1f3d"),y={components:{CkyIcon:d["a"]},name:"CkyStatsCard",props:{statistics:Object,iconWidth:{type:String,default:"30"},iconColor:{type:String,default:"#000000"}},computed:{getLoadingClass(){return{"cky-loading":this.loading}}}},k=y,g=(n("c5a6"),n("2877")),p=Object(g["a"])(k,l,u,!1,null,null,null),f=p.exports,_={components:{CkyCard:r["a"],CkyStatsCard:f},data(){return{loading:!0,stats:[{slug:"cookies",icon:!1,title:this.$i18n.__("Total Cookies","cookie-law-info"),count:0},{slug:"categories",icon:!1,title:this.$i18n.__("Total Categories","cookie-law-info"),count:0},{slug:"pages",icon:!1,title:this.$i18n.__("Pages Scanned","cookie-law-info"),count:0}]}},methods:{async getstats(){this.loading=!0;try{const t=await a["a"].get({path:"dashboard/summary"});t&&this.stats.forEach((function(e){const n=t[e.slug]?t[e.slug]:0;e.count=n})),this.loading=!1}catch(t){console.error(t)}}},computed:{statistics(){return this.stats},cardLoader(){return!this.$store.state.settings.info||this.loading}},created(){this.getstats()}},w=_,C=Object(g["a"])(w,i,o,!1,null,null,null),h=C.exports,v=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.showNotice?n("cky-notice",{ref:"ReviewNotice",staticClass:"cky-notice-migration",attrs:{type:"info"}},[n("div",{staticClass:"cky-row cky-align-center"},[n("div",{staticClass:"cky-col-12"},[n("div",{staticClass:"cky-align-center"},[n("p",{staticStyle:{"margin-bottom":"5px","margin-right":"15px"}},[n("b",[t._v(t._s(t.message)+" ")])]),n("a",{staticClass:"cky-button cky-button-outline",attrs:{href:t.legacyURL}},[t._v(" "+t._s(t.$i18n.__("Switch back to old UI","cookie-law-info"))+" ")])])])])]):t._e()},m=[],b=n("462b"),$={name:"NoticeMigration",components:{CkyNotice:b["a"]},data(){return{showNotice:!!window.ckyAppNotices.migration_notice,legacyURL:window.ckyGlobals.legacyURL}},computed:{message(){return this.showNotice&&window.ckyAppNotices.migration_notice.message||""}},methods:{async removeNotice(){await a["a"].post({path:"/settings/notices/migration_notice"}),this.$refs.ReviewNotice.isShown=!1},async switchToLegacy(){await a["a"].post({path:"/settings/legacy"})}},mounted(){}},S=$,L=(n("fdf1"),Object(g["a"])(S,v,m,!1,null,null,null)),x=L.exports,A=n("919d"),N=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.account.connected&&!t.syncing?n("cky-notice",{staticClass:"cky-connect-notice",attrs:{type:"default"}},[n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("h4",{staticClass:"cky-admin-notice-header"},[n("cky-icon",{attrs:{icon:"successCircle",color:"#00aa63",width:"16px"}}),t._v(" "+t._s(t.$i18n.__("Your website is connected to CookieYes","cookie-law-info"))+" ")],1),n("div",{staticClass:"cky-connect-notice-message"},[n("p",[t._v(" "+t._s(t.$i18n.__("You can access all the plugin settings (Cookie Banner, Cookie Manager, Languages & Policy Generators) on the web app and unlock new features like Cookie Scan and Consent Log.","cookie-law-info"))+" ")])]),n("button",{staticClass:"cky-button cky-external-link",on:{click:function(e){return e.preventDefault(),t.$router.redirectToApp()}}},[t._v(" "+t._s(t.$i18n.__("Go to Web App","cookie-law-info"))+" ")])])])]):t.showNotice&&!t.tablesMissing?n("cky-notice",{staticClass:"cky-connect-notice cky-connect-notice-disabled",attrs:{type:"default",isDismissable:!0},on:{onDismiss:function(e){return t.removeNotice()}}},[n("div",{staticClass:"cky-row cky-align-center"},[n("div",{staticClass:"cky-col-8"},[n("h3",{staticClass:"cky-admin-notice-header"},[n("cky-icon",{attrs:{icon:"connect",width:"44px"}}),t._v(" "+t._s(t.$i18n.__("Connect your website to CookieYes","cookie-law-info"))+" ")],1),n("p",{staticStyle:{"margin-top":"10px"},domProps:{innerHTML:t._s(t.contents.connect)}}),n("div",{staticClass:"cky-connect-features"},[n("p",{staticClass:"cky-align-center"},[n("span",[t._v("✓")]),t._v(t._s(t.$i18n.__("Cookie Scanner - Discover cookies on your site and auto-block them prior to user consent (Legally required)","cookie-law-info"))+" ")]),n("p",[n("span",[t._v("✓")]),t._v(t._s(t.$i18n.__("Consent Log - Record user consents to demonstrate proof of compliance (Legally required)","cookie-law-info"))+" ")])])]),n("div",{staticClass:"cky-col-4 cky-justify-end"},[n("div",{staticClass:"cky-connect-button-container"},[n("cky-button",{ref:"ckyButtonConnectNew",staticClass:"cky-button-connect cky-button-medium",nativeOn:{click:function(e){return t.connectToApp()}}},[t._v(" "+t._s(t.$i18n.__("New? Create a Free Account","cookie-law-info"))+" "),n("template",{slot:"loader"},[t._v(t._s(t.$i18n.__("Connecting...","cookie-law-info")))])],2),n("cky-button",{ref:"ckyButtonConnectExisting",staticClass:"cky-button-connect cky-button-medium cky-button-outline",nativeOn:{click:function(e){return t.connectToApp(!0)}}},[t._v(" "+t._s(t.$i18n.__("Connect Your Existing Account","cookie-law-info"))+" "),n("template",{slot:"loader"},[t._v(t._s(t.$i18n.__("Connecting...","cookie-law-info")))])],2)],1)])])]):t._e()},O=[],B=n("c068"),j=n("2f62"),I={name:"CkyConnectNotice",mixins:[B["a"]],components:{CkyNotice:b["a"],CkyIcon:d["a"]},data(){return{syncing:!1,contents:{connect:this.$i18n.sprintf(this.$i18n.__("Create a free account to connect with %sCookieYes web app%s. After connecting, you can manage all your settings from the web app and access advanced features:","cookie-law-info"),"<b>","</b>")}}},methods:{async removeNotice(){await a["a"].post({path:"/settings/notices/connect_notice",data:{}})}},computed:{...Object(j["d"])("settings",["info"]),account(){return this.getOption("account")},showNotice(){return!!window.ckyAppNotices.connect_notice},tablesMissing(){return!!this.info.tables_missing}},mounted(){this.account.connected||(this.$root.$on("beforeConnection",()=>{this.syncing=!0}),this.$root.$on("afterConnection",()=>{}),this.$root.$on("afterSyncing",()=>{this.syncing=!1}))}},U=I,R=(n("2a43"),Object(g["a"])(U,N,O,!1,null,null,null)),T=R.exports,E=function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.pluginStatus&&!t.tablesMissing?s("div",{class:["cky-dashboard-overview",{connected:!!t.account.connected}]},[s("div",{staticClass:"cky-row"},[s("div",{staticClass:"cky-col-12"},[s("div",{staticClass:"cky-card-header"},[s("h5",{staticClass:"cky-card-title"},[t._v(" "+t._s(t.$i18n.__("Overview","cookie-law-info"))+" ")])])]),s("div",{staticClass:"cky-col-6"},[s("cky-card",{attrs:{loading:t.cardLoader},scopedSlots:t._u([{key:"body",fn:function(){return[s("div",{staticClass:"cky-card-row"},[s("div",{staticClass:"cky-info-widget-container"},[s("div",{staticClass:"cky-info-widget"},[s("div",{staticClass:"cky-info-widget-icon"},[s("img",{attrs:{src:n("947c"),alt:"layout"}})]),s("div",{staticClass:"cky-info-widget-content"},[s("span",{staticClass:"cky-info-widget-title"},[t._v(t._s(t.$i18n.__("Banner status","cookie-law-info")))]),s("span",{staticClass:"cky-info-widget-text",staticStyle:{color:"#00aa62"}},[t._v(" "+t._s(t.$i18n.__("Active","cookie-law-info"))+" ")])])]),s("div",{staticClass:"cky-info-widget"},[s("div",{staticClass:"cky-info-widget-icon"},[s("img",{attrs:{src:n("91db"),alt:"layout"}})]),s("div",{staticClass:"cky-info-widget-content"},[s("span",{staticClass:"cky-info-widget-title"},[t._v(t._s(t.$i18n.__("Regulation","cookie-law-info")))]),s("span",{staticClass:"cky-info-widget-text",staticStyle:{"text-transform":"uppercase"}},[t._v(" "+t._s(t.applicableLaws)+" ")])])])])]),s("div",{staticClass:"cky-card-row"},[s("div",{staticClass:"cky-info-widget-container"},[s("div",{staticClass:"cky-info-widget"},[s("div",{staticClass:"cky-info-widget-icon"},[s("img",{attrs:{src:n("6aed"),alt:"layout"}})]),s("div",{staticClass:"cky-info-widget-content"},[s("span",{staticClass:"cky-info-widget-title"},[t._v(t._s(t.$i18n.__("Last cookie scan","cookie-law-info")))]),s("span",{staticClass:"cky-info-widget-text"},[t.scans.date&&t.account.connected?s("span",{staticStyle:{"font-size":"14px"}},[t._v(" "+t._s(t.scans.date.date||t.$i18n.__("Not available","cookie-law-info"))+" "),s("span",{staticStyle:{"font-weight":"400"}},[t._v(t._s(t.scans.date.time||""))])]):s("span",[t._v(t._s(t.$i18n.__("Not available","cookie-law-info")))])])])]),s("div",{staticClass:"cky-info-widget"},[s("div",{staticClass:"cky-info-widget-icon"},[s("img",{attrs:{src:n("39fa"),alt:"layout"}})]),s("div",{staticClass:"cky-info-widget-content"},[s("span",{staticClass:"cky-info-widget-title"},[t._v(t._s(t.$i18n.__("Language","cookie-law-info")))]),s("span",{staticClass:"cky-info-widget-text"},[t._v(" "+t._s(t.defaultLanguage.name)+" ")])])])])]),t.account.connected?s("div",{staticClass:"cky-card-row"},[s("div",{staticClass:"cky-card-row-actions"},[s("a",{staticClass:"\n\t\t\t\t\t\t\t\t\tcky-button\n\t\t\t\t\t\t\t\t\tcky-button-outline\n\t\t\t\t\t\t\t\t\tcky-external-link\n\t\t\t\t\t\t\t\t\tcky-button-medium\n\t\t\t\t\t\t\t\t",on:{click:function(e){return t.$router.redirectToApp("customize")}}},[t._v(t._s(t.$i18n.__("Customize Banner","cookie-law-info"))+" ")]),s("a",{staticClass:"\n\t\t\t\t\t\t\t\t\tcky-link cky-actions-link cky-button-icon cky-external-link\n\t\t\t\t\t\t\t\t",attrs:{href:t.getSiteURL(),target:"_blank"}},[t._v(t._s(t.$i18n.__("Preview Banner","cookie-law-info"))+" ")])])]):s("div",{staticClass:"cky-card-row"},[s("div",{staticClass:"cky-card-row-actions"},[s("router-link",{attrs:{to:{name:"customize"},custom:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.navigate;return[s("a",{staticClass:"cky-button cky-button-outline cky-button-medium",on:{click:n}},[t._v(t._s(t.$i18n.__("Customize Banner","cookie-law-info"))+" ")])]}}],null,!1,1347445872)}),s("a",{staticClass:"\n\t\t\t\t\t\t\t\t\tcky-link cky-actions-link cky-button-icon cky-external-link\n\t\t\t\t\t\t\t\t",attrs:{href:t.getSiteURL(),target:"_blank"}},[t._v(t._s(t.$i18n.__("Preview Banner","cookie-law-info"))+" ")])],1)])]},proxy:!0}],null,!1,3414214022)})],1),s("div",{staticClass:"cky-col-6"},[t.connected?s("upgrade-widget"):s("tutorial-video")],1)])]):t._e()},G=[],Y=n("c4aa"),D=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.account.connected?n("cky-card",{staticClass:"cky-upgrade-widget",scopedSlots:t._u([{key:"body",fn:function(){return[n("div",{staticClass:"cky-row cky-align-center"},[n("div",{staticClass:"cky-col-10"},[n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("h3",{staticClass:"cky-admin-notice-header"},[t._v(" "+t._s(t.content.title)+" ")]),n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("p",{staticClass:"cky-py-2"},[t._v(" "+t._s(t.content.description)+" ")])])])])]),n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-8"},[n("div",{staticClass:"cky-premium-features-list"},[n("ul",t._l(t.content.features,(function(e,s){return n("li",{key:s},[t._v(" "+t._s(e)+" ")])})),0)])])]),n("div",{staticClass:"cky-row"},[n("div",{staticClass:"cky-col-12"},[n("div",{staticClass:"cky-align-center cky-py-2"},[n("a",{staticClass:"\n\t\t\t\t\t\t\t\t\tcky-button cky-button-medium cky-button-icon cky-center\n\t\t\t\t\t\t\t\t",attrs:{href:t.getURL(),target:"_blank"}},["ultimate"!==t.plan.toLowerCase()?n("cky-icon",{attrs:{icon:"crown",width:"20"}}):t._e(),t._v(" "+t._s(t.content.cta)+" ")],1)])])])])])]},proxy:!0}],null,!1,2990724177)}):t._e()},M=[],P=n("3840");const z={default:{title:P["a"].__("Keep pace with compliance as your business grows","cookie-law-info"),description:P["a"].__("Access advanced features and future-proof your business against legal risks. Get 2 months free on annual plans!","cookie-law-info"),features:[P["a"].__("Get unlimited pageviews/month","cookie-law-info"),P["a"].__("Schedule monthly cookie scan","cookie-law-info"),P["a"].__("Geo-target cookie banner","cookie-law-info"),P["a"].__("Remove CookieYes branding","cookie-law-info")],cta:P["a"].__("Upgrade Now","cookie-law-info")},custom:{title:P["a"].__("Automate your compliance at scale with our enterprise plan","cookie-law-info"),description:P["a"].__("Your growing website needs scalable compliance. Get access to custom features tailored to meet your unique requirements.","cookie-law-info"),features:[P["a"].__("Get unlimited pageviews/month","cookie-law-info"),P["a"].__("Unlimited pages scanned/month","cookie-law-info"),P["a"].__("Advanced CSS customization","cookie-law-info"),P["a"].__("Dedicated customer support","cookie-law-info")],cta:P["a"].__("Get Custom Plan","cookie-law-info")}};var W={name:"UpgradeWidget",mixins:[B["a"]],components:{CkyCard:r["a"],CkyIcon:d["a"]},props:{},data(){return{}},methods:{getURL(){let t=`${window.ckyGlobals.webApp.url}/settings?upgrade_id=${this.account.website_id}&openUpgrade=true&upgrade_source=cypluginupgrade`;return"ultimate"===this.plan.toLowerCase()&&(t="https://www.cookieyes.com/support/?query=enterprise&ref=cypluginupgrade#enterprise"),t}},computed:{account(){return this.getOption("account")},plan(){return!!this.getInfo("plan")&&this.getInfo("plan").name||"free"},content(){return"ultimate"===this.plan.toLowerCase()?z.custom:z.default}},async created(){}},q=W,F=(n("727a"),Object(g["a"])(q,D,M,!1,null,null,null)),J=F.exports,V=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("cky-card",{staticClass:"cky-tutorial-widget",scopedSlots:t._u([{key:"body",fn:function(){return[n("iframe",{staticClass:"youtube-player",staticStyle:{width:"100%",height:"100%"},attrs:{src:"https://www.youtube.com/embed/g20giM91rs4?rel=0",allowfullscreen:"true",sandbox:"allow-scripts allow-same-origin allow-popups allow-presentation"}})]},proxy:!0}])})},H=[],K={name:"TutorialVideo",components:{CkyCard:r["a"]},props:{},methods:{},computed:{}},Q=K,X=Object(g["a"])(Q,V,H,!1,null,null,null),Z=X.exports,tt={name:"CkyDashboardOverview",components:{CkyCard:r["a"],UpgradeWidget:J,TutorialVideo:Z},props:{},data(){return{loading:!0}},methods:{loadBanner:async function(){await Y["a"].getActiveBanner()},getSiteURL(){const t=new URL(window.ckyGlobals.site.url);return t.searchParams.append("cky_preview",!0),t.toString()}},computed:{cardLoader(){return!this.$store.state.settings.info||this.loading},banner(){return this.$store.state.banners.current},consentLogs(){return this.getInfo("consent_logs")&&this.getInfo("consent_logs").status||!1},account(){return this.getOption("account")},connected(){return!!this.account.connected},scans(){return this.getInfo("scans")&&this.getInfo("scans")||{}},applicableLaws(){if(this.account.connected){const t=this.getInfo("banners");return t.laws&&t.laws||"gdpr"}return this.banner.properties.settings.applicableLaw},pluginStatus(){return this.$store.state.settings.status},tablesMissing(){return!!this.info.tables_missing},...Object(j["c"])("languages",{defaultLanguage:"getDefault"}),...Object(j["d"])("settings",["info"])},async created(){this.loading=!0,await this.loadBanner(),this.loading=!1}},et=tt,nt=(n("acb2"),Object(g["a"])(et,E,G,!1,null,null,null)),st=nt.exports,ct={name:"Dashboard",mixins:[B["a"]],components:{NoticeMigration:x,CkyScanSummary:h,CkyConnectSuccess:A["a"],CkyConnectNotice:T,CkyDashboardOverview:st,CkyConsentChart:()=>n.e("chunk-55c96061").then(n.bind(null,"03b4"))},props:{},data(){return{scanStatus:!0,loading:!0,syncing:!1}},methods:{loadBanner:async function(){await Y["a"].getActiveBanner()},connectScan(){this.connectToApp(),this.$root.$on("afterConnection",()=>{this.$refs.ckyButtonConnectScan.startLoading()})},connectLog(){this.connectToApp(),this.$root.$on("afterConnection",()=>{this.$refs.ckyButtonConnectLog.startLoading()})},getSiteURL(){const t=new URL(window.ckyGlobals.site.url);return t.searchParams.append("cky_preview",!0),t.toString()}},computed:{banner(){return this.$store.state.banners.current},consentLogs(){return this.getInfo("consent_logs")&&this.getInfo("consent_logs").status||!1},account(){return this.getOption("account")},bannerStatus(){return this.getInfo("banners")&&this.getInfo("banners").status||!1},scans(){return this.getInfo("scans")&&this.getInfo("scans")||{}},...Object(j["c"])("languages",{defaultLanguage:"getDefault"})},async created(){this.loading=!0;try{await this.loadBanner(),this.loading=!1,this.$root.$on("beforeConnection",()=>{this.syncing=!0}),this.$root.$on("afterSyncing",()=>{this.syncing=!1})}catch(t){console.error(t)}}},it=ct,ot=(n("5c78"),Object(g["a"])(it,s,c,!1,null,"72c85508",null));e["default"]=ot.exports},9610:function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.pluginStatus?n("div",{staticClass:"cky-card",class:t.getLoadingClass},[t.title?n("div",{staticClass:"cky-card-header"},[n("h5",{staticClass:"cky-card-title"},[t._v(" "+t._s(t.title)+" ")]),t.hasActions?n("div",{staticClass:"cky-card-actions"},[t._t("headerAction")],2):t._e()]):t._e(),t.hasBodySlot?n("div",{class:t.getBodyClass},[t.loading?n("cky-card-loader"):t._t("body")],2):t._e(),t._t("outside"),t.hasFooterSlot?n("div",{staticClass:"cky-card-footer"},[t._t("footer")],2):t._e()],2):t._e()},c=[],i=n("17aa"),o={components:{CkyCardLoader:i["a"]},name:"CkyCard",props:{title:{type:String,required:!1},bodyClass:{type:String,default:""},loading:{type:Boolean,default:!1},fullWidth:{type:Boolean,default:!1}},computed:{hasActions(){return!!this.$slots.headerAction},hasBodySlot(){return!!this.$slots.body},hasFooterSlot(){return!!this.$slots.footer},getLoadingClass(){return{"cky-loading":this.loading}},getBodyClass(){return{"cky-card-body":!0,"cky-card-body--full":this.fullWidth,[this.bodyClass]:this.bodyClass}},pluginStatus(){return this.$store.state.settings.status}}},a=o,r=n("2877"),l=Object(r["a"])(a,s,c,!1,null,null,null);e["a"]=l.exports},a209:function(t,e,n){"use strict";n("d6c6")},acb2:function(t,e,n){"use strict";n("7dcd")},b3ba:function(t,e,n){},c05d:function(t,e,n){},c5a6:function(t,e,n){"use strict";n("0235")},d6c6:function(t,e,n){},de21:function(t,e,n){},fdf1:function(t,e,n){"use strict";n("8e01")}}]);