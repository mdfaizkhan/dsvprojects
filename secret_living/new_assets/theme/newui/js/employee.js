var employee_list_table = user_activity_table = null;

var selected_tab = $('input[name="tabs"]:checked').attr('id');
var loaded_tabs = [selected_tab];

var data_table_language = JSON.parse($('#data_table_language').val());

$('.user-search-select2').select2({
    minimumInputLength: 1,
    multiple: true,
    placeholder : `${capitalizeFirstLetter(trans("user_name"))}`,
    allowClear: true,
    closeOnSelect : false,
    width: 'auto',
    ajax: {
        url: $('#base_url').val()+"admin/employee/ajax_employee_list",
        dataType: 'json',
        delay: 250,
        processResults: function (response) {
           return {
              results: response
           };
        }
    }
});

$(function () {
    employee_list_table = $('#employee_list_table').DataTable({
        language: data_table_language,
        order: [[3, "desc"]],
        dom: '<f<t><"#df"< i><p><l>>>',
        lengthChange: true,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        searching: false,
        processing: true,
        serverSide: true,
        autoWidth: false,
        deferLoading: 0,
        ajax: {
            url: $('#base_url').val() + "admin/employee/employee_list",
            type: 'GET',
            data: function (d) {
                return $.extend({}, d, {
                    'user_name': $('#employee_list_form .user-search-select2').val(),
                });
            }
        },
        columns: [
            {
                orderable: false,
                render: function(data, type, row, meta) {
                    return $('#template_employee_checkbox').html()
                        .replace('[employee_id]', row['employee_id'])
                        .replace('[user_name]', row['user_name']);
                }
            },
            {data: 'name'},
            {data: 'mobile'},
            {data: 'email'},
            {
                orderable: false,
                render: function(data, type, row, meta) {
                    return $('#template_edit_permission_btn').html()
                        .replace(/_employee_id/gi, row['employee_id'])
                        .replace('_em_user_name', row['user_name']);
                }
            },
        ]
    }).draw();

    user_activity_table = $('#user_activity_table').DataTable({
        language: data_table_language,
        // order: [[3, "desc"]],
        dom: '<f<t><"#df"< i><p><l>>>',
        lengthChange: true,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        searching: false,
        processing: true,
        serverSide: true,
        autoWidth: false,
        deferLoading: 0,
        ajax: {
            url: $('#base_url').val() + "admin/employee/user_activity",
            type: 'GET',
            data: function (d) {
                return $.extend({}, d, {
                    'user_name': $('#user_activity_form .user-search-select2').val(),
                });
            }
        },
        columns: [
            {data: 'name'},
            {data: 'activity'},
            {data: 'date'},
        ]
    });
    
});

$('input[name="tabs"]').on('click', function () {
    selected_tab = this.id;
    if (!loaded_tabs.includes(selected_tab)) {
        loaded_tabs.push(selected_tab);
        loadTabData(selected_tab);
    }
});

$('#employee_list_form #search_member_get').on('click', function () {
    employee_list_table.draw();
});

$('#user_activity_form #search_btn').on('click', function () {
    user_activity_table.draw();
});

$('#employee_list_form .search_clear').on('click', function () {
    $('#employee_list_form select').val('').trigger('change');
    employee_list_table.draw();
});

$('#user_activity_form .search_clear').on('click', function () {
    $('#user_activity_form select').val('').trigger('change');
    user_activity_table.draw();
});

$('.close-popup').click(function(e) {
    e.preventDefault();
    $(this).closest('.popup-btn-area').addClass('hidden');
    $('.employee-checkbox').prop('checked', false);
    $('.employee-list-all').prop('checked', false);
});

$('.employee-list-all').click(function () {
    $(this).is(':checked') ? $('#employee_list_table .employee-list-single').prop('checked', true) : $('#employee_list_table .employee-list-single').prop('checked', false);
    showEmployeeActionPopup();
});

