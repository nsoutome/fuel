<?php

class Controller_Hw extends Controller {

	public function action_index()
	{
		echo 'Hello World!';
	}

	public function action_buddy($name = 'buddy')
	{
		return Response::forge(View::forge('hello', array('name' => $name)));
	}
}
