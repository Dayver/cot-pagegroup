<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.delete.done
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

$pag_grp_without_del_pag = $db->query("SELECT * FROM $db_pages WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$id.".%'")->fetch();
if ($pag_grp_without_del_pag)
{
	$db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = REPLACE(page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '".$id.".', '".$pag_grp_without_del_pag['page_id'].".') WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$id.".%'");
}
