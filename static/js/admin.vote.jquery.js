/**
 * This files gets loaded when the admin page "vote" is displayed.
 * Enables the selection and submission of candidate votes on the page.
 */
$(document).ready(function(){
  $('li[data-vote]').on('click',function(){
    $(this).parent().find('.vote-selected').removeClass('vote-selected') // Remove existing selection
    $(this).addClass('vote-selected') // Highlight clicked item
    $('#voteinput').val($(this).data('vote'))
  }).find('.users-list-name').css({whiteSpace:'normal'})
})