<?php  
if (!defined('DATALIFEENGINE'))
	die("Go fuck yourself!");
	include ('engine/data/avatarconfig.php');
if ( "" . $dleavatar_config['active'] . "" == "1") {

$uiavatar  = array(
	$userName  = $member_id['name'];
	'color' => !empty($color) ? $color : preg_replace("/#/i", "", $dleavatar_config['color']),
	'bgcolor' => !empty($bgcolor) ? $bgcolor : preg_replace("/#/i", "", $dleavatar_config['bgcolor']),
	'size' => !empty($size) ? $size : "" . $dleavatar_config['width'] . "",
	'rounded' => !empty($rounded) ? $rounded : "" . $dleavatar_config['rounded'] . "",
	'format' => !empty($format) ? $format : "" . $dleavatar_config['format'] . "",
	'cachePrefix' => !empty($cachePrefix) ? $cachePrefix : 'archives',
	'cacheSuffix' => !empty($cacheSuffix) ? true : false
);
$cacheName = md5(implode('_', $uiavatar));
$dleavatar  = true;
$dleavatar  = dle_cache($uiavatar['cachePrefix'], $cacheName . $config['skin'], $uiavatar['cacheSuffix']);
if (!$dleavatar) {
	$img = "https://ui-avatars.com/api/?name=". $uiavatar['userName'] . "&color=" . $uiavatar['color'] . "&background=" . $uiavatar['bgcolor'] . "&size=" . $uiavatar['size'] . "&rounded=" . $uiavatar['rounded'] . "&format=" . $uiavatar['format'] . "";
	$dleavatar = $img;
	create_cache($uiavatar['cachePrefix'], $dleavatar, $cacheName . $config['skin'], $uiavatar['cacheSuffix']);
}
echo $dleavatar;
}
else {

	echo'<span style="color:#ff3d00">The module is either turned off or the user has no right to change the configuration</span>' ;
}
?>
