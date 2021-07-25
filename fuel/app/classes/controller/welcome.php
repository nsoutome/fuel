<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

// use Model\Contents;

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends Controller
{
	const table_name = "ai_analysis_log";
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index($name = "default")
	{
		$data = array();
		$data["name"] = $name;

		// API call
		$call_result = $this->call_ai($name);

		// データ登録
		$insert_result = DB::insert(self::table_name)->set($call_result)->execute();
		if($insert_result[1] > 0){
			$data["insert_result"] = "成功";
		} else {
			$data["insert_result"] = "失敗";
		}

		$query= DB::select()->from(self::table_name)->order_by('id', 'desc');
		$results=$query->execute();


//		$query = Contents::get_list(10, 0);
//		print_r($query->as_array());

		// $data['results'] = $results;
		$data['results']    = $results->as_array();
		
		print_r($data);

		// return Response::forge(View::forge('welcome/index'));
		return Response::forge(View::forge('welcome/index', $data));
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}

	// call api スタブ
	private function call_ai($name)
	{
		$data = array(	"image_path"         => $name,
				"success"            => "true",
				"message"            => "success",
				"class"              => 3,
				"confidence"         => 0.8683,
				"request_timestamp"  => time(),
				"response_timestamp" => time()
		);
		return $data;
	}
}
