var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
// Find all YouTube videos
var $allVideos = $("iframe[src^='//www.youtube.com']"),
// The element that is fluid width
$fluidEl = $("body");
$allVideos.each(function() {
  $(this)
    .data('aspectRatio', this.height / this.width)
    .removeAttr('height')
    .removeAttr('width');
});
var homedelivery=$("#HomeDelivery").val();
$( document ).ready(function()
{
    //$(".select2").select2();
    $("select").select2();
     
    /*$(document).on('focus', '.select2.select2-container', function (e) {
      if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
        $(this).siblings('select').select2('open');
      } 
    });*/
    $('#showforget').click(function()
    {
        $("#forget_pwd").show();
        $("#login").hide();
    });
    $('#showlogin').click(function()
    {
        $("#login").show();
        $("#forget_pwd").hide();
    });

    $('#HomeDelivery').click(function()
    {
        if($('#HomeDelivery').is(":checked"))
        {
            $(".ShippingCharge").show();
        }
        else
        {
            $(".ShippingCharge").hide();
        }
    });
});
// When the window is resized
$(window).resize(function() {
  var newWidth = $fluidEl.width();
  // Resize all videos according to their own aspect ratio
  $allVideos.each(function() {
    var $el = $(this);
    $el
      .width(newWidth)
      .height(newWidth * $el.data('aspectRatio'));
  });
// Kick off one resize to fix all videos on page load
}).resize();
var Country={
    getState:function(val){
        $elm=$('#state');
        $elm.html('<option value=""> -- Select Country First -- </option>');
        if(!val)return false;
        $(".state-loading").show();
        $.post("includes/webfunction",
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
$promoterdiv = '';
if($('img').hasClass('proimg'))
{
    $('.proimg').maphilight({
        stroke:false
    });
}
$(document).on('click','.togglemyhiddenprodetail',function ()
{
    $elm = $(this);
    var clickprodiv = $elm.attr("data-id");
    //Setting Highlight
    $('.togglemyhiddenprodetail').data('maphilight', {alwaysOn: false}).trigger('alwaysOn.maphilight');
    $('.commonpromoter').hide();
    if($promoterdiv == clickprodiv)
    {
        $('.switch2half').addClass('col-md-offset-3');
        $('.promodiv').removeClass('feature1');
        $promoterdiv = '';
    }
    else
    {
        if($('.switch2half').hasClass('col-md-offset-3'))
        $('.switch2half').removeClass('col-md-offset-3');
        if($('.promodiv').hasClass('feature1')) {}
        else
        $('.promodiv').addClass('feature1');
        $elm.data('maphilight', {alwaysOn: true}).trigger('alwaysOn.maphilight');
        $promoterdiv = clickprodiv;
        $('.'+clickprodiv).css('display','block');
    }
    $('.'+clickprodiv).toggleClass('myhiddenprodetail');
});
$( document ).ready(function()
{
    var isMobile = window.matchMedia("only screen and (max-width: 768px)");
    if (isMobile.matches)
    {
        if($('.logmenu').hasClass('greenback'))
        {
        }
        else
        {
            $('.signmenu').removeClass('btn btn-success greenback');
            $('.logmenu').addClass('btn btn-success greenback');
        }
    }
    else
    {
        if($('.signmenu').hasClass('greenback'))
        {
        }
        else {
            $('.signmenu').addClass('btn btn-success greenback');
            $('.logmenu').removeClass('btn btn-success greenback');
        }
    }
    /*$('.select2').multiselect({
        buttonWidth: '400px',
        enableFiltering: true
    });
    $('div.btn-group').addClass('importantRule');*/
    /*
     * Show hide login & forgot form
     */
    $('#showforget').click(function()
    {
        $("#forget_pwd").show();
        $("#login").hide();
    });
    $('#showlogin').click(function()
    {
        $("#login").show();
        $("#forget_pwd").hide();
    });
    $('.business_type').change(function()
    {
        if(this.value == 'Business') {
            $('#business_name').attr("required", true);
            $('.cssn').html('Employer Identification Number *');
        }
        else {
            $('#business_name').attr("required", false);
            $('.cssn').html('Social Security Number *');
        }
    });
});
$("#formvalidate").click(function(e)
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
});
function updateDate()
{
    var date = new Date();
    var n = date.toDateString();
    var time = date.toLocaleTimeString();
    var s = n + ' ' + time;
    $("#live-datetime").html(s);
}
/*
 Dealer Register, Login, Forgot
 */
$('#RegisterAffiliate').submit(function (e) {
    e.preventDefault();
    var country = $('input[name=country]').val();
    var zip = $('input[name=zip]').val();
    var ssn = $('input[name=ssn]').val();
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
    else if (!validSSN(ssn))
    {
        $msg = "Social Security Number is not Valid";
        isvalid = false;
    }
    if(isvalid)
    {
        $elm=$(".btn-submit1");
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        if($('.checked-agree').is(":checked"))
        {
            $form=$(this);
            $.ajax({
                type: 'POST',
                url: 'includes/webfunction',
                data:$(this).serialize(),
                success: function(resp) {
                    resp=JSON.parse(resp);
                    if(resp.success){
                        $.notify({
                            message: resp.message
                        },{
                            allow_dismiss: true,
                            type: 'success',
                            placement: {
                                from: "bottom",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1000000
                        });
                        $('#RegisterAffiliate')[0].reset();
                        setTimeout(function(){
                            location.href = resp.url;
                        }, 3000);
                    }else{
                        $.notify({
                            message: resp.message
                        },{
                            allow_dismiss: true,
                            type: 'info',
                            placement: {
                                from: "bottom",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1000000
                        });
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
            $.notify({
                message: 'Please Accept User Aggrement'
            },{
                allow_dismiss: true,
                type: 'info',
                placement: {
                    from: "bottom",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1000000
            });
            $(".submit-loading").remove();
            $elm.show();
        }
    }
    else
    {
        $.notify({
            message: $msg
        },{
            allow_dismiss: true,
            type: 'info',
            placement: {
                from: "bottom",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1000000
        });
        $(".submit-loading").remove();
    }
});
//Login 
$('#AffiliateLogin_old').submit(function (e) {
    e.preventDefault();
    $elm=$(".btn-submit2");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:$(this).serialize(),
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
                setTimeout(function(){
                    location.href = resp.url;
                }, 3000);
                
            }else{
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});
$('#ForgotUserPass').submit(function (e) {
    e.preventDefault();
    $elm=$(".btn-submit3");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:$(this).serialize(),
        success: function(resp)
        {
            $(".submit-loading").remove();
            $elm.show();
            resp=JSON.parse(resp);

            if(resp.success){
                swal(resp.message);
               
                $("#login").show();
                $("#forget_pwd").hide();
            }else{
                swal(resp.message);
            }
            return false;
        },
        error: function(data) {
        }
    });
});
/*
 * Set Password on reset for merchant and affiliate
 */
$('#SetNewPassword').submit(function (e) {
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:$(this).serialize(),
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
                setTimeout(function(){
                    location.href = resp.url;
                }, 3000);
            }else{
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});
/*
User Profile Update
 */
/*$("#ProfileUpdate").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                $.notify({
                    message: resp.msg
                },{
                    allow_dismiss: true,
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
                setTimeout(function(){
                    location.reload();
                }, 4000);
            }else{
                $.notify({
                    message: resp.msg
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});*/
$("#ProfileUpdate").submit(function(e)
{
  e.preventDefault();
  $elm=$(".btn-submit");
  $elm.hide();
  $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
  var formData = new FormData(this);
  $.ajax({
      type: 'POST',
      url: "includes/webfunction",
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
            swal(data.msg);

            setTimeout(function(){
                location.reload();          
            }, 2000);
        }
        else
        {
          swal(data.msg);
          return false;
        }

      }
  });
});


/*
 Change Consumer Password
 */
$("#userChangePass").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit2");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                swal(resp.message);
                
                setTimeout(function(){
                    location.reload();
                }, 4000);
            }else{
                swal(resp.message);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});
$("#ContactForm").submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp)
        {
            resp=JSON.parse(resp);
            if(resp.success){
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
                $("#ContactForm")[0].reset();
            }else{
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});
/*
 Unsubscribe List
 */
$('#UnSubscribe').submit(function(e)
{
    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'includes/userfunction',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                _toastr(resp.msg,"bottom-right","success",false);
            }else{
                _toastr(resp.msg,"bottom-right","info",false);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
    return false
});
/*--------------------------------------------------- Extra ----------------------------------------------------*/
$('#Subscribe').submit(function (e) {
    e.preventDefault();
    /*$elm=$(".btn-submit");
     $elm.hide();
     $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
     $form=$(this);*/
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:$(this).serialize(),
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }else{
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            /*$(".submit-loading").remove();
             $elm.show();*/
        },
        error: function(data) {
        }
    });
});
/*------- Register-------*/
$('#registerform').submit(function(e)
{    
    e.preventDefault();
    if($('.checked-agree').is(":checked"))
    {
        var parent_id = $("#parent_id").val();
        var sponsor_id = $("#sponsor_id").val();
        /*var pin_no = $("#pin_no").val();*/
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var rpassword = $("#rpassword").val();
        var mobile_no = $("#mobile_no").val();
        var gender = $("#gender").val();
        var pancard = $("#pan_no").val();
        var position = $("#position").val();
        if (fname == "" || lname == "" || password == "" || gender == "" ||  sponsor_id == "" || mobile_no == "" || pancard == "" ) {
            swal('All Fields are mandatory');
            
            return false;
        }
        else if (password != rpassword) {
            swal('Password & Confirm password do not match');
            return false;
        }
        else {
            $elm=$(".btn-submit");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
            $.ajax({
                type: "POST",
                url: "includes/webfunction",
                data: {
                    parent_id: parent_id,
                    sponsor_id: sponsor_id,
                    fname: fname,
                    lname: lname,
                    username: username,
                    email: email,
                    password: password,
                    gender: gender,
                    pan_no: pancard,
                    position: position,
                    mobile_no: mobile_no,
                    ajax_register: true
                },
                success: function (data) {
                    var data = jQuery.parseJSON(data);
                    if (data.valid) {
                        swal(data.message);
                        
                        setTimeout(function () {
                            window.location.href = "index";
                        }, 3000);
                    }
                    else {
                        swal(data.message);
                    }
                    $(".submit-loading").remove();
                    $elm.show();
                    return false;
                }
            });
        }
    }
    else
    {
        swal('Please Accept User Aggrement');
        return false;
    }
});
$('#checkoutregisterform').submit(function(e)
{    
    e.preventDefault();
    if($('.checked-agree').is(":checked"))
    {
        var parent_id = $("#parent_id").val();
        var sponsor_id = $("#sponsor_id").val();
        /*var pin_no = $("#pin_no").val();*/
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var rpassword = $("#rpassword").val();
        var mobile_no = $("#mobile_no").val();
        var gender = $("#gender").val();
        var pancard = $("#pan_no").val();
        var position = $("#position").val();
        if (fname == "" || lname == "" || password == "" || gender == "" ||   mobile_no == "" ) {
            swal('All Fields are mandatory');
            
            return false;
        }
        else if (password != rpassword) {
            swal('Password & Confirm password do not match');
            return false;
        }
        else {
            $elm=$(".btn-submit");
            $elm.hide();
            $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
            $.ajax({
                type: "POST",
                url: "includes/webfunction",
                data: {
                    parent_id: parent_id,
                    sponsor_id: sponsor_id,
                    fname: fname,
                    lname: lname,
                    username: username,
                    email: email,
                    password: password,
                    gender: gender,
                    pan_no: pancard,
                    position: position,
                    mobile_no: mobile_no,
                    type: 'checkoutregisterform',
                    ajax_register: true
                },
                success: function (data) {
                    var data = jQuery.parseJSON(data);
                    if (data.valid) {
                        swal(data.message);
                        
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                    else {
                        swal(data.message);
                    }
                    $(".submit-loading").remove();
                    $elm.show();
                    return false;
                }
            });
        }
    }
    else
    {
        swal('Please Accept User Aggrement');
        return false;
    }
});
//Login 
$('#AffiliateLogin').submit(function (e) {
    e.preventDefault();
    $elm=$(".btn-submit2");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:$(this).serialize(),
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                if(resp.status==1)
                {
                    swal(resp.message);
                    
                    setTimeout(function(){
                        location.href = resp.url;
                    }, 3000);
                }
                else
                {
                    swal(resp.message);
                    //$('#ActivateModal').modal('show');
                    /*$('#ActivateModal').css('display','block');
                    $('#ActivateModal').css('opacity','1');*/
                }
            }else{
                swal(resp.message);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
});

$('#FranchiseLogin').submit(function (e) {
    e.preventDefault();
    $elm=$(".btn-submit2");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    $form=$(this);
    $.ajax({
        type: 'POST',
        url: 'includes/webfunction',
        data:$(this).serialize(),
        success: function(resp) {
            resp=JSON.parse(resp);
            if(resp.success){
                swal(resp.message);
                    
                setTimeout(function(){
                    location.href = resp.url;
                }, 3000);
            }else{
                swal(resp.message);
            }
            $(".submit-loading").remove();
            $elm.show();
        },
        error: function(data) {
        }
    });
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
            url : "includes/webfunction",
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
                    $.notify({
                        message: data.message
                    },{
                        allow_dismiss: true,
                        type: 'info',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1000000
                    });
                    $('#pin_no').focus();
                    return false;
                }
                return false;
            }
        });
    }
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
            url : "includes/webfunction",
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
$("#contact-form").submit(function(e)
{
    // alert();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url : "includes/webfunction",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp)
        {
            resp=JSON.parse(resp);
            if(resp.success){
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
                $("#contact-form")[0].reset();
            }else{
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            $(".submit-loading").remove();
        },
        error: function(data) {
        }
    });
});

