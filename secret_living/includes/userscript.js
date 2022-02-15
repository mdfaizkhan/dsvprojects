$(document).ready(function() {
    if($('select').hasClass('categorymultiselect'))
    {
        $('.categorymultiselect').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '400px',
            enableFiltering: true
        });
        $('div.btn-group').addClass('importantRule');
    }
    CKEDITOR.replaceClass = 'ckeditor';

//profile Script
  var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
  });

  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url'],select,input[type='number'],textarea"),
          isValid = true;

      $(".form-group").removeClass("has-error");
      for(var i=0; i<curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }

      if (isValid)
          nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
});


$('select[name=status]').change(function()
{
    if(this.value == 'Approved') {
        $('.approval_field').attr("required", true);
    }
    else {
        $('.approval_field').attr("required", false);
    }
});

var Country={
    getState:function(val){
        $elm=$('#state');
        $elm.html('<option value=""> -- Select Country First -- </option>');
        if(!val)return false;
        $(".state-loading").show();
        $.post("../includes/webfunction",
            {
                id: val,
                type: "GetState"
            },
            function(resp, status){
                resp=JSON.parse(resp);
                if(resp.success)
                {
                    $data=resp.data;
                    $elm.html('<option value=""> -- Select State -- </option>');
                    for($i=0;$i<$data.length;$i++){
                        $elm.append('<option value="'+$data[$i].name+'">'+$data[$i].name+'</option>')
                    }
                }
                else {
                    $elm.html('<option value=""> -- Select Country First -- </option>');
                }
                $(".state-loading").hide();
            });
    }
};

/*---------------------------- End Of Generate & Share Link ----------------------*/

$(document).ready(function()
{
    $(document).on('click','#bump-offer',function ()
    {
        var check = $(this).is(":checked");
        if(check)
        {
            $(".checkbox").prop("checked", true);
        }
        else
        {
            $(".checkbox").prop("checked", false);
        }
    });
});


/*$("#formvalidate").click(function(e)
{
    var formname = $(this).attr("data-form");
    $('#'+formname).validate();
    if($('#'+formname).valid())
    {
        $('#'+formname).submit();
        return false;
    }
    else
    {
        return false
    }
});*/

$("body").on('click', '#formvalidate,.formvalidate', function(){
    var formname = $(this).attr("data-form");
    $('#'+formname).validate();
    if($('#'+formname).valid())
    {
        $('#'+formname).submit();
        return false;
    }
    else
    {
        //swal("Please fill all the required fields");
        return false
    }
});

$("body").on('change blur', '.checkValidPin', function()
{
    var pin_no = $(this).val();
    var slen = pin_no.length;
    if (slen>4)
    {
        $elm = $('.submit-loading1');
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : "../includes/userfunction",
            data :  {
                pin_no : pin_no,
                type : "checkValidPin"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    
                    return false;
                }
                else
                {
                    _toastr(data.message,"bottom-right","info",false);
                    $('#pin_no').focus();
                    return false;
                }
                return false;
            }
        });
    }

});
/* add / Edit User */
$("#formaddedituser").submit(function(e)
{
    /* alert("call"); */
   e.preventDefault();
   $elm=$(".btn-submit");
   $elm.hide();
   $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: "../includes/userfunction",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data)
        {
            $(".submit-loading").remove();
            $elm.show();
            var data = jQuery.parseJSON(data);
            if(data.valid)
            {
               _toastr(data.msg,"bottom-right","success",false);
                setTimeout(function(){
                  location.href='direct_child';
                }, 2000);
            }
            else
            {
                _toastr(data.msg,"bottom-right","info",false);
                return false;
            }

        }
    });
});

