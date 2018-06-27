$(document).ready(function(){
  $('#withdraw-type').on('change',function(){
    var types = (this.value);
    
    $.get("?r=withdraw/ajax-investor",{
          types:types
      },
      function(data, status){
        //  $('#price').empty().val(data);
          $("#withdraw-investor").html(data);
      });
  });
});
