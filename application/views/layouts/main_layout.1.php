<!DOCTYPE html>
<html lang="en">
<head>

	<title>{title}</title>
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/codeigniter_logo.png" type="image/x-icon">
		{meta}
		
		{css}

</head>

<body>
    <div class="overlay"></div>
    <img id="loading"  width="250px" src="<?=base_url()?>assets/images/loading.gif" alt="Loading...">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">#</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=base_url();?>">
                    <div class="inline"> {company} </div>
                </a>

            </div>
            <!-- /.navbar-header -->
            
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a  id="header-dropdown" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i id="header-icon" class="fa fa-user fa-fw"></i>  <i id="header-icon" class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!-- <li><a href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-refresh fa-fw"></i> Change Password</a></li>
                        <li class="divider"></li> -->
                        <li><a href="<?=base_url();?>login/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            
            <!-- /.navbar-top-links -->


        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">CHANGE PASSWORD (<?=$this->session->userdata('email')?>)</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="error" id="error_changePassword">invalid current password</label>
                                <label class="error" id="error_changePassword2">password must be at least 8 characters (alphanumeric or special characters)</label>
                            </div>
                        </div>
                        &nbsp;
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Current Password</label> &nbsp;&nbsp;
                                    <label class="error" id="error_currentPassword"> field is required.</label>
                                    <input class="form-control" id="currentPassword" placeholder="Current Password" name="currentPassword" type="password" autofocus>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>New Password</label> &nbsp;&nbsp;
                                    <label class="error" id="error_newPassword"> field is required.</label>
                                    <label class="error" id="error_newPassword2"> password not match</label>
                                    <input class="form-control" id="newPassword" placeholder="New Password" name="newPassword" type="password" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Confirm New Password</label> &nbsp;&nbsp;
                                    <input class="form-control" id="confirmNewPassword" placeholder="Confirm New Password" name="confirmNewPassword" type="password" autofocus>
                                </div> 
                            </div>
                      </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        <button id="changePasswordSubmit" type="button" class="btn btn-primary">UPDATE</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div> 
		<!-- /.modal -->

		<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <?php echo '<p class="welcome"><b> <text style="font-size:150%;">&#9786</text> <i>Bem-vindo </i>' . $this->session->userdata('name') . "!</b></p>"; ?>
                        </li>
                        <li>
                            <a href="<?=base_url()?>"><i class="fa fa-home fa-fw"></i> Abrir Chamado</a>
                        </li>
                        
                        <?php if($this->session->userdata('role') == 'admin'): ?>
                            <li>
                                <a href="<?=base_url()?>"><i class="fa fa-home fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                            <a href="<?=base_url()?>"><i class="fa fa-home fa-fw"></i> Chamados</a>
                        </li>
                            <li>
                                <a href="#"><i class="fa fa-user fa-fw"></i> Administrar<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li> <a href="<?=base_url('admin/user_list')?>">&raquo; User List</a> </li>
                                    <li> <a href="<?=base_url('admin/activity_log')?>">&raquo; Activity Log</a> </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Other Menu Sample<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="#">&raquo; Other Sub Menu 1</a> </li>
                                <li> <a href="#">&raquo; Other Sub Menu 2</a> </li>
                            </ul>
                        </li>
                  
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
		</nav>
		
		<div id="page-wrapper">
            <?php if($this->session->flashdata('success')):?>
                &nbsp;<div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $this->session->flashdata('success'); ?></strong>
                </div>
            <?php elseif($this->session->flashdata('error')):?>
                &nbsp;<div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $this->session->flashdata('error'); ?></strong>
                </div>
            <?php endif;?>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">{page}</h3>
                </div>
                <div class="col-lg-12">
                    <div class="row">
						{topContent}
		
						<!-- Content Layout -->
						{content}
							
						{footerContent}
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- wrapper -->


    <div class="col-lg-12 text-center" style="padding:5px;"><small>&copy; 2018 by <a target="_blank" href="https://www.linkedin.com/in/ygor-anjos-90a1057b">Ygor Anjos</a></small></div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	{js}
    

    



</body>

</html>