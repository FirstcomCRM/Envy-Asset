$(document).ready(function(){

});


function sums(){

  var price = $('#price').val();
  var purchase_date = $('#purchase_date').val();
  var expiry_date = $('#expiry_date').val();

  if (price != '' && purchase_date != '' && expiry_date != '') {
    $.post("?r=purchase/ajax-sum",{
          price:price,
          purchase_date:purchase_date,
          expiry_date:expiry_date,

      },
      function(data, status){
          console.log(data);
      //    var content = $( data ).find( "#content" );
      //    $( "#result" ).empty().append(data);
          $( "#sum_all" ).empty().val(data);
      //    $('.selected-item-list').append(data);
          // console.log(status);
      });
  }else{
    console.log('error something');
  }



}
