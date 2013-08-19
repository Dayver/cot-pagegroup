<?php
/* ====================
[BEGIN_COT_EXT]
Code=pagegroup
Name=Page group
Category=navigation-structure
Description=Collect page in group
Version=1.0
Date=2013-08-12
Author=Dayver
Copyright=Partial copyright (c) Dayver 2013
Notes=BSD License
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
Requires_modules=page
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
category=01:string:::Category codes, comma separated, where need collect page in group. If empty then for all
extrfldnamegroup=02:string::group_id:Name of page extra field, for a page id and group specification for grouped
extrfldnamesforgroup=03:string::color,height,length,weight,width:Page extra fields names, comma separated, for a collect pages in group by his value
[END_COT_EXT_CONFIG]
==================== */
defined('COT_CODE') or die('Wrong URL');

/*
MAY BE TODO:
для вычисления количества страниц в поддиректориях нужно подправить запросы

id

НЕ состояла в группах $id == $old_grp_id && $old_field == ''
	Вошла в группу $id != $grp_id
	Вошла в группу и стала главной
		СДЕЛАТЬ - проверить нет ли неглавных страниц для этой группы с другим полем field (ибо возможно она была когда то главной у группы)

		field = '';
		$db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$id.".".$field."' WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$id.".%'");

	Продолжает не состоять в группах
Была в группе главной $id == $old_grp_id && $old_field != ''
	Вошла в группу
		СДЕЛАТЬ - изменить идетефикатор группы у той из которой вышла

		$grp_pag_without_del_pag = $db->query("SELECT * FROM $db_pages WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$old_id.".%'")->fetch();
		if ($grp_pag_without_del_pag)
		{
			$db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = REPLACE(page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '".$old_id.".', '".$grp_pag_without_del_pag['page_id'].".') WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$old_id.".%'");
		}

	Вошла в группу и стала главной (изменилостолько поле field)
		СДЕЛАТЬ - изменить идетефикатор группы у той из которой вышла

		field = '';
		$db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$id.".".$field."' WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$id.".%'");

	Вышла из группы
		СДЕЛАТЬ - изменить идетефикатор группы у той из которой вышла

		$grp_pag_without_del_pag = $db->query("SELECT * FROM $db_pages WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$old_id.".%'")->fetch();
		if ($grp_pag_without_del_pag)
		{
			$db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = REPLACE(page_".$cfg['plugin']['pagegroup']['extrfldnamegroup'].", '".$old_id.".', '".$grp_pag_without_del_pag['page_id'].".') WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$old_id.".%'");
		}

Была в группе $id != $old_grp_id && $old_field != ''
	Вошла в группу
	Вошла в группу и стала главной
		СДЕЛАТЬ - проверить нет ли неглавных страниц для этой группы с другим полем field

		field = '';
		$db->query("UPDATE $db_pages SET page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." = '".$id.".".$field."' WHERE page_".$cfg['plugin']['pagegroup']['extrfldnamegroup']." LIKE '".$id.".%'");

	Вышла из группы

field

*/