/*
* Change Admin Password
*/
$("#changepass").submit(function(e)
{
   e.preventDefault();
   $elm=$(".btn-submit");
   $elm.hide();
   $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
   var current_password = $("#current_password").val();
   var new_password = $("#new_password").val();
   var rpassword = $("#rpassword").val();
   if(current_password == "" || new_password == "" || rpassword == "")
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("Currrent password or new password cannot be empty","bottom-right","info",false);
       return false;
   }
   else if(new_password !=  rpassword)
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("New Password & Confirm Password does not match","bottom-right","info",false);
       return false;
   }
   else
   {
       $.ajax({
           type: "POST",
           url  : "../includes/userfunction",
           data:{
               ajax_current_password : current_password,
               ajax_new_password : new_password,
               ajax_confirm_password : rpassword,
               ajax_changepassword : true
           },
           success: function (data)
           {
               var data = jQuery.parseJSON(data);
                $(".submit-loading").remove();
                $elm.show();
                if( data.valid == 1)
                {
                   _toastr(data.message,"bottom-right","success",false);
                   setTimeout(function(){
                       location.href = 'index';
                   }, 3000);
                   return false;
                }
                else
                {
                    _toastr(data.message,"bottom-right","info",false);
                    return false;
                }

           }
       });
   }
});

$("#changetranspass").submit(function(e)
{
   e.preventDefault();
   $elm=$(".btn-submit");
   $elm.hide();
   $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
   var current_password = $("#current_password").val();
   var new_password = $("#new_password").val();
   var rpassword = $("#rpassword").val();
   if(current_password == "" || new_password == "" || rpassword == "")
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("Currrent password or new password cannot be empty","bottom-right","info",false);
       return false;
   }
   else if(new_password !=  rpassword)
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("New Password & Confirm Password does not match","bottom-right","info",false);
       return false;
   }
   else
   {
       $.ajax({
           type: "POST",
           url  : "../includes/adminfunction",
           data:{
               ajax_current_password : current_password,
               ajax_new_password : new_password,
               ajax_confirm_password : rpassword,
               ajax_changetpassword : true
           },
           success: function (data)
           {
               var data = jQuery.parseJSON(data);
                $(".submit-loading").remove();
                $elm.show();
                if( data.valid == 1)
                {
                   _toastr(data.message,"bottom-right","success",false);
                   setTimeout(function(){
                       location.href = 'index';
                   }, 3000);
                   return false;
                }
                else
                {
                    _toastr(data.message,"bottom-right","info",false);
                    return false;
                }

           }
       });
   }
});
$("#fchangetranspass").submit(function(e)
{
   e.preventDefault();
   $elm=$(".btn-submit");
   $elm.hide();
   $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
   var current_password = $("#current_password").val();
   var new_password = $("#new_password").val();
   var rpassword = $("#rpassword").val();
   if(current_password == "" || new_password == "" || rpassword == "")
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("Currrent password or new password cannot be empty","bottom-right","info",false);
       return false;
   }
   else if(new_password !=  rpassword)
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("New Password & Confirm Password does not match","bottom-right","info",false);
       return false;
   }
   else
   {
       $.ajax({
           type: "POST",
           url  : "../includes/userfunction",
           data:{
               ajax_current_password : current_password,
               ajax_new_password : new_password,
               ajax_confirm_password : rpassword,
               ajax_fchangetpassword : true
           },
           success: function (data)
           {
               var data = jQuery.parseJSON(data);
                $(".submit-loading").remove();
                $elm.show();
                if( data.valid == 1)
                {
                   _toastr(data.message,"bottom-right","success",false);
                   setTimeout(function(){
                       location.href = 'index';
                   }, 3000);
                   return false;
                }
                else
                {
                    _toastr(data.message,"bottom-right","info",false);
                    return false;
                }

           }
       });
   }
});
$("body").on('click', '.accountstatus', function()
{

    var id = $(this).attr("data-id");
    var status = $(this).attr("data-value");
    $elm = $(this);
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $.ajax({
        type : 'POST',
        url : "../includes/userfunction",
        data :  {
            id : id,
            status: status,
            type : "UserStatus"
        },
        success : function(data)
        {
            $(".submit-loading").remove();
            $elm.show();
            var data = jQuery.parseJSON(data);
            if(data.valid)
            {
                _toastr(data.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.reload();
                }, 3000);
                return false;
            }
            else
            {
                _toastr(data.message,"bottom-right","info",false);
                return false;
            }
            return false;
        }
    });

});





