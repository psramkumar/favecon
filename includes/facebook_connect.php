<?php
	/********************
     FaveCon AddressBook
    *********************
    Copyright (C) 2010-2011 Daniel Mühlbachler
    
    FaveCon AddressBook is a contact management system with Google Maps and Facebook Integration (if you have API keys for it!).
	
	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    *********************
     Contact Information
    *********************
    To contact the developer of this program visit: http://www.muehlbachler.org
	
	*/
?>

<?php
	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => $user->settings['fb_app_id'],
	  'secret' => $user->settings['fb_secret'],
	  'cookie' => true,
	));
	
	// We may or may not have this data based on a $_GET or $_COOKIE based session.
	//
	// If we get a session here, it means we found a correctly signed session using
	// the Application Secret only Facebook and the Application know. We dont know
	// if it is still valid until we make an API call using the session. A session
	// can become invalid if it has already expired (should not be getting the
	// session back in this case) or if the user logged out of Facebook.
	$session = $facebook->getSession();
	
	$me = null;
	// Session based API call.
	if ($session) {
	  try {
		$uid = $facebook->getUser();
		$me = $facebook->api('/me');
	  } catch (FacebookApiException $e) {
		error_log($e);
	  }
	}
?>
	<!--
    We use the JS SDK to provide a richer user experience. For more info,
    look here: http://github.com/facebook/connect-js
    -->
    <tr style='display:none;'><td colspan='10'><div id="fb-root"></div></td></tr>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });
             // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
       });
    </script>

<?php
	if(!$me)
	{
?>
	<script type="text/javascript">
		FB.login(function(response) {});
	</script>
<?php
	}
?>