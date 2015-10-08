<?php
class DashBoardController extends BaseController{

	/*
	Shows Dashboard
	
	@filename: DashBoardController.php
	*/

	//Show Preferences
	public function showPreferences(){
		$data['page'] = 'User Preferences';
		return View::make('dash.preferences', $data);
	}

	//Handle submitted preferences
	public function preferencesSubmit(){

		//Rules to validate data
		$rules = array(
		    'firstname'=>'required|alpha|min:2',
			'lastname'=>'required|alpha|min:2'
			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->passes()){ // If submitted data is valid

			//Get password & confirmation
			$password = Input::get('password');
			$password_confirmation = Input::get('password_confirmation');

			if($password != ''){ //If password is not empty & confirmation matches, change password of user
				if($password === $password_confirmation){
					Auth::user()->password = Hash::make(Input::get('password'));
				}else{
					//If password confirmation doesnt match, throw error
					return Redirect::route('preferences')->with('message', "Password Confirmation Doesn't Match");
				}
			}

			//Update first and last name
			Auth::user()->firstname = Input::get('firstname');
			Auth::user()->lastname = Input::get('lastname');
			
			//Save to database
			Auth::user()->save();

			return Redirect::route('preferences')->with('message', "Preferences Saved!");

		}else{
			return Redirect::route('preferences')->withErrors($validator);
		}
	}
	
	/*
	Shows dashboard
	
	@filename: DashBoardController.php
	*/
		
	public function showDashBoard(){
		$data['page'] = 'DashBoard';

		//Populate dashboard with user's servers
		$servers = Auth::user()->servers()->get();
		$data['servers'] = $servers;

		return View::make('dash.board', $data);
	}

	/*
	Show the add server page
	
	@filename: DashBoardController.php
	*/
		
	public function addServer(){
		$data['page'] = 'Add Server';
		return View::make('dash.addedit', $data);
	}

	/*
	Shows the edit page with some data forwarded from editServer 
	
	@filename: DashBoardController.php
	*/
		
	public function editServerReal(){
		if(!Session::has('servid')){ //If the page did not get serverid, abort
				return Redirect::route('dashboard')->with('message', 'No Server Chosen To Edit!');
		}else{
			$data['page'] = 'Edit Server';
			$data['servid'] = Session::get('servid'); //This will be flashed by editServer
			return View::make('dash.addedit', $data);
		}
	}

	/*
	Handles clicks when user presses edit server
	
	@filename: DashBoardController.php
	*/
		
	public function editServer($server){
		$sid = str_replace(Core::getSalt(), '', Crypt::decrypt($server));//Decrypt the server id from url
		$server = Server::find($sid); //Find the server in database
		if($server != ''){//If server exists
			if($server->user_id == Auth::user()->id){ //If the server is owned by the logged in user
				$form = Request::instance()->query; //This will get instance of Input::old

				//Put data from database to Input::old()
				$form->set('name', $server->name);
				$form->set('provider', $server->provider);
				$form->set('type', $server->type);
				$form->set('location', $server->location);
				$form->set('url', $server->url);
				$form->set('panel', $server->panel);
				$form->set('panelo', $server->panelo);
				$form->set('panellogin', $server->panellogin);
				$form->set('panelpassword', $server->panelpassword);
				$form->set('panelurl', $server->panelurl);
				$form->set('billingurl', $server->billingurl);
				$form->set('billinglogin', $server->billinglogin);
				$form->set('billingpassword', $server->billingpassword);
				$form->set('iswhmcs', $server->iswhmcs);
				$form->set('ip', $server->ip);
				$form->set('color', $server->color);
				$form->set('notes', $server->notes);
				$form->set('ram', $server->ram);
				$form->set('cost', $server->cost);
				$form->set('storage', $server->storage);
				$form->set('bandwidth', $server->bandwidth);
				
				return Redirect::route('editserverreal')->withInput()->with('servid', Crypt::encrypt($server->id));
			}else{
				return Redirect::route('dashboard')->with('message', 'Sorry, You Are Not Authorized To Edit This Server!');
			}
		}else{
			return Redirect::route('dashboard')->with('message', 'Sorry, The Server Does Not Exist!');
		}
	}

	/*
	Handles submit form on add server page
	
	@filename: DashBoardController.php
	*/
		
	public function addServerSubmit(){

		//Rules to verify data submitted, only name is required
		$rules = array(
			'name'=>'required|min:2'
		);

		//Validate data
		$validator = Validator::make(Input::all(), $rules);

		if($validator->passes()){

			//Check if user is editing or not by getting the isedit form data that will say on if its edit page
			$isEdit = Input::get('isedit');
			if($isEdit == ''){
				$server = new Server(); //Create new server if its new
			}else{
				$server = Server::find(Crypt::decrypt($isEdit)); //Find old server if its old
			}

			//Start populating form data to database
			$server->name = Input::get('name');
			$server->provider = Input::get('provider');
			$server->type = Input::get('type');
			$server->url = $this->fixURL(Input::get('url'));
			$server->location = Input::get('location');

			//Check if user chose other panel, if yes, handle it properly
			$panel = Input::get('panel');
			if($panel == 'Other') $panel = Input::get('panelo');
			$server->panel = $panel;

			//Fixurl will add http://to the beginning if it doesnt contain it
			$server->panelurl = $this->fixURL(Input::get('panelurl'));
			$server->panellogin = Input::get('panellogin');
			$server->panelpassword = Input::get('panelpassword');
			$server->billingurl = $this->fixURL(Input::get('billingurl'));

			//Check if the billing panel is whmcs
			$iswhmcs = 0;
			if(Input::get('iswhmcs') === 'on') $iswhmcs = 1;
			$server->iswhmcs = $iswhmcs;
			$server->billinglogin = Input::get('billinglogin');
			$server->billingpassword = Input::get('billingpassword');
			$server->location = Input::get('location');
			$server->ip = Input::get('ip');
			$server->color = Input::get('color');
			$server->notes = Input::get('notes');
			$server->storage = Input::get('storage');
			$server->ram = Input::get('ram');
			$server->cost = Input::get('cost');
			$server->bandwidth = Input::get('bandwidth');
			$server->user_id = Auth::user()->id;

			$server->save();

			return Redirect::route('dashboard')->with('message', 'Server Added Successfully!');
		}else{
			return Redirect::route('addserver')->withErrors($validator)->withInput();
		}
	}

	/*
	Handle delete server button
	
	@filename: DashBoardController.php
	*/
		
	public function deleteServerSubmit(){

		//Find sid by decrypting the post data
		$sid = str_replace(Core::getSalt(), '', Crypt::decrypt(Input::get('delete')));//Decrypt the server

		//Find server to delete
		$server = Server::find($sid);

		if($server != ''){ //If the server exists
			if($server->user_id == Auth::user()->id){ //Check oif the user owns the server
				$sname = $server->name;
				$server->delete();//Delete server
				return Redirect::route('dashboard')->with('message', 'Server ' . e($sname) . ' Deleted Successfully!');
			}else{
				return Redirect::route('dashboard')->with('message', 'Sorry, You Are Not Authorized To Delete This Server!');
			}
		}else{
			return Redirect::route('dashboard')->with('message', 'Sorry, The Server Does Not Exist!');
		}
			
	}

	public function showAccountSettings(){

	}

	//Method to add http to urls if it doesnt exist
	private function fixURL($url){
		if($url != ''){
			if (preg_match("#https?://#", $url) === 0) {
				$url = 'http://'.$url;
			}
		}		
		return $url;
	}
}