$(document).on('click','.RemoveSelectedPin',function ()
{
    $elm=$(this);
    var pin_id = [];
    $.each($("input[name='checked_id[]']:checked"), function(){
        pin_id.push($(this).val());
    });
    bootbox.confirm({
        message: "Warning: You are about to delete multiple pin. Continue to Delete?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        pin_id : pin_id,
                        type : 'RemoveSelectedPin'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});


/*
* Change User Password
*/
$("#userChangePass").submit(function(e)
{
   e.preventDefault();
   $elm=$(".btn-submit");
   $elm.hide();
   $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
   var new_password = $("#new_password").val();
   var rpassword = $("#rpassword").val();
   var uid = $("#uid").val();
   if(new_password == "" || rpassword == "")
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr(" new password cannot be empty","bottom-right","info",false);
       return false;
   }
   else if(new_password !=  rpassword)
   {
       $(".submit-loading").remove();
        $elm.show();
       _toastr("New Password & Confirm Password does not match","bottom-right","info",false);
       return false;
   }
   else
   {
       $.ajax({
           type: "POST",
           url  : '../includes/userfunction',
           data:{
               uid : uid,
               new_password : new_password,
               confirm_password : rpassword,
               changeUserpassword : true
           },
           success: function (data)
           {
               var data = jQuery.parseJSON(data);
                $(".submit-loading").remove();
                $elm.show();
                if( data.valid)
                {
                   _toastr(data.msg,"bottom-right","success",false);
                   setTimeout(function(){
                       location.href = 'direct_child';
                   }, 3000);
                   return false;
                }
                else
                {
                    _toastr(data.msg,"bottom-right","info",false);
                    return false;
                }

           }
       });
   }
});
//Transfer Pin
$("#TransferPinToUser").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var uid=$("#user_id").val();
    $form=$(this);
    var formData = new FormData(this);
    bootbox.prompt({
        title: "Enter Password To Transfer Pin",
        inputType: 'password',
        callback: function (password) {
            //console.log(result);
            if(password!='')
            {
              $.ajax({
                type : 'POST',
                url : '../includes/adminfunction',
                data :  {
                    password : password,
                    uid : uid,
                    type : 'CheckPassword'
                },
                success : function(data)
                {
                    var resp = jQuery.parseJSON(data);
                    $(".submit-loading").remove();
                    $elm.show();
                    if(resp.success)
                    {
                        $.ajax({
                          type: 'POST',
                          url: '../includes/userfunction',
                          data:formData,
                          cache:false,
                          contentType: false,
                          processData: false,
                          success: function(resp) {
                              resp=JSON.parse(resp);
                              if(resp.success){
                                  _toastr(resp.message,"bottom-right","success",false);
                                  setTimeout(function(){
                                      location.reload();
                                  }, 4000);
                              }else{
                                  _toastr(resp.message,"bottom-right","info",false);
                              }
                              $(".submit-loading").remove();
                              $elm.show();
                          },
                          error: function(data) {
                          }
                        });
                        return false;
                    }
                    else
                    {
                        _toastr(resp.message,"bottom-right","info",false);
                        return false;
                    }
                    
                    return false;
                }
              });
            }
            else
            {
              _toastr("Please Enter Password","bottom-right","info",false);
            }
        }
    });
    
});
//Update Profile
$("#UpdateProfile1,#UpdateProfile2,#UpdateProfile3,#UpdateProfile4").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/userfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.reload();
                }, 4000);
            }else{
                _toastr(resp.message,"bottom-right","info",false);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});


$(document).on('click','.PurchasePlan',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to repurchase a plan. Continue to Purchase?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                var plan_id = $elm.attr("data-id");
                var price = $elm.attr("data-price");
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        plan_id : plan_id,
                        amount : price,
                        type : 'PlanPurchase'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.href='orders';
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});

