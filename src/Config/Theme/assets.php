<?php

wp_enqueue_script('homeScript', plugins_url('public/js/home.js', __FILE__), array(),  date('YmdHis'));
wp_enqueue_style('homeStyle', plugins_url('public/css/home.css', __FILE__), array(),  date('YmdHis'));


// font-awesome
wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null);


?>