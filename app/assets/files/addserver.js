"use strict";
$( document ).ready(function() {

	//Handle deleteserver option
	$('#delbuttonnav').tooltip({
		title: "Use the delete button on the server's panel to delete a server",
		placement: 'bottom'
	});

	//Change button texts if the password fields are not empty by default
	$('input', $('.setbutton').parent().parent()).each(function(){
		if($(this).val() != ''){
			$('.setbutton', $(this).parent()).text('Change');
		}
	});

	//Chagne the default selection on panel type
	$('#type option').filter(function() {
		return ($(this).text() == $('#type').data('selected')); //To select Blue
	}).prop('selected', true);

	//Chagne the default selection on panel type
	$('#panel option').filter(function() {
		return ($(this).text() == $('#panel').data('selected')); //To select Blue
	}).prop('selected', true);

	//Chagne the default selection on panel type
	$('#color option').filter(function() {
		return ($(this).text() == $('#color').data('selected').charAt(0).toUpperCase() + $('#color').data('selected').slice(1)); //To select Blue
	}).prop('selected', true);



	var selectedPassword;
	var selectedButton;

	$('.setbutton').click(function(){
		selectedButton = $(this);
		selectedPassword = $('input', $(this).parent().parent());
		$("#encpassword").val('');
		$('#passphrasebox').modal();
	});


	$('#encryptbuttonbox').click(function(){
		//Read Encryption Passphrase and Password Entered On Box
		var encpassphrase = $('#encpassphrase').val();
		var encpassword = $("#encpassword").val();

		//Show Error If The Passphrase Field Is Empty
		if(encpassphrase == '' || encpassword == ''){
			showMessage('Sorry, The Encryption Passphrase or Password Cannot Be Empty!');
			$('#passphrasebox').modal('hide');
		}else{

			//Read Encryption Passphrase For User
			var encryptiontoken = $('#enctoken').html();

			//Create A SHA3 Token From Entered Passphrase
			var echeck = CryptoJS.SHA3(encpassphrase + $('#edata').data('xsalt'));


			//Check If Token Matches Entered Passphrase So That User Doesn't Enter Wrong Passphrase
			if(encryptiontoken == echeck){
				try{
					//Decrypt
					var enc = GibberishAES.enc(encpassword, encpassphrase);

					//Set Decrypted Value
					selectedPassword.val(enc);
					selectedButton.text('Change');
					//Change button text

				}catch(err){
					showMessage('Encryption Failed! Try Again!');
					$('#passphrasebox').modal('hide');
				}

				$('#passphrasebox').modal('hide');

				showMessage('Password Encrypted!');


			}else{
				showMessage('Sorry, The Encryption Passphrase Used Was Incorrect!');
				$('#passphrasebox').modal('hide');
			}
		}

	});

	$('#panelodiv').hide();

	$( "#panel" ).change(function() {
		if($('#panel').val().localeCompare('Other') == 0){
			$('#panelodiv').slideDown();
		}else{
			$('#panelodiv').hide();
		}
	});


});

function showMessage(message){
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#message').text(message);
	$('#message').slideDown();
	setTimeout(function() {
		$('#message').slideUp();
	}, 5000);
}
