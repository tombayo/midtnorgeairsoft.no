/**
 * Dynamic URL 
 */

(function() {
  var dynUrl = function($) {

     /** Sets the state of URL-rewrite */
    var rewrite = document.getElementsByName('urlrewrite')[0].content == 'true' ? true:false;


    /**
     * Creates an url based on the application's config in respect to url rewrite
     * 
     * @todo The conditionals in this function can surely ble simplified and improved!
     * 
     * @param controller The controller to link to.
     * @param method The method within the controller to link to (optional).
     * @param get Optional object to build a GET statement out of.
     * @param frag Optional fragment(after #) string to be appended to the url.
     * @returns The url.
     */
    function make(controller,method,get,frag) {
      var path = controller;
      var query = '';
      var url = '';
      
      if (typeof method !== "undefined") {
        if (method !== '') path += '/'+method;
      }
      if (typeof argument !== "undefined") {
        if (argument !== '') path += '/'+argument;
      }
      if (typeof get !== "undefined") {
        if (get !== {}) query = $.param(get);
      }
      
      if (rewrite) {
        url = '/'+path;
        if (query !== '') url += '?'+query;
      } else {
        url = '/?p=' + path;
        if (query !== '') url += '&'+query;
      }
      
      if (typeof frag  !== "undefined") url += '#'+frag;
      
      return url;
    }


    return {
      make: make
    }

  };
  
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      return define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
      var $ = require('jQuery');
      return module.exports = factory($);
    } else {
      return root.dynUrl = factory(root.$);
    }
  })(this, dynUrl);

}).call(this);