var autoScroll = (function () {
'use strict';

function getDef(f, d) {
    if (typeof f === 'undefined') {
        return typeof d === 'undefined' ? f : d;
    }

    return f;
}
function boolean(func, def) {

    func = getDef(func, def);

    if (typeof func === 'function') {
        return function f() {
            for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
                args[_key] = arguments[_key];
            }

            return !!func.apply(this, args);
        };
    }

    return !!func ? function () {
        return true;
    } : function () {
        return false;
    };
}

var prefix = ['webkit', 'moz', 'ms', 'o'];

var requestAnimationFrame = function () {

  for (var i = 0, limit = prefix.length; i < limit && !window.requestAnimationFrame; ++i) {
    window.requestAnimationFrame = window[prefix[i] + 'RequestAnimationFrame'];
  }

  if (!window.requestAnimationFrame) {
    (function () {
      var lastTime = 0;

      window.requestAnimationFrame = function (callback) {
        var now = new Date().getTime();
        var ttc = Math.max(0, 16 - now - lastTime);
        var timer = window.setTimeout(function () {
          return callback(now + ttc);
        }, ttc);

        lastTime = now + ttc;

        return timer;
      };
    })();
  }

  return window.requestAnimationFrame.bind(window);
}();

var cancelAnimationFrame = function () {

  for (var i = 0, limit = prefix.length; i < limit && !window.cancelAnimationFrame; ++i) {
    window.cancelAnimationFrame = window[prefix[i] + 'CancelAnimationFrame'] || window[prefix[i] + 'CancelRequestAnimationFrame'];
  }

  if (!window.cancelAnimationFrame) {
    window.cancelAnimationFrame = function (timer) {
      window.clearTimeout(timer);
    };
  }

  return window.cancelAnimationFrame.bind(window);
}();

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
  return typeof obj;
} : function (obj) {
  return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj;
};

/**
 * Returns `true` if provided input is Element.
 * @name isElement
 * @param {*} [input]
 * @returns {boolean}
 */
var isElement = function (input) {
  return input != null && (typeof input === 'undefined' ? 'undefined' : _typeof(input)) === 'object' && input.nodeType === 1 && _typeof(input.style) === 'object' && _typeof(input.ownerDocument) === 'object';
};

