$(document).ready(function(){


  $('#metalnickeldeals-purchase_price_a').on('change',function(){
  //  sums();
    commissions();
  });

  $('#metalnickeldeals-insurance_cost_a').on('change',function(){
//    sums();
    commissions();
  });

  $('#metalnickeldeals-forward_price').on('change',function(){

    commissions();
  });

  $('#metalnickeldeals-final_sales_price_per').on('change',function(){
    commissions();
  });

  $('#metalnickeldeals-commission_per').on('change',function(){
    commissions();
  });


});

function sums(){
  var pur_price = $('#metalnickeldeals-purchase_price_a').val();
  var ins_price = $('#metalnickeldeals-insurance_cost_a').val();

//  if (pur_price != '' && ins_price != '') {
    $.post("?r=metal-nickel-deals/ajax-sum",{
          pur_price:pur_price,
          ins_price:ins_price,
      },
      function(data,status){
          $('#metalnickeldeals-total_cost_price').empty().val(data);
      });
//  }

}


function commissions(){
  var pur_price = $('#metalnickeldeals-purchase_price_a').val();
  var ins_price = $('#metalnickeldeals-insurance_cost_a').val();
  var for_price = $('#metalnickeldeals-forward_price').val();
  var final_percent = $('#metalnickeldeals-final_sales_price_per').val();
  var com_per = $('#metalnickeldeals-commission_per').val();
//console.log('coms');

  if (pur_price != '' && ins_price != '' && for_price !='' &&final_percent!='' && com_per != '') {
    $.post("?r=metal-nickel-deals/ajax-commission",{
          pur_price:pur_price,
          ins_price:ins_price,
          for_price:for_price,
          final_percent:final_percent,
          com_per:com_per,
      },
      function(data,status){
      //  console.log(data);
          var jsonObj = eval ("(" + data + ")");
          $('#metalnickeldeals-unrealised_profit_a').empty().val(jsonObj.before_commission);
          $('#metalnickeldeals-commision').empty().val(jsonObj.commission);
          $('#metalnickeldeals-unrealised_profit_b').empty().val(jsonObj.after_commission);
          $('#metalnickeldeals-net_unrealised').empty().val(jsonObj.net_realized);
      });
  }
}
