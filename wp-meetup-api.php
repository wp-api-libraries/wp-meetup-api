<?php
/**
 * WP Meetup API.
 * @link https://www.meetup.com/meetup_api/ API Docs
 * @package WP-API-Libraries\WP-Meetup-API
 */

 /*
 * Plugin Name: WP Meetup API
 * Plugin URI: https://github.com/wp-api-libraries/wp-meetup-api
 * Description: Perform API requests to Meetup in WordPress.
 * Author: WP API Libraries
 * Version: 1.0.0
 * Author URI: https://wp-api-libraries.com
 * GitHub Plugin URI: https://github.com/wp-api-libraries/wp-meetup-api
 * GitHub Branch: master
 * Text Domain: wp-meetup-api
 */

if( ! defined( 'ABSPATH' ) ){
  exit;
}

include_once( 'wp-meetup-base-api.php' );

if( defined( 'MeetupAPI' ) ){
  return;
}

/**
 * MeetupAPI class.
 */
class MeetupAPI extends WpMeetupBase {

  /**
   * The base URI for requests to go to.
   *
   * @var string
   */
  protected $base_uri = 'https://api.meetup.com/';

  /**
   * The authentication API key. TODO: support OAuth.
   * @var string
   */
  protected $api_key;

  /**
   * Constructorinatorino 9000
   *
   * @param string $domain   The domain extension of zendesk (basically org name).
   * @param string $username The username through which requests will be made
   *                         under.
   * @param string $api_key  The API key used for authentication.
   * @param bool   $debug    (Default: false) Whether to return calls even if error,
   *                         or to wrap them in a wp_error object.
   */
  public function __construct( $api_key, $is_debug = false ) {
    $this->api_key = $api_key;
    $this->is_debug     = $is_debug;
  }
  
  /**
   * build_request function.
   * 
   * @access public
   * @param string $route (default: '')
   * @param array $args (default: array())
   * @param string $method (default: 'GET')
   * @return void
   */
  public function build_request( $route = '', $args = array(), $method = 'GET' ){
    $args['key'] = $this->api_key;

    return parent::build_request( $route, $args, $method );
  }

  /**
   * Abstract extended function that is used to set authorization before each
   * call. $this->args['headers'] are wiped after every fetch call, hence this
   * function is necessary.
   *
   * @return void
   */
  protected function set_headers() {
    // $this->args['headers'] = array(
    //   'Authorization'      => 'Bearer ' . $this->api_key,
    //   'Content-Type'       => 'application/json'
    // );
  }
  
  /**
   * run function.
   * 
   * @access private
   * @param mixed $route
   * @param array $args (default: array())
   * @param string $method (default: 'GET')
   * @return void
   */
  private function run( $route, $args = array(), $method = 'GET' ){
    return $this->build_request( $route, $args, $method )->fetch();
  }
  
  // ABUSE.
  
  // BATCH.
  
  // BOARDS.
  
  /**
   * get_group_boards function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_group_boards( $url_name, $fields = null ) {
	  return $this->run( $url_name . '/boards', array( 'fields' => $fields ) );
  }
  
  /**
   * get_group_board_discussions function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $board_id
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_group_board_discussions( $url_name, $board_id, $fields = null ) {
	  return $this->run( $url_name . '/boards/' . $board_id . '/discussions', array( 'fields' => $fields ) );
  }
  
  /**
   * get_group_board_discussions_posts function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $board_id
   * @param mixed $discussion_id
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_group_board_discussions_posts( $url_name, $board_id, $discussion_id, $fields = null ) {
	  return $this->run( $url_name . '/boards/' . $board_id . '/discussions/' . $discussion_id, array( 'fields' => $fields ) );
  }
  
  // CATEGORIES.
  
  /**
   * get_categories function.
   * 
   * @access public
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_categories( $fields = null ) {
	   return $this->run( '2/categories', array( 'fields' => $fields ) );
  }
  
  // CITIES.
  
  /**
   * get_cities function.
   * 
   * @access public
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_cities( $fields = null ) {
	  return $this->run( '2/cities', array( 'fields' => $fields ) );
  }
  
  
  // DASHBOARD.

  /**
   * Get a dashboard of aggregated Meetup information for the authorized member
   * @param  [type] $fields [description]
   * @return [type]         [description]
   */
  public function get_dashboard( $fields = null ){
    return $this->run( 'dashboard', array( 'fields' => $fields ) );
  }
  
