<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.query
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

$pag_grp_need_grouped = false;
if (!empty($cfg['plugin']['pagegroup']['category']))
{
	$pag_grp_cats = explode(',', $cfg['plugin']['pagegroup']['category']);
	foreach ($pag_grp_cats as $pag_grp_cat)
	{		if (!empty($pag_grp_cat))
		{			if ($pag_grp_cat == $c)
			{
				$pag_grp_need_grouped = true;
				break;
			}			$pag_grp_catsub = cot_structure_children('page', $pag_grp_cat);			if (in_array($c, $pag_grp_catsub))
			{				$pag_grp_need_grouped = true;
				break;
			}
		}
	}
}
else $pag_grp_need_grouped = true;
if (empty($sql_page_string) && $pag_grp_need_grouped && isset($cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]))
{
	$where = array_filter($where);
	$where = ($where) ? 'WHERE ' . implode(' AND ', $where) : '';
	$sql_page_count = "SELECT COUNT(DISTINCT p.page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].") FROM $db_pages as p $join_condition $where";
	$sql_page_string = "SELECT p.*, COUNT(p.page_id) AS page_in_group_count, SUBSTRING_INDEX(p.page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '.', 1) AS page_group_main_pag_id, u.* $join_columns
		FROM $db_pages as p $join_condition
		LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
		$where
		GROUP BY page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']."
		ORDER BY $orderby LIMIT $d, ".$cfg['page']['maxrowsperpage'];
}
