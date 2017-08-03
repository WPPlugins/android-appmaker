<?php
/*
Plugin Name: Android Appmaker
Plugin Script: appmaker.php
Description: Erstelle Android-Apps auf Grundlage deiner Seite.
Version: 3.8
License: GPL
Author: appmaker.merq.org
Author URI: https://appmaker.merq.org

=== RELEASE NOTES ===
2012-09-14 - v1.0 - first version
2012-09-19 - v1.1 - output bug fixed
2012-09-19 - v1.2 - other bugs fixed
2013-09-25 - v2.0 - Appmaker pro added
2013-09-27 - v2.6 - comment fix
2013-09-28 - v2.7 - youtube fix
2013-09-28 - v2.8 - image / link fix
2013-09-29 - v2.9 - file_get_contents replaced
2013-09-30 - v3.0 - subcategories added
2013-09-30 - v3.1 - subcategories fix
2013-09-30 - v3.3 - subcategories fix / xml fix
2013-10-01 - v3.4 - time zone fix
2013-10-02 - v3.5 - rename functions
2016-09-15 - v3.6 - Appmaker WordPress
2016-09-16 - v3.7 - Pro version - Push messaging
2016-09-16 - v3.8 - Firefox fixed
*/

/* 
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Online: http://www.gnu.org/licenses/gpl.txt
*/

//PRO FEATURES START
function merqappmaker_gb($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

function file_get_content($url)
{
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}

function kurzen($string) {
$text=wordwrap($string, 100, "WRA5PW5%R"); 
$text=explode("WRA5PW5%R",$text); 
return htmlspecialchars("$text[0]").' (...)';
}

//00 CAT
if (isset($_GET['categories']) && $_GET['categories'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'><xxx>';

$cats=wp_list_categories("echo=0&show_count=1");
$cats=explode('<li class="cat-item',$cats);


foreach ($cats as $category) {
if (strlen(strstr($category,'cat-item'))>0) {

$option = "\r\n<cat><title>";
$ittt=str_replace('(','',str_replace(')','',merqappmaker_gb(merqappmaker_gb($category,'><a href="',"</a>")."ap%pmE43zZ",'">','ap%pmE43zZ'))).merqappmaker_gb($category,'</a>',"\n");
$option .= $ittt;
$option .= "</title><link>";
$ciii=merqappmaker_gb($category,'cat-item-','"');
$option .= $ciii;
$piii=get_category_parents($ciii);
$piii=substr_count($piii, '/');
if ($piii!="1") {
$dn="     ".$ittt;
} else {
$dn=$ittt;
}

$option .= "</link><dn>".$dn."</dn></cat>";
echo $option;
	
}}

echo "</xxx>"; 

}}
//11 CAT


//00 TAGS
if (isset($_GET['tags']) && $_GET['tags'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'><xxx>';


//$tags = wp_tag_cloud('format=array&number=15' );
//print_r($tags);

$tags = get_tags();

foreach ($tags as $tag){
	//$tag_link = get_tag_link($tag->term_id);			
	//$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
	//$html .= "{$tag->name}</a>";
	echo "\r\n<tag><title>";
	echo $tag->name." (".$tag->count.")";
	echo "</title><link>";
	echo $tag->term_id;
	echo "</link></tag>";
	
	
}


echo "</xxx>"; 

}}
//11 TAGS


//00 PUBLISH COMMENT
if (isset($_GET['publishcomment']) && $_GET['publishcomment'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('disqus-comment-system/disqus.php')) {
//DISQUS
$fgc=file_get_content("http://disqus.com/api/3.0/threads/list.json?api_key=E8Uh5l5fHZ6gD8U3KycjAIAk46f68Zw7C6eW8WSjZvCLXebZ7p0r1yrYDrLilk2F&forum=".strtolower(get_option('disqus_forum_url'))."&thread=link:".urlencode(get_permalink($_REQUEST['postid'])));
$fgc=json_decode($fgc,true);
$fgc=$fgc['response']['0']['id'];
$fields = array(		
'thread'=>$fgc,
'message'=>urlencode($_REQUEST['comment']),
'author_name'=>urlencode($_REQUEST['autor']),
'author_email'=>urlencode($_REQUEST['mail']),
'author_url'=>urlencode($_REQUEST['url']),
'api_key'=>'E8Uh5l5fHZ6gD8U3KycjAIAk46f68Zw7C6eW8WSjZvCLXebZ7p0r1yrYDrLilk2F',
);
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'http://disqus.com/api/3.0/posts/create.json');
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_exec($ch);
curl_close($ch);
//DISQUS
} else {
$time = current_time('mysql');
$data = array(
    'comment_post_ID' => $_REQUEST['postid'],
    'comment_author' => $_REQUEST['autor'],
    'comment_author_email' => $_REQUEST['mail'],
    'comment_author_url' => $_REQUEST['url'],
    'comment_content' => $_REQUEST['comment'],
    'comment_type' => '',
    'comment_parent' => 0,
    'user_id' => null,
    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
    'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de-de; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
    'comment_date' => $time,
    'comment_approved' => 1,
);
wp_insert_comment($data);
}}}
//11 PUBLISH COMMENT

