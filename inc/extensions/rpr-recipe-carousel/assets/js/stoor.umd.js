!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.Stoor=t()}(this,function(){var e={},t={getItem:function(t){return e[t]||null},setItem:function(t,r){return e[t]=r,!0},removeItem:function(t){return t in e&&delete e[t]},clear:function(){return e={},!0}},r=function(e){if("object"==typeof e)try{return e.setItem("localStorage",1),e.removeItem("localStorage"),!0}catch(e){return!1}return!1},n=function e(n){void 0===n&&(n={});var o=n.namespace;void 0===o&&(o="");var a=n.fallback;void 0===a&&(a=t);var i=n.storage;if(void 0===i&&(i="local"),!(this instanceof e))return new e({namespace:o,fallback:a,storage:i});if(!a.getItem||!a.setItem||!a.removeItem)throw new Error("Invalid fallback provided");this.storage="session"===i?r(window.sessionStorage)?window.sessionStorage:a:r(window.localStorage)?window.localStorage:a,this.namespace=o};return n.prototype.get=function(e,t){var r=this;if(void 0===t&&(t=null),Array.isArray(e))return e.map(function(e){return JSON.parse(r.storage.getItem(r.namespace+":"+e))});var n=this.namespace+":"+e;try{var o=JSON.parse(this.storage.getItem(n));return null!==o?o:t}catch(e){return t}},n.prototype.set=function(e,t){var r=this;return Array.isArray(e)?e.map(function(e){return r.storage.setItem(r.namespace+":"+e[0],JSON.stringify(e[1]))}):this.storage.setItem(this.namespace+":"+e,JSON.stringify(t))},n.prototype.remove=function(e){var t=this;return Array.isArray(e)?e.map(function(e){return t.storage.removeItem(t.namespace+":"+e)}):this.storage.removeItem(this.namespace+":"+e)},n.prototype.clear=function(){return this.storage.clear()},n});
