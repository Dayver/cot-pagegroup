<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

cot_sendheaders();
require_once cot_incfile('page', 'module');
$a = cot_import('a', 'G', 'ALP');
if ($a == 'addextfield' && $usr['isadmin'])
{
	$name = cot_import('name', 'G', 'ALP');
	if (!empty($name))
	{
		if (isset($cot_extrafields[$db_pages][$name]))
		{
			echo $L['adm_pag_grp_extr_field_ok'];
			$sql_page = $db->query('UPDATE '.$db_pages.' SET page_'.$db->prep($name).' = page_id WHERE page_'.$db->prep($name).' IS NULL OR page_'.$db->prep($name).' = "" OR INSTR(page_'.$db->prep($name).', ".") = 0');
			if ($sql_page) echo $L['adm_pag_grp_extr_field_upd_ok'];
			else echo 'Error';
		}
		else
		{
			if(cot_extrafield_add($db_pages, $name, 'select', '', ',massa', '', false, 'HTML', 'Группировка id.field', ''))
			{
				echo sprintf($L['adm_pag_grp_extr_field_added'], $name);
				$sql_page = $db->query('UPDATE '.$db_pages.' SET page_'.$db->prep($name).' = page_id WHERE page_'.$db->prep($name).' IS NULL OR page_'.$db->prep($name).' = "" OR INSTR(page_'.$db->prep($name).', ".") = 0');
				if ($sql_page) echo $L['adm_pag_grp_extr_field_upd_ok'];
				else echo 'Error';
			}
			else echo $L['adm_pag_grp_extr_field_error'];
		}
	}
	else
	{
		echo $L['adm_pag_grp_extr_field_empty'];
	}
}
else
{
	if (cot_plugin_active('comments')) require_once cot_incfile('comments', 'plug');
	$id = cot_import('id', 'G', 'INT');
	$container_id = cot_import('container_id', 'G', 'INT');
	if ($id > 0 && $container_id > 0)
	{
		$sql_str = "SELECT p.*, SUBSTRING_INDEX(p.page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '.', 1) AS page_group_main_pag_id, u.* $join_columns
			FROM $db_pages AS p $join_condition
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
			WHERE page_id=".$id." LIMIT 1";
		$sql_page = $db->query($sql_str);
	}
	if(!$id || $sql_page->rowCount() == 0)
	{
		cot_die_message(404, TRUE);
	}
	$pag = $sql_page->fetch();
	if (strpos($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], '.') !== false)
	{
		$sql_page_count = "SELECT COUNT(*) FROM $db_pages WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]."'";
		$pag['page_in_group_count'] = $db->query($sql_page_count)->fetchColumn();
		$pag_grp_sql_id_list = $pag_grp_sql_field_list = $pag_grp_container_id_list = $pag_grp_rowset = array();
		$pag_grp_id = $pag_grp_field = '';
		if ($pag['page_in_group_count'] > 1)
		{
			$pag_grp_dot_pos = strpos($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], '.');
			if ($pag_grp_dot_pos !== false)
			{
				$pag_grp_id = substr($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], 0, $pag_grp_dot_pos);
				$pag_grp_field = substr($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], $pag_grp_dot_pos+1);
				if ($pag_grp_id && isset($cot_extrafields[$db_pages][$pag_grp_field]))
				{
					$pag_grp_sql_id_list[$pag_grp_id] = $pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']];
					$pag_grp_sql_field_list[$pag_grp_id] = $pag_grp_field;

					$pag_grp_container_id_list[$pag_grp_id] = $container_id;
				}
			}
		}
		if ($pag_grp_sql_id_list)
		{
			$sql_pag_grp =
			"SELECT p.*, SUBSTRING_INDEX(p.page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '.', 1) AS page_group_main_pag_id, CONCAT('page_', SUBSTRING_INDEX( p.page_group_id,  '.', -1 ) ) AS page_group_field_order, u.*
			FROM $db_pages as p
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
			WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." IN ('".implode("','", $pag_grp_sql_id_list)."')
			ORDER BY page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." ASC, page_group_field_order ASC";

			$grp_pag_sql_list = $db->query($sql_pag_grp);
			$grp_pag_sql_list_rowset = $grp_pag_sql_list->fetchAll();
			foreach ($grp_pag_sql_list_rowset as $pag_grp)
			{
				$pag_grp_id_main_page = array_search($pag_grp['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], $pag_grp_sql_id_list);
				$pag_grp_rowset[$pag_grp_id_main_page][$pag_grp['page_id']] = $pag_grp;

				$pag_grp_rowset[$pag_grp_id_main_page][$pag_grp['page_id']]['page_pag_grp_container_id'] = $pag_grp_container_id_list[$pag_grp_id_main_page];
			}
		}
		$pag_grp_marker = false;
	}
	$cat = &$structure['page'][$pag['page_cat']];
	$mskin = cot_tplfile(array('pagegroup', 'listrow', $cat['tpl']), 'plug');
	$t = new XTemplate($mskin);
	$t->assign(cot_generate_pagetags($pag, 'LIST_ROW_', $cfg['page']['truncatetext'], $usr['isadmin']));
	$t->assign('LIST_ROW_OWNER', cot_build_user($pag['page_ownerid'], htmlspecialchars($pag['user_name'])));
	$t->assign(cot_generate_usertags($pag, 'LIST_ROW_OWNER_'));
	/* === Hook === */
	foreach (cot_getextplugins('page.list.loop') as $pl)
	{
		include $pl;
	}
	/* ===== */
	$t->parse('MAIN.LIST_ROW');
	$t->parse('MAIN');
	$t->out('MAIN');
}
