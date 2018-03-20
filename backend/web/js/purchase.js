$(document).ready(function(){

  //Purchase Module Area
  //$("input[name=someRadioGroup]").on('change', function()
  $('input[name="Purchase[purchase_type]"]').on('change', function() {
    pur_sum();
  });

  $('#price').on('change',function(){
  //  datas();
    pur_sum();
  });

  $('#purchase_date').on('change',function(){
  //  console.log('purchase date');
    pur_sum();
  });

  $('#expiry_date').on('change',function(){
    //console.log('expire date');
    pur_sum();
  });

  $('#charge_type').on('change',function(){
    pur_sum();
  });

  $('#company_charge').on('change',function(){
    pur_sum();
  });

  //End of Purchase Module Area


});

function datas(){
  var price = $('#price').val();
  var purchase_date = $('#purchase_date').val();
  var expiry_date = $('#expiry_date').val();
  var purchase_type = $('input[name="Purchase[purchase_type]"]:checked').val();
  var charge_type = $('#charge_type').val();
  var company_charge = $('#company_charge').val();
  //company_charge
//  console.log(price);
//  console.log(purchase_date);
//  console.log(expiry_date);
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


function pur_sum(){

  var price = $('#price').val();
  var purchase_date = $('#purchase_date').val();
  var expiry_date = $('#expiry_date').val();
  var purchase_type = $('input[name="Purchase[purchase_type]"]:checked').val();
  var charge_type = $('#charge_type').val();
  var company_charge = $('#company_charge').val();
  //company_charge
  console.log(price);
  console.log(purchase_type);
  console.log(charge_type);
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
