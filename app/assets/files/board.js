"use strict";
$(function() {//On Load

	$('#tbutton').click(function(){
		$('.collapselink').each(function(){
			$(this).click();
		});
	});

	//Handle deleteserver option
	$('#delbuttonnav').tooltip({
		title: "Use the delete button on the server itself to delete a server",
		placement: 'bottom'
	});

	//If there is a message set,show it
	$('.firstmsg').each(function(){
		showMessage($(this).data('msg'));
	});

	//Select Text When Mouse Hovers Over InputBoxes
	$('.aselect').mouseenter(function(){
		$(this).select().focus();
	});

	//Unselect Text When Mouse Leaves
	$('.aselect').mouseleave(function(){
		document.getSelection().removeAllRanges();
		$(this).blur();
	});

	//Enable Tooltips On All Inputs
	$('.aselect').tooltip({
		title: 'CTRL+C To Copy',
		placement: 'left'
	});

	//Make All Inputs With Data Read Only
	$('.aselect').attr('readonly', true);

	//Open Passphrase Box When Decrypt Password Button is Pressed
	$('#dbutton').click(function(){
		$('#passphrasebox').modal();
	});

	$('.delbtn').click(function(){
		$("#delete").val($(this).data('server'));
		$('#deletebox').modal();
	});

	//When Decrypt Password Button On Passphrase Box Is Clicked
	$('#decryptbutton').click(function(){

		//Read Encryption Passphrase Entered On Box
		var encpass = $('#encpassphrase').val();

		//Show Error If The Passphrase Field Is Empty
		if(encpass == ''){
			showMessage('Sorry, The Encryption Passphrase Cannot Be Empty!');
			$('#passphrasebox').modal('hide');
		}else{

			//Read Encryption Passphrase For User
			var encryptiontoken = $('#enctoken').html();


			//Create A SHA3 Token From Entered Passphrase
			var echeck = CryptoJS.SHA3(encpass + $('#edata').data('xsalt'));

			//Check If Token Matches Entered Passphrase So That User Doesn't Enter Wrong Passphrase
			if(encryptiontoken == echeck){
				var count = 0; //count every single password

				//Decrypt All Passwords In Page
				$(".encrypted").each(function(index){
					try{

						//Get Data To Decrypt From HTML5 Data Field
						var enc = $(this).data("enc");

						//Decrypt
						var dec = GibberishAES.dec(enc, encpass);

						//Set Decrypted Value
						$(this).val(dec);

						count++;

					}catch(err){
						showMessage('Decryption Failed! Check your password!');
						$('#passphrasebox').modal('hide');
					}
				});

				//Hide Decrypt Button After Decryption Is Complete
				$('#dbutton').hide();
				if(count == 0){
					showMessage('No Passwords To Decrypt!');
				}else{
					showMessage('Passwords Decrypted!');
				}

				//Hide Password Box
				$('#passphrasebox').modal('hide');
			}else{
				showMessage('Sorry, The Encryption Passphrase Used Was Incorrect!');
				$('#passphrasebox').modal('hide');
			}

		}
	});

	//Handle Search
	$('#search').keyup(function(){

		//Get search string from input box
		var search = $(this).val();

		//count of visible search results
		var count = 0;

		//search in every server container
		$('.pcontainer').each(function(){

			//start the searchable string with title
			var sstring = $('.panel-heading h3', this).html();

			$('.aselect', this).each(function(){
				//Add all the values that can be copies to searchable string
				sstring += ' ' + $(this).val();
			});

			//check if the search term exists in searchable string
			if (sstring.toLowerCase().indexOf(search.toLowerCase()) != -1){
				//if it does,show container
				$(this).show();
			}else{
				//if it doesnt, hide
				$(this).hide();
			}

			//if the container is visible, add increate counter of visible containers
			if($(this).is(":visible")){
				count++;
			}
		});

		//if there are no containers to display, give error message
		if(count == 0){
			showMessage('Sorry, No Search Results Found!');
		}else{
			//if containers appear again, remove message
			$('#message').slideUp();
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
