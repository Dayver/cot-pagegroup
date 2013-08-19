<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL.');

global $env, $m;
if (!empty($env['location']) && $env['location'] == 'administration' && $m == 'config' && $_GET['p'] == 'pagegroup') cot_rc_link_file($cfg['plugins_dir'].'/pagegroup/js/pagegroup.admin.config.js');