//00 UPDATE CHECK
if (isset($_GET['updatecheck']) && $_GET['updatecheck'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

$posts = query_posts('showposts=1');
while( have_posts()) : the_post();
echo get_the_ID();
endwhile;



}}
//11 UPDATE CHECK


//00 ARTIKEL

function data_uri($filename) {
    $data = base64_encode(file_get_content('http://images.weserv.nl/?url='.urlencode(str_replace('http://','',str_replace('https://','',$filename))).'&q=50&w=600'));
    if ($data=="RXJyb3IgNDA0OiBTZXJ2ZXIgY291bGQgcGFyc2UgdGhlID91cmw9IHRoYXQgeW91IHdlcmUgbG9va2luZyBmb3IsIGVycm9yIGl0IGdvdDogVGhlIHJlcXVlc3RlZCBVUkwgcmV0dXJuZWQgZXJyb3I6IDQwMyBGb3JiaWRkZW48c21hbGw+PGJyIC8+PGJyIC8+QWxzbywgaWYgcG9zc2libGUsIHBsZWFzZSByZXBsYWNlIGFueSBvY2N1cmVuY2VzIG9mIG9mICsgaW4gdGhlID91cmw9IHdpdGggJTJCIChzZWUgPGEgaHJlZj0iLy9pbWFnZXN3ZXNlcnYudXNlcnZvaWNlLmNvbS9mb3J1bXMvMTQ0MjU5LWltYWdlcy13ZXNlcnYtbmwtZ2VuZXJhbC9zdWdnZXN0aW9ucy8yNTg2ODYzLWJ1ZyI+KyBidWc8L2E+KTwvc21hbGw+") {
$data = base64_encode(file_get_content($filename));
}
    return "data:image/png;base64,$data";
}

if (isset($_GET['artikel']) && $_GET['artikel'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'><xxx>';


?>
<con>
<post><![CDATA[<html><head><style>
img {max-width: 100%;height: auto;}
iframe {max-width: 100%;}
</style></head><body><?php
$my_postid = $_GET['pid'];
$content_post = get_post($my_postid);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);


//$tube_link = '<a href="http://www.youtube.com/watch?v=XA5Qf8VHh9I&amp;feature=g-all-u&amp;context=G2f50f6aFAAAAAAAADAA" target="_blank" rel="nofollow">http://www.youtube.com/watch?v=XA5Qf8VHh9I&amp;feature=g-all-u&amp;context=G2f50f6aFAAAAAAAADAA</a>';

$search = '#<iframe.+?src="http://www.youtube.com/embed/([a-zA-Z0-9_-]{11}).+?"[^>]+?></iframe>#i';
$replace = '<a href="http://www.youtube.com/watch?v=$1"><img src="http://i1.ytimg.com/vi/$1/hqdefault.jpg" /></a>';
$content = preg_replace($search, $replace, $content);

$search = '#<iframe.+?src="//www.youtube.com/embed/([a-zA-Z0-9_-]{11}).+?"[^>]+?></iframe>#i';
$replace = '<a href="http://www.youtube.com/watch?v=$1"><img src="http://i1.ytimg.com/vi/$1/hqdefault.jpg" /></a>';
$content = preg_replace($search, $replace, $content);


//IMG LOCAL

function data_uri_callback($matchess) {
return  $matchess[1] . data_uri($matchess[2]) . $matchess[3];
}

function img_handler($matches) { 
$image_element = $matches[0];
$pattern = '/(src=["\'])([^"\']+)(["\'])/'; 
$image_element = preg_replace_callback($pattern, "data_uri_callback", $image_element);
return $image_element;
}

$search = '(<img\s+[^>]+>)';
$content = preg_replace_callback($search, 'img_handler', $content);

echo $content;
?></body></html>]]></post>
<author><?php echo get_userdata($content_post->post_author)->display_name; ?></author>
<date><?php echo mysql2date('d.m.Y H:i', get_post_time('Y-m-d H:i:s', false, $my_postid), false); ?></date>
<title><?php echo get_the_title($my_postid); ?></title>
<url><?php echo get_permalink($my_postid); ?></url>
<comments><![CDATA[<html><head><style>
img {max-width: 100%;height: auto;}
iframe {max-width: 100%;}
.comment {
padding-top:10px;
padding-bottom:10px;
border-top:1px solid black;
}
</style></head><body><div id="comments"><?php

$comments = get_comments('post_id='.$my_postid);
foreach($comments as $comment) :
?><div class="comment">
<b>
<?php if ($comment->comment_author_url) { ?>
<a href="<?php echo($comment->comment_author_url); ?>" target="_blank"><?php echo($comment->comment_author); ?></a>
<?php } else { ?>
<?php echo($comment->comment_author); ?>
<?php } ?>
</b>
<i>am <?php echo mysql2date('d.m.Y', $comment->comment_date, false); ?> um <?php echo mysql2date('H:i', $comment->comment_date, false); ?> Uhr</i>
<br/><br/>
<?php echo str_replace("\n", "<br/>", $comment->comment_content); ?>
<?php
	echo "</div>";
	endforeach;

?></div></body></html>]]></comments>
</con>
</xxx>
<?php

}}

