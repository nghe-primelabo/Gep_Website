function cValidate()
{
	/**
	 * Attach event to all form element with 'required' class
	 */
	this.message = '';
	this.REM	 = 'Required entry missing or entry contain invalid value!'; //required enty missing.

	this.init = function(){

			jQuery('#contestants-wrap form.contestant-form-validate :input.required').blur(
				function(){
					//alert('validate !');
					if( ! jQuery(this).hasClass('validate-custom-date') && ! jQuery(this).hasClass('validate-country') )
					{
						//alert('date or country!');
						if(cvalidate.validateElement(this))
							cvalidate.markValid(this);
						else
							cvalidate.markInvalid(this);
					}
				}
			);
			jQuery('#contestants-wrap form.contestant-form-validate .class_des').blur(
				function(){

						//alert('date or country!');
						if(cvalidate.validateElement(this))
							cvalidate.markValid(this);
						else
							cvalidate.markInvalid(this);
				}
			);
			jQuery('#contestants-wrap form.contestant-form-validate .tipNormal').blur(
				function(){
					//alert('validate !');
					if( ! jQuery(this).hasClass('validate-custom-date') && ! jQuery(this).hasClass('validate-country') )
					{
						//alert('date or country!');
						if(cvalidate.validateElement(this))
							cvalidate.markValid(this);
						else
							cvalidate.markInvalid(this);
					}
				}
			);
			jQuery('#contestants-wrap form.contestant-form-validate .tipRight').blur(
				function(){
					//alert('validate !');
					if( ! jQuery(this).hasClass('validate-custom-date') && ! jQuery(this).hasClass('validate-country') )
					{
						//alert('date or country!');
						if(cvalidate.validateElement(this))
							cvalidate.markValid(this);
						else
							cvalidate.markInvalid(this);
					}
				}
			);

			jQuery('#contestants-wrap form.contestant-form-validate :input.validate-profile-email').blur(
				function(){
					if((jQuery.trim(jQuery(this).val()) != ''))
					{
						if(cvalidate.validateElement(this))
							cvalidate.markValid(this);
						else
							cvalidate.markInvalid(this);
					}
				}
			);
			jQuery('#contestants-wrap form.contestant-form-validate :input.validate-number').blur(
				function(){
					//alert('i am here for working!!!');
					if((jQuery.trim(jQuery(this).val()) != ''))
					{
						if(cvalidate.validateElement(this))
							cvalidate.markValid(this);
						else
							cvalidate.markInvalid(this);
					}
				}
			);

			jQuery('#contestants-wrap form.contestant-form-validate :input.validateSubmit').click(
				function(){
					//alert('i am at submit');
					//this.restrictIpAdress();
					if(cvalidate.validateForm()){
						jQuery('#conForm').submit();
						return true;
					} else {
						var message = (cvalidate.REM == 'undefined' || cvalidate.REM == '') ? 'Required entry missing or entry contain invalid value!' : cvalidate.REM;
						cWindowShow('jQuery(\'#cWindowContent\').html("'+message+'")' , 'Notice' , 450 , 70 , 'warning');
						jQuery("#contestants-wrap form.contestant-form-validate :input.required[value='']").each(
							function(i){cvalidate.markInvalid(this);}
						);
						return false;
					}
				}
			);

	}
	this.markInvalid= function(el){
		var fieldName = el.name;

        if(jQuery(el).hasClass('validate-custom-date')){
	       //since we knwo custom date come from an array. so we have to invalid all.
	       jQuery("#contestants-wrap form.contestant-form-validate input[name='"+fieldName+"']").addClass('invalid');
	       jQuery("#contestants-wrap form.contestant-form-validate select[name='"+fieldName+"']").addClass('invalid');
	    } else {
           jQuery(el).addClass('invalid');
	    }
	}

	this.markValid= function(el){

	    var fieldName = el.name;

	    if(jQuery(el).hasClass('validate-custom-date')){
	       //since we knwo custom date come from an array. so we have to valid all.
	       jQuery("#contestants-wrap form.contestant-form-validate input[name='"+fieldName+"']").removeClass('invalid');
	       jQuery("#contestants-wrap form.contestant-form-validate select[name='"+fieldName+"']").removeClass('invalid');

	    } else {
		    jQuery(el).removeClass('invalid');
		}

	    //hide error only for those custom fields
	    if(fieldName != null){
			fieldName = fieldName.replace('[]','');
		    jQuery('#err'+fieldName+'msg').hide();
			jQuery('#err'+fieldName+'msg').html('&nbsp');
		}
	}

	/**
	 *
	 */
	this.validateElement = function(el){

		//alert('i am here');

		var isValid = true;
	    var fieldName = el.name;

	    if(jQuery(el).attr('type') == 'text' || jQuery(el).attr('type') == 'password' || jQuery(el).attr('type') == 'file' || jQuery(el).attr('type') == 'textarea'){

	      // alert('my type is'+jQuery(el).attr('type'));

	       if((jQuery.trim(jQuery(el).val()) == '') && (!jQuery(el).hasClass('norequired')) ) {
	          isValid = false;
	          //alert('i am here and fix this error!!!');
	          //show error only for those custom fields
	          fieldName = fieldName.replace('[]','');

	          //alert(fieldName);

	          lblName   = jQuery('#lbl'+fieldName).html();

	          //alert(lblName);

	          if(lblName == null){
		          lblName = 'Field';
	          } else {
	              lblName = lblName.replace('*','');
	          }
	          //alert(lblName);
	          this.setMessage(fieldName, lblName, 'GEP_INVALID_VALUE');

		   }else {
		       if(jQuery(el).hasClass('validate-name')){
		           //checking the string length
		           if(jQuery(el).val().length < 3){
			           this.setMessage(fieldName, '', 'GEP NAME TOO SHORT');
		               isValid = false;
		           } else {
		               jQuery('#err' + fieldName + 'msg').hide();
					   jQuery('#err' + fieldName + 'msg').html('&nbsp');
		               isValid = true;
		           }
		       }
		       if(jQuery(el).hasClass('validate-username')){
		           //use ajax to check the pages.
		          // alert('i am here');
		           if(jQuery('#usernamepass').val() != jQuery(el).val()){
		               isValid = cvalidate.ajaxValidateUserName(jQuery(el));
		               //alert(isValid);
		           }//end if
		       }
		       // This code check that the paycode is valid or not
		       if(jQuery(el).hasClass('validate-paycode')){
		       		if(jQuery('#paycodepass').val() != jQuery(el).val()){
		               isValid = cvalidate.ajaxValidatePaycode(jQuery(el));
		           }//end if
		       }

		       if(jQuery(el).hasClass('validate-email')){

		          // alert('i am here, where are you?');

		   		   //regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
		   		   regex=/^([*+!.&#$¦\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i;
			       isValid = regex.test(jQuery(el).val());

			       if(isValid == false){
					   this.setMessage(fieldName, '', 'GEP INVALID EMAIL');
			       } else {
		               jQuery('#err' + fieldName + 'msg').hide();
					   jQuery('#err' + fieldName + 'msg').html('&nbsp');

			           //use ajax to check the pages.
			           if(jQuery('#emailpass').val() != jQuery(el).val()){
			               isValid = cvalidate.ajaxValidateEmail(jQuery(el));
			           }//end if
				   }
		       }
		       if(jQuery(el).hasClass('validate-password') && el.name == 'mmpassword'){
		           if(jQuery(el).val().length < 6){
					   this.setMessage(fieldName, '', 'GEP PASSWORD TOO SHORT');
		               isValid = false;
		           } else {
		               jQuery('#err' + fieldName + 'msg').hide();
					   jQuery('#err' + fieldName + 'msg').html('&nbsp');
		               isValid = true;
		           }
		       }

		       if(jQuery(el).hasClass('validate-passverify') && el.name == 'password2'){
		           isValid = (jQuery('#password1').val() == jQuery(el).val());

		           if(isValid == false){
					   this.setMessage('password2', '', 'GEP PASSWORD NOT SAME');
		           } else {
		               jQuery('#errpassword2msg').hide();
					   jQuery('#errpassword2msg').html('&nbsp');
		           }
		       }
		       if( jQuery(el).hasClass('validate-captcha') && el.name == 'txtRobust' ){

					 isValid = (jQuery(el).val() == jQuery('#HidRd').val());
					 if(isValid == false){
					 	this.setMessage('txtRobust', '', 'GEP INVALID SICURITY CODE');
					 }else{
					 	jQuery('#errtxtRobustmsg').hide();
					    jQuery('#errtxtRobustmsg').html('&nbsp');
					 }
			   }
			   if( jQuery(el).hasClass('validate-cmnd')){
			   		var extReg = /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/;
					isValid = true;
					//alert(el.name);
					if (jQuery(el).val().search(extReg)==-1) {
						//alert('this is not a number!!!');
						isValid = false;
					}
					 if(isValid == false){
					 	this.setMessage(el.name, '', 'GEP INVALID NUMBER CARD');
					 }else{
					 	jQuery('#err'+el.name+'msg').hide();
					    jQuery('#err'+el.name+'msg').html('&nbsp');
					 }
			   }
			   if( jQuery(el).hasClass('validate-phone')){
			   		var extReg = /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/;
					isValid = true;
					if (jQuery(el).val().search(extReg)==-1) {
						//alert('this is not a number!!!');
						isValid = false;
					}
					 if(isValid == false){
					 	this.setMessage(el.name, '', 'GEP INVALID PHONE');
					 }else{
					 	jQuery('#err'+el.name+'msg').hide();
					    jQuery('#err'+el.name+'msg').html('&nbsp');
					 }
			   }

			   if( jQuery(el).hasClass('validate-avatar') && el.name == 'Filedata' ){
					var extReg = /^.+\.((jpg)|(gif)|(jpeg)|(png))$/i;
					isValid = true;
					if (jQuery('#file-upload').val().search(extReg)==-1) {
						isValid = false;
					}
					 if(isValid == false){
					 	this.setMessage('Filedata', '', 'GEP INVALID AVATAR');
					 }else{
					 	jQuery('#errFiledatamsg').hide();
					    jQuery('#errFiledatamsg').html('&nbsp');
					 }
			   }
		    }
		 }
		  else if(jQuery(el).attr('type') == 'checkbox'){
	       if(jQuery(el).hasClass('validate-custom-checkbox')){
			   if(jQuery("#contestants-wrap form.contestant-form-validate input[name='"+fieldName+"']:checked").size() == 0)
			   {
			   		isValid = false;
			   }

			   if(isValid == false){
		          fieldName = fieldName.replace('[]','');
		          lblName   = jQuery('#lbl'+fieldName).html();
		          if(lblName == null){
			          lblName = 'Field';
		          } else {
		              lblName = lblName.replace('*','');
		          }

		          this.setMessage(fieldName, lblName, 'GEP INVALID VALUE');
			   }//end if

	       } else {
              if(! jQuery(el).attr('checked')) isValid = false;
	       }
	    }

		return isValid;
	}

	/**
	 * Check & validate form elements
	 */
	this.validateForm = function(){
	    var isValid = true;

		jQuery('#contestants-wrap form.contestant-form-validate :input.required').each(
			function(i){
				if(! cvalidate.validateElement(this)) isValid = false;

				return isValid;
			}
		);
		/*
		jQuery('#contestants-wrap form.contestant-form-validate :input.validate-profile-email').each(
			function(){
				if((jQuery.trim(jQuery(this).val()) != ''))
				{
					if(! cvalidate.validateElement(this)) isValid = false;
				}
			}
		);
		*/

		jQuery('#contestants-wrap form.contestant-form-validate :input.validate-profile-url').each(
			function(){
				if((jQuery.trim(jQuery(this).val()) != ''))
				{
					if(! cvalidate.validateElement(this)) isValid = false;
				}
			}
		);
		return isValid;
	}
	/**
	 * Check to know how many time for a ip address
	 */
	 this.restrictIpAdress = function(){

		 times = jQuery('#mmrestrictipaddress').val();

		 if( times > 5 ){
		 	alert('you can not register more!');
		 }

		/**
		 if(isValid == false){
		 	this.setMessage('txtRobust', '', 'GEP INVALID SICURITY CODE');
		 }else{
		 	jQuery('#errtxtRobustmsg').hide();
		    jQuery('#errtxtRobustmsg').html('&nbsp');
		 }
		 **/
	 }

	/**
	 * Check the username whether already exisit or not.
	 */
	 this.ajaxValidateUserName = function(el){

	 	jaxcontestant.call_contestants('education', 'registration','registration.ajaxCheckUserName',jQuery(el).val());
	 }
	 /**
	 * Check the paycode whether already exisit or not.
	 */
	 this.ajaxValidatePaycode = function(el){

	 	//alert(jQuery(el).val());
	 	jaxcontestant.call_contestants('contestants', 'register','ajaxCheckPaycode',jQuery(el).val());
	 }
	 /**
	 * Check the paycode whether already exisit or not.
	 */
	 this.checkCatcha = function(el){
	 	jaxcontestant.call_contestants('contestants', 'register','ajaxCheckCatcha',jQuery(el).val());
	 }

	/**
	 * Check the email whether already exisit or not.
	 */
	 this.ajaxValidateEmail = function(el){
	  	jaxcontestant.call_contestants('education', 'registration','registration.ajaxCheckEmail',jQuery(el).val());
	 }
	  /*
	   * Get the message text from langauge file using ajax
	   */
	  this.setMessage = function(fieldName, txtLabel, msgStr){
	  		 //alert('i am here');
	  		 jaxcontestant.call_contestants('education', 'registration','registration.ajaxSetMessage',fieldName, txtLabel, msgStr);
	  }

	  //this.setREMText = function(text){
	  this.setSystemText = function(key, text){
	  	eval('cvalidate.' + key + ' = "' + text + '"');
	  }
}
var cvalidate = new cValidate();


