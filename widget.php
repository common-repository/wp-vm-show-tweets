<?php
//To integrate the list of professionals with ajax call from admin file
$tweets_plus_settings = 'tweets_plus_settings';
$options = get_option($tweets_plus_settings);
$tweets_plus_data = get_option('tweets_plus_data');

$title = htmlspecialchars($options['tweets_plus_title'], ENT_QUOTES);
        $_twitterUserID = $options['tweets_plus_option_userid'];
       	$_twitterCount = $options['tweets_plus_option_maxcount'];
        $_twitternoftweets = $options['tweets_plus_option_noftweets'];
        $_twitterfollows = $options['tweets_plus_option_follows'];
        $_twitterfollowers = $options['tweets_plus_option_followers'];
        $_twitterlisted = $options['tweets_plus_option_listed'];
        $_displayProfileLoc = $options['tweets_plus_option_displayProfileLoc'];
        $_displayProfileImg = $options['tweets_plus_option_displayProfileImg'];
         $tpluscahe = get_option('tweets_plus_cache');
         $tpluscahe = ($tpluscahe=='')?0:$tpluscahe;
        $statsdisplay =  Array();
        $tweetsplus_data = Array();
        $xml = '';
       
       if($_twitterUserID!="" && $tpluscahe==0 && ( empty($tweets_plus_data) || $tweets_plus_data['tweets_plus_xml_data_expire']+$tpluscahe<time())){
       $xml=file_get_contents('http://twitter.com/users/show.xml?screen_name='.$_twitterUserID);
       $tweetsplus_data['tweets_plus_xml_data'] = $xml;
 
       }else{
        $xml = $tweets_plus_data['tweets_plus_xml_data'] ;
       }
       
      
       if(!$xml){
        die('Please set up Your Twitter Id, we are unable to Load twitter account!..');
       }
      
      
       $address='<table cellspacing="5" ><tr>';  
      if (preg_match('/profile_image_url>(.*)</',$xml,$match)!=0 && $_displayProfileImg!='') {
	$address.= '<td><img src="'.$match[1].'" /></td>';
}    
    if (preg_match('/screen_name>(.*)</',$xml,$match)!=0 && $_displayProfileLoc!="") {
	 $address.= '<td>'.$match[1].'<br/>';
    }
    
    if (preg_match('/location>(.*)</',$xml,$match)!=0 && $_displayProfileLoc!='' ) {
	 $address.= $match[1].'</td>';
    }
     $address.= '</tr></table>';
if (preg_match('/followers_count>(.*)</',$xml,$match)!=0) {
	$_twitterfollowers1 = $match[1];
}
if (preg_match('/listed_count>(.*)</',$xml,$match)!=0) {
	$_twitterlisted1 = $match[1];
}
if (preg_match('/friends_count>(.*)</',$xml,$match)!=0) {
	$_twitterfollows1 = $match[1];
}
if (preg_match('/statuses_count>(.*)</',$xml,$match)!=0) {
	$_twitternoftweets1 = $match[1];
}

        if($_twitternoftweets!=''){
        $statsdis['label'] = 'Tweets';
        $statsdis['count'] = $_twitternoftweets1;
        $statsdisplay[] = $statsdis;
        }
         if($_twitterfollows!=''){
        $statsdis['label'] = 'Follows';
        $statsdis['count'] = $_twitterfollows1;
        $statsdisplay[] = $statsdis;
        }
         if($_twitterfollowers!=''){
        $statsdis['label'] = 'Followers';
        $statsdis['count'] = $_twitterfollowers1;
        $statsdisplay[] = $statsdis;
        }
         if($_twitterlisted!=''){
        $statsdis['label'] = 'Listed';
        $statsdis['count'] = $_twitterlisted1;
        $statsdisplay[] = $statsdis;
        }
         
        
 $_xmlfilestr ='';     
        
