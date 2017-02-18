/**
 * Simple javascript-object for dealing with obscurification of email-addresses on webpages.
 * 
 * Works by swapping each char in the string with the matching string in either key or base.
 * Should prevent crawlers from picking up email-adresses on the webpage.
 * 
 * @author Tom Andre Munkhaug <http://github.com/tombayo>
 */
var mailCoder = {
  key:"pxLXbKq80PBTI2Jjs1@aFoMrQC5cmO_ki6gDv+uWdR3zZNHtE7hUAYlVwnGy9fe-S.4",
  base:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@._-+0123456789",
  code:function(from, to, str){
    var result = "";
    for (var i=0; i<str.length; i++) {
      current = str.charAt(i);
      index = from.indexOf(current);
      next = (index == -1) ? current : to.charAt(index);
      result += next;
    }
    return result;
  },
  decode:function(str){
    return this.code(this.key,this.base,str);
  },
  encode:function(str){
    return this.code(this.base,this.key,str);
  }
};


/**
 * When the document is ready..
 * 
 * * Enables Bootstrap's popover where wanted.
 * * Decodes any encoded email-adresses.
 * 
 */
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
  $('[data-email]').each(function(index){
    var email = mailCoder.decode($(this).data('email'));
    $(this).attr('href','mailto:'+email).attr('title', email);
  });
  
});