(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";
/*! ctxMenu v1.1.1 | (c) Nikolaj Kappler | https://github.com/nkappler/ctxmenu/blob/master/LICENSE !*/

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });

var ContextMenu = function () {
    function ContextMenu() {
        var _this = this;

        _classCallCheck(this, ContextMenu);

        this.cache = {};
        this.dir = "r";
        window.addEventListener("click", function () {
            return _this.closeMenu();
        });
        window.addEventListener("resize", function () {
            return _this.closeMenu();
        });
        window.addEventListener("scroll", function () {
            return _this.closeMenu();
        });
        ContextMenu.addStylesToDom();
    }

    ContextMenu.getInstance = function getInstance() {
        if (!ContextMenu.instance) {
            ContextMenu.instance = new ContextMenu();
        }
        return ContextMenu.instance;
    };

    ContextMenu.prototype.attach = function attach(target, ctxMenu) {
        var _this2 = this;

        var beforeRender = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function (m) {
            return m;
        };

        var t = document.querySelector(target);
        if (this.cache[target] !== undefined) {
            console.error("target element " + target + " already has a context menu assigned. Use ContextMenu.update() intstead.");
            return;
        }
        if (!t) {
            console.error("target element " + target + " not found");
            return;
        }
        var handler = function handler(e) {
            e.stopImmediatePropagation();
            _this2.closeMenu();
            _this2.dir = "r";
            var newMenu = beforeRender([].concat(ctxMenu), e);
            _this2.menu = _this2.generateDOM(newMenu, e);
            document.body.appendChild(_this2.menu);
            e.preventDefault();
        };
        this.cache[target] = {
            ctxmenu: ctxMenu,
            handler: handler,
            beforeRender: beforeRender
        };
        t.addEventListener("contextmenu", handler);
    };

    ContextMenu.prototype.update = function update(target, ctxMenu, beforeRender) {
        var o = this.cache[target];
        var t = document.querySelector(target);
        o && t && t.removeEventListener("contextmenu", o.handler);
        delete this.cache[target];
        this.attach(target, ctxMenu || o && o.ctxmenu || [], beforeRender || o && o.beforeRender);
    };

    ContextMenu.prototype.delete = function _delete(target) {
        var o = this.cache[target];
        if (!o) {
            console.error("no context menu for target element " + target + " found");
            return;
        }
        var t = document.querySelector(target);
        if (!t) {
            console.error("target element " + target + " does not exist (anymore)");
            return;
        }
        t.removeEventListener("contextmenu", o.handler);
        delete this.cache[target];
    };

    ContextMenu.prototype.closeMenu = function closeMenu() {
        var menu = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.menu;

        if (menu) {
            if (menu === this.menu) {
                delete this.menu;
            }
            var p = menu.parentElement;
            p && p.removeChild(menu);
        }
    };

    ContextMenu.prototype.debounce = function debounce(target, action) {
        var timeout = void 0;
        target.addEventListener("mouseenter", function (e) {
            timeout = setTimeout(function () {
                return action(e);
            }, 150);
        });
        target.addEventListener("mouseleave", function () {
            return clearTimeout(timeout);
        });
    };

    ContextMenu.prototype.generateDOM = function generateDOM(ctxMenu, parentOrEvent) {
        var _this3 = this;

        var container = document.createElement("ul");
        if (ctxMenu.length === 0) {
            container.style.display = "none";
        }
        ctxMenu.forEach(function (item) {
            var li = document.createElement("li");
            _this3.debounce(li, function () {
                var subMenu = li.parentElement && li.parentElement.querySelector("ul");
                if (subMenu && subMenu.parentElement !== li) {
                    _this3.closeMenu(subMenu);
                }
            });
            if (ContextMenu.itemIsDivider(item)) {
                li.className = "divider";
            } else {
                li.innerHTML = item.text;
                li.title = item.tooltip || "";
                if (ContextMenu.itemIsInteractive(item)) {
                    if (!item.disabled) {
                        li.className = "interactive";
                        if (ContextMenu.itemIsAction(item)) {
                            li.addEventListener("click", item.action);
                        } else if (ContextMenu.itemIsAnchor(item)) {
                            li.innerHTML = "<a href=\"" + item.href + "\" " + (item.target ? 'target="' + item.target + '"' : "") + ">" + item.text + "</a>";
                        } else {
                            if (item.subMenu.length === 0) {
                                li.className = "disabled submenu";
                            } else {
                                li.className = "interactive submenu";
                                _this3.debounce(li, function (ev) {
                                    var subMenu = li.querySelector("ul");
                                    if (!subMenu) {
                                        _this3.openSubMenu(ev, item.subMenu, li);
                                    }
                                });
                            }
                        }
                    } else {
                        li.className = "disabled";
                        if (ContextMenu.itemIsSubMenu(item)) {
                            li.className = "disabled submenu";
                        }
                    }
                } else {
                    li.style.fontWeight = "bold";
                    li.style.marginLeft = "-5px";
                }
            }
            container.appendChild(li);
        });
        container.style.position = "fixed";
        container.className = "ctxmenu";
        var rect = ContextMenu.getBounding(container);
        var pos = { x: 0, y: 0 };
        if (parentOrEvent instanceof Element) {
            var parentRect = parentOrEvent.getBoundingClientRect();
            pos = {
                x: this.dir === "r" ? parentRect.left + parentRect.width : parentRect.left - rect.width,
                y: parentRect.top - 4
            };
            if (pos.x !== this.getPosition(rect, pos).x) {
                this.dir = this.dir === "r" ? "l" : "r";
                pos.x = this.dir === "r" ? parentRect.left + parentRect.width : parentRect.left - rect.width;
            }
        } else {
            pos = this.getPosition(rect, { x: parentOrEvent.clientX, y: parentOrEvent.clientY });
        }
        container.style.left = pos.x + "px";
        container.style.top = pos.y + "px";
        container.addEventListener("contextmenu", function (ev) {
            ev.stopPropagation();
            ev.preventDefault();
        });
        container.addEventListener("click", function (ev) {
            var item = ev.target && ev.target.parentElement;
            if (item && item.className !== "interactive") {
                ev.stopPropagation();
            }
        });
        return container;
    };

    ContextMenu.prototype.openSubMenu = function openSubMenu(e, ctxMenu, listElement) {
        var subMenu = listElement.parentElement && listElement.parentElement.querySelector("li > ul");
        if (subMenu && subMenu.parentElement !== listElement) {
            this.closeMenu(subMenu);
        }
        listElement.appendChild(this.generateDOM(ctxMenu, listElement));
    };

    ContextMenu.getBounding = function getBounding(elem) {
        var container = elem.cloneNode(true);
        container.style.visibility = "hidden";
        document.body.appendChild(container);
        var result = container.getBoundingClientRect();
        document.body.removeChild(container);
        return result;
    };

    ContextMenu.prototype.getPosition = function getPosition(rect, pos) {
        return {
            x: this.dir === "r" ? pos.x + rect.width > window.innerWidth ? window.innerWidth - rect.width : pos.x : pos.x < 0 ? 0 : pos.x,
            y: pos.y + rect.height > window.innerHeight ? window.innerHeight - rect.height : pos.y
        };
    };

    ContextMenu.itemIsInteractive = function itemIsInteractive(item) {
        return this.itemIsAction(item) || this.itemIsAnchor(item) || this.itemIsSubMenu(item);
    };

    ContextMenu.itemIsAction = function itemIsAction(item) {
        return item.hasOwnProperty("action");
    };

    ContextMenu.itemIsAnchor = function itemIsAnchor(item) {
        return item.hasOwnProperty("href");
    };

    ContextMenu.itemIsDivider = function itemIsDivider(item) {
        return item.hasOwnProperty("isDivider");
    };

    ContextMenu.itemIsSubMenu = function itemIsSubMenu(item) {
        return item.hasOwnProperty("subMenu");
    };

    ContextMenu.addStylesToDom = function addStylesToDom() {
        var append = function append() {
            var styles = document.createElement("style");
            styles.innerHTML = ".ctxmenu{border:1px solid #999;padding:2px 0;box-shadow:3px 3px 3px #aaa;background:#fff;margin:0;font-size:15px;font-family:Verdana,sans-serif;z-index:9999}.ctxmenu li{margin:1px 0;display:block;position:relative}.ctxmenu li span,.ctxmenu li a{display:block;padding:2px 20px;cursor:default}.ctxmenu li a{color:inherit;text-decoration:none}.ctxmenu li.disabled{color:#ccc}.ctxmenu li.divider{border-bottom:1px solid #aaa;margin:5px 0}.ctxmenu li.interactive:hover{background:rgba(0,0,0,0.1)}.ctxmenu li.submenu::after{content:'>';position:absolute;display:block;top:0;right:0.3em;font-family:monospace;line-height:22px}";
            document.head.insertBefore(styles, document.head.childNodes[0]);
        };
        if (document.readyState === "interactive") {
            append();
        } else {
            document.addEventListener("readystatechange", function () {
                if (document.readyState === "interactive") {
                    append();
                }
            });
        }
    };

    return ContextMenu;
}();

exports.ctxmenu = ContextMenu.getInstance();
},{}],2:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var ctxmenu_1 = require("./ctxmenu");
window.ctxmenu = ctxmenu_1.ctxmenu;
},{"./ctxmenu":1}]},{},[2]);
