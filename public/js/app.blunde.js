/*!

Holder - client side image placeholders
Version 2.9.6+fblyy
© 2018 Ivan Malopinsky - http://imsky.co

Site:     http://holderjs.com
Issues:   https://github.com/imsky/holder/issues
License:  MIT

*/
(function (window) {
  if (!window.document) return;
  var document = window.document;

  //https://github.com/inexorabletash/polyfill/blob/master/web.js
    if (!document.querySelectorAll) {
      document.querySelectorAll = function (selectors) {
        var style = document.createElement('style'), elements = [], element;
        document.documentElement.firstChild.appendChild(style);
        document._qsa = [];

        style.styleSheet.cssText = selectors + '{x-qsa:expression(document._qsa && document._qsa.push(this))}';
        window.scrollBy(0, 0);
        style.parentNode.removeChild(style);

        while (document._qsa.length) {
          element = document._qsa.shift();
          element.style.removeAttribute('x-qsa');
          elements.push(element);
        }
        document._qsa = null;
        return elements;
      };
    }

    if (!document.querySelector) {
      document.querySelector = function (selectors) {
        var elements = document.querySelectorAll(selectors);
        return (elements.length) ? elements[0] : null;
      };
    }

    if (!document.getElementsByClassName) {
      document.getElementsByClassName = function (classNames) {
        classNames = String(classNames).replace(/^|\s+/g, '.');
        return document.querySelectorAll(classNames);
      };
    }

  //https://github.com/inexorabletash/polyfill
  // ES5 15.2.3.14 Object.keys ( O )
  // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Object/keys
  if (!Object.keys) {
    Object.keys = function (o) {
      if (o !== Object(o)) { throw TypeError('Object.keys called on non-object'); }
      var ret = [], p;
      for (p in o) {
        if (Object.prototype.hasOwnProperty.call(o, p)) {
          ret.push(p);
        }
      }
      return ret;
    };
  }

  // ES5 15.4.4.18 Array.prototype.forEach ( callbackfn [ , thisArg ] )
  // From https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/forEach
  if (!Array.prototype.forEach) {
    Array.prototype.forEach = function (fun /*, thisp */) {
      if (this === void 0 || this === null) { throw TypeError(); }

      var t = Object(this);
      var len = t.length >>> 0;
      if (typeof fun !== "function") { throw TypeError(); }

      var thisp = arguments[1], i;
      for (i = 0; i < len; i++) {
        if (i in t) {
          fun.call(thisp, t[i], i, t);
        }
      }
    };
  }

  //https://github.com/inexorabletash/polyfill/blob/master/web.js
  (function (global) {
    var B64_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    global.atob = global.atob || function (input) {
      input = String(input);
      var position = 0,
          output = [],
          buffer = 0, bits = 0, n;

      input = input.replace(/\s/g, '');
      if ((input.length % 4) === 0) { input = input.replace(/=+$/, ''); }
      if ((input.length % 4) === 1) { throw Error('InvalidCharacterError'); }
      if (/[^+/0-9A-Za-z]/.test(input)) { throw Error('InvalidCharacterError'); }

      while (position < input.length) {
        n = B64_ALPHABET.indexOf(input.charAt(position));
        buffer = (buffer << 6) | n;
        bits += 6;

        if (bits === 24) {
          output.push(String.fromCharCode((buffer >> 16) & 0xFF));
          output.push(String.fromCharCode((buffer >>  8) & 0xFF));
          output.push(String.fromCharCode(buffer & 0xFF));
          bits = 0;
          buffer = 0;
        }
        position += 1;
      }

      if (bits === 12) {
        buffer = buffer >> 4;
        output.push(String.fromCharCode(buffer & 0xFF));
      } else if (bits === 18) {
        buffer = buffer >> 2;
        output.push(String.fromCharCode((buffer >> 8) & 0xFF));
        output.push(String.fromCharCode(buffer & 0xFF));
      }

      return output.join('');
    };

    global.btoa = global.btoa || function (input) {
      input = String(input);
      var position = 0,
          out = [],
          o1, o2, o3,
          e1, e2, e3, e4;

      if (/[^\x00-\xFF]/.test(input)) { throw Error('InvalidCharacterError'); }

      while (position < input.length) {
        o1 = input.charCodeAt(position++);
        o2 = input.charCodeAt(position++);
        o3 = input.charCodeAt(position++);

        // 111111 112222 222233 333333
        e1 = o1 >> 2;
        e2 = ((o1 & 0x3) << 4) | (o2 >> 4);
        e3 = ((o2 & 0xf) << 2) | (o3 >> 6);
        e4 = o3 & 0x3f;

        if (position === input.length + 2) {
          e3 = 64; e4 = 64;
        }
        else if (position === input.length + 1) {
          e4 = 64;
        }

        out.push(B64_ALPHABET.charAt(e1),
                 B64_ALPHABET.charAt(e2),
                 B64_ALPHABET.charAt(e3),
                 B64_ALPHABET.charAt(e4));
      }

      return out.join('');
    };
  }(window));

  //https://gist.github.com/jimeh/332357
  if (!Object.prototype.hasOwnProperty){
      /*jshint -W001, -W103 */
      Object.prototype.hasOwnProperty = function(prop) {
      var proto = this.__proto__ || this.constructor.prototype;
      return (prop in this) && (!(prop in proto) || proto[prop] !== this[prop]);
    };
      /*jshint +W001, +W103 */
  }

  // @license http://opensource.org/licenses/MIT
  // copyright Paul Irish 2015


  // Date.now() is supported everywhere except IE8. For IE8 we use the Date.now polyfill
  //   github.com/Financial-Times/polyfill-service/blob/master/polyfills/Date.now/polyfill.js
  // as Safari 6 doesn't have support for NavigationTiming, we use a Date.now() timestamp for relative values

  // if you want values similar to what you'd get with real perf.now, place this towards the head of the page
  // but in reality, you're just getting the delta between now() calls, so it's not terribly important where it's placed


  (function(){

    if ('performance' in window === false) {
        window.performance = {};
    }
    
    Date.now = (Date.now || function () {  // thanks IE8
      return new Date().getTime();
    });

    if ('now' in window.performance === false){
      
      var nowOffset = Date.now();
      
      if (performance.timing && performance.timing.navigationStart){
        nowOffset = performance.timing.navigationStart;
      }

      window.performance.now = function now(){
        return Date.now() - nowOffset;
      };
    }

  })();

  //requestAnimationFrame polyfill for older Firefox/Chrome versions
  if (!window.requestAnimationFrame) {
    if (window.webkitRequestAnimationFrame && window.webkitCancelAnimationFrame) {
    //https://github.com/Financial-Times/polyfill-service/blob/master/polyfills/requestAnimationFrame/polyfill-webkit.js
    (function (global) {
      global.requestAnimationFrame = function (callback) {
        return webkitRequestAnimationFrame(function () {
          callback(global.performance.now());
        });
      };

      global.cancelAnimationFrame = global.webkitCancelAnimationFrame;
    }(window));
    } else if (window.mozRequestAnimationFrame && window.mozCancelAnimationFrame) {
      //https://github.com/Financial-Times/polyfill-service/blob/master/polyfills/requestAnimationFrame/polyfill-moz.js
    (function (global) {
      global.requestAnimationFrame = function (callback) {
        return mozRequestAnimationFrame(function () {
          callback(global.performance.now());
        });
      };

      global.cancelAnimationFrame = global.mozCancelAnimationFrame;
    }(window));
    } else {
    (function (global) {
      global.requestAnimationFrame = function (callback) {
        return global.setTimeout(callback, 1000 / 60);
      };

      global.cancelAnimationFrame = global.clearTimeout;
    })(window);
    }
  }
})(this);

