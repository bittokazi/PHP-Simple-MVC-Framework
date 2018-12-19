<?php Core\View::loadView('Backend/header'); ?>
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
         
            <?php if(isset($data->success) || isset($data->error)) { ?>
             
            <div class="col-md-12">
                 <div class="alert alert-dismissible alert-<?php if(isset($data->success)) echo 'success'; else echo 'danger'; ?>">
                        <button class="close" type="button" data-dismiss="alert">×</button>
                        <?php if(isset($data->success)) echo $data->success; else echo $data->error; ?>
                    </div>
            </div>
            
            <?php } ?>
         
          <div class="col-md-12">
            <div class="card">
              <h3 class="card-title">User List</h3>
              <table class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php foreach($users as $user) { ?>
                        <tr>
                            <th><?php echo $user->id; ?></th>
                            <th><?php echo $user->username; ?></th>
                            <th><?php echo $user->email; ?></th>
                            <th><?php echo $user->firstname; ?></th>
                            <th><?php echo $user->lastname; ?></th>
                            <th><?php echo $user->title; ?></th>
                            <th><a href="<?php echo Core\URL::to('dashboard/users/edit/').$user->id; ?>"><i class="fa fa-pencil"></i></a></th>
                            <th><a href="<?php echo Core\URL::to('dashboard/users/delete/').$user->id; ?>"><i class="fa fa-trash"></i></a></th>
                        </tr>
                        <?php } ?>
                  </tbody>
              </table>
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
<?php Core\View::loadView('Backend/footer'); ?>