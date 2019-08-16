<?php
if(osc_is_web_user_logged_in()){
echo "<h2>Hello ". osc_logged_user_name() ."</h2>";
} else if(osc_is_admin_user_logged_in()) {
echo "<h2>Hello ". osc_logged_admin_name() ."</h2>";
} else {
echo "<h2>Hello Guest</h2>";
}
osc_run_hook('dt_forum_header');
?>
