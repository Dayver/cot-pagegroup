<?php
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Info
 */

$L['info_desc'] = 'Collect page in groups';

/**
 * Plugin Config
 */

$L['cfg_category'] = array('Category codes', 'Comma separated, where need collect page in group. If empty then for all';
$L['cfg_extrfldnamegroup'] = array('Name of extra field', 'Page extra field for a page id and group specification for grouped<div id="addextrfd">
<button type="button">Create the specified extra field</button> If there is an extra field that will fill his the service information. That is, it is recommended to click this button in any case</div>';
$L['cfg_extrfldnamesforgroup'] = array('Extra fields names', 'Page extra fields names, comma separated, for a collect pages in group by his value';

/**
 * Plugin Admin
 */

$L['adm_pag_grp_add_field_hint'] = ' where <b>id</b> - identifier page for add pages in the group, and the <b>field</b> - a field in which there are differences, and will switch to the group<br /><i><ul><li>- <b>id</b> and <b>field</b> fill only if the page to be included in an existing group.</li><li> - If you want to create a group and this page will be the main in this group then only fill <b>field</b>.</li><li> - If the page does not belong to any group then <b>id</b> and <b>field</b> is left blank</li></ul></i>';
$L['adm_pag_grp_this_page'] = ' (this page)';
$L['adm_pag_grp_group'] = '<br />Group: ';
$L['adm_pag_grp_extr_field_ok'] = 'In the table of pages, this field is already there. All is well! You can go to <a href="/admin.php?m=extrafields&n=cot_pages" target="_blank" class="button">extrafields settings page</a> and enter your current <i>Values ??for select ... </i>';
$L['adm_pag_grp_extr_field_upd_ok'] = '<br />Filling in the service information is successful - where Nada was put down';
$L['adm_pag_grp_extr_field_added'] = 'Extrafield <b>%s</b> added to the table!<br />Go to <a href="/admin.php?m=extrafields&n=cot_pages" target="_blank" class="button">extrafields settings page</a> and enter your current <i>Values ??for select ... </i>';
$L['adm_pag_grp_extr_field_empty'] = 'You did not specify the name for the extra fields. Enter it, and then click <button type="button">Create specified extra field</button>';
$L['adm_pag_grp_extr_field_error'] = 'Error! Extra field is not added. Go to <a href="/admin.php?m=extrafields&n=cot_pages" target="_blank" class="button">extrafields settings page</a> and add it manually';

/**
 * Plugin Body
 */

//$L['pag_grp_help'] = '';
