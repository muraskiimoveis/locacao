<?php

class Browser {


	function get_url($array) {

		/* defaults (there is no default for 'url' or 'content') */
		$robot_rules = TRUE; /* follow the robots.txt standard */
		$req_mthd = 'GET';
		$protocol = 'HTTP/1.0';
		$user_agent = 'PHP3 Browser';
		$time_out = 10;

		/* for each argument set in the array, overwrite default */
		while(list($k,$v) = each($array)) {
			$$k=$v;
		}

		/* set up the cookies.  If it exists, the straight variable
		   will be written above ($$k=$v). */

		if(is_array($cookies)) {
			$cookies2send = '';
			while(list($k,$v) = each($cookies) ) {
				$cookies2send .= "Cookie: $k=" . urlencode($v) . "\n";
			}
		}

	      if(!isset($url)) 
		return array("content"=>' ',"headers"=>' ',"errcode"=>-1,"errmsg"=>'Fatal Error: No URL defined');

              $parsed_url = parse_url("$url");

		if($robot_rules) { 

			$robots_url = $parsed_url["scheme"] . "://" . $parsed_url["host"];
			if($parsed_url["port"]) $robots_url .= ":" . $parsed_url["port"];
			$robots_url .= "/robots.txt";
		 if(!$this->robot_rules($url,$robots_url,$user_agent))
		   return array("content"=>' ',"headers"=>' ',"errcode"=>0,"errmsg"=>"Non-fatal Error: Robot Rules do not permit this browser to access $url");

		}

	      $req_mthd = strtoupper($req_mthd); // 2068 rfc says it's case sensitive.

              $host = $parsed_url["host"];

              if(!$host || $host=='' || !isset($host))
		array("content"=>' ',"headers"=>' ',"errcode"=>-1,"errmsg"=>'Fatal Error: No URL defined');

              $path = $parsed_url["path"];
              if(!$path || $path=='' || !isset($path))
		$path = "/";

              $query = $parsed_url["query"];
              if($query!='')
		$path = "$path?$query";

              if(!isset($parsed_url["port"])) {
               $port = 80;
              } else {
               $port = $parsed_url["port"];
              }

	 $timeout = time() + $time_out;

	 $fp = fsockopen("$host",$port,$errno,$errstring,$time_out);

	if(!$fp) {
		return array("content"=>' ',"headers"=>' ',"errcode"=>0,"errmsg"=>"Non-Fatal Error: Could not make connection to url $url (not found in DNS or you are not connected to the Internet)");
	} else {

	      set_socket_blocking($fp,0); // seems to work either way

	      $REQUEST = "$req_mthd $path $protocol\n";
	      if(eregi("^HTTP\/1\.[1-9]",$protocol)) $REQUEST .= "Host: $host\n";
	      $REQUEST .= "User-Agent: $user_agent\n";
		if($referer) {
			$REQUEST .= "Referer: $referer\n";
		}
	      $REQUEST .= "Connection: close\n";

		if($cookies) {
		 $REQUEST .= $cookies2send;
		}

		if($req_mthd=="POST") {
		 $REQUEST .= "Content-length: " . (strlen($content)) . "\n";
		 $REQUEST .= "Content-Type: application/x-www-form-urlencoded\n";
		 $REQUEST .= "\n$content\n";
		}
		fputs($fp,"$REQUEST\n"); // complete the request


		if($timeout<time())
			return array("content"=>' ',"headers"=>' ',"errcode"=>0,"errmsg"=>"Non-Fatal Error: Timed out while downloading page");
		while (!feof($fp) && time()<$timeout) {
		    $output = fgets($fp,255);
		    $view_output .= $output;

		          if(!isset($header)) {
			    if($output=="\n" || $output == "\r\n" || $output == "\n\l") {
	                         $header = $view_output;
  		                 $view_output = '';
			    }	
		          }

		}

	}

fclose($fp);

if(time()>$timeout)
	return array("content"=>"$content","headers"=>"$headers","errcode"=>0,"errmsg"=>"Non-Fatal Error: Timed out while downloading page");

return array("content"=>"$view_output","headers"=>"$header","errcode"=>1,"errmsg"=>"Success");

} // end function get_url










/* ************************************* */

function get_headers($h) {
  $array = explode("\n",$h);

   for($i=0;$i<count($array);$i++)  {
    if(  ereg("([A-Za-z]+)/([0-9]\.[0-9]) +([0-9]+) +([A-Za-z]+)",$array[$i],$r)  ) {
      $hdrs['version'] = trim($r[2]);
      $hdrs['status_code'] = (int)trim($r[3]);
      $hdrs['status_text'] = trim($r[4]);
    } elseif(ereg("([^:]*): +(.*)",$array[$i],$r)) {
     $hdr = eregi_replace("-","_",trim(strtolower($r[1])));
     $hdrs[$hdr] = trim($r[2]);
    }
   }

 return $hdrs;
} // end function get_headers










/* ************************************* */












function get_a_header($h,$w) {
  $w=strtolower($w);
  $array = explode("\n",$h);

   for($i=0;$i<count($array);$i++)  {
    if(  ereg("([A-Za-z]+)/([0-9]\.[0-9]) +([0-9]+) +([A-Za-z]+)",$array[$i],$r)  ) {
      $hdrs['version'] = $r[2];
      $hdrs['status_code'] = $r[3];
      $hdrs['status_text'] = $r[4];
    } elseif(ereg("([^:]*): +(.*)",$array[$i],$r)) {
     $hdr = eregi_replace("-","_",strtolower($r[1]));
     $hdrs[$hdr] = $r[2];
    }
   }

 return $hdrs[$w];
} // end function get_a_header










/* ************************************* */








function strip_html($string) {

  while(ereg("<[^>]*>",$string)) {
   $string = ereg_replace("<[^>]*>"," ",$string);
  }

  while(ereg("\t+",$string)) {
   $string = ereg_replace("\t+"," ",$string);
  }

  while(ereg("\n+",$string)) {
   $string = ereg_replace("\n+"," ",$string);
  }

  while(ereg("\r+",$string)) {
   $string = ereg_replace("\r+"," ",$string);
  }

  while(ereg("\l\r+",$string)) {
   $string = ereg_replace("\l\r+"," ",$string);
  }

  while(ereg(" {2,}",$string)) {
   $string = ereg_replace(" {2,}"," ",$string);
  }

 return $string; 
} // end function strip_tags









/* ************************************* */







