<!-- Agregar Nuevo -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<div class="modal-header">
		        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		    </div>
            <div class="modal-body">
			<div class="container-fluid">
			
			<form method="POST" action="add.php">
				  <div class="mb-1">
				    <label for="exampleInputEmail1" class="form-label">Email address</label>
				    <input type="email" class="form-control shadow-none" id="exampleInputEmail1">
				  </div>
				  <div class="mb-1">
				    <label for="exampleInputPassword1" class="form-label">Password</label>
				    <input type="password" class="form-control shadow-none" id="exampleInputPassword1">
				  </div>
  				  <div class="mb-1">
				    <label for="exampleInputEmail1" class="form-label">Email address</label>
				    <input type="email" class="form-control shadow-none" id="exampleInputEmail1">
				  </div>
				  <div class="mb-1">
				    <label for="exampleInputPassword1" class="form-label">Password</label>
				    <input type="password" class="form-control shadow-none" id="exampleInputPassword1">
				  </div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        		<button type="button" class="btn btn-primary">Save changes</button>
			</form>
            </div>
        </div>
    </div>
</div>
