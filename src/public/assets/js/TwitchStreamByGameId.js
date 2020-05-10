// modules are defined as an array
// [ module function, map of requires ]
//
// map of requires is short require name -> numeric require
//
// anything defined in a previous bundle is accessed via the
// orig method which is the require for previous bundles
parcelRequire = (function (modules, cache, entry, globalName) {
  // Save the require from previous bundle to this closure if any
  var previousRequire = typeof parcelRequire === 'function' && parcelRequire;
  var nodeRequire = typeof require === 'function' && require;

  function newRequire(name, jumped) {
    if (!cache[name]) {
      if (!modules[name]) {
        // if we cannot find the module within our internal map or
        // cache jump to the current global require ie. the last bundle
        // that was added to the page.
        var currentRequire = typeof parcelRequire === 'function' && parcelRequire;
        if (!jumped && currentRequire) {
          return currentRequire(name, true);
        }

        // If there are other bundles on this page the require from the
        // previous one is saved to 'previousRequire'. Repeat this as
        // many times as there are bundles until the module is found or
        // we exhaust the require chain.
        if (previousRequire) {
          return previousRequire(name, true);
        }

        // Try the node require function if it exists.
        if (nodeRequire && typeof name === 'string') {
          return nodeRequire(name);
        }

        var err = new Error('Cannot find module \'' + name + '\'');
        err.code = 'MODULE_NOT_FOUND';
        throw err;
      }

      localRequire.resolve = resolve;
      localRequire.cache = {};

      var module = cache[name] = new newRequire.Module(name);

      modules[name][0].call(module.exports, localRequire, module, module.exports, this);
    }

    return cache[name].exports;

    function localRequire(x){
      return newRequire(localRequire.resolve(x));
    }

    function resolve(x){
      return modules[name][1][x] || x;
    }
  }

  function Module(moduleName) {
    this.id = moduleName;
    this.bundle = newRequire;
    this.exports = {};
  }

  newRequire.isParcelRequire = true;
  newRequire.Module = Module;
  newRequire.modules = modules;
  newRequire.cache = cache;
  newRequire.parent = previousRequire;
  newRequire.register = function (id, exports) {
    modules[id] = [function (require, module) {
      module.exports = exports;
    }, {}];
  };

  var error;
  for (var i = 0; i < entry.length; i++) {
    try {
      newRequire(entry[i]);
    } catch (e) {
      // Save first error but execute all entries
      if (!error) {
        error = e;
      }
    }
  }

  if (entry.length) {
    // Expose entry point to Node, AMD or browser globals
    // Based on https://github.com/ForbesLindesay/umd/blob/master/template.js
    var mainExports = newRequire(entry[entry.length - 1]);

    // CommonJS
    if (typeof exports === "object" && typeof module !== "undefined") {
      module.exports = mainExports;

    // RequireJS
    } else if (typeof define === "function" && define.amd) {
     define(function () {
       return mainExports;
     });

    // <script>
    } else if (globalName) {
      this[globalName] = mainExports;
    }
  }

  // Override the current require with this new one
  parcelRequire = newRequire;

  if (error) {
    // throw error from earlier, _after updating parcelRequire_
    throw error;
  }

  return newRequire;
})({"twitch/src/WebRequest/WebRequest.ts":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var WebRequest =
/** @class */
function () {
  function WebRequest(_path, _headers, _onCompleteCallback) {
    this._path = _path;
    this._headers = _headers;
    this._onCompleteCallback = _onCompleteCallback;
  }

  WebRequest.prototype.get = function () {
    var _this = this;

    var request = new XMLHttpRequest();

    if (request.overrideMimeType) {
      request.overrideMimeType("application/json");
    }

    request.addEventListener("readystatechange", function (e) {
      return _this.onWebRequestLoaded(e);
    });
    request.open("GET", this._path, true);
    this.addHeaders(request);
    request.send(null);
  };

  WebRequest.prototype.post = function (formData) {
    var _this = this;

    var request = new XMLHttpRequest();

    if (request.overrideMimeType) {
      request.overrideMimeType("application/json");
    }

    request.addEventListener("readystatechange", function (e) {
      return _this.onWebRequestLoaded(e);
    });
    request.open("POST", this._path, true);
    this.addHeaders(request);
    request.send(formData);
  };

  WebRequest.prototype.addHeaders = function (request) {
    for (var header in this._headers) {
      request.setRequestHeader(header, this._headers[header]);
    }
  };

  WebRequest.prototype.onWebRequestLoaded = function (e) {
    var request = e.target;

    if (request.readyState == 4) {
      if (request.status == 200 || request.status == 0) {
        try {
          this.onComplete(request.responseText, null);
        } catch (e) {
          console.log(e);
          this.onComplete(null, {
            errorCode: -1,
            errorMessage: "Error parsing request"
          });
        }
      } else {
        this.onComplete(null, {
          errorMessage: request.responseText,
          errorCode: request.status
        });
      }
    }
  };

  WebRequest.prototype.onComplete = function (response, error) {
    this._onCompleteCallback(response, error);
  };

  return WebRequest;
}();

exports.WebRequest = WebRequest;
},{}],"twitch/src/WebRequest/WebRequestHandler.ts":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var WebRequest_1 = require("./WebRequest");

