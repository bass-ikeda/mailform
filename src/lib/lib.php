<?php
//---------------------------------------------------------------------
// functions

# require( 'html.php' );


//
// get_param()
//	 ... get parameters from $_GET and $_POST
//
//	arg: array　[, array]... 
//
//	returns: array, with parameters; key => value
//
function get_param()
{
	$dup = array();	// ONLY to check parameters' name duplication
	
	foreach(func_get_args() as $args)
	{
		foreach ($args as $k => $v)
		{
			if(isset($dup[$k]))
			{
if(DEBUG)
{
	printf("parameter dup: %s // ToDo: warning reporting func.\n", $k);
}
			}
			$dup[$k] = TRUE;

			// pickup values by keys
			$raw ='';
		
			if(isset($_GET[$k])) {
				$raw = $_GET[$k];
				
			} elseif (isset($_POST[$k])) {
				$raw = $_POST[$k];
		}	

			// tiny validation
			$param[$k] = '';
			if(is_array($v)) {
						
				foreach($v as $canbe)
				{
					if($raw === $canbe)
					{
						$param[$k] = $canbe;
						break;
					}
				}
				continue;
			}

			switch (substr($v, 0, 1))
			{
				case '#':	// integer
					$param[$k] = html_int($raw);
					break;
				
				case 'S':	// strings
					$param[$k] = $raw;
					break;
				
				case 'W':	// strings (Word)
				default:
					$raw = preg_replace('/[^a-zA-Z0-9_,@\ \.\+\-\/]/', '', $raw);
					$param[$k] = $raw;
					break;
			}
		}
	}
	return $param;
}


//
// first_line()
//
//  arg:
//		$str, multiline
//
//	returns:
//		the first **valid** (with some strings) line of $str.
//
function first_line($str = '')
{
	foreach(explode("\n", $str) as $line)
	{
		$line = trim(mb_ereg_replace('/[\r\n]/', '', $line));
		if(mb_strlen($line))
		{
			return $line;
		}
	}
	return '';
}

//
// permalink()
//	 ... build permalink URL from parameters
//
//	arg:
//		$param : array, built by get_param(), with parameters; key => value
//
//	returns: URL, string
//
function permalink($param = array(), $exclude = array())
{
	$proto = 'http://';
	if(isset($_SERVER['HTTPS']))
	{
		$proto = 'https://';
	}
	$server = $_SERVER['SERVER_NAME'];
	
	$url = sprintf('%s%s%s', $proto, $server, $_SERVER['REQUEST_URI']);
	$queries = array();
	
	foreach ($param as $k => $v)
	{
		if(! isset($v) || '' === $v)
		{
			continue;
		}
		if(FALSE !== array_search($k, $exclude))
		{
			continue;
		}
		
		array_push($queries, sprintf('%s=%s', $k, rawurlencode($v)));
	}
	
	if(count($queries))
	{
		$url .= '?' . implode('&', $queries);
	}
	
	return $url;
}

//
// workdir_setup()
//	 ... setup working directory, under DIR_WORKAREA
//
//	arg: none
//
//	returns: none
//
function workdir_setup()
{
	$cmd = sprintf('mktemp -q -d --tmpdir=%s XXXXXXXXXXXX', DIR_WORKAREA);
	$dir_work = rtrim(`$cmd`);
	
	if(! chdir($dir_work))
	{
	    print "cannot chdir() into $dir_work";
	    exit(1);
	}
	
	chmod('.', 0750);
}