//11 ARTIKEL

//00 SEARCH LISTE
if (isset($_GET['searchlist']) && $_GET['searchlist'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

$numposts = $_GET['num']; // number of posts in feed
if ($_GET['page']) {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&offset='.$offset.'&s='.$_GET['tag'].'&post_type=post');
} else {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&s='.$_GET['tag'].'&post_type=post');
}
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<channel>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>	
	<?php 
	$intnum = 0;
	while( have_posts()) : the_post(); 
	$intnum = $intnum + 1;
	?>
	<item>
		<title><?php the_title_rss(); ?></title>
		<link><?php echo htmlspecialchars(get_permalink()); ?></link>
		<id><?php echo get_the_ID(); ?></id>
		<pubDate><?php echo mysql2date('d.m.Y H:i', get_post_time('Y-m-d H:i:s', false), false); ?></pubDate>
		<creator><?php the_author(); ?></creator>
		<description><?php echo kurzen(strip_tags(get_the_excerpt())); ?></description>
		<comments><?php echo get_comments_number(); ?></comments>
		<pic><?php echo htmlspecialchars(merqappmaker_catch_that_image()); ?></pic>
	</item>
	<?php endwhile; ?>
	<intnum><?php echo $intnum; ?></intnum>
</channel>
<?php

}
exit;
}
//11 SEARCH LISTE



//00 TAG LISTE
if (isset($_GET['taglist']) && $_GET['taglist'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

$numposts = $_GET['num']; // number of posts in feed
if ($_GET['page']) {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&offset='.$offset.'&tag__in='.$_GET['tag']);
} else {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&tag__in='.$_GET['tag']);
}
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<channel>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<?php while( have_posts()) : the_post(); ?>
	<item>
		<title><?php the_title_rss(); ?></title>
		<link><?php echo htmlspecialchars(get_permalink()); ?></link>
		<id><?php echo get_the_ID(); ?></id>
		<pubDate><?php echo mysql2date('d.m.Y H:i', get_post_time('Y-m-d H:i:s', false), false); ?></pubDate>
		<creator><?php the_author(); ?></creator>
		<description><?php echo kurzen(strip_tags(get_the_excerpt())); ?></description>
		<comments><?php echo get_comments_number(); ?></comments>
		<pic><?php echo htmlspecialchars(merqappmaker_catch_that_image()); ?></pic>
	</item>
	<?php endwhile; ?>
</channel>
<?php

}
exit;
}
//11 TAG LISTE

//00 CAT LISTE
if (isset($_GET['catlist']) && $_GET['catlist'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {

$numposts = $_GET['num']; // number of posts in feed
if ($_GET['page']) {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&offset='.$offset.'&cat='.$_GET['cat']);
} else {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&cat='.$_GET['cat']);
}
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<channel>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<?php while( have_posts()) : the_post(); ?>
	<item>
		<title><?php the_title_rss(); ?></title>
		<link><?php echo htmlspecialchars(get_permalink()); ?></link>
		<id><?php echo get_the_ID(); ?></id>
		<pubDate><?php echo mysql2date('d.m.Y H:i', get_post_time('Y-m-d H:i:s', false), false); ?></pubDate>
		<creator><?php the_author(); ?></creator>
		<description><?php echo kurzen(strip_tags(get_the_excerpt())); ?></description>
		<comments><?php echo get_comments_number(); ?></comments>
		<pic><?php echo htmlspecialchars(merqappmaker_catch_that_image()); ?></pic>
	</item>
	<?php endwhile; ?>
</channel>
<?php

}
exit;
}
//11 CAT LISTE



//00 START

function merqappmaker_catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();

  $first_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
  $first_img = $first_img['0'];

  if ($first_img=='') {  
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){
  $first_img = "noimagemerqapp";
  }}
  return $first_img;
}



