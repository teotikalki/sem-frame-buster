<?php
/*
Plugin Name: Frame Buster
Plugin URI: http://www.semiologic.com/software/frame-buster/
Description: Thwarts any attempt to load your site in a frame.
Version: 5.1
Author: Denis de Bernardy, Mike Koepke
Author URI: http://www.getsemiologic.com
Text Domain: sem-frame-buster
Domain Path: /lang
License: Dual licensed under the MIT and GPLv2 licenses
*/

/*
Terms of use
------------

This software is copyright Denis de Bernardy & Mike Koepke, and is distributed under the terms of the MIT and GPLv2 licenses.
**/

class sem_frame_buster {

	public function __construct() {
		add_action('wp_footer', array($this, 'kill_frame') );
	}
	/**
	 * kill_frame()
	 *
	 * @return void
	 **/

	function kill_frame() {
		if ( is_preview() )
			return;

		$home_url = strtolower(get_option('home'));

		echo <<<EOS

	<script type="text/javascript">
	<!--
	try {
		var parent_location = new String(parent.location);
		var top_location = new String(top.location);
		var cur_location = new String(document.location);
		parent_location = parent_location.toLowerCase();
		top_location = top_location.toLowerCase();
		cur_location = cur_location.toLowerCase();

		if ( top_location != cur_location && parent_location.indexOf('$home_url') != 0 )
			top.location.href = document.location.href;
	} catch ( err ) {
		top.location.href = document.location.href;
	}
	//-->
	</script>

EOS;
	} # kill_frame()
}
