<?php

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
 Use: Uiavatar
=====================================================
*/

include ('engine/data/avatarconfig.php');

$row = $db->super_query( "SELECT * FROM " . USERPREFIX . "_users WHERE name = '{$user}'" );




if ( "" . $dleavatar_config['active'] . "" == "1") {

if (isset($_POST['color']) AND $_POST['bgcolor']){

    $color = preg_replace("/#/i", "", $_POST['color']);
    $bgcolor = preg_replace("/#/i", "", $_POST['bgcolor']);

$result = $db->query( "UPDATE " . USERPREFIX . "_users SET foto = 'https://ui-avatars.com/api/?name={$user}&color=$color&background=$bgcolor&size=" . $dleavatar_config['width'] . "&rounded=" . $dleavatar_config['rounded'] . "&format=" . $dleavatar_config['format'] . "' , color = '$color', bgcolor = '$bgcolor' WHERE name = '{$user}'" );

    if ($result == true){

$result = $db->query( "UPDATE " . USERPREFIX . "_users SET  color = '$color', bgcolor = '$bgcolor' WHERE name = '{$user}'" );

    }else{
        $db->query( "UPDATE " . USERPREFIX . "_users set foto='' WHERE user_id = '{$id}'" );
    }
}




if (isset($_POST['del_avatar'])) {

$del_avatar = $_POST['del_avatar'];

$del_avatar = $db->query( " UPDATE "  . USERPREFIX . "_users SET foto = '', bgcolor = '', color = ''");

if ($del_avatar == true) {

$db->query( " UPDATE "  . USERPREFIX . "_users SET foto = '', bgcolor = '', color = ''");
} else {

    $db->query( "UPDATE " . USERPREFIX . "_users SET foto = 'https://ui-avatars.com/api/?name={$user}&color=" . $row['color'] . "&background=" . $row['bgcolor'] . "&size=" . $dleavatar_config['width'] . "' , color = '$color', bgcolor = '$bgcolor' WHERE name = '{$user}'" );
}
}
}







if ($row['color']) {
    $tpl->set( '{color}', "#" . $row['color'] . "" );
} else {
    $tpl->set( '{color}', "" . $dleavatar_config['color'] . "" );
}

if ($row['bgcolor']) {
    $tpl->set( '{bgcolor}', "#" . $row['bgcolor'] . "" );
} else {
    $tpl->set( '{bgcolor}', "" . $dleavatar_config['bgcolor'] . "" );
}






if ( "" . $dleavatar_config['active'] . "" == "1" AND "" . $dleavatar_config['editactive'] . "" == "1") {
        
        $tpl->set( '{ui-avatar}',  "<li class=\"form-group\">
                                <label for=\"color\">Text Color</label><input name=\"color\" type=\"color\" value=\"#" . $row['color'] . "\" /><li><li class=\"form-group\">
                                <label for=\"bgcolor\">Background</label><input name=\"bgcolor\" type=\"color\" value=\"#" . $row['bgcolor'] . "\" /><li><li class=\"form-group\">
                                <div class=\"checkbox\"><input type=\"checkbox\" name=\"del_avatar\" id=\"del_avatar\" value=\"yes\" /> <label for=\"del_avatar\">Remove avatar</label></div>
                            <li>" );
    
        
    } else {
        
        $tpl->set( '{ui-avatar}', '<span style="color:#ff3d00">The module is either turned off or the user has no right to change the configuration</span>' );
    }

?>





