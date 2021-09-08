<?PHP
/*
=====================================================
 Ticcix
-----------------------------------------------------
 https://github.com/Ticcix
-----------------------------------------------------
 Copyright (c) 2021 Ticcix
=====================================================
 This code is protected by copyright
=====================================================
 File: avatar.php
-----------------------------------------------------
 Use: Configure Dle  UI Avatar
=====================================================
*/

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

if( $member_id['user_group'] != 1 ) {
	msg( "error", $lang['index_denied'], $lang['index_denied'] );
}

require_once (ENGINE_DIR . '/data/avatarconfig.php');
require_once (DLEPlugins::Check(ENGINE_DIR . '/modules/ticcix/avatar/lang/' . $selected_language . '/ticcix.php'));


if( $action == "save" ) {

	if( $_REQUEST['user_hash'] == "" or $_REQUEST['user_hash'] != $dle_login_hash ) {
		
		die( "Hacking attempt! User not found" );
	
	}

	$db->query( "INSERT INTO " . USERPREFIX . "_admin_logs (name, date, ip, action, extras) values ('".$db->safesql($member_id['name'])."', '{$_TIME}', '{$_IP}', '78', '')" );
	
	$save_con = $_POST['save_con'];

	
	$find = array();
	$replace = array();
	
	$find[] = "'\r'";
	$replace[] = "";
	$find[] = "'\n'";
	$replace[] = "";
	
	$save_con = $save_con + $dleavatar_config;
	
	$handler = fopen( ENGINE_DIR . '/data/avatarconfig.php', "w" );
	
	fwrite( $handler, "<?PHP \n\n//DLE Avatar Configurations\n\n\$dleavatar_config = array (\n\n" );
	foreach ( $save_con as $name => $value ) {
		
		$value = trim(strip_tags(stripslashes( $value )));
		$value = htmlspecialchars( $value, ENT_QUOTES, $config['charset']);
		$value = preg_replace( $find, $replace, $value );
			
		$name = trim(strip_tags(stripslashes( $name )));
		$name = htmlspecialchars( $name, ENT_QUOTES, $config['charset'] );
		$name = preg_replace( $find, $replace, $name );
		
		$value = str_replace( "$", "&#036;", $value );
		$value = str_replace( "{", "&#123;", $value );
		$value = str_replace( "}", "&#125;", $value );
		$value = str_replace( ".", "", $value );
		$value = str_replace( '/', "", $value );
		$value = str_replace( chr(92), "", $value );
		$value = str_replace( chr(0), "", $value );
		$value = str_replace( '(', "", $value );
		$value = str_replace( ')', "", $value );
		$value = str_ireplace( "decode", "dec&#111;de", $value );
		
		$name = str_replace( "$", "&#036;", $name );
		$name = str_replace( "{", "&#123;", $name );
		$name = str_replace( "}", "&#125;", $name );
		$name = str_replace( ".", "", $name );
		$name = str_replace( '/', "", $name );
		$name = str_replace( chr(92), "", $name );
		$name = str_replace( chr(0), "", $name );
		$name = str_replace( '(', "", $name );
		$name = str_replace( ')', "", $name );
		$name = str_ireplace( "decode", "dec&#111;de", $name );
		
		fwrite( $handler, "'{$name}' => '{$value}',\n\n" );
	
	}
	fwrite( $handler, ");\n\n?>" );
	fclose( $handler );
	
	clear_cache();
	
	if (function_exists('opcache_reset')) {
		opcache_reset();
	}
	
	msg( "success", $lang['opt_sysok'], $lang['opt_sysok_1'], "?mod=avatar" );
}



	echoheader( "<i class=\"fa fa-user-circle-o position-left\"></i><span class=\"text-semibold\">{$ena['header_me_1']}</span>", $ena['opt_vconf'] );

function showRow($title = "", $description = "", $field = "", $class = "") {
	echo "<tr>
       <td class=\"col-xs-6 col-sm-6 col-md-7\"><div class=\"media-heading text-semibold\">{$title}</div><span class=\"text-muted text-size-small hidden-xs\">{$description}</span></td>
       <td class=\"col-xs-6 col-sm-6 col-md-5\">{$field}</td>
       </tr>";
}

function makeCheckBox($name, $selected) {
	$selected = $selected ? "checked" : "";
	
	return "<input class=\"switch\" type=\"checkbox\" name=\"$name\" value=\"1\" {$selected}>";
}

function makeDropDown($options, $name, $selected) {
	$output = "<select class=\"uniform\" name=\"$name\">\r\n";
	foreach ( $options as $value => $description ) {
		$output .= "<option value=\"$value\"";
		if( $selected == $value ) {
			$output .= " selected ";
		}
		$output .= ">$description</option>\n";
	}
	$output .= "</select>";
	return $output;
}


echo <<<HTML
<form action="?mod=avatar&action=save" name="conf" id="conf" method="post">
<div class="panel panel-default">
  <div class="panel-heading">
    {$ena['opt_vconf']}
  </div>
  <div class="table-responsive">
  <table class="table table-striped">
      <thead>
      <tr>
        <th>{$ena['vconf_title']}</th>
        <th></th>
      </tr>
      </thead>
HTML;
showRow( $ena['sys_active'], $info['sys_active'], makeDropDown( array ("0" => "".$ena['no']."", "1" => "".$ena['yes']."" ), "save_con[active]", "{$dleavatar_config['active']}" ) );
showRow( $ena['sys_editactive'], $info['sys_editactive'], makeDropDown( array ("0" => "".$ena['no']."", "1" => "".$ena['yes']."" ), "save_con[editactive]", "{$dleavatar_config['editactive']}" ) );
	showRow( $ena['vconf_widhtd'], $info['vconf_widhtd'], "<input type=\"text\" name=\"save_con[width]\" value=\"{$dleavatar_config['width']}\" class=\"form-control\" style=\"max-width:150px; text-align: center;\">", "white-line" );
	showRow( $ena['vconf_color'], $info['vconf_color'], "<input type=\"color\" name=\"save_con[color]\" value=\"{$dleavatar_config['color']}\" class=\"form-control\" style=\"max-width:150px; height: 35px; text-align: center;\">", "white-line" );
	showRow( $ena['vconf_bgcolor'], $info['vconf_bgcolor'], "<input type=\"color\" name=\"save_con[bgcolor]\" value=\"{$dleavatar_config['bgcolor']}\" class=\"form-control\" style=\"max-width:150px; height: 35px; text-align: center;\">" );

	showRow( $ena['vconf_themeround'], $info['vconf_themeround'], makeDropDown( array ("false" => "".$ena['no']."", "true" => "".$ena['yes']."" ), "save_con[rounded]", "{$dleavatar_config['rounded']}" ) );

	showRow( $ena['vconf_format'], $info['vconf_format'], makeDropDown( array ("png" => "PNG", "svg" => "SVG" ), "save_con[format]", "{$dleavatar_config['format']}" ) );

echo <<<HTML
</table></div></div>
<div style="margin-bottom:30px;">
<input type="hidden" name="user_hash" value="{$dle_login_hash}" />
<button type="submit" class="btn bg-teal btn-raised position-left"><i class="fa fa-floppy-o position-left"></i>{$lang['user_save']}</button>
</div>

</form>
HTML;

if(!is_writable(ENGINE_DIR . '/data/avatarconfig.php')) {

	$lang['stat_system'] = str_replace ("{file}", "engine/data/avatarconfig.php", $lang['stat_system']);

	echo "<div class=\"alert alert-warning alert-styled-left alert-arrow-left alert-component\">{$lang['stat_system']}</div>";

}

echofooter();
?>




