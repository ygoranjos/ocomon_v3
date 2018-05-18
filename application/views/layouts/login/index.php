

	<div class="container">
	    <div class="row">
	        <div class="col-md-4 col-md-offset-4">
	            <div class="login-panel panel panel-default">
	                <div class="panel-heading">
	                    <h3 class="panel-title">{company}</h3>
	                </div>
	                <div class="panel-body">
	                	<small id="login-empty-input" class="error">Email ou Senha não podem ser vazios <br>&nbsp;</small>
	                	<?php if($alert): ?>
	                		<small id="login-invalid-input" class="error">Email ou Senha incorretos<br>&nbsp;</small>
	                	<?php endif; ?>

	                    <form role="form" method="post" onsubmit="return checkEmptyInput();" action="<?=base_url()?>login/login/">
	                        <fieldset>
	                            <div class="form-group">
	                                <input class="form-control" id="email" placeholder="E-mail" name="email" type="email" autofocus>
	                            </div>
	                            <div class="form-group">
	                                <input class="form-control" id="password" placeholder="Senha" name="password" type="password" value="">
	                            </div>
	                            
	                            <input id="login-submit" type="submit" value="Login" class="btn btn-lg btn-success btn-block">
	                        </fieldset>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

