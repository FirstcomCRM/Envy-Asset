$(document).ready(function(){

   $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
       $(".picker").each(function() {
          $(this).datepicker({
            // dateFormat : "dd/mm/yy",
            //  dateFormat : "yy-mm-dd",
                dateFormat : "dd M yy",
            // yearRange : "1925:+0",
             //maxDate : "-1D",
             //changeMonth: true,
             //changeYear: true
          });
     });
   });

   $(".dynamicform_wrapper").on("afterDelete", function(e, item) {
       $(".picker").each(function() {
          $(this).datepicker({
            // dateFormat : "dd/mm/yy",
            //  dateFormat : "yy-mm-dd",
              dateFormat : "dd M yy",
            // yearRange : "1925:+0",
             //maxDate : "-1D",
             //changeMonth: true,
             //changeYear: true
          });
     });
   });

  $('#stocks-buy_in_price').on('change',function(){
    multis();
  });

  $('#stocks-buy_in_rate').on('change',function(){
    multis();
  });

});


function multis(){

  var price = $('#stocks-buy_in_price').val();
  var rate = $('#stocks-buy_in_rate').val();

  if (rate != '' && price != '') {
    $.post("?r=stocks/ajax-local",{
          price:price,
          rate:rate
      },
      function(data, status){

          //var jsonObj = eval ("(" + data + ")");
          $('#stocks-buy_in_local').empty().val(data);
          //console.log(data);
          //$('#company_earn').empty().val(jsonObj.company_earn);
          //$('#staff_earn').empty().val(jsonObj.staff_earn);
      //    $('.selected-item-list').append(data);
          // console.log(status);
      });

  }

}

function lineCurr(item){
    index  = item.attr("id").replace(/[^0-9.]/g, "");
    var monthprice = "stocksline-"+index+"-month_price";
    var monthrate = "stocksline-"+index+"-month_rate";
    var urcurrs = "stocksline-"+index+"-unrealized_curr";

    var buyprice = $('#stocks-buy_in_price').val();
    var buyrate = $('#stocks-buy_in_rate').val();
    var monthpriced = $('#'+monthprice).val();
    var monthrated = $('#'+monthrate).val();

    //  console.log(ucurr);
    var ntotal = 0;
    var noCommas = $('.money').text().replace(/,/g, ''),
    //str.replace(",", "")
    //var str=$(".money").text();
    //var str2=   str.replace(",", "")
    buyprice = buyprice.replace(",", "");
    buyrate = buyrate.replace(",", "");
    monthpriced = monthpriced.replace(",", "");
    monthrated = monthrated.replace(",", "");
    //stocksline-0-unrealized_curr
    ntotal = (monthpriced - buyprice)/buyrate;
    $('#'+urcurrs).val(ntotal);

    if (monthrated != '' && monthpriced != '' && buyrate != '' && buyprice != '') {
      lineLocal(monthrated,monthpriced,buyrate,buyprice,index);
    }

}

function lineLocal(monthrated,monthpriced,buyrate,buyprice,index){
  var mtotal = 0;
  var buyprod = buyrate*buyprice;
  var monthprod = monthrated*monthpriced;

  var urloc = "stocksline-"+index+"-unrealized_local";

  mtotal = ( (monthprod-buyprod)/buyprod )*100;

  $('#'+urloc).val(mtotal);
  //in here
  //console.log(monthrated);
  //console.log(monthpriced);

}

function solds(item){
  var mtotal = 0;

  index  = item.attr("id").replace(/[^0-9.]/g, "");
  //stockslinea-0-sold_price
  var ids_price = "stockslinea-"+index+"-sold_price";
  var ids_unit = "stockslinea-"+index+"-sold_units";
  var ids_balance = "stockslinea-"+index+"-balance";

  var sold_price = $('#'+ids_price).val();
  var sold_units = $('#'+ids_unit).val();

  sold_price = sold_price.replace(",", "");
  sold_units = sold_units.replace(",", "");

  if (sold_price != '' && sold_units != '') {
    mtotal = sold_price*sold_units;
    $('#'+ids_balance).val(mtotal);
  }

  unitsTotal();


}

function unitsTotal(){
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
  $('#stocks-total_sold_unit').val(ntotal);
  console.log(ntotal);
}

function offRecalc(item){
  var index =  item.attr("id").replace(/[^0-9.]/g, "");
  removeUnits= "stockslinea-"+index+"-sold_units";
  $('#'+removeUnits).val(0.00);
  unitsTotal();

}