$("body").on('click', '.ActivateUser', function()
{
    $elm = $('.submit-loading1');
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    var pin_no=$("#pin_no").val();
    if(pin_no=='')
    {
        $.notify({
                    message: "Enter Pin No To Activate Account"
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
                $(".submit-loading").remove();
                $elm.show();
    }
    else
    {
        $.ajax({
        type : 'POST',
        url : "includes/webfunction",
        data :  {
            pin_no :pin_no,
            type : "ActivateUserStatus"
        },
        success : function(data)
        {
            $(".submit-loading").remove();
            $elm.show();
            var resp = jQuery.parseJSON(data);
             if(resp.success){
                 $.notify({
                        message: resp.message
                    },{
                        allow_dismiss: true,
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1000000
                    });
                    setTimeout(function(){
                        location.href = resp.url;
                    }, 3000);
            }else{
                $.notify({
                    message: resp.message
                },{
                    allow_dismiss: true,
                    type: 'info',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1000000
                });
            }
            $(".submit-loading").remove();
            $elm.show();
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
            url : "includes/webfunction",
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
                    $("#notification").css("display","block");
                        $("#notification").html(data.message);
                    $('#sponsor_id').focus();
                    return false;
                }
                return false;
            }
        });
    }
});

$("body").on('change', '.getUserdetail', function()
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
            url : "includes/webfunction",
            data :  {
                uid : sponsor_id,
                type : "getUserdetail"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    $(".OrderDetail").html(data.data);
                    $("#Sponsordetail").html(data.name);
                    $("#puid").val(data.uid);
                    $("#ctotal").val(data.total);
                    $("#userbv").val(data.bv);
                    return false;
                }
                else
                {
                    /*$("#notification").css("display","block");
                        $("#notification").html(data.message);*/
                    $('#sponsor_id').focus();
                    swal(data.message);
                    return false;
                }
                return false;
            }
        });
    }
});
$("body").on('change', '.getDUserdetail', function()
{
    $elm=$(this);
    var sponsor_id = $(this).val();
    var slen = sponsor_id.length;
    if (slen>0)
    {
        $elm = $('.submit-loading1');
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : "includes/webfunction",
            data :  {
                uid : sponsor_id,
                type : "getDUserdetail"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    $(".OrderDetail").html(data.data);
                    $("#DSponsordetail").html(data.name);
                    $("#dpuid").val(data.uid);
                    $("#ctotal").val(data.total);
                    $("#userbv").val(data.bv);
                    return false;
                }
                else
                {
                    /*$("#notification").css("display","block");
                        $("#notification").html(data.message);*/
                    $("#dsponsor_id").val('');
                    $('#dsponsor_id').focus();
                    swal(data.message);
                    return false;
                }
                return false;
            }
        });
    }
});

