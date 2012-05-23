<?php
/*
Plugin Name: Hyper Cache Clear Link
Plugin URI: http://www.driczone.net/blog/plugins/hyper-cache-clear-link
Description: Adds a link to clear cache in admin bar. Useful to test theme modifications.
Version: 1.0
Author: Dric
Author URI: http://www.driczone.net

Copyright 2012  Dric  (email : cedric@driczone.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function hccl_admin_bar_edit() {
	global $wp_admin_bar;
  if (current_user_can('manage_options')){
  $hccl_count = hyper_count();
  $hccl_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  if (!empty($_GET)){
    $hccl_link = $hccl_url.'&hccl_action=clear';
  }else{
    $hccl_link = $hccl_url.'?hccl_action=clear';
  }
	$wp_admin_bar->add_node(array(
    'id' => 'hccl',
    'title' => __( 'Clear Cache', 'hyper-cache' ).' ('.$hccl_count.')',
    'href' => $hccl_link ));
  }else{
    return;
  }
}

function hccl_get(){
  if (isset($_GET['hccl_action'])){
    hyper_delete_path(WP_CONTENT_DIR . '/cache/hyper-cache');
  }
}

add_action( 'wp_before_admin_bar_render', 'hccl_admin_bar_edit' );
add_action( 'init', 'hccl_get' );
