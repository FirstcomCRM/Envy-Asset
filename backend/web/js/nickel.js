$(document).ready(function(){

});

function costPrice(){
  var pur_price = $('#metalnickeldeals-purchase_price_a').val();
  var ins_price = $('#metalnickeldeals-insurance_cost_a').val();

  if (!$.isNumeric(pur_price)) {
    pur_price = 0;
  }

  if (!$.isNumeric(ins_price)) {
    ins_price = 0;
  }

  var total = parseFloat(pur_price)+parseFloat(ins_price);
  // /metalnickeldeals-total_cost_price
  total = total.toFixed(2);
  $('#metalnickeldeals-total_cost_price').val(total);
//  var expiry_date = $('#expiry_date').val();
}

function costPrice_b(){
  var pur_price = $('#metalnickeldeals-purchase_price_a').val();
  var ins_price = $('#metalnickeldeals-insurance_cost_a').val();

  if (!$.isNumeric(pur_price)) {
    pur_price = 0;
  }

  if (!$.isNumeric(ins_price)) {
    ins_price = 0;
  }

  var total = parseFloat(pur_price)+parseFloat(ins_price);
  total = total.toFixed(2);
  return total;

}


function beforeCom(){
  var final = $('#metalnickeldeals-final_sales_price').val();

  //costPrice = Total Cost Prices B16
  var costPrice = costPrice_b();//function call

  var total = parseFloat(final) - parseFloat(costPrice);
  total = total.toFixed(2);
  $('#metalnickeldeals-unrealised_profit_a').val(total);

  //comTotal = Commission b19
  var com_total = commission(total);//function call

  $('#metalnickeldeals-commision').val(com_total);
  var after_com = total-com_total;
  after_com = after_com.toFixed(2);
  //after com = Realized Profit after Commission B20
  $('#metalnickeldeals-unrealised_profit_b').val(after_com);

  //return = Net Realised Percentage Returns
  var return_per = (after_com/costPrice)*100;
  return_per = return_per.toFixed(2);
    console.log(return_per);
  $('#metalnickeldeals-net_unrealised').val(return_per);

}

function commission(total){

  var n_total = parseFloat(total)* parseFloat(0.15);
  n_total = n_total.toFixed(2);
//  $('#metalnickeldeals-commision').val(n_total);
  return n_total;
//  console.log(total);
}
