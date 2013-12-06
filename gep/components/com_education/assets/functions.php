<?php
/**
 * Get PostData
 * @return Array of PostData
 */
	function getPostData(){

	//	echo "getPostData";exit;

		include_once(JPATH_ROOT . DS . 'components' . DS . 'com_education' . DS . 'assets' .DS. 'JSON.php');
		$json = new Services_JSON();
		# build an array of args
		$args = array();
		$argCount = 0;

			# All POST data that are meant to be send to the function will
			# be appended by 'arg' keyword. Only pass this vars to the function
			foreach($_REQUEST as $key => $postData)
			{
				if(substr($key, 0, 3) == 'arg' )
				{
					//if ( get_magic_quotes_gpc() ) {
						$postData = stripslashes($postData);
					//}


					$postData = nl2brStrict($postData);
					//var_dump($postData);exit;
					$decoded = $json->decode($postData);
					$key = "";
					$val = "";

					// print_r($decoded);
					// exit;

					# if the args is an array, we need to pass it as an array
					# todo@ we need to expand this array further. We now assume,
					# if an array is passed, it comes in a pair of (key/value)
					if(is_array($decoded))
					{
						foreach($decoded as $index => $value)
						{
							$tempArray	= array();

							if( is_array($value) )
							{
								foreach($value as $val)
								{


									// The value is an array so we need to chuck them in
									// a multidimensional array instead
									if( is_array($val) )
									{
										// Since the values here are array, we will
										// always assume that the index 0 is always the key
										$key	= $val[0];
										$data	= br2nl( rawurldecode($val[1]) );

										// We will also always assume that the index 1 will be the value
										$decoded[$key][]	= $data;
									}
									else
									{
										// We always assume that the index 0 is the key of the array.
										$key	= $value[0];

										// We always assume that the index 1 is the data of the array.
										$data	= br2nl(rawurldecode($value[1]));

										if( substr($value[0], 0, 6) == '_d_' )
										{
											$decoded = array($val);
										}
										else
										{
											$newArray	= array( $key => $data );
											$decoded	= array_merge( $decoded, $newArray );
											//$newA		= array($key => $val);
											//$decoded	= array_merge($decoded, $newA);
										}
									}
								}
							} else{
								// If data passed is not array we treat
								if($value != '_d_' ){
									$decoded = br2nl(rawurldecode($value));
								}
							}
						}

						$args[] = $decoded;
					} else {
						$args[] = br2nl(rawurldecode($decoded));
					}
					$argCount++;
				}
			}

	return $args;
	}
	function nl2brStrict($text) {
		return preg_replace("/\r\n|\n|\r/", " <br />", $text);
	}

	function br2nl($text){
		$text = str_replace(' <br />', "\n", $text);
		return _fixQuote($text);
	}

	function _fixQuote($text){
		return str_replace('&quot;', '"', $text);
	}

	function singleLineIt($text){
		return preg_replace("((\r\n)+)", '', $text);
	}
	/**
	 * The function to convert to date format for a array value
	 **/
	function formatdata( $value )
	{
		$finalvalue = '';

		if(is_array($value))
		{
			if( empty( $value[0] ) || empty( $value[1] ) || empty( $value[2] ) )
			{
				$finalvalue = '';
			}
			else
			{
				$day	= intval($value[0]);
				$month	= intval($value[1]);
				$year	= intval($value[2]);

				$day 	= !empty($day) 		? $day 		: 1;
				$month 	= !empty($month) 	? $month 	: 1;
				$year 	= !empty($year) 	? $year 	: 1970;

				$finalvalue	= $year . '-' . $month . '-' . $day . ' 23:59:59';
			}
		}

		return $finalvalue;
	}
	function isMine($id1, $id2) {
		//echo $id1.'='.$id2;
		return ($id1 == $id2) && (($id1 != 0) || ($id2 != 0) );
	}

	function isRegisteredUser(){
		$my =& JFactory::getUser();
		return (($my->id != 0) && ($my->block !=1));
	}

	/**
	 *  Determines if the currently logged in user is a super administrator
	 **/
	function isSuperAdministrator()
	{
		return isContestantAdmin();
	}

	/**
	 * Check if a user can administer the contestant
	 */
	function isContestantAdmin($userid = null)
	{
		$my	= JFactory::getUser($userid);
		return ( $my->usertype == 'Super Administrator' || $my->usertype == 'Administrator' || $my->usertype == 'Manager' );
	}
	/**
	 * Check if a user can administer the contestant
	 */
	function isManager($userid = null)
	{
		$my	= JFactory::getUser($userid);
		return ( $my->usertype == 'Super Administrator' || $my->usertype == 'Administrator');
	}
	/*
	 * Check if a user is a candidate
	 * */
	function isCandidate($userId){
		$db =& JFactory::getDBO();
		$sql = "SELECT `id` FROM #__contestants_candidates WHERE `userid`=" . $db->Quote($userId);
		$db->setQuery($sql);

		$result = $db->loadResult();

		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		//var_dump($result);exit;

		return (int)$result;
	}
	function logoutAction(){
		global $mainframe;
			$user =& JFactory::getUser();
			if($user->get('id') && $mainframe->logout() )
			{
				return true;
			}
			return false;
		}
	function checkUserBalance($id)
	{
		$db =& JFactory::getDBO();
		$query = " SELECT balance FROM #__credits WHERE id='$id'";
		$db->setQuery($query);
		$result = $db->loadResult();

		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		//var_dump($result);exit;

		return (int)$result;
	}
	function addCredits(){
		$my = &JFactory::getUser();
		?>
		<div id="gift-container" class="hide_div">
		 	<div id="gift-content">
		Bạn đã không còn $ để upload hình ảnh. Hãy nhắn tin <span style="color:red"><strong>PLAY</strong></span> gửi đến <span style="color:red"><strong>6758</strong></span> (15000đ/tin nhắn) để nhận mã số dùng để được 15$ </span>.
		        <form enctype="multipart/form-data" id="creditform" action="" method="post">

				<span id="info_msg"></span>
				<p>
		        Mã code: <input type="text" class="paycode_class" id="paycode_id" name="paycode_name" value="" size="10"/>
				<input type="button" onclick="mm.credits.addCredits(<?php echo $my->id;?>)" value="Nạp" />

		        </p>
		        </form>
			</div>
		</div>
		<?php
	}

	/**
	* Update the view number of the candidate
	*
	* @param int $userId The user id
	* @return none
	*/

	function updateCanView( $userId ){

			$db =& JFactory::getDBO();

			//echo $userId;exit;

			//echo $curYear;exit;
			$view = checkupdateCanView($userId) + 1;

			if( $view > 1 ){
				 $query = 'UPDATE #__contestants_candidates SET'
	            	. '`view`='.$db->Quote($view)
	            	. ' WHERE `userid` ='.$db->Quote($userId)
	            	;
			}else{
            //@todo escape code
	         $query = 'UPDATE #__contestants_candidates SET'
	            	. ' `view`= 1'
	            	. ' WHERE `userid` ='.$db->Quote($userId)
	            	;
	        }
	       // echo $query;
            $db->setQuery($query);
            $db->query();
            if ($db->getErrorNum())
            {
                JError::raiseError(500, $db->stderr());
            }
	}
	/**
	* check for how much the view of the current user
	*
	* @param int $userId The user id
	* @return none
	*/
	function checkupdateCanView( $userId ){

			$db	=& JFactory::getDBO();

			$query = 'SELECT view'
			. ' FROM '.$db->nameQuote( '#__contestants_candidates' )
			. ' WHERE userid = '.$userId;

			$db->setQuery( $query);
			$row = $db->loadObject();
			$view = $row->view;
			//echo $id;exit;
			return (int)$view;
	}

	/**
	* check for how many times this ip address registered
	*
	* @param int $ipAdress of a computer
	* @return the times to register
	*/
	function checkTimeOfIpaddress(){

			$db	=& JFactory::getDBO();

			$ipAddress		= $_SERVER['REMOTE_ADDR'];

			$query = 'SELECT times'
			. ' FROM '.$db->nameQuote( '#__contestants_ip_check' )
			. ' WHERE ip_address = \''.$ipAddress.'\'';

			$db->setQuery( $query);
			$row = $db->loadObject();
			$times = $row->times;
			//echo $id;exit;
			return (int)$times;
	}

	function mo ($g, $l) {
		return $g - ($l * floor ($g/$l));
	}
	function powmod ($base, $exp, $modulus){
		$accum = 1;
		$i = 0;
		$basepow2 = $base;
		while (($exp >> $i)>0) {
			if ((($exp >> $i) & 1) == 1) {
				$accum = mo(($accum * $basepow2) , $modulus);
			}
			$basepow2 = mo(($basepow2 * $basepow2) , $modulus);
			$i++;
		}
		return $accum;
	}
	function PKI_Encrypt ($m, $e, $n){
		$asci = array ();
		for ($i=0; $i<strlen($m); $i+=3) {
			$tmpasci="1";
			for ($h=0; $h<3; $h++) {
				if ($i+$h <strlen($m)) {
					$tmpstr = ord (substr ($m, $i+$h, 1)) - 30;
					if (strlen($tmpstr) < 2) {
						$tmpstr ="0".$tmpstr;
					}
				} else {
					break;
				}
				$tmpasci .=$tmpstr;
			}
			array_push($asci, $tmpasci."1");
		}
		$coded = '';
		for ($k=0; $k< count ($asci); $k++) {
			$resultmod = powmod($asci[$k], $e, $n);
			$coded .= $resultmod." ";
		}
		return trim($coded);
	}
	function getStatusByTime(){
		//Set dates arrays for the Top Model Online Contestant


		$round2_time = array('start'	=> '2012-03-07 00:00:00',
							'end'	=>'2012-03-21 23:59:59'
		);
		$round3_time = array('start'	=> '2012-03-21 00:00:00',
							'end'	=>'2012-04-04 23:59:59'
		);
		$round4_time = array('start'	=> '2012-04-04 00:00:00',
							'end'	=>'2012-04-08 23:59:59'
		);
		$round5_time = array('start'	=> '2012-04-08 00:00:00',
							'end'	=>'2012-05-02 23:59:59'
		);
		$round6_time = array('start'	=> '2012-05-02 00:00:00',
							'end'	=>'2012-05-16 23:59:59'
		);
		$times = array($round1_time,$round2_time,$round3_time,$round4_time,$round5_time,$round6_time);

		$today = date('Y-m-d H:i:s');
		$today_strtotime = strtotime($today);
		$status = 1;

		for ($i=0; $i<6; $i++){

			//var_dump($times[0]['start']);exit;

			if( $today_strtotime < strtotime($times[1]['start']) ){
				$status = 1;
			}
			if( ( $today_strtotime > strtotime($times[1]['start']) ) and ( $today_strtotime < strtotime($times[2]['start']) ) ){
				$status = 2;
			}
			if( ( $today_strtotime > strtotime($times[2]['start']) ) and ( $today_strtotime < strtotime($times[3]['start']) ) ){
				$status = 3;
			}
			if( ( $today_strtotime > strtotime($times[3]['start']) ) and ( $today_strtotime < strtotime($times[4]['start']) ) ){
				$status = 4;
			}
			if( ( $today_strtotime > strtotime($times[4]['start']) ) and ( $today_strtotime < strtotime($times[5]['start']) ) ){
				$status = 5;
			}
			if( ( $today_strtotime > strtotime($times[5]['start']) ) and ( $today_strtotime < strtotime($times[6]['start']) ) ){
				$status = 6;
			}
		}
		$status = 1;
		//echo $status;
		return $status;
	}
	function getLastFirstName($name){

			//echo $name;
			$name = trim($name);
			list( $fname, $mname, $lname ) = explode( ' ', $name, 3 );
			if ( is_null($lname) ) //Meaning only two names were entered...
			{
				$lastname = $mname;
			}
			else
			{
				$lname = explode( ' ', $lname );
				$size = sizeof($lname);
				$lastname = $lname[$size-1];
			}
		//echo "First Name: $fname, Last Name: $lastname";exit;
		//echo $fname.' '.$lastname;
		return $fname.' '.$lastname;
	}
?>