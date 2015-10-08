<?php

class LoginController extends BaseController{

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
	}

	/*
	Shows Login Form
	
	@filename: LoginController.php
	*/
		
	public function showLogin(){
		$data['page'] = 'Login';
		return View::make('accounts/userform', $data);
	}

	/*
	Shows Login Form With Register CheckBox selected by default
	
	@filename: LoginController.php
	*/
		
	public function showRegister(){
		$data['page'] = 'Register';
		return View::make('accounts/userform', $data);
	}
	

	/*
	Handles submitted login/register forms
	
	@filename: LoginController.php
	*/
		
	public function submitForm(){

		//Get weather the form submitted was login form or registration form (using radio value)
		$type = Input::get('type');

		//Set rules for validation
		if($type == "login"){
			//Rules to validate form data if person is trying to login
			$rules = array(
				'email'=>'required|email',
				'password'=>'required|between:6,36'
			);
		}else{
			//Rules to validate form data if the person is trying to register
			if(Input::get('home') == "true"){ //If the user is trying to register from homepage, do not validate
					return Redirect::route('register')->with('message', 'Please fill the rest of the form to register.')->withInput();
				}else{//Set rules for registration validation
					$rules = array(
						    'firstname'=>'required|alpha|min:2',
							'lastname'=>'required|alpha|min:2',
							'email'=>'required|email|unique:users',
							'password'=>'required|between:6,12|confirmed',
							'password_confirmation'=>'required|between:6,12',
							'encryption_token'=>'required'
					);
				}
		}

		//Laravel validator
		$validator = Validator::make(Input::all(), $rules);

		//If the form is valid
		if($validator->passes()){
			Auth::logout(); //Log out user if validator passes to clear any logged in user's info
			if($type == "login"){ //If user wanted to login
				if(Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))){
					//Check if email has been confirmed or not
					$confirmed = Auth::user()->confirmed;
					if($confirmed){
						//If confirmed redirect to dashboard
						return Redirect::route('dashboard');
					}else{
						//If email hasn't been confirmed, send user back to login screen asking to confirm email.
						return Redirect::route('login')
							->with('message', 'Your email has not been confirmed yet. Please check your email and click on the confirmation link to activate your account.')
							->withInput();
					}					
				}else{
					return Redirect::route('login')
						->with('warning', 'Your username/password combination was incorrect.')
						->withInput();
				}
			}else{ //If user wanted to register
				//Create User Object
				$user = new User();
				$user->email = Input::get('email');
				$user->firstname = Input::get('firstname');
				$user->lastname = Input::get('lastname');
				$user->confirmed = false;
				$user->password = Hash::make(Input::get('password'));
				$user->encryptiontoken = Input::get('encryption_token');
				$confirmtoken = Crypt::encrypt(Input::get('email'));
				$user->token = $confirmtoken;

				//Write DB
				$user->save();

				//TODO: Need to setup a system to send confirmation email
				$emaildata['confirmurl'] = URL::route('confirm', $confirmtoken);
				Mail::send('emails.welcome', $emaildata, function($message){
					$message->to(Input::get('email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Welcome to Host Login!');
				});

				//Create view saying registration was successful
				$data['page'] = 'registrationsuccess';
				$data['remail'] = Input::get('email');
				return View::make('accounts/rsuccessmsg', $data);
				
			}
		}else{ //If form is invalid, send them back to form with errors
			if($type == "login"){
				return Redirect::route('login')->withErrors($validator)->withInput();
			}else{
				return Redirect::route('register')->withErrors($validator)->withInput();
			}
		}
	}

	/*
	Handles Confirmations
	
	@filename: LoginController.php
	*/

	public function confirmEmail($token){
		$user = User::where('token', '=', $token)->firstOrFail();
		$user->confirmed = true; //Set confirmed flag to true
		$user->save();

		//Redirect to login page with message
		return Redirect::route('login')
			->with('message', 'Your email ' . e($user->email) . ' has been confirmed, please login below.');
	}

	/*
	Simply Logs user out
	
	@filename: LoginController.php
	*/
		
	public function logoutUser(){
		Auth::logout();
		return Redirect::route('login')->with('message', 'You have been successfully logged out.');
	}
}