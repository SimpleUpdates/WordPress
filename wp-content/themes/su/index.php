<?php

session_start();
header("Cache-control: private");

include(LOCAL_DOCUMENT_ROOT."/legacy/includes/db_connect.inc.php");
include(LOCAL_DOCUMENT_ROOT."/legacy/includes/functions-public.inc.php");

$link_id = db_connect();
if(!$link_id) print(sql_error());

LoadSUSession();

#load the template
$query = "SELECT * FROM template_site where site_id = '{$_SESSION[$su]['site_id']}' and page_type = 'blog' ";
$template_result = mysql_query($query);
if(!$template_result) print(sql_error());
$template = mysql_fetch_array($template_result);

include(LOCAL_DOCUMENT_ROOT."/legacy/includes/simpleupdates-globals.inc.php");

#now with session, we can load the langauges for this file...
include(LOCAL_DOCUMENT_ROOT."/legacy/languages/" . $_SESSION[$su]['siteinfo']['language'] . "/global.inc.php");
include(LOCAL_DOCUMENT_ROOT."/legacy/languages/" . $_SESSION[$su]['siteinfo']['language'] . "/welcome.inc.php");

print "<base href='http://" . $_SESSION[$su]['siteinfo']['site_url'] . "'>";

OutputAboveArticle();
get_header();
get_footer();
OutputBelowArticle();