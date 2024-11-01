<?php
include("../../../wp-blog-header.php");


$question = isset($_POST["question"])?$_POST["question"]:"";

$submit = isset($_POST["submit"])?$_POST["submit"]:"";

$post_id =  isset($_REQUEST["p"])?$_REQUEST["p"]:0;

$options = get_option($anderson_makiyama[7]->plugin_slug."_" . $post_id);

$options_ = get_option($anderson_makiyama[7]->plugin_slug."_options");
$title = isset($options_["title"])?"<h1>".$options_["title"]."</h1>":"";

if(!empty($submit)){
	if(empty($question)){
		echo "<script>alert('" . __('Make your choice befor voting!','Anderson_Makiyama_Shortcode_Poll') ."');</script>";	
	}elseif(exceeded_limit($post_id)){
		echo "<script>alert('" . __('You have exceeded the maximum number of votes in the same post per day limit.','Anderson_Makiyama_Shortcode_Poll') . ' \\n' . __('Come back tomorrow!','Anderson_Makiyama_Shortcode_Poll') . "');</script>";	
	}else{
		
		$options = get_option($anderson_makiyama[7]->plugin_slug."_" . $post->ID);
		if(isset($options[$question])) $options[$question]++;
		update_option($anderson_makiyama[7]->plugin_slug."_" . $post->ID, $options);
		
		$msg = __('Thank you for voting!','Anderson_Makiyama_Shortcode_Poll');
		
		echo "<script>alert('$msg');</script>";	
	}
}

function exceeded_limit($post_id){
	global $anderson_makiyama;
	
	$options = get_option($anderson_makiyama[7]->plugin_slug."_options");
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$total = isset($options[$post_id])?$options[$post_id]:array(date('Y-m-d'),0, $ip);
	
	if($total[0] == date('Y-m-d') && $total[1] > 0 && $ip = $total[2]){
		return true;
	}else{
		$options[$post_id] = array(date('Y-m-d'), 1, $ip); 
	    update_option($anderson_makiyama[7]->plugin_slug."_options", $options);
		
		return false;
	}
}
?>
<html>
<head>
</head>
<body>
<div id="postbox" style="background-color:#EEE; padding: 15px; margin: 5px 0px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;" >
<?php echo $title;?>
<form id="new_post" name="new_post" method="post" action="">
<input type="hidden" name="p" value="<?php echo $p?>">
<?php
if(!empty($options)){
	foreach($options as $key=>$value){
		echo '<input type="radio" name="question" value="'.$key.'" > ' . $key . " ( ". $value." ". __("votes","Anderson_Makiyama_Shortcode_Poll") ." )<br>";
	}
}
?>
		

<br />

		<input id="submit" type="submit" name="submit" value="<?php _e('Vote','Anderson_Makiyama_Shortcode_Poll')?>" style='padding:10px; font-size:20px; width:250px;'  />

	</form>

</div> <!-- // postbox -->
</body>
</html>