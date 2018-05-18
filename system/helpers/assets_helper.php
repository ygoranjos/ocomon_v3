<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Array Helpers
 *
 * @package		
 * @subpackage	
 * @category	
 * @author		
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	
 * @param	
 * @param	
 * @param	
 * @return	
 */
if ( ! function_exists('element'))
{
	function element($item, $array, $default = FALSE)
	{
		if ( ! isset($array[$item]) OR $array[$item] == "")
		{
			return $default;
		}

		return $array[$item];
	}
}

if ( ! function_exists('image'))
{
	function image($asset_name = NULL, $additional_elements = NULL )
	{
		$CI =& get_instance();
        $CI->load->library('assets');

        return $CI->assets->img($asset_name, $additional_elements );
	}
}

if ( ! function_exists('js'))
{
	function js( $asset_name = NULL, $return_src = false )
	{
		$CI =& get_instance();
        $CI->load->library('assets');

        return $CI->assets->js($asset_name, $return_src);
        
	}
}

if ( ! function_exists('css'))
{
	function css( $asset_name = NULL, $media = 'screen' , $return_href = false)
	{
		$CI =& get_instance();
        $CI->load->library('assets');

        return $CI->assets->css( $asset_name, $media, $return_href);
        
	}
}

// application/helpers/path_helper.php
if ( ! function_exists('asset_url') )
{
	function asset_url( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path');
		else
            return base_url() . $CI->config->item('asset_path') . $path;
	}
}

if ( ! function_exists('asset_img') )
{
	function asset_img( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path') . '/' .  $CI->config->item('img_folder');
		else
            return base_url() . $CI->config->item('asset_path') . '/' . $CI->config->item('img_folder') . $path;
	}
}

if ( ! function_exists('asset_js') )
{
	function asset_js( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path') . '/' .  $CI->config->item('js_folder');
		else
            return base_url() . $CI->config->item('asset_path') . '/' . $CI->config->item('js_folder') . $path;
	}
}

if ( ! function_exists('asset_css') )
{
	function asset_css( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path') . '/' .  $CI->config->item('css_folder');
		else
            return base_url() . $CI->config->item('asset_path') . '/' . $CI->config->item('css_folder') . $path;
	}
}

if ( ! function_exists('asset_qrcode') )
{
	function asset_qrcode( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path') . '/' .  $CI->config->item('qrcode_folder');
		else
            return base_url() . $CI->config->item('asset_path') . '/' . $CI->config->item('qrcode_folder') . $path;
	}
}

if ( ! function_exists('asset_thumbs') )
{
	function asset_thumbs( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path') . '/' .  $CI->config->item('thumbs_folder');
		else
            return base_url() . $CI->config->item('asset_path') . '/' . $CI->config->item('thumbs_folder') . $path;
	}
}

if ( ! function_exists('asset_upload') )
{
	function asset_upload( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
            // return the asset_url
            return base_url() . $CI->config->item('asset_path') . '/' .  $CI->config->item('upload_folder');
		else
            return base_url() . $CI->config->item('asset_path') . '/' . $CI->config->item('upload_folder') . $path;
	}
}

