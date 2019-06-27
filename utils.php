<?

    function req($name, $default = '')
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    }

    function cookie($name, $default = '')
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    function set_cookie($name, $val)
    {
    	setcookie ( $name, $val, time()+60*60*24*2, "/" );
    }

    function sess($name, $val = null)
    {
    	if($val !== null)
    		$_SESSION[$name] = $val;

    	return $_SESSION[$name];
    }

    function clear_string($s)
    {
    	return preg_replace('/[\<\>&]/', '', $s);
    }

    function clear_phone()
    {
    	return preg_replace('/\D/', '', $s);
    }

    function start_session()
    {
        session_start(['cookie_lifetime' => 48*3600]);
    }
