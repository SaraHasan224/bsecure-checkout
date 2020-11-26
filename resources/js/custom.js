$(document).ready(function(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $(".create_order").click(function(){
    $.ajax({
      /* the route pointing to the post function */
      url: 'http://local.bsecure_laravel_sdk.localapp/create-order',
      type: 'POST',
      /* send the csrf-token and the input to the controller */
      data: {_token: CSRF_TOKEN, message:null},
      dataType: 'JSON',
      /* remind that 'data' is the response of the AjaxController */
      success: function (data) {
        console.log(data);
        alert("Success");
      }
    });
  });
});