var WebRequestHandler =
/** @class */
function () {
  function WebRequestHandler(path, headers, onCompleteCallback) {
    this._parser = new WebRequest_1.WebRequest(path, headers, onCompleteCallback.bind(this));
  }

  WebRequestHandler.prototype.get = function () {
    this._parser.get();
  };

  WebRequestHandler.prototype.post = function (formData) {
    this._parser.post(formData);
  };

  return WebRequestHandler;
}();

exports.WebRequestHandler = WebRequestHandler;
},{"./WebRequest":"twitch/src/WebRequest/WebRequest.ts"}],"twitch/src/Twitch/GetStreamByGameId.ts":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var WebRequestHandler_1 = require("../WebRequest/WebRequestHandler");

var GetStreamByGameId =
/** @class */
function () {
  function GetStreamByGameId(onComplete) {
    this.onComplete = onComplete;
  }

  GetStreamByGameId.prototype.get = function (streamId) {
    this.webRequest = new WebRequestHandler_1.WebRequestHandler("/api/twitch/stream/" + streamId, null, this.onRequestComplete.bind(this));
    this.webRequest.get();
  };

  GetStreamByGameId.prototype.onRequestComplete = function (response, error) {
    if (error != null) {
      console.log("Error fetching streams");
      return;
    }

    this.onComplete(JSON.parse(response));
  };

  return GetStreamByGameId;
}();

