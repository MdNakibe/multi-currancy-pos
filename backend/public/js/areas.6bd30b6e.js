(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["areas"],{"3a2f":function(t,e,a){"use strict";a("a9e3");var i=a("ade3"),r=(a("9734"),a("4ad4")),o=a("a9ad"),n=a("16b7"),s=a("b848"),c=a("75eb"),l=a("f573"),d=a("f2e7"),u=a("80d2"),h=a("d9bd"),f=a("58df");e["a"]=Object(f["a"])(o["a"],n["a"],s["a"],c["a"],l["a"],d["a"]).extend({name:"v-tooltip",props:{closeDelay:{type:[Number,String],default:0},disabled:Boolean,fixed:{type:Boolean,default:!0},openDelay:{type:[Number,String],default:0},openOnHover:{type:Boolean,default:!0},tag:{type:String,default:"span"},transition:String},data:function(){return{calculatedMinWidth:0,closeDependents:!1}},computed:{calculatedLeft:function(){var t=this.dimensions,e=t.activator,a=t.content,i=!this.bottom&&!this.left&&!this.top&&!this.right,r=!1!==this.attach?e.offsetLeft:e.left,o=0;return this.top||this.bottom||i?o=r+e.width/2-a.width/2:(this.left||this.right)&&(o=r+(this.right?e.width:-a.width)+(this.right?10:-10)),this.nudgeLeft&&(o-=parseInt(this.nudgeLeft)),this.nudgeRight&&(o+=parseInt(this.nudgeRight)),"".concat(this.calcXOverflow(o,this.dimensions.content.width),"px")},calculatedTop:function(){var t=this.dimensions,e=t.activator,a=t.content,i=!1!==this.attach?e.offsetTop:e.top,r=0;return this.top||this.bottom?r=i+(this.bottom?e.height:-a.height)+(this.bottom?10:-10):(this.left||this.right)&&(r=i+e.height/2-a.height/2),this.nudgeTop&&(r-=parseInt(this.nudgeTop)),this.nudgeBottom&&(r+=parseInt(this.nudgeBottom)),"".concat(this.calcYOverflow(r+this.pageYOffset),"px")},classes:function(){return{"v-tooltip--top":this.top,"v-tooltip--right":this.right,"v-tooltip--bottom":this.bottom,"v-tooltip--left":this.left,"v-tooltip--attached":""===this.attach||!0===this.attach||"attach"===this.attach}},computedTransition:function(){return this.transition?this.transition:this.isActive?"scale-transition":"fade-transition"},offsetY:function(){return this.top||this.bottom},offsetX:function(){return this.left||this.right},styles:function(){return{left:this.calculatedLeft,maxWidth:Object(u["h"])(this.maxWidth),minWidth:Object(u["h"])(this.minWidth),opacity:this.isActive?.9:0,top:this.calculatedTop,zIndex:this.zIndex||this.activeZIndex}}},beforeMount:function(){var t=this;this.$nextTick((function(){t.value&&t.callActivate()}))},mounted:function(){"v-slot"===Object(u["u"])(this,"activator",!0)&&Object(h["b"])("v-tooltip's activator slot must be bound, try '<template #activator=\"data\"><v-btn v-on=\"data.on>'",this)},methods:{activate:function(){this.updateDimensions(),requestAnimationFrame(this.startTransition)},deactivate:function(){this.runDelay("close")},genActivatorListeners:function(){var t=this,e=r["a"].options.methods.genActivatorListeners.call(this);return e.focus=function(e){t.getActivator(e),t.runDelay("open")},e.blur=function(e){t.getActivator(e),t.runDelay("close")},e.keydown=function(e){e.keyCode===u["z"].esc&&(t.getActivator(e),t.runDelay("close"))},e},genTransition:function(){var t=this.genContent();return this.computedTransition?this.$createElement("transition",{props:{name:this.computedTransition}},[t]):t},genContent:function(){var t;return this.$createElement("div",this.setBackgroundColor(this.color,{staticClass:"v-tooltip__content",class:(t={},Object(i["a"])(t,this.contentClass,!0),Object(i["a"])(t,"menuable__content__active",this.isActive),Object(i["a"])(t,"v-tooltip__content--fixed",this.activatorFixed),t),style:this.styles,attrs:this.getScopeIdAttrs(),directives:[{name:"show",value:this.isContentActive}],ref:"content"}),this.getContentSlot())}},render:function(t){var e=this;return t(this.tag,{staticClass:"v-tooltip",class:this.classes},[this.showLazyContent((function(){return[e.genTransition()]})),this.genActivator()])}})},"86e9":function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-container",{attrs:{fluid:""}},[a("v-row",[a("v-col",{staticClass:"pb-0",attrs:{cols:"6"}},[a("v-data-table",{staticClass:"custom-data-table shadow1 white rounded px-4 py-5",attrs:{headers:t.areaHeaders,items:t.$store.getters["area/areas"],search:t.searchArea,loading:t.$store.getters["area/loadingAreas"],"loading-text":"Loading... Please wait"},scopedSlots:t._u([{key:"top",fn:function(){return[a("v-toolbar",{staticStyle:{"border-bottom":"1px solid #ddd !important"},attrs:{dense:"",color:"white",elevation:0}},[a("v-toolbar-title",{staticClass:"subtitle-1"},[t._v("Area List")]),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-form",{staticClass:"custom-form"},[a("v-text-field",{staticStyle:{width:"300px"},attrs:{outlined:"",dense:"","hide-details":"",placeholder:"Search Area","append-icon":"mdi-magnify"},model:{value:t.searchArea,callback:function(e){t.searchArea=e},expression:"searchArea"}})],1),a("v-spacer"),a("area-dialog",{ref:"areaDialog",attrs:{icon:!0}})],1)]},proxy:!0},"super_admin"==t.userType||"admin"==t.userType?{key:"item.action",fn:function(e){var i=e.item;return[a("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(e){var r=e.on;return[a("v-icon",t._g({attrs:{small:"",color:"primary"},on:{click:function(e){return t.editArea(i)}}},r),[t._v("mdi-circle-edit-outline")])]}}],null,!0)},[a("span",[t._v("Edit")])]),a("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(e){var r=e.on;return[a("v-icon",t._g({attrs:{small:"",color:"error"},on:{click:function(e){t.areaId=i.id,t.$refs.confirmDialog.dialog=!0}}},r),[t._v("mdi-delete-circle-outline")])]}}],null,!0)},[a("span",[t._v("Delete")])])]}}:null],null,!0)}),a("confirm-dialog",{ref:"confirmDialog",on:{confirm:t.deleteArea}})],1)],1)],1)},r=[],o=(a("4160"),a("b64b"),a("159b"),a("b49a")),n=a("c711"),s={name:"Areas",components:{"confirm-dialog":o["a"],"area-dialog":n["a"]},data:function(){return{areaHeaders:[{text:"SL",value:"sl"},{text:"Name",value:"name"},{text:"Action",value:"action"}],searchArea:"",areaId:null,loading:!1,userType:""}},created:function(){this.$store.dispatch("area/getAreas");var t=JSON.parse(localStorage.getItem("userData"));this.userType=t.userType},methods:{editArea:function(t){var e=this;Object.keys(this.$refs.areaDialog.area).forEach((function(a){e.$refs.areaDialog.area[a]=t[a]})),this.$refs.areaDialog.showAreaDialog=!0},deleteArea:function(){this.$store.dispatch("area/deleteArea",this.areaId),this.$refs.confirmDialog.dialog=!1}}},c=s,l=a("2877"),d=a("6544"),u=a.n(d),h=a("62ad"),f=a("a523"),v=a("8fea"),p=a("ce7e"),m=a("4bd4"),g=a("132d"),b=a("0fd9"),A=a("2fa4"),y=a("8654"),x=a("71d9"),_=a("2a7f"),w=a("3a2f"),k=Object(l["a"])(c,i,r,!1,null,null,null);e["default"]=k.exports;u()(k,{VCol:h["a"],VContainer:f["a"],VDataTable:v["a"],VDivider:p["a"],VForm:m["a"],VIcon:g["a"],VRow:b["a"],VSpacer:A["a"],VTextField:y["a"],VToolbar:x["a"],VToolbarTitle:_["a"],VTooltip:w["a"]})},9276:function(t,e,a){"use strict";var i=a("f1d3"),r=a.n(i);r.a},9734:function(t,e,a){},b49a:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-dialog",{attrs:{"max-width":"320",light:""},model:{value:t.dialog,callback:function(e){t.dialog=e},expression:"dialog"}},[a("v-card",{staticClass:"text-center"},[a("div",{staticClass:"pt-5"},[a("v-icon",{staticClass:"cust-icon",attrs:{"x-large":"",color:"red",dark:""}},[t._v(" mdi-alert ")])],1),a("v-card-title",{staticClass:"justify-center py-0"},[a("h4",[t._v("Confirmation !")])]),a("v-card-text",{staticClass:"py-0"},[t._v("Are you sure to "+t._s(t.text)+"?")]),a("v-card-actions",{staticClass:"justify-center"},[a("v-btn",{attrs:{color:"primary",dark:""},on:{click:function(e){return t.$emit("confirm")}}},[t._v("Yes")]),a("v-btn",{attrs:{color:"error",dark:""},on:{click:function(e){t.dialog=!1}}},[t._v("No")])],1)],1)],1)},r=[],o={data:function(){return{dialog:!1,text:"delete"}}},n=o,s=(a("9276"),a("2877")),c=a("6544"),l=a.n(c),d=a("8336"),u=a("b0af"),h=a("99d9"),f=a("169a"),v=a("132d"),p=Object(s["a"])(n,i,r,!1,null,null,null);e["a"]=p.exports;l()(p,{VBtn:d["a"],VCard:u["a"],VCardActions:h["a"],VCardText:h["b"],VCardTitle:h["c"],VDialog:f["a"],VIcon:v["a"]})},c711:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-dialog",{attrs:{"max-width":"300",light:""},scopedSlots:t._u([t.icon?{key:"activator",fn:function(e){var i=e.on;return[a("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(e){var r=e.on;return[a("v-btn",t._g({attrs:{fab:"","x-small":"",depressed:"",color:"primary"}},Object.assign({},i,r)),[a("v-icon",{attrs:{dark:""}},[t._v("mdi-plus")])],1)]}}],null,!0)},[a("span",[t._v("Add Area")])])]}}:{key:"activator",fn:function(e){var i=e.on;return[a("v-btn",t._g({attrs:{color:"primary",dark:""}},i),[t._v("Add Area")])]}}],null,!0),model:{value:t.showAreaDialog,callback:function(e){t.showAreaDialog=e},expression:"showAreaDialog"}},[a("v-card",[a("v-form",{ref:"areaForm",on:{submit:function(e){return e.preventDefault(),t.saveArea(e)}}},[a("v-card-title",[t._v(" Area Name "),a("v-spacer"),a("v-btn",{attrs:{dark:"",icon:"",color:"error"},on:{click:t.closeAreaDialog}},[t._v(" X ")])],1),a("v-divider"),a("v-card-text",[a("v-text-field",{attrs:{dense:"",outlined:"",autocomplete:"off",rules:[function(){return!!t.area.name||"Enter area name"}]},model:{value:t.area.name,callback:function(e){t.$set(t.area,"name",e)},expression:"area.name"}})],1),a("v-divider"),a("v-card-actions",[a("v-spacer"),a("v-btn",{attrs:{color:"primary",height:"32",dark:"",type:"submit",loading:t.loadingAreaSave}},[t._v("Save")])],1)],1)],1)],1)},r=[],o=(a("4160"),a("b64b"),a("159b"),a("96cf"),a("1da1")),n={data:function(){return{area:{id:null,name:null},showAreaDialog:!1,loadingAreaSave:!1}},props:{icon:!1},methods:{closeAreaDialog:function(){var t=this;this.resetArea(),setTimeout((function(){t.showAreaDialog=!1}),100)},saveArea:function(){var t=this;return Object(o["a"])(regeneratorRuntime.mark((function e(){var a,i;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(a=!0,t.$refs.areaForm.validate(),t.$refs.areaForm.inputs.forEach((function(t){t.hasError&&(a=!1)})),a){e.next=5;break}return e.abrupt("return");case 5:return t.loadingAreaSave=!0,e.next=8,t.$store.dispatch("area/saveArea",t.area);case 8:i=e.sent,i&&(null==t.area.id?t.resetArea():t.closeAreaDialog()),t.loadingAreaSave=!1;case 11:case"end":return e.stop()}}),e)})))()},resetArea:function(){var t=this;this.$refs.areaForm.reset(),Object.keys(this.area).forEach((function(e){t.area[e]=null})),this.$refs.areaForm.resetValidation()}}},s=n,c=a("2877"),l=a("6544"),d=a.n(l),u=a("8336"),h=a("b0af"),f=a("99d9"),v=a("169a"),p=a("ce7e"),m=a("4bd4"),g=a("132d"),b=a("2fa4"),A=a("8654"),y=a("3a2f"),x=Object(c["a"])(s,i,r,!1,null,null,null);e["a"]=x.exports;d()(x,{VBtn:u["a"],VCard:h["a"],VCardActions:f["a"],VCardText:f["b"],VCardTitle:f["c"],VDialog:v["a"],VDivider:p["a"],VForm:m["a"],VIcon:g["a"],VSpacer:b["a"],VTextField:A["a"],VTooltip:y["a"]})},f1d3:function(t,e,a){}}]);
//# sourceMappingURL=areas.6bd30b6e.js.map