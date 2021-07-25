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
	public function action_index($image_path = "default")
	{
		$request_timestamp = time();

		$aws_public_domain = "http://ec2-54-250-192-112.ap-northeast-1.compute.amazonaws.com/";

		// 分析API call
		$params = array("image_path" => $image_path);
		$url = $aws_public_domain . "/index.php/api/analysis.json";
		$response = $this->call_api($params, $url);

		// データ登録 API call
		$params = array();
		$params["image_path"] = $image_path;
		$params["success"]    = $response->success;
		$params["message"]    = $response->message;
		$params["class"]      = $response->estimated_data->class;
		$params["confidence"] = $response->estimated_data->confidence;
		$params["request_timestamp"]  = $request_timestamp;
		$params["response_timestamp"] = time();

		$url = $aws_public_domain . "/index.php/api/regist.json";
		$insert_result = $this->call_api($params, $url);
		$data = array();
		if($insert_result[1] > 0){
			$data["insert_result"] = "成功";
		} else {
			$data["insert_result"] = "失敗";
		}

		$query= DB::select()->from(self::table_name)->order_by('id', 'desc');
		$results=$query->execute();

		$data["image_path"] = $image_path;
		$data['results']    = $results->as_array();
		
		return Response::forge(View::forge('welcome/index', $data));
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

	// call api
	private function call_api($params, $curl)
	{
		$curl=curl_init($curl);
		curl_setopt($curl,CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);  // オレオレ証明書対策
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);  // 
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
		curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

		// URLの情報を取得
		$response = curl_exec($curl);

		// セッションを終了
		curl_close($curl);

		return json_decode($response);
	}
}
