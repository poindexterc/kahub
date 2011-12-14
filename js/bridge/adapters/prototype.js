/*
 * Prototype Adapter
 * Part of Bridge.js
 */
Object.extend(Bridge, (function() {
  var _slice    = window.Array.prototype.slice;

  var _Object = window.Object,
      Object = _Object.extend(_Object.clone(Bridge.Shared.Object), _Object);

  var byId       = window.$,
      bySelector = window.$$;

  function $(element) {
    if (element.constructor && element.constructor == NodeWrapper) {
      return element;
    }
    var NW = new NodeWrapper(element);
    return NW.source && NW;
  }

  function $$(selector) {
    return new NodeListWrapper(selector);
  }

  var _Element = window.Element;
  function Element(tagName, attributes) {
    attributes = attributes || {};
    return $(document.createElement(tagName)).writeAttribute(attributes);
  }
  
  var NodeWrapper = Class.create({
    initialize: function(element) {
      this.source = byId(element);
    },

    // Classnames
    addClassName: function(className) {
      this.source.addClassName(className);
      return this;
    },
    removeClassName: function(className) {
      this.source.removeClassName(className);
      return this;
    },

    // Dimensions and positions
    getWidth: function() {
      return this.source.getWidth();
    },
    getHeight: function() {
      return this.source.getHeight();
    },
    getDimensions:   function() {
      return this.source.getDimensions();
    },
    cumulativeOffset: function() {
      return this.source.cumulativeOffset();
    },
    cumulativeScrollOffset: function() {
      return this.source.cumulativeScrollOffset();
    },

    // hide/show
    hide: function() {
      this.source.hide();
      return this;
    },
    show: function() {
      this.source.show();
      return this;
    },
    toggle: function() {
      this.source.toggle();
      return this;
    },

    // DOM
    remove: function() {
      this.source.remove();
    },
    insert: function(content) {
      var object = {};
      if (content.source || Object.isElement(content) || Object.isString(content)) {
        object.bottom = content.source || content;
      } else {
        // turn node.source into elements for insertion
        for (var property in content)
          object[property] = content[property].source || content[property];
      }

      this.source.insert(object);
      return this;
    },
    update: function(content) {
      this.source.update(content.source || content);
      return this;
    },
    writeAttribute: function(object) {
      this.source.writeAttribute(object);
      return this;
    },
    
    setStyle: function() {
      _Element.setStyle.apply(this, [this.source].concat(_slice.call(arguments)));
      return this;
    },
    getStyle: function() {
      return _Element.getStyle.apply(this, [this.source].concat(_slice.call(arguments)));
    },

    setOpacity: function(opacity) {
      this.source.setOpacity(opacity);
      return this;
    },
    
    select: function(selector) {
      var elements = this.source.select(selector);
      return new NodeListWrapper(elements);
    },
    match: function(selector){ 
      return this.source.match(selector);    	
    },

    up: function() {
      return _Element.up.apply(this, [this.source].concat(_slice.call(arguments)));
    },
    down: function() {
      return _Element.down.apply(this, [this.source].concat(_slice.call(arguments)));
    },
    previous: function() {
      return _Element.previous.apply(this, [this.source].concat(_slice.call(arguments)));
    },
    next: function() {
      return _Element.next.apply(this, [this.source].concat(_slice.call(arguments)));
    },

    // Storage
    store: function(key, value) {
      this.source.store(key, value);
      return this;
    },
    retrieve: function(key) {
      return this.source.retrieve(key);
    },
    eliminate: function(key) {
      this.store(key, null);
      return this;
    },

    // Events
    observe: function() {
      var args = [this.source].concat(_slice.call(arguments));
      _Element.observe.apply(null, args);
      return this;
    },

    stopObserving: function() {
      var args = [this.source].concat(_slice.call(arguments));
      _Element.stopObserving.apply(null, args);
      return this;
    }
  });


  var NodeListWrapper = Class.create({
    initialize: function(selector) {
      var elements, source = [];

      elements = (Object.isArray(selector))
        ? selector
        : bySelector(selector);

      Array._each(elements, function(element) {
        source.push(new NodeWrapper(element));
      });
      this.source = source;
    },

    invoke: function() {
      var args = _slice.call(arguments), fn = args.shift();
      Array._each(this.source, function(node) {
        node[fn].apply(node, args);
      });
      return this;
    },

    each: function(iterator, context) {
      var index = 0;
      Array._each(this.source, function(value) {
        iterator.call(context, value, index++);
      });
      return this;
    }
  });


  var Array = Object.extend({
    find: function(array, object) {
      return array.find(object);
    },
    without: function(array, object) {
      return array.without(object);
    }
  }, Bridge.Shared.Array);


  var _Event = window.Event,
  Event = Object.extend({
    observe: function(element) {
	  element = $(element);
      var args = [element.source].concat(_slice.call(arguments, 1));
      _Event.observe.apply(null, args);
    },

    stopObserving: function(element) {
      element = $(element);
      var args = [element.source].concat(_slice.call(arguments, 1));
      _Event.stopObserving.apply(null, args);
    }
  }, _Event);

  function domloaded(fn) { document.observe("dom:loaded", fn); }

  return {
    Array:         Array,
    Ajax:          Ajax,
    each:          Array.each,
    _each:         Array._each,
    Element:       Element,
    Event:         Event,
    Function:      Bridge.Shared.Function,
    String:        Bridge.Shared.String,
    Object:        Object,
    domloaded:     domloaded,
    $:             $,
    $$:            $$,
    emptyFunction: Prototype.emptyFunction,
    K:             Prototype.K,
    Viewport:      document.viewport
  };
})(Bridge));