//Request Pin
$("#ManageRequestPin").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/userfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.reload();
                }, 4000);
            }else{
                _toastr(resp.message,"bottom-right","info",false);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});

$(document).on('click','.deleteRequest',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a Request. Continue to Delete?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                var req_id = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        req_id : req_id,
                        type : 'deleteRequest'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.href='reqpin';
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});

$(document).on('click','.ProductPurchase',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to purchase a Product. Continue to Purchase?",
        inputType: 'number',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
              bootbox.prompt({
                  title: "Enter Quantity",
                  inputType: 'number',
                  callback: function (qty) {
                      console.log(qty);
                  
                      $('.bootbox-confirm').modal('hide');
                      $elm.hide();
                      $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                      var product_id = $elm.attr("data-id");
                      var price = $elm.attr("data-price");
                      $.ajax({
                          type : 'POST',
                          url : '../includes/userfunction',
                          data :  {
                              product_id : product_id,
                              price : price,
                              qty : qty,
                              type : 'ProductPurchase'
                          },
                          success : function(data)
                          {
                              $(".submit-loading").remove();
                              $elm.show();
                              var data = jQuery.parseJSON(data);
                              if(data.success)
                              {
                                  _toastr(data.message,"bottom-right","success",false);
                                  setTimeout(function(){
                                      location.href='cpayment';
                                  }, 3000);
                                  return false;
                              }
                              else
                              {
                                  _toastr(data.message,"bottom-right","info",false);
                                  return false;
                              }

                              return false;
                          }
                      });
                return false;
                }
              });
            }
        }
    });

});
//Manage Transfer Pin
$("#ManageTransPin").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/userfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.reload();
                }, 4000);
            }else{
                _toastr(resp.message,"bottom-right","info",false);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});

//**********************************************  ACTIVATE BINARY *******************************

$(document).on('click','.activatebinary',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Activate A Binary Plan. Continue to Activate?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                var plan_id = $elm.attr("data-id");
                var price = $elm.attr("data-price");
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        // plan_id : plan_id,
                        // amount : price,
                        type : 'activatebinary'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.href='binaryplan';
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});
$(document).on('click','.ReqUpgradePlan',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Request An Upgrade Plan. Continue to Upgrade?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                var plan_id = $elm.attr("data-id");
                var price = $elm.attr("data-price");
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        plan_id : plan_id,
                        amount : price,
                        type : 'ReqUpgradePlan'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.href='reqplan';
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});










//**********************************************  ACTIVATE BINARY *******************************

// $(document).on('click','.activatebinary',function () {
//     $elm=$(this);
//     bootbox.confirm({
//         message: "Warning: You are about to repurchase a plan. Continue to Purchase?",
//         buttons: {
//             confirm: {
//                 label: 'Yes',
//                 className: 'btn-success'
//             },
//             cancel: {
//                 label: 'No',
//                 className: 'btn-danger'
//             }
//         },
//         callback: function (result)
//         {
//             if(result == true)
//             {
//                 $('.bootbox-confirm').modal('hide');
//                 $elm.hide();
//                 $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
//                 var plan_id = $elm.attr("data-id");
//                 var price = $elm.attr("data-price");
//                 $.ajax({
//                     type : 'POST',
//                     url : '../includes/userfunction',
//                     data :  {
//                         // plan_id : plan_id,
//                         // amount : price,
//                         type : 'activatebinary'
//                     },
//                     success : function(data)
//                     {
//                         $(".submit-loading").remove();
//                         $elm.show();
//                         var data = jQuery.parseJSON(data);
//                         if(data.success)
//                         {
//                             _toastr(data.message,"bottom-right","success",false);
//                             setTimeout(function(){
//                                 location.href='orders';
//                             }, 3000);
//                             return false;
//                         }
//                         else
//                         {
//                             _toastr(data.message,"bottom-right","info",false);
//                             return false;
//                         }

