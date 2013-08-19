<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.main
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('pagegroup', 'plug');
split_field_variants();

$cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]['field_html'] = '<input type="text" name="{$name}_main_page_id" value="" maxlength="11" size="11" /><b>.</b>'.$cot_extrafields[$db_pages][$cfg['plugin']['pagegroup']['extrfldnamegroup']]['field_html'].$L['adm_pag_grp_add_field_hint'];
