$(function(){
  $('.email-checkbox').prop('checked', true);
  $('.email-checkbox').click(function() {
      $("#email-div").toggle(this.checked);
  });
});
/*$('.email-checkbox').click(function(){
  if  ($(this).is(':checked')) {
     $("#email-button").removeAttr("disabled")
    //  $("#email-button").prop('disabled', false);
      console.log('checked');
  }else{
      $("#email-button").attr("disabled", true);
      $("#email-button").click(function(e){
        e.preventDefault();
        console.log('prevenetDefault triggered');
      });
  console.log('unchecked');
        //e.preventDefault();
  //    $("#email-button").prop('disabled', true);

  }
})*/

//if($("#isAgeSelected").is(':checked'))
  //  $("#txtAge").show();  // checked
//else
  //  $("#txtAge").hide();  // unchecked
