

<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree Shubh Holidays</title>

  <!-- REQUIRED CSS -->
  <?php include 'link-css.php'; ?>
  <!-- // REQUIRED CSS -->

  <style media="screen">
    #btnSubmit:hover{
      background: #f5b120;
      color: white;
    }
  </style>

</head>

<body class="hold-transition skin-yellow-light sidebar-mini">
  <div class="wrapper">

   

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Send Email
          <small>Here You can Send email to customers.</small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content container-fluid">

        <div class="row">
          <!-- left column -->
          <div class="col-md-7 col-md-offset-2">
            <!-- general form elements -->
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Send Email</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form role="form" method="post" action="sendmail2.php" enctype="multipart/form-data">
                <div class="box-body">
                  
                    <div class="form-group">
                    <!-- <input type="hidden" class="form-control" id="inputcid" name="inputcid" value="<?php echo $rid; ?>" placeholder="Enter Customer Id"> -->
                    <label for="inputfname">Name</label>
                    <input type="text" class="form-control" id="inputfname" name="inputfname" placeholder="Enter First Name">
                  </div>
                                                <div class="form-group">
                    <label for="inputemail">Email</label>
                    <input type="text" class="form-control" id="inputemail" name="inputemail" placeholder="Enter Email">
                  </div>
                        
                                           
                  <div class="form-group">
                    <label for="file">Upload PDF</label>
                    <input type="file" id="file" name="file" size="50">
                    <label style="color: RED">PDF should be smaller in size</label>
                    <label style="color: RED">Write unique PDF File Name</label>
                  </div>
                
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.box -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->


      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

 

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->
  <?php include 'link-js.php'; ?>
  <!-- // REQUIRED JS SCRIPTS -->

</body>
</html>
