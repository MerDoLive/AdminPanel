<footer id="footer">
            <div class="col-md-12">
                <div class="pull-left">
                    Copyright &copy; <?= date('Y'); ?>
                </div>
                
            </div>
        </footer>
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg viewBox="25 25 50 50" class="pl-circular">
                    <circle r="20" cy="50" cx="50" class="plc-path"/>
                </svg>

                <p>Please wait...</p>
            </div>
        </div>
        <!-- Javascript Libraries -->

        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/waves.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap-growl.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/jquery.bootstrap.wizard.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
        <script type="text/javascript">
            function checkStatus(id)
            {
                $("#statusId").val(id);
                $("#deleteId").val(id);
                $("#deleteId1").val(id);
                $(".cmpId").val(id);
                
               /* alert(id);
                $('input[name=checkSmove123]').val(id);
                $('#checkSmove').append("this text was appended");*/
            }
            function checkStatusSMS(id)
            {
                $("#statusId").val(id);
                $("#deleteId").val(id);
            }
        </script>

        <script>
            var table;
            
            //kailash code
            var checked_box = [];
            function checkBox(id){
                val=jQuery.inArray( id, checked_box );
                if(val == -1){
                    checked_box.push(id);
                }else{
                    checked_box.splice($.inArray(id, checked_box),1);
                }
                console.log(checked_box);
            }
            //kailash code end

            $(document).ready(function() {
                //datatables
                 var selected_check = [];

                table = $('#server_table').DataTable({ 
                 "responsive": true,
                   
                      "oLanguage": {
                    "sProcessing": "<img src='<?= base_url()?>assets/img/ajax-loader.gif'>"
                },

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    "lengthMenu" : [[10, 25, 50, 100,200,500,1000], [10, 25, 50, 100,200,500,1000]],
                     "autoWidth": false,
                    
                    "pageLength" : 10,

                    // Load data for the table's content from an Ajax source

                    "ajax": {
                        "url": url,
                        "type": "POST"
                    },
                    //Set column definition initialisation properties.
                    //Set column definition initialisation properties.
                    "columnDefs": [
                    { 
                        "targets": [ actioncolumn ], // numbering column
                        "orderable": true, //set not orderable
                    },
                    

                ],
                  
                });
                
                //kailash code
                $('#delete_brand').click(function(){
                    var url_new = '<?= site_url('Brands/ajax_manage_page')?>'+'/1';
                    $('.det-btn').toggle();
                    table.ajax.url( url_new ).load();

                });
                
                $('#delete_cancel').click(function(){
                    $('.det-btn').toggle();
                    var url_new = '<?= site_url('Brands/ajax_manage_page')?>';
                    table.ajax.url( url_new ).load();
                    var checked_box = [];
                });
                
                $('#paginate_button').click(function(){
                    $('.det-btn').toggle();
                    var url_new = '<?= site_url('Brands/ajax_manage_page')?>';
                    table.ajax.url( url_new ).load();
                    var checked_box = [];
                });

                $('#delete_confirm').click(function(){
                var cun = confirm('Are you really want to delete?');
                if(cun === false){
                    return false;
                }
                    $.post( '<?= site_url('Brands/delete_multi')?>', { data : checked_box })
                    .done(function( data ) {
                        window.location.reload();
                    });
                });
                //kailash code end

                $('.ColVis').css('float','left');
                $('.ColVis').css('padding','1.6px');
                $('#table').addClass("compact");

                $('#table').addClass("ui celled table");
            });

        </script>

    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){$(".alert").fadeOut();},3000);
    });
</script>