$("body").on('blur', '.getFranchisedetail', function()
{
    var fid = $(this).val();
    var slen = fid.length;
    if (slen>0)
    {
        $elm = $('.submit-loading1');
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : "includes/webfunction",
            data :  {
                fid : fid,
                type : "getFranchisedetail"
            },
            success : function(data)
            {
                $(".submit-loading").remove();
                $elm.show();
                var data = jQuery.parseJSON(data);
                if(data.valid)
                {
                    $("#Franchisedetail").html(data.name);
                    $("#fid").val(data.uid);
                    $(".HomeDelivery").hide();
                    $(".HomeDelivery").val(0);
                    //$("#ctotal").val(data.total);
                    return false;
                }
                else
                {
                    /*$("#notification").css("display","block");
                        $("#notification").html(data.message);*/
                    $('#fid').focus();
                    $(".HomeDelivery").show();
                    $("#HomeDelivery").val(homedelivery);
                    swal(data.message);
                    return false;
                }
                return false;
            }
        });
    }
});
$("body").on('change', '.frSelect', function()
{
    var fid = $(this).val();
    if(fid!='')
    {
        $(".HomeDelivery").hide();
        $(".HomeDelivery").val(0);
    }
    else
    {
        $(".HomeDelivery").show();
        $("#HomeDelivery").val(homedelivery);
    }
});
/************************  jinal code ************************/
$("#ManageReview").submit(function(e)
{
    // alert();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url : "includes/webfunction",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(resp)
        {
            resp=JSON.parse(resp);
            if(resp.success){
                swal(resp.message);
                $("#ManageReview")[0].reset();
                $(".all-review").html(resp.html);
            }else{
                swal(resp.message);
            }
            $(".submit-loading").remove();
        },
        error: function(data) {
        }
    });
});

