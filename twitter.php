<?php require('simplepie.inc'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>emilysutherlin.com | Twitter Feed</title>
		<link rel="stylesheet" href="reset.css" type="text/css" />
		<link rel="stylesheet" href="screenview.css" media="screen" type="text/css" />
		<link rel="stylesheet" href="printview.css" type="text/css" media="print" />
		<link rel="stylesheet" href="edge.css" type="text/css" />
		<link rel="shortcut icon" href="http://www.emilysutherlin.com/favicon.png" type="image/png" />
	</head>
	<body>
	
	<div id="header">
		<h1><a href="index.htm"><img src="images/emilysutherlin-white-lg.png" alt="Emily Sutherlin"/></a></h1>
		<h1>Emily Sutherlin</h1>

	<?php 
kstwitter();

function kstwitter() {

  $kstwitfeed= new SimplePie;
  $kstwitfeed->enable_cache(false);
  $kstwitfeed->set_feed_url('http://twitter.com/statuses/user_timeline/103719649.rss');
  $kstwitfeed->handle_content_type();
  $kstwitfeed->init();

  if($kstwitfeed->error()) {
  /*If there's an error message, spit it out and stop*/
  print "<p class=\"tweet\">".$kstwitfeed->error()."</p>
  <p class=\"tweet-info\">
  <strong>We are doomed.</strong>
  Appease the Twitter gods.</p>";
	}
	
	else { 
	/*Otherwise, attempt to get the tweet, etc.*/  
	/*Get some stuff, but not @replies */
		//for($i=0; $i < 5; $i++) {
		$i = 0;
		$ksgotone = 'no';
	while($ksgotone=='no') {
	  if($item=$kstwitfeed->get_item($i)) {
		$tweet = substr($item->get_title(), 16);
		$tweet = substr(addslashes(html_entity_decode($item->get_title())), 16);
		$tweetdate = $item->get_date('F j');
		$tweetday = $item->get_date('j');
		$ksd = date('j');
		  if ($tweetday==$ksd) { $tweetdate = "today"; }
		  else if ($tweetday==($ksd-1)) { $tweetdate = "yesterday"; }
		  else { $tweetdate = "On " . $tweetdate; }
		$tweettime = $item->get_date('g\:i a');
		$ksgotone = 'yes';
	  }
	  else {
		$tweet = "Epic Twitter Fail.";
		$tweetdate = "Angry Twitter Gods";
		$tweettime = "this moment<!--".$i."-->";
		$ksgotone = 'yes';
	  }
	}
	$twsearch = array(
	  '%((www\.|(http|https)+\:\/\/)[_.a-zA-Z0-9-]+\.[a-zA-Z0-9\/_:@=.+?,##\%&~-]*[^.|\'|\# |!|\(|?|,| |>|<|;|\)])%',
	  '|@([\w_]+)|',
	  '|#([\w_]+)|'
	);
	$twreplace = array(
	  '<a href="$1">$1</a>',
	  '<a href="http://twitter.com/$1">@$1</a>',
	  '<a href="http://twitter.com/search?q=%23$1">#$1</a>'
	);
	$tweet = preg_replace($twsearch, $twreplace, $tweet);
	/*Print it out*/
	print "<p class=\"tweet\">\"".fancytext($tweet)."\"</p>
	  <p class=\"tweet-info\">Posted to <a href=\"http://twitter.com/essentialemily\">Twitter</a> ".$tweetdate." at ".$tweettime."</a></p>";
	}
}

function fancytext($text) {
  $simpfound = array(' \\\'', '\\\'', ' \"', '\" ', '\"');
  //Fix them with
  $simpfixed = array(' ‘', '’', ' “', '” ', '“');
  $fancysafe = str_replace($simpfound, $simpfixed, $text);
  return $fancysafe;
}

		?>
			<h2>Tweets</h2>	
		</div>
	</body>
</html>

