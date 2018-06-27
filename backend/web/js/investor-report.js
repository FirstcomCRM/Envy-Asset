$(document).ready(function(){

  $("#multi-email").click(function(e){
    e.preventDefault();
    var keys = $('#griditems').yiiGridView('getSelectedRows');
    var dates = $('#investorsearch-date_filter').val();
    //$('#loaders').show();
    $(".overlay").show();
    $.post("?r=investor-report/alter-email",{
          keys:keys,
          dates:dates,
      },
      function(data, status){
          $(".overlay").hide();
          alert('Email Success');

      });
  });

  $(".emails").click(function(e){
    e.preventDefault();
    var keys =  $(this).parents('tr').data('key');
    var dates = $('#investorsearch-date_filter').val();
    console.log(keys);
    $(".overlay").show();
    $.post("?r=investor-report/alter-email",{
          keys:keys,
          dates:dates,
      },
      function(data, status){
          $(".overlay").hide();
          alert('Email Success alone');

      });
  });

});
