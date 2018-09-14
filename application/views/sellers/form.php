<?php $this->load->view('common/header');  ?>
<?php $this->load->view('common/left_panel');  ?>

<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>site/assets/lib/multi-select/css/multi-select.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>site/intlTelInput.css">
 -->



	<link rel="stylesheet" type="text/css" href="http://merzido.sg/site/assets/lib/multi-select/css/multi-select.css">
<link rel="stylesheet" type="text/css" href="http://merzido.sg/site/intlTelInput.css">


<style>
form#seller_form input[type="text"], textarea, select, form#seller_form ul{
	border:1px solid #555 !important;
}
</style>

    <section id="content">
        <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4" style="padding: 0"><h3><i class="zmdi zmdi-city-alt"></i>&nbsp;<?= $subheading ?></h3></div>
                </div>
                <div class="main-page">
                <div class="col-sm-10 col-md-10 col-lg-10" style="padding:100px 10px; margin:auto;float:none; ">
                 <form class="form-horizontal" id="seller_form" role="form" style="padding:15px;" method="post" action="<?php echo base_url()?>index.php/Sellers/create_action" enctype="multipart/form-data">
                  <h1 style="text-align:center;">YOUR COMPANY INFORMATION</h1>
                  <br>
                  <div class="form-group row">
                     <label class="col-sm-4 control-label">Name *</label>
					 <div class="col-sm-6">
						 <div class="row">
							 <div class="col-sm-6 no-padding-right">
								<input required placeholder="First Name" type="text" name="seller_firstname" class="form-control">
							 </div>
							 <div class="col-sm-6 no-padding-left">
								<input required placeholder="Last Name" type="text" name="seller_lastname" class="form-control">
							 </div>
						 </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Email *</label>
                     <div class="col-sm-6">
                        <input type="text" required placeholder="Email" name="seller_email" class="form-control">
                     </div>
                  </div>
                  <div class="form-group ">
                     <label class="col-sm-4 control-label">Mobile Number *</label>
                     <div class="col-sm-6 ">
                        <input required placeholder="Enter Your Mobile Number" type="hidden"  name="seller_mobile">
                        <input type="text" id="mobile-number" placeholder="e.g. +1 702 123 4567" name="seller_mobile">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Legal Company Name* </label>
                     <div class="col-sm-6">
                        <input required placeholder="Company Name" type="text" name="compnay_name" id="company_name" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Business Registration Number *</label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Business Registration Number" type="text" name="buissness_reg_no" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Bank Account Name* </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Bank Account Name" type="text" name="bank_account_name" id="bank_name" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Bank Name*  </label>
                     <div class="col-sm-6">
                        <!--<input required placeholder="Enter Your Bank Name" type="text" name="bank_name" >-->
                        <select required placeholder="Enter Your Bank Name" type="text" name="bank_name" id="bank_drop" class="form-control">
							<option value="">Choose</option>
							<option value="DBS/POSB">DBS/POSB</option>
							<option value="Citibank">Citibank</option>
							<option value="OCBC">OCBC</option>
							<option value="Maybank">Maybank</option>
							<option value="HSBC">HSBC</option>
							<option value="Standard Chartered">Standard Chartered</option>
							<option value="Other">Other</option>
						</select>
						<br>
                        <input required placeholder="Enter Your Bank Name" type="text" name="bank_other_name" class="bank_other_name hidden">	
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Bank Account Number*  </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Your Bank Account Number" type="text" name="bank_account_no" id="bank_account_no" class="form-control">
                     </div>
                  </div>

                  <!-- <div class="form-group">
                     <label class="col-sm-4 control-label">Bank Code Number*  </label>
                      <div class="col-sm-6">
                        <input type="radio" name="bank_codeno" required value="7171"> DBS/POSB(7171)<br>
                        <input type="radio" name="bank_codeno" required value="7302" > Citibank (7302)<br>
                        <input type="radio" name="bank_codeno" required value="7339" > OCBC (7339)<br>
                        <input type="radio" name="bank_codeno" required value="7144" > Maybank (7144)<br>
						<input type="radio" name="bank_codeno" required value="7144" > HSBC (7144)<br>
						<input type="radio" name="bank_codeno" required value="7144" > Standard Chartered (7144)<br>
                        <input type="radio" name="bank_codeno" required value="other" > 
                        Other<br>
                        <input required placeholder="Enter Your Bank Code" type="text" name="bank_other_code" class="other_bankcode hidden">	
                     </div>
                  </div> -->

                  <div class="form-group">
                     <label class="col-sm-4 control-label">Company Address* </label>
                     <div class="col-sm-6">
                        <textarea required rows="4" cols="48" name="company_address" class="company_address form-control" required placeholder="Company Address"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Company Postal Code* </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Postal Code" type="text" name="company_postal" required class="company_postal form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Company Office Phone* </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Company Office Number" type="text" name="company_office_no" required class="company_office_no form-control">
                     </div>
                  </div>				  
				   <div class="form-group">
                     <label class="col-sm-4 control-label"> </label>
                     <div class="col-sm-6">
                        <input type="checkbox" name="same_address" class="same_address" value="1"> Same as Company Address<br>
                     </div>
                  </div>				   
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Warehouse Address* </label>
                     <div class="col-sm-6">
                        <textarea rows="4" cols="48" name="warehouse_address" class="warehouse_address form-control" required placeholder="Warehouse Address"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Warehouse Postal Code*  </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter the Warehouse Postal Code " type="text" name="warehouse_postal" class="warehouse_postal form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Warehouse Office Phone* </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Your Warehouse Office Phone " type="text" name="warehouse_office_no" class="warehouse_office_no form-control">
                     </div>
                  </div>
				  <div class="form-group">
                     <label class="col-sm-4 control-label"> </label>
                     <div class="col-sm-6">
                        <input type="checkbox" name="same_address_ware" class="same_address_ware" value="1"> Same as Company Address<br>
                     </div>
                  </div>
				  <div class="form-group">
                     <label class="col-sm-4 control-label">Customercare Address* </label>
                     <div class="col-sm-6">
                        <textarea rows="4" cols="48" name="customercare_address" class="customercare_address form-control" required placeholder="Customercare Address"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Customercare Postal Code*  </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter the Customercare Postal Code " type="text" name="customercare_postal" class="customercare_postal form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Customercare Office Phone* </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Your Customercare Office Phone " type="text" name="customercare_office_no" class="customercare_office_no form-control">
                     </div>
                  </div>
				  
				   <div class="form-group">
                     <label class="col-sm-4 control-label">GST Registered?*  </label>
                      <div class="col-sm-6">
                        <input type="radio" name="gst_registered" id="gst_registered" class="gst_registered" required value="1" >Yes<br>	
                        <input type="radio" name="gst_registered" id="gst_registered" class="gst_registered" required value="0" >No<br>
                     </div> 
                  </div>
				  
				  <div class="form-group">
                     <label class="col-sm-4 control-label">GST Number* </label>
                     <div class="col-sm-6">
                        <input placeholder="Enter Your GST Number" type="text" name="gst_number" class="gst_number form-control" value="">
                     </div>
                  </div>
				  
                  <br>
                  <hr>
                  <h1 style="text-align:center;">
                     YOUR SHOP INFORMATION
                  </h1>
                  <br>

                  <div class="form-group">
                     <label class="col-sm-4 control-label ">Shop Name / Display Name of Your Merzido Store*  </label>
                     <div class="col-sm-6">
                        <input required placeholder="Enter Display| Shop Name " type="text" name="merzido_store_name" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label ">What is the main category of product(s) you wish to sell?* </label>
                     <div class="col-sm-6">
						<select id="merzido-categories" size="1" name="merzido_category[]" multiple style="width:100%;padding:5px;height:150px;" class="form-control">
						<?php foreach($categories as $tmp){?>
                           <option value="<?php echo $tmp->CATG_MSTR_CATEGORY_ID?>"><?php echo $tmp->CATG_MSTR_CATEGORY_NAME?></option>
						<?php } ?>   
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label ">How many product(s) do you intend to sell on Merzido? </label>
                     <div class="col-sm-6">
						<select  size="1" name="seller_product_count" style="width:100%;padding:5px;" required class="form-control">
                           <option value="0-10">10  Below</option>
                           <option value="10-100">10 - 100 </option>
                           <option value="100-200">100 - 200 </option>
                           <option value="200-400">200 - 400 </option>
                           <option value="400-1000">400 - 1,000 </option>
                           <option value="1000-10000">1,000 - 10,000 </option>
                           <option value="10000+">10,000 Above</option>
                        </select>
                     </div>
                  </div>
				  
                  <div class="form-group">
                     <label class="col-sm-4 control-label ">Which brand(s) do you intend to sell on Merzido?</label>
                     <div class="col-sm-6">
                        <select id="merzido-brands" size="1" name="seller_brands[]" multiple style="width:100%;padding:5px;height:150px;" class="form-control">
						<?php foreach($brands as $tmp){?>
                           <option value="<?php echo $tmp->BRND_MSTR_BRAND_ID?>"><?php echo $tmp->BRND_MSTR_BRAND_NAME;?></option>
						<?php }?>
                        </select>
                     </div>
                  </div>
				  
				  <div class="form-group">
                     <label class="col-sm-4 control-label ">New Brand* </label>
                     <div class="col-sm-6">
                        <input placeholder="New Brand" type="text" name="seller_new_brands" class="form-control">
                     </div>
                  </div>
				  <br>
                  <hr>
                  <h1 style="text-align:center;">
						Documents to be uploaded
                  </h1>
                  <br>
				  
                  <div class="form-group">
                     <label class="col-sm-4 control-label ">Copy of Business Licence</label>
                     <div class="col-sm-6">
                        <input type="file" name="buissness_licence" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-4 control-label ">Copy of Bank Account </label>
                     <div class="col-sm-6">
                        <input type="file" name="bank_account" required>
                     </div>
                  </div>

                  <div class="form-group">
                     <div class="col-sm-offset-5 col-sm-9">
                        <button type="submit" class="btn btn-default" style="background-color: #183544; color:white; padding: 9px 22px; font-size: 16px;"><?= $button ?></button>
                     </div>
                  </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
