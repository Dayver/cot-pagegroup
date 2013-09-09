<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.before_loop
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

if (!$sqllist_rowset_other)
{
	$pag_grp_sql_id_list = $pag_grp_sql_field_list = $pag_grp_container_id_list = $pag_grp_rowset = array();
	foreach ($sqllist_rowset as $pag)
	{
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

					$pag_grp_container_id_list[$pag_grp_id] = $pag['page_id'];
				}
			}
		}
	}
	if ($pag_grp_sql_id_list)
	{
		$sql_pag_grp =
			"SELECT p.*, SUBSTRING_INDEX(p.page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '.', 1) AS page_group_main_pag_id, CONCAT('page_', SUBSTRING_INDEX( p.page_group_id,  '.', -1 ) ) AS page_group_field_order, u.* $join_columns
			FROM $db_pages as p $join_condition
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
		function order_paggrp($a, $b)
		{
			global $order_field;
			return strnatcmp($a[$order_field], $b[$order_field]);
		}
		foreach($pag_grp_rowset as $k=>$v)
		{
			$order_field = 'page_'.$pag_grp_sql_field_list[$k];
			usort($pag_grp_rowset[$k], "order_paggrp");
		}
	}
	$pag_grp_marker = false;
}
