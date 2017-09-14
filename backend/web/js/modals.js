$(function(){
  $('#modalButton').click(function(){ //#modalButton, changed to class when in gridview customer link
    $('#modal').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });

  

});
