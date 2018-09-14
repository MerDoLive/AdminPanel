<div class="container">
   <div class="row">
     <!--  <div class="block block-breadcrumbs"> -->
         <ul>
            <li>Seller Registration</li>
         </ul>
      </div>
      <div class="main-page">	
	  <?php if ($this->session->flashdata('success') != ''):?>
         <div class="col-sm-10 col-md-10 col-lg-10" style="padding:100px 10px; margin-top:50px;margin:auto;float:none;">
            <h1 class="text-center" style="color:color:#ffa200;">
                Thank you for joining us.!
            </h1>
            <br>
         </div>
	  <?php else:?>
		<div class="col-sm-10 col-md-10 col-lg-10" style="padding:100px 10px; margin-top:50px;margin:auto;float:none;">
            <h1 class="text-center ">
                Somthing went wrong, Please try again later!	
            </h1>
            <br>
         </div>
	  <?php endif;?>
      </div>
   </div>
</div>