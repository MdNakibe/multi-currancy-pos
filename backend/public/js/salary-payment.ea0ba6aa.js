(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["salary-payment"],{"2b5d":function(t,e,n){"use strict";n("7db0"),n("c975"),n("fb6a"),n("a434"),n("b0c0"),n("d3b7"),n("25f0"),n("8a79");var a=n("5530"),s=(n("2bfd"),n("b974")),i=(n("4de4"),n("d81d"),n("45fc"),n("498a"),n("8654")),o=n("d9f7"),r=n("80d2"),l=Object(a["a"])(Object(a["a"])({},s["b"]),{},{offsetY:!0,offsetOverflow:!0,transition:!1}),c=s["a"].extend({name:"v-autocomplete",props:{allowOverflow:{type:Boolean,default:!0},autoSelectFirst:{type:Boolean,default:!1},filter:{type:Function,default:function(t,e,n){return n.toLocaleLowerCase().indexOf(e.toLocaleLowerCase())>-1}},hideNoData:Boolean,menuProps:{type:s["a"].options.props.menuProps.type,default:function(){return l}},noFilter:Boolean,searchInput:{type:String,default:void 0}},data:function(){return{lazySearch:this.searchInput}},computed:{classes:function(){return Object(a["a"])(Object(a["a"])({},s["a"].options.computed.classes.call(this)),{},{"v-autocomplete":!0,"v-autocomplete--is-selecting-index":this.selectedIndex>-1})},computedItems:function(){return this.filteredItems},selectedValues:function(){var t=this;return this.selectedItems.map((function(e){return t.getValue(e)}))},hasDisplayedItems:function(){var t=this;return this.hideSelected?this.filteredItems.some((function(e){return!t.hasItem(e)})):this.filteredItems.length>0},currentRange:function(){return null==this.selectedItem?0:String(this.getText(this.selectedItem)).length},filteredItems:function(){var t=this;return!this.isSearching||this.noFilter||null==this.internalSearch?this.allItems:this.allItems.filter((function(e){var n=Object(r["s"])(e,t.itemText),a=null!=n?String(n):"";return t.filter(e,String(t.internalSearch),a)}))},internalSearch:{get:function(){return this.lazySearch},set:function(t){this.lazySearch=t,this.$emit("update:search-input",t)}},isAnyValueAllowed:function(){return!1},isDirty:function(){return this.searchIsDirty||this.selectedItems.length>0},isSearching:function(){return this.multiple&&this.searchIsDirty||this.searchIsDirty&&this.internalSearch!==this.getText(this.selectedItem)},menuCanShow:function(){return!!this.isFocused&&(this.hasDisplayedItems||!this.hideNoData)},$_menuProps:function(){var t=s["a"].options.computed.$_menuProps.call(this);return t.contentClass="v-autocomplete__content ".concat(t.contentClass||"").trim(),Object(a["a"])(Object(a["a"])({},l),t)},searchIsDirty:function(){return null!=this.internalSearch&&""!==this.internalSearch},selectedItem:function(){var t=this;return this.multiple?null:this.selectedItems.find((function(e){return t.valueComparator(t.getValue(e),t.getValue(t.internalValue))}))},listData:function(){var t=s["a"].options.computed.listData.call(this);return t.props=Object(a["a"])(Object(a["a"])({},t.props),{},{items:this.virtualizedItems,noFilter:this.noFilter||!this.isSearching||!this.filteredItems.length,searchInput:this.internalSearch}),t}},watch:{filteredItems:"onFilteredItemsChanged",internalValue:"setSearch",isFocused:function(t){t?(document.addEventListener("copy",this.onCopy),this.$refs.input&&this.$refs.input.select()):(document.removeEventListener("copy",this.onCopy),this.updateSelf())},isMenuActive:function(t){!t&&this.hasSlot&&(this.lazySearch=void 0)},items:function(t,e){e&&e.length||!this.hideNoData||!this.isFocused||this.isMenuActive||!t.length||this.activateMenu()},searchInput:function(t){this.lazySearch=t},internalSearch:"onInternalSearchChanged",itemText:"updateSelf"},created:function(){this.setSearch()},destroyed:function(){document.removeEventListener("copy",this.onCopy)},methods:{onFilteredItemsChanged:function(t,e){var n=this;t!==e&&(this.setMenuIndex(-1),this.$nextTick((function(){n.internalSearch&&(1===t.length||n.autoSelectFirst)&&(n.$refs.menu.getTiles(),n.setMenuIndex(0))})))},onInternalSearchChanged:function(){this.updateMenuDimensions()},updateMenuDimensions:function(){this.isMenuActive&&this.$refs.menu&&this.$refs.menu.updateDimensions()},changeSelectedIndex:function(t){this.searchIsDirty||(this.multiple&&t===r["z"].left?-1===this.selectedIndex?this.selectedIndex=this.selectedItems.length-1:this.selectedIndex--:this.multiple&&t===r["z"].right?this.selectedIndex>=this.selectedItems.length-1?this.selectedIndex=-1:this.selectedIndex++:t!==r["z"].backspace&&t!==r["z"].delete||this.deleteCurrentItem())},deleteCurrentItem:function(){var t=this.selectedIndex,e=this.selectedItems[t];if(this.isInteractive&&!this.getDisabled(e)){var n=this.selectedItems.length-1;if(-1!==this.selectedIndex||0===n){var a=this.selectedItems.length,s=t!==a-1?t:t-1,i=this.selectedItems[s];i?this.selectItem(e):this.setValue(this.multiple?[]:void 0),this.selectedIndex=s}else this.selectedIndex=n}},clearableCallback:function(){this.internalSearch=void 0,s["a"].options.methods.clearableCallback.call(this)},genInput:function(){var t=i["a"].options.methods.genInput.call(this);return t.data=Object(o["a"])(t.data,{attrs:{"aria-activedescendant":Object(r["q"])(this.$refs.menu,"activeTile.id"),autocomplete:Object(r["q"])(t.data,"attrs.autocomplete","off")},domProps:{value:this.internalSearch}}),t},genInputSlot:function(){var t=s["a"].options.methods.genInputSlot.call(this);return t.data.attrs.role="combobox",t},genSelections:function(){return this.hasSlot||this.multiple?s["a"].options.methods.genSelections.call(this):[]},onClick:function(t){this.isInteractive&&(this.selectedIndex>-1?this.selectedIndex=-1:this.onFocus(),this.isAppendInner(t.target)||this.activateMenu())},onInput:function(t){if(!(this.selectedIndex>-1)&&t.target){var e=t.target,n=e.value;e.value&&this.activateMenu(),this.internalSearch=n,this.badInput=e.validity&&e.validity.badInput}},onKeyDown:function(t){var e=t.keyCode;s["a"].options.methods.onKeyDown.call(this,t),this.changeSelectedIndex(e)},onSpaceDown:function(t){},onTabDown:function(t){s["a"].options.methods.onTabDown.call(this,t),this.updateSelf()},onUpDown:function(t){t.preventDefault(),this.activateMenu()},selectItem:function(t){s["a"].options.methods.selectItem.call(this,t),this.setSearch()},setSelectedItems:function(){s["a"].options.methods.setSelectedItems.call(this),this.isFocused||this.setSearch()},setSearch:function(){var t=this;this.$nextTick((function(){t.multiple&&t.internalSearch&&t.isMenuActive||(t.internalSearch=!t.selectedItems.length||t.multiple||t.hasSlot?null:t.getText(t.selectedItem))}))},updateSelf:function(){(this.searchIsDirty||this.internalValue)&&(this.valueComparator(this.internalSearch,this.getValue(this.internalValue))||this.setSearch())},hasItem:function(t){return this.selectedValues.indexOf(this.getValue(t))>-1},onCopy:function(t){if(-1!==this.selectedIndex){var e=this.selectedItems[this.selectedIndex],n=this.getText(e);t.clipboardData.setData("text/plain",n),t.clipboardData.setData("text/vnd.vuetify.autocomplete.item+plain",n),t.preventDefault()}}}});e["a"]=c.extend({name:"v-combobox",props:{delimiters:{type:Array,default:function(){return[]}},returnObject:{type:Boolean,default:!0}},data:function(){return{editingIndex:-1}},computed:{computedCounterValue:function(){return this.multiple?this.selectedItems.length:(this.internalSearch||"").toString().length},hasSlot:function(){return s["a"].options.computed.hasSlot.call(this)||this.multiple},isAnyValueAllowed:function(){return!0},menuCanShow:function(){return!!this.isFocused&&(this.hasDisplayedItems||!!this.$slots["no-data"]&&!this.hideNoData)}},methods:{onInternalSearchChanged:function(t){if(t&&this.multiple&&this.delimiters.length){var e=this.delimiters.find((function(e){return t.endsWith(e)}));null!=e&&(this.internalSearch=t.slice(0,t.length-e.length),this.updateTags())}this.updateMenuDimensions()},genInput:function(){var t=c.options.methods.genInput.call(this);return delete t.data.attrs.name,t.data.on.paste=this.onPaste,t},genChipSelection:function(t,e){var n=this,i=s["a"].options.methods.genChipSelection.call(this,t,e);return this.multiple&&(i.componentOptions.listeners=Object(a["a"])(Object(a["a"])({},i.componentOptions.listeners),{},{dblclick:function(){n.editingIndex=e,n.internalSearch=n.getText(t),n.selectedIndex=-1}})),i},onChipInput:function(t){s["a"].options.methods.onChipInput.call(this,t),this.editingIndex=-1},onEnterDown:function(t){t.preventDefault(),this.getMenuIndex()>-1||this.$nextTick(this.updateSelf)},onFilteredItemsChanged:function(t,e){this.autoSelectFirst&&c.options.methods.onFilteredItemsChanged.call(this,t,e)},onKeyDown:function(t){var e=t.keyCode;s["a"].options.methods.onKeyDown.call(this,t),this.multiple&&e===r["z"].left&&0===this.$refs.input.selectionStart?this.updateSelf():e===r["z"].enter&&this.onEnterDown(t),this.changeSelectedIndex(e)},onTabDown:function(t){if(this.multiple&&this.internalSearch&&-1===this.getMenuIndex())return t.preventDefault(),t.stopPropagation(),this.updateTags();c.options.methods.onTabDown.call(this,t)},selectItem:function(t){this.editingIndex>-1?this.updateEditing():c.options.methods.selectItem.call(this,t)},setSelectedItems:function(){null==this.internalValue||""===this.internalValue?this.selectedItems=[]:this.selectedItems=this.multiple?this.internalValue:[this.internalValue]},setValue:function(t){var e;s["a"].options.methods.setValue.call(this,null!=(e=t)?e:this.internalSearch)},updateEditing:function(){var t=this.internalValue.slice();t[this.editingIndex]=this.internalSearch,this.setValue(t),this.editingIndex=-1},updateCombobox:function(){var t=Boolean(this.$scopedSlots.selection)||this.hasChips;t&&!this.searchIsDirty||(this.internalSearch!==this.getText(this.internalValue)&&this.setValue(),t&&(this.internalSearch=void 0))},updateSelf:function(){this.multiple?this.updateTags():this.updateCombobox()},updateTags:function(){var t=this.getMenuIndex();if(!(t<0)||this.searchIsDirty){if(this.editingIndex>-1)return this.updateEditing();var e=this.selectedItems.indexOf(this.internalSearch);if(e>-1){var n=this.internalValue.slice();n.splice(e,1),this.setValue(n)}if(t>-1)return this.internalSearch=null;this.selectItem(this.internalSearch),this.internalSearch=null}},onPaste:function(t){if(this.multiple&&!this.searchIsDirty){var e=t.clipboardData.getData("text/vnd.vuetify.autocomplete.item+plain");e&&-1===this.findExistingIndex(e)&&(t.preventDefault(),s["a"].options.methods.selectItem.call(this,e))}}}})},"2bfd":function(t,e,n){},"3a2f":function(t,e,n){"use strict";n("a9e3");var a=n("ade3"),s=(n("9734"),n("4ad4")),i=n("a9ad"),o=n("16b7"),r=n("b848"),l=n("75eb"),c=n("f573"),u=n("f2e7"),h=n("80d2"),d=n("d9bd"),m=n("58df");e["a"]=Object(m["a"])(i["a"],o["a"],r["a"],l["a"],c["a"],u["a"]).extend({name:"v-tooltip",props:{closeDelay:{type:[Number,String],default:0},disabled:Boolean,fixed:{type:Boolean,default:!0},openDelay:{type:[Number,String],default:0},openOnHover:{type:Boolean,default:!0},tag:{type:String,default:"span"},transition:String},data:function(){return{calculatedMinWidth:0,closeDependents:!1}},computed:{calculatedLeft:function(){var t=this.dimensions,e=t.activator,n=t.content,a=!this.bottom&&!this.left&&!this.top&&!this.right,s=!1!==this.attach?e.offsetLeft:e.left,i=0;return this.top||this.bottom||a?i=s+e.width/2-n.width/2:(this.left||this.right)&&(i=s+(this.right?e.width:-n.width)+(this.right?10:-10)),this.nudgeLeft&&(i-=parseInt(this.nudgeLeft)),this.nudgeRight&&(i+=parseInt(this.nudgeRight)),"".concat(this.calcXOverflow(i,this.dimensions.content.width),"px")},calculatedTop:function(){var t=this.dimensions,e=t.activator,n=t.content,a=!1!==this.attach?e.offsetTop:e.top,s=0;return this.top||this.bottom?s=a+(this.bottom?e.height:-n.height)+(this.bottom?10:-10):(this.left||this.right)&&(s=a+e.height/2-n.height/2),this.nudgeTop&&(s-=parseInt(this.nudgeTop)),this.nudgeBottom&&(s+=parseInt(this.nudgeBottom)),"".concat(this.calcYOverflow(s+this.pageYOffset),"px")},classes:function(){return{"v-tooltip--top":this.top,"v-tooltip--right":this.right,"v-tooltip--bottom":this.bottom,"v-tooltip--left":this.left,"v-tooltip--attached":""===this.attach||!0===this.attach||"attach"===this.attach}},computedTransition:function(){return this.transition?this.transition:this.isActive?"scale-transition":"fade-transition"},offsetY:function(){return this.top||this.bottom},offsetX:function(){return this.left||this.right},styles:function(){return{left:this.calculatedLeft,maxWidth:Object(h["h"])(this.maxWidth),minWidth:Object(h["h"])(this.minWidth),opacity:this.isActive?.9:0,top:this.calculatedTop,zIndex:this.zIndex||this.activeZIndex}}},beforeMount:function(){var t=this;this.$nextTick((function(){t.value&&t.callActivate()}))},mounted:function(){"v-slot"===Object(h["u"])(this,"activator",!0)&&Object(d["b"])("v-tooltip's activator slot must be bound, try '<template #activator=\"data\"><v-btn v-on=\"data.on>'",this)},methods:{activate:function(){this.updateDimensions(),requestAnimationFrame(this.startTransition)},deactivate:function(){this.runDelay("close")},genActivatorListeners:function(){var t=this,e=s["a"].options.methods.genActivatorListeners.call(this);return e.focus=function(e){t.getActivator(e),t.runDelay("open")},e.blur=function(e){t.getActivator(e),t.runDelay("close")},e.keydown=function(e){e.keyCode===h["z"].esc&&(t.getActivator(e),t.runDelay("close"))},e},genTransition:function(){var t=this.genContent();return this.computedTransition?this.$createElement("transition",{props:{name:this.computedTransition}},[t]):t},genContent:function(){var t;return this.$createElement("div",this.setBackgroundColor(this.color,{staticClass:"v-tooltip__content",class:(t={},Object(a["a"])(t,this.contentClass,!0),Object(a["a"])(t,"menuable__content__active",this.isActive),Object(a["a"])(t,"v-tooltip__content--fixed",this.activatorFixed),t),style:this.styles,attrs:this.getScopeIdAttrs(),directives:[{name:"show",value:this.isContentActive}],ref:"content"}),this.getContentSlot())}},render:function(t){var e=this;return t(this.tag,{staticClass:"v-tooltip",class:this.classes},[this.showLazyContent((function(){return[e.genTransition()]})),this.genActivator()])}})},5778:function(t,e,n){"use strict";var a=n("6a0f"),s=n.n(a);s.a},"6a0f":function(t,e,n){},9276:function(t,e,n){"use strict";var a=n("f1d3"),s=n.n(a);s.a},9734:function(t,e,n){},b49a:function(t,e,n){"use strict";var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-dialog",{attrs:{"max-width":"320",light:""},model:{value:t.dialog,callback:function(e){t.dialog=e},expression:"dialog"}},[n("v-card",{staticClass:"text-center"},[n("div",{staticClass:"pt-5"},[n("v-icon",{staticClass:"cust-icon",attrs:{"x-large":"",color:"red",dark:""}},[t._v(" mdi-alert ")])],1),n("v-card-title",{staticClass:"justify-center py-0"},[n("h4",[t._v("Confirmation !")])]),n("v-card-text",{staticClass:"py-0"},[t._v("Are you sure to "+t._s(t.text)+"?")]),n("v-card-actions",{staticClass:"justify-center"},[n("v-btn",{attrs:{color:"primary",dark:""},on:{click:function(e){return t.$emit("confirm")}}},[t._v("Yes")]),n("v-btn",{attrs:{color:"error",dark:""},on:{click:function(e){t.dialog=!1}}},[t._v("No")])],1)],1)],1)},s=[],i={data:function(){return{dialog:!1,text:"delete"}}},o=i,r=(n("9276"),n("2877")),l=n("6544"),c=n.n(l),u=n("8336"),h=n("b0af"),d=n("99d9"),m=n("169a"),p=n("132d"),f=Object(r["a"])(o,a,s,!1,null,null,null);e["a"]=f.exports;c()(f,{VBtn:u["a"],VCard:h["a"],VCardActions:d["a"],VCardText:d["b"],VCardTitle:d["c"],VDialog:m["a"],VIcon:p["a"]})},e1b9:function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-container",{attrs:{fluid:""}},[n("v-row",{attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"12"}},[n("v-form",{ref:"salaryPaymentForm",staticClass:"custom-form",on:{submit:function(e){return e.preventDefault(),t.saveSalaryPayment(e)}}},[n("v-card",{staticClass:"white shadow1 rounded mb-4"},[n("v-row",{attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"12"}},[n("v-toolbar",{staticStyle:{"border-bottom":"1px solid #ddd !important"},attrs:{elevation:0}},[n("v-toolbar-title",{staticClass:"subtitle-1"},[t._v("Employee Salary Payment")])],1),n("v-card-text",{staticClass:"py-0 mt-1"},[n("v-row",[n("v-col",{attrs:{cols:"2"}}),n("v-col",{attrs:{cols:"4"}},[n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Payment Type")]),n("v-col",{attrs:{cols:"8"}},[n("v-combobox",{attrs:{dense:"",outlined:"","hide-details":"",items:["Cash","Bank"]},model:{value:t.payment.type,callback:function(e){t.$set(t.payment,"type",e)},expression:"payment.type"}})],1)],1),"Bank"==t.payment.type?n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Bank Acc.")]),n("v-col",{attrs:{cols:"8"}},[n("v-combobox",{attrs:{dense:"",outlined:"","hide-details":"",loading:t.$store.getters["bankAccount/loadingBankAccount"],items:t.$store.getters["bankAccount/accounts"],"item-text":"display_text","item-value":"id"},on:{focus:function(e){return t.$store.dispatch("bankAccount/getBankAccounts")}},model:{value:t.bank,callback:function(e){t.bank=e},expression:"bank"}})],1)],1):t._e(),n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Employee")]),n("v-col",{attrs:{cols:"8"}},[n("v-combobox",{attrs:{dense:"",outlined:"","hide-details":"",rules:[function(t){return!!t}],"item-text":"display_text","item-value":"id",loading:t.$store.getters["employee/loading"],items:t.$store.getters["employee/employees"]},on:{focus:function(e){return t.$store.dispatch("employee/getEmployees")}},model:{value:t.selectedEmployee,callback:function(e){t.selectedEmployee=e},expression:"selectedEmployee"}})],1)],1),n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Month")]),n("v-col",{attrs:{cols:"8"}},[n("v-combobox",{attrs:{dense:"",outlined:"","hide-details":"",rules:[function(t){return!!t}],"item-text":"name","item-value":"id",loading:t.$store.getters["month/loading"],items:t.$store.getters["month/months"]},on:{focus:function(e){return t.$store.dispatch("month/getMonths")}},model:{value:t.selectedMonth,callback:function(e){t.selectedMonth=e},expression:"selectedMonth"}})],1)],1),n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Payable Amount")]),n("v-col",{attrs:{cols:"8"}},[n("v-text-field",{attrs:{dense:"",outlined:"","hide-details":"",readonly:""},model:{value:t.paymentTotal,callback:function(e){t.paymentTotal=e},expression:"paymentTotal"}})],1)],1)],1),n("v-col",{attrs:{cols:"4"}},[n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Payment Date")]),n("v-col",{attrs:{cols:"8"}},[n("v-menu",{attrs:{"close-on-content-click":!1,"nudge-right":0,transition:"scale-transition","offset-y":"","min-width":"auto"},scopedSlots:t._u([{key:"activator",fn:function(e){var a=e.on,s=e.attrs;return[n("v-text-field",t._g(t._b({attrs:{dense:"",outlined:"","hide-details":"",autocomplete:"off"},on:{change:t.getPayments},model:{value:t.payment.date,callback:function(e){t.$set(t.payment,"date",e)},expression:"payment.date"}},"v-text-field",s,!1),a),[n("v-icon",{attrs:{slot:"prepend-inner"},slot:"prepend-inner"},[t._v("mdi-calendar-month")])],1)]}}]),model:{value:t.menu,callback:function(e){t.menu=e},expression:"menu"}},[n("v-date-picker",{on:{input:function(e){t.menu=!1},change:t.getPayments},model:{value:t.payment.date,callback:function(e){t.$set(t.payment,"date",e)},expression:"payment.date"}})],1)],1)],1),n("v-row",{staticClass:"mb-1",attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Payment Amount")]),n("v-col",{attrs:{cols:"8"}},[n("v-text-field",{attrs:{dense:"",outlined:"","hide-details":"",rules:[function(t){return!!t}]},model:{value:t.payment.amount,callback:function(e){t.$set(t.payment,"amount",t._n(e))},expression:"payment.amount"}})],1)],1),n("v-row",{attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}},[t._v("Description ")]),n("v-col",{attrs:{cols:"8"}},[n("v-text-field",{attrs:{dense:"",outlined:"","hide-details":""},model:{value:t.payment.note,callback:function(e){t.$set(t.payment,"note",e)},expression:"payment.note"}})],1)],1),n("v-row",{attrs:{"no-gutters":""}},[n("v-col",{attrs:{cols:"4"}}),n("v-col",{attrs:{cols:"8"}},[n("v-row",{attrs:{dense:""}},[n("v-col",{attrs:{cols:"6"}},[n("v-btn",{attrs:{type:"submit",loading:t.loading,block:"",color:"text_bg_fave"}},[t._v("Save")])],1),n("v-col",{attrs:{cols:"6"}},[n("v-btn",{attrs:{dark:"",block:"",color:"deep-orange"},on:{click:t.resetForm}},[t._v("Clear")])],1)],1)],1)],1)],1)],1)],1)],1)],1)],1)],1)],1)],1),n("v-row",{staticClass:"mt-1"},[n("v-col",{staticClass:"pb-0",attrs:{cols:"12"}},[n("v-data-table",{staticClass:"custom-data-table shadow1 white rounded px-4 py-4",attrs:{headers:t.salaryPaymentHeaders,loading:t.$store.getters["salaryPayment/loading"],items:t.$store.getters["salaryPayment/payments"],search:t.searchSalaryPayments},scopedSlots:t._u([{key:"top",fn:function(){return[n("v-toolbar",{staticStyle:{"border-bottom":"1px solid #ddd !important","margin-bottom":"20px"},attrs:{dense:"",color:"white",elevation:0}},[n("v-toolbar-title",{staticClass:"subtitle-2"},[t._v("Salary Payment List")]),n("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),n("v-form",{staticClass:"custom-form"},[n("v-text-field",{staticStyle:{width:"300px"},attrs:{outlined:"",dense:"","hide-details":"",placeholder:"Search Salary Payments","append-icon":"mdi-magnify"},model:{value:t.searchSalaryPayments,callback:function(e){t.searchSalaryPayments=e},expression:"searchSalaryPayments"}})],1)],1)]},proxy:!0},{key:"item.action",fn:function(e){var a=e.item;return[n("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(e){var s=e.on;return[n("v-icon",t._g({attrs:{small:"",color:"primary"},on:{click:function(e){return t.editSalaryPayment(a)}}},s),[t._v("mdi-circle-edit-outline")])]}}],null,!0)},[n("span",[t._v("Edit")])]),n("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(e){var s=e.on;return[n("v-icon",t._g({attrs:{small:"",color:"error"},on:{click:function(e){t.paymentId=a.id,t.$refs.confirmDialog.dialog=!0}}},s),[t._v("mdi-delete-circle-outline")])]}}],null,!0)},[n("span",[t._v("Delete")])])]}}],null,!0)})],1)],1),n("delete-confirm",{ref:"confirmDialog",on:{confirm:t.deleteSalaryPayment}})],1)},s=[],i=(n("99af"),n("4160"),n("b0c0"),n("b64b"),n("159b"),n("96cf"),n("1da1")),o=n("b49a"),r={name:"SalaryPayment",components:{"delete-confirm":o["a"]},data:function(){return{menu:!1,searchSalaryPayments:"",salaryPaymentHeaders:[{text:"Date",value:"date"},{text:"Employee Id",value:"employee.emp_id"},{text:"Employee Name",value:"employee.name"},{text:"Month",value:"month.name"},{text:"Payment Amount",value:"amount"},{text:"Description ",value:"note"},{text:"Action ",value:"action"}],payment:{id:null,type:"",employee_id:null,month_id:null,date:(new Date).toISOString().substr(0,10),amount:0,note:""},selectedEmployee:null,selectedMonth:null,paymentId:null,bank:null,paymentTotal:0,loading:!1}},watch:{selectedEmployee:function(t){var e=this;return Object(i["a"])(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:if(void 0!=t){n.next=2;break}return n.abrupt("return");case 2:return e.payment.employee_id=t.id,n.next=5,e.getPaymentSalary();case 5:case"end":return n.stop()}}),n)})))()},selectedMonth:function(t){var e=this;return Object(i["a"])(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:if(void 0!=t){n.next=2;break}return n.abrupt("return");case 2:if(e.payment.month_id=t.id,null!=e.selectedEmployee){n.next=6;break}return e.$store.dispatch("snackbar/error","Select an employee"),n.abrupt("return");case 6:return n.next=8,e.getPaymentSalary();case 8:case"end":return n.stop()}}),n)})))()},bank:function(t){void 0!=t&&(this.payment.account_id=t.id)}},created:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.getPayments();case 2:case"end":return e.stop()}}),e)})))()},methods:{getPayments:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n={dateFrom:t.payment.date,dateTo:t.payment.date},e.next=3,t.$store.dispatch("salaryPayment/getPayments",n);case 3:case"end":return e.stop()}}),e)})))()},getPaymentSalary:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(null==t.selectedEmployee||null==t.selectedMonth){e.next=5;break}return n={employeeId:t.selectedEmployee.id,monthId:t.selectedMonth.id},e.next=4,t.$store.dispatch("salaryPayment/getSalaryDue",n);case 4:t.paymentTotal=t.$store.getters["salaryPayment/paymentTotal"];case 5:case"end":return e.stop()}}),e)})))()},saveSalaryPayment:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){var n,a;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(n=t.$refs.salaryPaymentForm.validate(),n){e.next=3;break}return e.abrupt("return");case 3:if(""!=t.payment.type){e.next=6;break}return t.$store.dispatch("snackbar/error","Select a payment type"),e.abrupt("return");case 6:if("Bank"!=t.payment.type||null!=t.bank){e.next=9;break}return t.$store.dispatch("snackbar/error","Select a bank"),e.abrupt("return");case 9:if(null!=t.selectedEmployee){e.next=12;break}return t.$store.dispatch("snackbar/error","Select an employee"),e.abrupt("return");case 12:if(null!=t.selectedMonth){e.next=15;break}return t.$store.dispatch("snackbar/error","Select a month"),e.abrupt("return");case 15:if(0!=t.payment.amount&&null!=t.payment.amount){e.next=18;break}return t.$store.dispatch("snackbar/error","Amount is required"),e.abrupt("return");case 18:if(!(t.payment.amount>+t.paymentTotal)){e.next=21;break}return t.$store.dispatch("snackbar/error","Payment amount to much hight"),e.abrupt("return");case 21:return t.loading=!0,e.next=24,t.$store.dispatch("salaryPayment/saveSalaryPayment",t.payment);case 24:if(a=e.sent,!a){e.next=29;break}return e.next=28,t.getPayments();case 28:t.resetForm();case 29:t.loading=!1;case 30:case"end":return e.stop()}}),e)})))()},editSalaryPayment:function(t){var e=this;Object.keys(this.payment).forEach((function(n){e.payment[n]=t[n]})),this.selectedEmployee=t.employee,this.selectedEmployee.display_text="".concat(t.employee.emp_id," - ").concat(t.employee.name),this.selectedMonth=t.month,null!=t.bank_account&&(this.bank=t.bank_account,this.bank.display_text="".concat(t.bank_account.account_name," - ").concat(t.bank_account.account_number," - ").concat(t.bank_account.bank_name))},deleteSalaryPayment:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return t.$store.dispatch("salaryPayment/deleteSalaryPayment",t.paymentId),t.$refs.confirmDialog.dialog=!1,e.next=4,t.getPayments();case 4:case"end":return e.stop()}}),e)})))()},resetForm:function(){this.payment.id=null,this.payment.amount=0,this.payment.date=(new Date).toISOString().substr(0,10),this.payment.note="",this.selectedEmployee=null,this.selectedMonth=null,this.$refs.salaryPaymentForm.resetValidation(),this.paymentTotal=0}}},l=r,c=(n("5778"),n("2877")),u=n("6544"),h=n.n(u),d=n("8336"),m=n("b0af"),p=n("99d9"),f=n("62ad"),v=n("2b5d"),y=n("a523"),g=n("8fea"),b=n("2e4b"),x=n("ce7e"),I=n("4bd4"),S=n("132d"),k=n("e449"),w=n("0fd9"),C=n("8654"),D=n("71d9"),_=n("2a7f"),P=n("3a2f"),$=Object(c["a"])(l,a,s,!1,null,"ffa4cb6c",null);e["default"]=$.exports;h()($,{VBtn:d["a"],VCard:m["a"],VCardText:p["b"],VCol:f["a"],VCombobox:v["a"],VContainer:y["a"],VDataTable:g["a"],VDatePicker:b["a"],VDivider:x["a"],VForm:I["a"],VIcon:S["a"],VMenu:k["a"],VRow:w["a"],VTextField:C["a"],VToolbar:D["a"],VToolbarTitle:_["a"],VTooltip:P["a"]})},f1d3:function(t,e,n){}}]);
//# sourceMappingURL=salary-payment.ea0ba6aa.js.map