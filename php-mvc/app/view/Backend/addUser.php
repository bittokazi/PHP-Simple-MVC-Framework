<?php Core\view::load('Backend/header', $data); ?>
      <div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-users"></i> User Management</h1>
            <p>All User List Shown Below</p>
          </div>
          <div>
            <ul class="breadcrumb">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li><a href="#">User List</a></li>
            </ul>
          </div>
        </div>
        <div class="row">
         
            <?php if(isset($data->data['error'])) { ?>
             
            <div class="col-md-12">
                 <?php foreach($data->data['error'] as $error) { ?>
                 
                 <div class="alert alert-dismissible alert-danger">
                        <button class="close" type="button" data-dismiss="alert">×</button>
                        <?php echo $error; ?>
                      </div>
                 
                 <?php } ?>
            </div>
            
            <?php } ?>
         
          <div class="col-md-12">
            <div class="card">
              <h3 class="card-title">Add User</h3>
              
              <form action="" method="POST">
                  
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input class="form-control" type="text" placeholder="Enter first name" name="fname" value="<?php if(isset($data->data['data'])) echo $data->data['data'][3]; ?>">
                </div>
                
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input class="form-control" type="text" placeholder="Enter last name" name="lname" value="<?php if(isset($data->data['data'])) echo $data->data['data'][4]; ?>">
                </div>
                
                <div class="form-group">
                    <label class="control-label">Username</label>
                    <input class="form-control" type="text" placeholder="Enter username" name="username" value="<?php if(isset($data->data['data'])) echo $data->data['data'][0]; ?>">
                </div>
                
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input class="form-control" type="email" placeholder="Enter email" name="email" value="<?php if(isset($data->data['data'])) echo $data->data['data'][2]; ?>">
                </div>
                 
                <div class="form-group">
                    <label class="control-label">Select Role</label>
                    <select class="form-control" id="select" name="role">
                        <?php foreach($data->roles as $role) { ?>
                        <option value="<?php echo $role->id; ?>" <?php if(isset($data->data['data'])) { if($data->data['data'][6]==$role->id) echo 'selected'; } ?>><?php echo $role->title; ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Select Status</label>
                    <select class="form-control" id="select" name="status">
                       
                        <option value="1" <?php if(isset($data->data['data'])) { if($data->data['data'][5]==1) echo 'selected'; } ?>>Enabled</option>
                        
                        <option value="0" <?php if(isset($data->data['data'])) { if($data->data['data'][5]==0) echo 'selected'; } ?>>Disabled</option>
                        
                    </select>
                </div>
                 
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input class="form-control" type="password" placeholder="Enter password" name="password">
                </div>
                 
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
                  
              </form>
              
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- Javascripts-->
    <script src="<?php echo Core\URL::asset('assets/js/jquery-2.1.4.min.js'); ?>"></script>
    <script src="<?php echo Core\URL::asset('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo Core\URL::asset('assets/js/plugins/pace.min.js'); ?>"></script>
    <script src="<?php echo Core\URL::asset('assets/js/main.js'); ?>"></script>
<?php Core\view::load('Backend/footer', $data); ?>