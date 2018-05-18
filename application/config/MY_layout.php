<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
####################################################################################
| AVISO: A LIBRAY LAYOUT USA A LIBRARY ASSETS ENTÃO AMBAS DEVEM ESTAR CONFIGURADAS 
####################################################################################
*/


/*
|--------------------------------------------------------------------------
| Configurações para library LAYOUT
|--------------------------------------------------------------------------
|
| Define uma pasta padrão para arquivos como css, javascript e layouts
| usado na library layout
|
*/

// --- Nome da pasta de layouts para arquivos css e js. Deve estar no primeiro nível da pasta $config['asset_path']
$config['layout_folder']  = 'layouts/';

// --- Procurar arquivo minify antes de gerar o arquivo?
$config['layout_min']	  = true;				/* true / false */

// --- Configuração do minify para arquivos javascript ( o processamento em tempo real de arquivo js é muito lento
$config['layout_min_js']  = 'disabled';			/* disabled / all / single */

// --- Configuração do minify para arquivos de folha de estilo
$config['layout_min_css'] = 'disabled';			/* disabled / enabled / auto */

// --- Nome do arquivo principal do layout
$config['layout_main']    = 'main_layout';

// --- Liguagem para gerar o html sem o uso de um template layou_main
$config['layout_lang']	  = 'pt-br';

// --- Configuração do doctype da sem o uso de um template layou_main
$config['layout_doctype'] = 'html4-trans';		/* xhtml11  xhtml1-strict  xhtml1-trans  xhtml1-frame  html5  html4-strict  html4-trans html4-frame */
