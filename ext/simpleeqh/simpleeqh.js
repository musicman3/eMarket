(function($){
"use strict";
$.fn.simpleEQH = function() {
  var maxHeight = this.map(function(i, e) {
    return $(e).height();
  }).get();
  return this.height(Math.max.apply(this, maxHeight));
};
}( jQuery ));