if ($_GET['start'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker_appid')) {
//FEEDAUSGABE
$numposts = $_GET['num']; // number of posts in feed
if ($_GET['page']) {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts.'&offset='.$offset);
} else {
$offset = (((int)$_GET['page'])-1)*10;
$posts = query_posts('showposts='.$numposts);
}

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<channel>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<?php while( have_posts()) : the_post(); ?>
	<item>
		<title><?php the_title_rss(); ?></title>
		<link><?php echo htmlspecialchars(get_permalink()); ?></link>
		<id><?php echo get_the_ID(); ?></id>
		<pubDate><?php echo mysql2date('d.m.Y H:i', get_post_time('Y-m-d H:i:s', false), false); ?></pubDate>
		<creator><?php the_author(); ?></creator>
		<description><?php echo kurzen(strip_tags(get_the_excerpt())); ?></description>
		<comments><?php echo get_comments_number(); ?></comments>
		<pic><?php echo htmlspecialchars(merqappmaker_catch_that_image()); ?></pic>
	</item>
	<?php endwhile; ?>
</channel>
<?php
//FEEDAUSGABE ENDE
}
exit;
}

//11 START


//PRO FEATURES ENDE

if ($_GET['rss'] == "1") {
require( '../../../wp-load.php' );
if ($_GET['p'] == get_option('wp_merq_appmaker')) {
//FEEDAUSGABE
$numposts = get_option('wp_merq_appmaker_anzahl'); // number of posts in feed
$posts = query_posts('showposts='.$numposts.'&cat=');
$more = 1;

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action('rss2_ns'); ?>
>
<channel>
	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<?php the_generator( 'rss2' ); ?>
	<language><?php echo get_option('rss_language'); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php while( have_posts()) : the_post(); ?>

	<item>
		<title><?php the_title_rss(); ?></title>
		<link><?php the_permalink_rss(); ?></link>
		<comments><?php comments_link(); ?></comments>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', false), false); ?></pubDate>
		<dc:creator><?php the_author(); ?></dc:creator>
<?php the_category_rss(); ?>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
<?php if (get_option('rss_use_excerpt')) : ?>

		<description><![CDATA[<?php the_content() ?>]]></description>
<?php else : ?>

		<description><![CDATA[<?php the_content() ?>]]></description>
	<?php if ( strlen( $post->post_content ) > 0 ) : ?>

		<content:encoded><![CDATA[<?php the_content() ?>]]></content:encoded>
	<?php else : ?>

		<content:encoded><![CDATA[<?php the_excerpt_rss() ?>]]></content:encoded>
	<?php endif; ?>
<?php endif; ?>

		<wfw:commentRss><?php echo get_post_comments_feed_link(); ?></wfw:commentRss>
		<slash:comments><?php echo get_comments_number(); ?></slash:comments>
<?php rss_enclosure(); ?>
<?php do_action('rss2_item'); ?>

	</item>
	<?php endwhile; ?>

</channel>
</rss>
<?php
//FEEDAUSGABE ENDE
}
exit;
}


add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_options_page('Einstellungen', 'Android Appmaker', 'manage_options', 'appmaker', 'my_plugin_options');
}

function my_plugin_options() {


    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }


    if( $_POST['anzahl'] != '' ) {
	update_option('wp_merq_appmaker_anzahl',$_POST['anzahl']);


?>
<div class="updated"><p><strong><?php _e('Einstellungen gespeichert.', 'menu-start' ); ?></strong></p></div>
<?php
}


if( $_POST['appid'] != '' ) {
update_option('wp_merq_appmaker_appid',$_POST['appid']);
?>
<div class="updated"><p><strong><?php _e('Einstellungen gespeichert.', 'menu-start' ); ?></strong></p></div>
<?php
}

if( $_POST['kennwort'] != '' ) {
update_option('wp_merq_appmaker_kennwort',$_POST['kennwort']);
?>
<div class="updated"><p><strong><?php _e('Einstellungen gespeichert.', 'menu-start' ); ?></strong></p></div>
<?php
}

