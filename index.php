<?php require('simplepie.inc');

// Include WordPress - php used to pull in WordPress content courtesy of http://www.corvidworks.com/articles/wordpress-content-on-other-pages
define('WP_USE_THEMES', false);
require('./blog/wp-load.php');
query_posts('showposts=3');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>emilysutherlin.com | Home</title>
	<link rel="stylesheet" href="reset.css" type="text/css" />
	<link rel="stylesheet" href="screenview.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="printview.css" type="text/css" media="print" />
	<link rel="stylesheet" href="edge.css" type="text/css" />
	<link rel="shortcut icon" href="http://www.emilysutherlin.com/favicon.png" type="image/png" />

</head>

<body>

	<div id="header">
		<h1><a href="http://www.emilysutherlin.com"><img src="images/emilysutherlin-white-lg.png" alt="Emily Sutherlin"/></a></h1>
		<h1>Emily Sutherlin</h1>
			<h2>Home</h2>
	</div>

	<div id="accessibility">
		<ul>
			<li><a href="#navigation">Skip to navigation</a></li>
			<li><a href="#content">Skip to content</a></li>
			<li><a href="#links">Skip to external links</a></li>
		</ul>
	</div>

	<div id="navigation">
		<ul>
			<li class="current-page"><a href="#header">Home</a></li>
			<li><a href="http://www.emilysutherlin.com/portfolio">Portfolio</a></li>
			<li><a href="resume.htm">Resumé</a></li>
			<li><a href="about-me.htm">About Me</a></li>
		</ul>
	</div>



	<div id="content">
	    <div id="twitter">
            <h2>On Twitter</h2>
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
  A recent Twitter post cannot be retrieved.</p>";
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
		$tweet = "Trouble retrieving tweet from";
		$tweetdate = "today";
		$tweettime = "<!--".$i."-->";
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
	  <p class=\"tweet-info\"> ".$tweetdate." at ".$tweettime.". <a href=\"http://twitter.com/essentialemily\">See more.</a></p>";
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
    </div>		<!--	end of twitter feed  -->
	<h3>Welcome</h3>
		<p>And thanks for visiting the personal and professional website for Emily Sutherlin.  This site was developed during <a href="http://karlstolley.com">Karl Stolley</a>'s <a href="http://courses.karlstolley.com/530/CourseHome">"Standards-Based Web Design"</a> course at <a href="http://www.iit.edu/csl/hum/">IIT</a>. It is a constant work in progress, so please <a href="mailto:esutherl@iit.edu">email me</a> if you have any feedback, ideas, or words of advice!
		</p>
		<p>For now, feel free to peruse my site via the links at left, or check out some of my interests via the links on the right.</p>
		<p>~Emily</p>

<?php while (have_posts()): the_post(); // php used to pull in WordPress content courtesy of http://www.corvidworks.com/articles/wordpress-content-on-other-pages ?> 
<h3><?php the_title(); ?></h3>
<?php the_excerpt(); ?>
<?php endwhile; ?>

	<p><a href="http://www.emilysutherlin.com/blog">Read more...</a></p>

	</div>

	<div id="footer">
			<p>Copyright © 2010 Emily Sutherlin. Written with valid

				<a href="http://validator.w3.org/check?uri=referer">
                    <img src="http://www.w3.org/Icons/valid-xhtml10"
    					alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
                and
                <a href="http://jigsaw.w3.org/css-validator/check/referer">
                   <img style="border:0;width:88px;height:31px"
                        src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
                       alt="Valid CSS!" /></a>.
                Git repository at <a href="https://github.com/essentialemily/Project-1">Github</a>.</p>
	</div>

	<div id="links">
		<ul>

			<li><h4>Social Networks</h4>
				<ul>
					<li><a href="http://www.facebook.com/people/Emily-Sutherlin/54302056">Facebook</a></li>
					<li><a href="http://twitter.com/essentialemily">Twitter</a></li>
					<li><a href="http://www.linkedin.com/pub/emily-sutherlin/12/777/3b8">LinkedIn</a></li>
				</ul>
			</li>

			<li><h4>Organizations</h4>
				<ul>
					<li><a href="http://www.acui.org/">Association of College Unions International</a></li>
					<li><a href="http://www.alphasigmaalpha.org/">Alpha Sigma Alpha</a></li>
					<li><a href="http://www.pioneer-corps.org/">Pioneer Drum Corps</a></li>
					<li><a href="http://www.stbaldricks.org/">St. Baldrick's</a></li>
				</ul>
			</li>

			<li><h4>Daily Reading</h4>
				<ul>
					<li><a href="http://news.discovery.com/">Discovery News</a></li>
					<li><a href="http://www.wired.com/">Wired News</a></li>
					<li><a href="http://www.engadget.com/">Engadget</a></li>
					<li><a href="http://www.uptownupdate.com/">Uptown Update</a></li>
					<li><a href="http://xkcd.com/">xkcd</a></li>
				</ul>
			</li>

	<!--	knitting, sewing and music  -->

		</ul>
	</div>

</body>

</html>

