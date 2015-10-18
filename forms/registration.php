<script type="text/javascript">

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    firstname: "required",
                    lastname: "required",
					address1: "required",
					city: "required",
					state: "required",
					zipcode: "required"
                },
                messages: {
                    firstname: "Please enter your first name.",
                    lastname: "Please enter your last name.",
					address1: "Please enter your address1.",
					city: "Please enter your city.",
					state: "Please select your state.",
					zipcode: "Please enter your zip code with 5 or 9 digits."
                },
                submitHandler: function(form) {
         			form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
<form action="" method="post" id="register-form" novalidate="novalidate">

    <h1>User Registration</h1>&nbsp;<font style="font-size:12px;">[Note: All <font color='red'>*</font> marked fields are mandatory]</font>
	<?php

		if(!empty($errorMsg)){
			echo $errorMsg;
		}
	?>

    <div id="form-content">
        <fieldset>

            <div class="fieldgroup">
                <label for="firstname">First Name<font color='red'>*</font></label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);?>"  placeholder="Enter Your First Name"  maxlength="30">
            </div>

            <div class="fieldgroup">
                <label for="lastname">Last Name<font color='red'>*</font></label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);?>"  placeholder="Enter Your Last Name"   maxlength="30">
            </div>

			<div class="fieldgroup">
                <label for="lastname">Address1<font color='red'>*</font></label>
                <input type="text" name="address1" value="<?php echo htmlspecialchars($address1, ENT_QUOTES);?>"   placeholder="Enter Your Address1"   maxlength="100">
            </div>

			<div class="fieldgroup">
                <label for="lastname">Address2</label>
                <input type="text" name="address2" value="<?php echo htmlspecialchars($address2, ENT_QUOTES);?>"   placeholder="Enter Your Address2"   maxlength="100">
            </div>
           <div class="fieldgroup">
                <label for="lastname">City<font color='red'>*</font></label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($city, ENT_QUOTES);?>"   placeholder="Enter Your City"  placeholder="Enter Your City"  maxlength="30">
            </div>

			<div class="fieldgroup">
                <label for="lastname">State<font color='red'>*</font></label>
                <select name="state">
					<?php
						foreach($a_usaProvinces as $key=>$value){

							$select		=	"";
							if($key     ==  $state){
								$select	=	"selected";
							}

							echo "<option value='$key' $select>".ucwords(strtolower($value))."</option>";
						}
					?>
				</select>
            </div>

			<div class="fieldgroup">
                <label for="lastname">Zip Code<font color='red'>*</font></label>
                <input type="text" name="zipcode" value="<?php echo htmlspecialchars($zipcode, ENT_QUOTES);?>"   placeholder="Enter Your Zip Code"  onkeypress="return checkForNumberPoints();" maxlength="9">
            </div>

			<div class="fieldgroup">
                <label for="lastname">Country<font color='red'>*</font></label>
                <input type="text" name="country" value="United States" readonly disabled>
            </div>

            <div class="fieldgroup">
				<input type="hidden" name="formSubmitted" value="1">
				<input type="submit" name="submit" value="Register" class="submit">
            </div>

        </fieldset>
    </div>
</form>