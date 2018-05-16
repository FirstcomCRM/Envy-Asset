$(document).ready(function(){
  //$(".stocks-head").hide();


  //.monthpicker applicable only at investor report
  $(".monthPicker").datepicker({
    dateFormat: 'M yy',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('M yy', new Date(year, month, 1)));
        }
    });

  $(".monthPicker").focus(function () {
       $(".ui-datepicker-calendar").hide();
       $("#ui-datepicker-div").position({
           my: "center top",
           at: "center bottom",
           of: $(this)
       });
   });



  var typep = '';
  var typep = $('input[name="Purchase[purchase_type]"]:checked').val();
  //console.log(typep);
  hiding(typep);
//  listProducts(typep);

  //Purchase Module Area
  //$("input[name=someRadioGroup]").on('change', function()
  $('input[name="Purchase[purchase_type]"]').on('change', function() {
    var ptype = $('input[name="Purchase[purchase_type]"]:checked').val();
    hiding(ptype);
    if (ptype) {
      listProducts(ptype);
    }
    //pur_sum();
  });



  $('#purchase-buy_units').on('change',function(){
    console.log('purchase-buy_unit');
    stocksAmount();
  });

  $('#purchase-buy_in_price').on('change',function(){
    console.log('purchase-buy_price');
    stocksAmount();
  });


  $('#products').on('change',function(){
    nickelDate();
  });

  $('#price').on('change',function(){
  //  datas();
  //  console.log('@@');
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
    nickelDate();
  });

  //End of Purchase Module Area


});

//function to hide divs
function hiding(typep){
  if (typep == 'Metal') {
    $(".metal-head").show();
    $(".nickels-head").hide();
    $(".stocks-head").hide();
    $("#purchase-buy_curr_rate").val('');
    $("#purchase-buy_units").val('');
    $("#purchase-buy_in_price").val('');
    $("#purchase-nickel_date").val('');
    $("#purchase-nickel_expiry").val('');

  }else if(typep == 'Nickel'){
    $(".nickels-head").show();
    $(".stocks-head").hide();
    $(".metal-head").hide();
    $("#purchase-buy_curr_rate").val('');
    $("#purchase-buy_units").val('');
    $("#purchase-buy_in_price").val('');
    $("#purchase-expiry_date").val('');
    $("#purchase-trading_days").val('');
    $("#purchase-prorated_days").val('');

  }else if(typep == 'Stocks'){
    $(".stocks-head").show();
    $(".nickels-head").hide();
    $(".metal-head").hide();
    $("#purchase-nickel_date").val('');
    $("#purchase-nickel_expiry").val('');
    $("#purchase-expiry_date").val('');
    $("#purchase-trading_days").val('');
    $("#purchase-prorated_days").val('');

  }else{
    $(".nickel-head").hide();
    $(".stocks-head").hide();
    $(".metal-head").hide();
  }
}

//function to list Products based on selected value
function listProducts(typep){
  var selects = 'Select Product';
  var test = 0;
  $.post("?r=purchase/ajax-product",{
      //  ptype:ptype,
        ptype:typep,
    },
    function(data, status){

        $("#products").empty();
        $("#products").append('<option value="'+test+'">'+selects+'</option>');
        $.each(data,function(key,value){
            //add a fix add selected attribute
            $("#products").append('<option value="'+key+'">'+value+'</option>');
       });

    },'json' );

}

function stocksAmount(){
  var stocks_unit = $("#purchase-buy_units").val();
  var stocks_price = $("#purchase-buy_in_price").val();
  if (stocks_price != '' && stocks_unit != '') {
    $.post("?r=purchase/ajax-stockamount",{
          stocks_unit:stocks_unit,
          stocks_price:stocks_price,
      },
      function(data, status){
          $('#price').empty().val(data);

      });
  }
}

//onchange()
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
  //console.log(expiry_date);
  price = price.replace(",", "");
  if (price != '' && purchase_date != '' && expiry_date != '') {
    $.post("?r=purchase/ajax-sum",{
          price:price,
          purchase_date:purchase_date,
          expiry_date:expiry_date,
          charge_type:charge_type,
          purchase_type:purchase_type,
          company_charge:company_charge,
        //  sold_price:sold_price,

      },
      function(data, status){
          var jsonObj = eval ("(" + data + ")");
          $('#customer_earn').empty().val(jsonObj.customer_amount);
          $('#company_earn').empty().val(jsonObj.company_earn);
          $('#staff_earn').empty().val(jsonObj.staff_earn);
      });
  }else{
  //  console.log('error something');
  }


}

function nickelDate(){
  var product = $('#products').val();

  console.log(product);
  if (product!='') {
    $.post("?r=purchase/ajax-nickel",{
          product:product,
      },
      function(data, status){
        console.log('test');
          var jsonObj = eval ("(" + data + ")");
          $('#purchase-nickel_date').empty().val(jsonObj.start);
          $('#purchase-nickel_expiry').empty().val(jsonObj.end);
      //    'purchase-nickel_date',
      //    'purchase-nickel_expiry',
      });
  }
}

//onchange()
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
  punitsTotal();
}

//onchange()
function punitsTotal(){
  var ntotal = 0;
  var total = 0;
  var items = $('.item_a');
  items.each(function(index, elem){
    var totalPart = $(elem).find(".sumPart").val();
    totalPart = totalPart.replace(",", "");
    if ($.isNumeric(totalPart) ) {
      total = parseFloat(total) + parseFloat(totalPart);
      total = parseFloat(total).toFixed(2);
      ntotal = total;
    //  console.log(typeof ntotal);
    }

  });
  $('#purchase-ptotal_sold_unit').val(ntotal);
//  console.log(ntotal);
}


//onchange()
function poffRecalc(item){
  var index =  item.attr("id").replace(/[^0-9.]/g, "");
  //purchaseline-0-psold_units
  removeUnits= "purchaseline-"+index+"-psold_units";
  $('#'+removeUnits).val(0.00);
  punitsTotal();

}
