$(document).ready(function(){

   $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
       $(".picker").each(function() {
          $(this).datepicker({
            // dateFormat : "dd/mm/yy",
              dateFormat : "yy-mm-dd",
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

  console.log(monthprod);
  console.log(buyprod);
  console.log(mtotal);
}