// Production steps of ECMA-262, Edition 6, 22.1.2.1
// Reference: http://www.ecma-international.org/ecma-262/6.0/#sec-array.from
var polyfill = function () {
  var isCallable = function (fn) {
    return typeof fn === 'function';
  };
  var toInteger = function (value) {
    var number = Number(value);
    if (isNaN(number)) {
      return 0;
    }
    if (number === 0 || !isFinite(number)) {
      return number;
    }
    return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
  };
  var maxSafeInteger = Math.pow(2, 53) - 1;
  var toLength = function (value) {
    var len = toInteger(value);
    return Math.min(Math.max(len, 0), maxSafeInteger);
  };
  var iteratorProp = function (value) {
    if (value != null) {
      if (['string', 'number', 'boolean', 'symbol'].indexOf(typeof value) > -1) {
        return Symbol.iterator;
      } else if (typeof Symbol !== 'undefined' && 'iterator' in Symbol && Symbol.iterator in value) {
        return Symbol.iterator;
      }
      // Support "@@iterator" placeholder, Gecko 27 to Gecko 35
      else if ('@@iterator' in value) {
          return '@@iterator';
        }
    }
  };
  var getMethod = function (O, P) {
    // Assert: IsPropertyKey(P) is true.
    if (O != null && P != null) {
      // Let func be GetV(O, P).
      var func = O[P];
      // ReturnIfAbrupt(func).
      // If func is either undefined or null, return undefined.
      if (func == null) {
        return void 0;
      }
      // If IsCallable(func) is false, throw a TypeError exception.
      if (!isCallable(func)) {
        throw new TypeError(func + ' is not a function');
      }
      return func;
    }
  };
  var iteratorStep = function (iterator) {
    // Let result be IteratorNext(iterator).
    // ReturnIfAbrupt(result).
    var result = iterator.next();
    // Let done be IteratorComplete(result).
    // ReturnIfAbrupt(done).
    var done = Boolean(result.done);
    // If done is true, return false.
    if (done) {
      return false;
    }
    // Return result.
    return result;
  };

  // The length property of the from method is 1.
  return function from(items /*, mapFn, thisArg */) {
    'use strict';

    // 1. Let C be the this value.

    var C = this;

    // 2. If mapfn is undefined, let mapping be false.
    var mapFn = arguments.length > 1 ? arguments[1] : void 0;

    var T;
    if (typeof mapFn !== 'undefined') {
      // 3. else
      //   a. If IsCallable(mapfn) is false, throw a TypeError exception.
      if (!isCallable(mapFn)) {
        throw new TypeError('Array.from: when provided, the second argument must be a function');
      }

      //   b. If thisArg was supplied, let T be thisArg; else let T
      //      be undefined.
      if (arguments.length > 2) {
        T = arguments[2];
      }
      //   c. Let mapping be true (implied by mapFn)
    }

    var A, k;

    // 4. Let usingIterator be GetMethod(items, @@iterator).
    // 5. ReturnIfAbrupt(usingIterator).
    var usingIterator = getMethod(items, iteratorProp(items));

    // 6. If usingIterator is not undefined, then
    if (usingIterator !== void 0) {
      // a. If IsConstructor(C) is true, then
      //   i. Let A be the result of calling the [[Construct]]
      //      internal method of C with an empty argument list.
      // b. Else,
      //   i. Let A be the result of the abstract operation ArrayCreate
      //      with argument 0.
      // c. ReturnIfAbrupt(A).
      A = isCallable(C) ? Object(new C()) : [];

      // d. Let iterator be GetIterator(items, usingIterator).
      var iterator = usingIterator.call(items);

      // e. ReturnIfAbrupt(iterator).
      if (iterator == null) {
        throw new TypeError('Array.from requires an array-like or iterable object');
      }

      // f. Let k be 0.
      k = 0;

      // g. Repeat
      var next, nextValue;
      while (true) {
        // i. Let Pk be ToString(k).
        // ii. Let next be IteratorStep(iterator).
        // iii. ReturnIfAbrupt(next).
        next = iteratorStep(iterator);

        // iv. If next is false, then
        if (!next) {

          // 1. Let setStatus be Set(A, "length", k, true).
          // 2. ReturnIfAbrupt(setStatus).
          A.length = k;

          // 3. Return A.
          return A;
        }
        // v. Let nextValue be IteratorValue(next).
        // vi. ReturnIfAbrupt(nextValue)
        nextValue = next.value;

        // vii. If mapping is true, then
        //   1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
        //   2. If mappedValue is an abrupt completion, return
        //      IteratorClose(iterator, mappedValue).
        //   3. Let mappedValue be mappedValue.[[value]].
        // viii. Else, let mappedValue be nextValue.
        // ix.  Let defineStatus be the result of
        //      CreateDataPropertyOrThrow(A, Pk, mappedValue).
        // x. [TODO] If defineStatus is an abrupt completion, return
        //    IteratorClose(iterator, defineStatus).
        if (mapFn) {
          A[k] = mapFn.call(T, nextValue, k);
        } else {
          A[k] = nextValue;
        }
        // xi. Increase k by 1.
        k++;
      }
      // 7. Assert: items is not an Iterable so assume it is
      //    an array-like object.
    } else {

      // 8. Let arrayLike be ToObject(items).
      var arrayLike = Object(items);

      // 9. ReturnIfAbrupt(items).
      if (items == null) {
        throw new TypeError('Array.from requires an array-like object - not null or undefined');
      }

      // 10. Let len be ToLength(Get(arrayLike, "length")).
      // 11. ReturnIfAbrupt(len).
      var len = toLength(arrayLike.length);

      // 12. If IsConstructor(C) is true, then
      //     a. Let A be Construct(C, «len»).
      // 13. Else
      //     a. Let A be ArrayCreate(len).
      // 14. ReturnIfAbrupt(A).
      A = isCallable(C) ? Object(new C(len)) : new Array(len);

      // 15. Let k be 0.
      k = 0;
      // 16. Repeat, while k < len… (also steps a - h)
      var kValue;
      while (k < len) {
        kValue = arrayLike[k];
        if (mapFn) {
          A[k] = mapFn.call(T, kValue, k);
        } else {
          A[k] = kValue;
        }
        k++;
      }
      // 17. Let setStatus be Set(A, "length", len, true).
      // 18. ReturnIfAbrupt(setStatus).
      A.length = len;
      // 19. Return A.
    }
    return A;
  };
}();