//                         return false;
//                     }
//                 });
//                 return false;
//             }
//         }
//     });

// });



$(document).on('click','.request_for_withdraw',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: Are you sure withdraw you amount?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        uid:uid,
                        type : 'RequestForWithdraw'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});

$(document).on('click','.SubmitPinVerify',function(e){
  e.preventDefault();
  $elm  = $(this);
  var pin_no = $('#pin_no').val();
  /*$elm.hide();
  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');*/
  $.ajax({
    url:'../includes/userfunction',
    type:'post',
    data:{
      pin_no : pin_no,
      type : 'SubmitPinVerify',
    },
    success:function(result){
      var res = JSON.parse(result);
      if(res.success)
      {
         _toastr(res.message,"bottom-right","success",false);
          setTimeout(function(){
            location.reload();
          }, 2000);
      }
      else
      {
          _toastr(res.message,"bottom-right","info",false);
          return false;
      }
    }
  })
})

$(document).on('click','.changemenu',function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    
    var url1=$(this).data("href");
    var uid=$(this).data("uid");
    bootbox.prompt({
        title: "Enter Password To Transfer Pin",
        inputType: 'password',
        callback: function (password) {
            //console.log(result);
            if(password!='')
            {
              $.ajax({
                type : 'POST',
                url : '../includes/adminfunction',
                data :  {
                    password : password,
                    uid : uid,
                    type : 'ChecktPassword'
                },
                success : function(data)
                {
                    var resp = jQuery.parseJSON(data);
                    $(".submit-loading").remove();
                    $elm.show();
                    if(resp.success)
                    {
                        location.href=url1;
                        return false;
                    }
                    else
                    {
                        _toastr(resp.message,"bottom-right","info",false);
                        return false;
                    }
                    
                    return false;
                }
              });
            }
            else
            {
              _toastr("Please Enter Password","bottom-right","info",false);
            }
        }
    });
    
});
$('#ActivatePlan11111111,#ActivatePlanall11111111111').submit(function(e){
    e.preventDefault();
    $elm=$(this).find(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var formData = new FormData(this);
    $.ajax({
        url:'../includes/userfunction',
        type:'post',
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(result){
            var res = jQuery.parseJSON(result);
            $(".submit-loading").remove();
            $elm.show();
            if(res.valid)
            {
                _toastr(res.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.reload();
                }, 1000);
                return false;
            }
            else
            {
                _toastr(res.message,"bottom-right","info",false);
                return false;
            }
        }
    })
})
$('#ActivatePlan,#ActivatePlanall').submit(function(e){
    e.preventDefault();
    /*if(show_password_verify_modal == 1){
        $('.password_verification').modal('show');
        return false;
    }*/
    $elm=$(this).find(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var formData = new FormData(this);
    var uid=mlmid;
    bootbox.prompt({
        title: "Enter Transaction Password To Activate Pin",
        inputType: 'password',
        callback: function (password) {
            console.log(password);
            if(password!='')
            {
              $.ajax({
                type : 'POST',
                url : '../includes/adminfunction',
                data :  {
                    password : password,
                    uid : uid,
                    type : 'ChecktPassword'
                },
                success : function(data)
                {
                    var resp = jQuery.parseJSON(data);
                   
                    if(resp.success)
                    {
                        $.ajax({
                            url:'../includes/adminfunction',
                            type:'post',
                            cache:false,
                            contentType:false,
                            processData:false,
                            data:formData,
                            success:function(result){
                                var res = jQuery.parseJSON(result);
                                $(".submit-loading").remove();
                                $elm.show();
                                if(res.valid)
                                {
                                    _toastr(res.message,"bottom-right","success",false);
                                    setTimeout(function(){
                                        location.reload();
                                    }, 1000);
                                    return false;
                                }
                                else
                                {
                                    _toastr(res.message,"bottom-right","info",false);
                                    return false;
                                }
                            }
                        })
                        return false;
                    }
                    else
                    {
                        _toastr(resp.message,"bottom-right","info",false);
                         $(".submit-loading").remove();
                        $elm.show();
                        return false;
                    }
                    
                    return false;
                }
              });
            }
            else
            {
              _toastr("Please Enter Password","bottom-right","info",false);
              
            }
        }
    });
    
    
    
})

$("body").on('blur', '.checkusername', function()
{
    var username = $(this).val();
    var slen = username.length;
    if (slen>0)
    {
        $elm = $('.submit-loading1');
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : "../includes/webfunction",
            data :  {
                username : username,
                type : "checkusername"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    $(".usernamevalid").remove();
                    $('#usernameresp').html('<div class="usernamevalid btn btn-xs btn-success"><i class="fa fa-check"></i></div>');
                    return false;
                }
                else
                {
                    $('#username').focus();
                    $(".usernamevalid").remove();
                    $('#usernameresp').html('<div class="usernamevalid btn btn-xs btn-danger"><i class="fa fa-close"></i></div>');
                    return false;
                }
                return false;
            }
        });
    }
});
$("body").on('blur', '.getSponsordetail', function()
{
    var sponsor_id = $(this).val();
    var slen = sponsor_id.length;
    if (slen>0)
    {
        $elm = $('.submit-loading1');
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : "../includes/webfunction",
            data :  {
                sponsor_id : sponsor_id,
                type : "getSponsordetail"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    $("#Sponsordetail").html(data.name);
                    return false;
                }
                else
                {
                     _toastr(data.message,"bottom-right","info",false);
                    $('#sponsor_id').focus();
                    return false;
                }
                return false;
            }
        });
    }
});

