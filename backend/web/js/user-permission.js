$('#userGroup').change(function(){
  $('#w0').submit();
});

$('#controllerName').change(function(){
  $('#w0').submit();
});

$('#select-all').click(function(event) {
    $(':checkbox').each(function() {
        this.checked = true;
    });
});