var index$1 = typeof Array.from === 'function' ? Array.from : polyfill;

/**
 * isArray
 */

var isArray = Array.isArray;

/**
 * toString
 */

var str = Object.prototype.toString;

/**
 * Whether or not the given `val`
 * is an array.
 *
 * example:
 *
 *        isArray([]);
 *        // > true
 *        isArray(arguments);
 *        // > false
 *        isArray('');
 *        // > false
 *
 * @param {mixed} val
 * @return {bool}
 */

var index$2 = isArray || function (val) {
  return !!val && '[object Array]' == str.call(val);
};

function indexOfElement(elements, element) {
    element = resolveElement(element, true);
    if (!isElement(element)) return -1;
    for (var i = 0; i < elements.length; i++) {
        if (elements[i] === element) {
            return i;
        }
    }
    return -1;
}

function hasElement(elements, element) {
    return -1 !== indexOfElement(elements, element);
}

function domListOf(arr) {

    if (!arr) return [];

    try {
        if (typeof arr === 'string') {
            return index$1(document.querySelectorAll(arr));
        } else if (index$2(arr)) {
            return arr.map(resolveElement);
        } else {
            if (typeof arr.length === 'undefined') {
                return [resolveElement(arr)];
            }

            return index$1(arr, resolveElement);
        }
    } catch (e) {
        throw new Error(e);
    }
}

function pushElements(elements, toAdd) {

    for (var i = 0; i < toAdd.length; i++) {
        if (!hasElement(elements, toAdd[i])) elements.push(toAdd[i]);
    }

    return toAdd;
}

function addElements(elements) {
    for (var _len2 = arguments.length, toAdd = Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
        toAdd[_key2 - 1] = arguments[_key2];
    }

    toAdd = toAdd.map(resolveElement);
    return pushElements(elements, toAdd);
}

function removeElements(elements) {
    for (var _len3 = arguments.length, toRemove = Array(_len3 > 1 ? _len3 - 1 : 0), _key3 = 1; _key3 < _len3; _key3++) {
        toRemove[_key3 - 1] = arguments[_key3];
    }

    return toRemove.map(resolveElement).reduce(function (last, e) {

        var index = indexOfElement(elements, e);

        if (index !== -1) return last.concat(elements.splice(index, 1));
        return last;
    }, []);
}

function resolveElement(element, noThrow) {
    if (typeof element === 'string') {
        try {
            return document.querySelector(element);
        } catch (e) {
            throw e;
        }
    }

    if (!isElement(element) && !noThrow) {
        throw new TypeError(element + ' is not a DOM element.');
    }
    return element;
}

var index$3 = function createPointCB(object, options) {

    // A persistent object (as opposed to returned object) is used to save memory
    // This is good to prevent layout thrashing, or for games, and such

    // NOTE
    // This uses IE fixes which should be OK to remove some day. :)
    // Some speed will be gained by removal of these.

    // pointCB should be saved in a variable on return
    // This allows the usage of element.removeEventListener

    options = options || {};

    var allowUpdate;

    if (typeof options.allowUpdate === 'function') {
        allowUpdate = options.allowUpdate;
    } else {
        allowUpdate = function () {
            return true;
        };
    }

    return function pointCB(event) {

        event = event || window.event; // IE-ism
        object.target = event.target || event.srcElement || event.originalTarget;
        object.element = this;
        object.type = event.type;

        if (!allowUpdate(event)) {
            return;
        }

        // Support touch
        // http://www.creativebloq.com/javascript/make-your-site-work-touch-devices-51411644

        if (event.targetTouches) {
            object.x = event.targetTouches[0].clientX;
            object.y = event.targetTouches[0].clientY;
            object.pageX = event.pageX;
            object.pageY = event.pageY;
        } else {

            // If pageX/Y aren't available and clientX/Y are,
            // calculate pageX/Y - logic taken from jQuery.
            // (This is to support old IE)
            // NOTE Hopefully this can be removed soon.

            if (event.pageX === null && event.clientX !== null) {
                var eventDoc = event.target && event.target.ownerDocument || document;
                var doc = eventDoc.documentElement;
                var body = eventDoc.body;

                object.pageX = event.clientX + (doc && doc.scrollLeft || body && body.scrollLeft || 0) - (doc && doc.clientLeft || body && body.clientLeft || 0);
                object.pageY = event.clientY + (doc && doc.scrollTop || body && body.scrollTop || 0) - (doc && doc.clientTop || body && body.clientTop || 0);
            } else {
                object.pageX = event.pageX;
                object.pageY = event.pageY;
            }

            // pageX, and pageY change with page scroll
            // so we're not going to use those for x, and y.
            // NOTE Most browsers also alias clientX/Y with x/y
            // so that's something to consider down the road.

            object.x = event.clientX;
            object.y = event.clientY;
        }
    };

    //NOTE Remember accessibility, Aria roles, and labels.
};

