$(function() {

	//Open tokenbox when clicked
	$('#encbutton').click(function(){
		$('#tokenbox').modal();
	});

	//when create token button is clicked
	$('#ctoken').click(function(){

		//read encryption passphrase value from box
		var encpass = $('#encpassphrase').val();
		var encpassconfirm = $('#encpassphraseconfirm').val();


		//check if its empty
		if(encpass == "" || encpassconfirm == ""){
			showMessage('Sorry, Encryption Passphrase or Confirm field Cannot Be Empty!');
			$('#tokenbox').modal('hide');
		}else{
			if(encpass == encpassconfirm){
				try{

					//create sha3 token
					var enc = CryptoJS.SHA3(encpass + $('#edata').data('xsalt'));

					//set token value on form
					$('#encryption_token').val(enc);

					//change text of button
					$('#encbutton').html('Change');

					//hide box
					$('#tokenbox').modal('hide');

					//show message
					showMessage('Encryption Token Created!');
				}catch(err){
					showMessage('Could Not Create Token, Please Try Again!');
					$('#tokenbox').modal('hide');
				}
			}else{
				showMessage('Sorry, Encryption Passphrase Does Not Match The Confirm Field!');
				$('#tokenbox').modal('hide');
		}
			}

	});
});

function showMessage(message){
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('#message').text(message);
	$('#message').slideDown();
	setTimeout(function() {
		$('#message').slideUp();
	}, 3000);
}
