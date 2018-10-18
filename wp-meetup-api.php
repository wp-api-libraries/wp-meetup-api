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

  private function run( $route, $args = array(), $method = 'GET' ){
    return $this->build_request( $route, $args, $method )->fetch();
  }

  /**
   * Get a dashboard of aggregated Meetup information for the authorized member
   * @param  [type] $fields [description]
   * @return [type]         [description]
   */
  public function get_dashboard( $fields = null ){
    return $this->run( 'dashboard', array( 'fields' => $fields ) );
  }
}
