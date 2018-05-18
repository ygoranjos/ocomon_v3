<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chamados extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        $this->layout->page = 'Chamados';

        $this->layout->css( array(
            'vendor/datatables-plugins/dataTables.bootstrap',
            'vendor/datatables-responsive/dataTables.responsive',
        ));

        $this->layout->js(array(
            'css/vendor/datatables/js/jquery.dataTables.min',
            'css/vendor/datatables-plugins/dataTables.bootstrap.min',
            'css/vendor/datatables-responsive/dataTables.responsive'
        ));
        $this->load->model('chamados_model');

        $this->load->library('table');

        $template = array(
            'table_open' => '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTable">'
        );

        $perfil = $this->chamados_model->get_perfil($this->session->userdata('perfil'));

        $this->layout->set(array(
            'areas' => $this->get_areas($perfil['permissao_areas']),
            'empresas' => $this->get_empresas($perfil['permissao_empresas'])
        ));

        $this->table->set_template($template);

    }

    public function index() {

        $chamados = $this->chamados_model->get_chamados_operador($postData);

        $this->table->set_heading('Name', 'Color', 'Size');
        $this->table->add_row(array('Fred', 'Blue', 'Small'));
        $this->table->add_row(array('Mary', 'Red', 'Large'));
        $this->table->add_row(array('John', 'Green', 'Medium'));
        $data_table = $this->table->generate();

        $this->layout->table_chamados = $data_table;

        $this->layout->output();
    }

    public function meus_chamados() {

        $this->table->set_heading('Chamado', 'Contato', 'Ações');

        $dados = array(
            'id_user'=>$this->session->userdata('id_user')
        );
        
        $chamados = $this->chamados_model->get_chamados_user($dados);

        foreach ($chamados as $row)
        {
            $this->table->add_row(array(
                $row->id_chamado,
                $row->contato,
                'ver chamado'
            ));
        }

        $data_table = $this->table->generate();

        $this->layout->table_chamados = $data_table;


        $this->layout->output();
    }

    public function abrir_chamado() {

        $this->layout->nome = $this->session->userdata('nome');
        $this->layout->telefone = $this->session->userdata('telefone');

        $this->layout->set(array(
            
        ));
        
        $this->layout->output();
    }

    public function inserir_chamado() {
        
        $this->layout->output();
    }

    public function get_departamentos($id_filial = null) {
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $departamentos= array();
        $departamentos['options'][] = array('value'=>'','text'=>'Selecione');

        if($id_filial == null){
            echo json_encode($departamentos);
            exit;
        }

        $query_departamentos = $this->chamados_model->get_departamentos($id_filial);
        
        foreach ($query_departamentos as $row)
        {
            $departamentos['options'][] = array('value'=>$row['id_departamento'],'text'=>$row['nome_departamento']);
        }

        echo json_encode($departamentos);

    }

    public function get_problemas($id_area = null) {
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $problemas= array();
        $problemas['options'][] = array('value'=>'','text'=>'Selecione');

        if($id_area == null){
            echo json_encode($problemas);
            exit;
        }

        $query_problemas = $this->chamados_model->get_problemas($id_area);
        
        foreach ($query_problemas as $row)
        {
            $problemas['options'][] = array('value'=>$row['id_problema'],'text'=>$row['nome_problema']);
        }

        echo json_encode($problemas);

    }

    public function get_sub_problemas($id_problema = null) {
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $options = array();
        $options['options'][] = array('value'=>'','text'=>'Selecione');

        if($id_problema == null){
            echo json_encode($options);
            exit;
        }

        $query = $this->chamados_model->get_sub_problemas($id_problema);
        
        foreach ($query as $row)
        {
            $options['options'][] = array('value'=>$row['id_sub_problema'],'text'=>$row['nome_sub_problema']);
        }

        echo json_encode($options);

    }

    public function get_filiais($id_empresa = null) {
        
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $options = array();
        $options['options'][] = array('value'=>'','text'=>'Selecione');

        if($id_empresa == null){
            echo json_encode($options);
            exit;
        }

        $query = $this->chamados_model->get_filiais($id_empresa);
        
        foreach ($query as $row)
        {
            $options['options'][] = array('value'=>$row['id_filial'],'text'=>$row['nome_filial']);
        }

        echo json_encode($options);

    }

    private function get_areas($permissao){

        $query_areas = $this->chamados_model->get_areas($permissao);
        $areas =array(''=>'Selecione');
        foreach ($query_areas as $row)
        {
            $areas[$row['id_area']] = $row['nome_area'];
        }

        return $areas;
    }

    private function get_empresas($permissao){

        $query_empresas = $this->chamados_model->get_empresas($permissao);
        $empresas = array(''=>'Selecione');
        foreach ($query_empresas as $row)
        {
            $empresas[$row['id_empresa']] = $row['nome_empresa'];
        }

        return $empresas;
    }


}

/* End of file */
