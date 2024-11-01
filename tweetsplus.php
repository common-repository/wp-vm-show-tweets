<?php 
/**
 * @package Wp VM Show Tweets
 * @author VinMatrix Team
 * @version 1.0
 */
/*
Plugin Name: Wp Vm Show Tweets
Plugin URI: http://blog.vinmatrix.com
Description: This plugin adds a widget to your blog to view tweets from the twitter and also allows you to change and view the design of widget on fly.
Cache setting also maintained to increase the performance of the plugin. 
Author: VinMatrix Team
Version: 1.0
Author URI: http://blog.vinmatrix.com
*/

add_action('admin_menu','vm_tweets_plus_admin_menu');
add_action('admin_menu','vm_tweets_plus_mgr_admin_menu');



function vm_tweets_plus_admin_menu() {

	$opt_title_name = 'tweets_plus_screen_title_name';
	$opt_title_val = str_replace("\\","",(get_option( $opt_title_name )));
	
	if ($opt_title_val==""){
		$opt_title_val = "VM Tweets Plus Settings";
		}
	
		
	

}

function vm_tweets_plus_mgr_admin_menu() {
	
	if (function_exists('add_options_page')) {
		add_options_page(__('VM Tweets Plus Settings'),__('VM Tweets Plus Settings'),10,basename(__FILE__),'vm_tweets_plus_page');
	}
}

