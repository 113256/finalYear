// DeDup JQuery tablesorter plugin
// version 0.2
// (c) 2015 Tomek 'Grych' Gryszkiewicz, grych@tg.pl
// MIT License
// https://github.com/grych/dedup
//
// DeDup is a Tablesorter widget to hide duplicated values in columns
//
// #### Before:
//
//    +------+--------+
//    | John | Smith  |
//    | John | Doe    |
//    | Ted  | Doe    |
//    +------+--------+
//
// #### After:
//
//     +------+--------+
//     | John | Smith  |
//     |      | Doe    |
//     | Ted  |        |
//     +------+--------+
//
// ## [Example Page](http://www.tg.pl/deduper/ "DeDup example")
//
// ## 1. Include this widget:
//
//     <script type="text/javascript" src="jquery.tablesorter.deduper.js"></script>
//
// ## 2. Define a style for "hidden" elements:
//
//     <style type="text/css">
//       .barely-visible {
//         color: rgba(0, 0, 0, 0.1);
//       }
//     </style>
//
// ## 3. Add widget to the tablesorter:
//
//     $("table").tablesorter({
//       theme: 'default',
//       widgets: ['zebra', 'deduper'],
//       widgetOptions : {
//         dupClass : 'barely-visible',
//         dupCompareFunction: function(x, y) { 
//           return x.toLowerCase() == y.toLowerCase(); 
//         }      
//       }
//     });
//
// ### Options:
//
// * dupClass, default: 
// 'light': class for duplicated elements
// * dupCompareFuction, default: function(x, y) {return x.toLowerCase() == y.toLowerCase();}: function for comparing strings
//
// ### Metadata:
//
// data-deduper="false" in table header to disable dedupering the given header
//
// ## CREDITS
// (c) 2015 Tomek "Grych" Gryszkiewicz
// grych@tg.pl
// https://github.com/grych/dedup
// MIT License
//
$(function() {
  $.tablesorter.addWidget({
    id: "deduper",
    priority: 10,
    options: {
      dupClass : 'light',
      dupCompareFunction: function(x, y) { 
        return x.toLowerCase() == y.toLowerCase();
      }
    },
    format: function(table, c, wo) {
      // remove dupClass from all rows prior to sort
      $("td." + wo.dupClass, table).removeClass(wo.dupClass);
      // initialize the previous row array with $.prototype values (needed to compare first row)
      var before_row = Array.apply(null, Array(c.columns)).map($.prototype.valueOf,$.prototype);
      // only visible rows
      c.$tbodies.children('tr:visible').each(function() { 
        $("td", this).each(function(i) {
          if ( $("th:eq(" + i + ")", table).data('deduper') != false && wo.dupCompareFunction(before_row[i].text(), $(this).text()) ) {
            $(this).addClass(wo.dupClass);
          }
        });
        // gets this row and save it into the Array of JQuery objects
        before_row = $("td", this).map(function() { 
          return $(this);
        }).get();
      });

    },
    remove: function(table, c){
      $("td." + wo.dupClass, table).removeClass(wo.wo.dupClass);
    }
  });
});
