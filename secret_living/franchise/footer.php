
		</div>

        <!-- javascript file -->
        <script type="text/javascript">var plugin_path = '../assets1/plugins/';</script>
        <script type="text/javascript" src="../assets1/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets1/js/app.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <script type="text/javascript" src="../assets1/js/bootstrap-multiselect.js"></script>
        <script type="text/javascript" src="../assets1/plugins/jqueryvalidate/jquery.validate.min.js" ></script>
        <script type="text/javascript" src="../assets1/plugins/ckeditor/ckeditor.js" ></script>
         <script type="text/javascript" src="extraplugin/bootstrap-notify-3.1.3/bootstrap-notify.min.js" ></script>
        <script type="text/javascript" src="../includes/function.js"></script>
        <script type="text/javascript" src="../includes/userscript.js"></script>
        <!-- JS DATATABLE -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('.nav a').each(function(index)
                {
                    if(this.href.trim() == window.location)
                    {
                        $(this).closest('li').addClass('active');
                        $(this).closest('.el_primary').addClass('active');
                    }

                });
                $(document).on('focus', '.select2.select2-container', function (e) {
                  if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
                    $(this).siblings('select').select2('open');
                  } 
                });
            });
            loadScript(plugin_path + "datatables/js/jquery.dataTables.min.js", function()
            {
                loadScript(plugin_path + "datatables/js/dataTables.tableTools.min.js", function()
                {
                    loadScript(plugin_path + "datatables/dataTables.bootstrap.js", function()
                    {
                        loadScript(plugin_path + "select2/js/select2.full.min.js", function(){

                            var table = jQuery('.sample_5');

                            /* Set tabletools buttons and button container */

                            jQuery.extend(true, jQuery.fn.DataTable.TableTools.classes, {
                                "container": "btn-group pull-right tabletools-topbar",
                                "buttons": {
                                    "normal": "btn btn-sm btn-default",
                                    "disabled": "btn btn-sm btn-default disabled"
                                },
                                "collection": {
                                    "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
                                }
                            });

                            var oTable = table.dataTable({
                                "order": [
                                    [0, 'desc']
                                ],
                                "lengthMenu": [
                                    [10, 15, 20, -1],
                                    [10, 15, 20, "All"] // change per page values here
                                ],
                                "pageLength": 10, // set the initial value,
                                "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                                "tableTools": {
                                    "sSwfPath": plugin_path + "datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                                    "aButtons": [/*{
                                        "sExtends": "pdf",
                                        "sButtonText": "PDF"
                                    }, {
                                        "sExtends": "csv",
                                        "sButtonText": "CSV"
                                    }, {
                                        "sExtends": "xls",
                                        "sButtonText": "Excel"
                                    }, {
                                        "sExtends": "print",
                                        "sButtonText": "Print",
                                        "sInfo": 'Please press "CTR+P" to print or "ESC" to quit',
                                        "sMessage": "Generated by DataTables"
                                    }*/]
                                }
                            });

                            var tableWrapper = jQuery('#sample_5_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
                            tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

                        });
                    });
                });
            });

        </script>


	</body>
</html>