function vm_tweets_plus_page(){
     $tweets_plus_settings = 'tweets_plus_settings';
    ?>
    
     <link rel="stylesheet" href="<?=get_option('siteurl')?>/wp-content/plugins/tweetsplus/colorpicker/css/colorpicker.css" type="text/css" />
    
  	<script type="text/javascript" src="<?=get_option('siteurl')?>/wp-content/plugins/tweetsplus/colorpicker/js/jquery.js"></script>
	<script type="text/javascript" src="<?=get_option('siteurl')?>/wp-content/plugins/tweetsplus/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="<?=get_option('siteurl')?>/wp-content/plugins/tweetsplus/colorpicker/js/eye.js"></script>
    <script type="text/javascript" src="<?=get_option('siteurl')?>/wp-content/plugins/tweetsplus/colorpicker/js/utils.js"></script>
    <script type="text/javascript" src="<?=get_option('siteurl')?>/wp-content/plugins/tweetsplus/colorpicker/js/layout.js?ver=1.0.2"></script>

    <?php
    	if (isset($_POST["tweets_plus_submit"])&& $_POST["tweets_plus_submit"]!='' ) {
    	   update_option('tweets_plus_settings', $_POST);
           echo '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
           }
          
	  
        $options = get_option($tweets_plus_settings);
    
		$_twitterUserID = $options['tweets_plus_option_userid'];
		$_twitterCount = $options['tweets_plus_option_maxcount'];
        $_twitternoftweets = $options['tweets_plus_option_noftweets'];
        $_twitterfollows = $options['tweets_plus_option_follows'];
        $_twitterfollowers = $options['tweets_plus_option_followers'];
        $_twitterlisted = $options['tweets_plus_option_listed'];
        
		$displayProfileImg = $options['tweets_plus_option_displayProfileImg'];
		$displayLocation = $options['tweets_plus_option_displayProfileLoc'];
       
        $widgetwidth = $options['tweets_plus_option_widget-width'];
	    $bdcolor = $options['tweets_plus_option_bdcolor'];
        $bdwidth = $options['tweets_plus_option_bwidth'];
        $bgcolor = $options['tweets_plus_option_bgcolor'];
        $ftcolor = $options['tweets_plus_option_ftcolor'];
         
		$title = htmlspecialchars($options['tweets_plus_title'], ENT_QUOTES);
      
        
     if (isset($_POST["tweets_plus_cache"])&& $_POST["tweets_plus_cache"]!='' && isset($_POST["button"])&& $_POST["button"]=='Set Cache'  ) {
    	  update_option('tweets_plus_cache', $_POST["tweets_plus_cache"]);
           echo '<div class="updated"><p><strong>Cache saved.</strong></p></div>';
           }
            if (isset($_POST["button"])&& $_POST["button"]=='Clear Cache'  ) {
    	  update_option('tweets_plus_cache', '');
           echo '<div class="updated"><p><strong>Cache cleared.</strong></p></div>';
           }
            $cachevalue = get_option('tweets_plus_cache');
    ?>
    <h2>Tweet Plus Settings</h2>
    <form name="form1" method="post" action="" onsubmit="return  validateit(this);">
    <table><tr>
	    <td><?php _e('Title:'); ?> </td><td><input id="tweets_plus_title" name="tweets_plus_title" type="text" value="<?php echo $title; ?>" /><br /></td></tr>
	    <tr>
	    <td><?php _e('Twitter ID:'); ?></td><td><input id="tweets_plus_option_userid" name="tweets_plus_option_userid" type="text" value="<?php echo $_twitterUserID; ?>" /><br /></td></tr>
        <tr>
	    <td><?php _e('Max tweets to Show:'); ?> </td><td><input style="width: 75px;" id="tweets_plus_option_maxcount" name="tweets_plus_option_maxcount" type="text" value="<?php echo $_twitterCount; ?>" /><br /></td></tr>
        <tr><td colspan="2"><strong>Stats</strong></td></tr>
        <tr>
	    <td><?php _e('Tweets:'); ?> </td><td><input id="tweets_plus_option_noftweets" name="tweets_plus_option_noftweets" type="checkbox" value="1" <?php if( $_twitternoftweets ) echo 'checked';?>/><br /></td></tr>
       <tr>
	    <td><?php _e('Follows:'); ?> </td><td><input id="tweets_plus_option_follows" name="tweets_plus_option_follows" type="checkbox" value="1" <?php if( $_twitterfollows ) echo 'checked';?>/><br /></td></tr>
       <tr>
	    <td><?php _e('Followers:'); ?> </td><td><input id="tweets_plus_option_followers" name="tweets_plus_option_followers" type="checkbox" value="1" <?php if( $_twitterfollowers ) echo 'checked';?>/><br /></td></tr>
        <tr>
	    <td><?php _e('Listed:'); ?> </td><td><input id="tweets_plus_option_listed" name="tweets_plus_option_listed" type="checkbox" value="1" <?php if( $_twitterlisted ) echo 'checked';?>/><br /></td></tr>
        <tr><td colspan="2"><strong>Twitter Profile Details</strong></td></tr>
        <tr>
	    <td><?php _e('Profile Image:'); ?> </td><td><input id="tweets_plus_option_displayProfileImg" name="tweets_plus_option_displayProfileImg" type="checkbox" value="1" <?php if( $displayProfileImg ) echo 'checked';?>/><br /></td></tr>
        &nbsp;&nbsp;<tr>
	    <td><?php _e('Location:'); ?> </td><td><input id="tweets_plus_option_displayProfileLoc" name="tweets_plus_option_displayProfileLoc" type="checkbox" value="1" <?php if( $displayLocation ) echo 'checked';?>/><br /></td></tr>
        <tr><td colspan="2"><strong>Widget Style</strong></td></tr>
        
        <tr>
	    <td><?php _e('Widget Width:'); ?> </td><td><input size="5" id="tweets_plus_option_widget-width" name="tweets_plus_option_widget-width" type="text" value="<?php echo $widgetwidth ;?>"/><br /></td></tr>
        
        <tr>
	    <td><?php _e('Border Color:#'); ?> </td><td><input size="5" id="tweets_plus_option_bdcolor" name="tweets_plus_option_bdcolor" type="text" value="<?php echo $bdcolor ;?>"/><input type="text" disabled="true" size="3" id="bdcolor_show" name="bdcolor_show"/></td></tr>
        <tr>
	    <td><?php _e('Border width:'); ?> </td><td><input size="5" id="tweets_plus_option_bwidth" name="tweets_plus_option_bwidth" type="text" value="<?php echo $bdwidth ;?>"/></td></tr>
       <tr>
	    <td><?php _e('Background Color:#'); ?> </td><td><input size="5" id="tweets_plus_option_bgcolor" name="tweets_plus_option_bgcolor" type="text" value="<?php echo $bgcolor ;?>"/><input type="text" disabled="true" size="3" id="bgcolor_show" name="bgcolor_show"/></td></tr>
         <tr>
	    <td><?php _e('Font Color:#'); ?> </td><td><input size="5" id="tweets_plus_option_ftcolor" name="tweets_plus_option_ftcolor" type="text" value="<?php echo $ftcolor ;?>"/><input type="text" disabled="true" size="3" id="ftcolor_show" name="ftcolor_show"/></td></tr>
      
        <tr>
	    <td><input type="hidden" id="tweets_plus_submit" name="tweets_plus_submit" value="1" /></td></tr>
        <tr>
	    <td><input type="submit" value="Submit" /></td></tr>
        </table>
</form>
<div id="preview">
<form name="form2" method="post" action="">
<h2>Cache Settings</h2>
<table><tr>
	    <td><?php _e('Set Cache In Seconds :'); ?> </td><td><input size="5"  id="tweets_plus_cache" name="tweets_plus_cache" type="text" value="<?=$cachevalue?>" /></td></tr>
	    <tr>
	    <td><input type="submit" name="button" value="Set Cache" /></td><td><input name="button" type="submit" value="Clear Cache" /></td></tr>
        <tr>
</table>	
</form>
</div>

<div style="padding-top: 20px;">
Help: Just Use the method "getTweetsPlusWidget()" in your template files
        And see the result... 
 
</div>
<script>
$('#tweets_plus_option_bdcolor, #tweets_plus_option_bgcolor, #tweets_plus_option_ftcolor').ColorPicker({

    onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
        
        if(el.id=='tweets_plus_option_bgcolor')
        $('#bgcolor_show').css('backgroundColor', '#' + hex);
        if(el.id=='tweets_plus_option_bdcolor')
          $('#bdcolor_show').css('backgroundColor', '#' + hex);
        if(el.id=='tweets_plus_option_ftcolor')
          $('#ftcolor_show').css('backgroundColor', '#' + hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
	  
		$(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});
$('#tweets_plus_option_bdcolor').ColorPicker({
	color: '#0000ff'
	
});
 if($('#tweets_plus_option_bgcolor').val()!='')
        $('#bgcolor_show').css('backgroundColor', '#' + $('#tweets_plus_option_bgcolor').val());
        if($('#tweets_plus_option_bdcolor').val()!='')
          $('#bdcolor_show').css('backgroundColor', '#' + $('#tweets_plus_option_bdcolor').val());
        if($('#tweets_plus_option_ftcolor').val()!='')
          $('#ftcolor_show').css('backgroundColor', '#' + $('#tweets_plus_option_ftcolor').val());
	
</script>
<div id="preview">
<h2>Widget Preview</h2>
<?php 

getTweetsPlusWidgetPreview();
?>

</div>
<?php

}

 function getTweetsPlusWidgetPreview(){
   require_once("widget.php");
}
 function getTweetsPlusWidget(){
 $tweets_plus_settings = 'tweets_plus_settings';
$options = get_option($tweets_plus_settings);
if($options!="")
   require_once("widget.php");
   else
   echo 'Please setup the TweetsPlus Plugin from admin panel';
}
?>