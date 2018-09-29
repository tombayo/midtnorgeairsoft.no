/**
 * This files gets loaded when the admin page "editpersons" is displayed.
 * Handles the search-fields in the frontend.
 */
$(document).ready(function(){
  $('#p-search').on('submit', function(e){
    e.preventDefault();
    $('#p-results').html('<li class="list-group-item"><span class="glyphicon glyphicon-cog spinning"></span></li>');
    
    $.getJSON(dynUrl.make('admin','jsonpersons',{'type':$('[name="searchtype"]:checked').val(),'text':$('#p-searchbar').val()}), function(r){
      if (r.empty) {
        $('#p-results').html('<li class="list-group-item">Ingen treff :(</li>');
      } else if (r.error) {
        $('#p-results').html('<li class="list-group-item">En feil har oppstått:</li><li class="list-group-item">'+r.error.msg+'</li>');
      } else {
        var list = $('#p-results').html('');
        var ags = $('#accessgroups').children();
        
        for (var i=0;i<r.length;i++) {
          // Prepare HTML
          var item = $('<li>').addClass('list-group-item').appendTo(list);
          var heading = $('<h3>').addClass('list-group-item-heading').appendTo(item);
          var inline = $('<ul>').addClass('h5 list-inline').css('color','#333').appendTo(item);
          var inputgrp = $('<div>').addClass('input-group has-error col-md-5').appendTo(item);
          var igrpaddon = $('<span>').addClass('input-group-addon').html('Tilgangsgruppe:').appendTo(inputgrp);
          var igrptxt = $('<input/>',{
            "type": "text",
            "class": "form-control",
            "disabled": "disabled"
          }).appendTo(inputgrp);
          var igrpbtn = $('<div>').addClass('input-group-btn').appendTo(inputgrp);
          var btn = $('<button>', {
            "type": "button",
            "class": "btn btn-danger dropdown-toggle",
            "data-toggle": "dropdown",
            "aria-haspopup": "true",
            "aria-expanded": "false"
          }).html('Endre <span class="caret"></span>').appendTo(igrpbtn);
          var drpdwn = $('<ul>').addClass('dropdown-menu').appendTo(igrpbtn);
          
          // Fill with content
          heading.html(r[i].lastname+', '+r[i].firstname);
          inline.append($('<li>').html(r[i].email));
          igrptxt.val(r[i].groupname);
          
          for (var j=0;j<ags.length;j++) {
            var cur = $(ags[j]);
            var drpdwnitem = $('<li>').appendTo(drpdwn);
            var ddilink = $('<a>').appendTo(drpdwnitem);
            if (r[i].accesslevel == cur.val() || cur.val() == 9) {
              drpdwnitem.addClass('disabled');
              ddilink.attr('href','#');
            } else {
              ddilink.attr('href',dynUrl.make('admin','editpersons',{'userid':r[i].id,'accesslvl':cur.val()}));
            }
            ddilink.html(cur.html());
          }
        }
      }
    });
  });
  if ($('[data-fixurl]').length) {
    history.pushState({},'',$('[data-fixurl]').data('fixurl'));
  }
})