 function full_time($l=0) {  
   $microtime = microtime();
   return doubleval(substr($microtime,0,10))  +  substr($microtime,11,10) + $l;  
  }







/* ************************************* */








function get_links($s,$url=''){ 

	if($url) {
	  $p = parse_url($url);
		if($p["port"]) { 
			$port = ":$p[port]";
		} else {
			$port = '';
		}
	}

 $copy = $s; // so we can return links and titles in their proper case
 $s = strtolower($s); // or else the strstr and strpos searches are case sensitive...
 $pos_start=strpos($s,"<a");

  while($pos_start) {
    $pos_close = strpos($s,"</a",$pos_start);
	if($pos_close) {
	   $pos_close += 4;
	} else {
	   break;
	}
    $array[] = substr( $copy , $pos_start , $pos_close-$pos_start );
    $pos_start=strpos($s,"<a",$pos_close);
  }

  for($i=0;$i<count($array);$i++) {
   eregi('href *= *"?([^" >]*)"?[^>]*>(.*)</a *>?',$array[$i],$r);

	if($url) {
	   if(!eregi("^mailto",$r[1])) {

		if(eregi("^(f|ht)tp",$r[1])) {
			/* full url */
			$this_url = $r[1];
		} elseif(eregi("^/",$r[1])) {
			/* absolute path, but not full url */
			$this_url = $p["scheme"] . "://" . $p["host"] . $port . $r[1];
		} else {
			if($p["path"] == "/" || $p["path"] == '') {
			/* relative link, but no url path */
				$this_url = $p["scheme"] . "://" . $p["host"] . $port . "/" .  $r[1];
			} else {
			/* relative link, with url path */
				if(ereg("/$",$p["path"])) {
				/* and the path ends in '/', so not a file */
					$this_url = $p["scheme"] . "://" . $p["host"] . $port . $p["path"] . $r[1];
				} else {
				/* and the path doesn't end in '/', so 
				   probably a file (but it *could* be 
				   a directory, we can't really know) */
					$remove = strrchr($p["path"],"/");
					$path = ereg_replace("$remove","/",$p["path"]);
					$this_url = $p["scheme"] . "://" . $p["host"] . $port . "$path" .  $r[1];

				}
			}

		}

	   $links[] = array($array[$i],$this_url,$r[2]);

	   }

	} else {

	   $links[] = array($array[$i],$r[1],$r[2]);

	}


  }

 return $links; /*
		 array[$i][0] = entire link,
		 array[$i][1] = link,
		 array[$i][2] = link title
		*/

} // end function get_links









/* ************************************* */










function get_page_title($s){ 

 if(eregi("<title *>([^<]*)</title *>",$s,$r)) {
  return $r[1];
 } else {
  return 0;
 }

} // end function get_page_title

/* ************************************* */







function get_meta_tags($s){ 


  while($s = strstr($s,"<meta")) {
    $pos_close = strpos($s,">") + 1;
    $array[] = substr( $s , 0 , $pos_close );
    $s=substr( $s , $pos_close  );
  }


  for($i=0;$i<count($array);$i++) {
   eregi('<meta +(name|httpd-equiv|http-equiv) *= *"?([^">]*)"? +content *= *"?([^">]*)[^>]*>',$array[$i],$r);
   $meta[strtolower($r[2])] = $r[3];
  }

 return $meta;

} // end function get_meta_tags









	function robot_rules ($url,$robots_url,$user_agent) {
 	 $a = $this->get_url(array("url"=>"$robots_url","robot_rules"=>FALSE));
 	 $h = $this->get_headers($a["headers"]); 

		if($h["status_code"]<200 || $h["status_code"] >299) return TRUE;
					// robots.txt doesn't exist, we can index

	    $lines = explode("\n",$a["content"]);


		for($i=0;$i<count($lines);$i++) {
			$entry = split(" *: *",$lines[$i]);
			$type = strtolower($entry[0]);
			$value = strtolower($entry[1]);

			if($type == "user-agent") $ua = $value;

			if($type == "disallow") {
				 $hash["$ua"]["$value"] = 1;
			}
		}

			if(is_array($hash["*"])) {
				while(list($k,$v) = each ($hash["*"])) {
					if(strpos($url,$k)>0) return FALSE;
				}
			}

			if(is_array($hash["$user_agent"])) {
				while(list($k,$v) = each ($hash["$user_agent"])) {
					if(strpos($url,$k)>0) return FALSE;
				}
			}

	 return TRUE;
	}	



} // End Browser Class

?>