<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout Class
 *
 * An open source application development framework for PHP 5.1.6 or newer
 * 
 * Build your CodeIgniter pages much easier with partials, breadcrumbs, layouts and themes*
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Layout
 * @since		Version 1.0
 * @license		GPL2 
 * 
 */

class Layout
{
	# --- VAR used to get a object instance CI used model sigleton
	private $CI;
	# --- Array de configuração do layout
	public $layout = array();
	
	# --- VARS used to Layout parse in layout
	private	$title   = NULL;
	private $metas; 
	private	$js;
	private $js_min;
	private $css_min; 
	private	$css;	
	private	$topContent;
	private	$content;	
	private	$footerContent;	
    
    public $debug = array();
    public $config = array();

	private $parse = array();

	public $flashdata = NULL;	
	
	private $_parseExec;
	private $_header;
	private $_footer;

	public $_doctype = 'html4-trans'; /* xhtml11  xhtml1-strict  xhtml1-trans  xhtml1-frame  html5  html4-strict  html4-trans html4-frame */
	
	protected $folder = NULL;
	protected $class = NULL;
	protected $method = NULL;
	protected $layout_main = NULL;
	
	#### --- AINDA EM DESENVOLVIMENTO --- ####
	
	// --- Beta teste
	private $cache_lifetime = 0;
	##########################################
    
	public $set_layout_main;
	public $set_layout_method;
	public $set_layout_class;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->metas        = '<!-- Metas Layout Library -->' . PHP_EOL;
		$this->js           = '<!-- Js Layout Library -->' . PHP_EOL;
		$this->js_min       = '<!-- JsMin Layout Library -->' . PHP_EOL;
		$this->css_min      = '<!-- CssMin Layout Library -->' . PHP_EOL;
		$this->css          = '<!-- Css Layout Library -->' . PHP_EOL;
		$this->topContent   = '<!-- TopContent Layout Library -->' . PHP_EOL;
		$this->content      = '<!-- Content Layout Library -->' . PHP_EOL;
		$this->footerContent= '<!-- FooterContent Layout Library -->' . PHP_EOL;		
		
		// --- Load config the layout library in folder config
		$pre = $this->CI->config->item('subclass_prefix');
		$this->CI->load->config($pre.'layout');
		
		// --- Libraries loads for use in the layout library
		$this->CI->load->library('parser');
		$this->CI->load->library('assets');
		
		//// Config folder and view for autoload layout	//////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// --- Pasta padrão para busca de view, jss e css
		$this->folder = $this->CI->config->item('layout_folder');
		// --- Define classe que está acessando
		$this->class  = $this->CI->router->class;
		// --- Define Método que está acessando
		$this->method = $this->CI->router->method;
		
		// --- Define Main layout, this name will be used to search layout, js and css of the main layout
		$this->layout_main = $this->CI->config->item('layout_main');
		
		// --- Define nome da pasta js
		$this->js_folder = $this->CI->config->item('js_folder');
		// --- Define nome da pasta css
		$this->css_folder = $this->CI->config->item('css_folder');
		
		// --- Verifica se o ambiente é de desenvolvimento para exibir o debug do Layout carregado
		$this->debug['active']	= ENVIRONMENT == 'development' ? TRUE : FALSE;		
		
		$this->debug['meta'] = '';
		$this->debug['js']  = '';
		$this->debug['css'] = '';
		$this->debug['layout'] = '';
		$this->debug['content']	= '';
        $this->debug['module'] = '';
	
