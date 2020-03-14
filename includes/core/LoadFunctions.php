<?php

 function wp_get_server_protocol() {
  return \Wp\Core\Load::getInstance()->wp_get_server_protocol();
}

function wp_unregister_GLOBALS() {
   \Wp\Core\Load::getInstance()->wp_unregister_GLOBALS();
}

function wp_fix_server_vars() {
   \Wp\Core\Load::getInstance()->wp_fix_server_vars();
}

function wp_check_php_mysql_versions() {
  \Wp\Core\Load::getInstance()->wp_check_php_mysql_versions();
}

function wp_favicon_request() {
  \Wp\Core\Load::getInstance()->wp_favicon_request();
}

function wp_maintenance() {
     \Wp\Core\Load::getInstance()->wp_maintenance();
}

function timer_start() {
  return \Wp\Core\Load::getInstance()->timer_start();
}

function timer_stop( $display = 0, $precision = 3 ) {
 return \Wp\Core\Load::getInstance()->timer_stop($display,$precision);
 }

function wp_debug_mode() {
  \Wp\Core\Load::getInstance()->wp_debug_mode();
}

function wp_set_lang_dir() {
  \Wp\Core\Load::getInstance()->wp_set_lang_dir();
}

function require_wp_db() {
  \Wp\Core\Load::getInstance()->require_wp_db();
}

 function wp_set_wpdb_vars() {
 \Wp\Core\Load::getInstance()->wp_set_wpdb_vars();
}

function wp_using_ext_object_cache( $using = null ) {
   return \Wp\Core\Load::getInstance()->wp_using_ext_object_cache($using);
}

function wp_start_object_cache() {
 \Wp\Core\Load::getInstance()->wp_start_object_cache();
}

function wp_not_installed() {
  \Wp\Core\Load::getInstance()->wp_not_installed();
}

function wp_get_mu_plugins() {
  return \Wp\Core\Load::getInstance()->wp_get_mu_plugins();
}

function wp_get_active_and_valid_plugins() {
  return \Wp\Core\Load::getInstance()->wp_get_active_and_valid_plugins();
}

function wp_skip_paused_plugins( array $plugins ) {
  return \Wp\Core\Load::getInstance()->wp_skip_paused_plugins($plugins);
}

function wp_get_active_and_valid_themes() {
    return \Wp\Core\Load::getInstance()->wp_get_active_and_valid_themes();
}

function wp_skip_paused_themes( array $themes ){
    return \Wp\Core\Load::getInstance()->wp_skip_paused_themes($themes);
}

function wp_is_recovery_mode( array $themes ){
    return \Wp\Core\Load::getInstance()->wp_is_recovery_mode();
}

function is_protected_endpoint() {
    return \Wp\Core\Load::getInstance()->is_protected_endpoint();
}

function is_protected_ajax_action(){
    return \Wp\Core\Load::getInstance()->is_protected_ajax_action();
}

function wp_set_internal_encoding(){
    \Wp\Core\Load::getInstance()->wp_set_internal_encoding();
}

function wp_magic_quotes() {
    \Wp\Core\Load::getInstance()->wp_magic_quotes();
}

function shutdown_action_hook(){
    \Wp\Core\Load::getInstance()->shutdown_action_hook();
}

function wp_clone( $object ){
   return \Wp\Core\Load::getInstance()->wp_clone($object);
}

function is_admin(){
    return \Wp\Core\Load::getInstance()->is_admin();
}

function is_blog_admin(){
    return \Wp\Core\Load::getInstance()->is_blog_admin();
}

function is_network_admin(){
    return \Wp\Core\Load::getInstance()->is_network_admin();
}

function is_user_admin(){
    return \Wp\Core\Load::getInstance()->is_user_admin();
}

function is_multisite(){
    return \Wp\Core\Load::getInstance()->is_multisite();
}

function get_current_blog_id(){
    return \Wp\Core\Load::getInstance()->get_current_blog_id();
}

function get_current_network_id(){
    return \Wp\Core\Load::getInstance()->get_current_network_id();
}

function wp_load_translations_early(){
    \Wp\Core\Load::getInstance()->wp_load_translations_early();
}

function wp_installing( $is_installing = null ){
    \Wp\Core\Load::getInstance()->wp_installing($is_installing);
}

function is_ssl(){
    return \Wp\Core\Load::getInstance()->is_ssl();
}

function wp_convert_hr_to_bytes( $value ){
    return \Wp\Core\Load::getInstance()->wp_convert_hr_to_bytes($value);
}

function wp_is_ini_value_changeable( $setting ){
    return \Wp\Core\Load::getInstance()->wp_is_ini_value_changeable($setting);
}

function wp_doing_ajax(){
    return \Wp\Core\Load::getInstance()->wp_doing_ajax();
}

function wp_using_themes(){
    return \Wp\Core\Load::getInstance()->wp_using_themes();
}

function wp_doing_cron(){
    return \Wp\Core\Load::getInstance()->wp_doing_cron();
}

function is_wp_error( $thing ){
    return \Wp\Core\Load::getInstance()->is_wp_error($thing);
}

function wp_is_file_mod_allowed( $context ){
    return \Wp\Core\Load::getInstance()->wp_is_file_mod_allowed($context);
}

function wp_start_scraping_edited_file_errors(){
    \Wp\Core\Load::getInstance()->wp_start_scraping_edited_file_errors();
}

function wp_finalize_scraping_edited_file_errors( $scrape_key ){
    \Wp\Core\Load::getInstance()->wp_finalize_scraping_edited_file_errors($scrape_key);
}

function wp_is_json_request(){
   return \Wp\Core\Load::getInstance()->wp_is_json_request();
}

function wp_is_jsonp_request(){
    return \Wp\Core\Load::getInstance()->wp_is_jsonp_request();
}

function wp_is_xml_request(){
    return \Wp\Core\Load::getInstance()->wp_is_xml_request();
}