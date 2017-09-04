/*$("#tier-form").hide();

$("#apply_tier").on("click",function() {
    $("#tier-form").toggle(this.checked);
  });

  $("#apply_tier").click(function() {
    if($(this).is(":checked")) {
        $("#tier-form").show();
    } else {
        $("#usermanagement-tier_leve").val('');
      //  select2-usermanagement-tier_level-container
    //    $("#usermanagement-tier_level").html('');
    //    $("#usermanagement-tier_level[value='']").attr('selected', true)
    //    document.getElementById('#usermanagement-tier_level').selectedIndex = '';
    //    $("#usermanagement-tier_level").empty();
        $("#tier-form").hide();
    }
});*/
// $("#cat-id").attr("disabled", true);

if($("#apply_tier").is(":checked")) {
   $("#cat-id").removeAttr("disabled");
   $("#subcat-id").removeAttr("disabled");

} else {
    $("#cat-id").attr("disabled", true);
    $("#subcat-id").attr("disabled", true);
}


$("#apply_tier").click(function() {
  if($(this).is(":checked")) {
    //  $("#tier-form").show();
     $("#subcat-id").removeAttr("disabled");
     $("#cat-id").removeAttr("disabled");
  } else {
    //  $("#usermanagement-tier_leve").val('');
  //    $("#tier-form").hide();
       $("#cat-id").attr("disabled", true);
       $("#subcat-id").attr("disabled", true);
  }
});
