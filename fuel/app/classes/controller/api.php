<?php
class Controller_Api extends Controller_Rest
{

	const table_name = "ai_analysis_log";

	// 分析API(スタブ)
	public function post_analysis() {
		// sleep(1);
		// Input::get('params')

		$confidence_list = array(0.000, 0.111, 0.222, 0.8683, 0.444, 0.555);
		$key = rand(0, 5);

		$list = array(
			"success"            => "true",
			"message"            => "success",
			"estimated_data"     => array(
									"class"       => $key,
									"confidence"  => $confidence_list[$key],
									)
		);

		// @TODO エラーレスポンス
		/*
			{
					"success": false,
					"message": "Error:E50012",
					"estimated_data": {}
			}

		*/

		// $this->responseに配列として設定する
		return $this->response($list,200);
	}

	// 登録API
	public function post_regist() {
		$params = array();
		$params["image_path"]         = Input::post("image_path");
		$params["success"]            = Input::post("success");
		$params["message"]            = Input::post("message");
		$params["class"]              = Input::post("class");
		$params["confidence"]         = Input::post("confidence");
		$params["request_timestamp"]  = Input::post("request_timestamp");
		$params["response_timestamp"] = Input::post("response_timestamp");
			
		$insert_result = DB::insert(self::table_name)->set($params)->execute();
		// $this->responseに配列として設定する
		return $this->response($insert_result,200);
	}

}