exports.GetStreamByGameId = GetStreamByGameId;
},{"../WebRequest/WebRequestHandler":"twitch/src/WebRequest/WebRequestHandler.ts"}],"TwitchStreamByGameId.ts":[function(require,module,exports) {
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var GetStreamByGameId_1 = require("./twitch/src/Twitch/GetStreamByGameId");

var TwitchStreamByGameId =
/** @class */
function () {
  function TwitchStreamByGameId(containerId) {
    this.container = document.getElementById(containerId);
    var twitchStreamsByGameId = new GetStreamByGameId_1.GetStreamByGameId(this.onComplete.bind(this));

    if (window["URLSearchParams"] != null) {
      var searchParam = new URLSearchParams(window.location.search);
      var gameId = searchParam.get("game_id");
      twitchStreamsByGameId.get(gameId);
    }
  }

  TwitchStreamByGameId.prototype.onComplete = function (streams) {
    if (streams.length > 0) {
      this.container.innerHTML = "";
    }

    for (var i = 0; i < streams.length; i++) {
      this.container.appendChild(this.createResult(streams[i].user_name));
    }
  };

  TwitchStreamByGameId.prototype.createResult = function (username) {
    var resultItem = document.createElement("div");
    resultItem.classList.add("twitch-embed", "embed-responsive", "embed-responsive-4by3");
    resultItem.innerHTML += "\n            <iframe\n                src=\"https://player.twitch.tv/?channel=" + username + "&muted=true&autoplay=false\"\n                frameborder=\"0\"\n                scrolling=\"no\"\n                allowfullscreen=\"true\"\n                class=\"embed-responsive-item\">\n            </iframe>\n        ";
    return resultItem;
  };

  return TwitchStreamByGameId;
}();

exports.TwitchStreamByGameId = TwitchStreamByGameId;
new TwitchStreamByGameId("streams");
},{"./twitch/src/Twitch/GetStreamByGameId":"twitch/src/Twitch/GetStreamByGameId.ts"}],"C:/Users/Grant/AppData/Local/Yarn/Data/global/node_modules/parcel-bundler/src/builtins/hmr-runtime.js":[function(require,module,exports) {
var global = arguments[3];
var OVERLAY_ID = '__parcel__error__overlay__';
var OldModule = module.bundle.Module;

function Module(moduleName) {
  OldModule.call(this, moduleName);
  this.hot = {
    data: module.bundle.hotData,
    _acceptCallbacks: [],
    _disposeCallbacks: [],
    accept: function (fn) {
      this._acceptCallbacks.push(fn || function () {});
    },
    dispose: function (fn) {
      this._disposeCallbacks.push(fn);
    }
  };
  module.bundle.hotData = null;
}

module.bundle.Module = Module;
var checkedAssets, assetsToAccept;
var parent = module.bundle.parent;

if ((!parent || !parent.isParcelRequire) && typeof WebSocket !== 'undefined') {
  var hostname = "" || location.hostname;
  var protocol = location.protocol === 'https:' ? 'wss' : 'ws';
  var ws = new WebSocket(protocol + '://' + hostname + ':' + "49685" + '/');

  ws.onmessage = function (event) {
    checkedAssets = {};
    assetsToAccept = [];
    var data = JSON.parse(event.data);

    if (data.type === 'update') {
      var handled = false;
      data.assets.forEach(function (asset) {
        if (!asset.isNew) {
          var didAccept = hmrAcceptCheck(global.parcelRequire, asset.id);

          if (didAccept) {
            handled = true;
          }
        }
      }); // Enable HMR for CSS by default.

      handled = handled || data.assets.every(function (asset) {
        return asset.type === 'css' && asset.generated.js;
      });

      if (handled) {
        console.clear();
        data.assets.forEach(function (asset) {
          hmrApply(global.parcelRequire, asset);
        });
        assetsToAccept.forEach(function (v) {
          hmrAcceptRun(v[0], v[1]);
        });
      } else if (location.reload) {
        // `location` global exists in a web worker context but lacks `.reload()` function.
        location.reload();
      }
    }

    if (data.type === 'reload') {
      ws.close();

      ws.onclose = function () {
        location.reload();
      };
    }

    if (data.type === 'error-resolved') {
      console.log('[parcel] ✨ Error resolved');
      removeErrorOverlay();
    }

    if (data.type === 'error') {
      console.error('[parcel] 🚨  ' + data.error.message + '\n' + data.error.stack);
      removeErrorOverlay();
      var overlay = createErrorOverlay(data);
      document.body.appendChild(overlay);
    }
  };
}

function removeErrorOverlay() {
  var overlay = document.getElementById(OVERLAY_ID);

  if (overlay) {
    overlay.remove();
  }
}

function createErrorOverlay(data) {
  var overlay = document.createElement('div');
  overlay.id = OVERLAY_ID; // html encode message and stack trace

  var message = document.createElement('div');
  var stackTrace = document.createElement('pre');
  message.innerText = data.error.message;
  stackTrace.innerText = data.error.stack;
  overlay.innerHTML = '<div style="background: black; font-size: 16px; color: white; position: fixed; height: 100%; width: 100%; top: 0px; left: 0px; padding: 30px; opacity: 0.85; font-family: Menlo, Consolas, monospace; z-index: 9999;">' + '<span style="background: red; padding: 2px 4px; border-radius: 2px;">ERROR</span>' + '<span style="top: 2px; margin-left: 5px; position: relative;">🚨</span>' + '<div style="font-size: 18px; font-weight: bold; margin-top: 20px;">' + message.innerHTML + '</div>' + '<pre>' + stackTrace.innerHTML + '</pre>' + '</div>';
  return overlay;
}

function getParents(bundle, id) {
  var modules = bundle.modules;

  if (!modules) {
    return [];
  }

  var parents = [];
  var k, d, dep;

  for (k in modules) {
    for (d in modules[k][1]) {
      dep = modules[k][1][d];

      if (dep === id || Array.isArray(dep) && dep[dep.length - 1] === id) {
        parents.push(k);
      }
    }
  }

  if (bundle.parent) {
    parents = parents.concat(getParents(bundle.parent, id));
  }

  return parents;
}

function hmrApply(bundle, asset) {
  var modules = bundle.modules;

  if (!modules) {
    return;
  }

  if (modules[asset.id] || !bundle.parent) {
    var fn = new Function('require', 'module', 'exports', asset.generated.js);
    asset.isNew = !modules[asset.id];
    modules[asset.id] = [fn, asset.deps];
  } else if (bundle.parent) {
    hmrApply(bundle.parent, asset);
  }
}

function hmrAcceptCheck(bundle, id) {
  var modules = bundle.modules;

  if (!modules) {
    return;
  }

  if (!modules[id] && bundle.parent) {
    return hmrAcceptCheck(bundle.parent, id);
  }

  if (checkedAssets[id]) {
    return;
  }

  checkedAssets[id] = true;
  var cached = bundle.cache[id];
  assetsToAccept.push([bundle, id]);

  if (cached && cached.hot && cached.hot._acceptCallbacks.length) {
    return true;
  }

  return getParents(global.parcelRequire, id).some(function (id) {
    return hmrAcceptCheck(global.parcelRequire, id);
  });
}

function hmrAcceptRun(bundle, id) {
  var cached = bundle.cache[id];
  bundle.hotData = {};

  if (cached) {
    cached.hot.data = bundle.hotData;
  }

  if (cached && cached.hot && cached.hot._disposeCallbacks.length) {
    cached.hot._disposeCallbacks.forEach(function (cb) {
      cb(bundle.hotData);
    });
  }

  delete bundle.cache[id];
  bundle(id);
  cached = bundle.cache[id];

  if (cached && cached.hot && cached.hot._acceptCallbacks.length) {
    cached.hot._acceptCallbacks.forEach(function (cb) {
      cb();
    });

    return true;
  }
}
},{}]},{},["C:/Users/Grant/AppData/Local/Yarn/Data/global/node_modules/parcel-bundler/src/builtins/hmr-runtime.js","TwitchStreamByGameId.ts"], null)