function Add_cart(id,price,qty)
{
    
    $.ajax({
        type : 'POST',
        url : 'includes/webfunction',
        data :  {
            product_id:id,
            qty:qty,
            price:price, 
            type : 'AddToCart'
        },
        success : function(data)
        {
            
            var data = jQuery.parseJSON(data);
            if(data.success)
            {
                $(".cartcount").html("");
                $(".cartcount").html(data.cartcount);
                swal(data.message);
                return false;
            }
            else
            {
              $(".cartcount").html("");
               $(".cartcount").html(data.cartcount);
               swal(data.message);
                
                return false;
            }
            return false;
        }
    });
    return false;
}
function Add_cart1(id,price,qty)
{

  var quantity=$("#"+qty).val();

    $.ajax({
        type : 'POST',
        url : 'includes/webfunction',
        data :  {
            product_id:id,
            qty:quantity,
            price:price,
            type : 'AddToCart'
        },
        success : function(data)
        {
            var data = jQuery.parseJSON(data);
            if(data.success)
            {
                $(".cartcount").html("");
                $(".cartcount").html(data.cartcount);
                swal(data.message);
                return false;
            }
            else
            {
              $(".cartcount").html("");
               $(".cartcount").html(data.cartcount);
               swal(data.message);
                
                return false;
            }
            return false;
        }
    });
    return false;
}
function Add_cart2(id,price,qty)
{
    $.ajax({
        type : 'POST',
        url : 'includes/webfunction',
        data :  {
            product_id:id,
            qty:qty,
            price:price,
            type : 'AddToCart2'
        },
        success : function(data)
        {
            var data = jQuery.parseJSON(data);
            if(data.success)
            {
                $(".cartcount").html("");
                $(".cartcount").html(data.cartcount);
                $(".subtotal"+id).html(data.total);
                $("#carttotal").html(data.carttotal);
                if(data.carttotal > 0)
                {
                    $(".GotoCheckout").show();
                }
                else
                {
                    $(".GotoCheckout").hide();
                }
               
                _toastr(data.message,"bottom-right","info",false);
                return false;
            }
            else
            {
              $(".cartcount").html("");
               $(".cartcount").html(data.cartcount);
               $(".subtotal"+id).html(data.total);
               $("#carttotal").html(data.carttotal);
               if(data.carttotal > 0)
                {
                    $(".GotoCheckout").show();
                }
                else
                {
                    $(".GotoCheckout").hide();
                }
               swal(data.message);
                
                return false;
            }
            return false;
        }
    });
    return false;
}
function RedirectTourl(url){
     window.location=url;
}
$(document).on('click','.DeleteCart',function () {
    $ele  = $(this);
    var cart_id = $(this).attr("data-id");
    $.ajax({
        type : 'POST',
        url : 'includes/webfunction',
        data :  {
            cart_id : cart_id,
            type : 'RemoveFromCart'
        },
        success : function(data)
        {
            var data = jQuery.parseJSON(data);
            if(data.success)
            {
                $(".cartcount").html("");
                $(".cartcount").html(data.cartcount);
                $("#carttotal").html(data.carttotal);
                if(data.carttotal > 0)
                {
                    $(".GotoCheckout").show();
                }
                else
                {
                    $(".GotoCheckout").hide();
                }
                $ele.parents('.item').remove();
                swal(data.message);
                
                
                return false;
            }
            else
            {
                /*$(".cartcount").html("");
                $(".cartcount").html(data.cartcount);*/
                swal(data.message);
                return false;
            }
            return false;
        }
    });
    return false;
});
$(document).on('input blur','.UpdateCart',function () {
    var product_id = $(this).attr("data-id");
    var price = $(this).attr("data-price");
    var qty1 = $(this).attr("data-qty");
    var qty = $("#"+qty1).val();
    if(qty>0)
    {
        Add_cart2(product_id,price,qty);
    }
    else
    {
        $("#"+qty1).val(1);
        swal("you can not set 0 qty");
    }
});

