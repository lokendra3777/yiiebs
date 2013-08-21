
<?php  if($payment && $payment->responseCode == '0'){?>
	<h3><?= $payment->responseMessage ?></h3>
<?php }else{?>
<h3>Pay via EBS Payment gateway</h3>
<form  method="post" action="<? echo $ebs_post['ebs_gateway']?>" name="frmTransaction" id="frmTransaction" onSubmit="return validate()">
<input name="account_id" type="text" value="<?echo $ebs_post['account_id'] ?>" placeholder="Account ID">
     
 <input name="return_url" type="text" size="60" value="<? echo $ebs_post['return_url'] ?>" placeholder="Return URL" />
 <input name="mode" type="text" size="60" value="<? echo $ebs_post['mode']?>" placeholder="Mode"/>
  <input name="reference_no" type="text" value="<? echo  $ebs_post['reference_no'] ?>" placeholder="Reference Nu."/>
  <input name="amount" type="text" value="<? echo $ebs_post['amount']?>" placeholder="Amount"/>
  <input name="description" type="text" value="<? echo $ebs_post['description'] ?>" placeholder="Description"/> 
 <input name="name" type="text" maxlength="255" value="<? echo $ebs_post['name'] ?>" placeholder="Name"/>
<input name="address" type="text" maxlength="255" value="<? echo $ebs_post['address'] ?>" placeholder="Address"/>
<input name="city" type="text" maxlength="255" value="<? echo $ebs_post['city'] ?>" placeholder="City"/>
<input name="state" type="text" maxlength="255" value="<? echo $ebs_post['state'] ?>" placeholder="State"/>
<input name="postal_code" type="text" maxlength="255" value="<? echo $ebs_post['postal_code'] ?>" placeholder="Postal Code"/>
<input name="country" type="text" maxlength="255" value="<? echo $ebs_post['country'] ?>" placeholder="Country"/>
 <input name="phone" type="text" maxlength="255" value="<? echo $ebs_post['phone'] ?>" placeholder="Phone"/>
   <input name="email" type="text" size="60" value="<? echo $ebs_post['email']?>" placeholder="Email"/>
   <input name="secure_hash" type="text" size="60" value="<? echo $ebs_post['secure_hash'];?>" placeholder="Secure Hash"/>
 <input name="submitted" value="Submit" type="submit" class="btn btn-primary"/>
 
</form>

<?php }?>


<script language="JavaScript">
function validate(){
	
	var frm = document.frmTransaction;
	var aName = Array();
	aName['account_id'] = 'Account ID';
	aName['reference_no'] = 'Reference No';
	aName['amount'] = 'Amount';
	aName['description'] = 'Description';
	aName['name'] = 'Billing Name';
	aName['address'] = 'Billing Address';
	aName['city'] = 'Billing City';
	aName['state'] = 'Billing State';
	aName['postal_code'] = 'Billing Postal Code';
	aName['country'] = 'Billing Country';
	aName['email'] = 'Billing Email';
	aName['phone'] = 'Billing Phone Number';
	aName['ship_name']='Shipping Name';
	aName['ship_address']='Shipping Address';
	aName['ship_city']='Shipping City';
	aName['ship_state']='Shipping State';
	aName['ship_postal_code']='Shipping Postal code';
	aName['ship_country']='Shipping Country';
	aName['ship_phone']='Shipping Phone';
	aName['return_url']='Return URL';
	

	for(var i = 0; i < frm.elements.length ; i++){
		if((frm.elements[i].value.length == 0)||(frm.elements[i].value=="Select Country")){
						if((frm.elements[i].name=='country')||(frm.elements[i].name=="ship_country"))
					alert("Select the " + aName[frm.elements[i].name]);
					else
					alert("Enter the " + aName[frm.elements[i].name]);
				frm.elements[i].focus();
				return false;
			}
			if(frm.elements[i].name=='account_id'){
			
			if(!validateNumeric(frm.elements[i].value)){
					alert("Account Id must be NUMERIC");
			frm.elements[i].focus();
			return false;
			}
			}
			
			if(frm.elements[i].name=='amount'){
			if(!validateNumeric(frm.elements[i].value)){
					alert("Amount should be NUMERIC");
			frm.elements[i].focus();
			return false;
			}
			}
			if((frm.elements[i].name=='postal_code')||(frm.elements[i].name == 'ship_postal_code'))
			{
			if(!validateNumeric(frm.elements[i].value)){
					alert("Postal code should be NUMERIC");
			frm.elements[i].focus();
			return false;
			}
			}	
			
			if((frm.elements[i].name=='phone')||(frm.elements[i].name =='ship_phone')){
			if(!validateNumeric(frm.elements[i].value)){
					alert("Enter a Valid CONTACT NUMBER");
			frm.elements[i].focus();
			return false;
			}
			}		
    	
    
	
		if((frm.elements[i].name == 'name')||(frm.elements[i].name == 'ship_name'))
		{
		
		if(validateNumeric(frm.elements[i].value)){
					alert("Enter your Name");
			frm.elements[i].focus();
			return false;
			}
		}
		
				
		if(frm.elements[i].name=='ship_postal_code'){
			if(!validateNumeric(frm.elements[i].value)){
					alert("Postal code should be NUMERIC");
			frm.elements[i].focus();
			return false;
			}
			}		
    
			
							
		if(frm.elements[i].name == 'email'){
				if(!validateEmail(frm.elements[i].value)){
					alert("Invalid input for " + aName[frm.elements[i].name]);
					frm.elements[i].focus();
					return false;
				}		
			}
			
	}  
	return true;
}

	function validateNumeric(numValue){
		if (!numValue.toString().match(/^[-]?\d*\.?\d*$/)) 
				return false;
		return true;		
	}

function validateEmail(email) {
    //Validating the email field
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	//"
    if (! email.match(re)) {
        return (false);
    }
    return(true);
}


Array.prototype.inArray = function (value)
// Returns true if the passed value is found in the
// array.  Returns false if it is not.
{
    var i;
    for (i=0; i < this.length; i++) {
        // Matches identical (===), not just similar (==).
        if (this[i] === value) {
            return true;
        }
    }
    return false;
};

</script>
