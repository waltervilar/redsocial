<?php
session_start();
include 'lib/config.php';
include 'lib/socialnetwork-lib.php';

ini_set('error_reporting',0);

if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
}
?>

<?php
  if(isset($_GET['id']))
  {
  $id = mysqli_real_escape_string($connect, $_GET['id']);
  $pag = $_GET['perfil'];

  $infouser = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_use = '$id'");
  $use = mysqli_fetch_array($infouser);

  $amigos = mysqli_query($connect, "SELECT * FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
  $ami = mysqli_fetch_array($amigos);
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $use['nombre']; ?> | REDPOL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- codigo scroll -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/jquery.jscroll.js"></script>
  <!-- codigo scroll -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php echo Headerb (); ?>

  <?php echo Side (); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="avatars/<?php echo $use['avatar'];?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $use['nombre'];?></h3> 
              <?php if($use['verificado'] != 0) {?>
              <center><span class="glyphicon glyphicon-ok"></span></center>
              <?php } ?>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>
              
              <?php if($_SESSION['id'] != $id) {?>
              <form action="" method="post">
              
              <?php if(mysql_num_rows($amigos) >= 1 AND $ami['estado'] == 0) { ?>
              <center><h4>Esperando respuesta</h4></center>
              <?php } else { ?>

              <?php if($use['privada'] == 1 AND $ami['estado'] == 0) { ?>
              <input type="submit" class="btn btn-primary btn-block" name="seguir" value="Enviar solicitud de amistad">
              <?php } ?>
              <?php if($use['privada'] == 1 AND $ami['estado'] == 1) { ?>
              <input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">
              <?php } ?>
              <?php if($use['privada'] == 0 AND $ami['estado'] == 0) { ?>
              <input type="submit" class="btn btn-primary btn-block" name="seguirdirecto" value="Seguir">
              <?php } ?>
              <?php if($use['privada'] == 0 AND $ami['estado'] == 1) { ?>
              <input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">
              <?php } ?>


              <?php } ?>
              </form>
              <?php } ?>

              <?php
              if(isset($_POST['seguir'])) {
                $add = mysqli_query($connect, "INSERT INTO amigos (de,para,fecha,estado) values ('".$_SESSION['id']."','$id',now(),'0')");
                if($add) {echo '<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>

              <?php
              if(isset($_POST['seguirdirecto'])) {
                $add = mysqli_query($connect, "INSERT INTO amigos (de,para,fecha,estado) values ('".$_SESSION['id']."','$id',now(),'1')");
                if($add) {echo '<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>

              <?php
              if(isset($_POST['dejarseguir'])) {
                $add = mysqli_query($connect, "DELETE FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
                if($add) {echo '<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>
              
              <br>
              <a href="chat.php?usuario=<?php echo $id; ?>"><input type="button" class="btn btn-default btn-block" name="dejarseguir" value="Enviar chat"></a>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php echo $pag == 'miactividad' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=miactividad">Actividad</a></li>
              <li class="<?php echo $pag == 'informacion' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=informacion">Información</a></li>
              <li class="<?php echo $pag == 'fotos' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=fotos">Fotos</a></li>
            </ul>
            <div class="tab-content">

                
          <!-- codigo scroll -->
          <div class="scroll">

          <?php
          if($use['privada'] != 1) { ?>
          
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
            require_once $pagina.'.php';
            ?>

          <?php } elseif ($use['privada'] == 1 AND $ami['estado'] == 1) { ?>
              
            <?php
            $pagina = isset( $_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
            require_once $pagina.'.php';
            ?>

          <?php } elseif ($use['privada'] == 1 AND $_SESSION['id'] == $id) { ?>
              
            <?php
            $pagina = isset( $_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
            require_once $pagina.'.php';
            ?>


          <?php } else { ?>

          <center><h2>Este perfil es privado, envia una solicitud</h2></center>

          <?php } ?>

          </div>

            
                
              </div>
  
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php

} // finaliza if GET
?>