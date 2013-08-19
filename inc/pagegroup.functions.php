<?php
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('pagegroup', 'plug');

function split_field_variants()
{
	global $cfg, $cot_extrafields, $db_pages;

	if (!empty($cfg['plugin']['pagegroup']['extrfldnamesforgroup']))
	{
		$existing_fields = array(0 => '');
		$inputed_feilds = explode(',', $cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]['field_variants']);
		$pag_grp_extfields = explode(',', $cfg['plugin']['pagegroup']['extrfldnamesforgroup']);
		foreach ($inputed_feilds as $inputed_feild)
		{
			if (!empty($inputed_feild) && isset($cot_extrafields[$db_pages][$inputed_feild])) $existing_fields[] = $inputed_feild;
		}
		foreach ($pag_grp_extfields as $pag_grp_extfield)
		{
			if (!empty($pag_grp_extfield) && isset($cot_extrafields[$db_pages][$pag_grp_extfield]) && !in_array($pag_grp_extfield, $existing_fields)) $existing_fields[] = $pag_grp_extfield;
		}
		$cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]['field_variants'] = implode(',', $existing_fields);
	}
}

function pag_grp_value_import()
{
	global $cfg, $db, $id, $rpage;
	$pag_grp_main_page_id = cot_import('rpage'.$cfg['plugin']['pagegroup']['extrfldnamegroup'].'_main_page_id', 'POST', 'INT');
	if (!empty($pag_grp_main_page_id) && !empty($rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]))//Страница добавляется\переносится в существующую групппу
	{
		//TODO: только при add - проверить если поле отличается от поля в основной странице то изменить поле
		//MAY BE TODO: только при edit - проверить если страница была главной в другой группе то изменить индетификатор группы у страниц из той группы
		$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']] = $pag_grp_main_page_id.'.'.$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']];
		$pag_grp_upd = $db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]."' WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$pag_grp_main_page_id."' OR page_id = ".$id);
	}
	elseif (!empty($rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]))//Страница устанавливается главной в группе\переносится из другой
	{
		//MAY BE TODO: только при edit - проверить если страница была главной в другой группе то изменить индетификатор группы у страниц из той группы
		$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']] = $id.'.'.$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']];
		$pag_grp_upd = $db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]."' WHERE page_id = ".$id);
	}
	else//Страница вне всяких групп\убирается из групп
	{
		//MAY BE TODO: только при edit - проверить если страница была главной в другой группе то изменить индетификатор группы у страниц из той группы
		$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']] = $id;
		$pag_grp_upd = $db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$rpage['page_'.$cfg['plugin']['pagegroup']['extrfldnamegroup']]."' WHERE page_id = ".$id);
	}
}