$("body").on('blur', '.getParentdetail', function()
{
    var parent_id = $(this).val();
    var slen = parent_id.length;
    if (slen>0)
    {
        $elm = $('.submit-loading1');
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : "../includes/webfunction",
            data :  {
                sponsor_id : parent_id,
                type : "getSponsordetail"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    $("#Parentdetail").html(data.name);
                    return false;
                }
                else
                {
                     _toastr(data.message,"bottom-right","info",false);
                    $('#parent_id').focus();
                    return false;
                }
                return false;
            }
        });
    }
});

//Payout as paid
$(document).on('click','.OrdersMarkAsPaid',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Mark Purchase As Paid,Continue to Mark As Paid?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                var id = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        id : id,
                        type : 'PaidProductOrders'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});

/***************************************  Purchase Product  ***************************************/
function randomIntFromInterval(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}
$(document).ready(function()
{
  var productlist='';
  var wrapper = $(".additionc"); 

    var x = 1; //initlal text box count
    $("body").on("click",".add_field_button", function(e){
        e.preventDefault();
        var newid = randomIntFromInterval(2, 10000);
            var options='';
            if (productlist.length > 0) {

                for ($i = 0; $i < productlist.length; $i++) {
                    //console.log(productlist[$i]);
                    options +='<option value="' + productlist[$i]['id'] + '">'+productlist[$i]['name']+'</option>';
                }
                
            }
            $(wrapper).append('<div class="inside_div margin-bottom-10">'
                
                +'<div class="col-md-12">'
                +'<span class="btn btn-danger btn-xs button-color remove_field pull-right"><i class="fa fa-plus"></i> Remove</span></div>'
                +'<div class="clearfix"></div>'
                +'<div class="row bx1">'
                +'<div class="form-group" style="padding-left:10px; padding-right:10px;">'
                +'<div class="col-md-4 col-sm-6">'
                +'<label>Products</label>'
                +'<select placeholder = "Products" class = "form-control select2 ProductsSel"  name = "products['+newid+'][name]" id = "products'+newid+'" title = "Enter Product.!" >'
                
                +'<option value="">Select Product</option>'+ options+'</select>'               
                +'</div>'
                +'<div class="col-md-4 col-sm-6">'
                +'<label>Quantity</label>'
                +'<input type="number"  placeholder = "Quantity" class = "form-control" name = "products['+newid+'][qty]"  id = "quantity'+newid+'" title = "Enter Quantity" >'
                +'</div>'
                
                +'<div class="clearfix"></div>'
                +'</div>'
                +'</div>'
                +'<div class="clearfix"></div>'
                +' </div>'
                +'</div>'
                +'</div>'
                +'</div>'); //add input box
            $('.ProductsSel').select2();
        
    });

    $(wrapper).on("click",".remove_field", function(e){
        e.preventDefault();
        if($(this).closest(".inside_div").remove())
        {
            x--;
        }

    });
    
     /*var productlist = '';*/
     var price = 0;
    $('body').on("change",".productFetch", function(e)
    { 
        
            var cat_id=$('#cat_id').val();
            if(cat_id!='')
            {
                
                    $.ajax({
                        type: "POST",
                        url: "../includes/userfunction",
                        data: {
                            cat_id: cat_id,
                            ProductFetch: true
                        },

                        success: function (data) {

                            mydata = JSON.parse(data);
                            productlist = mydata.data;

                            /*alert($data[0]);*/
                            $elm = $('.ProductsSel');
                            //$elm.empty();
                            $elm.html('<option value="">Select Product</option>');

                            if (productlist.length > 0) {

                                for ($i = 0; $i < productlist.length; $i++) {
                                    //console.log(productlist[$i]);
                                    $elm.append('<option value="' + productlist[$i]['id'] + '">'+productlist[$i]['name']+'</option>');
                                }
                                
                            }
                            else
                            {
                              $('.ProductsSel').val('');
                              $('.ProductsSel').select2();
                              /*$('.ProductsSel').val('');*/
                            }
                            /*var key  = _.findIndex(productlist, { 'name': 'Gulab Jamun'});
                            alert(key);*/
                            return false;
                        }
                    });
            } else {
                _toastr('Please Select Category',"bottom-right","info",false);
                return false;
            }
        });
    });

