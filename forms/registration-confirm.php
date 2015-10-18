<script type="text/javascript">
	function goToBack()
	{
		document.getElementById('backclickID').value = "1";
		document.forms["confirmSubmitForm"].submit();
	}

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
<form action="" method="post" id="register-form" name="confirmSubmitForm">

    <h2>Please Confirm Your Registration</h2>
	
    <div id="form-content">
        <fieldset>

            <div class="fieldgroup">
                <label for="firstname" style="font-weight:bold">First Name</label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);?>"  placeholder="Enter Your First Name"  maxlength="30" readonly>
            </div>

            <div class="fieldgroup">
                <label for="lastname" style="font-weight:bold">Last Name</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);?>"  placeholder="Enter Your Last Name"   maxlength="30" readonly>
            </div>

			<div class="fieldgroup">
                <label for="lastname" style="font-weight:bold">Address1</label>
                <input type="text" name="address1" value="<?php echo htmlspecialchars($address1, ENT_QUOTES);?>"   placeholder="Enter Your Address1"   maxlength="100" readonly>
            </div>

			<div class="fieldgroup">
                <label for="lastname">Address2</label>
                <input type="text" name="address2" value="<?php echo htmlspecialchars($address2, ENT_QUOTES);?>" maxlength="100" readonly>
            </div>

            <div class="fieldgroup">
                <label for="lastname" style="font-weight:bold">City</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($city, ENT_QUOTES);?>"   placeholder="Enter Your City"  placeholder="Enter Your City"  maxlength="30" readonly>
            </div>

			<div class="fieldgroup">
                <label for="lastname" style="font-weight:bold">State</label>
                <select name="state" readonly>
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
                <label for="lastname" style="font-weight:bold">Zip Code</label>
                <input type="text" name="zipcode" value="<?php echo htmlspecialchars($zipcode, ENT_QUOTES);?>"   placeholder="Enter Your Zip Code"  onkeypress="return checkForNumberPoints();" maxlength="9" readonly>
            </div>

			<div class="fieldgroup">
                <label for="lastname" style="font-weight:bold">Country</label>
                <input type="text" name="country" value="United States" readonly>
            </div>

            <div class="fieldgroup">
				<input type="hidden" name="formSubmittedConfirm" value="1">
				<input type="submit" name="submit" value="Confrim" class="submit">
				<input type="submit" name="cancel" value="Back" class="submit" onClick="goToBack()">
				<input type="hidden" name="isBackedClick" value="0" id="backclickID">
            </div>
        </fieldset>
    </div>
</form>