(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["Holder"] = factory();
	else
		root["Holder"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	/*
	Holder.js - client side image placeholders
	(c) 2012-2015 Ivan Malopinsky - http://imsky.co
	*/

	module.exports = __webpack_require__(1);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(global) {/*
	Holder.js - client side image placeholders
	(c) 2012-2016 Ivan Malopinsky - http://imsky.co
	*/

	//Libraries and functions
	var onDomReady = __webpack_require__(2);
	var querystring = __webpack_require__(3);

	var SceneGraph = __webpack_require__(6);
	var utils = __webpack_require__(7);
	var SVG = __webpack_require__(8);
	var DOM = __webpack_require__(9);
	var Color = __webpack_require__(10);
	var constants = __webpack_require__(11);

	var svgRenderer = __webpack_require__(12);
	var sgCanvasRenderer = __webpack_require__(15);

	var extend = utils.extend;
	var dimensionCheck = utils.dimensionCheck;

	//Constants and definitions
	var SVG_NS = constants.svg_ns;

	var Holder = {
	    version: constants.version,

	    /**
	     * Adds a theme to default settings
	     *
	     * @param {string} name Theme name
	     * @param {Object} theme Theme object, with foreground, background, size, font, and fontweight properties.
	     */
	    addTheme: function(name, theme) {
	        name != null && theme != null && (App.settings.themes[name] = theme);
	        delete App.vars.cache.themeKeys;
	        return this;
	    },

	    /**
	     * Appends a placeholder to an element
	     *
	     * @param {string} src Placeholder URL string
	     * @param el A selector or a reference to a DOM node
	     */
	    addImage: function(src, el) {
	        //todo: use jquery fallback if available for all QSA references
	        var nodes = DOM.getNodeArray(el);
	        nodes.forEach(function (node) {
	            var img = DOM.newEl('img');
	            var domProps = {};
	            domProps[App.setup.dataAttr] = src;
	            DOM.setAttr(img, domProps);
	            node.appendChild(img);
	        });
	        return this;
	    },

	    /**
	     * Sets whether or not an image is updated on resize.
	     * If an image is set to be updated, it is immediately rendered.
	     *
	     * @param {Object} el Image DOM element
	     * @param {Boolean} value Resizable update flag value
	     */
	    setResizeUpdate: function(el, value) {
	        if (el.holderData) {
	            el.holderData.resizeUpdate = !!value;
	            if (el.holderData.resizeUpdate) {
	                updateResizableElements(el);
	            }
	        }
	    },

	    /**
	     * Runs Holder with options. By default runs Holder on all images with "holder.js" in their source attributes.
	     *
	     * @param {Object} userOptions Options object, can contain domain, themes, images, and bgnodes properties
	     */
	    run: function(userOptions) {
	        //todo: split processing into separate queues
	        userOptions = userOptions || {};
	        var engineSettings = {};
	        var options = extend(App.settings, userOptions);

	        App.vars.preempted = true;
	        App.vars.dataAttr = options.dataAttr || App.setup.dataAttr;

	        engineSettings.renderer = options.renderer ? options.renderer : App.setup.renderer;
	        if (App.setup.renderers.join(',').indexOf(engineSettings.renderer) === -1) {
	            engineSettings.renderer = App.setup.supportsSVG ? 'svg' : (App.setup.supportsCanvas ? 'canvas' : 'html');
	        }

	        var images = DOM.getNodeArray(options.images);
	        var bgnodes = DOM.getNodeArray(options.bgnodes);
	        var stylenodes = DOM.getNodeArray(options.stylenodes);
	        var objects = DOM.getNodeArray(options.objects);

	        engineSettings.stylesheets = [];
	        engineSettings.svgXMLStylesheet = true;
	        engineSettings.noFontFallback = !!options.noFontFallback;
	        engineSettings.noBackgroundSize = !!options.noBackgroundSize;

	        stylenodes.forEach(function (styleNode) {
	            if (styleNode.attributes.rel && styleNode.attributes.href && styleNode.attributes.rel.value == 'stylesheet') {
	                var href = styleNode.attributes.href.value;
	                //todo: write isomorphic relative-to-absolute URL function
	                var proxyLink = DOM.newEl('a');
	                proxyLink.href = href;
	                var stylesheetURL = proxyLink.protocol + '//' + proxyLink.host + proxyLink.pathname + proxyLink.search;
	                engineSettings.stylesheets.push(stylesheetURL);
	            }
	        });

	        bgnodes.forEach(function (bgNode) {
	            //Skip processing background nodes if getComputedStyle is unavailable, since only modern browsers would be able to use canvas or SVG to render to background
	            if (!global.getComputedStyle) return;
	            var backgroundImage = global.getComputedStyle(bgNode, null).getPropertyValue('background-image');
	            var dataBackgroundImage = bgNode.getAttribute('data-background-src');
	            var rawURL = dataBackgroundImage || backgroundImage;

	            var holderURL = null;
	            var holderString = options.domain + '/';
	            var holderStringIndex = rawURL.indexOf(holderString);

	            if (holderStringIndex === 0) {
	                holderURL = rawURL;
	            } else if (holderStringIndex === 1 && rawURL[0] === '?') {
	                holderURL = rawURL.slice(1);
	            } else {
	                var fragment = rawURL.substr(holderStringIndex).match(/([^\"]*)"?\)/);
	                if (fragment !== null) {
	                    holderURL = fragment[1];
	                } else if (rawURL.indexOf('url(') === 0) {
	                    throw 'Holder: unable to parse background URL: ' + rawURL;
	                }
	            }

	            if (holderURL) {
	                var holderFlags = parseURL(holderURL, options);
	                if (holderFlags) {
	                    prepareDOMElement({
	                        mode: 'background',
	                        el: bgNode,
	                        flags: holderFlags,
	                        engineSettings: engineSettings
	                    });
	                }
	            }
	        });

	        objects.forEach(function (object) {
	            var objectAttr = {};

	            try {
	                objectAttr.data = object.getAttribute('data');
	                objectAttr.dataSrc = object.getAttribute(App.vars.dataAttr);
	            } catch (e) {}

	            var objectHasSrcURL = objectAttr.data != null && objectAttr.data.indexOf(options.domain) === 0;
	            var objectHasDataSrcURL = objectAttr.dataSrc != null && objectAttr.dataSrc.indexOf(options.domain) === 0;

	            if (objectHasSrcURL) {
	                prepareImageElement(options, engineSettings, objectAttr.data, object);
	            } else if (objectHasDataSrcURL) {
	                prepareImageElement(options, engineSettings, objectAttr.dataSrc, object);
	            }
	        });

	        images.forEach(function (image) {
	            var imageAttr = {};

	            try {
	                imageAttr.src = image.getAttribute('src');
	                imageAttr.dataSrc = image.getAttribute(App.vars.dataAttr);
	                imageAttr.rendered = image.getAttribute('data-holder-rendered');
	            } catch (e) {}

	            var imageHasSrc = imageAttr.src != null;
	            var imageHasDataSrcURL = imageAttr.dataSrc != null && imageAttr.dataSrc.indexOf(options.domain) === 0;
	            var imageRendered = imageAttr.rendered != null && imageAttr.rendered == 'true';

	            if (imageHasSrc) {
	                if (imageAttr.src.indexOf(options.domain) === 0) {
	                    prepareImageElement(options, engineSettings, imageAttr.src, image);
	                } else if (imageHasDataSrcURL) {
	                    //Image has a valid data-src and an invalid src
	                    if (imageRendered) {
	                        //If the placeholder has already been render, re-render it
	                        prepareImageElement(options, engineSettings, imageAttr.dataSrc, image);
	                    } else {
	                        //If the placeholder has not been rendered, check if the image exists and render a fallback if it doesn't
	                        (function(src, options, engineSettings, dataSrc, image) {
	                            utils.imageExists(src, function(exists) {
	                                if (!exists) {
	                                    prepareImageElement(options, engineSettings, dataSrc, image);
	                                }
	                            });
	                        })(imageAttr.src, options, engineSettings, imageAttr.dataSrc, image);
	                    }
	                }
	            } else if (imageHasDataSrcURL) {
	                prepareImageElement(options, engineSettings, imageAttr.dataSrc, image);
	            }
	        });

	        return this;
	    }
	};

	var App = {
	    settings: {
	        domain: 'holder.js',
	        images: 'img',
	        objects: 'object',
	        bgnodes: 'body .holderjs',
	        stylenodes: 'head link.holderjs',
	        themes: {
	            'gray': {
	                bg: '#EEEEEE',
	                fg: '#AAAAAA'
	            },
	            'social': {
	                bg: '#3a5a97',
	                fg: '#FFFFFF'
	            },
	            'industrial': {
	                bg: '#434A52',
	                fg: '#C2F200'
	            },
	            'sky': {
	                bg: '#0D8FDB',
	                fg: '#FFFFFF'
	            },
	            'vine': {
	                bg: '#39DBAC',
	                fg: '#1E292C'
	            },
	            'lava': {
	                bg: '#F8591A',
	                fg: '#1C2846'
	            }
	        }
	    },
	    defaults: {
	        size: 10,
	        units: 'pt',
	        scale: 1 / 16
	    }
	};

	/**
	 * Processes provided source attribute and sets up the appropriate rendering workflow
	 *
	 * @private
	 * @param options Instance options from Holder.run
	 * @param renderSettings Instance configuration
	 * @param src Image URL
	 * @param el Image DOM element
	 */
	function prepareImageElement(options, engineSettings, src, el) {
	    var holderFlags = parseURL(src.substr(src.lastIndexOf(options.domain)), options);
	    if (holderFlags) {
	        prepareDOMElement({
	            mode: null,
	            el: el,
	            flags: holderFlags,
	            engineSettings: engineSettings
	        });
	    }
	}

	/**
	 * Processes a Holder URL and extracts configuration from query string
	 *
	 * @private
	 * @param url URL
	 * @param instanceOptions Instance options from Holder.run
	 */
	function parseURL(url, instanceOptions) {
	    var holder = {
	        theme: extend(App.settings.themes.gray, null),
	        stylesheets: instanceOptions.stylesheets,
	        instanceOptions: instanceOptions
	    };

	    var firstQuestionMark = url.indexOf('?');
	    var parts = [url];

	    if (firstQuestionMark !== -1) {
	        parts = [url.slice(0, firstQuestionMark), url.slice(firstQuestionMark + 1)];
	    }

	    var basics = parts[0].split('/');

	    holder.holderURL = url;

	    var dimensions = basics[1];
	    var dimensionData = dimensions.match(/([\d]+p?)x([\d]+p?)/);

	    if (!dimensionData) return false;

	    holder.fluid = dimensions.indexOf('p') !== -1;

	    holder.dimensions = {
	        width: dimensionData[1].replace('p', '%'),
	        height: dimensionData[2].replace('p', '%')
	    };

	    if (parts.length === 2) {
	        var options = querystring.parse(parts[1]);

	        // Dimensions

	        if (utils.truthy(options.ratio)) {
	            holder.fluid = true;
	            var ratioWidth = parseFloat(holder.dimensions.width.replace('%', ''));
	            var ratioHeight = parseFloat(holder.dimensions.height.replace('%', ''));

	            ratioHeight = Math.floor(100 * (ratioHeight / ratioWidth));
	            ratioWidth = 100;

	            holder.dimensions.width = ratioWidth + '%';
	            holder.dimensions.height = ratioHeight + '%';
	        }

	        holder.auto = utils.truthy(options.auto);

	        // Colors

	        if (options.bg) {
	            holder.theme.bg = utils.parseColor(options.bg);
	        }

	        if (options.fg) {
	            holder.theme.fg = utils.parseColor(options.fg);
	        }

	        //todo: add automatic foreground to themes without foreground
	        if (options.bg && !options.fg) {
	            holder.autoFg = true;
	        }

	        if (options.theme && holder.instanceOptions.themes.hasOwnProperty(options.theme)) {
	            holder.theme = extend(holder.instanceOptions.themes[options.theme], null);
	        }

	        // Text

	        if (options.text) {
	            holder.text = options.text;
	        }

	        if (options.textmode) {
	            holder.textmode = options.textmode;
	        }

	        if (options.size && parseFloat(options.size)) {
	            holder.size = parseFloat(options.size);
	        }

	        if (options.font) {
	            holder.font = options.font;
	        }

	        if (options.align) {
	            holder.align = options.align;
	        }

	        if (options.lineWrap) {
	            holder.lineWrap = options.lineWrap;
	        }

	        holder.nowrap = utils.truthy(options.nowrap);

	        // Miscellaneous

	        holder.outline = utils.truthy(options.outline);

	        if (utils.truthy(options.random)) {
	            App.vars.cache.themeKeys = App.vars.cache.themeKeys || Object.keys(holder.instanceOptions.themes);
	            var _theme = App.vars.cache.themeKeys[0 | Math.random() * App.vars.cache.themeKeys.length];
	            holder.theme = extend(holder.instanceOptions.themes[_theme], null);
	        }
	    }

	    return holder;
	}

	/**
	 * Modifies the DOM to fit placeholders and sets up resizable image callbacks (for fluid and automatically sized placeholders)
	 *
	 * @private
	 * @param settings DOM prep settings
	 */
	function prepareDOMElement(prepSettings) {
	    var mode = prepSettings.mode;
	    var el = prepSettings.el;
	    var flags = prepSettings.flags;
	    var _engineSettings = prepSettings.engineSettings;
	    var dimensions = flags.dimensions,
	        theme = flags.theme;
	    var dimensionsCaption = dimensions.width + 'x' + dimensions.height;
	    mode = mode == null ? (flags.fluid ? 'fluid' : 'image') : mode;
	    var holderTemplateRe = /holder_([a-z]+)/g;
	    var dimensionsInText = false;

	    if (flags.text != null) {
	        theme.text = flags.text;

	        //<object> SVG embedding doesn't parse Unicode properly
	        if (el.nodeName.toLowerCase() === 'object') {
	            var textLines = theme.text.split('\\n');
	            for (var k = 0; k < textLines.length; k++) {
	                textLines[k] = utils.encodeHtmlEntity(textLines[k]);
	            }
	            theme.text = textLines.join('\\n');
	        }
	    }

	    if (theme.text) {
	        var holderTemplateMatches = theme.text.match(holderTemplateRe);

	        if (holderTemplateMatches !== null) {
	            //todo: optimize template replacement
	            holderTemplateMatches.forEach(function (match) {
	                if (match === 'holder_dimensions') {
	                    theme.text = theme.text.replace(match, dimensionsCaption);
	                }
	            });
	        }
	    }

	    var holderURL = flags.holderURL;
	    var engineSettings = extend(_engineSettings, null);

	    if (flags.font) {
	        /*
	        If external fonts are used in a <img> placeholder rendered with SVG, Holder falls back to canvas.

	        This is done because Firefox and Chrome disallow embedded SVGs from referencing external assets.
	        The workaround is either to change the placeholder tag from <img> to <object> or to use the canvas renderer.
	        */
	        theme.font = flags.font;
	        if (!engineSettings.noFontFallback && el.nodeName.toLowerCase() === 'img' && App.setup.supportsCanvas && engineSettings.renderer === 'svg') {
	            engineSettings = extend(engineSettings, {
	                renderer: 'canvas'
	            });
	        }
	    }

	    //Chrome and Opera require a quick 10ms re-render if web fonts are used with canvas
	    if (flags.font && engineSettings.renderer == 'canvas') {
	        engineSettings.reRender = true;
	    }

	    if (mode == 'background') {
	        if (el.getAttribute('data-background-src') == null) {
	            DOM.setAttr(el, {
	                'data-background-src': holderURL
	            });
	        }
	    } else {
	        var domProps = {};
	        domProps[App.vars.dataAttr] = holderURL;
	        DOM.setAttr(el, domProps);
	    }

	    flags.theme = theme;

	    //todo consider using all renderSettings in holderData
	    el.holderData = {
	        flags: flags,
	        engineSettings: engineSettings
	    };

	    if (mode == 'image' || mode == 'fluid') {
	        DOM.setAttr(el, {
	            'alt': theme.text ? (dimensionsInText ? theme.text : theme.text + ' [' + dimensionsCaption + ']') : dimensionsCaption
	        });
	    }

	    var renderSettings = {
	        mode: mode,
	        el: el,
	        holderSettings: {
	            dimensions: dimensions,
	            theme: theme,
	            flags: flags
	        },
	        engineSettings: engineSettings
	    };

	    if (mode == 'image') {
	        if (!flags.auto) {
	            el.style.width = dimensions.width + 'px';
	            el.style.height = dimensions.height + 'px';
	        }

	        if (engineSettings.renderer == 'html') {
	            el.style.backgroundColor = theme.bg;
	        } else {
	            render(renderSettings);

	            if (flags.textmode == 'exact') {
	                el.holderData.resizeUpdate = true;
	                App.vars.resizableImages.push(el);
	                updateResizableElements(el);
	            }
	        }
	    } else if (mode == 'background' && engineSettings.renderer != 'html') {
	        render(renderSettings);
	    } else if (mode == 'fluid') {
	        el.holderData.resizeUpdate = true;

	        if (dimensions.height.slice(-1) == '%') {
	            el.style.height = dimensions.height;
	        } else if (flags.auto == null || !flags.auto) {
	            el.style.height = dimensions.height + 'px';
	        }
	        if (dimensions.width.slice(-1) == '%') {
	            el.style.width = dimensions.width;
	        } else if (flags.auto == null || !flags.auto) {
	            el.style.width = dimensions.width + 'px';
	        }
	        if (el.style.display == 'inline' || el.style.display === '' || el.style.display == 'none') {
	            el.style.display = 'block';
	        }

	        setInitialDimensions(el);

	        if (engineSettings.renderer == 'html') {
	            el.style.backgroundColor = theme.bg;
	        } else {
	            App.vars.resizableImages.push(el);
	            updateResizableElements(el);
	        }
	    }
	}

	/**
	 * Core function that takes output from renderers and sets it as the source or background-image of the target element
	 *
	 * @private
	 * @param renderSettings Renderer settings
	 */
	function render(renderSettings) {
	    var image = null;
	    var mode = renderSettings.mode;
	    var el = renderSettings.el;
	    var holderSettings = renderSettings.holderSettings;
	    var engineSettings = renderSettings.engineSettings;

	    switch (engineSettings.renderer) {
	        case 'svg':
	            if (!App.setup.supportsSVG) return;
	            break;
	        case 'canvas':
	            if (!App.setup.supportsCanvas) return;
	            break;
	        default:
	            return;
	    }

	    //todo: move generation of scene up to flag generation to reduce extra object creation
	    var scene = {
	        width: holderSettings.dimensions.width,
	        height: holderSettings.dimensions.height,
	        theme: holderSettings.theme,
	        flags: holderSettings.flags
	    };

	    var sceneGraph = buildSceneGraph(scene);

	    function getRenderedImage() {
	        var image = null;
	        switch (engineSettings.renderer) {
	            case 'canvas':
	                image = sgCanvasRenderer(sceneGraph, renderSettings);
	                break;
	            case 'svg':
	                image = svgRenderer(sceneGraph, renderSettings);
	                break;
	            default:
	                throw 'Holder: invalid renderer: ' + engineSettings.renderer;
	        }

	        return image;
	    }

	    image = getRenderedImage();

	    if (image == null) {
	        throw 'Holder: couldn\'t render placeholder';
	    }

	    //todo: add <object> canvas rendering
	    if (mode == 'background') {
	        el.style.backgroundImage = 'url(' + image + ')';

	        if (!engineSettings.noBackgroundSize) {
	            el.style.backgroundSize = scene.width + 'px ' + scene.height + 'px';
	        }
	    } else {
	        if (el.nodeName.toLowerCase() === 'img') {
	            DOM.setAttr(el, {
	                'src': image
	            });
	        } else if (el.nodeName.toLowerCase() === 'object') {
	            DOM.setAttr(el, {
	                'data': image,
	                'type': 'image/svg+xml'
	            });
	        }
	        if (engineSettings.reRender) {
	            global.setTimeout(function () {
	                var image = getRenderedImage();
	                if (image == null) {
	                    throw 'Holder: couldn\'t render placeholder';
	                }
	                //todo: refactor this code into a function
	                if (el.nodeName.toLowerCase() === 'img') {
	                    DOM.setAttr(el, {
	                        'src': image
	                    });
	                } else if (el.nodeName.toLowerCase() === 'object') {
	                    DOM.setAttr(el, {
	                        'data': image,
	                        'type': 'image/svg+xml'
	                    });
	                }
	            }, 150);
	        }
	    }
	    //todo: account for re-rendering
	    DOM.setAttr(el, {
	        'data-holder-rendered': true
	    });
	}

	/**
	 * Core function that takes a Holder scene description and builds a scene graph
	 *
	 * @private
	 * @param scene Holder scene object
	 */
	//todo: make this function reusable
	//todo: merge app defaults and setup properties into the scene argument
	function buildSceneGraph(scene) {
	    var fontSize = App.defaults.size;
	    if (parseFloat(scene.theme.size)) {
	        fontSize = scene.theme.size;
	    } else if (parseFloat(scene.flags.size)) {
	        fontSize = scene.flags.size;
	    }

	    scene.font = {
	        family: scene.theme.font ? scene.theme.font : 'Arial, Helvetica, Open Sans, sans-serif',
	        size: textSize(scene.width, scene.height, fontSize, App.defaults.scale),
	        units: scene.theme.units ? scene.theme.units : App.defaults.units,
	        weight: scene.theme.fontweight ? scene.theme.fontweight : 'bold'
	    };

	    scene.text = scene.theme.text || Math.floor(scene.width) + 'x' + Math.floor(scene.height);

	    scene.noWrap = scene.theme.nowrap || scene.flags.nowrap;

	    scene.align = scene.theme.align || scene.flags.align || 'center';

	    switch (scene.flags.textmode) {
	        case 'literal':
	            scene.text = scene.flags.dimensions.width + 'x' + scene.flags.dimensions.height;
	            break;
	        case 'exact':
	            if (!scene.flags.exactDimensions) break;
	            scene.text = Math.floor(scene.flags.exactDimensions.width) + 'x' + Math.floor(scene.flags.exactDimensions.height);
	            break;
	    }

	    var lineWrap = scene.flags.lineWrap || App.setup.lineWrapRatio;
	    var sceneMargin = scene.width * lineWrap;
	    var maxLineWidth = sceneMargin;

	    var sceneGraph = new SceneGraph({
	        width: scene.width,
	        height: scene.height
	    });

	    var Shape = sceneGraph.Shape;

	    var holderBg = new Shape.Rect('holderBg', {
	        fill: scene.theme.bg
	    });

	    holderBg.resize(scene.width, scene.height);
	    sceneGraph.root.add(holderBg);

	    if (scene.flags.outline) {
	        var outlineColor = new Color(holderBg.properties.fill);
	        outlineColor = outlineColor.lighten(outlineColor.lighterThan('7f7f7f') ? -0.1 : 0.1);
	        holderBg.properties.outline = {
	            fill: outlineColor.toHex(true),
	            width: 2
	        };
	    }

	    var holderTextColor = scene.theme.fg;

	    if (scene.flags.autoFg) {
	        var holderBgColor = new Color(holderBg.properties.fill);
	        var lightColor = new Color('fff');
	        var darkColor = new Color('000', {
	            'alpha': 0.285714
	        });

	        holderTextColor = holderBgColor.blendAlpha(holderBgColor.lighterThan('7f7f7f') ? darkColor : lightColor).toHex(true);
	    }

	    var holderTextGroup = new Shape.Group('holderTextGroup', {
	        text: scene.text,
	        align: scene.align,
	        font: scene.font,
	        fill: holderTextColor
	    });

	    holderTextGroup.moveTo(null, null, 1);
	    sceneGraph.root.add(holderTextGroup);

	    var tpdata = holderTextGroup.textPositionData = stagingRenderer(sceneGraph);
	    if (!tpdata) {
	        throw 'Holder: staging fallback not supported yet.';
	    }
	    holderTextGroup.properties.leading = tpdata.boundingBox.height;

	    var textNode = null;
	    var line = null;

	    function finalizeLine(parent, line, width, height) {
	        line.width = width;
	        line.height = height;
	        parent.width = Math.max(parent.width, line.width);
	        parent.height += line.height;
	    }

	    if (tpdata.lineCount > 1) {
	        var offsetX = 0;
	        var offsetY = 0;
	        var lineIndex = 0;
	        var lineKey;
	        line = new Shape.Group('line' + lineIndex);

	        //Double margin so that left/right-aligned next is not flush with edge of image
	        if (scene.align === 'left' || scene.align === 'right') {
	            maxLineWidth = scene.width * (1 - (1 - lineWrap) * 2);
	        }

	        for (var i = 0; i < tpdata.words.length; i++) {
	            var word = tpdata.words[i];
	            textNode = new Shape.Text(word.text);
	            var newline = word.text == '\\n';
	            if (!scene.noWrap && (offsetX + word.width >= maxLineWidth || newline === true)) {
	                finalizeLine(holderTextGroup, line, offsetX, holderTextGroup.properties.leading);
	                holderTextGroup.add(line);
	                offsetX = 0;
	                offsetY += holderTextGroup.properties.leading;
	                lineIndex += 1;
	                line = new Shape.Group('line' + lineIndex);
	                line.y = offsetY;
	            }
	            if (newline === true) {
	                continue;
	            }
	            textNode.moveTo(offsetX, 0);
	            offsetX += tpdata.spaceWidth + word.width;
	            line.add(textNode);
	        }

	        finalizeLine(holderTextGroup, line, offsetX, holderTextGroup.properties.leading);
	        holderTextGroup.add(line);

	        if (scene.align === 'left') {
	            holderTextGroup.moveTo(scene.width - sceneMargin, null, null);
	        } else if (scene.align === 'right') {
	            for (lineKey in holderTextGroup.children) {
	                line = holderTextGroup.children[lineKey];
	                line.moveTo(scene.width - line.width, null, null);
	            }

	            holderTextGroup.moveTo(0 - (scene.width - sceneMargin), null, null);
	        } else {
	            for (lineKey in holderTextGroup.children) {
	                line = holderTextGroup.children[lineKey];
	                line.moveTo((holderTextGroup.width - line.width) / 2, null, null);
	            }

	            holderTextGroup.moveTo((scene.width - holderTextGroup.width) / 2, null, null);
	        }

	        holderTextGroup.moveTo(null, (scene.height - holderTextGroup.height) / 2, null);

	        //If the text exceeds vertical space, move it down so the first line is visible
	        if ((scene.height - holderTextGroup.height) / 2 < 0) {
	            holderTextGroup.moveTo(null, 0, null);
	        }
	    } else {
	        textNode = new Shape.Text(scene.text);
	        line = new Shape.Group('line0');
	        line.add(textNode);
	        holderTextGroup.add(line);

	        if (scene.align === 'left') {
	            holderTextGroup.moveTo(scene.width - sceneMargin, null, null);
	        } else if (scene.align === 'right') {
	            holderTextGroup.moveTo(0 - (scene.width - sceneMargin), null, null);
	        } else {
	            holderTextGroup.moveTo((scene.width - tpdata.boundingBox.width) / 2, null, null);
	        }

	        holderTextGroup.moveTo(null, (scene.height - tpdata.boundingBox.height) / 2, null);
	    }

	    //todo: renderlist
	    return sceneGraph;
	}

	/**
	 * Adaptive text sizing function
	 *
	 * @private
	 * @param width Parent width
	 * @param height Parent height
	 * @param fontSize Requested text size
	 * @param scale Proportional scale of text
	 */
	function textSize(width, height, fontSize, scale) {
	    var stageWidth = parseInt(width, 10);
	    var stageHeight = parseInt(height, 10);

	    var bigSide = Math.max(stageWidth, stageHeight);
	    var smallSide = Math.min(stageWidth, stageHeight);

	    var newHeight = 0.8 * Math.min(smallSide, bigSide * scale);
	    return Math.round(Math.max(fontSize, newHeight));
	}

	/**
	 * Iterates over resizable (fluid or auto) placeholders and renders them
	 *
	 * @private
	 * @param element Optional element selector, specified only if a specific element needs to be re-rendered
	 */
	function updateResizableElements(element) {
	    var images;
	    if (element == null || element.nodeType == null) {
	        images = App.vars.resizableImages;
	    } else {
	        images = [element];
	    }
	    for (var i = 0, l = images.length; i < l; i++) {
	        var el = images[i];
	        if (el.holderData) {
	            var flags = el.holderData.flags;
	            var dimensions = dimensionCheck(el);
	            if (dimensions) {
	                if (!el.holderData.resizeUpdate) {
	                    continue;
	                }

	                if (flags.fluid && flags.auto) {
	                    var fluidConfig = el.holderData.fluidConfig;
	                    switch (fluidConfig.mode) {
	                        case 'width':
	                            dimensions.height = dimensions.width / fluidConfig.ratio;
	                            break;
	                        case 'height':
	                            dimensions.width = dimensions.height * fluidConfig.ratio;
	                            break;
	                    }
	                }

	                var settings = {
	                    mode: 'image',
	                    holderSettings: {
	                        dimensions: dimensions,
	                        theme: flags.theme,
	                        flags: flags
	                    },
	                    el: el,
	                    engineSettings: el.holderData.engineSettings
	                };

	                if (flags.textmode == 'exact') {
	                    flags.exactDimensions = dimensions;
	                    settings.holderSettings.dimensions = flags.dimensions;
	                }

	                render(settings);
	            } else {
	                setInvisible(el);
	            }
	        }
	    }
	}

	/**
	 * Sets up aspect ratio metadata for fluid placeholders, in order to preserve proportions when resizing
	 *
	 * @private
	 * @param el Image DOM element
	 */
	function setInitialDimensions(el) {
	    if (el.holderData) {
	        var dimensions = dimensionCheck(el);
	        if (dimensions) {
	            var flags = el.holderData.flags;

	            var fluidConfig = {
	                fluidHeight: flags.dimensions.height.slice(-1) == '%',
	                fluidWidth: flags.dimensions.width.slice(-1) == '%',
	                mode: null,
	                initialDimensions: dimensions
	            };

	            if (fluidConfig.fluidWidth && !fluidConfig.fluidHeight) {
	                fluidConfig.mode = 'width';
	                fluidConfig.ratio = fluidConfig.initialDimensions.width / parseFloat(flags.dimensions.height);
	            } else if (!fluidConfig.fluidWidth && fluidConfig.fluidHeight) {
	                fluidConfig.mode = 'height';
	                fluidConfig.ratio = parseFloat(flags.dimensions.width) / fluidConfig.initialDimensions.height;
	            }

	            el.holderData.fluidConfig = fluidConfig;
	        } else {
	            setInvisible(el);
	        }
	    }
	}

	/**
	 * Iterates through all current invisible images, and if they're visible, renders them and removes them from further checks. Runs every animation frame.
	 *
	 * @private
	 */
	function visibilityCheck() {
	    var renderableImages = [];
	    var keys = Object.keys(App.vars.invisibleImages);
	    var el;

	    keys.forEach(function (key) {
	        el = App.vars.invisibleImages[key];
	        if (dimensionCheck(el) && el.nodeName.toLowerCase() == 'img') {
	            renderableImages.push(el);
	            delete App.vars.invisibleImages[key];
	        }
	    });

	    if (renderableImages.length) {
	        Holder.run({
	            images: renderableImages
	        });
	    }

	    // Done to prevent 100% CPU usage via aggressive calling of requestAnimationFrame
	    setTimeout(function () {
	        global.requestAnimationFrame(visibilityCheck);
	    }, 10);
	}

	/**
	 * Starts checking for invisible placeholders if not doing so yet. Does nothing otherwise.
	 *
	 * @private
	 */
	function startVisibilityCheck() {
	    if (!App.vars.visibilityCheckStarted) {
	        global.requestAnimationFrame(visibilityCheck);
	        App.vars.visibilityCheckStarted = true;
	    }
	}

	/**
	 * Sets a unique ID for an image detected to be invisible and adds it to the map of invisible images checked by visibilityCheck
	 *
	 * @private
	 * @param el Invisible DOM element
	 */
	function setInvisible(el) {
	    if (!el.holderData.invisibleId) {
	        App.vars.invisibleId += 1;
	        App.vars.invisibleImages['i' + App.vars.invisibleId] = el;
	        el.holderData.invisibleId = App.vars.invisibleId;
	    }
	}

	//todo: see if possible to convert stagingRenderer to use HTML only
	var stagingRenderer = (function() {
	    var svg = null,
	        stagingText = null,
	        stagingTextNode = null;
	    return function(graph) {
	        var rootNode = graph.root;
	        if (App.setup.supportsSVG) {
	            var firstTimeSetup = false;
	            var tnode = function(text) {
	                return document.createTextNode(text);
	            };
	            if (svg == null || svg.parentNode !== document.body) {
	                firstTimeSetup = true;
	            }

	            svg = SVG.initSVG(svg, rootNode.properties.width, rootNode.properties.height);
	            //Show staging element before staging
	            svg.style.display = 'block';

	            if (firstTimeSetup) {
	                stagingText = DOM.newEl('text', SVG_NS);
	                stagingTextNode = tnode(null);
	                DOM.setAttr(stagingText, {
	                    x: 0
	                });
	                stagingText.appendChild(stagingTextNode);
	                svg.appendChild(stagingText);
	                document.body.appendChild(svg);
	                svg.style.visibility = 'hidden';
	                svg.style.position = 'absolute';
	                svg.style.top = '-100%';
	                svg.style.left = '-100%';
	                //todo: workaround for zero-dimension <svg> tag in Opera 12
	                //svg.setAttribute('width', 0);
	                //svg.setAttribute('height', 0);
	            }

	            var holderTextGroup = rootNode.children.holderTextGroup;
	            var htgProps = holderTextGroup.properties;
	            DOM.setAttr(stagingText, {
	                'y': htgProps.font.size,
	                'style': utils.cssProps({
	                    'font-weight': htgProps.font.weight,
	                    'font-size': htgProps.font.size + htgProps.font.units,
	                    'font-family': htgProps.font.family
	                })
	            });

	            //Unescape HTML entities to get approximately the right width
	            var txt = DOM.newEl('textarea');
	            txt.innerHTML = htgProps.text;
	            stagingTextNode.nodeValue = txt.value;

	            //Get bounding box for the whole string (total width and height)
	            var stagingTextBBox = stagingText.getBBox();

	            //Get line count and split the string into words
	            var lineCount = Math.ceil(stagingTextBBox.width / rootNode.properties.width);
	            var words = htgProps.text.split(' ');
	            var newlines = htgProps.text.match(/\\n/g);
	            lineCount += newlines == null ? 0 : newlines.length;

	            //Get bounding box for the string with spaces removed
	            stagingTextNode.nodeValue = htgProps.text.replace(/[ ]+/g, '');
	            var computedNoSpaceLength = stagingText.getComputedTextLength();

	            //Compute average space width
	            var diffLength = stagingTextBBox.width - computedNoSpaceLength;
	            var spaceWidth = Math.round(diffLength / Math.max(1, words.length - 1));

	            //Get widths for every word with space only if there is more than one line
	            var wordWidths = [];
	            if (lineCount > 1) {
	                stagingTextNode.nodeValue = '';
	                for (var i = 0; i < words.length; i++) {
	                    if (words[i].length === 0) continue;
	                    stagingTextNode.nodeValue = utils.decodeHtmlEntity(words[i]);
	                    var bbox = stagingText.getBBox();
	                    wordWidths.push({
	                        text: words[i],
	                        width: bbox.width
	                    });
	                }
	            }

	            //Hide staging element after staging
	            svg.style.display = 'none';

	            return {
	                spaceWidth: spaceWidth,
	                lineCount: lineCount,
	                boundingBox: stagingTextBBox,
	                words: wordWidths
	            };
	        } else {
	            //todo: canvas fallback for measuring text on android 2.3
	            return false;
	        }
	    };
	})();

	//Helpers

	/**
	 * Prevents a function from being called too often, waits until a timer elapses to call it again
	 *
	 * @param fn Function to call
	 */
	function debounce(fn) {
	    if (!App.vars.debounceTimer) fn.call(this);
	    if (App.vars.debounceTimer) global.clearTimeout(App.vars.debounceTimer);
	    App.vars.debounceTimer = global.setTimeout(function() {
	        App.vars.debounceTimer = null;
	        fn.call(this);
	    }, App.setup.debounce);
	}

	/**
	 * Holder-specific resize/orientation change callback, debounced to prevent excessive execution
	 */
	function resizeEvent() {
	    debounce(function() {
	        updateResizableElements(null);
	    });
	}

	//Set up flags

	for (var flag in App.flags) {
	    if (!App.flags.hasOwnProperty(flag)) continue;
	    App.flags[flag].match = function(val) {
	        return val.match(this.regex);
	    };
	}

	//Properties set once on setup

	App.setup = {
	    renderer: 'html',
	    debounce: 100,
	    ratio: 1,
	    supportsCanvas: false,
	    supportsSVG: false,
	    lineWrapRatio: 0.9,
	    dataAttr: 'data-src',
	    renderers: ['html', 'canvas', 'svg']
	};

	//Properties modified during runtime

	App.vars = {
	    preempted: false,
	    resizableImages: [],
	    invisibleImages: {},
	    invisibleId: 0,
	    visibilityCheckStarted: false,
	    debounceTimer: null,
	    cache: {}
	};

	//Pre-flight

	(function() {
	    var canvas = DOM.newEl('canvas');

	    if (canvas.getContext) {
	        if (canvas.toDataURL('image/png').indexOf('data:image/png') != -1) {
	            App.setup.renderer = 'canvas';
	            App.setup.supportsCanvas = true;
	        }
	    }

	    if (!!document.createElementNS && !!document.createElementNS(SVG_NS, 'svg').createSVGRect) {
	        App.setup.renderer = 'svg';
	        App.setup.supportsSVG = true;
	    }
	})();

	//Starts checking for invisible placeholders
	startVisibilityCheck();

	if (onDomReady) {
	    onDomReady(function() {
	        if (!App.vars.preempted) {
	            Holder.run();
	        }
	        if (global.addEventListener) {
	            global.addEventListener('resize', resizeEvent, false);
	            global.addEventListener('orientationchange', resizeEvent, false);
	        } else {
	            global.attachEvent('onresize', resizeEvent);
	        }

	        if (typeof global.Turbolinks == 'object') {
	            global.document.addEventListener('page:change', function() {
	                Holder.run();
	            });
	        }
	    });
	}

	module.exports = Holder;

	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 2 */
/***/ (function(module, exports) {

	/*!
	 * onDomReady.js 1.4.0 (c) 2013 Tubal Martin - MIT license
	 *
	 * Specially modified to work with Holder.js
	 */

	function _onDomReady(win) {
	    //Lazy loading fix for Firefox < 3.6
	    //http://webreflection.blogspot.com/2009/11/195-chars-to-help-lazy-loading.html
	    if (document.readyState == null && document.addEventListener) {
	        document.addEventListener("DOMContentLoaded", function DOMContentLoaded() {
	            document.removeEventListener("DOMContentLoaded", DOMContentLoaded, false);
	            document.readyState = "complete";
	        }, false);
	        document.readyState = "loading";
	    }
	    
	    var doc = win.document,
	        docElem = doc.documentElement,
	    
	        LOAD = "load",
	        FALSE = false,
	        ONLOAD = "on"+LOAD,
	        COMPLETE = "complete",
	        READYSTATE = "readyState",
	        ATTACHEVENT = "attachEvent",
	        DETACHEVENT = "detachEvent",
	        ADDEVENTLISTENER = "addEventListener",
	        DOMCONTENTLOADED = "DOMContentLoaded",
	        ONREADYSTATECHANGE = "onreadystatechange",
	        REMOVEEVENTLISTENER = "removeEventListener",
	    
	        // W3C Event model
	        w3c = ADDEVENTLISTENER in doc,
	        _top = FALSE,
	    
	        // isReady: Is the DOM ready to be used? Set to true once it occurs.
	        isReady = FALSE,
	    
	        // Callbacks pending execution until DOM is ready
	        callbacks = [];
	    
	    // Handle when the DOM is ready
	    function ready( fn ) {
	        if ( !isReady ) {
	    
	            // Make sure body exists, at least, in case IE gets a little overzealous (ticket #5443).
	            if ( !doc.body ) {
	                return defer( ready );
	            }
	    
	            // Remember that the DOM is ready
	            isReady = true;
	    
	            // Execute all callbacks
	            while ( fn = callbacks.shift() ) {
	                defer( fn );
	            }
	        }
	    }
	    
	    // The ready event handler
	    function completed( event ) {
	        // readyState === "complete" is good enough for us to call the dom ready in oldIE
	        if ( w3c || event.type === LOAD || doc[READYSTATE] === COMPLETE ) {
	            detach();
	            ready();
	        }
	    }
	    
	    // Clean-up method for dom ready events
	    function detach() {
	        if ( w3c ) {
	            doc[REMOVEEVENTLISTENER]( DOMCONTENTLOADED, completed, FALSE );
	            win[REMOVEEVENTLISTENER]( LOAD, completed, FALSE );
	        } else {
	            doc[DETACHEVENT]( ONREADYSTATECHANGE, completed );
	            win[DETACHEVENT]( ONLOAD, completed );
	        }
	    }
	    
	    // Defers a function, scheduling it to run after the current call stack has cleared.
	    function defer( fn, wait ) {
	        // Allow 0 to be passed
	        setTimeout( fn, +wait >= 0 ? wait : 1 );
	    }
	    
	    // Attach the listeners:
	    
	    // Catch cases where onDomReady is called after the browser event has already occurred.
	    // we once tried to use readyState "interactive" here, but it caused issues like the one
	    // discovered by ChrisS here: http://bugs.jquery.com/ticket/12282#comment:15
	    if ( doc[READYSTATE] === COMPLETE ) {
	        // Handle it asynchronously to allow scripts the opportunity to delay ready
	        defer( ready );
	    
	    // Standards-based browsers support DOMContentLoaded
	    } else if ( w3c ) {
	        // Use the handy event callback
	        doc[ADDEVENTLISTENER]( DOMCONTENTLOADED, completed, FALSE );
	    
	        // A fallback to window.onload, that will always work
	        win[ADDEVENTLISTENER]( LOAD, completed, FALSE );
	    
	    // If IE event model is used
	    } else {
	        // Ensure firing before onload, maybe late but safe also for iframes
	        doc[ATTACHEVENT]( ONREADYSTATECHANGE, completed );
	    
	        // A fallback to window.onload, that will always work
	        win[ATTACHEVENT]( ONLOAD, completed );
	    
	        // If IE and not a frame
	        // continually check to see if the document is ready
	        try {
	            _top = win.frameElement == null && docElem;
	        } catch(e) {}
	    
	        if ( _top && _top.doScroll ) {
	            (function doScrollCheck() {
	                if ( !isReady ) {
	                    try {
	                        // Use the trick by Diego Perini
	                        // http://javascript.nwbox.com/IEContentLoaded/
	                        _top.doScroll("left");
	                    } catch(e) {
	                        return defer( doScrollCheck, 50 );
	                    }
	    
	                    // detach all dom ready events
	                    detach();
	    
	                    // and execute any waiting functions
	                    ready();
	                }
	            })();
	        }
	    }
	    
	    function onDomReady( fn ) {
	        // If DOM is ready, execute the function (async), otherwise wait
	        isReady ? defer( fn ) : callbacks.push( fn );
	    }
	    
	    // Add version
	    onDomReady.version = "1.4.0";
	    // Add method to check if DOM is ready
	    onDomReady.isReady = function(){
	        return isReady;
	    };

	    return onDomReady;
	}

	module.exports = typeof window !== "undefined" && _onDomReady(window);

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

	//Modified version of component/querystring
	//Changes: updated dependencies, dot notation parsing, JSHint fixes
	//Fork at https://github.com/imsky/querystring

	/**
	 * Module dependencies.
	 */

	var encode = encodeURIComponent;
	var decode = decodeURIComponent;
	var trim = __webpack_require__(4);
	var type = __webpack_require__(5);

	var arrayRegex = /(\w+)\[(\d+)\]/;
	var objectRegex = /\w+\.\w+/;

	/**
	 * Parse the given query `str`.
	 *
	 * @param {String} str
	 * @return {Object}
	 * @api public
	 */

	exports.parse = function(str){
	  if ('string' !== typeof str) return {};

	  str = trim(str);
	  if ('' === str) return {};
	  if ('?' === str.charAt(0)) str = str.slice(1);

	  var obj = {};
	  var pairs = str.split('&');
	  for (var i = 0; i < pairs.length; i++) {
	    var parts = pairs[i].split('=');
	    var key = decode(parts[0]);
	    var m, ctx, prop;

	    if (m = arrayRegex.exec(key)) {
	      obj[m[1]] = obj[m[1]] || [];
	      obj[m[1]][m[2]] = decode(parts[1]);
	      continue;
	    }

	    if (m = objectRegex.test(key)) {
	      m = key.split('.');
	      ctx = obj;
	      
	      while (m.length) {
	        prop = m.shift();

	        if (!prop.length) continue;

	        if (!ctx[prop]) {
	          ctx[prop] = {};
	        } else if (ctx[prop] && typeof ctx[prop] !== 'object') {
	          break;
	        }

	        if (!m.length) {
	          ctx[prop] = decode(parts[1]);
	        }

	        ctx = ctx[prop];
	      }

	      continue;
	    }

	    obj[parts[0]] = null == parts[1] ? '' : decode(parts[1]);
	  }

	  return obj;
	};

	/**
	 * Stringify the given `obj`.
	 *
	 * @param {Object} obj
	 * @return {String}
	 * @api public
	 */

	exports.stringify = function(obj){
	  if (!obj) return '';
	  var pairs = [];

	  for (var key in obj) {
	    var value = obj[key];

	    if ('array' == type(value)) {
	      for (var i = 0; i < value.length; ++i) {
	        pairs.push(encode(key + '[' + i + ']') + '=' + encode(value[i]));
	      }
	      continue;
	    }

	    pairs.push(encode(key) + '=' + encode(obj[key]));
	  }

	  return pairs.join('&');
	};


/***/ }),
/* 4 */
/***/ (function(module, exports) {

	
	exports = module.exports = trim;

	function trim(str){
	  return str.replace(/^\s*|\s*$/g, '');
	}

	exports.left = function(str){
	  return str.replace(/^\s*/, '');
	};

	exports.right = function(str){
	  return str.replace(/\s*$/, '');
	};


/***/ }),
/* 5 */
/***/ (function(module, exports) {

	/**
	 * toString ref.
	 */

	var toString = Object.prototype.toString;

	/**
	 * Return the type of `val`.
	 *
	 * @param {Mixed} val
	 * @return {String}
	 * @api public
	 */

	module.exports = function(val){
	  switch (toString.call(val)) {
	    case '[object Date]': return 'date';
	    case '[object RegExp]': return 'regexp';
	    case '[object Arguments]': return 'arguments';
	    case '[object Array]': return 'array';
	    case '[object Error]': return 'error';
	  }

	  if (val === null) return 'null';
	  if (val === undefined) return 'undefined';
	  if (val !== val) return 'nan';
	  if (val && val.nodeType === 1) return 'element';

	  if (isBuffer(val)) return 'buffer';

	  val = val.valueOf
	    ? val.valueOf()
	    : Object.prototype.valueOf.apply(val);

	  return typeof val;
	};

	// code borrowed from https://github.com/feross/is-buffer/blob/master/index.js
	function isBuffer(obj) {
	  return !!(obj != null &&
	    (obj._isBuffer || // For Safari 5-7 (missing Object.prototype.constructor)
	      (obj.constructor &&
	      typeof obj.constructor.isBuffer === 'function' &&
	      obj.constructor.isBuffer(obj))
	    ))
	}


/***/ }),
/* 6 */
/***/ (function(module, exports) {

	var SceneGraph = function(sceneProperties) {
	    var nodeCount = 1;

	    //todo: move merge to helpers section
	    function merge(parent, child) {
	        for (var prop in child) {
	            parent[prop] = child[prop];
	        }
	        return parent;
	    }

	    var SceneNode = function(name) {
	        nodeCount++;
	        this.parent = null;
	        this.children = {};
	        this.id = nodeCount;
	        this.name = 'n' + nodeCount;
	        if (typeof name !== 'undefined') {
	            this.name = name;
	        }
	        this.x = this.y = this.z = 0;
	        this.width = this.height = 0;
	    };

	    SceneNode.prototype.resize = function(width, height) {
	        if (width != null) {
	            this.width = width;
	        }
	        if (height != null) {
	            this.height = height;
	        }
	    };

	    SceneNode.prototype.moveTo = function(x, y, z) {
	        this.x = x != null ? x : this.x;
	        this.y = y != null ? y : this.y;
	        this.z = z != null ? z : this.z;
	    };

	    SceneNode.prototype.add = function(child) {
	        var name = child.name;
	        if (typeof this.children[name] === 'undefined') {
	            this.children[name] = child;
	            child.parent = this;
	        } else {
	            throw 'SceneGraph: child already exists: ' + name;
	        }
	    };

	    var RootNode = function() {
	        SceneNode.call(this, 'root');
	        this.properties = sceneProperties;
	    };

	    RootNode.prototype = new SceneNode();

	    var Shape = function(name, props) {
	        SceneNode.call(this, name);
	        this.properties = {
	            'fill': '#000000'
	        };
	        if (typeof props !== 'undefined') {
	            merge(this.properties, props);
	        } else if (typeof name !== 'undefined' && typeof name !== 'string') {
	            throw 'SceneGraph: invalid node name';
	        }
	    };

	    Shape.prototype = new SceneNode();

	    var Group = function() {
	        Shape.apply(this, arguments);
	        this.type = 'group';
	    };

	    Group.prototype = new Shape();

	    var Rect = function() {
	        Shape.apply(this, arguments);
	        this.type = 'rect';
	    };

	    Rect.prototype = new Shape();

	    var Text = function(text) {
	        Shape.call(this);
	        this.type = 'text';
	        this.properties.text = text;
	    };

	    Text.prototype = new Shape();

	    var root = new RootNode();

	    this.Shape = {
	        'Rect': Rect,
	        'Text': Text,
	        'Group': Group
	    };

	    this.root = root;
	    return this;
	};

	module.exports = SceneGraph;


/***/ }),
/* 7 */
/***/ (function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/**
	 * Shallow object clone and merge
	 *
	 * @param a Object A
	 * @param b Object B
	 * @returns {Object} New object with all of A's properties, and all of B's properties, overwriting A's properties
	 */
	exports.extend = function(a, b) {
	    var c = {};
	    for (var x in a) {
	        if (a.hasOwnProperty(x)) {
	            c[x] = a[x];
	        }
	    }
	    if (b != null) {
	        for (var y in b) {
	            if (b.hasOwnProperty(y)) {
	                c[y] = b[y];
	            }
	        }
	    }
	    return c;
	};

	/**
	 * Takes a k/v list of CSS properties and returns a rule
	 *
	 * @param props CSS properties object
	 */
	exports.cssProps = function(props) {
	    var ret = [];
	    for (var p in props) {
	        if (props.hasOwnProperty(p)) {
	            ret.push(p + ':' + props[p]);
	        }
	    }
	    return ret.join(';');
	};

	/**
	 * Encodes HTML entities in a string
	 *
	 * @param str Input string
	 */
	exports.encodeHtmlEntity = function(str) {
	    var buf = [];
	    var charCode = 0;
	    for (var i = str.length - 1; i >= 0; i--) {
	        charCode = str.charCodeAt(i);
	        if (charCode > 128) {
	            buf.unshift(['&#', charCode, ';'].join(''));
	        } else {
	            buf.unshift(str[i]);
	        }
	    }
	    return buf.join('');
	};

	/**
	 * Checks if an image exists
	 *
	 * @param src URL of image
	 * @param callback Callback to call once image status has been found
	 */
	exports.imageExists = function(src, callback) {
	    var image = new Image();
	    image.onerror = function() {
	        callback.call(this, false);
	    };
	    image.onload = function() {
	        callback.call(this, true);
	    };
	    image.src = src;
	};

	/**
	 * Decodes HTML entities in a string
	 *
	 * @param str Input string
	 */
	exports.decodeHtmlEntity = function(str) {
	    return str.replace(/&#(\d+);/g, function(match, dec) {
	        return String.fromCharCode(dec);
	    });
	};


	/**
	 * Returns an element's dimensions if it's visible, `false` otherwise.
	 *
	 * @param el DOM element
	 */
	exports.dimensionCheck = function(el) {
	    var dimensions = {
	        height: el.clientHeight,
	        width: el.clientWidth
	    };

	    if (dimensions.height && dimensions.width) {
	        return dimensions;
	    } else {
	        return false;
	    }
	};


	/**
	 * Returns true if value is truthy or if it is "semantically truthy"
	 * @param val
	 */
	exports.truthy = function(val) {
	    if (typeof val === 'string') {
	        return val === 'true' || val === 'yes' || val === '1' || val === 'on' || val === '✓';
	    }
	    return !!val;
	};

	/**
	 * Parses input into a well-formed CSS color
	 * @param val
	 */
	exports.parseColor = function(val) {
	    var hexre = /(^(?:#?)[0-9a-f]{6}$)|(^(?:#?)[0-9a-f]{3}$)/i;
	    var rgbre = /^rgb\((\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/;
	    var rgbare = /^rgba\((\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(0\.\d{1,}|1)\)$/;

	    var match = val.match(hexre);
	    var retval;

	    if (match !== null) {
	        retval = match[1] || match[2];
	        if (retval[0] !== '#') {
	            return '#' + retval;
	        } else {
	            return retval;
	        }
	    }

	    match = val.match(rgbre);

	    if (match !== null) {
	        retval = 'rgb(' + match.slice(1).join(',') + ')';
	        return retval;
	    }

	    match = val.match(rgbare);

	    if (match !== null) {
	        retval = 'rgba(' + match.slice(1).join(',') + ')';
	        return retval;
	    }

	    return null;
	};

	/**
	 * Provides the correct scaling ratio for canvas drawing operations on HiDPI screens (e.g. Retina displays)
	 */
	exports.canvasRatio = function () {
	    var devicePixelRatio = 1;
	    var backingStoreRatio = 1;

	    if (global.document) {
	        var canvas = global.document.createElement('canvas');
	        if (canvas.getContext) {
	            var ctx = canvas.getContext('2d');
	            devicePixelRatio = global.devicePixelRatio || 1;
	            backingStoreRatio = ctx.webkitBackingStorePixelRatio || ctx.mozBackingStorePixelRatio || ctx.msBackingStorePixelRatio || ctx.oBackingStorePixelRatio || ctx.backingStorePixelRatio || 1;
	        }
	    }

	    return devicePixelRatio / backingStoreRatio;
	};
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(global) {var DOM = __webpack_require__(9);

	var SVG_NS = 'http://www.w3.org/2000/svg';
	var NODE_TYPE_COMMENT = 8;

	/**
	 * Generic SVG element creation function
	 *
	 * @param svg SVG context, set to null if new
	 * @param width Document width
	 * @param height Document height
	 */
	exports.initSVG = function(svg, width, height) {
	    var defs, style, initialize = false;

	    if (svg && svg.querySelector) {
	        style = svg.querySelector('style');
	        if (style === null) {
	            initialize = true;
	        }
	    } else {
	        svg = DOM.newEl('svg', SVG_NS);
	        initialize = true;
	    }

	    if (initialize) {
	        defs = DOM.newEl('defs', SVG_NS);
	        style = DOM.newEl('style', SVG_NS);
	        DOM.setAttr(style, {
	            'type': 'text/css'
	        });
	        defs.appendChild(style);
	        svg.appendChild(defs);
	    }

	    //IE throws an exception if this is set and Chrome requires it to be set
	    if (svg.webkitMatchesSelector) {
	        svg.setAttribute('xmlns', SVG_NS);
	    }

	    //Remove comment nodes
	    for (var i = 0; i < svg.childNodes.length; i++) {
	        if (svg.childNodes[i].nodeType === NODE_TYPE_COMMENT) {
	            svg.removeChild(svg.childNodes[i]);
	        }
	    }

	    //Remove CSS
	    while (style.childNodes.length) {
	        style.removeChild(style.childNodes[0]);
	    }

	    DOM.setAttr(svg, {
	        'width': width,
	        'height': height,
	        'viewBox': '0 0 ' + width + ' ' + height,
	        'preserveAspectRatio': 'none'
	    });

	    return svg;
	};

	/**
	 * Converts serialized SVG to a string suitable for data URI use
	 * @param svgString Serialized SVG string
	 * @param [base64] Use base64 encoding for data URI
	 */
	exports.svgStringToDataURI = function() {
	    var rawPrefix = 'data:image/svg+xml;charset=UTF-8,';
	    var base64Prefix = 'data:image/svg+xml;charset=UTF-8;base64,';

	    return function(svgString, base64) {
	        if (base64) {
	            return base64Prefix + btoa(global.unescape(encodeURIComponent(svgString)));
	        } else {
	            return rawPrefix + encodeURIComponent(svgString);
	        }
	    };
	}();

	/**
	 * Returns serialized SVG with XML processing instructions
	 *
	 * @param svg SVG context
	 * @param stylesheets CSS stylesheets to include
	 */
	exports.serializeSVG = function(svg, engineSettings) {
	    if (!global.XMLSerializer) return;
	    var serializer = new XMLSerializer();
	    var svgCSS = '';
	    var stylesheets = engineSettings.stylesheets;

	    //External stylesheets: Processing Instruction method
	    if (engineSettings.svgXMLStylesheet) {
	        var xml = DOM.createXML();
	        //Add <?xml-stylesheet ?> directives
	        for (var i = stylesheets.length - 1; i >= 0; i--) {
	            var csspi = xml.createProcessingInstruction('xml-stylesheet', 'href="' + stylesheets[i] + '" rel="stylesheet"');
	            xml.insertBefore(csspi, xml.firstChild);
	        }

	        xml.removeChild(xml.documentElement);
	        svgCSS = serializer.serializeToString(xml);
	    }

	    var svgText = serializer.serializeToString(svg);
	    svgText = svgText.replace(/\&amp;(\#[0-9]{2,}\;)/g, '&$1');
	    return svgCSS + svgText;
	};

	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 9 */
/***/ (function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/**
	 * Generic new DOM element function
	 *
	 * @param tag Tag to create
	 * @param namespace Optional namespace value
	 */
	exports.newEl = function(tag, namespace) {
	    if (!global.document) return;

	    if (namespace == null) {
	        return global.document.createElement(tag);
	    } else {
	        return global.document.createElementNS(namespace, tag);
	    }
	};

	/**
	 * Generic setAttribute function
	 *
	 * @param el Reference to DOM element
	 * @param attrs Object with attribute keys and values
	 */
	exports.setAttr = function (el, attrs) {
	    for (var a in attrs) {
	        el.setAttribute(a, attrs[a]);
	    }
	};

	/**
	 * Creates a XML document
	 * @private
	 */
	exports.createXML = function() {
	    if (!global.DOMParser) return;
	    return new DOMParser().parseFromString('<xml />', 'application/xml');
	};

	/**
	 * Converts a value into an array of DOM nodes
	 *
	 * @param val A string, a NodeList, a Node, or an HTMLCollection
	 */
	exports.getNodeArray = function(val) {
	    var retval = null;
	    if (typeof(val) == 'string') {
	        retval = document.querySelectorAll(val);
	    } else if (global.NodeList && val instanceof global.NodeList) {
	        retval = val;
	    } else if (global.Node && val instanceof global.Node) {
	        retval = [val];
	    } else if (global.HTMLCollection && val instanceof global.HTMLCollection) {
	        retval = val;
	    } else if (val instanceof Array) {
	        retval = val;
	    } else if (val === null) {
	        retval = [];
	    }

	    retval = Array.prototype.slice.call(retval);

	    return retval;
	};

	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 10 */
/***/ (function(module, exports) {

	var Color = function(color, options) {
	    //todo: support rgba, hsla, and rrggbbaa notation
	    //todo: use CIELAB internally
	    //todo: add clamp function (with sign)
	    if (typeof color !== 'string') return;

	    this.original = color;

	    if (color.charAt(0) === '#') {
	        color = color.slice(1);
	    }

	    if (/[^a-f0-9]+/i.test(color)) return;

	    if (color.length === 3) {
	        color = color.replace(/./g, '$&$&');
	    }

	    if (color.length !== 6) return;

	    this.alpha = 1;

	    if (options && options.alpha) {
	        this.alpha = options.alpha;
	    }

	    this.set(parseInt(color, 16));
	};

	//todo: jsdocs
	Color.rgb2hex = function(r, g, b) {
	    function format (decimal) {
	        var hex = (decimal | 0).toString(16);
	        if (decimal < 16) {
	            hex = '0' + hex;
	        }
	        return hex;
	    }

	    return [r, g, b].map(format).join('');
	};

	//todo: jsdocs
	Color.hsl2rgb = function (h, s, l) {
	    var H = h / 60;
	    var C = (1 - Math.abs(2 * l - 1)) * s;
	    var X = C * (1 - Math.abs(parseInt(H) % 2 - 1));
	    var m = l - (C / 2);

	    var r = 0, g = 0, b = 0;

	    if (H >= 0 && H < 1) {
	        r = C;
	        g = X;
	    } else if (H >= 1 && H < 2) {
	        r = X;
	        g = C;
	    } else if (H >= 2 && H < 3) {
	        g = C;
	        b = X;
	    } else if (H >= 3 && H < 4) {
	        g = X;
	        b = C;
	    } else if (H >= 4 && H < 5) {
	        r = X;
	        b = C;
	    } else if (H >= 5 && H < 6) {
	        r = C;
	        b = X;
	    }

	    r += m;
	    g += m;
	    b += m;

	    r = parseInt(r * 255);
	    g = parseInt(g * 255);
	    b = parseInt(b * 255);

	    return [r, g, b];
	};

	/**
	 * Sets the color from a raw RGB888 integer
	 * @param raw RGB888 representation of color
	 */
	//todo: refactor into a static method
	//todo: factor out individual color spaces
	//todo: add HSL, CIELAB, and CIELUV
	Color.prototype.set = function (val) {
	    this.raw = val;

	    var r = (this.raw & 0xFF0000) >> 16;
	    var g = (this.raw & 0x00FF00) >> 8;
	    var b = (this.raw & 0x0000FF);

	    // BT.709
	    var y = 0.2126 * r + 0.7152 * g + 0.0722 * b;
	    var u = -0.09991 * r - 0.33609 * g + 0.436 * b;
	    var v = 0.615 * r - 0.55861 * g - 0.05639 * b;

	    this.rgb = {
	        r: r,
	        g: g,
	        b: b
	    };

	    this.yuv = {
	        y: y,
	        u: u,
	        v: v
	    };

	    return this;
	};

	/**
	 * Lighten or darken a color
	 * @param multiplier Amount to lighten or darken (-1 to 1)
	 */
	Color.prototype.lighten = function(multiplier) {
	    var cm = Math.min(1, Math.max(0, Math.abs(multiplier))) * (multiplier < 0 ? -1 : 1);
	    var bm = (255 * cm) | 0;
	    var cr = Math.min(255, Math.max(0, this.rgb.r + bm));
	    var cg = Math.min(255, Math.max(0, this.rgb.g + bm));
	    var cb = Math.min(255, Math.max(0, this.rgb.b + bm));
	    var hex = Color.rgb2hex(cr, cg, cb);
	    return new Color(hex);
	};

	/**
	 * Output color in hex format
	 * @param addHash Add a hash character to the beginning of the output
	 */
	Color.prototype.toHex = function(addHash) {
	    return (addHash ? '#' : '') + this.raw.toString(16);
	};

	/**
	 * Returns whether or not current color is lighter than another color
	 * @param color Color to compare against
	 */
	Color.prototype.lighterThan = function(color) {
	    if (!(color instanceof Color)) {
	        color = new Color(color);
	    }

	    return this.yuv.y > color.yuv.y;
	};

	/**
	 * Returns the result of mixing current color with another color
	 * @param color Color to mix with
	 * @param multiplier How much to mix with the other color
	 */
	/*
	Color.prototype.mix = function (color, multiplier) {
	    if (!(color instanceof Color)) {
	        color = new Color(color);
	    }

	    var r = this.rgb.r;
	    var g = this.rgb.g;
	    var b = this.rgb.b;
	    var a = this.alpha;

	    var m = typeof multiplier !== 'undefined' ? multiplier : 0.5;

	    //todo: write a lerp function
	    r = r + m * (color.rgb.r - r);
	    g = g + m * (color.rgb.g - g);
	    b = b + m * (color.rgb.b - b);
	    a = a + m * (color.alpha - a);

	    return new Color(Color.rgbToHex(r, g, b), {
	        'alpha': a
	    });
	};
	*/

	/**
	 * Returns the result of blending another color on top of current color with alpha
	 * @param color Color to blend on top of current color, i.e. "Ca"
	 */
	//todo: see if .blendAlpha can be merged into .mix
	Color.prototype.blendAlpha = function(color) {
	    if (!(color instanceof Color)) {
	        color = new Color(color);
	    }

	    var Ca = color;
	    var Cb = this;

	    //todo: write alpha blending function
	    var r = Ca.alpha * Ca.rgb.r + (1 - Ca.alpha) * Cb.rgb.r;
	    var g = Ca.alpha * Ca.rgb.g + (1 - Ca.alpha) * Cb.rgb.g;
	    var b = Ca.alpha * Ca.rgb.b + (1 - Ca.alpha) * Cb.rgb.b;

	    return new Color(Color.rgb2hex(r, g, b));
	};

	module.exports = Color;


/***/ }),
/* 11 */
/***/ (function(module, exports) {

	module.exports = {
	  'version': '2.9.6',
	  'svg_ns': 'http://www.w3.org/2000/svg'
	};

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

	var shaven = __webpack_require__(13);

	var SVG = __webpack_require__(8);
	var constants = __webpack_require__(11);
	var utils = __webpack_require__(7);

	var SVG_NS = constants.svg_ns;

	var templates = {
	  'element': function (options) {
	    var tag = options.tag;
	    var content = options.content || '';
	    delete options.tag;
	    delete options.content;
	    return  [tag, content, options];
	  }
	};

	//todo: deprecate tag arg, infer tag from shape object
	function convertShape (shape, tag) {
	  return templates.element({
	    'tag': tag,
	    'width': shape.width,
	    'height': shape.height,
	    'fill': shape.properties.fill
	  });
	}

	function textCss (properties) {
	  return utils.cssProps({
	    'fill': properties.fill,
	    'font-weight': properties.font.weight,
	    'font-family': properties.font.family + ', monospace',
	    'font-size': properties.font.size + properties.font.units
	  });
	}

	function outlinePath (bgWidth, bgHeight, outlineWidth) {
	  var outlineOffsetWidth = outlineWidth / 2;

	  return [
	    'M', outlineOffsetWidth, outlineOffsetWidth,
	    'H', bgWidth - outlineOffsetWidth,
	    'V', bgHeight - outlineOffsetWidth,
	    'H', outlineOffsetWidth,
	    'V', 0,
	    'M', 0, outlineOffsetWidth,
	    'L', bgWidth, bgHeight - outlineOffsetWidth,
	    'M', 0, bgHeight - outlineOffsetWidth,
	    'L', bgWidth, outlineOffsetWidth
	  ].join(' ');
	}

	module.exports = function (sceneGraph, renderSettings) {
	  var engineSettings = renderSettings.engineSettings;
	  var stylesheets = engineSettings.stylesheets;
	  var stylesheetXml = stylesheets.map(function (stylesheet) {
	    return '<?xml-stylesheet rel="stylesheet" href="' + stylesheet + '"?>';
	  }).join('\n');

	  var holderId = 'holder_' + Number(new Date()).toString(16);

	  var root = sceneGraph.root;
	  var textGroup = root.children.holderTextGroup;

	  var css = '#' + holderId + ' text { ' + textCss(textGroup.properties) + ' } ';

	  // push text down to be equally vertically aligned with canvas renderer
	  textGroup.y += textGroup.textPositionData.boundingBox.height * 0.8;

	  var wordTags = [];

	  Object.keys(textGroup.children).forEach(function (lineKey) {
	    var line = textGroup.children[lineKey];

	    Object.keys(line.children).forEach(function (wordKey) {
	      var word = line.children[wordKey];
	      var x = textGroup.x + line.x + word.x;
	      var y = textGroup.y + line.y + word.y;
	      var wordTag = templates.element({
	        'tag': 'text',
	        'content': word.properties.text,
	        'x': x,
	        'y': y
	      });

	      wordTags.push(wordTag);
	    });
	  });

	  var text = templates.element({
	    'tag': 'g',
	    'content': wordTags
	  });

	  var outline = null;

	  if (root.children.holderBg.properties.outline) {
	    var outlineProperties = root.children.holderBg.properties.outline;
	    outline = templates.element({
	      'tag': 'path',
	      'd': outlinePath(root.children.holderBg.width, root.children.holderBg.height, outlineProperties.width),
	      'stroke-width': outlineProperties.width,
	      'stroke': outlineProperties.fill,
	      'fill': 'none'
	    });
	  }

	  var bg = convertShape(root.children.holderBg, 'rect');

	  var sceneContent = [];

	  sceneContent.push(bg);
	  if (outlineProperties) {
	    sceneContent.push(outline);
	  }
	  sceneContent.push(text);

	  var scene = templates.element({
	    'tag': 'g',
	    'id': holderId,
	    'content': sceneContent
	  });

	  var style = templates.element({
	    'tag': 'style',
	    //todo: figure out how to add CDATA directive
	    'content': css,
	    'type': 'text/css'
	  });

	  var defs = templates.element({
	    'tag': 'defs',
	    'content': style
	  });

	  var svg = templates.element({
	    'tag': 'svg',
	    'content': [defs, scene],
	    'width': root.properties.width,
	    'height': root.properties.height,
	    'xmlns': SVG_NS,
	    'viewBox': [0, 0, root.properties.width, root.properties.height].join(' '),
	    'preserveAspectRatio': 'none'
	  });

	  var output = shaven(svg);

	  if (/\&amp;(x)?#[0-9A-Fa-f]/.test(output[0])) {
	    output[0] = output[0].replace(/&amp;#/gm, '&#');
	  }
	  
	  output = stylesheetXml + output[0];

	  var svgString = SVG.svgStringToDataURI(output, renderSettings.mode === 'background');
	  return svgString;
	};

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

	var escape = __webpack_require__(14)

	// TODO: remove namespace

	module.exports = function shaven (array, namespace, returnObject) {

		'use strict'

		var i = 1
		var doesEscape = true
		var HTMLString
		var attributeKey
		var callback
		var key


		returnObject = returnObject || {}


		function createElement (sugarString) {

			var tags = sugarString.match(/^[\w-]+/)
			var element = {
				tag: tags ? tags[0] : 'div',
				attr: {},
				children: []
			}
			var id = sugarString.match(/#([\w-]+)/)
			var reference = sugarString.match(/\$([\w-]+)/)
			var classNames = sugarString.match(/\.[\w-]+/g)


			// Assign id if is set
			if (id) {
				element.attr.id = id[1]

				// Add element to the return object
				returnObject[id[1]] = element
			}

			if (reference)
				returnObject[reference[1]] = element

			if (classNames)
				element.attr.class = classNames.join(' ').replace(/\./g, '')

			if (sugarString.match(/&$/g))
				doesEscape = false

			return element
		}

		function replacer (key, value) {

			if (value === null || value === false || value === undefined)
				return

			if (typeof value !== 'string' && typeof value !== 'object')
				return String(value)

			return value
		}

		function escapeAttribute (string) {
			return (string || string === 0) ?
				String(string)
					.replace(/&/g, '&amp;')
					.replace(/"/g, '&quot;') :
				''
		}

		function escapeHTML (string) {
			return String(string)
				.replace(/&/g, '&amp;')
				.replace(/"/g, '&quot;')
				.replace(/'/g, '&apos;')
				.replace(/</g, '&lt;')
				.replace(/>/g, '&gt;')
		}


		if (typeof array[0] === 'string')
			array[0] = createElement(array[0])

		else if (Array.isArray(array[0]))
			i = 0

		else
			throw new Error(
				'First element of array must be a string, ' +
				'or an array and not ' + JSON.stringify(array[0])
			)


		for (; i < array.length; i++) {

			// Don't render element if value is false or null
			if (array[i] === false || array[i] === null) {
				array[0] = false
				break
			}

			// Continue with next array value if current value is undefined or true
			else if (array[i] === undefined || array[i] === true) {
				continue
			}

			else if (typeof array[i] === 'string') {
				if (doesEscape)
					array[i] = escapeHTML(array[i])

				array[0].children.push(array[i])
			}

			else if (typeof array[i] === 'number') {

				array[0].children.push(array[i])
			}

			else if (Array.isArray(array[i])) {

				if (Array.isArray(array[i][0])) {
					array[i].reverse().forEach(function (subArray) {
						array.splice(i + 1, 0, subArray)
					})

					if (i !== 0)
						continue
					i++
				}

				shaven(array[i], namespace, returnObject)

				if (array[i][0])
					array[0].children.push(array[i][0])
			}

			else if (typeof array[i] === 'function')
				callback = array[i]


			else if (typeof array[i] === 'object') {
				for (attributeKey in array[i])
					if (array[i].hasOwnProperty(attributeKey))
						if (array[i][attributeKey] !== null &&
							array[i][attributeKey] !== false)
							if (attributeKey === 'style' &&
								typeof array[i][attributeKey] === 'object')
								array[0].attr[attributeKey] = JSON
									.stringify(array[i][attributeKey], replacer)
									.slice(2, -2)
									.replace(/","/g, ';')
									.replace(/":"/g, ':')
									.replace(/\\"/g, '\'')

							else
								array[0].attr[attributeKey] = array[i][attributeKey]
			}

			else
				throw new TypeError('"' + array[i] + '" is not allowed as a value.')
		}


		if (array[0] !== false) {

			HTMLString = '<' + array[0].tag

			for (key in array[0].attr)
				if (array[0].attr.hasOwnProperty(key))
					HTMLString += ' ' + key + '="' +
						escapeAttribute(array[0].attr[key]) + '"'

			HTMLString += '>'

			array[0].children.forEach(function (child) {
				HTMLString += child
			})

			HTMLString += '</' + array[0].tag + '>'

			array[0] = HTMLString
		}

		// Return root element on index 0
		returnObject[0] = array[0]

		if (callback)
			callback(array[0])

		// returns object containing all elements with an id and the root element
		return returnObject
	}


/***/ }),
/* 14 */
/***/ (function(module, exports) {

	/*!
	 * escape-html
	 * Copyright(c) 2012-2013 TJ Holowaychuk
	 * Copyright(c) 2015 Andreas Lubbe
	 * Copyright(c) 2015 Tiancheng "Timothy" Gu
	 * MIT Licensed
	 */

	'use strict';

	/**
	 * Module variables.
	 * @private
	 */

	var matchHtmlRegExp = /["'&<>]/;

	/**
	 * Module exports.
	 * @public
	 */

	module.exports = escapeHtml;

	/**
	 * Escape special characters in the given string of html.
	 *
	 * @param  {string} string The string to escape for inserting into HTML
	 * @return {string}
	 * @public
	 */

	function escapeHtml(string) {
	  var str = '' + string;
	  var match = matchHtmlRegExp.exec(str);

	  if (!match) {
	    return str;
	  }

	  var escape;
	  var html = '';
	  var index = 0;
	  var lastIndex = 0;

	  for (index = match.index; index < str.length; index++) {
	    switch (str.charCodeAt(index)) {
	      case 34: // "
	        escape = '&quot;';
	        break;
	      case 38: // &
	        escape = '&amp;';
	        break;
	      case 39: // '
	        escape = '&#39;';
	        break;
	      case 60: // <
	        escape = '&lt;';
	        break;
	      case 62: // >
	        escape = '&gt;';
	        break;
	      default:
	        continue;
	    }

	    if (lastIndex !== index) {
	      html += str.substring(lastIndex, index);
	    }

	    lastIndex = index + 1;
	    html += escape;
	  }

	  return lastIndex !== index
	    ? html + str.substring(lastIndex, index)
	    : html;
	}


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

	var DOM = __webpack_require__(9);
	var utils = __webpack_require__(7);

	module.exports = (function() {
	    var canvas = DOM.newEl('canvas');
	    var ctx = null;

	    return function(sceneGraph) {
	        if (ctx == null) {
	            ctx = canvas.getContext('2d');
	        }

	        var dpr = utils.canvasRatio();
	        var root = sceneGraph.root;
	        canvas.width = dpr * root.properties.width;
	        canvas.height = dpr * root.properties.height ;
	        ctx.textBaseline = 'middle';

	        var bg = root.children.holderBg;
	        var bgWidth = dpr * bg.width;
	        var bgHeight = dpr * bg.height;
	        //todo: parametrize outline width (e.g. in scene object)
	        var outlineWidth = 2;
	        var outlineOffsetWidth = outlineWidth / 2;

	        ctx.fillStyle = bg.properties.fill;
	        ctx.fillRect(0, 0, bgWidth, bgHeight);

	        if (bg.properties.outline) {
	            //todo: abstract this into a method
	            ctx.strokeStyle = bg.properties.outline.fill;
	            ctx.lineWidth = bg.properties.outline.width;
	            ctx.moveTo(outlineOffsetWidth, outlineOffsetWidth);
	            // TL, TR, BR, BL
	            ctx.lineTo(bgWidth - outlineOffsetWidth, outlineOffsetWidth);
	            ctx.lineTo(bgWidth - outlineOffsetWidth, bgHeight - outlineOffsetWidth);
	            ctx.lineTo(outlineOffsetWidth, bgHeight - outlineOffsetWidth);
	            ctx.lineTo(outlineOffsetWidth, outlineOffsetWidth);
	            // Diagonals
	            ctx.moveTo(0, outlineOffsetWidth);
	            ctx.lineTo(bgWidth, bgHeight - outlineOffsetWidth);
	            ctx.moveTo(0, bgHeight - outlineOffsetWidth);
	            ctx.lineTo(bgWidth, outlineOffsetWidth);
	            ctx.stroke();
	        }

	        var textGroup = root.children.holderTextGroup;
	        ctx.font = textGroup.properties.font.weight + ' ' + (dpr * textGroup.properties.font.size) + textGroup.properties.font.units + ' ' + textGroup.properties.font.family + ', monospace';
	        ctx.fillStyle = textGroup.properties.fill;

	        for (var lineKey in textGroup.children) {
	            var line = textGroup.children[lineKey];
	            for (var wordKey in line.children) {
	                var word = line.children[wordKey];
	                var x = dpr * (textGroup.x + line.x + word.x);
	                var y = dpr * (textGroup.y + line.y + word.y + (textGroup.properties.leading / 2));

	                ctx.fillText(word.properties.text, x, y);
	            }
	        }

	        return canvas.toDataURL('image/png');
	    };
	})();

/***/ })
/******/ ])
});
;
(function(ctx, isMeteorPackage) {
    if (isMeteorPackage) {
        Holder = ctx.Holder;
    }
})(this, typeof Meteor !== 'undefined' && typeof Package !== 'undefined');

var myapp_get_color = {
	primary_50: '#ccbfdf',
	primary_100: '#beaed7',
	primary_200: '#b19dce',
	primary_300: '#a38cc6',
	primary_400: '#967bbd',
	primary_500: '#886ab5',
	primary_600: '#7a59ad',
	primary_700: '#6e4e9e',
	primary_800: '#62468d',
	primary_900: '#563d7c',
	success_50: '#7aece0',
	success_100: '#63e9db',
	success_200: '#4de5d5',
	success_300: '#37e2d0',
	success_400: '#21dfcb',
	success_500: '#1dc9b7',
	success_600: '#1ab3a3',
	success_700: '#179c8e',
	success_800: '#13867a',
	success_900: '#107066',
	info_50: '#9acffa',
	info_100: '#82c4f8',
	info_200: '#6ab8f7',
	info_300: '#51adf6',
	info_400: '#39a1f4',
	info_500: '#2196F3',
	info_600: '#0d8aee',
	info_700: '#0c7cd5',
	info_800: '#0a6ebd',
	info_900: '#0960a5',
	warning_50: '#ffebc1',
	warning_100: '#ffe3a7',
	warning_200: '#ffdb8e',
	warning_300: '#ffd274',
	warning_400: '#ffca5b',
	warning_500: '#ffc241',
	warning_600: '#ffba28',
	warning_700: '#ffb20e',
	warning_800: '#f4a500',
	warning_900: '#da9400',	
	danger_50: '#feb7d9',
	danger_100: '#fe9ecb',
	danger_200: '#fe85be',
	danger_300: '#fe6bb0',
	danger_400: '#fd52a3',
	danger_500: '#fd3995',
	danger_600: '#fd2087',
	danger_700: '#fc077a',
	danger_800: '#e7026e',
	danger_900: '#ce0262',
	fusion_50: '#909090',
	fusion_100: '#838383',
	fusion_200: '#767676',
	fusion_300: '#dimgray',
	fusion_400: '#5d5d5d',
	fusion_500: '#505050',
	fusion_600: '#434343',
	fusion_700: '#363636',
	fusion_800: '#2a2a2a',
	fusion_900: '#1d1d1d'	
}
//--------------------------------------------------------------------------
// HEADSUP!
// Please be sure to re-run gulp again if you do not see the config changes
//--------------------------------------------------------------------------
var myapp_config = {
	/*
	APP VERSION
	*/
	VERSION: '4.0.0',
	/*
	SAVE INSTANCE REFERENCE
	Save a reference to the global object (window in the browser)
	*/
	root_: $('body'), // used for core app reference
	root_logo: $('.page-sidebar > .page-logo'), // used for core app reference
	/*
	DELAY VAR FOR FIRING REPEATED EVENTS (eg., scroll & resize events)
	Lowering the variable makes faster response time but taxing on the CPU
	Reference: http://benalman.com/code/projects/jquery-throttle-debounce/examples/throttle/
	*/
	throttleDelay: 450, // for window.scrolling & window.resizing
	filterDelay: 150,   // for keyup.functions 
	/*
	DETECT MOBILE DEVICES
	Description: Detects mobile device - if any of the listed device is 
	detected a class is inserted to $.root_ and the variable thisDevice 
	is decleard. (so far this is covering most hand held devices)
	*/
	thisDevice: null, // desktop or mobile
	isMobile: (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase())), //popular device types available on the market
	mobileMenuTrigger: null, // used by pagescrolling and appHeight script, do not change!
	mobileResolutionTrigger: 992, //the resolution when the mobile activation fires
	/*
	DETECT IF WEBKIT
	Description: this variable is used to fire the custom scroll plugin. 
	If it is a non-webkit it will fire the plugin.
	*/
	isWebkit: ((!!window.chrome && !!window.chrome.webstore) === true || Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 === true),
	/*
	DETECT CHROME
	Description: this variable is used to fire the custom CSS hacks
	*/
	isChrome: (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())),
	/*
	DETECT IE (it only detects the newer versions of IE)
	Description: this variable is used to fire the custom CSS hacks
	*/
	isIE: ( (window.navigator.userAgent.indexOf('Trident/') ) > 0 === true ),
	/*
	DEBUGGING MODE
	debugState = true; will spit all debuging message inside browser console.
	*/
	debugState: true, // outputs debug information on browser console
	/*
	Turn on ripple effect for buttons and touch events
	Dependency: 
	*/
	rippleEffect: true, // material design effect that appears on all buttons
	/*
	Primary theme anchor point ID
	This anchor is created dynamically and CSS is loaded as an override theme
	*/
	mythemeAnchor: '#mytheme',
	/*
	Primary menu anchor point #js-primary-nav
	This is the root anchor point where the menu script will begin its build
	*/
	navAnchor: $('#js-primary-nav'), //changing this may implicate slimscroll plugin target
	navHooks: $('#js-nav-menu'), //changing this may implicate CSS targets
	navAccordion: true, //nav item when one is expanded the other closes
	navInitalized: 'js-nav-built', //nav finished class 
	navFilterInput: $('#nav_filter_input'), //changing this may implicate CSS targets
	navHorizontalWrapperId: 'js-nav-menu-wrapper',
	/*
	The rate at which the menu expands revealing child elements on click
	Lower rate reels faster expansion of nav childs
	*/
	navSpeed: 500, //ms
	/*
	Nav close and open signs
	This uses the fontawesome css class
	*/
	navClosedSign: 'fal fa-angle-down',
	navOpenedSign: 'fal fa-angle-up',
	/*
	App date ID
	found inside the breadcrumb unit, displays current date to the app on pageload
	*/
	appDateHook: $('.js-get-date'),
	/*
	* SaveSettings to localStorage
	* DOC: to store settings to a DB instead of LocalStorage see below:
	*    initApp.pushSettings("className1 className2") //sets value
	*    var DB_string = initApp.getSettings(); //returns setting string
	*/
	storeLocally: true,
	/*
	* Used with initApp.loadScripts
	* DOC: Please leave it blank
	*/
	jsArray : []
};

 /*!
 * jQuery app.navigation v1.0.0
 *
 * Copyright 2019, 2020 SmartAdmin WebApp
 * Released under Marketplace License (see your license details for usage)
 *
 * Publish Date: 2018-01-01T17:42Z
 */

(function($) {

	/**
	 * Menu Plugin
	 **/
	$.fn.extend({

		/**
		 * pass the options variable to the function
		 *
		 *   $(id).navigation({ 
		 *       accordion: true,
		 *       animate: 'easeOutExpo',
		 *       speed: 200,
		 *       closedSign: '[+]',
		 *       openedSign: '[-]',
		 *       initClass: 'js-nav-built'
		 *   });
		 *
		 **/
	     
	    navigation: function(options) {

	        var defaults = {
					accordion: true,
					animate: 'easeOutExpo',
					speed: 200,
					closedSign: '[+]',
					openedSign: '[-]',
					initClass: 'js-nav-built'
	            },

	            /**
	             * extend our default options with those provided.
	             **/
	            opts = $.extend(defaults, options),

	            /**
	             * assign current element to variable, in this case is UL element
	             **/
	            self = $(this);

				if (!self.hasClass(opts.initClass)) {

				    /**
				     * confirm build to prevent rebuild error
				     **/
				    self.addClass(opts.initClass);

				    /**
				     * add a mark [+] to a multilevel menu
				     **/
				    self.find("li").each(function() {
				        if ($(this).find("ul").length !== 0) {

				            /**
				             * add the multilevel sign next to the link
				             **/
				            $(this).find("a:first").append("<b class='collapse-sign'>" + opts.closedSign + "</b>");

				            /**
				             * avoid jumping to the top of the page when the href is an #
				             **/
				            if ($(this).find("a:first").attr('href') == "#") {
				                $(this).find("a:first").click(function() {
				                    return false;
				                });
				            }
				        }
				    });

				    /**
				     * add open sign to all active lists
				     **/
				    self.find("li.active").each(function() {
				        $(this).parents("ul")
				        	.parent("li")
				        	.find("a:first")
				        	.attr('aria-expanded', true)
				        	.find("b:first")
				        	.html(opts.openedSign);
				    });

				    /**
				     * click events
				     **/
				    self.find("li a").on('mousedown', function(e) {

				        if ($(this).parent().find("ul").length !== 0) {

				            if (opts.accordion) {

				                /**
				                 * do nothing when the list is open
				                 **/
				                if (!$(this).parent().find("ul").is(':visible')) {

				                    parents = $(this).parent().parents("ul");
				                    visible = self.find("ul:visible");
				                    visible.each(function(visibleIndex) {
				                        var close = true;
				                        parents.each(function(parentIndex) {

				                            if (parents[parentIndex] == visible[visibleIndex]) {

				                                close = false;
				                                return false;
				                            }
				                        });
				                        if (close) {

				                            if ($(this).parent().find("ul") != visible[visibleIndex]) {

				                                $(visible[visibleIndex]).slideUp(opts.speed + 300, opts.animate, function() {
				                                    $(this).parent("li")
				                                    	.removeClass("open")
				                                    	.find("a:first")
				                                    	.attr('aria-expanded', false)
				                                    	.find("b:first")
				                                    	.html(opts.closedSign);

				                                    if (myapp_config.debugState)
				                                        console.log("nav item closed")    
				                                });
				                            }
				                        }
				                    });
				                }
				            }

				            /**
				             * Add active class to open element
				             **/
				            if ($(this).parent().find("ul:first").is(":visible") && !$(this).parent().find("ul:first").hasClass("active")) {

				                $(this).parent().find("ul:first").slideUp(opts.speed + 100, opts.animate, function() {
				                    $(this).parent("li")
				                    	.removeClass("open")
				                    	.find("a:first")
				                    	.attr('aria-expanded', false)
				                    	.find("b:first").delay(opts.speed)
				                    	.html(opts.closedSign);  

				                    if (myapp_config.debugState)
				                        console.log("nav item closed")
				                });
				            } else {
				                $(this).parent().find("ul:first").slideDown(opts.speed, opts.animate, function() {

				                    $(this).parent("li")
				                    	.addClass("open")
				                    	.find("a:first")
				                    	.attr('aria-expanded', true)
				                    	.find("b:first").delay(opts.speed)
				                    	.html(opts.openedSign);

				                    if (myapp_config.debugState)
				                        console.log("nav item opened");

				                });
				            }
				        }
				    });    

				} else {
				    
				    if (myapp_config.debugState)
				        console.log(self.get(0) + " this menu already exists");       
				}

	    },

	    /**
	     * DOC: $(id).destroy();
	     **/
	    navigationDestroy: function() {
	        
			self = $(this);

			if (self.hasClass(myapp_config.navInitalized)) {
			    self.find("li").removeClass("active open");
			    self.find("li a").off('mousedown').removeClass("active").removeAttr("aria-expanded").find(".collapse-sign").remove();
			    self.removeClass(myapp_config.navInitalized).find("ul").removeAttr("style");

			    if (myapp_config.debugState)
			        console.log( self.get(0) + " destroyed");     

			} else {
			    console.log("menu does not exist")
			}

	        
	    }
	}); 

})(jQuery, window, document);
 /*!
 * jQuery menuSlider v1.0.0
 *
 * Copyright 2019, 2020 SmartAdmin WebApp
 * Released under Marketplace License (see your license details for usage)
 *
 * Publish Date: 2019-01-01T17:42Z
 */


;
(function($) {
    var pluginName = 'menuSlider';

    function Plugin(element, options) {

        var $el = $(element),
             el = element;
        options = $.extend({}, $.fn[pluginName].defaults, options);

        function init() {

            /* reset margin */
            $el.css('margin-left', '0px');

            /* add wrapper around navigation */
            $el.wrap( '<div id="'+options.wrapperId+'" class="nav-menu-wrapper d-flex flex-grow-1 width-0 overflow-hidden"></div>' );

            /* add buttons for scroller */
            $('#' + options.wrapperId).before('<a href="#" id="' + options.wrapperId + '-left-btn" class="d-flex align-items-center justify-content-center width-4 btn mt-1 mb-1 mr-2 ml-1 p-0 fs-xxl text-primary"><i class="fal fa-angle-left"></i></a>');
            $('#' + options.wrapperId).after('<a href="#" id="' + options.wrapperId + '-right-btn" class="d-flex align-items-center justify-content-center width-4 btn mt-1 mb-1 mr-1 ml-2 p-0 fs-xxl text-primary"><i class="fal fa-angle-right"></i></a>');

            var getListWidth = $.map($el.children('li:not(.nav-title)'),function(val){ return $(val).outerWidth(true);}),
                /* define variables */
                wrapperWidth,
                currentMarginLeft,
                contentWidth,               
                setMargin,
                maxMargin,


                /* update variables for margin calculations */
                _getValues = function() {
                    wrapperWidth = $('#' + options.wrapperId).outerWidth(); /* incase its changed we get it again */
                    contentWidth = $.map( $el.children('li:not(.nav-title)'), function(val){ return $(val).outerWidth(true); }).reduce(function(a, b) { return a + b; }, 0);
                    currentMarginLeft = parseFloat($el.css('margin-left'));

                    /*console.log("got new values");
                    console.log("wrapperWidth :" + wrapperWidth);
                    console.log("contentWidth :" + contentWidth);
                    console.log("currentMarginLeft :" + currentMarginLeft);*/
                },

                /* scroll right */
                navMenuScrollRight = function() {

                    _getValues();

                    if (-currentMarginLeft + wrapperWidth < contentWidth) {
                        setMargin = Math.max(currentMarginLeft - wrapperWidth, -(contentWidth - wrapperWidth) );
                    } else {
                        setMargin = currentMarginLeft;
                        console.log("right end");
                    }

                    $el.css({
                        marginLeft: setMargin
                    });

                },

                /* scroll left */
                navMenuScrollLeft = function() {

                    _getValues();

                    if (currentMarginLeft < 0) {
                        setMargin = Math.min(currentMarginLeft + wrapperWidth, 0);
                    } else {
                        setMargin = currentMarginLeft;
                        console.log("left end");
                    }

                    $el.css({
                        marginLeft: setMargin
                    });

                };

            /* assign buttons for right*/
            $('#' + options.wrapperId + '-left-btn').click(function(e) {

                navMenuScrollLeft();

                e.preventDefault();
            });

            /* assign buttons for left */
             $('#' + options.wrapperId + '-right-btn').click(function(e) {

                navMenuScrollRight();

                e.preventDefault();
            });

            hook('onInit');
        }

        function option(key, val) {
            if (val) {
                options[key] = val;
            } else {
                return options[key];
            }
        }

        function destroy(options) {
            $el.each(function() {
                var el = this;
                var $el = $(this);

                // Add code to restore the element to its original state...

                $el.css('margin-left', '0px');                           
                $el.unwrap(parent);
                $el.prev().off().remove();
                $el.next().off().remove();

                hook('onDestroy');
                $el.removeData('plugin_' + pluginName);
            });
        }

        function hook(hookName) {
            if (options[hookName] !== undefined) {
                options[hookName].call(el);
            }
        }

        init();

        return {
            option: option,
            destroy: destroy
        };
    }

    $.fn[pluginName] = function(options) {
        if (typeof arguments[0] === 'string') {
            var methodName = arguments[0];
            var args = Array.prototype.slice.call(arguments, 1);
            var returnVal;
            this.each(function() {
                if ($.data(this, 'plugin_' + pluginName) && typeof $.data(this, 'plugin_' + pluginName)[methodName] === 'function') {
                    returnVal = $.data(this, 'plugin_' + pluginName)[methodName].apply(this, args);
                } else {
                    throw new Error('Method ' + methodName + ' does not exist on jQuery.' + pluginName);
                }
            });
            if (returnVal !== undefined) {
                return returnVal;
            } else {
                return this;
            }
        } else if (typeof options === "object" || !options) {
            return this.each(function() {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
                }
            });
        }
    };

    $.fn[pluginName].defaults = {
        onInit: function() {},
        onDestroy: function() {},
        element: myapp_config.navHooks,
        wrapperId: myapp_config.navHorizontalWrapperId
    };


})(jQuery);
 /*!
 * jQuery SmartAdmin v4.0.0
 *
 * Copyright 2019, 2020 SmartAdmin WebApp
 * Released under Marketplace License (see your license details for usage)
 *
 * Publish Date: 2019-01-01T17:42Z
 */
var initApp = (function(app) {

	/**
	 * List filter 
	 * DOC: searches list items, it could be UL or DIV elements
	 * usage: initApp.listFilter($('.list'), $('#intput-id'));
	 *        inside the .list you will need to insert 'data-filter-tags' inside <a>
	 * @param  list
	 * @param  input 
	 * @param  anchor
	 * @return 
	 */
	app.listFilter = function (list, input, anchor) {

		/* add class to filter hide/show */
		if (anchor) {
			$(anchor).addClass('js-list-filter');
		} else {
			$(list).addClass('js-list-filter');
		}

		/* on change keyboard */
		$(input).change( function () {

			var filter = $(this).val().toLowerCase(),
				listPrev = $(list).next().filter('.js-filter-message');
	
			/* when user types more than 1 letter start search filter */
			if(filter.length > 1) {

				/* this finds all data-filter-tags in a list that contain the input val,
				   hiding the ones not containing the input while showing the ones that do */
				
				/* (1) hide all that does not match */   
				$(list).find($("[data-filter-tags]:not([data-filter-tags*='" + filter + "'])"))
					.parentsUntil(list).removeClass('js-filter-show')
					.addClass('js-filter-hide');

				/* (2) hide all that does match */	
				$(list).find($("[data-filter-tags*='" + filter + "']"))
					.parentsUntil(list).removeClass('js-filter-hide')
					.addClass('js-filter-show');

				/* if element exists then print results */	
				if (listPrev){	
					listPrev.text("showing " + $(list).find('li.js-filter-show').length + " from " + $(list).find('[data-filter-tags]').length + " total");
				}

			} else {

				/* when filter length is blank reset the classes */
				$(list).find('[data-filter-tags]').parentsUntil(list).removeClass('js-filter-hide js-filter-show');

				/* if element exists reset print results */
				if (listPrev){
					listPrev.text("");
				}
			} 

			return false;

		}).keyup( $.debounce( myapp_config.filterDelay, function (e) {

			/* fire the above change event after every letter is typed with a delay of 250ms */
		 	$(this).change();

		 	/*if(e.keyCode == 13) {
				console.log( $(list).find(".filter-show:not(.filter-hide) > a") );
			}*/

		}));
	};

	/**
	 * Load scripts using lazyload method 
	 * usage: initApp.loadScript("js/my_lovely_script.js", myFunction);
	 * @param  {[type]}   scriptName
	 * @param  {Function} callback  
	 * @return {[type]}             
	 */
	app.loadScript = function (scriptName, callback) {

		if (!myapp_config.jsArray[scriptName]) {	
			var promise = jQuery.Deferred();

			/* adding the script tag to the head as suggested before */
			var body = document.getElementsByTagName('body')[0],
				script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = scriptName;

			/* then bind the event to the callback function
			   there are several events for cross browser compatibility */
			script.onload = function() {
				promise.resolve();
			};

			/* fire the loading */
			body.appendChild(script);
			myapp_config.jsArray[scriptName] = promise.promise();
		}	

		else if (myapp_config.debugState)
			console.log("This script was already loaded: " + scriptName);

		myapp_config.jsArray[scriptName].then(function () {
			if(typeof callback === 'function') {
				callback();
			}
		});
	};

	/**
	 * Javascript Animation for save settings 
	 * @return
	 **/
	app.saveSettings = function () {

		/* if saveSettings function exists */		
		if (typeof saveSettings !== 'undefined' && $.isFunction(saveSettings) && myapp_config.storeLocally) {

			/* call accessIndicator animation */
			initApp.accessIndicator();

			/* call saveSettings function from myapp_config.root_ (HTML) */
			saveSettings();

			if (myapp_config.debugState)
				console.log('Theme settings: ' + '\n' +localStorage.getItem('themeSettings'));

		} else {
			console.log("save function does not exist");
		}
		
	};

	/**
	 * Reset settings 
	 * DOC: removes all classes from root_ then saves
	 * @return {[type]}
	 **/
	app.resetSettings = function () {

		/* remove all setting classes nav|header|mod|display */
		myapp_config.root_.removeClass (function (index, className) {
			return (className.match (/(^|\s)(nav-|header-|mod-|display-)\S+/g) || []).join(' ');
		});

		/* detach custom css skin */
		$(myapp_config.mythemeAnchor).attr('href', "");

		/* check non-conflicting plugins */
		initApp.checkNavigationOrientation();

		/* save settings if "storeLocally == true" */
		initApp.saveSettings();

		if (myapp_config.debugState)
			console.log("App reset successful");
	};

	/**
	 * Factory Reset 
	 * DOC: Resets all of localstorage
	 * @return {[type]}
	 **/
	app.factoryReset = function () {

		//backdrop sound
		initApp.playSound('media/sound', 'messagebox');
		//hide settings modal to bootstrap avoid modal bug
		$('.js-modal-settings').modal('hide');

		if (typeof bootbox  != 'undefined') {

			bootbox.confirm({
				title: "<i class='fal fa-exclamation-triangle text-warning mr-2'></i> You are about to reset all of your localStorage settings",
				message: "<span><strong>Warning:</strong> This action is not reversable. You will lose all your layout settings.</span>",
				centerVertical: true,
				swapButtonOrder: true,
				buttons: {
					confirm: {
						label: 'Factory Reset',
						className: 'btn-warning shadow-0'
					},
					cancel: {
						label: 'Cancel',
						className: 'btn-success'
					}
				},
				className: "modal-alert",
				closeButton: false,
				callback: function (result) {
					if (result == true) {
						//close panel 
						localStorage.clear();
						initApp.resetSettings();
						location.reload();
					}
				}
			});

		} else {

			if (confirm( 'You are about to reset all of your localStorage to null state. Do you wish to continue?' )) {
				localStorage.clear();
				initApp.resetSettings();
				location.reload();
			}

		}				

		//e.preventDefault();

		if (myapp_config.debugState)
			console.log("App reset successful");
	};

	/**
	 * Access Indicator
	 * DOC: spinning icon that appears whenever you
	 * access localstorage or change settings
	 * @return {[type]}
	 **/
	app.accessIndicator = function () {

		myapp_config.root_.addClass('saving').delay(600).queue(function(){
			$(this).removeClass('saving').dequeue();
			return true;
		});

	};

	/*
	 * usage: initApp.pushSettings("className1 className2")
	 * save settings to localstorage: initApp.pushSettings("className1 className2", true)
	 * DOC: pushSettings will also auto save to localStorage if "storeLocally == true" 
	 * we will use this "pushSettings" when loading settings from a database
	 * @param  {[type]} DB_string   
	 * @param  {[type]} saveToLocal
	 * @return {[type]}            
	 */
	app.pushSettings = function (DB_string, saveToLocal) {

		/* clear localstorage variable 'themeSettings' */
		if (saveToLocal != false)
		localStorage.setItem("themeSettings", "");

		/* replace classes from <body> with fetched DB string */
		myapp_config.root_.addClass(DB_string); //ommited .removeClass()

		/* destroy or enable slimscroll */
		initApp.checkNavigationOrientation();

		/* save settings if "storeLocally == true" && "saveToLocal is true" */
		if (saveToLocal != false)
		initApp.saveSettings();

		/* return string */
		return DB_string;
	};

	/*
	 * usage: var DB_string = initApp.getSettings();
	 * we will use this "getSettings" when storing settings to a database
	 * @return {[type]}
	 */
	app.getSettings = function () {

		return myapp_config.root_.attr('class').split(/[^\w-]+/).filter(function(item) {
			return /^(nav|header|mod|display)-/i.test(item);
		}).join(' ');
	};

	/*
	 * Play Sounds
	 * usage: initApp.playSound(path, sound);
	 * @param  {[string]} path 
	 * @param  {[string]} sound 
	 */
	app.playSound = function(path, sound) {
		var audioElement = document.createElement('audio');
		if (navigator.userAgent.match('Firefox/'))
			audioElement.setAttribute('src', path + "/" + sound + '.ogg');
		else
			audioElement.setAttribute('src', path + "/" + sound + '.mp3');

		//$.get();// <-- ??
		audioElement.addEventListener("load", function () {
			audioElement.play();
		}, true);

		audioElement.pause();
		audioElement.play();
	}

	/*
	 * Checks and sets active settings selections
	 * DOC: ?
	 */
	/*app.indicateSelections = function () {

		var classNames = initApp.getSettings()
			.split(' ')
			.map(function(c) {
				return '[data-class="' +  c + '"].js-indicateSelections';
			})
			.join(',');

		$('[data-class].active.js-indicateSelections').removeClass('active');
		$(classNames).addClass('active');

		if (myapp_config.debugState)
			console.log(classNames);
	}*/

	/**
	 * detect browser type
	 * DOC: detect if browser supports webkit CSS
	 * @return {[type]}
	 **/
	app.detectBrowserType = function () {

		/* safari, chrome or IE detect */	
		if(myapp_config.isChrome){

			myapp_config.root_.addClass('chrome webkit');
			return 'chrome webkit';

		} else if (myapp_config.isWebkit) {

			myapp_config.root_.addClass('webkit');
			return 'webkit';

		} else if (myapp_config.isIE) {

			myapp_config.root_.addClass('ie');
			return 'ie';
		}

	};

	/**
	 * Add device type
	 * DOC: Detect if mobile or desktop
	 **/		
	app.addDeviceType = function() {
		
		if (!myapp_config.isMobile) {

			/* desktop */	
			myapp_config.root_.addClass('desktop');
			myapp_config.thisDevice = 'desktop';

		} else {

			/* mobile */
			myapp_config.root_.addClass('mobile');
			myapp_config.thisDevice = 'mobile';
			 
		}

		return myapp_config.thisDevice;
		
	};

	/**
	 * Fix logo position on .header-function-fixed & .nav-function-hidden
	 * DOC: Counters browser bug for fixed position and overflow:hidden for the logo (firefox/IE/Safari)
	 *      Will not fire for webkit devices or Chrome as its not needed
	 * @return {[type]}     
	 **/
	 app.windowScrollEvents = function () {
		if ( myapp_config.root_.is('.nav-function-hidden.header-function-fixed:not(.nav-function-top)') &&  myapp_config.thisDevice === 'desktop') {
			myapp_config.root_logo.css({
				'top': $(window).scrollTop()
			});
		} else if ( myapp_config.root_.is('.header-function-fixed:not(.nav-function-top):not(.nav-function-hidden)') &&  myapp_config.thisDevice === 'desktop') {
			myapp_config.root_logo.attr("style", "");
		}
	 };

	/**
	 * checkNavigationOrientation by checking layout conditions
	 * DOC: sometimes settings can trigger certain plugins; so we check this condition and activate accordingly
	 * E.g: the fixed navigation activates custom scroll plugin for the navigation, but this only happens when
	 *		it detects desktop browser and destroys the plugin when navigation is on top or if its not fixed.
	 * @return {[type]}		
	 **/
	 app.checkNavigationOrientation = function() {

	 	/**
	 	 * DOC: add the plugin with the following rules: fixed navigation is selected, top navigation is not active, minify nav is not active, 
	 	 * and the device is desktop. We do not need to activate the plugin when loading from a mobile phone as it is not needed for touch screens.
		 **/
		switch ( true ) {

			case ( myapp_config.root_.hasClass('nav-function-fixed') && !myapp_config.root_.is('.nav-function-top, .nav-function-minify, .mod-main-boxed') && myapp_config.thisDevice === 'desktop' ):

				/* start slimscroll on nav */
				if ( typeof $.fn.slimScroll !== 'undefined' ) {
					myapp_config.navAnchor.slimScroll({
						height: '100%',
						color: '#fff',
						size: '4px',
						distance: '4px',
						railOpacity: 0.4,
						wheelStep: 10
					});

					if ( document.getElementById(myapp_config.navHorizontalWrapperId) ) {
						myapp_config.navHooks.menuSlider('destroy');
						
						if (myapp_config.debugState)
						console.log("----top controls destroyed");
					}

					if (myapp_config.debugState)
					console.log("slimScroll created");

				} else {
					console.log("$.fn.slimScroll...NOT FOUND");
				}	

				break;			

			case ( myapp_config.navAnchor.parent().hasClass('slimScrollDiv') && myapp_config.thisDevice === 'desktop' && typeof $.fn.slimScroll !== 'undefined' ):

				/* destroy the plugin if it is in violation of rules above */
	    		myapp_config.navAnchor.slimScroll({ destroy: true });
	    		myapp_config.navAnchor.attr('style', '');

				/* clear event listners (IE bug) */
				events = jQuery._data( myapp_config.navAnchor[0], "events" );

				if (events) 
					jQuery._removeData( myapp_config.navAnchor[0], "events" );

				if (myapp_config.debugState)
					console.log("slimScroll destroyed");

				break;					

		}

		switch ( true ) {


			/* fires when user switches to nav-function-top on desktop view */
			case ( $.fn.menuSlider && myapp_config.root_.hasClass('nav-function-top') && $("#js-nav-menu-wrapper").length == false && !myapp_config.root_.hasClass('mobile-view-activated') ):

				/* build horizontal navigation */
				myapp_config.navHooks.menuSlider({
					element: myapp_config.navHooks,
					wrapperId: myapp_config.navHorizontalWrapperId
				});

				/* build horizontal nav */
				if (myapp_config.debugState)
				console.log("----top controls created -- case 1");

				break;

			/* fires when user resizes screen to mobile size or app is loaded on mobile resolution */
			case ( myapp_config.root_.hasClass('nav-function-top') && $("#js-nav-menu-wrapper").length == true && myapp_config.root_.hasClass('mobile-view-activated') ):

				/* destroy horizontal nav */
				myapp_config.navHooks.menuSlider('destroy');

				/* build horizontal nav */
				if (myapp_config.debugState)
				console.log("----top controls destroyed -- case 2");

				break;	

			/* fires when users switch off nav-function-top class */
			case ( !myapp_config.root_.hasClass('nav-function-top') && $("#js-nav-menu-wrapper").length == true ):

				/* destroy horizontal nav */
				myapp_config.navHooks.menuSlider('destroy');

				/* build horizontal nav */
				if (myapp_config.debugState)
				console.log("----top controls destroyed -- case 3");				

				break;	

		}

	};
	
	/**
	 * Activate Nav
	 * DOC: activation should not take place if top navigation is on
	 * @param  {[type]} id 
	 * @return {[type]} 
	 **/
	app.buildNavigation = function(id) {
		
		/**
		 * build nav
		 * app.navigation.js
		 **/
		if ($.fn.navigation) {

			$(id).navigation({ 

				accordion : myapp_config.navAccordion,
				speed : myapp_config.navSpeed,
				closedSign : '<em class="' + myapp_config.navClosedSign + '"></em>',
				openedSign : '<em class="' + myapp_config.navOpenedSign + '"></em>',
				initClass: myapp_config.navInitalized

			});

			return (id);
		} else {

			if (myapp_config.debugState)
			console.log( "WARN: navigation plugin missing" );

		}
	};

	/**
	 * Destroy Nav
	 * @param  {[type]} id 
	 * @return {[type]} 
	 **/
	app.destroyNavigation = function(id) {
		
		/**
		 * destroy nav
		 * app.navigation.js
		 **/
		if ($.fn.navigation) {

			$(id).navigationDestroy(); 

			return (id);
		} else {

			if (myapp_config.debugState)
			console.log( "WARN: navigation plugin missing" );

		}
	};

	/**
	 * App Forms
	 * DOC: detects if input is selected or blured
	 * @param  {[type]} parentClass
	 * @param  {[type]} focusClass
	 * @param  {[type]} disabledClass
	 * @return {[type]} 
	 **/
	app.appForms = function(parentClass,focusClass,disabledClass){

		/* go through each .form-control */
		/*$('.form-control').each(function () {
			checkLength(this);
		});*/

		/* if input has 'some value' add class .has-length to .form-group */
		/*function checkLength(e) {
			if (e.value.length > 0 ) {
				$(e).parents(parentClass).addClass(focusClass);
				if($(e).is('[readonly]') || $(e).is('[disabled]')) {
					$(e).parents(parentClass).addClass(disabledClass);
				}
			} else {
				$(e).parents(parentClass).removeClass(focusClass);
				if($(e).is('[readonly]') || $(e).is('[disabled]')) {
					$(e).parents(parentClass).removeClass(disabledClass);
				}
			}
		}*/

		function setClass(e, parentClass, focusClass) {
			$(e).parents(parentClass).addClass(focusClass);
		}

		function deleteClass(e, parentClass, focusClass) {
			/*if(e.value.length) {

			} else {*/
				$(e).parents(parentClass).removeClass(focusClass);
			/*}*/
		}

		$(parentClass).each(function () {
			var input = $(this).find('.form-control');
			input.on('focus', function(){
				setClass(this, parentClass, focusClass);
			});
			input.on('blur', function(){
				deleteClass(this, parentClass, focusClass);
			});
		});
	}; 
	
	/**
	 * Mobile Check Activate
	 * DOC: check on window resize if screen width is less than [value]
	 * @return {int}
	 */
	app.mobileCheckActivation = function(){
		
		if ( window.innerWidth < myapp_config.mobileResolutionTrigger ) {

			myapp_config.root_.addClass('mobile-view-activated');
			myapp_config.mobileMenuTrigger = true;

		} else {

			myapp_config.root_.removeClass('mobile-view-activated');
			myapp_config.mobileMenuTrigger = false;

		}

		if (myapp_config.debugState)
			console.log( "mobileCheckActivation on " + $(window).width() + " | activated: " + myapp_config.mobileMenuTrigger);

		return myapp_config.mobileMenuTrigger;
	}; 

	/**
	 *  Toggle visibility
	 * 	DOC: show and hide content with a button action
	 *  Usage: onclick="initApp.toggleVisibility('foo');"
	 *  @param  {[type]} id 
	 *  @return {[type]}
	 **/
	app.toggleVisibility = function (id) {
		var e = document.getElementById(id);
		if (e.style.display == 'block')
			e.style.display = 'none';
		else
			e.style.display = 'block';
	};

	/**
	 * Miscelaneous DOM ready functions
	 * DOC: start jQuery(document).ready calls
	 * @return {[type]}
	 **/
	app.domReadyMisc = function() {

		/* Give modal backdrop an extra class to make it customizable */
		$('.modal-backdrop-transparent').on('show.bs.modal', function (e) {
			setTimeout(function(){
				$('.modal-backdrop').addClass('modal-backdrop-transparent');
			});
		});
		
		/* Add app date to js-get-date */
		if ( myapp_config.appDateHook.length ) {
			var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
				now = new Date(),
				formatted = day[now.getDay()] + ', ' +  
							months[now.getMonth()] + ' ' +  
							now.getDate() + ', ' +
							now.getFullYear();
			myapp_config.appDateHook.text(formatted);				
		}

		/* Check conflicting classes to build/destroy slimscroll */
		initApp.checkNavigationOrientation();

		/* Activate the last tab clicked using localStorage */
		var lastTab = localStorage.getItem('lastTab');
		 
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			localStorage.setItem('lastTab', $(this).attr('href'));
		});
		
		if (lastTab) {
			$('[href="' + lastTab + '"]').tab('show');
		} 

		/**
		 * all options:
		 * --------------
			width: '300px',
			height: '500px',
			size: '10px',
			position: 'left',
			color: '#ffcc00',
			alwaysVisible: true,
			distance: '20px',
			start: $('#child_image_element'),
			railVisible: true,
			railColor: '#222',
			railOpacity: 0.3,
			wheelStep: 10,
			allowPageScroll: false,
			disableFadeOut: false
		 **/
		if ( typeof $.fn.slimScroll !== 'undefined' && myapp_config.thisDevice === 'desktop') {

			$('.custom-scroll:not(.disable-slimscroll) >:first-child').slimscroll({
				height: $(this).data('scrollHeight') || '100%',
				size: $(this).data('scrollSize') || '4px',
				position: $(this).data('scrollPosition') || 'right',
				color: $(this).data('scrollColor') || 'rgba(0,0,0,0.6)',
				alwaysVisible: $(this).data('scrollAlwaysVisible') || false,
				distance: $(this).data('scrollDistance') || '4px',
				railVisible: $(this).data('scrollRailVisible') || false,
				railColor: $(this).data('scrollRailColor') || '#fafafa',
				allowPageScroll: false,
				disableFadeOut: false
			});

			if (myapp_config.debugState)
				console.log("%c✔ SlimScroll plugin active", "color: #148f32");	

		} else {
			console.log("WARN! $.fn.slimScroll not loaded or user is on desktop");
			myapp_config.root_.addClass("no-slimscroll");
		}

		/**
		 * Activate listFilters
		 * usage: <input id="inputID" data-listfilter="listFilter" />
		 **/
		if( typeof initApp.listFilter !== 'undefined' && $.isFunction(initApp.listFilter) && $('[data-listfilter]').length ) {


			var inputID = $('[data-listfilter]').attr('id'),
				listFilter = $('[data-listfilter]').attr("data-listfilter");

			/* initApp.listFilter($('.list'), $('#intput-id')); */
			initApp.listFilter(listFilter, '#' + inputID);
		}

		/**
		 * Start bootstrap tooltips
		 **/
		if( typeof($.fn.tooltip) !== 'undefined' && $('[data-toggle="tooltip"]').length ){
			$('[data-toggle="tooltip"]').tooltip(); /*{html: true}*/
		} else {
			console.log("OOPS! bs.tooltip is not loaded");
		}

		/**
		 * Start bootstrap popovers
		 **/
		if( typeof($.fn.popover) !== 'undefined' && $('[data-toggle="popover"]').length ){

			/* BS4 sanatize */
			var myDefaultWhiteList = $.fn.tooltip.Constructor.Default.whiteList

			/* init popover */
			/* data-sanitize="false" was not working so had to add this globally */
			/* DOC: https://getbootstrap.com/docs/4.3/getting-started/javascript/#sanitizer */
			$('[data-toggle="popover"]').popover({sanitize:false}); /*{trigger: "focus"}*/

		} /*else {
			console.log("OOPS! bs.popover is not loaded");
			console.log("this")
		}*/

		/* 
         * Disable popper.js's forced hardware accelaration styles
		 */
		if( typeof($.fn.dropdown) !== 'undefined'){ 
			Popper.Defaults.modifiers.computeStyle.gpuAcceleration = false;
		} else {
			console.log("OOPS! bs.popover is not loaded");
		} 

		/**
		 * Dropdowns will not close on click
		 * doc: close dropdowns on click outside hit area
		 **/
		$(document).on('click', '.dropdown-menu', function (e) {
			e.stopPropagation();
		});

		/**
		 * Waves effect (plugin has issues with IE9)
		 * DOC: http://fian.my.id/Waves/#start 
		 **/
		if (window.Waves && myapp_config.rippleEffect) {

			Waves.attach('.nav-menu:not(.js-waves-off) a, .btn:not(.js-waves-off):not(.btn-switch), .js-waves-on', ['waves-themed']);
    		Waves.init();

			if (myapp_config.debugState)
				console.log("%c✔ Waves plugin active", "color: #148f32");	
			
		} else {
			if (myapp_config.debugState)
				console.log("%c✘ Waves plugin inactive! ", "color: #fd3995");

		}

		/**
		 * Action buttons
		 **/		
		myapp_config.root_
			.on('click touchend', '[data-action]', function(e) {

				var actiontype = $(this).data('action');

				switch ( true ) {

					/**
					 * toggle trigger
					 * Usage 1 (body): <a href="#" data-action="toggle" data-class="add-this-class-to-body">...</a>
					 * Usage 2 (target): <a href="#" data-action="toggle" data-class="add-this-class-to-target" data-target="target">...</a>
					 **/
					case ( actiontype === 'toggle' ):

						var target = $(this).attr('data-target') || myapp_config.root_,
							dataClass = $(this).attr('data-class'),
							inputFocus = $(this).attr('data-focus');

						/* remove previous background image if alternate is selected */
						if ( dataClass.indexOf('mod-bg-') !== -1 ) {
							$(target).removeClass (function (index, css) {
								return (css.match (/(^|\s)mod-bg-\S+/g) || []).join(' ');
							});
						}

						/* trigger class change */
						$(target).toggleClass( dataClass );

						/* this allows us to add active class for dropdown toggle components */
						if ( $(this).hasClass('dropdown-item') ) {
							$(this).toggleClass('active');
						}

						/* focus input if available 
						   FAQ: We had to put a delay timer to slow it down for chrome
						*/
						if(inputFocus != undefined) {
							setTimeout(function(){ $('#' + inputFocus).focus(); }, 200);
						}

						/* save settings */
						if ( typeof classHolder != 'undefined' || classHolder != null ) {

							/* NOTE: saveSettings function is located right after <body> tag */
							initApp.checkNavigationOrientation();
							initApp.saveSettings();
						}

						break;

					/**
					 * toggle swap trigger
					 * Usage (target): <a href="#" data-action="toggle-swap" data-class=".add-this-class-to-target .another-class" data-target="#id">...</a>
					 **/
					case ( actiontype === 'toggle-swap' ):

						var target = $(this).attr('data-target'),
							dataClass = $(this).attr('data-class');

						/* trigger class change */
						$(target).removeClass().addClass( dataClass );

						break;

					/**
					 * panel 'collapse' trigger
					 **/
					case ( actiontype === 'panel-collapse' ):

						var selectedPanel = $(this).closest('.panel');

						selectedPanel.children('.panel-container').collapse('toggle')
						.on('show.bs.collapse', function() {
						  	selectedPanel.removeClass("panel-collapsed");

						  	if (myapp_config.debugState)
								console.log( "panel id:" + selectedPanel.attr('id') + " | action: uncollapsed" );

						}).on('hidden.bs.collapse', function(){
							selectedPanel.addClass("panel-collapsed");

							if (myapp_config.debugState)
								console.log( "panel id:" + selectedPanel.attr('id') + " | action: collapsed" );

						});
				
						/* return ID of panel */
						//return selectedPanel.attr('id');

						break;

					/**
					 * panel 'fullscreen' trigger
					 **/
					case ( actiontype === 'panel-fullscreen' ):

						var selectedPanel = $(this).closest('.panel');

						selectedPanel.toggleClass('panel-fullscreen');
						myapp_config.root_.toggleClass('panel-fullscreen');

						if (myapp_config.debugState)
						console.log( "panel id:" + selectedPanel.attr('id') + " | action: fullscreen" );

						/* return ID of panel */
						//return selectedPanel.attr('id');

						break;

					/**
					 * panel 'close' trigger
					 **/
					case ( actiontype === 'panel-close' ):

						var selectedPanel = $(this).closest('.panel');

						var killPanel = function (){

							selectedPanel.fadeOut(500,function(){
								/* remove panel */
								$(this).remove();

								if (myapp_config.debugState)
								console.log( "panel id:" + selectedPanel.attr('id') + " | action: removed" );
							});

						};

						if (typeof bootbox  != 'undefined') {

							initApp.playSound('media/sound', 'messagebox')

							bootbox.confirm({
								title: "<i class='fal fa-times-circle text-danger mr-2'></i> Do you wish to delete panel <span class='fw-500'>&nbsp;'" +selectedPanel.children('.panel-hdr').children('h2').text().trim()+ "'&nbsp;</span>?",
								message: "<span><strong>Warning:</strong> This action cannot be undone!</span>",
								centerVertical: true,
								swapButtonOrder: true,
								buttons: {
									confirm: {
										label: 'Yes',
										className: 'btn-danger shadow-0'
									},
									cancel: {
										label: 'No',
										className: 'btn-default'
									}
								},
								className: "modal-alert",
								closeButton: false,
								callback: function (result) {

									if (result == true) {
										killPanel();
									}
								}
							});

						} else {
							
							if (confirm( 'Do you wish to delete panel ' + selectedPanel.children('.panel-hdr').children('h2').text().trim() + '?' )) {
								killPanel();
							}

						}

						break;

					/**
					 * update header css, 'theme-update' trigger
					 * eg:  data-action = "theme-update" 
					 *      data-theme = "css/cust-theme-1.css"
					 **/
					case ( actiontype === 'theme-update' ):

						if ( $(myapp_config.mythemeAnchor).length) {
							$(myapp_config.mythemeAnchor).attr('href', $(this).attr('data-theme') );
						} else {
							var mytheme = $("<link>", {id: myapp_config.mythemeAnchor.replace('#', ''), "rel": "stylesheet", "href" : $(this).attr('data-theme') });
							$('head').append(mytheme);
						}

						initApp.saveSettings();

						break;

					/**
					 * theme 'app-reset' trigger
					 **/
					case ( actiontype === 'app-reset' ):

						initApp.resetSettings();

						break;

					/**
					 * theme 'factory-reset' trigger
					 **/
					case ( actiontype === 'factory-reset' ):

						initApp.factoryReset();

						break;	

					/**
					 * app print
					 * starts print priview for browser
					 **/
					case ( actiontype === 'app-print' ):

						window.print();

						break;

					/**
					 * ondemand
					 * load onDemand scripts
					 **/
					case ( actiontype === 'app-loadscript' ):

						var loadurl = $(this).attr('data-loadurl'),
							loadfunction = $(this).attr('data-loadfunction');

						initApp.loadScript(loadurl,loadfunction);

						break;	

					/**
					 * app language selection
					 * lazyloads i18n plugin and activates selected language
					 **/
					case ( actiontype === 'lang' ):

						var applang = $(this).attr('data-lang').toString();

						if (!$.i18n) {
						//jQuery.getScript('http://url/to/the/script');

							initApp.loadScript("js/i18n/i18n.js", 

								function activateLang () {
									
									$.i18n.init({
										resGetPath: 'media/data/__lng__.json',
										load: 'unspecific',
										fallbackLng: false,
										lng: applang
									}, function (t){
										$('[data-i18n]').i18n();
									});								
									
								}
							);

						} else {

							i18n.setLng(applang, function(){
								$('[data-i18n]').i18n();
								$('[data-lang]').removeClass('active');
								$(this).addClass('active');
							});

						}

						break;	

					/**
					 * app 'fullscreen' trigger
					 **/
					case ( actiontype === 'app-fullscreen' ):

						/* NOTE: this may not work for all browsers if the browser security does not permit it 
					 	   IE issues: http://stackoverflow.com/questions/33732805/fullscreen-not-working-in-ie */

						if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {

							if (document.documentElement.requestFullscreen) {
								/* Standard browsers */
								document.documentElement.requestFullscreen();
							} else if (document.documentElement.msRequestFullscreen) {
								/* Internet Explorer */
								document.documentElement.msRequestFullscreen();
							} else if (document.documentElement.mozRequestFullScreen) {
								/* Firefox */
								document.documentElement.mozRequestFullScreen();
							} else if (document.documentElement.webkitRequestFullscreen) {
								/* Chrome */
								document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
							}

							if (myapp_config.debugState)
								console.log( "app fullscreen toggle active" );

						} else {

							if (document.exitFullscreen) {
								document.exitFullscreen();
							} else if (document.msExitFullscreen) {
								document.msExitFullscreen();
							} else if (document.mozCancelFullScreen) {
								document.mozCancelFullScreen();
							} else if (document.webkitExitFullscreen) {
								document.webkitExitFullscreen();
							}

							if (myapp_config.debugState)
								console.log("%capp fullscreen toggle inactive! ", "color: #ed1c24");
						}

						break; 
				
					/**
					 * app 'playsound' trigger
					 * usage: data-action="playsound" data-soundpath="media/sound/" data-soundfile="filename" (no file extensions)
					 **/
					case ( actiontype === 'playsound' ):

						var path = $(this).attr('data-soundpath') || "media/sound/",
							sound = $(this).attr('data-soundfile');

						initApp.playSound(path,sound);

						break;

				}

				/* hide tooltip if any present */
				$(this).tooltip('hide');

				if (myapp_config.debugState)
					console.log("data-action clicked: " + actiontype);

				/* stop default link action */				
				e.stopPropagation(); 
				e.preventDefault();		
		}); 

		/**
		 * Windows mobile 8 fix ~
		 * DOC: bootstrap related
		 **/
		if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
			var msViewportStyle = document.createElement('style');
			msViewportStyle.appendChild(
				document.createTextNode(
					'@-ms-viewport{width:auto!important}'
				)
			);
			document.head.appendChild(msViewportStyle)
		};

		/**
		 * Display APP version
		 * DOC: only show this if debug state tree
		 **/
		 if (myapp_config.debugState)
		 	console.log("%c✔ Finished app.init() v" + myapp_config.VERSION + '\n' + "---------------------------", "color: #148f32");	
	};

	return app;
	
})({});

/**
 * Bind the throttled handler to the resize event.
 * NOTE: Please do not change the order displayed (e.g. 1a, 1b, 2a, 2b...etc)
 **/
$(window).resize(

 	$.throttle( myapp_config.throttleDelay, function (e) {

		 /**
		  * (1a) ADD CLASS WHEN BELOW CERTAIN WIDTH (MOBILE MENU)
		  * Description: tracks the page min-width of #CONTENT and NAV when navigation is resized.
		  * This is to counter bugs for minimum page width on many desktop and mobile devices.
		  **/
		  initApp.mobileCheckActivation();

		 /**
		  * (1b) CHECK NAVIGATION STATUS (IF HORIZONTAL OR VERTICAL)
		  * Description: fires an event to check for navigation orientation.
		  * Based on the condition, it will initliaze or destroy the slimscroll, or horizontal nav plugins
		  **/
		  initApp.checkNavigationOrientation();


		 /** -- insert your resize codes below this line -- **/
	 
	})
); 

/**
 * Bind the throttled handler to the scroll event
 **/
$(window).scroll(

 	$.throttle( myapp_config.throttleDelay, function (e) {

		 /**
		  * FIX APP HEIGHT
		  * Compare the height of nav and content;
		  * If one is longer/shorter than the other, measure them to be equal.
		  * This event is only fired on desktop.
		  **/
		  

		  /** -- insert your other scroll codes below this line -- **/

	})

);

/**
 * Initiate scroll events
 **/
$(window).on('scroll', initApp.windowScrollEvents);

/**
 * DOCUMENT LOADED EVENT
 * DOC: Fire when DOM is ready
 * Do not change order a, b, c, d...
 **/
jQuery(document).ready(function() {

	/**
	 * detect desktop or mobile 
	 **/
	initApp.addDeviceType();

	/**
	 * detect Webkit Browser 
	 **/
	initApp.detectBrowserType();

	/**
	 * a. check for mobile view width and add class .mobile-view-activated
	 **/
	initApp.mobileCheckActivation();

 	/**
	 * b. build navigation
	 **/
	initApp.buildNavigation(myapp_config.navHooks);

 	/**
	 * c. initialize nav filter
	 **/
	initApp.listFilter(myapp_config.navHooks, myapp_config.navFilterInput, myapp_config.navAnchor);

 	/**
	 * d. run DOM misc functions
	 **/
	initApp.domReadyMisc();

 	/**
	 * e. run app forms class detectors [parentClass,focusClass,disabledClass]
	 **/
	initApp.appForms('.input-group', 'has-length', 'has-disabled');

}); 

/**
 * Mobile orientation change events
 * DOC: recalculates app height
 **/
$( window ).on( "orientationchange", function( event ) {
	/* reset any .CSS heights and force appHeight function to recalculate */

	if (myapp_config.debugState)
		console.log("orientationchange event");
});

/**
 * Window load function
 * DOC: window focus blur detection
 **/
$(window).on("blur focus", function(e) {
    var prevType = $(this).data("prevType");
    /**
     * reduce double fire issues
     **/
    if (prevType != e.type) {   
        switch (e.type) {
            case "blur":
                myapp_config.root_.toggleClass("blur") 

                if (myapp_config.debugState)
                console.log("blur");
            
                break;
            case "focus":
                myapp_config.root_.toggleClass("blur")
                if (myapp_config.debugState)

                console.log("focused");

                break;
        }
    }

    $(this).data("prevType", e.type);
})
