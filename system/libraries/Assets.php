<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Asset Library
 *
 * Provides simple functions to include CSS, JavaScript & Image assets.
 * By using this library, you will have cleaner view files.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @link		
 */

class CI_Assets
{
	private $CI;	
	private $asset_name;
	private $img_folder;
	private $js_folder;
	private $css_folder;
	
	private $pre;
	
	public function __construct()
	{
		$this->CI =& get_instance();		
		
		// --- Load config library assets in folder config in or application
		$this->pre = $this->CI->config->item('subclass_prefix');
		$this->CI->load->config( $this->pre .'assets');
		
		$this->img_folder = $this->CI->config->item('base_url') . $this->CI->config->item('asset_path') . $this->CI->config->item('img_folder');
		$this->js_folder  = $this->CI->config->item('base_url') . $this->CI->config->item('asset_path') . $this->CI->config->item('js_folder');
		$this->css_folder = $this->CI->config->item('base_url') . $this->CI->config->item('asset_path') . $this->CI->config->item('css_folder');
		
		log_message('debug', "Assets Class Inicializada");		
	}
	
	public function css( $asset_name = NULL, $media = 'screen' , $return_href = false)
	{
		$css = NULL;
		if( !is_array($asset_name) ):
			$css .= $this->Stylesheet($asset_name,$media, $return_href);
		else: 
			$A = count($asset_name);
			for( $i=0; $i < $A; $i++ )
				$css .= $this->Stylesheet($asset_name[$i], $media,$return_href);
		endif;
		
		return $css;
	}
	
	protected function Stylesheet($asset_name, $media , $return_href )
	{
		
		if ( $asset_name != NULL ):		
		
			$asset_name = str_replace('.css','',$asset_name);
			$stylesheet = '<link rel="stylesheet" type="text/css"';
		
			if ($media == NULL)
				$stylesheet .= ' media="' . $media . '"';			
			
			if ( strpos( $asset_name, 'js/') !== FALSE )
			{
				if($return_href === true)
					return $this->CI->config->item('base_url') . $this->CI->config->item('asset_path') . $asset_name . '.css';
				
				$stylesheet .= ' href="' . $this->CI->config->item('base_url') . $this->CI->config->item('asset_path') . $asset_name . '.css" />';
			}
			elseif ( strpos( $asset_name, 'http') !== FALSE )
			{
				if($return_href === true)
					return $asset_name;
				
				$stylesheet .= ' href="' . $asset_name . '.css" />';
			}
			else
			{
				if($return_href === true)
					return $this->css_folder . $asset_name . '.css';
				
				$stylesheet .= ' href="' . $this->css_folder . $asset_name . '.css" />';
			}
			
			return $stylesheet . PHP_EOL;
		endif;
	}

	public function css_min( $asset_name , $exist = true, $return_code = false)
	{
		$this->CI->load->driver('minify');
	
		$asset_name = str_replace('.css','',$asset_name);
		
		if($exist == true)
		{
			if ( strpos( $asset_name, 'js/') !== FALSE )
				$name_file = $this->CI->config->item('asset_path') . $asset_name . '_min.css';
			else
				$name_file = $this->CI->config->item('asset_path') . $this->CI->config->item('css_folder') . $asset_name . '_min.css';
			
			if( !file_exists($name_file))
			{
				if ( strpos( $asset_name, 'js/') !== FALSE )
				{
					$this->CI->minify->save_file($this->CI->minify->css->min($this->CI->config->item('asset_path')  . $asset_name . '.css'), $this->CI->config->item('asset_path')  . $asset_name . '_min.css');
				}
				else
				{
					$this->CI->minify->save_file($this->CI->minify->css->min($this->CI->config->item('asset_path') . $this->CI->config->item('css_folder') . $asset_name . '.css'), $this->CI->config->item('asset_path') . $this->CI->config->item('css_folder') . $asset_name . '_min.css');
				}
			}
		}
		else 
		{
			$this->CI->minify->save_file($this->CI->minify->css->min($this->CI->config->item('asset_path') . $this->CI->config->item('css_folder') . $asset_name . '.css'), $this->CI->config->item('asset_path') . $this->CI->config->item('css_folder') . $asset_name . '_min.css');
		}
		
		// --- Retornar somente c�digo minify ou link javascript
		if( $return_code == true )
			return $CSS;
		else
			return $this->css($asset_name . '_min.css');
	
	}
	
	public function js ( $asset_name = NULL, $return_src = false )
	{
		$js = NULL;
		if( !is_array($asset_name) ):
			$js .= $this->Javascript($asset_name, $return_src);
		else: 
			$A = count($asset_name);
			for( $i=0 ; $i < $A ; $i++ )
				$js .= $this->Javascript($asset_name[$i], $return_src);			
		endif;
		
		return $js;
	}
	
