
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">{page}</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Abrir Chamado
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="col-lg-12">
                            <?= form_open_multipart('chamados/inserir_chamado'); ?>

                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input name="nome" class="form-control" value="{nome}">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Telefone/Ramal</label>
                                            <input name="telefone" class="form-control" value="{telefone}">
                                        </div>

                                        <div class="form-group">
                                            <label>Equipamento</label>
                                            <input name="equipamento" class="form-control" >
                                        </div>

                                        <div class="form-group">
                                            <label>Empresa</label>
                                            <?= form_dropdown('empresa', $empresas,'',array('class'=>'form-control','id'=>'empresa')); ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Filial</label>
                                            <select name="filial" id="filial" class="form-control">
                                               
                                            </select>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label>Departamento</label>
                                            <select name="departamento" id="departamento" class="form-control">
                                               
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Área</label>
                                            <?= form_dropdown('area', $areas,'',array('class'=>'form-control','id'=>'area')); ?>                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Problema</label>
                                            <select name="problema" id="problema" class="form-control">   
                                            </select>                                                                                    
                                        </div>

                                        <div class="form-group">
                                            <label>Sub Problema</label>
                                            <select name="sub-problema" id="sub-problema" class="form-control">  
                                                                                             
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Descrição</label>
                                            <textarea name="descricao" class="form-control" rows="5"></textarea>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label>Anexo</label>
                                            <input type="file">
                                        </div>
                                        
                                        
                                        <button type="submit" class="btn btn-default">Abrir Chamado</button>
                                        
                                        <?= form_close(); ?>
                                </div>
                            
                        
                        

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>

             
        

       