function createWindowRect() {
    var props = {
        top: { value: 0, enumerable: true },
        left: { value: 0, enumerable: true },
        right: { value: window.innerWidth, enumerable: true },
        bottom: { value: window.innerHeight, enumerable: true },
        width: { value: window.innerWidth, enumerable: true },
        height: { value: window.innerHeight, enumerable: true },
        x: { value: 0, enumerable: true },
        y: { value: 0, enumerable: true }
    };

    if (Object.create) {
        return Object.create({}, props);
    } else {
        var rect = {};
        Object.defineProperties(rect, props);
        return rect;
    }
}

function getClientRect(el) {
    if (el === window) {
        return createWindowRect();
    } else {
        try {
            var rect = el.getBoundingClientRect();
            if (rect.x === undefined) {
                rect.x = rect.left;
                rect.y = rect.top;
            }
            return rect;
        } catch (e) {
            throw new TypeError("Can't call getBoundingClientRect on " + el);
        }
    }
}

function pointInside(point, el) {
    var rect = getClientRect(el);
    return point.y > rect.top && point.y < rect.bottom && point.x > rect.left && point.x < rect.right;
}

function AutoScroller(elements) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    var self = this;
    var maxSpeed = 10,
        scrolling = false;

    this.margin = options.margin || -1;
    //this.scrolling = false;
    this.scrollWhenOutside = options.scrollWhenOutside || false;

    var point = {},
        pointCB = index$3(point),
        down = false;

    window.addEventListener('mousemove', pointCB, false);
    window.addEventListener('touchmove', pointCB, false);

    if (!isNaN(options.maxSpeed)) {
        maxSpeed = options.maxSpeed;
    }

    this.autoScroll = boolean(options.autoScroll);

    this.destroy = function () {
        window.removeEventListener('mousemove', pointCB, false);
        window.removeEventListener('touchmove', pointCB, false);
        window.removeEventListener('mousedown', onDown, false);
        window.removeEventListener('touchstart', onDown, false);
        window.removeEventListener('mouseup', onUp, false);
        window.removeEventListener('touchend', onUp, false);

        window.removeEventListener('scroll', setScroll, true);
        elements = [];
    };

    this.add = function () {
        for (var _len = arguments.length, element = Array(_len), _key = 0; _key < _len; _key++) {
            element[_key] = arguments[_key];
        }

        addElements.apply(undefined, [elements].concat(element));
        return this;
    };

    this.remove = function () {
        for (var _len2 = arguments.length, element = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
            element[_key2] = arguments[_key2];
        }

        return removeElements.apply(undefined, [elements].concat(element));
    };

    var hasWindow = null,
        windowAnimationFrame = void 0;

    if (Object.prototype.toString.call(elements) !== '[object Array]') {
        elements = [elements];
    }

    (function (temp) {
        elements = [];
        temp.forEach(function (element) {
            if (element === window) {
                hasWindow = window;
            } else {
                self.add(element);
            }
        });
    })(elements);

    Object.defineProperties(this, {
        down: {
            get: function get() {
                return down;
            }
        },
        maxSpeed: {
            get: function get() {
                return maxSpeed;
            }
        },
        point: {
            get: function get() {
                return point;
            }
        },
        scrolling: {
            get: function get() {
                return scrolling;
            }
        }
    });

    var n = 0,
        current = null,
        animationFrame = void 0;

    window.addEventListener('mousedown', onDown, false);
    window.addEventListener('touchstart', onDown, false);
    window.addEventListener('mouseup', onUp, false);
    window.addEventListener('touchend', onUp, false);

    window.addEventListener('mousemove', onMove, false);
    window.addEventListener('touchmove', onMove, false);

    window.addEventListener('mouseleave', onMouseOut, false);

    window.addEventListener('scroll', setScroll, true);

    function setScroll(e) {

        for (var i = 0; i < elements.length; i++) {
            if (elements[i] === e.target) {
                scrolling = true;
                break;
            }
        }

        if (scrolling) {
            requestAnimationFrame(function () {
                return scrolling = false;
            });
        }
    }

    function onDown() {
        down = true;
    }

    function onUp() {
        down = false;
        cancelAnimationFrame(animationFrame);
        cancelAnimationFrame(windowAnimationFrame);
    }

    function onMouseOut() {
        down = false;
    }

    function getTarget(target) {
        if (!target) {
            return null;
        }

        if (current === target) {
            return target;
        }

        if (hasElement(elements, target)) {
            return target;
        }

        while (target = target.parentNode) {
            if (hasElement(elements, target)) {
                return target;
            }
        }

        return null;
    }

    function getElementUnderPoint() {
        var underPoint = null;

        for (var i = 0; i < elements.length; i++) {
            if (inside(point, elements[i])) {
                underPoint = elements[i];
            }
        }

        return underPoint;
    }

    function onMove(event) {

        if (!self.autoScroll()) return;
        var target = event.target,
            body = document.body;

        if (current && !inside(point, current)) {
            if (!self.scrollWhenOutside) {
                current = null;
            }
        }

        if (target && target.parentNode === body) {
            //The special condition to improve speed.
            target = getElementUnderPoint();
        } else {
            target = getTarget(target);

            if (!target) {
                target = getElementUnderPoint();
            }
        }

        if (target && target !== current) {
            current = target;
        }

        if (hasWindow) {
            cancelAnimationFrame(windowAnimationFrame);
            windowAnimationFrame = requestAnimationFrame(scrollWindow);
        }

        if (!current) {
            return;
        }

        cancelAnimationFrame(animationFrame);
        animationFrame = requestAnimationFrame(scrollTick);
    }

    function scrollWindow() {
        autoScroll(hasWindow);

        cancelAnimationFrame(windowAnimationFrame);
        windowAnimationFrame = requestAnimationFrame(scrollWindow);
    }

    function scrollTick() {

        if (!current) {
            return;
        }

        autoScroll(current);

        cancelAnimationFrame(animationFrame);
        animationFrame = requestAnimationFrame(scrollTick);
    }

    function autoScroll(el) {
        var rect = getClientRect(el),
            scrollx = void 0,
            scrolly = void 0;

        if (point.x < rect.left + self.margin) {
            scrollx = Math.floor(Math.max(-1, (point.x - rect.left) / self.margin - 1) * self.maxSpeed);
        } else if (point.x > rect.right - self.margin) {
            scrollx = Math.ceil(Math.min(1, (point.x - rect.right) / self.margin + 1) * self.maxSpeed);
        } else {
            scrollx = 0;
        }

        if (point.y < rect.top + self.margin) {
            scrolly = Math.floor(Math.max(-1, (point.y - rect.top) / self.margin - 1) * self.maxSpeed);
        } else if (point.y > rect.bottom - self.margin) {
            scrolly = Math.ceil(Math.min(1, (point.y - rect.bottom) / self.margin + 1) * self.maxSpeed);
        } else {
            scrolly = 0;
        }

        setTimeout(function () {

            if (scrolly) {
                scrollY(el, scrolly);
            }

            if (scrollx) {
                scrollX(el, scrollx);
            }
        });
    }

    function scrollY(el, amount) {
        if (el === window) {
            window.scrollTo(el.pageXOffset, el.pageYOffset + amount);
        } else {
            el.scrollTop += amount;
        }
    }

    function scrollX(el, amount) {
        if (el === window) {
            window.scrollTo(el.pageXOffset + amount, el.pageYOffset);
        } else {
            el.scrollLeft += amount;
        }
    }
}

function AutoScrollerFactory(element, options) {
    return new AutoScroller(element, options);
}
function inside(point, el, rect) {
    if (!rect) {
        return pointInside(point, el);
    } else {
        return point.y > rect.top && point.y < rect.bottom && point.x > rect.left && point.x < rect.right;
    }
}

/*
git remote add origin https://github.com/hollowdoor/dom_autoscroller.git
git push -u origin master
*/

return AutoScrollerFactory;

}());
//# sourceMappingURL=dom-autoscroller.js.map
