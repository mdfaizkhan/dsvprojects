 var base_url = $("#base_url").val();
var is_preset_demo = $("#is_preset_demo").val();
var POP_UP = $("#POP_UP").val();
$("#demo_contact_form_button").text(trans('continue'));
if(is_preset_demo && !$("#lead_type").length) {
    $('#demo_contact_form').modal({backdrop: 'static', keyboard: false});
    $('#demo_contact_form').modal('show');
} else {
    // if($("#lead_coutry").length && $("#lead_country").val().toLowerCase() != 'india') {
    //      $("#otp_send_to").html($("#lead_email").val());
    //      $('#demo_otp').attr("placeholder", trans('enter_otp_send_to'));
    //     $('#myModalLabel').html(trans('enter_otp_send_to'));
    // } else {
    //     $("#otp_send_to").html($("#lead_phone").val());
    //     $('#demo_otp').attr("placeholder", trans('enter_otp_send_to_mobile'));
    //      $('#myModalLabel').html(trans('enter_otp_send_to_mobile'))
        
    // }
     $('#demo_otp').attr("placeholder", trans('enter_otp_send_to'));
    $('#myModalLabel').html(trans('enter_otp_send_to'));
    $('#otp_resend_text').html(trans('if_dont_receive_code'));
    $("#otp_send_to").html($("#lead_email").val());
    $('#demo_otp_form').modal({backdrop: 'static', keyboard: false});
    $("#demo_otp_resend").text(trans('resend'));
    $("#demo_otp_submit").text(trans('Verify_otp'));
    $("#otpModalCenterTitle").html(trans('otp_send_to'));
    $('#demo_otp_form').modal('show');
}

$("#demo_contact_form_button").on("click", function () {
	var dataObj = {
        name : $("#name").val(),
        email : $("#email").val(),
        mobile : $("#mobile").val(),
        country : $("#country").val()
    };
    $("#demo_contact_form_button").attr('disabled', true);
    $.post(base_url + 'login/add_new_demo_visitor', dataObj, function (rawData) {
        var response = JSON.parse(rawData);
        contact_window_mini_alert(response.message, response.status);
        if(response.status) {
            $('#demo_contact_form').modal('hide');
            // if($("#lead_coutry").length && $("#lead_country").val().toLowerCase() != 'india') {
            //      $("#otp_send_to").html($("#lead_email").val());
            //      $('#demo_otp').attr("placeholder", trans('enter_otp_send_to'));
            //      $('#myModalLabel').html(trans('enter_otp_send_to'));
            // } else {
            //     $("#otp_send_to").html($("#lead_phone").val());
            //     $('#demo_otp').attr("placeholder", trans('enter_otp_send_to_mobile'));
            //      $('#myModalLabel').html(trans('enter_otp_send_to_mobile'))

                
            // }
             $("#otp_send_to").html($("#lead_email").val());
            $('#demo_otp').attr("placeholder", trans('enter_otp_send_to'));
            $('#myModalLabel').html(trans('enter_otp_send_to'));
            $('#otp_resend_text').html(trans('if_dont_receive_code'));
            $('#demo_otp').attr("placeholder", trans('enter_otp_send_to'));
            $("#demo_otp_resend").text(trans('resend'));
            $("#demo_otp_submit").text(trans('Verify_otp'));
            $("#otpModalCenterTitle").html(trans('otp_send_to'));
            
            $('#otp_send_to').html($("#email").val());
            $('#otp_send_to').html($("#mobile").val());
            $('#demo_otp_form').modal({backdrop: 'static', keyboard: false});
            $('#demo_otp_form').modal('show');
            
        }
        $("#demo_contact_form_button").attr('disabled', false);
    });
});

$("#demo_otp_resend").on("click", function() {
    $(".otp-window-buttons").attr('disabled', true);
    $("#demo_otp").val('');
    $.get(base_url + 'login/resend_demo_verification_otp', function(rawData) {
        var response = JSON.parse(rawData);
        otp_window_mini_alert(response.message, response.status);
        $(".otp-window-buttons").attr('disabled', false);
    });
})

$("#demo_otp_submit").on("click", function() {
    $(".otp-window-buttons").attr('disabled', true);
    if($.trim($("#demo_otp").val()).length > 3)
    {
        $.post(base_url + 'login/verify_demo_otp', { demo_otp : $("#demo_otp").val() }, function(rawData) {
            var response = JSON.parse(rawData);
            otp_window_mini_alert(response.message, response.status);
            if(response.status) {
                $('#demo_otp_form').modal('hide');
            }
            $(".otp-window-buttons").attr('disabled', false);
        });
    }
});



$(".otp-window-alert").on("click", function() {
	$(this).hide();
});
$(".contact-window-alert").on("click", function() {
    $(this).hide();
});

function otp_window_mini_alert(message, status) {
    var type = (status) ? "success" : "danger" ;
    $(".otp-window-alert").hide();
    $(".otp-window-alert").removeClass("alert-danger");
    $(".otp-window-alert").removeClass("alert-success");
    $(".otp-window-alert").html("" + message);
    $(".otp-window-alert").addClass("alert-" + type);
    $(".otp-window-alert").show();
}

function contact_window_mini_alert(message, status) {
	var type = (status) ? "success" : "danger" ;
	$(".contact-window-alert").hide();
	$(".contact-window-alert").removeClass("alert-danger");
	$(".contact-window-alert").removeClass("alert-success");
	$(".contact-window-alert").html("" + message);
	$(".contact-window-alert").addClass("alert-" + type);
	$(".contact-window-alert").show();
}