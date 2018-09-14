
<?php
                foreach($attribute_selected as $attr_selected)
                {

                        $attribute_name_from_table[]=$attr_selected->PRODUCT_ATTR_MAP_ATTR_NAME;

                }
                foreach($attribute_value_selected as $attr_val_selected)
                {

                        $attribute_value_from_table[]=$attr_val_selected->PRODUCT_ATTR_MAP_ATTR_VALUES;
                        
                }

                $prdt_attr='';
                $prdt_attr_name='';
                $prdt_attr_display='';
                $pro_count=0;
                foreach($attributes as $attr)
                {
                ?>
                      <div class="form-group row">
                      <label class="col-sm-2 col-form-label">
                      <?php 

                    echo $attr->ATTR_MSTR_ATTR_NAME;
                    $name=$attr->ATTR_MSTR_ATTR_ID;
                    $required='';
                    if($attr->CATG_ATTR_MAP_MANDATORY=='1')
                        {
                            $required='required';
                          echo '<span class="err">*</span>';
                        }
                    $prdt_attr_name.=$attr->ATTR_MSTR_ATTR_NAME.";";
                    $prdt_attr.=$name.";";
                    $prdt_attr_display.=$attr->CATG_ATTR_DISPLAY_TYPE.";";
                    $display=$attr->CATG_ATTR_DISPLAY_TYPE;
                    $event='';
                    if($attr->ATTR_MSTR_ATTR_TYPE=='1')
                    {
                        $event="onkeypress='return isInt(event)'";
                    }
                    else if($attr->ATTR_MSTR_ATTR_TYPE=='2')
                    {
                        $event="onkeypress='return isChar(event)'";
                    }
                    else if($attr->ATTR_MSTR_ATTR_TYPE=='3')
                    {
                        $event="onkeypress='return isString(event)'";
                    }
                    $atr=0;
                    $selected_val='';
                    $pro_count++;
                    foreach($attribute_name_from_table as $attr_name1)
                    {
                        if($attr->ATTR_MSTR_ATTR_NAME==$attr_name1)
                        {
                                $selected_val=$attribute_value_from_table[$atr]; 
                               // echo "*";       
                        }
                        $atr++;
                    }

                ?>
                      </label>
                      <div class="col-sm-9">
                      <?php
                                               foreach($values as $val){
                                                ?>
                      <?php

                                   if($attr->ATTR_MSTR_ATTR_ID == $val->ATTR_VALUES_ATTR_ID)
                                    {
                                        $ATTR_VAL[]= $val->ATTR_VALUES_ATTR_VALUES;
                                    }
                                    
                                    ?>
                      <?php
                                        }
                                        
                                    switch($display)
                                    {
                                        case '1':
                                        {

                                            echo "<select name='".$name."' class='form-control' ".$required." ".$event.">";
                                            $available=0;
                                            $option='';
                                           // echo "<option></option>";
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                                
                                            $option.="<option value='".$attr_val1."'";
                                            if($selected_val== $attr_val1)
                                                {
                                                    $option.="selected";
                                                }
                                            $option.=">".$attr_val1."</option>";
                                            $available++;
                                            }
                                            if($available==0)
                                            {
                                                echo "<option disabled selected>No Attributes available</option>";
                                            }
                                            else
                                            {
                                                echo "<option disabled selected>Select</option>";
                                                echo $option;
                                            }
                                            echo "</select>";
                                            break;
                                        }
                                        case '2':
                                        {
                                            $data1='';
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                                
                                                if($selected_val== $attr_val1)
                                                {
                                                    $data1=$selected_val;
                                                }
                                                else{
                                                    $data1.=$attr_val1;
                                                }
                                            }

                                            echo "<input type='text' name='".$name."' value='".$data1."' class='form-control input-sm' ".$required." ".$event.">";
                                            break;
                                        }
                                        
                                        case '4':
                                        {
                                            $data1='';
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                                $data1.=$attr_val1;
                                                if($selected_val== $attr_val1)
                                                {
                                                    $data1=$selected_val;
                                                }
                                            }
                                            echo "<input type='date' name='".$name."' value='".$data1."' class='form-control input-sm' ".$required." ".$event.">";
                                            break;
                                        }
                                        case '5':
                                        {
                                            echo "<select name='".$name."[]' multiple class='form-control input-sm'  ".$required." ".$event.">";
                                            //echo "<option>select</option>";
                                                $selected_val1=explode(",",$selected_val);
                                               
                                            foreach($ATTR_VAL as $attr_val1){
                                            echo "<option value='".$attr_val1."'";
                                            foreach($selected_val1 as $sel_val1)
                                            {   
                                                    if($sel_val1==$attr_val1)
                                                {
                                                    echo "selected";
                                                }
                                            }
                                            echo ">".$attr_val1."</option>";
                                            }
                                            echo "</select>";
                                         
                                            break;
                                        }
                                        case '6':
                                        {

                                          
                                            $selected_val1=explode(",",$selected_val);
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                            echo " <div><input type='checkbox'  id='skucheck' class='skucheck' value='".$attr_val1."' name='".$name."[]' ";
                                            foreach($selected_val1 as $sel_val1)
                                            {   
                                                    if($sel_val1==$attr_val1)
                                                {
                                                    echo "checked ";
                                                }
                                            }
                                            echo $required."><label for='checkbox3'>".$attr_val1."</label></input></div>";
                                            }
                                            break;
                                            
                                        }
                                        case '7':
                                        {
                                            $data1='';
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                                $data1.=$attr_val1;
                                                if($selected_val== $attr_val1)
                                                {
                                                     $data1=$selected_val;
                                                }
                                            }
                                            echo "<input type='number' value='".$data1."' name='".$name."' min='0' max='1000000' class='form-control input-sm' ".$required." ".$event.">";
                                            break;
                                        }
                                        case '8':
                                        {
                                            $data1='';
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                                $data1.=$attr_val1;
                                                if($selected_val== $attr_val1)
                                                {
                                                     $data1=$selected_val;
                                                }
                                            }
                                            echo "<img src='".$data1."' name='".$name."'>";

                                            break;
                                        }
                                        case '3':
                                        {
                                            echo "<textarea type='text'  class='form-control input-sm ckeditor' name='".$name."'";
                                            if($required=='required')
                                                {
                                                    echo "id='textarea1'";
                                                }
                                            echo ">";
                                            foreach($ATTR_VAL as $attr_val1)
                                            {
                                                
                                                if($selected_val== $attr_val1)
                                                {
                                                    echo $selected_val;
                                                }
                                                else
                                                {
                                                        echo $attr_val1;  
                                                }
                                            }
                                            echo "</textarea>";
                                            echo "<div class='text-danger'>".form_error('textarea1')."<span id=\etextarea1'></span></div>";
                                            break;
                                        }
                                    }
                                    echo "</div></div>";
                                 $display='';
                                            unset($ATTR_VAL);
                                            }
                                         ?>

                                         <input type='hidden' name='prdt_attr<?php echo $group;?>' value="<?= $prdt_attr ?>">
                  <input type='hidden' name='prdt_attr_name<?php echo $group;?>' value="<?= $prdt_attr_name ?>">
                  <input type='hidden' name='prdt_attr_display<?php echo $group;?>' value="<?= $prdt_attr_display ?>">