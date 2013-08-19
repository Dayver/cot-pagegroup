<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=pagetags.main
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

global $pag_grp_marker;
if (!$pag_grp_marker)
{
	$temp_array['PAGE_IN_GROUP_COUNT'] = $page_data['page_in_group_count'] ? $page_data['page_in_group_count'] : '';
	global $pag_grp_rowset, $pag_grp_sql_field_list;
	if (!empty($pag_grp_rowset))
	{		foreach ($pag_grp_rowset as $k => $v)
		{			if ($k == $page_data['page_id'] || isset($v[$page_data['page_id']]))
			{				$pag_grp_feild = $pag_grp_sql_field_list[$k];
				$pag_grp_t = new XTemplate(cot_tplfile('pagegroup.listrow.rotator', 'plug'));
				foreach ($v as $pag_grp_data)
				{
					$pag_grp_marker = $page_data['page_id'];
					$pag_grp_t->assign('PAGE_GROUP_MAIN_PAGE_ID', $k);
					//$pag_grp_t->assign('PAGE_GROUP_MAIN_PAGE_FIELD', $pag_grp_feild);
					$pag_grp_t->assign('PAGE_GROUP_THIS_MAIN_PAGE', $page_data['page_id'] == $pag_grp_data['page_id'] ? true : false);
					$pag_grp_t->assign('PAGE_GROUP_CONTAINER_ID', $pag_grp_data['page_pag_grp_container_id']);
					$pag_grp_t->assign('PAGE_GROUP_FIELD', $pag_grp_feild);
					$pag_grp_t->assign('PAGE_GROUP_FIELD_VALUE', $pag_grp_data['page_'.$pag_grp_feild]);
					$pag_grp_t->assign(cot_generate_pagetags($pag_grp_data, 'PAGE_GROUP_', $cfg['page']['truncatetext'], $usr['isadmin']));
					$pag_grp_t->parse('MAIN.ROW');
				}
				$pag_grp_t->assign('PAGE_GROUP_MAIN_PAGE_ID', $page_data['page_group_main_pag_id']);
				$pag_grp_t->assign('PAGE_GROUP_MAIN_PAGE_FIELD', $pag_grp_feild);
				$pag_grp_t->parse('MAIN');
				$temp_array['PAGE_GROUP_ROTATOR'] = $pag_grp_t->text('MAIN');

				break;			}		}	}
	$pag_grp_marker = false;
}