if( $_POST['pushurl'] != '' ) {
update_option('wp_merq_appmaker_pushurl',$_POST['pushurl']);
?>
<div class="updated"><p><strong><?php _e('Einstellungen gespeichert.', 'menu-start' ); ?></strong></p></div>
<?php
}

if (get_option('wp_merq_appmaker_anzahl') == "") {
update_option('wp_merq_appmaker_anzahl',"20");
}	
	
if (get_option('wp_merq_appmaker') == "") {

$pool = "qwertzupasdfghkyxcvbnm23456789WERTZUPLKJHGFDSAYXCVBNM";
srand ((double)microtime()*1000000);
for($index = 0; $index < 6; $index++) { $pass_word .= substr($pool,(rand()%(strlen ($pool))), 1); }

update_option('wp_merq_appmaker',$pass_word);

}
?>
<div class="wrap">
<h2>Einstellungen: Android Appmaker</h2>
<h3><a href="https://appmaker.merq.org" target="_blank">Appmaker</a></h3>

Mithilfe dieses Plugins kannst du deine eigene Android App erstellen. Die App enthält u.a. die letzten Artikel deiner Seite.<br /><br />
1. Registriere dich kostenlos bei <a href="https://appmaker.merq.org" target="_blank">Appmaker.merq.org</a>.<br />
2. Erstelle auf der Seite eine neue App und gebe die hier genannte URL (s.u.) in das RSS-Feed - Feld ein.<br />
3. Die Android App ist fertig. Du kannst auf deiner Seite noch einen Link zur App setzen!<br />
4. Bei Bedarf kannst du den Pro-Tarif buchen und von weiteren Vorteilen profitieren! Oder lasse die eine native App erstellen (s.u.).<br /><br />
URL zum RSS-Feed: <b><?php echo plugin_dir_url(__FILE__)."appmaker.php?rss=1&p=".get_option('wp_merq_appmaker'); ?><br/><br/></b>

<form name="form1" method="post" action="">


<p>Push-URL (nur Pro-Tarif): 
<input type="text" name="pushurl" value="<?php echo get_option('wp_merq_appmaker_pushurl'); ?>">
</p>


<p>Anzahl Beiträge, welche in der App angezeigt werden sollen: 
<input type="text" name="anzahl" value="<?php echo get_option('wp_merq_appmaker_anzahl'); ?>" size="5">
</p>
<i>Hinweis: Änderungen werden in der App nach zirka 30 Minuten sichtbar!</i>

<br>
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" /></p>
</form>
<hr />

<h3><a href="https://appmaker.merq.org/wordpress" target="_blank">Appmaker WordPress Nativ</a></h3>
Mit <i>Appmaker WordPress</i> kannst du native Apps für Android erstellen.<br /><br />
1. Gehe auf <a href="https://appmaker.merq.org/wordpress" target="_blank">Appmaker für WordPress</a> und klicke auf App erstellen.<br />
2. Erstelle auf der Seite eine neue App und folge dabei den Anweisungen.<br />
3. Fülle die Einstellungen AppID und Kennwort hier (unten) aus.<br />
4. Die Android App ist fertig. Du kannst auf deiner Seite noch einen Link zur App setzen!<br /><br />


<form name="form1" method="post" action="">

<p>AppID: 
<input type="text" name="appid" value="<?php echo get_option('wp_merq_appmaker_appid'); ?>">
</p>

<p>Kennwort: 
<input type="text" name="kennwort" value="<?php echo get_option('wp_merq_appmaker_kennwort'); ?>">
</p>


<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" /></p>
</form>


</div>
<?php
}

add_action('media_buttons_context', 'MERQBUTTON');
function MERQBUTTON($context) {

if (get_option('wp_merq_appmaker_appid') != "") {
return "<a href=\"#\" onclick=\"javascript:var iframe=document.createElement('iframe');iframe.style.display='none';iframe.src='http://appmaker.merq.org/wordpress/ping?i=".get_option('wp_merq_appmaker_appid')."&k=".get_option('wp_merq_appmaker_kennwort')."&m='+document.getElementById('title').value;document.body.appendChild(iframe);\">Pushnaricht senden</a>";
} else {
if (get_option('wp_merq_appmaker_pushurl') != "") {
return "<a href=\"#\" onclick=\"javascript:var iframe=document.createElement('iframe');iframe.style.display='none';iframe.src='".get_option('wp_merq_appmaker_pushurl')."&m='+document.getElementById('title').value;document.body.appendChild(iframe);\">Pushnaricht senden</a>";
}
}

}