$('body').on('click', '.employee-list-single', function() {
    $(this).is(':checked') ? $(this).prop('checked', true) : $('#employee_list_table .employee-list-all').prop('checked', false);
   showEmployeeActionPopup();
});

$('#employee_delete_btn').on('click', function() {
    let selected_employees = [];
    $('.employee-list-single:checked').each(function(){   
        selected_employees.push($(this).val());
    });
    $.ajax({
       'method': 'POST',
       'url': $('#base_url').val()+"/admin/employee/delete",
       'data': {
           'employees': selected_employees,
       },
       success: function(response) {
           response = JSON.parse(response);
            if(response.status == "failed") {
                if(response.error_type == "validation") {
                    showErrorAlert(response.message);
                } else if(response.error_type == "unknown") {
                    showErrorAlert(response.message)
                }
            } else if(response.status == "success") {
                // payout_requests_table.draw()
                showSuccessAlert(response.message)
                employee_list_table.draw();
                $('#employee_delete_popup').addClass('hidden')
            }
       }, 
       beforeSend: function() {
            $('#employee_delete_btn').button('loading');
      },
      complete: function() {
            $('#employee_delete_btn').button('reset');
      }
    }); 
});

$("#create_employee_form").on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: $('#base_url').val() + "admin/employee/store",
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            form.find('.form-group .text-danger').remove();
            $('#create_employee_btn').button('loading');
        },
        complete: function() {
            $('#create_employee_btn').button('reset');
        },
        success: function (response) {
            if (response.status) {
                showSuccessAlert(response.message);
                closePopup('#create_employee_modal');
                loaded_tabs = [selected_tab];
                loadTabData(selected_tab);
            } else {
                if (response.validation_error) {
                    setValidationErrors(form, response);
                }
                showErrorAlert(response.message);
            }
        }
    });
});

$('body').on('click', '.edit-employee', function() {
    const button = $(this);
    $.ajax({
        url: ` ${$('#base_url').val()}admin/employee/${button.data('id')}`,
        type: 'GET',
        data: button.data('id'),
        dataType: 'json',
        success: function (response) {
            if (response.status == "success") {
                $('#edit_first_name').val(response.data.user_detail_name);
                $('#edit_last_name').val(response.data.user_detail_second_name);
                $('#edit_email').val(response.data.user_detail_email);
                $('#edit_mobile_no').val(response.data.user_detail_mobile);
                $('#edit_employee_id').val(button.data('id'));
                $('#edit_employee_modal').modal('show');
            } else {
                showErrorAlert(response.message);
            }
        }
    });
});

$('body').on('click', '.edit-employee-permission', function(e) {
    e.preventDefault();
    const el = $(this);
    
    $.ajax({
        url: ` ${$('#base_url').val()}admin/employee/get_permissions`,
        type: 'GET',
        data: {
            'id': el.data('employee_id')
        },
        success: function (response) {
            $('#permission_view').html(response);
            $('#change_employee_permission_modal').modal('show')
            console.log(response);
        }
    });
});

$('body').on('click', '.edit-dashboard-configuration', function(e) {
    e.preventDefault();
    const el = $(this);
    
    $.ajax({
        url: ` ${$('#base_url').val()}admin/employee/get_dashboard_configuration`,
        type: 'GET',
        data: {
            'id': el.data('employee_id')
        },
        success: function (response) {
            $('#configuration_view').html(response);
            $('#change_dashboard_configuration_modal').modal('show')
            console.log(response);
        }
    });
});

$('body').on('click', '.edit-password', function(e) {
    e.preventDefault();
    const el = $(this);
    $('#change_password_user_name').val($(this).data('employee_user_name'));
    $('#change_password_modal').modal('show');
});

