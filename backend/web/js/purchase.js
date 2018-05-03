$(document).ready(function(){

  var typep = '';
  var typep = $('input[name="Purchase[purchase_type]"]:checked').val();
  //console.log(typep);
  if (typep == 'Metal') {
    $("#stocks-test").hide();
    $("#nickels-test").hide();
  }else if(typep == 'Nickel'){
    $("#stocks-test").hide();
    $("#nickels-test").show();
  }else if(typep == 'Stocks'){
    $("#stocks-test").show();
    $("#nickels-test").hide();
  }else{
    $("#stocks-test").hide();
    $("#nickels-test").hide();
  }

  //Purchase Module Area
  //$("input[name=someRadioGroup]").on('change', function()
  $('input[name="Purchase[purchase_type]"]').on('change', function() {
    var ptype = $('input[name="Purchase[purchase_type]"]:checked').val();
    //console.log(ptype);
    if (ptype == 'Metal') {
      $("#stocks-test").hide();
      $("#nickels-test").hide();
    }else if(ptype == 'Nickel'){
      $("#stocks-test").hide();
      $("#nickels-test").show();
    }else if(ptype == 'Stocks'){
      $("#stocks-test").show();
      $("#nickels-test").hide();
    }

    if (ptype) {
      console.log('ajax-product')
      $.post("?r=purchase/ajax-product",{
            ptype:ptype,
        },
        function(data, status){

            $("#products").empty();
            $.each(data,function(key,value){
                $("#products").append('<option value="'+key+'">'+value+'</option>');
           });

        },'json' );

    }

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

  $('#purchase-sold_price').on('change',function(){
    pur_sum();
  });

  $('#company_charge').on('change',function(){
    pur_sum();
  });


  $('#purchase-product').on('change',function(){
      //console.log('expire date');
  //  var product = $('#purchase-product').val();
  //  console.log(product);
    nickelDate();
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
    //console.log('error something');
  }
}


function pur_sum(){

  var price = $('#price').val();
  var purchase_date = $('#purchase_date').val();
  var expiry_date = $('#expiry_date').val();
  var purchase_type = $('input[name="Purchase[purchase_type]"]:checked').val();
  var charge_type = $('#charge_type').val();
  var company_charge = $('#company_charge').val();
  var sold_price = $('#purchase-sold_price').val();
  if (sold_price == '') {
    sold_price = 0;
  }
  price = price.replace(",", "");
  //purchase-sold_price
  //company_charge
  console.log(sold_price);
//  console.log(purchase_type);
//  console.log(charge_type);
  if (price != '' && purchase_date != '' && expiry_date != '') {
    $.post("?r=purchase/ajax-sum",{
          price:price,
          purchase_date:purchase_date,
          expiry_date:expiry_date,
          charge_type:charge_type,
          purchase_type:purchase_type,
          company_charge:company_charge,
          sold_price:sold_price,

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
  //  console.log('error something');
  }


}

function nickelDate(){
  var product = $('#purchase-product').val();

  if (product!='') {
    $.post("?r=purchase/ajax-nickel",{
          product:product,
      },
      function(data, status){
          var jsonObj = eval ("(" + data + ")");
          $('#purchase-nickel_date').empty().val(jsonObj.start);
          $('#purchase-nickel_expiry').empty().val(jsonObj.end);
      //    'purchase-nickel_date',
      //    'purchase-nickel_expiry',
      });
  }
}

function pursolds(item){
  var mtotal = 0;
  
  index  = item.attr("id").replace(/[^0-9.]/g, "");
  //purchaseline-0-psold_price"
  var ids_price = "purchaseline-"+index+"-psold_price";
  var ids_unit = "purchaseline-"+index+"-psold_units";
  var ids_balance = "purchaseline-"+index+"-pbalance";

  var sold_price = $('#'+ids_price).val();
  var sold_units = $('#'+ids_unit).val();

  sold_price = sold_price.replace(",", "");
  sold_units = sold_units.replace(",", "");

  if (sold_price != '' && sold_units != '') {
    mtotal = sold_price*sold_units;
    $('#'+ids_balance).val(mtotal);
  }
  //item_a


}