	protected function Javascript ( $asset_name, $return_src )
	{
		if( strpos( $asset_name, 'http') === FALSE)
			$asset_name = $this->js_folder .  $asset_name;
		
		if($return_src === true)
			return $this->js_folder .  $asset_name . '.js';
			
		if ( $asset_name != NULL ):
			
			
			$asset_name = str_replace('.js','',$asset_name);
			$javascript = 	'<script type="text/javascript" src="' . $asset_name . '.js"></script>';
				
			return $javascript . PHP_EOL;
		endif;
	}
	
	public function js_min( $asset_name , $exist = true, $return_code = false )
	{	
		$this->CI->load->driver('minify');
		
		$asset_name = str_replace('.js','',$asset_name);
		
		// --- Se definico como "auto" 
 		if($exist == true)
 		{
 			if( !file_exists($this->CI->config->item('asset_path') . $this->CI->config->item('js_folder') . $asset_name . '_min.js'))
 			{
				$this->CI->minify->save_file($this->CI->minify->js->min($this->CI->config->item('asset_path') . $this->CI->config->item('js_folder') . $asset_name . '.js'), $this->CI->config->item('asset_path') . $this->CI->config->item('js_folder') . $asset_name . '_min.js');
 			}
 		}
 		else
 		{
			$this->CI->minify->save_file($this->CI->minify->js->min($this->CI->config->item('asset_path') . $this->CI->config->item('js_folder') . $asset_name . '.js'), $this->CI->config->item('asset_path') . $this->CI->config->item('js_folder') . $asset_name . '_min.js');
 		}
		// --- Retornar somente c�digo minify ou link javascript
		if( $return_code == true )
			return $JS;
		else
			return $this->js($asset_name . '_min.js');
	}
	
	public function js_inline($code)
	{
		return '<script type="text/javascript">' . PHP_EOL . $code . PHP_EOL . '</script>' . PHP_EOL;
	}
	
	public function img ( $asset_name = NULL, $additional_elements = NULL )
	{
		if ( $asset_name != NULL)
			$image = '<img src="'.$this->img_folder . $asset_name . '"';
			
		if ( $additional_elements != NULL)
			foreach ($additional_elements as $element => $value)
				$image .= ' ' . $element . '=' . '"' . $value . '"';
		
		$image = $image . ' />';
			
		return $image . PHP_EOL;
		
	}
	
	public function img_thumb ( $asset_name, $config = array(), $attr = array() )
	{		
		$this->CI->load->library('image_lib');
		// --- Define width 
		$config['width'] = isset($config['width']) ? $config['width'] : 60;
        
        $config['master_dim'] = 'width';
        
		// --- Define height
		if(!isset($config['height']))
		{
			$config['height'] = $config['width'];
			$config['maintain_ratio'] = FALSE;
		}
		else
		{
			$config['maintain_ratio'] = FALSE;
		} 			
		
		
			// --- Defined where save thumb
			$folder = isset($config['save_image'])? $config['save_image'] . '/' : '';
			
			if(strpos($asset_name,'/')!==FALSE)
			{
				$folders = explode('/',$asset_name);
				$i = count($folders)-1;
				$config['source_image'] = $asset_name;
				$asset_name = $folders[$i];
			}
			
			$img = explode('.',$asset_name);
			
			$img_new  = $folder . $img[0] . '_' . $config['width'] . 'x' . $config['height'] . '.' . $img[1];	
			
			if(!isset($config['source_image']))
				$config['source_image'] = $this->CI->config->item('asset_path') . $this->CI->config->item('img_folder') . $asset_name;
			
			$config['new_image']    = $this->CI->config->item('asset_path') . $this->CI->config->item('img_folder') . $img_new;
			
			if(!file_exists($config['new_image'])):
				$this->CI->image_lib->initialize($config);
				
				if(!$this->CI->image_lib->resize())
					return FALSE;
				
				$this->CI->image_lib->clear();
				
			endif;		
					
		return $this->img($img_new, $attr);
	}
	
	public function img_qrcode($asset_name, $text, $width = '')
	{
		$this->CI->load->config( $this->pre . 'qr_code');
		
		$this->CI->load->helper('qr_code');
		
		if(strpos('.jpeg', $asset_name) !== TRUE)
		{
			$asset_name = str_replace('.jpeg', '', $asset_name);
			$ext = '.jpeg';
		}
		elseif(strpos('.png', $asset_name) !== TRUE)
		{
			$asset_name = str_replace('.png', '', $asset_name);
			$ext = '.png';
		}
		else 
		{
			$ext = $this->CI->config->item('qrcode_default_ext');
		}
		
		// --- Gera a imagem do QR Code
		qrencode(array('text'=>$text,'file_name'=>$asset_name,'ext'=>$ext));
		
		return $this->img( $this->CI->config->item('qrcode_save_path') . $asset_name . $ext, array('width'=>$width));
	}
	
	
}