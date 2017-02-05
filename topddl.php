<?php
/*
Plugin Name: TopDDL Streaming & DDL Box
Plugin URI:  http://topddl.net
Description: Plugin for topddl user, to easily display streaming and download box.
Version:     0.1
Author:      Topddl Team
Author URI:  http://topddl.net
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function topddl_style_header() {
  ob_start(); ?>
  <style type="text/css">img.turnOnLight, iframe.turnOnLight {opacity: 0;}.mirror-selector{margin-bottom: 5px;} .turnOnLight {background-color: #000 !important;color: #000 !important;border-color: #000  !important;} #topddl-turn-on-light {cursor: pointer;} .mirror-selector-button.selected,.mirror-selector-button:hover{color:#8c8c8c;text-decoration:none;border-color:#8c8c8c} .mirror-selector-button{border:1px solid #007acc;padding:0 5px;border-radius:3px;color:#007acc;text-decoration:none}</style>
  <script>
  function topddl_turn_on() {
    var topddl_body = document.getElementsByTagName("*");
    for (var i = 0, len = topddl_body.length; i != len; ++i) {
      if(!/topddl/ig.test(topddl_body[i].className)) {
        topddl_body[i].className += " turnOnLight";
      }
    }
    var div = document.getElementById("topddl-turn-on-light");
    div.innerHTML = 'Turon on light';
    div.setAttribute("onclick","topddl_turn_off();" );
  }
  function topddl_turn_off() {
    var topddl_body = document.getElementsByTagName("*");
    for (var i = 0, len = topddl_body.length; i != len; ++i) {
      if(!/topddl/ig.test(topddl_body[i].className)) {
        topddl_body[i].className = topddl_body[i].className.replace(/(?:^|\s)turnOnLight(?!\S)/g , '' );
      }
    }
    var div = document.getElementById("topddl-turn-on-light");
    div.setAttribute("onclick","topddl_turn_on();" );
    div.innerHTML = 'Turon off light';
  }
  </script>
  <?php $contents = ob_get_clean();
  echo $contents;
}
add_action('wp_head', 'topddl_style_header');

function topdd_embed_shortcode( $atts, $content = "" ) {
  $mirror = 1;
  if(isset($_GET['mirror'])) $mirror = $_GET['mirror'];
  $width = 640;
  $height = 360;
  if(isset($atts["w"])) $width =  $atts["w"];
  if(isset($atts["h"])) $height =  $atts["h"];
  if($mirror == 2) $height += 20;
  $content = str_replace(array("http:", "https:"), "", $content) . '?embed=true&mirror=' . $mirror;
  $selected1 = '';
  $selected2 = '';
  if($mirror == 1) $selected1 = 'selected';
  if($mirror == 2) $selected2 = 'selected';
  $selector = '<div id="mirror-selector" class="topddl mirror-selector">';
  $selector .= '<span id="topddl-turn-on-light" class="topddl mirror-selector-button" onclick="topddl_turn_on();">Turn off light</span> ';
  $selector .= '<a class="topddl mirror-selector-button '.$selected1.'" href="'. get_permalink().'?mirror=1#mirror-selector">Mirror 1</a> <a class="topddl mirror-selector-button '.$selected2.'" href="'. get_permalink().'?mirror=2#mirror-selector">Mirror 2</a>';
  $selector .= '</div>';
	return $selector . '<iframe class="topddl" src="'.$content.'" frameborder="0" width="'.$width.'" height="'.$height.'" allowfullscreen="allowfullscreen"></iframe>';
}
add_shortcode( 'topddl', 'topdd_embed_shortcode' );

function topddl_ddl_shortcode($atts, $content = "") {

}
?>