/*$('#OrderNow').submit(function (e) {

    e.preventDefault();
    $elm=$(".btn-submit");
    $elm.hide();
    $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
    if($('.checked-agree').is(":checked"))
    {
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'includes/webfunction',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(resp) {
                resp=JSON.parse(resp);
                if(resp.success){
                    swal(resp.message);
                    
                    //$('#OrderNow')[0].reset();
                    setTimeout(function(){
                        location.href = resp.url;
                    }, 3000);
                }else{
                    swal(resp.message);
                    $(".submit-loading").remove();
                    $elm.show();
                }

            },
            error: function(data) {
            }
        });
    }
    else
    {
        $.notify({
            message: 'Please Accept User Aggrement'
        },{
            allow_dismiss: true,
            type: 'info',
            placement: {
                from: "bottom",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1000000
        });
        $(".submit-loading").remove();
        $elm.show();
    }

});*/

$(document).on('click','.CategoryFilter',function () {
  var id = $(this).attr("data-id");
  $.ajax({
        type : 'POST',
        url : 'includes/webfunction',
        data :  {
          cat_id : id,
          type : 'CategoryFilter'
        },
        success : function(data)
        {
          var data = jQuery.parseJSON(data);
          if(data.success)
          {
            $(".shop-product-wrap").html(data.data);
            $(".prdpage").html(data.pagination);
            return false;
          }
          else
          {
            swal(data.message);
            return false;
          }
          return false;
        }
      });
   
});


