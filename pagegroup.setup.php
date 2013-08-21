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
