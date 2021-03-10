<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data['title'] = ucfirst("home"); // Capitalize the first letter
		$data['isi'] = "home"; 
		return view('main-layout/wraper',$data);
	}
	
	public function login()
	{
		$data['title'] = ucfirst("login"); // Capitalize the first letter
		return view('login',$data);
	}
	
	public function any($data1 ='', $data2='', $data3='', $data4='', $data5='', $data6='')
	{
		switch ($data1) {
			case "index":
				$this->index();
				break;
			case "login":
				$this->login();
				break;
			default :
				echo $data1;
		}

	}
}
