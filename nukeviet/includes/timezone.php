<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 31/05/2010, 00:36
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

//Xac dinh ten mui gio
function nv_getTimezoneName_from_cookie( $cookie )
{
	if( preg_match( "/^([\-]*\d+)\.([\-]*\d+)\.([\-]*\d+)\|(.*)$/", rawurldecode( $cookie ), $matches ) )
	{
		$ini = file( NV_ROOTDIR . '/includes/ini/timezone.ini' );
		$timezones = array();
	
		foreach( $ini as $i )
		{
			if( preg_match( '/\[(.+)\]/', $i, $ms ) )
			{
				$last = trim( $ms[1] );
			}
			elseif( preg_match( '/(.+)[ ]*\=[ ]*(\-?\d+)/', $i, $ms ) )
			{
				$timezones[$last][trim( $ms[1] )] = trim( $ms[2] );
			}
		}
	
		foreach( $timezones as $name => $offset )
		{
			if( $offset['winter_offset'] == intval( $matches[2] ) * 60 && $offset['summer_offset'] == intval( $matches[2] ) * 60 ) return $name;
		}
	}
	return '';
}

unset( $matches, $matches2 );
$global_config['cookie_prefix'] = ( empty( $global_config['cookie_prefix'] ) ) ? "nv3" : $global_config['cookie_prefix'];

if( isset( $_COOKIE[$global_config['cookie_prefix'] . '_cltn'] ) )
{
	$nv_cltn = base64_decode( $_COOKIE[$global_config['cookie_prefix'] . '_cltn'] );

	if( preg_match( "/^([^\.]+)\.([\-]*\d+)\.(\d{1})$/", $nv_cltn, $matches ) )
	{
		define( 'NV_CLIENT_TIMEZONE_NAME', $matches[1] );
		define( 'NV_CLIENT_TIMEZONE_OFFSET', $matches[2] );
		define( 'NV_CLIENT_TIMEZONE_DST', $matches[3] );
	}
	else
	{
		setcookie( $global_config['cookie_prefix'] . '_cltn', false, time() - 86400 );
	}
}

if( ! defined( 'NV_CLIENT_TIMEZONE_NAME' ) and isset( $_COOKIE[$global_config['cookie_prefix'] . '_cltz'] ) and preg_match( "/^([\-]*\d+)\.([\-]*\d+)\.([\-]*\d+)\|(.*)$/", rawurldecode( $_COOKIE[$global_config['cookie_prefix'] . '_cltz'] ), $matches2 ) )
{
	$client_timezone_name = nv_getTimezoneName_from_cookie( $_COOKIE[$global_config['cookie_prefix'] . '_cltz'] );

	if( ! empty( $client_timezone_name ) )
	{
		define( 'NV_CLIENT_TIMEZONE_NAME', $client_timezone_name );
		define( 'NV_CLIENT_TIMEZONE_OFFSET', $matches2[3] * 60 );
	}
	else
	{
		$sd = floor( $matches2[2] >= 0 ? $matches2[2] / 60 : -$matches2[2] / 60 );
	
		define( 'NV_CLIENT_TIMEZONE_NAME', ( $matches2[2] >= 0 ? "+" : "-" ) . str_pad( $sd, 2, '0', STR_PAD_LEFT ) . ":00" );
		define( 'NV_CLIENT_TIMEZONE_OFFSET', floor( $matches2[3] / 60 ) * 3600 );
	}

	define( 'NV_CLIENT_TIMEZONE_DST', $matches2[1] != $matches2[2] ? 1 : 0 );

	$client_timezone_name = base64_encode( NV_CLIENT_TIMEZONE_NAME . '.' . NV_CLIENT_TIMEZONE_OFFSET . '.' . NV_CLIENT_TIMEZONE_DST );

	setcookie( $global_config['cookie_prefix'] . '_cltn', $client_timezone_name, 0, $matches2[4], '', 0 );

	unset( $client_timezone_name, $sd );
}

$site_timezone = ( $global_config['site_timezone'] == "byCountry" ) ? $countries[$client_info['country']][2] : $global_config['site_timezone'];

if( $site_timezone == '' )
{
	$site_timezone = defined( 'NV_CLIENT_TIMEZONE_NAME' ) ? NV_CLIENT_TIMEZONE_NAME : $global_config['statistics_timezone'];

	if( $site_timezone == '' )
	{
		$site_timezone = 'Asia/Saigon';
	}
}

date_default_timezone_set( $site_timezone );
define( 'NV_SITE_TIMEZONE_GMT_NAME', preg_replace( "/^([\+|\-]{1}\d{2})(\d{2})$/", "$1:$2", date( "O" ) ) );

if( strcasecmp( date_default_timezone_get(), $site_timezone ) == 0 )
{
	define( 'NV_SITE_TIMEZONE_NAME', $site_timezone );
}
else
{
	define( 'NV_SITE_TIMEZONE_NAME', NV_SITE_TIMEZONE_GMT_NAME );
}

unset( $site_timezone );

define( 'NV_SITE_TIMEZONE_OFFSET', date( "Z" ) );

?>