$(document).on('click','#OrderNowBtn',function ()
{

    if($('.checked-agree').is(":checked"))
    {
        //var formData = new FormData(this);
        bootbox.confirm({
            message: "Warning: You are about place an order. Continue?",
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
                    /*$("#postdata").val(formData);*/
                    $('#myModal').modal('show');
                    $("#myModal #password").val('');
                    return false;
                }
            }
        });
    }
    else
    {
        swal('Please Accept User Aggrement');
    }

    
});


$(document).on('click','.SubmitPassword',function (){
    $elm=$(this);
    var uid=$("#user_id").val();
    var password= $("#tpassword").val();
    var postdata= $("#postdata").val();
    var table= $("#table").val();
    //$('#myModal').modal('show');
    
    if (uid!='' && password!='')
    {
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type : 'POST',
            url : 'includes/webfunction',
            data :  {
                password : password,
                uid : uid,
                table : table,
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
                    var formData = $("#OrderNow").serializeArray();
                    //var data1 = JSON.stringify(formData);
                    $.ajax({
                        type : 'POST',
                        url : 'includes/webfunction',
                        data :  {
                            formData : formData,
                            type : 'OrderNow'
                        },
                        success : function(data)
                        {
                            $(".submit-loading").remove();
                            $elm.show();
                            var data = jQuery.parseJSON(data);
                            if(data.success)
                            {
                                swal(data.message);
                                setTimeout(function(){
                                    location.href=data.url;
                                }, 2000);
                                return false;
                            }
                            else
                            {
                                swal(data.message);
                                return false;
                            }

                            return false;
                        }
                    });
                    return false;
                }
                else
                {
                    swal(resp.message);
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



$("#formaddedituser").submit(function(e)
{
   e.preventDefault();
   $elm=$(".btn-submit");
     var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: "includes/webfunction",
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
                  location.href='login';
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

$("#payments").submit(function(e)
{
   e.preventDefault();
    if($('.checked-agree').is(":checked"))
    {
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'includes/webfunction',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(resp) {
                console.log(resp)
                window.location.href="https://toyyibpay.com/"+resp;
            },
            error: function(data) {
            }
        }); 
    }
    else
    {
        swal('Please Accept User Aggrement');
    }

    
});