if($_twitterUserID!="" && $tpluscahe==0 &&  ( empty($tweets_plus_data) || $tweets_plus_data['tweets_plus_xml_data_expire']+$tpluscahe<time())){
$_xmlfilestr = 'http://twitter.com/statuses/user_timeline/' . $_twitterUserID . '.xml?count='.$_twitterCount;

$tweetsplus_data['tweets_plus_xml_data2'] = $_xmlfilestr;
}else{
 $_xmlfilestr =  $tweets_plus_data['tweets_plus_xml_data2'];  
}
$twitters = @simplexml_load_file( $_xmlfilestr );
$widgetdesign['bordercolor'] = '#CCCCCC';
$widgetdesign['bordercolorwidth']=1;
$widgetdesign['background-color']='#4D88C1';
$widgetdesign['font-color']='white';
$widgetdesign['widget-width']=250;  
$widgetdesign['widget-width'] = ($options['tweets_plus_option_widget-width']!='')?$options['tweets_plus_option_widget-width']:$widgetdesign['widget-width'];
$widgetdesign['bordercolor'] = ($options['tweets_plus_option_bdcolor']!='')?'#'.$options['tweets_plus_option_bdcolor']:$widgetdesign['bordercolor'];
$widgetdesign['bordercolorwidth'] = ($options['tweets_plus_option_bwidth']!='')?$options['tweets_plus_option_bwidth']:$widgetdesign['bordercolorwidth'];
$widgetdesign['background-color']= ($options['tweets_plus_option_bgcolor']!='')?'#'.$options['tweets_plus_option_bgcolor']:$widgetdesign['background-color'];
$widgetdesign['font-color']= ($options['tweets_plus_option_ftcolor']!='')?'#'.$options['tweets_plus_option_ftcolor']:$widgetdesign['font-color']; 

if(!empty($tweetsplus_data)){
$tweetsplus_data['tweets_plus_xml_data_expire'] = time();
update_option('tweets_plus_data', $tweetsplus_data);
}

?>

<style>
.tweetsplus-widget table tr td{
vertical-align: middle !important;    
}
.tweetsplus-widget table tr td img{
margin-right: 20px !important;    
}
</style>                 

     


<div class="tweetsplus-widget" style="width:<?=$widgetdesign['widget-width']?>px;border: <?=$widgetdesign['bordercolorwidth']?>px solid <?=$widgetdesign['bordercolor']?>;">



<?php {
if($title!="")  
?>

<div style="background-color:<?=$widgetdesign['background-color']?> ;border-bottom: <?=$widgetdesign['bordercolorwidth']?>px solid <?=$widgetdesign['bordercolor']?>;padding:5px;color:<?=$widgetdesign['font-color']?>;" id="tweetsplus_title"> <?php echo $title;?> Stats</div>


<?php }
?> 
<?php 

if(count($statsdisplay)){
    ?>
    <div style="border-bottom:<?=$widgetdesign['bordercolorwidth']?>px solid <?=$widgetdesign['bordercolor']?>;padding:5px;">

<table width="100%">
<tr>
<?php
for($j=0;$j<count($statsdisplay);$j++){
    if($j!=count($statsdisplay)-1){
?>
<td style="border-right:<?=$widgetdesign['bordercolorwidth']?>px solid <?=$widgetdesign['bordercolor']?>;" align="center"><?=$statsdisplay[$j]['label']?><span style="display: block;text-align:center;"><?=$statsdisplay[$j]['count']?></span></td>
<?php
}else{?>
<td align="center"><?=$statsdisplay[$j]['label']?><span style="display: block;text-align:center;"><?=$statsdisplay[$j]['count']?></span></td>

    <?
}
}
?>
</tr>
</table>
</div>
<?php  } 
?>

<?php 
if(($_displayProfileLoc!='' || $_displayProfileImg!=''))  {  
?>
<div style="border-bottom: <?=$widgetdesign['bordercolorwidth']?>px solid <?=$widgetdesign['bordercolor']?>;padding: 5px;"><?php echo $address;?></div>

<?php }
?>
<?php
if($_twitterCount!=''){
$output = '<div style="padding:5px 5px 5px 8px;"><ul style="list-style:none outside none;margin-left:-2px;">';
foreach( $twitters as $tw ) {
                $output.='<li>';
				$words = explode(' ', $tw->text);
                for($i=0;$i<count($words)-1;$i++)
                $output.= $words[$i].' ';
                
                $output.='<a href="'.$words[count($words)-1].'">'.$words[count($words)-1].'</a>';
				$output.='</li>';
                }
               
                echo $output.'</ul></div>';
                }?>
                
</div>
               