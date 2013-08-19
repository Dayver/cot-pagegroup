<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.main
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('pagegroup', 'plug');
split_field_variants();

$pag_grp_arr = array();
$pag_grp_dot_pos = strpos($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], '.');
if (empty($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]))
{	$pag_grp_id = '';//$id}
elseif ($pag_grp_dot_pos !== false)
{	$pag_grp_id_sql = $pag_grp_id = substr($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], 0, $pag_grp_dot_pos);
	if ($pag_grp_id == $id) $pag_grp_id = '';
	$pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']] = substr($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']], $pag_grp_dot_pos+1);
	if (!empty($pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]))
	{
		$pag_grp_rows = $db->query("SELECT * FROM $db_pages WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$pag_grp_id_sql.".".$pag['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]."'")->fetchall();
		foreach ($pag_grp_rows as $pag_grp_row)
		{			if ($pag_grp_row['page_id'] != $id)
			{				$pag_grp_row_url_params = empty($pag_grp_row['page_alias']) ? array('c' => $pag_grp_row['page_cat'], 'id' => $pag_grp_row['page_id']) : array('c' => $pag_grp_row['page_cat'], 'al' => $pag_grp_row['page_alias']);
				$pag_grp_row_url = cot_url('page', $pag_grp_row_url_params, '', true);
				$pag_grp_arr[$pag_grp_row['page_id']] = '<a href="'.$pag_grp_row_url.'">#'.$pag_grp_row['page_id'].'</a>';//TODO: in resources
			}
			else $pag_grp_arr[$id] = '#'.$pag_grp_row['page_id'].$L['adm_pag_grp_this_page'];//TODO: in resources		}
	}
}
else
{	$pag_grp_id = '';//$id}
$str_grp_pag_row = $pag_grp_arr ? $L['adm_pag_grp_group'].implode(', ', $pag_grp_arr) : '';

$cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]['field_html'] = '<input type="text" name="{$name}_main_page_id" value="'.$pag_grp_id.'" maxlength="11" size="11" /><b>.</b>'.$cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]['field_html'].$L['adm_pag_grp_add_field_hint'].$str_grp_pag_row;//TODO: in resources
