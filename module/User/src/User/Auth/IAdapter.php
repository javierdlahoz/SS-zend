<?php

namespace User\Auth;

interface IAdapter {
	
	public function login($request);
	
	public function logout();
}