  // COMMENTS.
  
  /**
   * get_event_comments function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $event_id
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_event_comments( $url_name, $event_id, $fields = null ) {
	 return $this->run( $url_name . '/events/' . $event_id . '/comments', array( 'fields' => $fields ) );
  }
  
  /**
   * get_event_comment_likes function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $event_id
   * @param mixed $comment_id
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_event_comment_likes( $url_name, $event_id, $comment_id, $fields = null ) {
	  return $this->run( $url_name . '/events/' . $event_id . '/comments/' . $comment_id . '/likes', array( 'fields' => $fields ) );
  }
  
  // EVENTS.
  
  /**
   * get_events function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_events( $url_name, $fields = null ) {
	  return $this->run( $url_name . '/events/', array( 'fields' => $fields ) );
  }
  
  /**
   * get_event function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $event_id
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_event( $url_name, $event_id, $fields = null ) {
	   return $this->run( $url_name . '/events/' . $event_id, array( 'fields' => $fields ) );
  }
  
  /**
   * get_event_attendance function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $event_id
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_event_attendance( $url_name, $event_id, $fields = null ) {
	  return $this->run( $url_name . '/events/' . $event_id . '/attedance', array( 'fields' => $fields ) );
  }
  
  /**
   * find_upcoming_events function.
   * 
   * @access public
   * @param mixed $fields (default: null)
   * @return void
   */
  public function find_upcoming_events( $fields = null ) {
	  return $this->run( 'find/upcoming_events/', array( 'fields' => $fields ) );
  }
  
  /**
   * get_self_calendar function.
   * 
   * @access public
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_self_calendar( $fields = null ) {
	   return $this->run( 'self/calendar', array( 'fields' => $fields ) );
  }
  
  /**
   * get_self_events function.
   * 
   * @access public
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_self_events( $fields = null ) {
	   return $this->run( 'self/events', array( 'fields' => $fields ) );
  }
  
  
  // FEEDS.
  
  public function get_activity( $fields = null ) {
	  return $this->run( 'activity', array( 'fields' => $fields ) );
  }
  
  // GEO.
  
  public function find_locations() {
	  
  }
  
  // GROUPS.
   
  /**
   * get_group function.
   * 
   * @access public
   * @param mixed $url_name
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_group( $url_name, $fields = null ) {
	  return $this->run( $url_name, array( 'fields' => $fields ) );
  }
  
  public function create_group() {
	  // TODO:
  }
  
  public function get_similar_groups( $url_name, $fields = null ) {
	  
  }
  
  public function add_group_topics() {
	  
  }
  
  public function delete_group_topics() {
	  
  }
  
  public function find_groups() {
	  
  }
  
  public function get_recommended_groups() {
	  
  }
  
  public function add_recommend_groups_ignores() {
	  
  }
  
  /**
   * get_self_groups function.
   * 
   * @access public
   * @param mixed $fields (default: null)
   * @return void
   */
  public function get_self_groups( $fields = null ) {
	  return $this->run( 'self/groups', array( 'fields' => $fields ) );
  }
  
  // HOSTS.
  
  // MEMBERS.
  
  // META.
  
  // NOTIFICATIONS.
  
  // PHOTOS.
  
  // PREFERENCES.
  
  // PRO.
  
  // PROFILES.
  
  
  
  // RSVPS.
  
  public function get_group_event_rsvps() {
	  
  }
  
  public function add_group_event_rsvps() {
	  
  }
  
  // TOPICS.
  
  public function find_topic_categories() {
	  
  }
  
  public function find_topics() {
	  
  }
  
  public function get_recommended_group_topics() {
	  
  }
  
  // VENUES.
  
  public function get_group_venues() {
	  
  }
  
  public function add_group_venue() {
	  
  }
  
  public function find_venues() {
	  
  }
  
  public function get_recommended_venues() {
	  
  }
  
}