$("body").on('submit', '#set_permission_form', function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: $('#base_url').val() + "admin/employee/set_permissions",
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            form.find('.form-group .text-danger').remove();
            $('#permission_btn').button('loading');
        },
        complete: function() {
            $('#permission_btn').button('reset');
        },
        success: function (response) {
            if (response.status == "success") {
                showSuccessAlert(response.message);
                closePopup('#change_employee_permission_modal');
                
            } else {
                if (response.validation_error) {
                    setValidationErrors(form, response);
                }
                showErrorAlert(response.message);
            }
        }
    });
});

$("#edit_employee_form").on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: $('#base_url').val() + "admin/employee/update",
        type: 'POST',
        data: {
            'first_name' : $('#edit_first_name').val(),
            'last_name'  : $('#edit_last_name').val(),
            'email'      : $('#edit_email').val(),
            'mobile_no'  : $('#edit_mobile_no').val(),
            'employee_id': $('#edit_employee_id').val()
        },
        dataType: 'json',
        beforeSend: function() {
            form.find('.form-group .text-danger').remove();
            $('#update_employee_btn').button('loading');
        },
        complete: function() {
          $('#update_employee_btn').button('reset');  
        },
        success: function (response) {
            if (response.status) {
                showSuccessAlert(response.message);
                closePopup('#edit_employee_modal');
                loaded_tabs = [selected_tab];
                loadTabData(selected_tab);
            } else {
                if (response.validation_error) {
                    for (input_name in response.validation_error) {
                        response.validation_error['edit_'+input_name] = response.validation_error[input_name];
                        delete response.validation_error[input_name];
                    }
                    setValidationErrors(form, response);
                }
                showErrorAlert(response.message);
            }
        }
    });
});
$("body").on('submit', '#set_dashboard_configuration_form', function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: $('#base_url').val() + "admin/employee/set_dashboard_configuration",
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            form.find('.form-group .text-danger').remove();
            $('#configuration_btn').button('loading');
        },
        complete: function() {
          $('#configuration_btn').button('reset');  
        },
        success: function (response) {
            if (response.status == "success") {
                closePopup('#change_dashboard_configuration_modal');
                showSuccessAlert(response.message);
            } else {
                if (response.validation_error) {
                    setValidationErrors(form, response);
                }
                showErrorAlert(response.message);
            }
        }
    });
});

$("#change_password_form").on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: $('#base_url').val() + "admin/employee/update_password",
        type: 'POST',
        data: {
            'user_name'        : $('#change_password_user_name').val(),
            'password'         : $('#change_password_password').val(),
            'confirm_password' : $('#change_password_confirm_password').val(),
        },
        dataType: 'json',
        beforeSend: function() {
            form.find('.form-group .text-danger').remove();
            $('#change_password_submit_btn').button('loading');
            
        },
        complete: function() {
            $('#change_password_submit_btn').button('reset');
        },
        success: function (response) {
            if (response.status) {
                showSuccessAlert(response.message);
                closePopup('#change_password_modal');
                loaded_tabs = [selected_tab];
                loadTabData(selected_tab);
            } else {
                if (response.validation_error) {
                    for (input_name in response.validation_error) {
                        response.validation_error['change_password_'+input_name] = response.validation_error[input_name];
                        delete response.validation_error[input_name];
                    }
                    setValidationErrors(form, response);
                }
                showErrorAlert(response.message);
            }
        }
    });
});

function loadTabData(tab) {
    if (tab == 'employee_list') {
        employee_list_table.draw();
    } else if(tab == "user_activity") {
        user_activity_table.draw();
    }
}

function showEmployeeActionPopup() {
    if ($(".employee-list-single:checked").length) { // any one is checked
        let items_selected = $(".employee-list-single:checked").length;
        $('#employee_delete_popup_span').text(items_selected);
        $('#employee_delete_popup').removeClass('hidden');
    } else { // none is checked
        $('.employee-list-single').prop('checked', false);
        $('.employee-list-all').prop('checked', false);
        $('#employee_delete_popup').addClass('hidden');
        $('.payout-process-all').prop('checked', false);
    }
}