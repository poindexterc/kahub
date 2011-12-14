Tipped.options = {
  zIndex: 3000
};

Bridge.Object.extend(Tipped.Skins || (Tipped.Skins = {}), {
  // base skin
  // leave untouched for inheritance to work
  'base': {
    afterUpdate: false,
    ajax: {
      cache: true,
      method: 'post'
    },
    background: {
      color: '#f2f2f2',
      opacity: 1
    },
    border: {
      size: 1,
      color: '#111',
      opacity: 1
    },
    closeButtonSkin: 'default',
    color: '#fff',
    containment: {
      selector: 'viewport',
      flip: false
    },
    fadeDuration: .22,
    showDelay: .14,
    hideDelay: 0,
    padding: 8,
    radius: {
      size: 5,
      position: 'background'
    },
    hideAfter: false,
    hideOn: {
      element: 'self',
      event: 'mouseleave'
    },
    hideOnClickOutside: false,
    hook: 'topleft',
    offset: {
      x: 0,
      y: 0,
      mouse: { // only defined in the base class
        x: -8,
        y: -8
      }
    },
    onHide: false,
    onShow: false,
    shadow: {
      blur: 1,
      color: '#000',
      offset: {
        x: 0,
        y: 0
      },
      opacity: .3
    },
    showOn: 'mousemove',
    stem: {
      corner: {
        height: 8,
        width: 8
      },
      center: {
        height: 7,
        width: 13
      }
    },
    target: 'self'
  },
  
  // every other skin inherits from this one
  'reset': {
    ajax: false,
    border: {
      opacity: 1
    },
    closeButton: false,
    hideOn: [{
      element: 'self',
      event: 'mouseleave'
    }, {
      element: 'tooltip',
      event: 'mouseleave'
    }],
    hook: 'topmiddle',
    shadow: {
      blur: 2
    },
    stem: true
  }
});

Bridge.Object.extend(Tipped.CloseButtonSkins || (Tipped.CloseButtonSkins = {}), {
  'base': {
    diameter: 18,
    border: 2,
    x: {
      diameter: 10,
      size: 2,
      opacity: 1
    },
    states: {
      'default': {
        background: {
          color: [
            { position: 0, color: '#1a1a1a' },
            { position: 0.46, color: '#171717' },
            { position: 0.53, color: '#121212' },
            { position: 0.54, color: '#101010' },
            { position: 1, color: '#000' }
          ],
          opacity: 1
        },
        x: {
          color: '#fafafa',
          opacity: 1
        },
        border: {
          color: '#fff',
          opacity: 1
        }
      },
      'hover': {
        background: {
          color: [
            { position: 0, color: '#232323' },
            { position: 0.46, color: '#202020' },
            { position: 0.53, color: '#1b1b1b' },
            { position: 0.54, color: '#191919' },
            { position: 1, color: '#0a0a0a' }
          ],
          opacity: 1
        },
        x: {
          color: '#fff',
          opacity: 1
        },
        border: {
          color: '#fff',
          opacity: 1
        }
      }
    },
    shadow: {
      blur: 3,
      color: '#000',
      offset: {
        x: 0,
        y: 0
      },
      opacity: .25
    }
  },

  'reset': {}
});