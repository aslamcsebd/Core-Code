<?php
	include('../includes/connection.php'); 
	$code  =  code();
?>

<?php include('../includes/header.php'); ?>

   <div class="container-fluid action">

      <?php include('../includes/navbar.php'); ?> 

      <div class="row">

         <div class="col-2 left-side-section">
            <?php include('../includes/left-side.php'); ?> 
         </div> 

         <div class="col-10 border">
         	<a href="view_code.php" class="btn btn-sm btn-warning back">Back</a>

				<?php
					// Insert Code...
					if (isset($_POST['InsertCode'])) {

						// $search  = array('&#039;', '&quot;');
						
	               // $replace = array("'", '"');

	               $search = array("'", '"');
	               $replace  = array("\'", '\"');
	              

				      $code_type      =  $_POST['code_type'];

				      $item_name     =$_POST['item_name'];
				      $row_code     =$_POST['row_code'];

				      // $row_code=str_replace("'","\'",$row_code);
				      $item_name=str_replace($search, $replace, $item_name);
				      $row_code=str_replace($search, $replace, $row_code);

				      $sql ="insert into $code_type values (null, '$item_name','$row_code')";
				      $result =  mysqli_query($code,$sql);
				      if ($result) {
				         $_SESSION['code_insert_successfully']=true;
				         echo "<script>window.location.href='view_code.php?type=$code_type'</script>";
				      }
				   }  

				   // Edit Code... view this page below...	
			      if (isset($_GET['edit_code_type'])) {
				     	$edit_code_type=$_GET['edit_code_type']; //All or not  or  html, css ,php
				     	$edit_code_id=$_GET['edit_code_id']; 	//id 1 2 3
				     	$edit_item=$_GET['edit_item']; 			// [button] [insert, delete] [update/edit]

				      if ($edit_code_type!='all') {
					      $sql  ="select * from $edit_code_type where id='$edit_code_id'";
					      $result  =  mysqli_query($code,$sql);
					      $edit_row = mysqli_fetch_assoc($result);

				      }else{
				      	$sql2 ="select * from code_type";
		               $result2 = mysqli_query($code,$sql2);
		               while($codeType = mysqli_fetch_assoc($result2)) {
		               	$codeType=$codeType['code_name'];

					      	$sql3 ="select * from $codeType where id='$edit_code_id' AND item='$edit_item'";
					      	$result3=mysqli_query($code,$sql3);
		               	$rowcount3 = mysqli_num_rows($result3);
								if ($rowcount3){
									$sql4  ="select * from $codeType where id='$edit_code_id'";
							      $result4  =  mysqli_query($code,$sql4);
							      $edit_row = mysqli_fetch_assoc($result4);
							      break;
							   }
							}
						}
					}

					// Edit Code Confirm...
					if (isset($_POST['edit_code_confirm'])) {
						$search = array("'", '"');
	               $replace  = array("\'", '\"');

				      $code_type 	=  $_POST['code_type'];

				      $item     	=  $_POST['item_name'];
					  	$row_code   =  $_POST['row_code'];

				      $item=str_replace($search, $replace, $item);
				      $row_code=str_replace($search, $replace, $row_code);
					   

				      if ($code_type==null) {
				      	if (!isset($codeType)) {
				      		$sql ="update $edit_code_type set item='$item', code='$row_code' where id=$edit_code_id";
							   $result =  mysqli_query($code,$sql);
					         $_SESSION['edit_code_successfully']=true;					   
							   echo "<script>window.location.href='view_code.php?type=$edit_code_type&sms=$edit_code_type'</script>";

				      	}
				      	if (isset($codeType)) { 
				      		$sql ="update $codeType set item='$item', code='$row_code' where id=$edit_code_id";
							   $result =  mysqli_query($code,$sql);
					         $_SESSION['edit_code_successfully']=true;					   
							   echo "<script>window.location.href='view_code.php?type=$edit_code_type&sms=$codeType'</script>";
				      	}

				      }else{
				      	//if don't select 'all' & type to another type move direcet
				      	
				      	if (!isset($codeType)) { 
				      		$sql3 ="insert into $code_type values (null, '$item','$row_code')";
						      $result3 =  mysqli_query($code,$sql3);
								
								//delete default/old option
						      $sql4 	="delete from $edit_code_type where id='$edit_code_id'";
								$result4	=	mysqli_query($code,$sql4);

						      if ($result4) {
						         $_SESSION['old_code_move_successfully']=true;			         
						         echo "<script>window.location.href='view_code.php?type=$edit_code_type&old_code=$edit_code_type&move_to=$code_type'</script>";
						      }
						   }

						   //$codeType= when select 'all' but don't know all means html or css type
						   if (isset($codeType)) {
						   	//if select & default option same
					      	if ($code_type==$codeType) {
					      		$sql2 ="update $codeType set item='$item', code='$row_code' where id=$edit_code_id";
							   	$result =  mysqli_query($code,$sql2);
					         	$_SESSION['edit_code_successfully']=true;		
							   	echo "<script>window.location.href='view_code.php?type=$edit_code_type&sms=$codeType'</script>";				      	
					      	}else{
							      $sql3 ="insert into $code_type values (null, '$item','$row_code')";
							      $result3 =  mysqli_query($code,$sql3);
									
									//delete default/old option
							      $sql4 	="delete from $codeType where id='$edit_code_id'";
									$result4	=	mysqli_query($code,$sql4);

							      if ($result4) {
							         $_SESSION['old_code_move_successfully']=true;				         
							         echo "<script>window.location.href='view_code.php?type=$edit_code_type&old_code=$codeType&move_to=$code_type'</script>";
							      }
							   }
					   	}
					   }
					}


				   //Delete code...
				   if (isset($_GET['delete_code_type'])) {
				   	$delete_code_id=$_GET['delete_code_id']; 
				      $delete_code_type=$_GET['delete_code_type']; 
				      $item=$_GET['item'];

				      if ($delete_code_type!='all') {
				      	
					      $sql3 	="delete from $delete_code_type where id='$delete_code_id'";
							$result3	=	mysqli_query($code,$sql3);

						 	if ($result3) {
						 		$sql4 ="SELECT * FROM $delete_code_type where id='$delete_code_id'";
								$result4=mysqli_query($code,$sql4);
							 	$rowcount4 = mysqli_num_rows($result4);
									if ($rowcount4){
										$_SESSION['code_delete_fail']=true;
					         		echo "<script>window.location.href='view_code.php?type=$delete_code_type'</script>";

									} else {
										$_SESSION['code_delete_successfully']=true;
					         		echo "<script>window.location.href='view_code.php?type=$delete_code_type'</script>";
									}
							}
						}else{		

					      $sql5 ="select * from code_type";
		               $result5 = mysqli_query($code,$sql5);
		               while($codeType = mysqli_fetch_assoc($result5)) {
		               	$codeType=$codeType['code_name'];

					      	$sql6 ="select * from $codeType where id='$delete_code_id' AND item='$item'";
					      	$result6=mysqli_query($code,$sql6);
		               	$rowcount6 = mysqli_num_rows($result6);
								if ($rowcount6){

									$sql7 ="delete from $codeType where id='$delete_code_id' AND item='$item'";
				      			$result7=mysqli_query($code,$sql7);
				      			if ($result7) {
				      				$sql8 ="select * from $codeType where id='$delete_code_id' AND item='$item'";
							      	$result8=mysqli_query($code,$sql8);
				               	$rowcount8 = mysqli_num_rows($result8);
										if ($rowcount8){
											$_SESSION['code_delete_fail']=true;
					         			echo "<script>window.location.href='view_code.php?type=$delete_code_type'</script>";
										}else{
				      					$_SESSION['from_all_code_delete_successfully']=true;

				         				echo "<script>window.location.href='view_code.php?type=$delete_code_type&all_type=$codeType'</script>";
				         				break;
				         			}
				         		}
				         	}
				         }
			      	}
			      }
				?>
		        
	        	<?php if (isset($_GET['InsertCodeButton'])) { ?>
	        		<div class="card">
 						<div class="card-header text-center bg-primary text-light">Add More Code</div>
 							<div class="card-body">
	          		  		<form action="" method="POST" enctype="multipart/form-data">

		          		  		<div class="form-group row">
		                     	<label class="col-2 col-form-label text-right" for="select">Code Section</label>
		                        <div class="col-2">
		                           <select class="form-control action_select" name='code_type' id="select" autofocus required>
	                                 <option value="">Code type</option>
	                                 <?php 
	                                    $sql  ="select * from code_type order by id ASC";
	                                    $result  =  mysqli_query($code,$sql);
	                                    while($codeType = mysqli_fetch_assoc($result)) { ?>
	                                      <option style="text-align: center;" value="<?= $codeType['code_name'] ?>"><?= $codeType['code_name'] ?></option>
	                                     <?php } ?>
		                           </select>                                
		                        </div> 
		                  	</div> 

		                     <div class="form-group row justify-content-center">
		                        <label class="col-2 col-form-label" for="name">Item Name</label>
		                        <div class="col">
		                        	 <input id="name" type="text" class="form-control" name="item_name" keydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}" placeholder="Item's Name ex: insert, delete, btn etc" required>
		                        </div>	                                          
		                  	</div>

		                     <div class="form-group row justify-content-center">
		                        <label  class="col-2 col-form-label" for="code">Row Code</label>
		                        <div class="col">                     
		                           <div class="form-group">
		                              <textarea id="code" type="text" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}" class="form-control" rows="8" name="row_code" placeholder="Row Code...Helping code like css, example etc"></textarea>
		                           </div> 
		                        </div>
		                     </div>    

		                     <div class="row text-center">
		                        <div class="offset-2 col-4 btn-group" role="group">
		                           <button type="submit" name="InsertCode" class="btn btn-primary">Insert Code</button>
		                           <a href="view_code.php" class="btn btn-warning">Cancel</a>
		                        </div>                                          
		                     </div>
		                  </form> 
	          			</div>
	          	</div>
	         <?php } ?>

	        	<?php if (isset($_GET['edit_code_type'])) { ?>
	        		<div class="card">
 						<div class="card-header text-center bg-primary text-light">Edit Code</div>
 							<div class="card-body">
	          		  		<form action="" method="POST" enctype="multipart/form-data"> 

		          		  		<div class="form-group row">
		          		  			<label class="col-2 col-form-label text-right" for="select">Code Section : </label>
		                        <div class="col-3">
	                              <select name='code_type' class="form-control action_select" id="select">
	                                 <option value="">Select code type</option>
	                                 <?php 
	                                    $sql  ="select * from code_type order by id ASC";
	                                    $result  =  mysqli_query($code,$sql);
	                                    while($codeType = mysqli_fetch_assoc($result)) { ?>
	                                      <option style="text-align: center;" value="<?= $codeType['code_name'] ?>"><?= $codeType['code_name'] ?></option>
	                                     <?php } ?>
	                              </select>                   
		                        </div> 
		                  	</div> 


		                     <div class="form-group row justify-content-center">
		                        <label  class="col-2 col-form-label text-right">Item Name : </label>
		                        <div class="col">
		                           <input type="text" name="item_name" class="form-control" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}" value="<?= $edit_row['item']; ?>" >          
		                        </div>	                                          
		                  	</div> 

		                     <div class="form-group row justify-content-md-center">
		                        <label  class="col-2 col-form-label text-right">Row Code : </label>
		                        <div class="col">                     
		                           <div class="form-group">
		                              <textarea type="text" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}" class="form-control" rows="10" name="row_code" placeholder="Row Code..." ><?= $edit_row['code']; ?></textarea>
		                           </div> 
		                        </div>
		                     </div>

		                     <div class="row">
		                        <div class="offset-2 col-4 btn-group" role="group">
		                           <button type="submit" name="edit_code_confirm" class="btn btn-primary">Edit Code</button>
		                        	<a href="view_code.php" class="btn btn-success">Cancel</a>
		                        </div>                                          
		                     </div>
	                  </form> 
	               </fieldset>
	          	</div>
	         <?php } ?>
	      </div>
	   </div>
	</div>

<?php include('../includes/footer.php');   ?>
<?php unset($_SESSION['employee_add_fail']); ?>
<?php unset($_SESSION['employee_name_exit']); ?>
<?php unset($_SESSION['employee_id_exit']); ?>