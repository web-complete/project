(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.IMask = factory());
}(this, (function () { 'use strict';

// 7.2.1 RequireObjectCoercible(argument)
var _defined = function(it){
  if(it == undefined)throw TypeError("Can't call method on  " + it);
  return it;
};

// 7.1.13 ToObject(argument)

var _toObject = function(it){
  return Object(_defined(it));
};

var hasOwnProperty = {}.hasOwnProperty;
var _has = function(it, key){
  return hasOwnProperty.call(it, key);
};

var toString = {}.toString;

var _cof = function(it){
  return toString.call(it).slice(8, -1);
};

// fallback for non-array-like ES3 and non-enumerable old V8 strings

var _iobject = Object('z').propertyIsEnumerable(0) ? Object : function(it){
  return _cof(it) == 'String' ? it.split('') : Object(it);
};

// to indexed object, toObject with fallback for non-array-like ES3 strings

var _toIobject = function(it){
  return _iobject(_defined(it));
};

// 7.1.4 ToInteger
var ceil  = Math.ceil;
var floor = Math.floor;
var _toInteger = function(it){
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};

// 7.1.15 ToLength
var min       = Math.min;
var _toLength = function(it){
  return it > 0 ? min(_toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};

var max       = Math.max;
var min$1       = Math.min;
var _toIndex = function(index, length){
  index = _toInteger(index);
  return index < 0 ? max(index + length, 0) : min$1(index, length);
};

// false -> Array#indexOf
// true  -> Array#includes

var _arrayIncludes = function(IS_INCLUDES){
  return function($this, el, fromIndex){
    var O      = _toIobject($this)
      , length = _toLength(O.length)
      , index  = _toIndex(fromIndex, length)
      , value;
    // Array#includes uses SameValueZero equality algorithm
    if(IS_INCLUDES && el != el)while(length > index){
      value = O[index++];
      if(value != value)return true;
    // Array#toIndex ignores holes, Array#includes - not
    } else for(;length > index; index++)if(IS_INCLUDES || index in O){
      if(O[index] === el)return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};

function createCommonjsModule(fn, module) {
	return module = { exports: {} }, fn(module, module.exports), module.exports;
}

var _global = createCommonjsModule(function (module) {
// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self : Function('return this')();
if(typeof __g == 'number')__g = global; // eslint-disable-line no-undef
});

var SHARED = '__core-js_shared__';
var store  = _global[SHARED] || (_global[SHARED] = {});
var _shared = function(key){
  return store[key] || (store[key] = {});
};

var id = 0;
var px = Math.random();
var _uid = function(key){
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};

var shared = _shared('keys');
var _sharedKey = function(key){
  return shared[key] || (shared[key] = _uid(key));
};

var arrayIndexOf = _arrayIncludes(false);
var IE_PROTO     = _sharedKey('IE_PROTO');

var _objectKeysInternal = function(object, names){
  var O      = _toIobject(object)
    , i      = 0
    , result = []
    , key;
  for(key in O)if(key != IE_PROTO)_has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while(names.length > i)if(_has(O, key = names[i++])){
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};

// IE 8- don't enum bug keys
var _enumBugKeys = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');

// 19.1.2.14 / 15.2.3.14 Object.keys(O)


var _objectKeys = Object.keys || function keys(O){
  return _objectKeysInternal(O, _enumBugKeys);
};

var _core = createCommonjsModule(function (module) {
var core = module.exports = {version: '2.4.0'};
if(typeof __e == 'number')__e = core; // eslint-disable-line no-undef
});

var _core_1 = _core.version;

var _isObject = function(it){
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};

var _anObject = function(it){
  if(!_isObject(it))throw TypeError(it + ' is not an object!');
  return it;
};

var _fails = function(exec){
  try {
    return !!exec();
  } catch(e){
    return true;
  }
};

// Thank's IE8 for his funny defineProperty
var _descriptors = !_fails(function(){
  return Object.defineProperty({}, 'a', {get: function(){ return 7; }}).a != 7;
});

var document$1 = _global.document;
var is = _isObject(document$1) && _isObject(document$1.createElement);
var _domCreate = function(it){
  return is ? document$1.createElement(it) : {};
};

var _ie8DomDefine = !_descriptors && !_fails(function(){
  return Object.defineProperty(_domCreate('div'), 'a', {get: function(){ return 7; }}).a != 7;
});

// 7.1.1 ToPrimitive(input [, PreferredType])

// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
var _toPrimitive = function(it, S){
  if(!_isObject(it))return it;
  var fn, val;
  if(S && typeof (fn = it.toString) == 'function' && !_isObject(val = fn.call(it)))return val;
  if(typeof (fn = it.valueOf) == 'function' && !_isObject(val = fn.call(it)))return val;
  if(!S && typeof (fn = it.toString) == 'function' && !_isObject(val = fn.call(it)))return val;
  throw TypeError("Can't convert object to primitive value");
};

var dP             = Object.defineProperty;

var f = _descriptors ? Object.defineProperty : function defineProperty(O, P, Attributes){
  _anObject(O);
  P = _toPrimitive(P, true);
  _anObject(Attributes);
  if(_ie8DomDefine)try {
    return dP(O, P, Attributes);
  } catch(e){ /* empty */ }
  if('get' in Attributes || 'set' in Attributes)throw TypeError('Accessors not supported!');
  if('value' in Attributes)O[P] = Attributes.value;
  return O;
};

var _objectDp = {
	f: f
};

var _propertyDesc = function(bitmap, value){
  return {
    enumerable  : !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable    : !(bitmap & 4),
    value       : value
  };
};

var _hide = _descriptors ? function(object, key, value){
  return _objectDp.f(object, key, _propertyDesc(1, value));
} : function(object, key, value){
  object[key] = value;
  return object;
};

var _redefine = createCommonjsModule(function (module) {
var SRC       = _uid('src')
  , TO_STRING = 'toString'
  , $toString = Function[TO_STRING]
  , TPL       = ('' + $toString).split(TO_STRING);

_core.inspectSource = function(it){
  return $toString.call(it);
};

(module.exports = function(O, key, val, safe){
  var isFunction = typeof val == 'function';
  if(isFunction)_has(val, 'name') || _hide(val, 'name', key);
  if(O[key] === val)return;
  if(isFunction)_has(val, SRC) || _hide(val, SRC, O[key] ? '' + O[key] : TPL.join(String(key)));
  if(O === _global){
    O[key] = val;
  } else {
    if(!safe){
      delete O[key];
      _hide(O, key, val);
    } else {
      if(O[key])O[key] = val;
      else _hide(O, key, val);
    }
  }
// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
})(Function.prototype, TO_STRING, function toString(){
  return typeof this == 'function' && this[SRC] || $toString.call(this);
});
});

var _aFunction = function(it){
  if(typeof it != 'function')throw TypeError(it + ' is not a function!');
  return it;
};

// optional / simple context binding

var _ctx = function(fn, that, length){
  _aFunction(fn);
  if(that === undefined)return fn;
  switch(length){
    case 1: return function(a){
      return fn.call(that, a);
    };
    case 2: return function(a, b){
      return fn.call(that, a, b);
    };
    case 3: return function(a, b, c){
      return fn.call(that, a, b, c);
    };
  }
  return function(/* ...args */){
    return fn.apply(that, arguments);
  };
};

var PROTOTYPE = 'prototype';

var $export = function(type, name, source){
  var IS_FORCED = type & $export.F
    , IS_GLOBAL = type & $export.G
    , IS_STATIC = type & $export.S
    , IS_PROTO  = type & $export.P
    , IS_BIND   = type & $export.B
    , target    = IS_GLOBAL ? _global : IS_STATIC ? _global[name] || (_global[name] = {}) : (_global[name] || {})[PROTOTYPE]
    , exports   = IS_GLOBAL ? _core : _core[name] || (_core[name] = {})
    , expProto  = exports[PROTOTYPE] || (exports[PROTOTYPE] = {})
    , key, own, out, exp;
  if(IS_GLOBAL)source = name;
  for(key in source){
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    // export native or passed
    out = (own ? target : source)[key];
    // bind timers to global for call from export context
    exp = IS_BIND && own ? _ctx(out, _global) : IS_PROTO && typeof out == 'function' ? _ctx(Function.call, out) : out;
    // extend global
    if(target)_redefine(target, key, out, type & $export.U);
    // export
    if(exports[key] != out)_hide(exports, key, exp);
    if(IS_PROTO && expProto[key] != out)expProto[key] = out;
  }
};
_global.core = _core;
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library` 
var _export = $export;

// most Object methods by ES6 should accept primitives

var _objectSap = function(KEY, exec){
  var fn  = (_core.Object || {})[KEY] || Object[KEY]
    , exp = {};
  exp[KEY] = exec(fn);
  _export(_export.S + _export.F * _fails(function(){ fn(1); }), 'Object', exp);
};

// 19.1.2.14 Object.keys(O)


_objectSap('keys', function(){
  return function keys(it){
    return _objectKeys(_toObject(it));
  };
});

var keys = _core.Object.keys;

var _stringRepeat = function repeat(count){
  var str = String(_defined(this))
    , res = ''
    , n   = _toInteger(count);
  if(n < 0 || n == Infinity)throw RangeError("Count can't be negative");
  for(;n > 0; (n >>>= 1) && (str += str))if(n & 1)res += str;
  return res;
};

_export(_export.P, 'String', {
  // 21.1.3.13 String.prototype.repeat(count)
  repeat: _stringRepeat
});

var repeat = _core.String.repeat;

// https://github.com/tc39/proposal-string-pad-start-end


var _stringPad = function(that, maxLength, fillString, left){
  var S            = String(_defined(that))
    , stringLength = S.length
    , fillStr      = fillString === undefined ? ' ' : String(fillString)
    , intMaxLength = _toLength(maxLength);
  if(intMaxLength <= stringLength || fillStr == '')return S;
  var fillLen = intMaxLength - stringLength
    , stringFiller = _stringRepeat.call(fillStr, Math.ceil(fillLen / fillStr.length));
  if(stringFiller.length > fillLen)stringFiller = stringFiller.slice(0, fillLen);
  return left ? stringFiller + S : S + stringFiller;
};

// https://github.com/tc39/proposal-string-pad-start-end


_export(_export.P, 'String', {
  padStart: function padStart(maxLength /*, fillString = ' ' */){
    return _stringPad(this, maxLength, arguments.length > 1 ? arguments[1] : undefined, true);
  }
});

var padStart = _core.String.padStart;

// https://github.com/tc39/proposal-string-pad-start-end


_export(_export.P, 'String', {
  padEnd: function padEnd(maxLength /*, fillString = ' ' */){
    return _stringPad(this, maxLength, arguments.length > 1 ? arguments[1] : undefined, false);
  }
});

var padEnd = _core.String.padEnd;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
  return typeof obj;
} : function (obj) {
  return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
};











var classCallCheck = function (instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

var createClass = function () {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
}();







var _extends = Object.assign || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};



var inherits = function (subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function, not " + typeof superClass);
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      enumerable: false,
      writable: true,
      configurable: true
    }
  });
  if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
};











var possibleConstructorReturn = function (self, call) {
  if (!self) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return call && (typeof call === "object" || typeof call === "function") ? call : self;
};

function isString(str) {
  return typeof str === 'string' || str instanceof String;
}

function conform(res, str) {
  var fallback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';

  return isString(res) ? res : res ? str : fallback;
}

var DIRECTION = {
  NONE: 0,
  LEFT: -1,
  RIGHT: 1
};


function indexInDirection(pos, direction) {
  if (direction === DIRECTION.LEFT) --pos;
  return pos;
}

function escapeRegExp(str) {
  return str.replace(/([.*+?^=!:${}()|[\]/\\])/g, '\\$1');
}

// cloned from https://github.com/epoberezkin/fast-deep-equal with small changes
function objectIncludes(b, a) {
  if (a === b) return true;

  var arrA = Array.isArray(a),
      arrB = Array.isArray(b),
      i;

  if (arrA && arrB) {
    if (a.length != b.length) return false;
    for (i = 0; i < a.length; i++) {
      if (!objectIncludes(a[i], b[i])) return false;
    }return true;
  }

  if (arrA != arrB) return false;

  if (a && b && (typeof a === 'undefined' ? 'undefined' : _typeof(a)) === 'object' && (typeof b === 'undefined' ? 'undefined' : _typeof(b)) === 'object') {
    var keys = Object.keys(a);
    // if (keys.length !== Object.keys(b).length) return false;

    var dateA = a instanceof Date,
        dateB = b instanceof Date;
    if (dateA && dateB) return a.getTime() == b.getTime();
    if (dateA != dateB) return false;

    var regexpA = a instanceof RegExp,
        regexpB = b instanceof RegExp;
    if (regexpA && regexpB) return a.toString() == b.toString();
    if (regexpA != regexpB) return false;

    for (i = 0; i < keys.length; i++) {
      if (!Object.prototype.hasOwnProperty.call(b, keys[i])) return false;
    }for (i = 0; i < keys.length; i++) {
      if (!objectIncludes(a[keys[i]], b[keys[i]])) return false;
    }return true;
  }

  return false;
}

/* eslint-disable no-undef */
var g = typeof window !== 'undefined' && window || typeof global !== 'undefined' && global.global === global && global || typeof self !== 'undefined' && self.self === self && self || {};
/* eslint-enable no-undef */

var ActionDetails = function () {
  function ActionDetails(value, cursorPos, oldValue, oldSelection) {
    classCallCheck(this, ActionDetails);

    this.value = value;
    this.cursorPos = cursorPos;
    this.oldValue = oldValue;
    this.oldSelection = oldSelection;

    // double check if left part was changed (autofilling, other non-standard input triggers)
    while (this.value.slice(0, this.startChangePos) !== this.oldValue.slice(0, this.startChangePos)) {
      --this.oldSelection.start;
    }
  }

  createClass(ActionDetails, [{
    key: 'startChangePos',
    get: function get$$1() {
      return Math.min(this.cursorPos, this.oldSelection.start);
    }
  }, {
    key: 'insertedCount',
    get: function get$$1() {
      return this.cursorPos - this.startChangePos;
    }
  }, {
    key: 'inserted',
    get: function get$$1() {
      return this.value.substr(this.startChangePos, this.insertedCount);
    }
  }, {
    key: 'removedCount',
    get: function get$$1() {
      // Math.max for opposite operation
      return Math.max(this.oldSelection.end - this.startChangePos ||
      // for Delete
      this.oldValue.length - this.value.length, 0);
    }
  }, {
    key: 'removed',
    get: function get$$1() {
      return this.oldValue.substr(this.startChangePos, this.removedCount);
    }
  }, {
    key: 'head',
    get: function get$$1() {
      return this.value.substring(0, this.startChangePos);
    }
  }, {
    key: 'tail',
    get: function get$$1() {
      return this.value.substring(this.startChangePos + this.insertedCount);
    }
  }, {
    key: 'removeDirection',
    get: function get$$1() {
      if (!this.removedCount || this.insertedCount) return DIRECTION.NONE;

      // align right if delete at right or if range removed (event with backspace)
      return this.oldSelection.end === this.cursorPos || this.oldSelection.start === this.cursorPos ? DIRECTION.RIGHT : DIRECTION.LEFT;
    }
  }]);
  return ActionDetails;
}();

var ChangeDetails = function () {
  function ChangeDetails(details) {
    classCallCheck(this, ChangeDetails);

    _extends(this, {
      inserted: '',
      overflow: false,
      removedCount: 0,
      shift: 0
    }, details);
  }

  ChangeDetails.prototype.aggregate = function aggregate(details) {
    this.inserted += details.inserted;
    this.removedCount += details.removedCount;
    this.shift += details.shift;
    this.overflow = this.overflow || details.overflow;
    if (details.rawInserted) this.rawInserted += details.rawInserted;
    return this;
  };

  createClass(ChangeDetails, [{
    key: 'offset',
    get: function get$$1() {
      return this.shift + this.inserted.length - this.removedCount;
    }
  }, {
    key: 'rawInserted',
    get: function get$$1() {
      return this._rawInserted != null ? this._rawInserted : this.inserted;
    },
    set: function set$$1(rawInserted) {
      this._rawInserted = rawInserted;
    }
  }]);
  return ChangeDetails;
}();

var Masked = function () {
  function Masked(opts) {
    classCallCheck(this, Masked);

    this._value = '';
    this._update(_extends({}, Masked.DEFAULTS, opts));
    this.isInitialized = true;
  } // $Shape<MaskedOptions>; TODO after fix https://github.com/facebook/flow/issues/4773

  Masked.prototype.updateOptions = function updateOptions(opts) {
    this.withValueRefresh(this._update.bind(this, opts));
  };

  Masked.prototype._update = function _update(opts) {
    _extends(this, opts);
  };

  Masked.prototype.clone = function clone() {
    var m = new Masked(this);
    m._value = this.value.slice();
    return m;
  };

  Masked.prototype.reset = function reset() {
    this._value = '';
  };

  Masked.prototype.resolve = function resolve(value) {
    this.reset();
    this._append(value, { input: true });
    this._appendTail();
    this.doCommit();
    return this.value;
  };

  Masked.prototype.nearestInputPos = function nearestInputPos(cursorPos, direction) {
    return cursorPos;
  };

  Masked.prototype.extractInput = function extractInput() {
    var fromPos = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var toPos = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length;
    return this.value.slice(fromPos, toPos);
  };

  Masked.prototype._extractTail = function _extractTail() {
    var fromPos = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var toPos = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length;

    return this.extractInput(fromPos, toPos);
  };

  Masked.prototype._appendTail = function _appendTail() {
    var tail = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";

    return this._append(tail, { tail: true });
  };

  Masked.prototype._append = function _append(str) {
    var flags = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    var oldValueLength = this.value.length;
    var consistentValue = this.clone();
    var overflow = false;

    str = this.doPrepare(str, flags);

    for (var ci = 0; ci < str.length; ++ci) {
      this._value += str[ci];
      if (this.doValidate(flags) === false) {
        // $FlowFixMe
        _extends(this, consistentValue);
        if (!flags.input) {
          // in `input` mode dont skip invalid chars
          overflow = true;
          break;
        }
      }

      consistentValue = this.clone();
    }

    return new ChangeDetails({
      inserted: this.value.slice(oldValueLength),
      overflow: overflow
    });
  };

  Masked.prototype.appendWithTail = function appendWithTail(str, tail) {
    // TODO refactor
    var aggregateDetails = new ChangeDetails();
    var consistentValue = this.clone();
    var consistentAppended = void 0;

    for (var ci = 0; ci < str.length; ++ci) {
      var ch = str[ci];

      var appendDetails = this._append(ch, { input: true });
      consistentAppended = this.clone();
      var tailAppended = !appendDetails.overflow && !this._appendTail(tail).overflow;
      if (!tailAppended || this.doValidate({ tail: true }) === false) {
        // $FlowFixMe
        _extends(this, consistentValue);
        break;
      }

      // $FlowFixMe
      _extends(this, consistentAppended);
      consistentValue = this.clone();
      aggregateDetails.aggregate(appendDetails);
    }

    // TODO needed for cases when
    // 1) REMOVE ONLY AND NO LOOP AT ALL
    // 2) last loop iteration removes tail
    // 3) when breaks on tail insert

    // aggregate only shift from tail
    aggregateDetails.shift += this._appendTail(tail).shift;

    return aggregateDetails;
  };

  Masked.prototype._unmask = function _unmask() {
    return this.value;
  };

  Masked.prototype.remove = function remove() {
    var from = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var count = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length - from;

    this._value = this.value.slice(0, from) + this.value.slice(from + count);
  };

  Masked.prototype.withValueRefresh = function withValueRefresh(fn) {
    if (this._refreshing || !this.isInitialized) return fn();
    this._refreshing = true;

    var unmasked = this.unmaskedValue;

    var ret = fn();

    this.unmaskedValue = unmasked;

    delete this._refreshing;
    return ret;
  };

  Masked.prototype.doPrepare = function doPrepare(str) {
    var flags = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    return this.prepare(str, this, flags);
  };

  Masked.prototype.doValidate = function doValidate(flags) {
    return this.validate(this.value, this, flags);
  };

  Masked.prototype.doCommit = function doCommit() {
    this.commit(this.value, this);
  };

  // TODO
  // insert (str, fromPos, flags)

  Masked.prototype.splice = function splice(start, deleteCount, inserted, removeDirection) {
    var tailPos = start + deleteCount;
    var tail = this._extractTail(tailPos);

    var startChangePos = this.nearestInputPos(start, removeDirection);
    this.remove(startChangePos);
    var changeDetails = this.appendWithTail(inserted, tail);

    // adjust shift if start was aligned
    changeDetails.shift += startChangePos - start;
    return changeDetails;
  };

  createClass(Masked, [{
    key: 'value',
    get: function get$$1() {
      return this._value;
    },
    set: function set$$1(value) {
      this.resolve(value);
    }
  }, {
    key: 'unmaskedValue',
    get: function get$$1() {
      return this._unmask();
    },
    set: function set$$1(value) {
      this.reset();
      this._append(value);
      this._appendTail();
      this.doCommit();
    }
  }, {
    key: 'rawInputValue',
    get: function get$$1() {
      return this.extractInput(0, this.value.length, { raw: true });
    },
    set: function set$$1(value) {
      this.reset();
      this._append(value, { raw: true });
      this._appendTail();
      this.doCommit();
    }
  }, {
    key: 'isComplete',
    get: function get$$1() {
      return true;
    }
  }]);
  return Masked;
}();

Masked.DEFAULTS = {
  prepare: function prepare(val) {
    return val;
  },
  validate: function validate() {
    return true;
  },
  commit: function commit() {}
};

function maskedClass(mask) {
  if (mask == null) {
    throw new Error('mask property should be defined');
  }

  if (mask instanceof RegExp) return g.IMask.MaskedRegExp;
  if (isString(mask)) return g.IMask.MaskedPattern;
  if (mask instanceof Date || mask === Date) return g.IMask.MaskedDate;
  if (mask instanceof Number || typeof mask === 'number' || mask === Number) return g.IMask.MaskedNumber;
  if (Array.isArray(mask) || mask === Array) return g.IMask.MaskedDynamic;
  // $FlowFixMe
  if (mask.prototype instanceof g.IMask.Masked) return mask;
  // $FlowFixMe
  if (mask instanceof Function) return g.IMask.MaskedFunction;

  console.warn('Mask not found for mask', mask); // eslint-disable-line no-console
  return g.IMask.Masked;
}

function createMask(opts) {
  opts = _extends({}, opts); // clone
  var mask = opts.mask;

  if (mask instanceof g.IMask.Masked) return mask;

  var MaskedClass = maskedClass(mask);
  return new MaskedClass(opts);
}

var PatternDefinition = function () {
  function PatternDefinition(opts) {
    classCallCheck(this, PatternDefinition);
    // TODO flow
    _extends(this, opts);

    if (this.mask) {
      this._masked = createMask(opts);
    }
  }

  PatternDefinition.prototype.reset = function reset() {
    this.isHollow = false;
    this.isRawInput = false;
    if (this._masked) this._masked.reset();
  };

  PatternDefinition.prototype.resolve = function resolve(ch) {
    if (!this._masked) return false;
    return this._masked.resolve(ch);
  };

  createClass(PatternDefinition, [{
    key: 'isInput',
    get: function get$$1() {
      return this.type === PatternDefinition.TYPES.INPUT;
    }
  }, {
    key: 'isHiddenHollow',
    get: function get$$1() {
      return this.isHollow && this.optional;
    }
  }]);
  return PatternDefinition;
}();

PatternDefinition.DEFAULTS = {
  '0': /\d/,
  'a': /[\u0041-\u005A\u0061-\u007A\u00AA\u00B5\u00BA\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0\u08A2-\u08AC\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097F\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D\u0C58\u0C59\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D60\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191C\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19C1-\u19C7\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA697\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA80-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC]/, // http://stackoverflow.com/a/22075070
  '*': /./
};
PatternDefinition.TYPES = {
  INPUT: 'input',
  FIXED: 'fixed'
};

var PatternGroup = function () {
  function PatternGroup(masked, _ref) {
    var name = _ref.name,
        offset = _ref.offset,
        mask = _ref.mask,
        validate = _ref.validate;
    classCallCheck(this, PatternGroup);

    this.masked = masked;
    this.name = name;
    this.offset = offset;
    this.mask = mask;
    this.validate = validate || function () {
      return true;
    };
  }

  PatternGroup.prototype.doValidate = function doValidate(flags) {
    return this.validate(this.value, this, flags);
  };

  createClass(PatternGroup, [{
    key: 'value',
    get: function get$$1() {
      return this.masked.value.slice(this.masked.mapDefIndexToPos(this.offset), this.masked.mapDefIndexToPos(this.offset + this.mask.length));
    }
  }, {
    key: 'unmaskedValue',
    get: function get$$1() {
      return this.masked.extractInput(this.masked.mapDefIndexToPos(this.offset), this.masked.mapDefIndexToPos(this.offset + this.mask.length));
    }
  }]);
  return PatternGroup;
}();

var RangeGroup = function () {
  function RangeGroup(_ref2) {
    var from = _ref2[0],
        to = _ref2[1];
    var maxlen = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : String(to).length;
    classCallCheck(this, RangeGroup);

    this._from = from;
    this._to = to;
    this._maxLength = maxlen;
    this.validate = this.validate.bind(this);

    this._update();
  }

  RangeGroup.prototype._update = function _update() {
    this._maxLength = Math.max(this._maxLength, String(this.to).length);
    this.mask = '0'.repeat(this._maxLength);
  };

  RangeGroup.prototype.validate = function validate(str) {
    var minstr = '';
    var maxstr = '';

    var _ref3 = str.match(/^(\D*)(\d*)(\D*)/) || [],
        placeholder = _ref3[1],
        num = _ref3[2];

    if (num) {
      minstr = '0'.repeat(placeholder.length) + num;
      maxstr = '9'.repeat(placeholder.length) + num;
    }

    var firstNonZero = str.search(/[^0]/);
    if (firstNonZero === -1 && str.length <= this._matchFrom) return true;

    minstr = minstr.padEnd(this._maxLength, '0');
    maxstr = maxstr.padEnd(this._maxLength, '9');

    return this.from <= Number(maxstr) && Number(minstr) <= this.to;
  };

  createClass(RangeGroup, [{
    key: 'to',
    get: function get$$1() {
      return this._to;
    },
    set: function set$$1(to) {
      this._to = to;
      this._update();
    }
  }, {
    key: 'from',
    get: function get$$1() {
      return this._from;
    },
    set: function set$$1(from) {
      this._from = from;
      this._update();
    }
  }, {
    key: 'maxLength',
    get: function get$$1() {
      return this._maxLength;
    },
    set: function set$$1(maxLength) {
      this._maxLength = maxLength;
      this._update();
    }
  }, {
    key: '_matchFrom',
    get: function get$$1() {
      return this.maxLength - String(this.from).length;
    }
  }]);
  return RangeGroup;
}();

function EnumGroup(enums) {
  return {
    mask: '*'.repeat(enums[0].length),
    validate: function validate(value, group, flags) {
      return enums.some(function (e) {
        return e.indexOf(group.unmaskedValue) >= 0;
      });
    }
  };
}

PatternGroup.Range = RangeGroup;
PatternGroup.Enum = EnumGroup;

var MaskedPattern = function (_Masked) {
  inherits(MaskedPattern, _Masked);

  // TODO deprecated, remove in 3.0
  // TODO mask type
  function MaskedPattern() {
    var opts = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    classCallCheck(this, MaskedPattern);
    // TODO type $Shape<MaskedPatternOptions>={} does not work
    opts.definitions = _extends({}, PatternDefinition.DEFAULTS, opts.definitions);
    return possibleConstructorReturn(this, _Masked.call(this, _extends({}, MaskedPattern.DEFAULTS, opts)));
  }

  MaskedPattern.prototype._update = function _update() {
    var opts = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    opts.definitions = _extends({}, this.definitions, opts.definitions);
    if (opts.placeholder != null) {
      console.warn("'placeholder' option is deprecated and will be removed in next major release, use 'placeholderChar' and 'lazy' instead.");
      if ('char' in opts.placeholder) opts.placeholderChar = opts.placeholder.char;
      if ('lazy' in opts.placeholder) opts.lazy = opts.placeholder.lazy;
      delete opts.placeholder;
    }
    if (opts.placeholderLazy != null) {
      console.warn("'placeholderLazy' option is deprecated and will be removed in next major release, use 'lazy' instead.");
      opts.lazy = opts.placeholderLazy;
      delete opts.placeholderLazy;
    }
    _Masked.prototype._update.call(this, opts);
    this._updateMask();
  };

  MaskedPattern.prototype._updateMask = function _updateMask() {
    var _this2 = this;

    var defs = this.definitions;
    this._charDefs = [];
    this._groupDefs = [];

    var pattern = this.mask;
    if (!pattern || !defs) return;

    var unmaskingBlock = false;
    var optionalBlock = false;
    var stopAlign = false;

    var _loop = function _loop(_i) {
      if (_this2.groups) {
        var p = pattern.slice(_i);
        var gNames = Object.keys(_this2.groups).filter(function (gName) {
          return p.indexOf(gName) === 0;
        });
        // order by key length
        gNames.sort(function (a, b) {
          return b.length - a.length;
        });
        // use group name with max length
        var gName = gNames[0];
        if (gName) {
          var group = _this2.groups[gName];
          _this2._groupDefs.push(new PatternGroup(_this2, {
            name: gName,
            offset: _this2._charDefs.length,
            mask: group.mask,
            validate: group.validate
          }));
          pattern = pattern.replace(gName, group.mask);
        }
      }

      var char = pattern[_i];
      var type = !unmaskingBlock && char in defs ? PatternDefinition.TYPES.INPUT : PatternDefinition.TYPES.FIXED;
      var unmasking = type === PatternDefinition.TYPES.INPUT || unmaskingBlock;
      var optional = type === PatternDefinition.TYPES.INPUT && optionalBlock;

      if (char === MaskedPattern.STOP_CHAR) {
        stopAlign = true;
        return 'continue';
      }

      if (char === '{' || char === '}') {
        unmaskingBlock = !unmaskingBlock;
        return 'continue';
      }

      if (char === '[' || char === ']') {
        optionalBlock = !optionalBlock;
        return 'continue';
      }

      if (char === MaskedPattern.ESCAPE_CHAR) {
        ++_i;
        char = pattern[_i];
        if (!char) return 'break';
        type = PatternDefinition.TYPES.FIXED;
      }

      _this2._charDefs.push(new PatternDefinition({
        char: char,
        type: type,
        optional: optional,
        stopAlign: stopAlign,
        unmasking: unmasking,
        mask: type === PatternDefinition.TYPES.INPUT ? defs[char] : function (value) {
          return value === char;
        }
      }));

      stopAlign = false;
      i = _i;
    };

    _loop2: for (var i = 0; i < pattern.length; ++i) {
      var _ret = _loop(i);

      switch (_ret) {
        case 'continue':
          continue;

        case 'break':
          break _loop2;}
    }
  };

  MaskedPattern.prototype.doValidate = function doValidate() {
    var _Masked$prototype$doV;

    for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    return this._groupDefs.every(function (g$$1) {
      return g$$1.doValidate.apply(g$$1, args);
    }) && (_Masked$prototype$doV = _Masked.prototype.doValidate).call.apply(_Masked$prototype$doV, [this].concat(args));
  };

  MaskedPattern.prototype.clone = function clone() {
    var _this3 = this;

    var m = new MaskedPattern(this);
    m._value = this.value;
    // $FlowFixMe
    m._charDefs.forEach(function (d, i) {
      return _extends(d, _this3._charDefs[i]);
    });
    // $FlowFixMe
    m._groupDefs.forEach(function (d, i) {
      return _extends(d, _this3._groupDefs[i]);
    });
    return m;
  };

  MaskedPattern.prototype.reset = function reset() {
    _Masked.prototype.reset.call(this);
    this._charDefs.forEach(function (d) {
      delete d.isHollow;
    });
  };

  MaskedPattern.prototype.hiddenHollowsBefore = function hiddenHollowsBefore(defIndex) {
    return this._charDefs.slice(0, defIndex).filter(function (d) {
      return d.isHiddenHollow;
    }).length;
  };

  MaskedPattern.prototype.mapDefIndexToPos = function mapDefIndexToPos(defIndex) {
    return defIndex - this.hiddenHollowsBefore(defIndex);
  };

  MaskedPattern.prototype.mapPosToDefIndex = function mapPosToDefIndex(pos) {
    var defIndex = pos;
    for (var di = 0; di < this._charDefs.length; ++di) {
      var def = this._charDefs[di];
      if (di >= defIndex) break;
      if (def.isHiddenHollow) ++defIndex;
    }
    return defIndex;
  };

  MaskedPattern.prototype._unmask = function _unmask() {
    var str = this.value;
    var unmasked = '';

    for (var ci = 0, di = 0; ci < str.length && di < this._charDefs.length; ++di) {
      var ch = str[ci];
      var def = this._charDefs[di];

      if (def.isHiddenHollow) continue;
      if (def.unmasking && !def.isHollow) unmasked += ch;
      ++ci;
    }

    return unmasked;
  };

  MaskedPattern.prototype._appendTail = function _appendTail() {
    var tail = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

    return this._appendChunks(tail, { tail: true }).aggregate(this._appendPlaceholder());
  };

  MaskedPattern.prototype._append = function _append(str) {
    var flags = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    var oldValueLength = this.value.length;
    var rawInserted = '';
    var overflow = false;

    str = this.doPrepare(str, flags);

    for (var ci = 0, di = this.mapPosToDefIndex(this.value.length); ci < str.length;) {
      var ch = str[ci];
      var def = this._charDefs[di];

      // check overflow
      if (def == null) {
        overflow = true;
        break;
      }

      // reset
      def.isHollow = false;

      var resolved = void 0,
          skipped = void 0;
      var chres = conform(def.resolve(ch), ch);

      if (def.type === PatternDefinition.TYPES.INPUT) {
        if (chres) {
          this._value += chres;
          if (!this.doValidate()) {
            chres = '';
            this._value = this.value.slice(0, -1);
          }
        }

        resolved = !!chres;
        skipped = !chres && !def.optional;

        if (!chres) {
          if (!def.optional && !flags.input) {
            this._value += this.placeholderChar;
            skipped = false;
          }
          if (!skipped) def.isHollow = true;
        } else {
          rawInserted += chres;
        }
      } else {
        this._value += def.char;
        resolved = chres && (def.unmasking || flags.input || flags.raw) && !flags.tail;
        def.isRawInput = resolved && (flags.raw || flags.input);
        if (def.isRawInput) rawInserted += def.char;
      }

      if (!skipped) ++di;
      if (resolved || skipped) ++ci;
    }

    return new ChangeDetails({
      inserted: this.value.slice(oldValueLength),
      rawInserted: rawInserted,
      overflow: overflow
    });
  };

  MaskedPattern.prototype._appendChunks = function _appendChunks(chunks) {
    var details = new ChangeDetails();

    for (var _len2 = arguments.length, args = Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
      args[_key2 - 1] = arguments[_key2];
    }

    for (var ci = 0; ci < chunks.length; ++ci) {
      var _chunks$ci = chunks[ci],
          fromDefIndex = _chunks$ci[0],
          input = _chunks$ci[1];

      if (fromDefIndex != null) details.aggregate(this._appendPlaceholder(fromDefIndex));
      if (details.aggregate(this._append.apply(this, [input].concat(args))).overflow) break;
    }
    return details;
  };

  MaskedPattern.prototype._extractTail = function _extractTail() {
    var fromPos = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var toPos = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length;

    return this._extractInputChunks(fromPos, toPos);
  };

  MaskedPattern.prototype.extractInput = function extractInput() {
    var fromPos = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var toPos = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length;
    var flags = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    if (fromPos === toPos) return '';

    var str = this.value;
    var input = '';

    var toDefIndex = this.mapPosToDefIndex(toPos);
    for (var ci = fromPos, di = this.mapPosToDefIndex(fromPos); ci < toPos && ci < str.length && di < toDefIndex; ++di) {
      var ch = str[ci];
      var def = this._charDefs[di];

      if (!def) break;
      if (def.isHiddenHollow) continue;

      if (def.isInput && !def.isHollow || flags.raw && !def.isInput && def.isRawInput) input += ch;
      ++ci;
    }
    return input;
  };

  MaskedPattern.prototype._extractInputChunks = function _extractInputChunks() {
    var _this4 = this;

    var fromPos = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var toPos = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length;

    if (fromPos === toPos) return [];

    var fromDefIndex = this.mapPosToDefIndex(fromPos);
    var toDefIndex = this.mapPosToDefIndex(toPos);
    var stopDefIndices = this._charDefs.map(function (d, i) {
      return [d, i];
    }).slice(fromDefIndex, toDefIndex).filter(function (_ref) {
      var d = _ref[0];
      return d.stopAlign;
    }).map(function (_ref2) {
      var i = _ref2[1];
      return i;
    });

    var stops = [fromDefIndex].concat(stopDefIndices, [toDefIndex]);

    return stops.map(function (s, i) {
      return [stopDefIndices.indexOf(s) >= 0 ? s : null, _this4.extractInput(_this4.mapDefIndexToPos(s), _this4.mapDefIndexToPos(stops[++i]))];
    }).filter(function (_ref3) {
      var stop = _ref3[0],
          input = _ref3[1];
      return stop != null || input;
    });
  };

  MaskedPattern.prototype._appendPlaceholder = function _appendPlaceholder(toDefIndex) {
    var oldValueLength = this.value.length;
    var maxDefIndex = toDefIndex || this._charDefs.length;
    for (var di = this.mapPosToDefIndex(this.value.length); di < maxDefIndex; ++di) {
      var def = this._charDefs[di];
      if (def.isInput) def.isHollow = true;

      if (!this.lazy || toDefIndex) {
        this._value += !def.isInput && def.char != null ? def.char : !def.optional ? this.placeholderChar : '';
      }
    }
    return new ChangeDetails({
      inserted: this.value.slice(oldValueLength)
    });
  };

  MaskedPattern.prototype.remove = function remove() {
    var from = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var count = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length - from;

    var to = from + count;
    this._value = this.value.slice(0, from) + this.value.slice(to);
    var fromDefIndex = this.mapPosToDefIndex(from);
    var toDefIndex = this.mapPosToDefIndex(to);
    this._charDefs.slice(fromDefIndex, toDefIndex).forEach(function (d) {
      return d.reset();
    });
  };

  MaskedPattern.prototype.nearestInputPos = function nearestInputPos(cursorPos) {
    var direction = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : DIRECTION.NONE;

    var step = direction || DIRECTION.LEFT;

    var initialDefIndex = this.mapPosToDefIndex(cursorPos);
    var initialDef = this._charDefs[initialDefIndex];
    var di = initialDefIndex;

    var firstInputIndex = void 0,
        firstFilledInputIndex = void 0,
        firstVisibleHollowIndex = void 0,
        nextdi = void 0;

    // check if chars at right is acceptable for LEFT and NONE directions
    if (direction !== DIRECTION.RIGHT && (initialDef && initialDef.isInput ||
    // in none direction latest position is acceptable also
    direction === DIRECTION.NONE && cursorPos === this.value.length)) {
      firstInputIndex = initialDefIndex;
      if (initialDef && !initialDef.isHollow) firstFilledInputIndex = initialDefIndex;
    }

    if (firstFilledInputIndex == null && direction == DIRECTION.LEFT || firstInputIndex == null) {
      // search forward
      for (nextdi = indexInDirection(di, step); 0 <= nextdi && nextdi < this._charDefs.length; di += step, nextdi += step) {
        var nextDef = this._charDefs[nextdi];
        if (firstInputIndex == null && nextDef.isInput) firstInputIndex = di;
        if (firstVisibleHollowIndex == null && nextDef.isHollow && !nextDef.isHiddenHollow) firstVisibleHollowIndex = di;
        if (nextDef.isInput && !nextDef.isHollow) {
          firstFilledInputIndex = di;
          break;
        }
      }
    }

    // if has aligned left inside fixed and has came to the start - use start position
    if (direction === DIRECTION.LEFT && di === 0 && (!initialDef || !initialDef.isInput)) firstInputIndex = 0;

    if (direction !== DIRECTION.RIGHT || firstInputIndex == null) {
      // search backward
      step = -step;
      var overflow = false;

      // find hollows only before initial pos
      for (nextdi = indexInDirection(di, step); 0 <= nextdi && nextdi < this._charDefs.length; di += step, nextdi += step) {
        var _nextDef = this._charDefs[nextdi];
        if (_nextDef.isInput) {
          firstInputIndex = di;
          if (_nextDef.isHollow && !_nextDef.isHiddenHollow) break;
        }

        // if hollow not found before start position - set `overflow`
        // and try to find just any input
        if (di === initialDefIndex) overflow = true;

        // first input found
        if (overflow && firstInputIndex != null) break;
      }

      // process overflow
      overflow = overflow || nextdi >= this._charDefs.length;
      if (overflow && firstInputIndex != null) di = firstInputIndex;
    } else if (firstFilledInputIndex == null) {
      // adjust index if delete at right and filled input not found at right
      di = firstVisibleHollowIndex != null ? firstVisibleHollowIndex : firstInputIndex;
    }

    return this.mapDefIndexToPos(di);
  };

  MaskedPattern.prototype.group = function group(name) {
    return this.groupsByName(name)[0];
  };

  MaskedPattern.prototype.groupsByName = function groupsByName(name) {
    return this._groupDefs.filter(function (g$$1) {
      return g$$1.name === name;
    });
  };

  createClass(MaskedPattern, [{
    key: 'isComplete',
    get: function get$$1() {
      var _this5 = this;

      return !this._charDefs.some(function (d, i) {
        return d.isInput && !d.optional && (d.isHollow || !_this5.extractInput(i, i + 1));
      });
    }
  }]);
  return MaskedPattern;
}(Masked);

MaskedPattern.DEFAULTS = {
  lazy: true,
  placeholderChar: '_'
};
MaskedPattern.STOP_CHAR = '`';
MaskedPattern.ESCAPE_CHAR = '\\';
MaskedPattern.Definition = PatternDefinition;
MaskedPattern.Group = PatternGroup;

var MaskedDate = function (_MaskedPattern) {
  inherits(MaskedDate, _MaskedPattern);

  function MaskedDate(opts) {
    classCallCheck(this, MaskedDate);
    return possibleConstructorReturn(this, _MaskedPattern.call(this, _extends({}, MaskedDate.DEFAULTS, opts)));
  }

  MaskedDate.prototype._update = function _update(opts) {
    // TODO pattern mask is string, but date mask is Date
    if (opts.mask === Date) delete opts.mask;
    if (opts.pattern) {
      opts.mask = opts.pattern;
      delete opts.pattern;
    }

    var groups = opts.groups;
    opts.groups = _extends({}, MaskedDate.GET_DEFAULT_GROUPS());
    // adjust year group
    if (opts.min) opts.groups.Y.from = opts.min.getFullYear();
    if (opts.max) opts.groups.Y.to = opts.max.getFullYear();
    _extends(opts.groups, groups);

    _MaskedPattern.prototype._update.call(this, opts);
  };

  MaskedDate.prototype.doValidate = function doValidate() {
    var _MaskedPattern$protot;

    for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    var valid = (_MaskedPattern$protot = _MaskedPattern.prototype.doValidate).call.apply(_MaskedPattern$protot, [this].concat(args));
    var date = this.date;

    return valid && (!this.isComplete || this.isDateExist(this.value) && date && (this.min == null || this.min <= date) && (this.max == null || date <= this.max));
  };

  MaskedDate.prototype.isDateExist = function isDateExist(str) {
    return this.format(this.parse(str)) === str;
  };

  createClass(MaskedDate, [{
    key: 'date',
    get: function get$$1() {
      return this.isComplete ? this.parse(this.value) : null;
    },
    set: function set$$1(date) {
      this.value = this.format(date);
    }
  }]);
  return MaskedDate;
}(MaskedPattern);

MaskedDate.DEFAULTS = {
  pattern: 'd{.}`m{.}`Y',
  format: function format(date) {
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var year = date.getFullYear();

    return [day, month, year].join('.');
  },
  parse: function parse(str) {
    var _str$split = str.split('.'),
        day = _str$split[0],
        month = _str$split[1],
        year = _str$split[2];

    return new Date(year, month - 1, day);
  }
};
MaskedDate.GET_DEFAULT_GROUPS = function () {
  return {
    d: new PatternGroup.Range([1, 31]),
    m: new PatternGroup.Range([1, 12]),
    Y: new PatternGroup.Range([1900, 9999])
  };
};

var InputMask = function () {
  function InputMask(el, opts) {
    classCallCheck(this, InputMask);

    this.el = el;
    this.masked = createMask(opts);

    this._listeners = {};
    this._value = '';
    this._unmaskedValue = '';

    this._saveSelection = this._saveSelection.bind(this);
    this._onInput = this._onInput.bind(this);
    this._onChange = this._onChange.bind(this);
    this._onDrop = this._onDrop.bind(this);
    this.alignCursor = this.alignCursor.bind(this);
    this.alignCursorFriendly = this.alignCursorFriendly.bind(this);

    this.bindEvents();

    // refresh
    this.updateValue();
    this._onChange();
  }

  InputMask.prototype.bindEvents = function bindEvents() {
    this.el.addEventListener('keydown', this._saveSelection);
    this.el.addEventListener('input', this._onInput);
    this.el.addEventListener('drop', this._onDrop);
    this.el.addEventListener('click', this.alignCursorFriendly);
    this.el.addEventListener('change', this._onChange);
  };

  InputMask.prototype.unbindEvents = function unbindEvents() {
    this.el.removeEventListener('keydown', this._saveSelection);
    this.el.removeEventListener('input', this._onInput);
    this.el.removeEventListener('drop', this._onDrop);
    this.el.removeEventListener('click', this.alignCursorFriendly);
    this.el.removeEventListener('change', this._onChange);
  };

  InputMask.prototype.fireEvent = function fireEvent(ev) {
    var listeners = this._listeners[ev] || [];
    listeners.forEach(function (l) {
      return l();
    });
  };

  InputMask.prototype._saveSelection = function _saveSelection() /* ev */{
    if (this.value !== this.el.value) {
      console.warn('Uncontrolled input change, refresh mask manually!'); // eslint-disable-line no-console
    }
    this._selection = {
      start: this.selectionStart,
      end: this.cursorPos
    };
  };

  InputMask.prototype.updateValue = function updateValue() {
    this.masked.value = this.el.value;
  };

  InputMask.prototype.updateControl = function updateControl() {
    var newUnmaskedValue = this.masked.unmaskedValue;
    var newValue = this.masked.value;
    var isChanged = this.unmaskedValue !== newUnmaskedValue || this.value !== newValue;

    this._unmaskedValue = newUnmaskedValue;
    this._value = newValue;

    if (this.el.value !== newValue) this.el.value = newValue;
    if (isChanged) this._fireChangeEvents();
  };

  InputMask.prototype.updateOptions = function updateOptions(opts) {
    opts = _extends({}, opts); // clone
    if (opts.mask === Date && this.masked instanceof MaskedDate) delete opts.mask;

    // check if changed
    if (objectIncludes(this.masked, opts)) return;

    this.masked.updateOptions(opts);
    this.updateControl();
  };

  InputMask.prototype.updateCursor = function updateCursor(cursorPos) {
    if (cursorPos == null) return;
    this.cursorPos = cursorPos;

    // also queue change cursor for mobile browsers
    this._delayUpdateCursor(cursorPos);
  };

  InputMask.prototype._delayUpdateCursor = function _delayUpdateCursor(cursorPos) {
    var _this = this;

    this._abortUpdateCursor();
    this._changingCursorPos = cursorPos;
    this._cursorChanging = setTimeout(function () {
      if (!_this.el) return; // if was destroyed
      _this.cursorPos = _this._changingCursorPos;
      _this._abortUpdateCursor();
    }, 10);
  };

  InputMask.prototype._fireChangeEvents = function _fireChangeEvents() {
    this.fireEvent('accept');
    if (this.masked.isComplete) this.fireEvent('complete');
  };

  InputMask.prototype._abortUpdateCursor = function _abortUpdateCursor() {
    if (this._cursorChanging) {
      clearTimeout(this._cursorChanging);
      delete this._cursorChanging;
    }
  };

  InputMask.prototype.alignCursor = function alignCursor() {
    this.cursorPos = this.masked.nearestInputPos(this.cursorPos, DIRECTION.LEFT);
  };

  InputMask.prototype.alignCursorFriendly = function alignCursorFriendly() {
    if (this.selectionStart !== this.cursorPos) return;
    this.alignCursor();
  };

  InputMask.prototype.on = function on(ev, handler) {
    if (!this._listeners[ev]) this._listeners[ev] = [];
    this._listeners[ev].push(handler);
    return this;
  };

  InputMask.prototype.off = function off(ev, handler) {
    if (!this._listeners[ev]) return;
    if (!handler) {
      delete this._listeners[ev];
      return;
    }
    var hIndex = this._listeners[ev].indexOf(handler);
    if (hIndex >= 0) this._listeners[ev].splice(hIndex, 1);
    return this;
  };

  InputMask.prototype._onInput = function _onInput() {
    this._abortUpdateCursor();

    var details = new ActionDetails(
    // new state
    this.el.value, this.cursorPos,
    // old state
    this.value, this._selection);

    var offset = this.masked.splice(details.startChangePos, details.removed.length, details.inserted, details.removeDirection).offset;

    var cursorPos = this.masked.nearestInputPos(details.startChangePos + offset);

    this.updateControl();
    this.updateCursor(cursorPos);
  };

  InputMask.prototype._onChange = function _onChange() {
    if (this.value !== this.el.value) {
      this.updateValue();
    }
    this.masked.doCommit();
    this.updateControl();
  };

  InputMask.prototype._onDrop = function _onDrop(ev) {
    ev.preventDefault();
    ev.stopPropagation();
  };

  InputMask.prototype.destroy = function destroy() {
    this.unbindEvents();
    // $FlowFixMe why not do so?
    this._listeners.length = 0;
    delete this.el;
  };

  createClass(InputMask, [{
    key: 'mask',
    get: function get$$1() {
      return this.masked.mask;
    },
    set: function set$$1(mask) {
      if (mask == null || mask === this.masked.mask) return;

      if (this.masked.constructor === maskedClass(mask)) {
        this.masked.mask = mask;
        return;
      }

      var masked = createMask({ mask: mask });
      masked.unmaskedValue = this.masked.unmaskedValue;
      this.masked = masked;
    }
  }, {
    key: 'value',
    get: function get$$1() {
      return this._value;
    },
    set: function set$$1(str) {
      this.masked.value = str;
      this.updateControl();
      this.alignCursor();
    }
  }, {
    key: 'unmaskedValue',
    get: function get$$1() {
      return this._unmaskedValue;
    },
    set: function set$$1(str) {
      this.masked.unmaskedValue = str;
      this.updateControl();
      this.alignCursor();
    }
  }, {
    key: 'selectionStart',
    get: function get$$1() {
      return this._cursorChanging ? this._changingCursorPos : this.el.selectionStart;
    }
  }, {
    key: 'cursorPos',
    get: function get$$1() {
      return this._cursorChanging ? this._changingCursorPos : this.el.selectionEnd;
    },
    set: function set$$1(pos) {
      if (this.el !== document.activeElement) return;

      this.el.setSelectionRange(pos, pos);
      this._saveSelection();
    }
  }]);
  return InputMask;
}();

var MaskedNumber = function (_Masked) {
  inherits(MaskedNumber, _Masked);

  // TODO deprecarted, remove in 3.0
  function MaskedNumber(opts) {
    classCallCheck(this, MaskedNumber);
    return possibleConstructorReturn(this, _Masked.call(this, _extends({}, MaskedNumber.DEFAULTS, opts)));
  }

  MaskedNumber.prototype._update = function _update(opts) {
    if (opts.postFormat) {
      console.warn("'postFormat' option is deprecated and will be removed in next release, use plain options instead.");
      _extends(opts, opts.postFormat);
      delete opts.postFormat;
    }
    _Masked.prototype._update.call(this, opts);
    this._updateRegExps();
  };

  MaskedNumber.prototype._updateRegExps = function _updateRegExps() {
    // use different regexp to process user input (more strict, input suffix) and tail shifting
    var start = '^';

    var midInput = '';
    var mid = '';
    if (this.allowNegative) {
      midInput += '([+|\\-]?|([+|\\-]?(0|([1-9]+\\d*))))';
      mid += '[+|\\-]?';
    } else {
      midInput += '(0|([1-9]+\\d*))';
    }
    mid += '\\d*';

    var end = (this.scale ? '(' + this.radix + '\\d{0,' + this.scale + '})?' : '') + '$';

    this._numberRegExpInput = new RegExp(start + midInput + end);
    this._numberRegExp = new RegExp(start + mid + end);
    this._mapToRadixRegExp = new RegExp('[' + this.mapToRadix.map(escapeRegExp).join('') + ']', 'g');
    this._thousandsSeparatorRegExp = new RegExp(escapeRegExp(this.thousandsSeparator), 'g');
  };

  MaskedNumber.prototype._extractTail = function _extractTail() {
    var fromPos = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
    var toPos = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.value.length;

    return this._removeThousandsSeparators(_Masked.prototype._extractTail.call(this, fromPos, toPos));
  };

  MaskedNumber.prototype._removeThousandsSeparators = function _removeThousandsSeparators(value) {
    return value.replace(this._thousandsSeparatorRegExp, '');
  };

  MaskedNumber.prototype._insertThousandsSeparators = function _insertThousandsSeparators(value) {
    // https://stackoverflow.com/questions/2901102/how-to-print-a-number-with-commas-as-thousands-separators-in-javascript
    var parts = value.split(this.radix);
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, this.thousandsSeparator);
    return parts.join(this.radix);
  };

  MaskedNumber.prototype.doPrepare = function doPrepare(str) {
    var _Masked$prototype$doP;

    for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
      args[_key - 1] = arguments[_key];
    }

    return (_Masked$prototype$doP = _Masked.prototype.doPrepare).call.apply(_Masked$prototype$doP, [this, this._removeThousandsSeparators(str.replace(this._mapToRadixRegExp, this.radix))].concat(args));
  };

  MaskedNumber.prototype.appendWithTail = function appendWithTail() {
    var _Masked$prototype$app;

    var previousValue = this.value;
    this._value = this._removeThousandsSeparators(this.value);
    var startChangePos = this.value.length;

    for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      args[_key2] = arguments[_key2];
    }

    var appendDetails = (_Masked$prototype$app = _Masked.prototype.appendWithTail).call.apply(_Masked$prototype$app, [this].concat(args));
    this._value = this._insertThousandsSeparators(this.value);

    // calculate offsets after insert separators
    var beforeTailPos = startChangePos + appendDetails.inserted.length;
    for (var pos = 0; pos <= beforeTailPos; ++pos) {
      if (this.value[pos] === this.thousandsSeparator) {
        if (pos < startChangePos ||
        // check high bound
        // if separator is still there - consider it also
        pos === startChangePos && previousValue[pos] === this.thousandsSeparator) {
          ++startChangePos;
        }
        if (pos < beforeTailPos) ++beforeTailPos;
      }
    }

    // adjust details with separators
    appendDetails.rawInserted = appendDetails.inserted;
    appendDetails.inserted = this.value.slice(startChangePos, beforeTailPos);
    appendDetails.shift += startChangePos - previousValue.length;

    return appendDetails;
  };

  MaskedNumber.prototype.nearestInputPos = function nearestInputPos(cursorPos, direction) {
    if (!direction) return cursorPos;

    var nextPos = indexInDirection(cursorPos, direction);
    if (this.value[nextPos] === this.thousandsSeparator) cursorPos += direction;
    return cursorPos;
  };

  MaskedNumber.prototype.doValidate = function doValidate(flags) {
    var regexp = flags.input ? this._numberRegExpInput : this._numberRegExp;

    // validate as string
    var valid = regexp.test(this._removeThousandsSeparators(this.value));

    if (valid) {
      // validate as number
      var number = this.number;
      valid = valid && !isNaN(number) && (
      // check min bound for negative values
      this.min == null || this.min >= 0 || this.min <= this.number) && (
      // check max bound for positive values
      this.max == null || this.max <= 0 || this.number <= this.max);
    }

    return valid && _Masked.prototype.doValidate.call(this, flags);
  };

  MaskedNumber.prototype.doCommit = function doCommit() {
    var number = this.number;
    var validnum = number;

    // check bounds
    if (this.min != null) validnum = Math.max(validnum, this.min);
    if (this.max != null) validnum = Math.min(validnum, this.max);

    if (validnum !== number) this.unmaskedValue = String(validnum);

    var formatted = this.value;

    if (this.normalizeZeros) formatted = this._normalizeZeros(formatted);
    if (this.padFractionalZeros) formatted = this._padFractionalZeros(formatted);

    this._value = formatted;
    _Masked.prototype.doCommit.call(this);
  };

  MaskedNumber.prototype._normalizeZeros = function _normalizeZeros(value) {
    var parts = this._removeThousandsSeparators(value).split(this.radix);

    // remove leading zeros
    parts[0] = parts[0].replace(/^(\D*)(0*)(\d*)/, function (match, sign, zeros, num) {
      return sign + num;
    });
    // add leading zero
    if (value.length && !/\d$/.test(parts[0])) parts[0] = parts[0] + '0';

    if (parts.length > 1) {
      parts[1] = parts[1].replace(/0*$/, ''); // remove trailing zeros
      if (!parts[1].length) parts.length = 1; // remove fractional
    }

    return this._insertThousandsSeparators(parts.join(this.radix));
  };

  MaskedNumber.prototype._padFractionalZeros = function _padFractionalZeros(value) {
    var parts = value.split(this.radix);
    if (parts.length < 2) parts.push('');
    parts[1] = parts[1].padEnd(this.scale, '0');
    return parts.join(this.radix);
  };

  createClass(MaskedNumber, [{
    key: 'number',
    get: function get$$1() {
      var numstr = this._removeThousandsSeparators(this._normalizeZeros(this.unmaskedValue)).replace(this.radix, '.');

      return Number(numstr);
    },
    set: function set$$1(number) {
      this.unmaskedValue = String(number).replace('.', this.radix);
    }
  }, {
    key: 'allowNegative',
    get: function get$$1() {
      return this.signed || this.min != null && this.min < 0 || this.max != null && this.max < 0;
    }
  }]);
  return MaskedNumber;
}(Masked);

MaskedNumber.DEFAULTS = {
  radix: ',',
  thousandsSeparator: '',
  mapToRadix: ['.'],
  scale: 2,
  signed: false,
  normalizeZeros: true,
  padFractionalZeros: false
};

var MaskedRegExp = function (_Masked) {
  inherits(MaskedRegExp, _Masked);

  function MaskedRegExp() {
    classCallCheck(this, MaskedRegExp);
    return possibleConstructorReturn(this, _Masked.apply(this, arguments));
  }

  MaskedRegExp.prototype._update = function _update(opts) {
    opts.validate = function (value) {
      return value.search(opts.mask) >= 0;
    };
    _Masked.prototype._update.call(this, opts);
  };

  return MaskedRegExp;
}(Masked);

var MaskedFunction = function (_Masked) {
  inherits(MaskedFunction, _Masked);

  function MaskedFunction() {
    classCallCheck(this, MaskedFunction);
    return possibleConstructorReturn(this, _Masked.apply(this, arguments));
  }

  MaskedFunction.prototype._update = function _update(opts) {
    opts.validate = opts.mask;
    _Masked.prototype._update.call(this, opts);
  };

  return MaskedFunction;
}(Masked);

var MaskedDynamic = function (_Masked) {
  inherits(MaskedDynamic, _Masked);

  function MaskedDynamic(opts) {
    classCallCheck(this, MaskedDynamic);

    var _this = possibleConstructorReturn(this, _Masked.call(this, _extends({}, MaskedDynamic.DEFAULTS, opts)));

    _this.currentMask = null;
    return _this;
  }

  MaskedDynamic.prototype._update = function _update(opts) {
    _Masked.prototype._update.call(this, opts);
    this.compiledMasks = Array.isArray(opts.mask) ? opts.mask.map(function (m) {
      return createMask(m);
    }) : [];
  };

  MaskedDynamic.prototype._append = function _append(str) {
    var oldValueLength = this.value.length;
    var details = new ChangeDetails();

    for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
      args[_key - 1] = arguments[_key];
    }

    str = this.doPrepare.apply(this, [str].concat(args));

    var inputValue = this.rawInputValue;
    this.currentMask = this.doDispatch.apply(this, [str].concat(args));
    if (this.currentMask) {
      var _currentMask;

      // update current mask
      this.currentMask.rawInputValue = inputValue;
      details.shift = this.value.length - oldValueLength;
      details.aggregate((_currentMask = this.currentMask)._append.apply(_currentMask, [str].concat(args)));
    }

    return details;
  };

  MaskedDynamic.prototype.doDispatch = function doDispatch(appended) {
    var flags = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    return this.dispatch(appended, this, flags);
  };

  MaskedDynamic.prototype.clone = function clone() {
    var m = new MaskedDynamic(this);
    m._value = this.value;
    if (this.currentMask) m.currentMask = this.currentMask.clone();
    return m;
  };

  MaskedDynamic.prototype.reset = function reset() {
    if (this.currentMask) this.currentMask.reset();
    this.compiledMasks.forEach(function (cm) {
      return cm.reset();
    });
  };

  MaskedDynamic.prototype._unmask = function _unmask() {
    return this.currentMask ? this.currentMask._unmask() : '';
  };

  MaskedDynamic.prototype.remove = function remove() {
    var _currentMask2;

    if (this.currentMask) (_currentMask2 = this.currentMask).remove.apply(_currentMask2, arguments);
  };

  MaskedDynamic.prototype.extractInput = function extractInput() {
    var _currentMask3;

    return this.currentMask ? (_currentMask3 = this.currentMask).extractInput.apply(_currentMask3, arguments) : '';
  };

  MaskedDynamic.prototype.doCommit = function doCommit() {
    if (this.currentMask) this.currentMask.doCommit();
    _Masked.prototype.doCommit.call(this);
  };

  MaskedDynamic.prototype.nearestInputPos = function nearestInputPos() {
    var _currentMask4, _Masked$prototype$nea;

    for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      args[_key2] = arguments[_key2];
    }

    return this.currentMask ? (_currentMask4 = this.currentMask).nearestInputPos.apply(_currentMask4, args) : (_Masked$prototype$nea = _Masked.prototype.nearestInputPos).call.apply(_Masked$prototype$nea, [this].concat(args));
  };

  createClass(MaskedDynamic, [{
    key: 'value',
    get: function get$$1() {
      return this.currentMask ? this.currentMask.value : '';
    },
    set: function set$$1(value) {
      this.resolve(value);
    }
  }, {
    key: 'isComplete',
    get: function get$$1() {
      return !!this.currentMask && this.currentMask.isComplete;
    }
  }]);
  return MaskedDynamic;
}(Masked);

MaskedDynamic.DEFAULTS = {
  dispatch: function dispatch(appended, masked, flags) {
    if (!masked.compiledMasks.length) return;

    var inputValue = masked.rawInputValue;

    // update all
    masked.compiledMasks.forEach(function (cm) {
      cm.rawInputValue = inputValue;
      cm._append(appended, flags);
    });

    // pop masks with longer values first
    var inputs = masked.compiledMasks.map(function (cm, index) {
      return { value: cm.rawInputValue.length, index: index };
    });
    inputs.sort(function (i1, i2) {
      return i2.value - i1.value;
    });

    return masked.compiledMasks[inputs[0].index];
  }
};

function IMask$1(el) {
  var opts = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  // currently available only for input-like elements
  return new InputMask(el, opts);
}

IMask$1.InputMask = InputMask;

IMask$1.Masked = Masked;
IMask$1.MaskedPattern = MaskedPattern;
IMask$1.MaskedNumber = MaskedNumber;
IMask$1.MaskedDate = MaskedDate;
IMask$1.MaskedRegExp = MaskedRegExp;
IMask$1.MaskedFunction = MaskedFunction;
IMask$1.MaskedDynamic = MaskedDynamic;
IMask$1.createMask = createMask;

g.IMask = IMask$1;

return IMask$1;

})));
//# sourceMappingURL=imask.js.map