		log_message('debug', "Layout Class Inicializada");		
	}
	
	/**
	 * Método mágico __set é executando quando um atributo da instância atual é definido porém não foi declarado na classe, isso torna possível criar {PLACEHOLDER} nos templates sem que eles tenham sido declarados previamente na biblioteca layout.
     * ATENÇÂO: Use nomes mais específicos pois se já existirem ele irá substituir ambos com o último atributo instânciado. EXEMPLO {index_alunos}  {table_materias}
      *
     * @param type $name
     * @param type $value 
     */
	public function __set($name, $value)
	{
        if(isset($this->parse[$name]))
            $this->parse[$name] .= $value;
        else
            $this->parse[$name] = $value;
        
	}
    
    public function __get($name)
	{
        echo '<pre>';
        print_r($this->parse);
        echo '</pre>';
	}
    
    /**  As of PHP 5.1.0  */
    public function __unset($name)
    {
        unset($this->parse[$name]);
    }
    
	/**
	 * Esse método carrega uma view contida na pasta layouts/module com configurações padrões de css, js, meta usando a classe Layout. 
     * Exemplo um banner que usa um css e js padrão pode ser criado em uma pasta usando os métodos $this->layout->css e $this->layout->js
     * quando for preciso usar o banner em qualquer outro controller basta carregar o módulo com todos os CSS e JS.
	 * 
     * @acess public
     * 
	 * @param text $module
	 * @param array $data
	 * @param boolean $return
	 */
	public function module_view($module, $data = NULL, $parse = TRUE)
	{  
        if($parse === TRUE)
        {
            $explode = explode('/',$module);
            $parse = $explode[count($explode)-1];
        }
            
        if(file_exists( APPPATH . 'views/'. $this->folder . '_modules/'. $module .EXT))
        {
            $this->debug_module('Module', $this->folder . '_modules/'. $module . EXT);
            
            if(is_array($data) || $data == NULL || $data == '')
                if(!$parse)
                    $this->content .= $this->CI->load->view( $this->folder . '_modules/'.$module, $data, TRUE);
                else
                    if(isset($this->parse[$parse]))
                        $this->parse[$parse] .= $this->CI->load->view($this->folder . '_modules/'.$module, $data, TRUE);
                    else
                        $this->parse[$parse] = $this->CI->load->view($this->folder . '_modules/'.$module, $data, TRUE);
            else
                if(isset($this->parse[$parse]))
                    $this->parse[$parse] .= '';
                else
                    $this->parse[$parse] = '';
        }
        else
        {
            if(isset($this->parse[$parse]))
                    $this->parse[$parse] .= '';
                else
                    $this->parse[$parse] = '';
                
            $this->debug_module('Module', $this->folder . '_modules/'. $module . EXT,FALSE);
        }
        
            
    }
    
	/**
	 * Esse método carrega um parse contida na pasta layouts/module com configurações padrões de css, js, meta usando a classe Layout. 
     * Exemplo um banner que usa um css e js padrão pode ser criado em uma pasta usando os métodos $this->layout->css e $this->layout->js
     * quando for preciso usar o banner em qualquer outro controller basta carregar o módulo com todos os CSS e JS.
	 * 
     * @acess public
     * 
	 * @param text $module
	 * @param array $data
	 * @param boolean $parse Use esse parâmetro para definir em qual {PLACEHOLDER} o módulo deve ser carregad. Se omitido o modulo será carregado normalmente usando o método $this->content().
	 */    
    public function module_parse($module, $data = FALSE, $parse = TRUE)
	{   
        
        if($parse === TRUE)
        {
            $explode = explode('/',$module);
            $parse = $explode[count($explode)-1];
        }
        
        if(file_exists( APPPATH . 'views/'. $this->folder . '_modules/'. $module .EXT))
        {
            $this->debug_module('Module', $this->folder . '_modules/'. $module . EXT);
            
            if(is_array($data))
            {
                if(!$parse)
                {
                    $this->content .= $this->CI->parser->parse($this->folder . '_modules/'.$module, $data, TRUE);
                }
                else
                {
                    if(isset($this->parse[$parse]))
                        $this->parse[$parse] .= $this->CI->parser->parse($this->folder . '_modules/'.$module, $data, TRUE);
                    else
                        $this->parse[$parse] = $this->CI->parser->parse($this->folder . '_modules/'.$module, $data, TRUE);
                }
            }
            else
            {
                if(isset($this->parse[$parse]))
                    $this->parse[$parse] .= '';
                else
                    $this->parse[$parse] = ''; 
            }
                
        }
        else
        {
            if(isset($this->parse[$parse]))
                    $this->parse[$parse] .= '';
                else
                    $this->parse[$parse] = '';
                
            $this->debug_module('Module', $this->folder . '_modules/'. $module . EXT,FALSE);
        }   
	}
    
    public function module($module, $parse = TRUE)
	{
        if($parse === TRUE)
        {
            $explode = explode('/',$module);
            $parse = $explode[count($explode)-1];
        }
        
        if(file_exists( APPPATH . 'views/'. $this->folder . '_modules/'. $module .EXT))
        {
            $this->debug_module('Module', $this->folder . '_modules/'. $module . EXT);
            
            $this->content( $this->CI->parser->parse($this->folder . '_modules/'.$module, NULL, TRUE));
            
            if(isset($this->parse[$parse]))
                $this->parse[$parse] .= '';
            else
               $this->parse[$parse] = ''; 
        }
        else
        {
            if(isset($this->parse[$parse]))
                $this->parse[$parse] .= '';
            else
                $this->parse[$parse] = '';
                
            $this->debug_module('Module', $this->folder . '_modules/'. $module . EXT,FALSE);
        }    
	}
    
    /**
	 * Troca de nome do arquivo padrão de layout definido na configuração da libraries localizada na pasta CONFIG.
	 * 
     * @access  public
     * 
	 * @param  string $name Nome do arquivo padrão de layout sem a extensão do arquivo.
	 */	
	public function set_layout_main($name)
	{
		$this->set_layout_main = $name . EXT;
	}

    /**
	 * Troca nome da classe padrão para busca da view class.
	 * 
     * @access  public
     * 
	 * @param  string $name Nome da classe padrão para busca da view.
	 */
	public function set_layout_class($name)
	{
		$this->set_layout_class = $name . EXT;
	}
    
    /**
	 * Troca nome da classe padrão para busca do method view.
	 * 
     * @access  public
     * 
	 * @param  string $name Nome da classe padrão para busca da view.
	 */
	public function set_layout_method($name)
	{
		$this->set_layout_method= $name . EXT;
	}
  
    /**
	 * Inseri um vetor com variávies no autoload das views.
	 * 
     * @access public
     * 
     * @param  array  $data Vetor contendo as variável que serão inseridas no layout na estrutura array('nome_variavel'=>'valor_variavel')
	 * @param  string $name Nome da view de autoload que ele deve inserir o vetor.
     *                      OPÇÕES: main | layout_main | layout_class | layout_method | layout_main_page
	 */
    public function set( $data = array(), $name = 'layout_method')
    {
        if(isset($this->config[$name.'_data']))
        {
            $this->config[$name.'_data'] = array_merge($this->config[$name.'_data'], $data);
        }
        else
        {
           $this->config[$name.'_data'] = $data; 
        }
    }
    
    public function set_class( $data = array())
    {
        $this->config['layout_class_data'] = $data;
    }

    public function set_method( $data = array())
    {
        $this->config['layout_method_data'] = $data;
    }
    
    public function set_main( $data = array())
    {
        $this->config['layout_main_data'] = $data;
    }
    
    public function set_main_main( $data = array())
    {
        $this->config['main_data'] = $data;
    }

    public function set_main_class( $data = array())
    {
        $this->config['main_class_data'] = $data;
    }
    
    private function ConfigLayout()
	{
		// --- Define o layout principal
		$this->config['main'] = isset($this->set_layout_main)? $this->set_layout_main : $this->folder . $this->layout_main . EXT;
        $this->config['main_class'] = isset($this->set_layout_main)? $this->set_layout_main : $this->folder . $this->layout_main . '_class' . EXT;
		// --- Define pasta de arquivos padrão de arquivos
		$this->config['assets']  = $this->CI->config->item('asset_path');	
		// --- Verifica se existe uma layout principal para o controller utilizado se ele existir irá substituir o main_layou global.
		$this->config['layout_main']  = $this->folder  . $this->class . '/'. $this->layout_main . EXT;
        $this->config['layout_main_class']  = $this->folder  . $this->class . '/'. $this->layout_main . '_class' . EXT;
		// --- Define layout padrão de uso para os controllers que extenderem essa classe. Se o arquivo não existir não será carregado
		$this->config['layout_class'] = isset($this->set_layout_class)? $this->set_layout_class : $this->folder . $this->class . '/' . $this->class . EXT;
		// --- Define layout padrão de uso para os controllers conforme o método usada. Se o arquivo não existir não será carregado
		$this->config['layout_method'] = isset($this->set_layout_method)? $this->set_layout_method : $this->folder . $this->class . '/' . $this->method . EXT;
		// --- Define layout simple onde é substituida as variáveis parse se existirem
		$this->config['layout_main_page']   = $this->folder . $this->class . '/' . $this->layout_main . '_' . $this->method . EXT;
		
		// --- Define js padrão para esse layout principal		
		$this->config['js_layout']  = $this->folder  . $this->layout_main . '.js';
        // --- Define js padrão para esse layout principal		
		$this->config['js_layout_this']  = $this->folder  . $this->class . '/' .  $this->layout_main . '.js';
		// --- Define js padrão do javascript para class usada
		$this->config['js_class']   = $this->folder  . $this->class . '/' . $this->class . '.js';
		// --- Define js padrão do método usado dessa classe
		$this->config['js_method']  = $this->folder  . $this->class . '/' . $this->method . '.js';
		
		// --- Define css padrão para todos que usarem essa library
		$this->config['css_layout'] = $this->folder  . $this->layout_main . '.css';
        // --- Define js padrão para esse layout principal		
		$this->config['css_layout_this']  = $this->folder  . $this->class . '/' .  $this->layout_main . '.css';
		// --- Define css padrão para todos os métodos da classe
		$this->config['css_class']  = $this->folder  . $this->class . '/' . $this->class . '.css';
		// --- Define css padrão para esse método
		$this->config['css_method'] = $this->folder  . $this->class . '/' . $this->method . '.css';	
	}	

    /** 
	 * Inseri o título no <head> da página HTML. OBS: Se o título já foi definido em algum construtor ou método que sua classe atual extende ele irá concatenar o texto com o anterior. Se for preciso sobreescrever o título defina o parâmetro $clear como TRUE
	 * 
     * @access  public 
     * 
	 * @param string $title Título que será inserido nao title contido no head da página.
	 * @param boolean $clear Define se o títulos será concatenado com anterior.
	 */
	public function title( $title , $clear = NULL )
	{
		if(is_null($clear))
			$this->title .= ' '.$title;
		else 
			$this->title  = $title;
        
	}
	
    /**
	 * Inseri meta tags no <head> da página HTML, pode ser inserida no formato padrão html puro ou usando o helper "HTML" meta() do Codeigniter passando um vetor com as definições de metas que devem ser carregadas.
	 * 
     * @access Public
     * 
	 * @param string | array $meta Se passado como array ele irá inserir a meta usando o helper meta() do CI. Se preferir é possível passar sua meta tag como string pronta.
	 */
	public function meta( $meta )
	{
		if(is_array($meta)):			
			$this->metas .= meta($meta[0],$meta[1],$meta[2]);
			$this->debug_header( 'meta', meta( $meta ) );
		else:
			$this->metas .=  $meta;
			$this->debug_header( 'meta', $meta );
		endif;
	}	
	
    /**
	 * Inseri tag com link para script no <head> da página HTML.
	 * 
     * @access  public
     * 
	 * @param  string $src Nome do arquivo javascript ou endereço localizado na pasta definida no arquivo de configuração.
	 */
	public function js( $src )
	{
		if( $this->CI->config->item('layout_min_js') == 'all') 
		{
			if(is_array($src))
			{
				foreach($src as $key => $value)
				{
					if( strpos( $value, 'http://') !== FALSE ):
						$this->config['minJS_files'][] = $value;
					else:
						$value = str_replace('.js', '', $value);
						$this->config['minJS_files'][] = $this->CI->config->item('asset_path') . $this->CI->config->item('js_folder').$value.'.js';
					endif;
				}
			}
			else
			{	
				if( strpos( $src, 'http://') !== FALSE ):
					$this->config['minJS_files'][] = $src;
				else:
					$src = str_replace('.js', '', $src);
					$this->config['minJS_files'][] = $this->CI->config->item('asset_path') . $this->CI->config->item('js_folder').$src.'.js';
				endif;
			}
		}
		elseif( $this->CI->config->item('layout_min_js') == 'single')
		{
			if(is_array($src))
			{
				foreach($src AS $key => $src_value):
					$this->js_min($src_value, $this->CI->config->item('layout_min'));
					$this->debug_header( 'js', $src_value );
				endforeach;
			}
			else
			{
				$this->js_min($src, $this->CI->config->item('layout_min'));
				$this->debug_header( 'js', $src );
			}				
		}
		else
		{
			if(is_array($src)):
				foreach($src AS $key => $src_value):
					$this->js .= $this->CI->assets->js($src_value);
					$this->debug_header( 'js', $src_value );
				endforeach;
			else:
				$this->js .= $this->CI->assets->js($src);
				$this->debug_header( 'js', $src );
			endif;
		}
	}

    /**
	 * Inseri tag com link para script no <head> da página HTML para o javascript compactado. A própria classe irá gerar o arquivo compactado e inserir o link com o nome padrão <NOME>_min localizado junto com o arquivo especificado para compactação.
	 * 
     * @access  public
     * 
	 * @param  string $src Nome do arquivo javascript ou endereço localizado na pasta definida no arquivo de configuração que será compactado.
	 */
	public function js_min( $src , $return_code = false )
	{
		$exist = $this->CI->config->item('layout_min');
		
		$this->debug_header( 'js', $src );
		$this->js_min .= $this->CI->assets->js_min($src , $exist, $return_code );
	}

    /**
	 * Inseri javascript inline no <head> da página HTML gerada pelo método output()
	 * 
     * @access  public
     * 
	 * @param  string $code String contendo javascript para ser inserido inline no <heaa>. Lembre-se de escapar todos os caracteres de conflito com a linguagem PHP.
	 */
	public function js_inline($code)
	{
		$this->debug_header( 'js', 'Library layouts insert inline javascript' );
		$this->js .= $this->CI->assets->js_inline($code);
	}

    /**
	 * Inseri link css no <head> da página HTML.
	 * 
     * @access  public
     * 
	 * @param  string $href Nome do arquivo css ou endereço localizado na pasta definida no arquivo de configuração.
	 */
	public function css( $href )
	{
		if( $this->CI->config->item('layout_min_css') == 'all') 
		{ 
			if(is_array($href))
			{
				foreach($href as $key => $value)
				{
					if( strpos( $value, 'http') !== FALSE ):
						$this->config['minCSS_files'][] = $value;
					else:
						$value = str_replace('.css', '', $value);
						
						if ( strpos( $value, 'js/') !== FALSE )
							$this->config['minCSS_files'][] = $this->CI->config->item('asset_path') . $value . '.css';
						else
							$this->config['minCSS_files'][] = $this->CI->config->item('asset_path') . $this->CI->config->item('css_folder') . $value.'.css';
					endif;
				}
			}
			else
			{
				if( strpos( $href, 'http') !== FALSE ):
					$this->config['minCSS_files'][] = $href;
				else:
					$href = str_replace('.css', '', $href);
					
					if ( strpos( $href, 'js/') !== FALSE )
						$this->config['minCSS_files'][] = $this->CI->config->item('asset_path') . $href . '.css';
					else
						$this->config['minCSS_files'][] = $this->CI->config->item('asset_path') . $this->CI->config->item('css_folder').$href.'.css';
				endif;
			}
		}
		elseif( $this->CI->config->item('layout_min_css') == 'sigle')
		{
			if(is_array($href))
			{
				foreach($href AS $key => $href_value):
					$this->css_min($href_value, $this->CI->config->item('layout_min'));
					$this->debug_header( 'css', $href_value );
				endforeach;
			}
			else
			{
				$this->css_min($href, $this->CI->config->item('layout_min'));
				$this->debug_header( 'css', $href );
			}		
		}
		else
		{
			if(is_array($href)):
				foreach($href AS $key => $href_value):
					$this->css .= $this->CI->assets->css($href_value);
					$this->debug_header( 'css', $href_value );
				endforeach;
			else:
				$this->css .= $this->CI->assets->css($href);
				$this->debug_header( 'css', $href );
			endif;
		}
	}

    /**
	 * Inseri link css compactado <head> da página HTML.
	 * 
     * @access  public
     * 
	 * @param  string $href Nome do arquivo css ou endereço localizado na pasta definida no arquivo de configuração.
	 */
	public function css_min( $href , $return_code = false )
	{
		$exist = $this->CI->config->item('layout_min');
		
		$this->debug_header( 'css', $href );
		$this->css_min .= $this->CI->assets->css_min($href , $exist, $return_code );
	}

    /**
	 * Método que inseri conteúdo comum html, text ou resposta de um método view. Se output for definido como TRUE ele gera a saída depois que o conteúdo for inserido.
	 * 
     * @access public
     * 
	 * @param string $content Conteúdo HTML e/ou string.
     * @param boolean $output Define que o output será gerado logo após o conteúdo ser inserido.
	 */
	public function content( $content , $output = FALSE )
	{
		if(is_array($content))
			foreach($content AS $key => $content_value)
				$this->content .= $content_value;
		else
			$this->content .= $content;
		
		if($output)
			$this->output();
	}

    /**
	 * Esse método trabalha exatamente igual ao método VIEW padrão do CI, com a diferença que o último parâmetro boolean define se o OUTPUT será executado logo após o conteúdo ser inserido.
	 * 
     * @access public
     * 
	 * @param string $view Nome da view ou pastas e nome da view.
     * @param array $data Vetor contendo dados que serão usados no processamento da view.
     * @param array $output Define que o output será gerado logo após o conteúdo ser inserido.
     * @param string $load * EM DESENVOLVIMENTO
     * @example $this->layout->view('carro/ferrari',array('cor'=>'vermelha'));
	 */
	public function view( $view, $data = null, $return = true, $load = NULL )
	{
		if($return && $load == NULL)
		{
			$this->debug_content( $view );
			$this->content( $this->CI->load->view( $view, $data, true) );			
		}
		elseif($return == false)
		{
			$this->content( $this->CI->load->view( $view , $data, true ) );
			$this->output();
		}
		elseif($return && $load != NULL)
		{
			$this->debug_content( $view  );			
			
			if($load == 'header')
				$this->layout_header($view, $data = null, $return);
			if($load == 'body')
				$this->layout_body($view, $data = null, $return);
			if($load == 'footer')
				$this->layout_footer($view, $data = null, $return);
		}		
	}
    
    /**
	 * Inserir contéudo antes do CONTENT principal.
	 * 
     * @access public
     *
     * @param string $topContent Conteúdo para ser inserido.
     * @example $this->layout->topContent(<JAVASCRIPT>);
     */
	public function topContent( $topContent )
	{
		$this->topContent .= $topContent;
	}
    
    /**
	 * Inserir contéudo depois do CONTENT principal. Usado principalmente para inserir código do google ou javascript que deve ser processado no fim do carregamento.
	 * 
     * @access public
     *
     * @param string $footerContent Conteúdo para ser inserido.
     * @example $this->layout->footerContent(<JAVASCRIPT>);
     */
	public function footerContent( $footerContent )
	{
		$this->footerContent .= $footerContent;
	}
	
    /**
	 * Inseri mensagens de alert, ajuda ou de sucesso em alguma operação.
	 * 
     * @access public
     *
     * @param string $footerContent Conteúdo para ser inserido.
     * @example $this->layout->footerContent(<JAVASCRIPT>);
     */
	public function flashdata($flashdata)
	{
		$this->flashdata .= $flashdata . '<br/>' . PHP_EOL;
	}
    
    /**
	 * Processa todas as definições de métodos anteriores a sua execução para gerar a saída HTML contendo JS, CSS, META, JS_MIN, CSS_MIN, CONTENT e VIEW.
     * ATENÇÃO: quando sobreescrito os nomes do método e/ou classe o $this->layout->output() não irá executar script contidos nele, essa função foi criada com foco na reutilização das VIEWs carregadas automaticamente. 
	 * 
     * @access public
     *
     * @param string $method Quando definido ele sobreescreve o nome atual do método do controller que executou o OUTPUT na procura pelas VIEWs LAYOUTS.
     * @param string $class Quando definido ele sobreescreve o nome atual da classe do controller que executou o OUTPUT na procura pelas VIEWs LAYOUTS.
     * @example $this->layout->output(<METHOD>,<CLASS>);
     */
	public function output( $method = NULL, $class = NULL)
	{
		// --- Verifica se o autoload deve carregar o layout de outra class e outro método
		if( !is_null($class) )
			$this->class = $class;	
				
		if( !is_null($method) )
			$this->method = $method;
		
		$this->ConfigLayout();
        
		# --- Verifica e inseri js padrão do layout no formato class_method		
		if( file_exists(  $this->config['assets'] . $this->config['js_layout_this']) )
        {
            if( $this->CI->config->item('layout_min_js') == 'single' )
				$this->js_min( base_url() . $this->config['assets'] . $this->config['js_layout_this'], $this->CI->config->item('layout_min') );				
			else
				$this->js( base_url() . $this->config['assets'] . $this->config['js_layout_this'] );
        }
        elseif( file_exists(  $this->config['assets'] . $this->config['js_layout']) )
        {
			if( $this->CI->config->item('layout_min_js') == 'single' )
				$this->js_min( base_url() . $this->config['assets'] . $this->config['js_layout'], $this->CI->config->item('layout_min') );				
			else
				$this->js( base_url() . $this->config['assets'] . $this->config['js_layout'] );
        }
		else
			$this->debug_header('js', '<span  style="color:red">'.$this->config['assets'] . $this->config['js_layout'].' - <em><small  style="color:red">Not Found</small></em></span>');
		
		# --- Verifica e inseri js padrão do class
		if( file_exists(  $this->config['assets'] . $this->config['js_class']) )
			if( $this->CI->config->item('layout_min_js') == 'single' )
				$this->js_min( base_url() . $this->config['assets'] . $this->config['js_class'], $this->CI->config->item('layout_min') );
			else
				$this->js( base_url() . $this->config['assets'] . $this->config['js_class'] );
		else
			$this->debug_header('js', '<span  style="color:red">'.$this->config['assets'] . $this->config['js_class'].' - <em><small  style="color:red">Not Found</small></em></span>');
		
		# --- Verifica e inseri js padrão do method
		if( file_exists(  $this->config['assets'] . $this->config['js_method']) )
			if( $this->CI->config->item('layout_min_js') == 'single' )
				$this->js_min( base_url() . $this->config['assets'] . $this->config['js_method'], $this->CI->config->item('layout_min') );
			else	
				$this->js( base_url() . $this->config['assets'] .$this->config['js_method'] );
		else
			$this->debug_header('js', '<span  style="color:red">'.$this->config['assets'] . $this->config['js_method'].' - <em><small  style="color:red">Not Found</small></em></span>');
		
		# --- Verifica e inseri css padrão do layout no formato class_method
		if( file_exists(  $this->config['assets'] . $this->config['css_layout_this']) )
        {
			if( $this->CI->config->item('layout_min_css') == 'single' )
				$this->css_min( base_url() . $this->config['assets'] . $this->config['css_layout_this'], $this->CI->config->item('layout_min') );
			else
				$this->css( base_url() . $this->config['assets'] . $this->config['css_layout_this'] );
        }
        elseif( file_exists(  $this->config['assets'] . $this->config['css_layout']) )
        {
            if( $this->CI->config->item('layout_min_css') == 'single' )
                $this->css_min( base_url() . $this->config['assets'] . $this->config['css_layout'], $this->CI->config->item('layout_min') );
            else
                $this->css( base_url() . $this->config['assets'] . $this->config['css_layout'] );
        }
		else
			$this->debug_header('css', '<span  style="color:red">'.$this->config['assets'] . $this->config['css_layout'].' - <em><small  style="color:red">Not Found</small></em></span>');
					
		# --- Verifica e inseri css padrão do layout no formato class_method
		if( file_exists(  $this->config['assets'] . $this->config['css_class']) )
			if( $this->CI->config->item('layout_min_css') == 'single' )
				$this->css_min( base_url() . $this->config['assets'] . $this->config['css_class'], $this->CI->config->item('layout_min') );
			else
				$this->css( base_url() . $this->config['assets'] . $this->config['css_class'] );
		else
			$this->debug_header('css', '<span  style="color:red">'.$this->config['assets'] . $this->config['css_class'].' - <em><small  style="color:red">Not Found</small></em></span>');
		
		# --- Verifica e inseri css padrão do layout no formato class_method
		if( file_exists(  $this->config['assets'] . $this->config['css_method']) )
			if( $this->CI->config->item('layout_min_css') == 'single' )
				$this->css_min( base_url() . $this->config['assets'] .$this->config['css_method'], $this->CI->config->item('layout_min') );
			else	
				$this->css( base_url() . $this->config['assets'] .$this->config['css_method'] );
		else
			$this->debug_header('css', '<span  style="color:red">'.$this->config['assets'] . $this->config['css_method'].' - <em><small  style="color:red">Not Found</small></em></span>');
				
		// --- Header
		$layout['title']  = $this->title;
		$layout['meta']   = $this->metas;
		
		# --- Gera minify dos arquivos Javascript inseridos se ele for ativado		
		if( $this->CI->config->item('layout_min_js') == 'disabled' || $this->CI->config->item('layout_min_js') == '' ):
			$layout['js'] = $this->js;
		else:
			// --- Load Driver to minify in your folder system/library/Minify
			$this->CI->load->driver('minify');
			
			// --- Se definido como "auto"
			if($this->CI->config->item('layout_min') == true && $this->CI->config->item('layout_min_js') == 'all')
			{
				if( !file_exists($this->config['assets']. $this->folder .$this->class. '/' .$this->method . '_min.js'))
				{
					$JS = $this->CI->minify->combine_files($this->config['minJS_files']);
					$this->CI->minify->save_file($JS, $this->config['assets']. $this->folder .$this->class. '/' .$this->method . '_min.js');
				}
				$layout['js'] .= $this->CI->assets->js('../'.$this->folder.$this->class. '/' .$this->method . '_min');
			}
			elseif($this->CI->config->item('layout_min_js') == 'all')
			{
				$JS = $this->CI->minify->combine_files($this->config['minJS_files']);
				$this->CI->minify->save_file($JS, $this->config['assets']. $this->folder .$this->class. '/' .$this->method . '_min.js');
				$layout['js'] .= $this->CI->assets->js('../'.$this->folder.$this->class. '/' .$this->method . '_min');
			}
			
		endif;

		# --- Gera minify dos arquivos CSS inseridos se ele for ativado
		if($this->CI->config->item('layout_min_css') == 'disabled' || $this->CI->config->item('layout_min_css') == '' ):
			$layout['css'] = $this->css;	
		else:
			// --- Load Driver to minify in your folder system/library/Minify
			$this->CI->load->driver('minify');
			
			// --- Se definido como "auto" ele irá buscar o arquivo se ele existir não será gerado um novo minfiy
			if($this->CI->config->item('layout_min') == true && $this->CI->config->item('layout_min_css') == 'all')
			{
				if( !file_exists($this->config['assets']. $this->folder .$this->class. '/' .$this->method . '_min.css'))
				{
					$CSS = $this->CI->minify->combine_files($this->config['minCSS_files']);
					$this->CI->minify->save_file($CSS, $this->config['assets']. $this->folder .$this->class. '/' .$this->method . '_min.css');
				}
				$layout['css'] .= $this->CI->assets->css('../'.$this->folder.$this->class. '/' .$this->method . '_min');
			}
			elseif( $this->CI->config->item('layout_min_css') == 'all' )
			{
				$CSS = $this->CI->minify->combine_files($this->config['minCSS_files']);
				$this->CI->minify->save_file($CSS, $this->config['assets']. $this->folder .$this->class. '/' .$this->method . '_min.css');
				$layout['css'] .= $this->CI->assets->css('../'.$this->folder.$this->class. '/' .$this->method . '_min');
			}
		endif;			
		
		// --- Inseri css minify no layout
		$layout['css'] .= $this->css_min;
		// --- Inseri js minify no layout
		$layout['js']  .= $this->js_min;
		
		$parse = count($this->parse);
		
		if( count($parse)>0 )
			foreach($this->parse as $name => $value):
				if($name != 'title' && $name != 'meta' && $name != 'js' && $name != 'js_min' && $name != 'css_min' && $name != 'css' && $name != 'topContent' && $name != 'content' && $name != 'footerContent') 
					$layout[$name] = $value;
			endforeach;
		
		// --- Loads scripts or html when an absolute alignment does not work with your stylesheet
		$layout['topContent']    = $this->topContent;
		// --- Main Content
		$layout['content']  	 = $this->content;		
		// --- Footer scripts or analytics
		$layout['footerContent'] = $this->footerContent;		
		// --- Form message
		$layout['flashdata']     = $this->flashdata;
		
		if( file_exists( APPPATH . 'views/' . $this->config['layout_main_page']) ):
			
			$this->debug_layout( 'Layout Simple',$this->config['layout_main_page']);
            
            if(isset($this->config['layout_main_page_data'])):
                $this->config['layout_main_page']['data'] = array(
                    'content'=>$layout['content'],
                    'topContent'=>$layout['topContent'],
                    'footerContent'=>$layout['footerContent'],
                    'flashdata'=>$layout['flashdata']
                );
                
                $this->CI->load->view( $this->config['layout_main_page'] , $this->config['layout_main_page_data']);
            else:
                $this->CI->parser->parse( $this->config['layout_main_page'] , $layout);
            endif;
            
		else:
			$this->debug_layout('<span  style="color:red"> ' . APPPATH .'views/' . $this->config['layout_main_page'],'<em><small  style="color:red">Not Found</small></em></span>');
			
			// --- Procura layout de primeiro nível onde a librarie parse substitui a variável {content} e gera uma nova saída de conteúdo
        
			if( file_exists( APPPATH . 'views/' . $this->config['layout_method']) )
			{
				$this->debug_layout( 'Layout Method', APPPATH . 'views/' . $this->config['layout_method'] );
                
                if(isset($this->config['layout_method_data'])):
                    $layout['content'] = $this->CI->parser->parse_string($this->CI->load->view( $this->config['layout_method'] , $this->config['layout_method_data'], TRUE), $layout, TRUE);
                else:
                    $layout['content'] = $this->CI->parser->parse( $this->config['layout_method'] , $layout ,TRUE);
                endif;
				
				// --- Define como verdadeira o "parse" das variaveis
				$this->_parseExec = 1;
			}
			else
				$this->debug_layout('<span  style="color:red">' . APPPATH .'views/' . $this->config['layout_method'],'<em><small  style="color:red">Not Found</small></em></span>');
			
			
			// --- Procura layout de primeiro nível onde a librarie parse substitui a variável {content} e gera uma nova saída de conteúdo
			if( file_exists( APPPATH . 'views/' . $this->config['layout_class']) )
			{
				$this->debug_layout( 'Layout Class' ,  APPPATH .'views/' . $this->config['layout_class'] );				
                
                if(isset($this->config['layout_class_data'])):
                    $layout['content'] = $this->CI->parser->parse_string($this->CI->load->view( $this->config['layout_class'] , $this->config['layout_class_data'], TRUE), $layout, TRUE);
                else:
                    $layout['content'] = $this->CI->parser->parse( $this->config['layout_class'] , $layout ,TRUE);
				endif;
				// --- Define como verdadeira o "parse" das variaveis
				$this->_parseExec = 1;
			}			
			elseif( file_exists( APPPATH . 'views/' . $this->config['layout_main_class']) )
			{
				$this->debug_layout( 'Layout Main Class' ,  APPPATH .'views/' . $this->config['layout_main_class'] );				
                
                if(isset($this->config['layout_main_class_data'])):
                    $layout['content'] = $this->CI->parser->parse_string($this->CI->load->view( $this->config['layout_main_class'] , $this->config['layout_main_class_data'], TRUE), $layout, TRUE);
                else:
                    $layout['content'] = $this->CI->parser->parse( $this->config['layout_main_class'] , $layout ,TRUE);
				endif;
                
				// --- Define como verdadeira o "parse" das variaveis
				$this->_parseExec = 1;
			}
			elseif( file_exists( APPPATH . 'views/' . $this->config['main_class']) )
			{
                
				$this->debug_layout( 'Main Class' ,  APPPATH .'views/' . $this->config['main_class'] );				
                
                if(isset($this->config['main_class_data'])):
                    $layout['content'] = $this->CI->parser->parse_string($this->CI->load->view( $this->config['main_class'] , $this->config['main_class_data'], TRUE), $layout, TRUE);
                else:
                    $layout['content'] = $this->CI->parser->parse( $this->config['main_class'] , $layout ,TRUE);
				endif;
                
				// --- Define como verdadeira o "parse" das variaveis
				$this->_parseExec = 1;
			}
			else
                $this->debug_layout('<span  style="color:red">' . APPPATH . 'views/' .  $this->config['layout_class'],'<em><small  style="color:red">Not Found</small></em></span>');
			
			// --- Procura layout principal
			if( file_exists(APPPATH . 'views/' . $this->config['layout_main']) )
			{	
				if($this->debug['active'] == TRUE)
				{
					$this->debug_layout( 'Layout Main', APPPATH . 'views/' . $this->config['layout_main'] );
	
					// ---  Gera debug se ele estiver ativo
					$layout['footerContent'] .= $this->debug();	
				}	
				
                if(isset($this->config['layout_main_data'])):
                    $layout['content'] = $this->CI->parser->parse_string($this->CI->load->view( $this->config['layout_main'] , $this->config['layout_main_data'], TRUE), $layout, TRUE);
                else:
                    $this->CI->parser->parse( $this->config['layout_main'] , $layout );	
                endif;	
			}
			elseif( file_exists( APPPATH . 'views/' . $this->config['main']) )
			{
				$this->debug_layout('<span  style="color:red">' . APPPATH . 'views/' .  $this->config['layout_main'],'<em><small  style="color:red">Not Found</small></em></span>');
				if($this->debug['active'] == TRUE)
				{
					$this->debug_layout( 'Layout Main', APPPATH . 'views/' . $this->config['main'] );
				
					// ---  Gera debug se ele estiver ativo
					$layout['footerContent'] .= $this->debug();
				}
				if(isset($this->config['main_data'])):
                    $this->CI->parser->parse_string($this->CI->load->view( $this->config['main'] , $this->config['main_data'], TRUE), $layout);
                else:
                    $this->CI->parser->parse( $this->config['main'] , $layout );
                endif;
			}
			else
			{
				$this->debug_layout('<span  style="color:red">' . APPPATH . 'views/' .  $this->config['main'],'<em><small  style="color:red">Not Found</small></em></span>');
				$this->debug_layout('<span  style="color:red">' . APPPATH . 'views/' .  $this->config['layout_main'],'<em><small  style="color:red">Not Found</small></em></span>');
				
				$html = $this->layout_header();
				
				// --- Verifica se as variaveis "parse" foram substituidas
				if($this->_parseExec == 1)
				{
					$html .= $layout['content'];
					$html .= $this->layout_footer();
				
					echo $html;
				}
				else
				{
					$html .= $layout['flashdata'];
					$html .= $layout['topContent'];
					$html .= $layout['content'];
					$html .= $layout['footerContent'];
					$html .= $this->layout_footer();
				
					echo $html;
				}
			}
		endif;
	}
	
    public function outmethod()
    {
        $outmethod = layout_header();
        
        
        
        $outmethod = layout_footer();
        
        echo $outmethod;
    }
    
	# --- Em desenvolvimento
	public function layout_header()
	{	
		$this->CI->load->helper('html');		
		$this->_doctype =  doctype('html4-trans');

		$this->_header  = $this->_doctype.PHP_EOL;
		$this->_header .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$this->CI->config->item('layout_lang').'">'.PHP_EOL;
		$this->_header .= '<head>'.PHP_EOL;
		$this->_header .= '<title>'.$this->title.'</title>'.PHP_EOL;
		$this->_header .= '<!-- Meta Layout -->'.PHP_EOL;
		$this->_header .= $this->metas;
		$this->_header .= '<!-- Javascript Layout-->'.PHP_EOL;
		$this->_header .= $this->js;
		$this->_header .= '<!-- Javascript Layout Minify -->'.PHP_EOL;
		$this->_header .= $this->js_min;
		$this->_header .= '<!-- Stylesheet Layout-->';
		$this->_header .= $this->css ."\n";
		$this->_header .= '<!-- Stylesheet Layout Minify -->'.PHP_EOL;
		$this->_header .= $this->css_min;
		$this->_header .= '</head>'.PHP_EOL;
		$this->_header .= '<body>'.PHP_EOL;
		
		return $this->_header;
	}
	
	public function layout_footer()
	{
		if($this->debug['active'] == TRUE)
			$this->_footer = $this->debug();
		
		$this->_footer  .= PHP_EOL.'</body>'.PHP_EOL;
		$this->_footer .= '</html>'.PHP_EOL;
		
		return $this->_footer;
	}
	
	private function debug()
	{
		if( strpos( $_SERVER['HTTP_HOST'] ,"localhost" ) !== FALSE ){
			if($this->debug['active'] == true)
			{
				$this->CI->output->enable_profiler(TRUE);
				
				$debug  = '<div id="codeigniter_layout_debug" style="clear:both;background-color:#e4e4e4;padding:10px;">';
				$debug .= '<fieldset style="border:1px solid #8080FF;background:#f4f4f4;"><legend style="color:#8080FF;">META</legend><table>'  . $this->debug['meta'] . '</table></fieldset>';
				$debug .= '<fieldset style="border:1px solid #FF0000;background:#f4f4f4;"><legend style="color:#FF0000;">Javascript</legend><table>'  . $this->debug['js'] . '</table></fieldset>';
				$debug .= '<fieldset style="border:1px solid #FF80FF;background:#f4f4f4;"><legend style="color:#FF80FF;">Stylesheet</legend><table>'  . $this->debug['css'] . '</table></fieldset>';
				$debug .= '<fieldset style="border:1px solid #FF8000;background:#f4f4f4;"><legend style="color:#FF8000;">Layout Load</legend><table>' . $this->debug['layout'] . '</table></fieldset>';
				$debug .= '<fieldset style="border:1px solid #8000FF;background:#f4f4f4;"><legend style="color:#8000FF;">Content Load</legend><table>' . $this->debug['content'] . '</table></fieldset>';
                $debug .= '<fieldset style="border:1px solid #800000;background:#f4f4f4;"><legend style="color:#800000;">Load Module</legend><table>' . $this->debug['module'] . '</table></fieldset>';
				$debug .= '</div>';
			}else{
				$debug = '';
			}
		}else{
			$debug = '';
		}
	
		return PHP_EOL.$debug;
	}
	
	private function debug_content( $view )
	{
		$this->debug['content'] = '<tr><td><span style="color:#333;">' . $view . '</span></td></tr>';
	}
	
	private function debug_header( $type, $link )
	{
		if($type == 'meta')
			$this->debug['meta'] .= '<tr><td><span style="color:#333;">' . htmlentities($link) . '</span></td></tr>';			
		elseif($type == 'js')
			$this->debug['js']   .= '<tr><td><span style="color:#333;">' . $link . '</span></td></tr>';
		elseif($type == 'css')
			$this->debug['css']  .= '<tr><td><span style="color:#333;">' . $link . '</span></td></tr>';
	}
	
	private function debug_layout( $title = '', $data )
	{
		$this->debug['layout'] .= '<tr><td><span style="color:#333;">'. $title . ' <strong>' . $data . '</strong></span></td></tr>';
	}
    
    private function debug_module( $title = 'Module', $data, $type = TRUE)
    {
        $text = '';
        
        if($type == TRUE):
            $color = 'none';
        else:
            $color = 'red';
            $text = 'Not found';
        endif;
        
        $this->debug['module'] .= '<tr><td><span style="color:#333;">'. $title . ' <strong><span style="color:'.$color.'">' . $data . ' '. $text .'</span></strong></span></td></tr>';
    }

	 
/* --------------------     Modelo para criar o main_layout.php   --------------------------

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
	<title>{title}</title>
		
	{meta}
	{js}
	{css}
		
</head>
<body>
	{topContent}
		
	<!-- Content Layout -->
	{content}
		
	{footerContent}
</body>
</html>

*/
	
}

/* End of file Layout.php */
/* Location: ./system/libraries/Layout.php */