</section>
<script>
    var url = '<?= site_url('Designations/ajax_manage_page')?>';
    var actioncolumn=3;
</script>
<?php $this->load->view('common/footer');  ?>

<!-- jQuery  -->
<script type="text/javascript" src="http://merzido.sg/site/assets/lib/jquery/jquery-1.11.2.min.js"></script>


<!---- Validation---->
<script type="text/javascript" src="http://merzido.sg/site/assets/lib/form-validataion/js/formValidation.js"></script>
<script type="text/javascript" src="http://merzido.sg/site/assets/lib/form-validataion/js/framework/bootstrap.js"></script>
<script type="text/javascript" type="text/css" src="http://merzido.sg/site/assets/lib/multi-select/js/jquery.multi-select.js"></script> 
<script type="text/javascript" src="http://merzido.sg/site/intlTelInput.js"></script>

<style>
.intl-tel-input {

font-size: 14px;
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
color: #333;
}
.intl-tel-input input {
border: 1px solid #CCC;
font-family: inherit;
font-size: 100%;
color: inherit;
}
</style>
<script type="text/javascript">

	$("#mobile-number").intlTelInput();

	$(function(){
       $("input[name='chkPassPort']").click(function () {
           if ($("#chkYes").is(":checked")) {
               $("#dvPassport").show();
           } else {
               $("#dvPassport").hide();
           }
       });
	});
	
	$(document).on("change",".gst_registered",function(){
			if($(".gst_registered:checked").val() == 0){
				$(".gst_number").removeAttr("required");
			}else{
				$(".gst_number").attr("required",true);
			}
	});
	
	
	$(document).on("click","input:radio[name=bank_codeno]",function(){
		if($('input:radio[name=bank_codeno]:checked').val() == "other"){
			$(".other_bankcode").removeClass('hidden');
		}
		else{
			$(".other_bankcode").addClass('hidden');
		}
	});
	
	$(document).on("change","input:checkbox[name=same_address]",function(){
		if($(this).prop('checked')==true){
			$(".warehouse_address").val($(".company_address").val());
			$(".warehouse_postal").val($(".company_postal").val());
			$(".warehouse_office_no").val($(".company_office_no").val());
		}
		else{
			$(".warehouse_address").val('');
			$(".warehouse_postal").val('');
			$(".warehouse_office_no").val('');
		}
	});
	
	$(document).on("change","input:checkbox[name=same_address_ware]",function(){
		if($(this).prop('checked')==true){
			$(".customercare_address").val($(".company_address").val());
			$(".customercare_postal").val($(".company_postal").val());
			$(".customercare_office_no").val($(".company_office_no").val());
		}
		else{
			$(".customercare_address").val('');
			$(".customercare_postal").val('');
			$(".customercare_office_no").val('');
		}
	});
	
	$(document).on("keyup",".company_address, .company_postal, .company_office_no",function(){
		if($("input:checkbox[name=same_address]").prop('checked')==true){
			$(".warehouse_address").val($(".company_address").val());
			$(".warehouse_postal").val($(".company_postal").val());
			$(".warehouse_office_no").val($(".company_office_no").val());
		};
	});

	$(document).ready(function(){
		
		$("#company_name").keyup(function(){
			$("#bank_name").val($("#company_name").val());
		});
		
		$("#bank_drop").change(function(){
				if($(this).val() == 'Other'){
					$(".bank_other_name").removeClass('hidden');
				}else{
					$(".bank_other_name").addClass('hidden');
				}
		});
		
		
		
        $('#seller_form').formValidation({
                message: 'This value is not valid',
                fields: {
						seller_email: {
							message: 'The email is required',
							validators: {
								notEmpty: {
									message: 'The email is required and can\'t be empty'
								},
								email:{
									message: 'invalid email'
								}
							}
						},
						shipping_contact: {
							validators: {
								notEmpty: {
									message: 'The email address is required and can\'t be empty'
								},
								integer: {
									message: 'The value is not an valid number'
								}
							}
						},
						shipping_address: {
							validators: {
								notEmpty: {
									message: 'The shipping address is required and can\'t be empty'
								}
							}
						},
						shipping_city: {
							validators: {
								notEmpty: {
									message: 'This is required and can\'t be empty'
								}
							}
						},						
						shipping_state: {
							validators: {
								notEmpty: {
									message: 'This can\'t be empty'
								}
							}
						},						
						shipping_zipcode: {
							validators: {
								notEmpty: {
									message: 'This can\'t be empty'
								},
								integer: {
									message: 'The value is not an valid number'
								}
							}
						},						
						shipping_country: {
							validators: {
								notEmpty: {
									message: 'This can\'t be empty'
								}
							}
						}
                }
            }).on('change', '.showbilling', function() {
                var billingAddress   = $(this).is(':checked');
                if (empty(billingAddress)) {
                    $('#billing_form').hide();
                    $('#shipping_form')
                        .formValidation('removeField', 'billing_name')
                        .formValidation('removeField', 'billing_address')
                        .formValidation('removeField', 'billing_city')
                        .formValidation('removeField', 'billing_state')
                        .formValidation('removeField', 'billing_country')
                        .formValidation('removeField', 'billing_zipcode')
                        .formValidation('removeField', 'billing_contact');
                }
				else {
                    $('#billing_form').show();
					
                    $('#shipping_form').formValidation('addField', 'billing_name', {
                            validators: {
                                notEmpty: {
                                    message: 'The name is required'
                                }
                            }
                        }).formValidation('addField', 'billing_contact', {
                            message: 'The phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        }).formValidation('addField', 'billing_zipcode', {
                            message: 'The phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        }).formValidation('addField', 'billing_address', {
                            message: 'The phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                }
                            }
                        }).formValidation('addField', 'billing_city', {
                            message: 'The phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                }
                            }
                        }).formValidation('addField', 'billing_state', {
                            message: 'The phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                }
                            }
                        }).formValidation('addField', 'billing_country', {
                            message: 'The phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                }
                            }
                        })
                }
            });
    });	
</script>