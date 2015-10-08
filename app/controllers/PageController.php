<?php

class PageController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome()
	{
		$data['page'] = 'Home';
		return View::make('pages/home', $data);
	}

	public function showPage($page){
		$data['page'] = ucfirst($page);
		if(View::exists('pages/' . $page)){
			return View::make('pages/' . $page, $data);
		}else{
			return App::abort(404);
		}
	}

	public function showImage($image) {
		if(file_exists(app_path() . "/assets/images/$image.png")){
			$response = Response::make(file_get_contents(app_path() . "/assets/images/$image.png"), 200);	
			$response->headers->set('Content-Type', 'image/png');
			return $response;		
		}else{
			App::abort(404);			
		}
	}

	public function showAsset($asset) {
		if(file_exists(app_path() . "/assets/files/$asset")){
			$response = Response::make(file_get_contents(app_path() . "/assets/files/$asset"), 200);	
			if(substr($asset, -3) == 'css'){
				$response->headers->set('Content-Type', 'text/css');
			}elseif(substr($asset, -2) == 'js'){
				$response->headers->set('Content-Type', 'text/javascript');				
			}
			return $response;		
		}else{
			App::abort(404);			
		}
	}

}