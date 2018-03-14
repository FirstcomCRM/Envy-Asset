$(document).ready(function(){

  //Purchase Module Area
  //$("input[name=someRadioGroup]").on('change', function()
  $('input[name="Purchase[purchase_type]"]').on('change', function() {
    sums();
  });

  $('#price').on('change',function(){
    sums();
  });

  $('#purchase_date').on('change',function(){
  //  console.log('purchase date');
    sums();
  });

  $('#expiry_date').on('change',function(){
    //console.log('expire date');
    sums();
  });

  $('#charge_type').on('change',function(){
    sums();
  });

  $('#company_charge').on('change',function(){
    sums();
  });

  //End of Purchase Module Area

  //Purchase Staff Area
  $('input[name="PurchaseStaff[purchase_type]"]').on('change', function() {
    s_sums();
  });

  $('#s_price').on('change',function(){
    s_sums();
  });

  $('#s_purchase_date').on('change',function(){
  //  console.log('purchase date');
    s_sums();
  });

  $('#s_expiry_date').on('change',function(){
    //console.log('expire date');
    s_sums();
  });

  $('#s_charge_type').on('change',function(){
    s_sums();
  });

  $('#s_company_charge').on('change',function(){
    s_sums();
  });

  //end of Purchase Module Area



});


function sums(){

  var price = $('#price').val();
  var purchase_date = $('#purchase_date').val();
  var expiry_date = $('#expiry_date').val();
  var purchase_type = $('input[name="Purchase[purchase_type]"]:checked').val();
  var charge_type = $('#charge_type').val();
  var company_charge = $('#company_charge').val();
  //company_charge
  //console.log(price);
//  console.log(purchase_type);
//  console.log(charge_type);
  if (price != '' && purchase_date != '' && expiry_date != '') {
    $.post("?r=purchase/ajax-sum",{
          price:price,
          purchase_date:purchase_date,
          expiry_date:expiry_date,
          charge_type:charge_type,
          purchase_type:purchase_type,
          company_charge:company_charge

      },
      function(data, status){
        //  console.log(data);
          //    $( "#sum_all" ).empty().val(data);
      //    var content = $( data ).find( "#content" );
      //    $( "#result" ).empty().append(data);

          var jsonObj = eval ("(" + data + ")");
          $('#customer_earn').empty().val(jsonObj.customer_amount);
          $('#company_earn').empty().val(jsonObj.company_earn);
          $('#staff_earn').empty().val(jsonObj.staff_earn);
      //    $('.selected-item-list').append(data);
          // console.log(status);
      });
  }else{
    console.log('error something');
  }



}

function s_sums(){
  var price = $('#s_price').val();
  var purchase_date = $('#s_purchase_date').val();
  var expiry_date = $('#s_expiry_date').val();
  var purchase_type = $('input[name="PurchaseStaff[purchase_type]"]:checked').val();
  var charge_type = $('#s_charge_type').val();
  var company_charge = $('#s_company_charge').val();
  //company_charge

  if (price != '' && purchase_date != '' && expiry_date != '') {
    $.post("?r=purchase-staff/ajax-sum",{
          price:price,
          purchase_date:purchase_date,
          expiry_date:expiry_date,
          charge_type:charge_type,
          purchase_type:purchase_type,
          company_charge:company_charge

      },
      function(data, status){
        //  console.log(data);
            $( "#s_sum_all" ).empty().val(data);

      //    var content = $( data ).find( "#content" );
      //    $( "#result" ).empty().append(data);

      //    $('.selected-item-list').append(data);
          // console.log(status);
      });
  }else{
    console.log('error something');
  }


}
