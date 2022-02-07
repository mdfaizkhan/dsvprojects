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
            url : "../includes/adminfunction",
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
   e.preventDefault();
   $elm=$(".btn-submit");
//   var mobile_no=$("#mobile_no").val().match('[0-9]{10}');
//   if(mobile_no){
//          _toastr("Please put 10 digit mobile number","bottom-right","info",false);
//          setTimeout(function(){                         
//           }, 2000);
//   }else{
     var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: "../includes/adminfunction",
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
                         //location.href='user';
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
$("#adminchangepass").submit(function(e)
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
           url	: "../includes/adminfunction",
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

$("#UserUpdate").submit(function(e)
{
    e.preventDefault();
    var country = $('input[name=country]').val();
    var zip = $('input[name=zip]').val();
    var address = $('input[name=address1]').val();

    var isvalid = true;
    if (!isValidEmail($('input[name=email]').val()))
    {
        $msg = "Enter Valid Email id";
        isvalid = false;
    }
    else if (!isValidPhone($('input[name=mobile_no]').val()))
    {
        $msg = "Mobile Number should be 10 digit";
        isvalid = false;
    }
    else if ($('input[name=phone_no]').val() != '' && !isValidPhone($('input[name=phone_no]').val()))
    {
        $msg = "Phone Number should be 10 digit";
        isvalid = false;
    }
    else if(!addressCheck(address))
    {
        $msg = "Address line may not contain special characters";
        isvalid = false;
    }
    else if(!isValidCity($('input[name=city]').val()))
    {
        $msg = "City should have character only";
        isvalid = false;
    }
    else if (!validZip(zip,country))
    {
        $msg = "Enter Valid Zip Code";
        isvalid = false;
    }

    if(isvalid)
    {
        $elm=$(".btn-submit");
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $form=$(this);
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '../includes/adminfunction',
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
    }
    else
    {
        _toastr($msg,"bottom-right","info",false);

    }
});



$("body").on('click', '.GeneratePassword', function()
{

    var id = $(this).attr("data-id");
    $elm = $(this);
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $.ajax({
        type : 'POST',
        url	: "../includes/adminfunction",
        data :  {
            id : id,
            type : "GeneratePassword"
        },
        success : function(data)
        {
            $(".submit-loading").remove();
            $elm.show();
            var data = jQuery.parseJSON(data);
            if(data.valid)
            {
                _toastr(data.message,"bottom-right","success",false);
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

$("body").on('click', '.accountstatus', function()
{

    var id = $(this).attr("data-id");
    var status = $(this).attr("data-value");
    $elm = $(this);
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $.ajax({
        type : 'POST',
        url	: "../includes/adminfunction",
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

$("#ManagePlan").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='plans';
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

$(document).on('click','.deleteplan',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a plan. if any user have this plan will be removed from it Continue to Delete?",
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
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        plan_id : plan_id,
                        type : 'DelPlan'
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

$("#ManagePin").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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

$(document).on('click','.deletepin',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a pin. Continue to Delete?",
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
                var pin_id = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        pin_id : pin_id,
                        type : 'DelPin'
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
                    url : '../includes/adminfunction',
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

//set Level
$("#setLevelPer").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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
//set Level
$("#setRoyaltyAmount").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='plans';
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
//remove all record
$(document).on('click','.RemoveSelecteduser',function ()
{
    $elm=$(this);
    var user_id = [];
    $.each($("input[name='checked_id[]']:checked"), function(){
        user_id.push($(this).val());
    });
    bootbox.confirm({
        message: "Warning: You are about to delete multiple User. Continue to Delete?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        user_id : user_id,
                        type : 'RemoveSelecteduser'
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
           url  : '../includes/adminfunction',
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
//Manage Transfer Pin
$("#ManageTransPin").submit(function(e)
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
                            url: '../includes/adminfunction',
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
//Payout as paid
$(document).on('click','.PayoutMarkAsPaid',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Mark Payout As Paid,Continue to Mark As Paid?",
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
                var uid = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        uid : uid,
                        type : 'PayoutMarkPaid'
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

$(document).on('click','.PayoutMarkAsPaid_rank',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Mark Payout As Paid,Continue to Mark As Paid?",
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
                var uid = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        uid : uid,
                        type : 'PayoutMarkPaid_rank'
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
//all payout paid
$(document).on('click','.AllPayoutPaid',function () {
    $elm=$(this);
    var payout = [];
    $.each($("input[name='checked_id[]']:checked"), function(){
        payout.push($(this).val());
    });
    bootbox.confirm({
        message: "Warning: You are about to Mark Payout As Paid,Continue to Mark As Paid?",
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
                var uid = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        uid : payout,
                        type : 'AllPayoutPaid'
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
//Update Profile
$("#UpdateProfile1,#UpdateProfile2,#UpdateProfile3").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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

//generate payout for plan1
$(document).on('click','.GenerateDirectPlan',function ()
{
    bootbox.confirm({
        message: "Warning: You are about Generate Direct Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateDirectPlan');
                $('#myModal').modal('show');
                return false;
            }
        }
    });
});

//generate payout for plan2
$(document).on('click','.GenerateSingleLeg',function ()
{

    bootbox.confirm({
        message: "Warning: You are about Generate Royalty Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateSingleLeg');
                $('#myModal').modal('show');
                return false;
               /* $('.bootbox-confirm').modal('hide');
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {

                        type : 'GenerateSingleLeg'
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
                                location.href="complete_payout";
                            }, 2000);
                            return false;
                        }
                        else
                        {
                            _toastr(data.message,"bottom-right","info",false);
                            setTimeout(function(){
                                location.href="complete_payout";
                            }, 2000);
                            return false;
                        }

                        return false;
                    }
                });
                return false;*/
            }
        }
    });

    
});
//generate payout for Binary
$(document).on('click','.GenerateBinaryPayout',function ()
{

    bootbox.confirm({
        message: "Warning: You are about Generate Binary Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('BinaryPayoutGenerate');
                $('#myModal').modal('show');
                return false;
            }
        }
    });

    
});
//generate payout for Binary
$(document).on('click','.GenerateReferalPayout',function ()
{

    bootbox.confirm({
        message: "Warning: You are about Generate Referal Bonus Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateReferalPayout');
                $('#myModal').modal('show');
                return false;
            }
        }
    });

    
});

//
$(document).on('click','.generateBonusPayout',function(e){
    bootbox.confirm({
        message: "Warning: You are about Generate Binary Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateBonusPayout');
                $('#myModal').modal('show');
                return false;
            }
        }
    });
    $/*.ajax({
        url:'../includes/adminfunction',
        type:'POST',
        data:{
            type:'GenerateBonusPayout',
        },
        success:function(result){
            var res = JSON.parse(result);
            if(res.success)
            {
                _toastr(res.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href="complete_bonus";
                }, 2000);
                return false;
            }
            else
            {
                _toastr(res.message,"bottom-right","error",false);
                return false;
            }
        }
    })*/
})
$(document).on('click','.generateRoiPayout',function(e){
    bootbox.confirm({
        message: "Warning: You are about Generate Binary Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateRoiPayout');
                $('#myModal').modal('show');
                return false;
            }
        }
    });
   /* $.ajax({
        url:'../includes/adminfunction',
        type:'POST',
        data:{
            type:'GenerateRoiPayout',
        },
        success:function(result){
            var res = JSON.parse(result);
            if(res.success)
            {
                _toastr(res.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href="complete_bonus";
                }, 2000);
                return false;
            }
            else
            {
                _toastr(res.message,"bottom-right","error",false);
                return false;
            }
        }
    })*/
})




//generate payout for plan3
$(document).on('click','.plan3',function (){
    $elm=$(this);

    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');

    $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {

            type : 'plan3'
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
                    location.href="complete_payout";
                }, 2000);
                return false;
            }
            else
            {
                _toastr(data.message,"bottom-right","info",false);
                setTimeout(function(){
                    location.href="complete_payout";
                }, 2000);
                return false;
            }

            return false;
        }
    });
    return false;
});

$(document).on('click','.SubmitPassword',function (){
    $elm=$(this);
    var uid=$("#user_id").val();
    var password= $("#password").val();
    var plan= $("#plan").val();
    //$('#myModal').modal('show');
    
    if (uid!='' && password!='')
    {
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
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
                $('#myModal').modal('hide');
                $("#password").val('');
                var resp = jQuery.parseJSON(data);
                $(".submit-loading").remove();
                $elm.show();
                if(resp.success)
                {
                    $.ajax({
                        type : 'POST',
                        url : '../includes/adminfunction',
                        data :  {
                            type : plan
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
                                    location.href="complete_payout";
                                }, 2000);
                                return false;
                            }
                            else
                            {
                                _toastr(data.message,"bottom-right","info",false);
                                setTimeout(function(){
                                    location.href="complete_payout";
                                }, 2000);
                                return false;
                            }

                            return false;
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
        return false;
    }
    else
    {
        _toastr("Enter Password To Generate Payout.","bottom-right","info",false);
        return false;
    }
});


//set Level
$("#AddReward").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='rewardplans';
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

$(document).on('click','.deleterewardplan',function (){
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a reward plan. if any user have this plan will be removed from it Continue to Delete?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        id : id,
                        type : 'DelRewardPlan'
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

$(document).on('click','.MarkRewardPaid',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to mark all reward paid a reward. Continue to Mark?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        id : id,
                        type : 'MarkRewardPaid'
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
$(document).on('click','.MarkAllRewardPaid',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to mark all reward paid a reward. Continue to Mark?",
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
                //var id = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        type : 'MarkAllRewardPaid'
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

//set Amount and other detail for royalty
$("#EditPayoutDetail").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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

$(document).on("click", ".descModaluser", function ()
{
    var id = $(this).attr('data-id');
    $elm = $(this);
    $("#UserDeModal #userid").val(id);
    $('#UserDeModal').modal('show');
});
/*$('#UserDeModal').on('hidden.bs.modal', function () {
 location.reload();
})*/
//$("#DeactiveUser").submit(function(e)
$(document).on("submit", "#DeactiveUser", function (e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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

$(document).on("click", ".PModaluser", function ()
{
    alert(11);
    var id = $(this).attr('data-id');
    var fname = $(this).attr('data-name');
    var rank = $(this).attr('data-rank');
    $elm = $(this);
    $("#UserPayModal #userid").val(id);
    $("#UserPayModal #rank_name").val(rank);
    $("#UserPayModal #myModalLabel").html(fname);
    $('#UserPayModal').modal('show');
});
$(document).on("submit", "#UserRankPay", function (e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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

$("#AddNews").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='news';
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

$(document).on('click','.deleteNews',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a News.Are You Sure Continue to Delete?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        id : id,
                        type : 'DelNews'
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

$("#AddWebNews").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='wnews';
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

$(document).on('click','.deleteWEBNews',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a News.Are You Sure Continue to Delete?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        id : id,
                        type : 'DelWebNews'
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

/**************************************** Repurchase *****************************************/
//Other Product
$("#ManageProduct").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='products';
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

$(document).on('click','.deleteProduct',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a Product. Continue to Delete?",
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
                var product_id = $elm.attr("data-id");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        product_id : product_id,
                        type : 'deleteOtherProduct'
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

$(".addprdimage").click(function () {
   $(".PrdImg").append('<div class="row">'+
       '<div class="form-group">'+
        '<div class="col-md-4">'+
        '<label>Product Image</label>'+
        '<div class="fancy-file-upload fancy-file-primary">'+
        '<i class="fa fa-upload"></i>'+
        '<input type="file" class="form-control" name="prdimage[]" onchange="jQuery(this).next(\'input\').val(this.value);" accept="image/jpeg, image/png">'+
        '<input type="text" class="form-control" placeholder="No file selected" readonly="" >'+
        '<span class="button">Choose File</span>'+
        '</div>'+
        '</div>'+
        '<div class="col-md-1 col-sm-1" style="padding-top:28px;">'+
        '<label>&nbsp;</label>'+
        '<span class="btn btn-sm btn-primary RemovePrdImg"><i class="fa fa-minus"></i></span>'+
        '</div>'+
        '</div>'+
        '</div>');
});

$(document).on('click','.RemovePrdImg',function () {
    $(this).closest(".row").remove();
});

$('.delprdimages').click(function(){
    var rowid = $(this).attr("data-rowid");
    var image_id = $(this).attr("data-imageid");
    $.ajax({
        type : 'POST',
        url : "../includes/adminfunction",
        data :  {
            image_id : image_id,
            delbanqimg : true
        },
        success : function(data)
        {
            var data = jQuery.parseJSON(data);
            if(data.valid == "1")
            {
                $('#'+rowid).hide();
                _toastr(data.message,"bottom-right","success",false);
                return false;
            }
            else
            {
                _toastr(data.message,"bottom-right","error",false);
                return false;
            }
            return false;
        }
    });
    return false;
});







$("#ManagerPlan").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='rplans';
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

$(document).on('click','.deleterplan',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a repurchase plan. Continue to Delete?",
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
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        plan_id : plan_id,
                        type : 'DelrPlan'
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
//set Level
$("#setLevelIncome").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='rplans';
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

$(document).on('click','.RejectRequest',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Reject a Request. Are You Sure to Reject?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        req_id : req_id,
                        type : 'RejectPINRequest'
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
                                location.href='pinreq';
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

//approve pin req
$(document).on('click','.ApprovePINReq',function () {
    $elm=$(this);
    var request = [];
    $.each($("input[name='checked_id[]']:checked"), function(){
        request.push($(this).val());
    });
    if(request.length > 0)
    {
        bootbox.confirm({
            message: "Warning: You are about to approve pin request,Continue to approve?",
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
                        url : '../includes/adminfunction',
                        data :  {
                            request : request,
                            type : 'PINReqApprove'
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
    }
    else
    {
         _toastr("Select Atleast One Request To Approve! ","bottom-right","info",false);
         return false;
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
                    url : '../includes/adminfunction',
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

//Re Purchase

$(document).on('click','.RejectPurchaseReq',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Reject a Request. Are You Sure to Reject?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        req_id : req_id,
                        type : 'RejectPurchaseReq'
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

//approve pin req
$(document).on('click','.ApprovePurchaseReq',function () {
    $elm=$(this);
    var request = [];
    $.each($("input[name='checked_id[]']:checked"), function(){
        request.push($(this).val());
    });
    if(request.length > 0)
    {
        bootbox.confirm({
            message: "Warning: You are about to approve Purchase request,Continue to approve?",
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
                        url : '../includes/adminfunction',
                        data :  {
                            request : request,
                            type : 'PurchaseReqApprove'
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
    }
    else
    {
         _toastr("Select Atleast One Request To Approve! ","bottom-right","info",false);
         return false;
    }

});

//set Amount and other detail for Singke leg
$("#EditSinglePayoutDetail").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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

//set Amount and other detail for Referal payout
$("#EditRefBonusDetail").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
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
$(document).on('click','.confirmcancel',function(){
    $elm=$(this);
    var userid;
    var ans=$(this).val();

    // planid=$.trim($(this).data('planid'));
     userid=$.trim($(this).data('userid'));
    bootbox.confirm({
        message: "Are you sure you want to "+ans,
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
                    type :"post",
                    url : "confirm_binary",
                    data :
                    {
                        userid : userid,
                        ans :ans
                    },
                    datatype : "json",
                    success : function(data)
                    {
                        $(".submit-loading").remove();
                            $elm.show();
                        var result = JSON.parse(data);
                            if(result.res == "success"){
                                //console.log('ssss');
                               _toastr('Success!',"bottom-right","success",false);
                                setTimeout(function(){ 
                                  location.reload();
                                },2000);
                          }
                          else if(result.res == "Fail"){
                                 // console.log('ffff');
                                _toastr('Something went wrong!',"bottom-right","success",false);
                                
                          }
                    }
                });
                //return false;
            }
        }
    });

});
$("body").on('click', '.ProductStatus', function()
{
    var id = $(this).attr("data-id");
    var status = $(this).attr("data-value");
    $elm = $(this);
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $.ajax({
        type : 'POST',
        url : "../includes/adminfunction",
        data :  {
            id : id,
            status: status,
            type : "ChangeProductStatus"
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
                }, 1000);
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

$(document).on('click','.PlanRequeststatus',function(){
    $elm=$(this);
    var userid;
    var ans=$(this).val();

    // planid=$.trim($(this).data('planid'));
     req_id=$.trim($(this).data('id'));
     bootbox.confirm({
            message: "Warning: You are sure,You Want To Continue to "+ans+"?",
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
                    type :"post",
                    url : "../includes/adminfunction",
                    data :
                    {
                        req_id : req_id,
                        status :ans,
                        type :"PlanRequeststatus"
                    },
                    datatype : "json",
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
                            }, 1000);
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
                //return false;
            }
        }
    });

});
$(document).on('click','.UpgradePlan',function(){
    $elm=$(this);
    var ans=$(this).val();

    plan_id=$.trim($(this).data('plan'));
    uid=$.trim($(this).data('id'));
     bootbox.confirm({
            message: "Warning: You are sure,You Want To Continue to Upgarde Plan ?",
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
                    type :"post",
                    url : "../includes/adminfunction",
                    data :
                    {
                        plan_id : plan_id,
                        uid :uid,
                        type :"UpgradeUserPlan"
                    },
                    datatype : "json",
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
                            }, 1000);
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
                //return false;
            }
        }
    });

});




$(document).on('click','.Approve,.Reject',function(){
    $elm=$(this);
    var status = $(this).attr('data-status');
    var request_id = $(this).attr('data-id');
    bootbox.confirm({
            message: "Warning: You are sure,You Want To Continue to action ?",
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
                    type :"post",
                    url : "../includes/adminfunction",
                    data :
                    {
                        request_id : request_id,
                        status : status,
                        type : "UpdateRequestStatus"
                    },
                    datatype : "json",
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
                            }, 1000);
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
                //return false;
            }
        }
    });

});


$('#UploadExcelFrom').submit(function(e){
    e.preventDefault();
    $elm=$(".UploadExcelFrom");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var formData = new FormData(this);
    $.ajax({
        url:'../includes/adminfunction',
        type:'post',
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(result){
            var res= JOSN.parse(result);
            $(".submit-loading").remove();
            $elm.show();
            if(res.success)
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

/*$('[name="topupother"]').click(function(){
    $('.password_verification').modal('show');
})
*/

/*var show_password_verify_modal = 1;
$('#check_password').click(function(){
    var password = $('.bootbox-input-password').val();
    var uid = mlmid;
    if(password == ''){
         _toastr('Enter Password',"bottom-right","success",false);
         return false;
    }
    $.ajax({
        url:'../includes/adminfunction',
        type:'POST',
        data:{
            password : password,
            uid : uid,
            type : 'ChecktPassword'
        },
        success:function(result){
            var res = JSON.parse(result);
            if(res.success == true){
                show_password_verify_modal = 0;
                $('#ActivatePlanall').submit();
            }
            else{
                show_password_verify_modal = 1;
                _toastr(res.message,"bottom-right","info",false);
                return false;
            }
        }
    })
    
})*/


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
$(document).on('click','.UpgradeTopup',function(){
    $elm=$(this);
    var ans=$(this).val();

    plan_id=$.trim($(this).data('plan'));
    uid=$.trim($(this).data('id'));
     bootbox.confirm({
            message: "Warning: You are sure,You Want To Continue to Upgarde Pin ?",
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
                    type :"post",
                    url : "../includes/adminfunction",
                    data :
                    {
                        plan_id : plan_id,
                        uid :uid,
                        type :"UpgradeUserPlan"
                    },
                    datatype : "json",
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
                            }, 1000);
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
                //return false;
            }
        }
    });

});

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

/*
Add/Edit Product Category
 */
$("#ManageCategory").submit(function(e)
{
  e.preventDefault(); 
  $elm=$(".btn-submit");
  $elm.hide();
  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
  /*for (var i in CKEDITOR.instances) {
    CKEDITOR.instances[i].updateElement();
  } */
  $form=$(this);
  var formData = new FormData(this);
  $.ajax({
    type: 'POST',
    url: '../includes/adminfunction',
    data:formData,
    cache:false,
    contentType: false,
    processData: false, 
    success: function(resp) {
      resp=JSON.parse(resp);
      if(resp.success)
      {
        _toastr(resp.message,"bottom-right","success",false);                    
        setTimeout(function(){
          location.href='category';
        },2000);
      }
      else{
         _toastr(resp.message,"bottom-right","info",false);
      }
      $(".submit-loading").remove();
      $elm.show();
    },
    error: function(data) {
    }
  }); 
});

 /*
Delete Category
 */
$(document).on('click','.DeleteCat',function () {

  var id = $(this).attr("data-id");
  
    bootbox.confirm({
      message: "Warning: You are sure,You Want To Continue to Upgarde Pin ?",
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
       $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {
          id : id,
          type : 'DeleteCategory'
        },
        success : function(data)
        {
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
      })
     }
  }
  });   
});


$(document).on('click','.ReqMarkAsPaid',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Confirm Balance Request,Continue to Confirm?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        req_id : req_id,
                        type : 'ReqMarkAsPaid'
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
$(document).on('click','.RejectReq',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Reject Balance Request,Continue to Reject?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        req_id : req_id,
                        type : 'RejectReq'
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

//generate gtb payout
$(document).on('click','.GenerateGTBPayout',function ()
{
    bootbox.confirm({
        message: "Warning: You are about Generate GTB Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateGTBPayout');
                $('#myModal').modal('show');
                return false;
            }
        }
    });    
});
/// Generate Rank Payout

$(document).on('click','.GenerateRankayout',function ()
{
    bootbox.confirm({
        message: "Warning: You are about Generate GTB Payout. Continue to Generate?",
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
                $elm=$(this);
                $elm.hide();
                $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
                $("#password").val('');
                $("#plan").val('GenerateRankayout');
                $('#myModal').modal('show');
                return false;
            }
        }
    });    
});




$("#ManageFranchise").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    }
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    location.href='franchise';
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

$(document).on('click','.DelFranchise',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to delete a Franchise. Continue to Delete?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        id : id,
                        type : 'DelFranchise'
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



$(document).on('click','.FReqMarkAsPaid',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Confirm Balance Request,Continue to Confirm?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        req_id : req_id,
                        type : 'FReqMarkAsPaid'
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
$(document).on('click','.FRejectReq',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to Reject Balance Request,Continue to Reject?",
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
                    url : '../includes/adminfunction',
                    data :  {
                        req_id : req_id,
                        type : 'FRejectReq'
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
                    url : '../includes/adminfunction',
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

$("#UpdateShippingCharge").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    window.location.reload();
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
$("#UpgradeVPower").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '../includes/adminfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.message,"bottom-right","success",false);
                setTimeout(function(){
                    window.location.reload();
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


$(document).on('click','.HideProduct',function () {
    $elm=$(this);
    bootbox.confirm({
        message: "Warning: You are about to hinding a Product. Continue to Hide?",
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
                var product_id = $elm.attr("data-id");
                var value = $elm.attr("data-value");
                $.ajax({
                    type : 'POST',
                    url : '../includes/adminfunction',
                    data :  {
                        product_id : product_id,
                        value : value,
                        type : 'hideOtherProduct'
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
Add/Edit Manageslider
 */
$("#Manageslider").submit(function(e)
{
  e.preventDefault(); 
  $elm=$(".btn-submit");
  $elm.hide();
  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
  /*for (var i in CKEDITOR.instances) {
    CKEDITOR.instances[i].updateElement();
  } */
  $form=$(this);
  var formData = new FormData(this);
  $.ajax({
    type: 'POST',
    url: '../includes/adminfunction',
    data:formData,
    cache:false,
    contentType: false,
    processData: false, 
    success: function(resp) {
      resp=JSON.parse(resp);
      if(resp.success)
      {
        _toastr(resp.message,"bottom-right","success",false);                    
        setTimeout(function(){
          location.href='slider';
        },2000);
      }
      else{
         _toastr(resp.message,"bottom-right","info",false);
      }
      $(".submit-loading").remove();
      $elm.show();
    },
    error: function(data) {
    }
  }); 
});



 /*
Delete Slider
 */
$(document).on('click','.deleteslider',function () {

  var id = $(this).attr("data-id");
  
    bootbox.confirm({
      message: "Warning: You are sure,You Want To Continue to Upgarde Pin ?",
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
       $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {
          id : id,
          type : 'deleteslider'
        },
        success : function(data)
        {
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
      })
     }
  }
  });   
});




/*
Add/Edit Manageteam
 */
$("#Manageteam").submit(function(e)
{
  e.preventDefault(); 
  $elm=$(".btn-submit");
  $elm.hide();
  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
  /*for (var i in CKEDITOR.instances) {
    CKEDITOR.instances[i].updateElement();
  } */
  $form=$(this);
  var formData = new FormData(this);
  $.ajax({
    type: 'POST',
    url: '../includes/adminfunction',
    data:formData,
    cache:false,
    contentType: false,
    processData: false, 
    success: function(resp) {
      resp=JSON.parse(resp);
      if(resp.success)
      {
        _toastr(resp.message,"bottom-right","success",false);                    
        setTimeout(function(){
          location.href='team';
        },2000);
      }
      else{
         _toastr(resp.message,"bottom-right","info",false);
      }
      $(".submit-loading").remove();
      $elm.show();
    },
    error: function(data) {
    }
  }); 
});





 /*
Delete Team
 */
$(document).on('click','.deleteteam',function () {

  var id = $(this).attr("data-id");
  
    bootbox.confirm({
      message: "Warning: You are sure,You Want To Continue to Upgarde Pin ?",
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
       $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {
          id : id,
          type : 'deleteteam'
        },
        success : function(data)
        {
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
      })
     }
  }
  });   
});


/*
 Managegallery
 */
$("#Managegallery").submit(function(e)
{
  e.preventDefault(); 
  $elm=$(".btn-submit");
  $elm.hide();
  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
  /*for (var i in CKEDITOR.instances) {
    CKEDITOR.instances[i].updateElement();
  } */
  $form=$(this);
  var formData = new FormData(this);
  $.ajax({
    type: 'POST',
    url: '../includes/adminfunction',
    data:formData,
    cache:false,
    contentType: false,
    processData: false, 
    success: function(resp) {
      resp=JSON.parse(resp);
      if(resp.success)
      {
        _toastr(resp.message,"bottom-right","success",false);                    
        setTimeout(function(){
          location.href='gallery';
        },2000);
      }
      else{
         _toastr(resp.message,"bottom-right","info",false);
      }
      $(".submit-loading").remove();
      $elm.show();
    },
    error: function(data) {
    }
  }); 
});



 /*
Delete gallery
 */
$(document).on('click','.deletegallery',function () {

  var id = $(this).attr("data-id");
  
    bootbox.confirm({
      message: "Warning: You are sure,You Want To Continue to Upgarde Pin ?",
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
       $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {
          id : id,
          type : 'deletegallery'
        },
        success : function(data)
        {
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
      })
     }
  }
  });   
});

function block_user(id){
  var uid=id;
    bootbox.confirm({
      message: "Warning: You are sure,You want to block this user ?",
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
       $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {
          uid : uid,
          type : 'block_user'
        },
        success : function(data)
        {
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
      })
     }
  }
  });   
}


function unblock_user(id){
  var uid=id;
    bootbox.confirm({
      message: "Warning: You are sure,You want to Un block this user ?",
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
       $.ajax({
        type : 'POST',
        url : '../includes/adminfunction',
        data :  {
          uid : uid,
          type : 'unblock_user'
        },
        success : function(data)
        {
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
      })
     }
  }
  });   
}


