//add Order
 $("#formaddorder").submit(function(e)
    {
        e.preventDefault();
        //$("#address").val($(".note-editable").html());
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "../includes/userfunction",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data)
            {
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                   _toastr(data.msg,"bottom-right","success",false);
                    setTimeout(function(){
                            location.href='myinvoice?id='+data.id; 
                    }, 2000);
                }
                else
                {
                    _toastr(data.msg,"bottom-right","info",false);
                    return false;
                }

            }
        });
    });

 //delete Order
$("body").on('click', '.DeleteOrder', function()
{
    var id = $(this).attr("data-id");
    $elm = $(this);
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $.ajax({
        type : 'POST',
        url : "../includes/userfunction",
        data :  {
            id : id,
            type : "DeleteOrder"
        },
        success : function(data)
        {
            $(".submit-loading").remove();
            $elm.show();
            var data = jQuery.parseJSON(data);
            if(data.valid)
            {
                $('#product'+id).hide();
                _toastr(data.message,"bottom-right","success",false);
                setTimeout(function(){
                            window.location.reload(); 
                    }, 2000);
                return false;
            }
            else
            {
                _toastr(data.message,"bottom-right","info",false);
                return false;
            }
            return false;
        }
    });

});
$(document).on('click','.paymentDetail',function () {
  var id = $(this).attr("data-id");
  var mid = $(this).attr("data-mid");
  $("#purchase_id").val(id);
  $("#ManagePaymentDetails")[0].reset();
  $('#'+mid).modal('show');
}); 
$(document).ready(function(){
//add Order
    $("#ManagePaymentDetails").submit(function(e)
    {
        e.preventDefault();
        //$("#address").val($(".note-editable").html());
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "../includes/userfunction",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data)
            {
                var data = jQuery.parseJSON(data);
                if(data.success)
                {
                   _toastr(data.msg,"bottom-right","success",false);
                    setTimeout(function(){
                            location.href='cpayment'; 
                    }, 2000);
                }
                else
                {
                    _toastr(data.msg,"bottom-right","info",false);
                    return false;
                }

            }
        });
    });


    $("#ManageBalReq").submit(function(e)
    {
        e.preventDefault();
        //$("#address").val($(".note-editable").html());
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "../includes/userfunction",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data)
            {
                var data = jQuery.parseJSON(data);
                if(data.success)
                {
                   _toastr(data.msg,"bottom-right","success",false);
                    setTimeout(function(){
                            location.href='balance'; 
                    }, 2000);
                }
                else
                {
                    _toastr(data.msg,"bottom-right","info",false);
                    return false;
                }

            }
        });
    });


    $(document).on('click','.DeleteWBReq',function () {
      $elm=$(this);
      bootbox.confirm({
          message: "Warning: You are about to delete a Request. Continue to Delete?",
          buttons: {
              confirm: {
                  label: 'Yes',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'No',
                  className: 'btn-danger'
              }
          },
          callback: function (result)
          {
              if(result == true)
              {
                  $('.bootbox-confirm').modal('hide');
                  $elm.hide();
                  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                  var req_id = $elm.attr("data-id");
                  $.ajax({
                      type : 'POST',
                      url : '../includes/userfunction',
                      data :  {
                          req_id : req_id,
                          type : 'DeleteWBReq'
                      },
                      success : function(data)
                      {
                          $(".submit-loading").remove();
                          $elm.show();
                          var data = jQuery.parseJSON(data);
                          if(data.success)
                          {
                              _toastr(data.message,"bottom-right","success",false);
                              setTimeout(function(){
                                  location.reload();
                              }, 3000);
                              return false;
                          }
                          else
                          {
                              _toastr(data.message,"bottom-right","info",false);
                              return false;
                          }

                          return false;
                      }
                  });
                  return false;
              }
          }
      });

    });


    $("#ManageFBalReq").submit(function(e)
    {
        e.preventDefault();
        //$("#address").val($(".note-editable").html());
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "../includes/userfunction",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data)
            {
                var data = jQuery.parseJSON(data);
                if(data.success)
                {
                   _toastr(data.msg,"bottom-right","success",false);
                    setTimeout(function(){
                            location.href='fbalance'; 
                    }, 2000);
                }
                else
                {
                    _toastr(data.msg,"bottom-right","info",false);
                    return false;
                }

            }
        });
    });


    $(document).on('click','.DeleteFWBReq',function () {
      $elm=$(this);
      bootbox.confirm({
          message: "Warning: You are about to delete a Request. Continue to Delete?",
          buttons: {
              confirm: {
                  label: 'Yes',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'No',
                  className: 'btn-danger'
              }
          },
          callback: function (result)
          {
              if(result == true)
              {
                  $('.bootbox-confirm').modal('hide');
                  $elm.hide();
                  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                  var req_id = $elm.attr("data-id");
                  $.ajax({
                      type : 'POST',
                      url : '../includes/userfunction',
                      data :  {
                          req_id : req_id,
                          type : 'DeleteFWBReq'
                      },
                      success : function(data)
                      {
                          $(".submit-loading").remove();
                          $elm.show();
                          var data = jQuery.parseJSON(data);
                          if(data.success)
                          {
                              _toastr(data.message,"bottom-right","success",false);
                              setTimeout(function(){
                                  location.reload();
                              }, 3000);
                              return false;
                          }
                          else
                          {
                              _toastr(data.message,"bottom-right","info",false);
                              return false;
                          }

                          return false;
                      }
                  });
                  return false;
              }
          }
      });

    });



});


$(document).on('click','.DispatchOrder',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to dispatch an order. Are You Sure ?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result)
        {
            if(result == true)
            {
                $('.bootbox-confirm').modal('hide');
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                var order_id = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/userfunction',
                    data :  {
                        order_id : order_id,
                        type : 'DispatchOrder'
                    },
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                        $elm.show();
                        var data = jQuery.parseJSON(data);
                        if(data.success)
                        {
                            _toastr(data.message,"bottom-right","success",false);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            return false;
                        }

                        return false;
                    }
                });
                return false;
            }
        }
    });

});