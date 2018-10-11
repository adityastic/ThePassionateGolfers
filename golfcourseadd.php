<?php
include "connect.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['mobileno']) || empty($_SESSION['mobileno'])) {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Add Golf Course</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>

<?php include("includes/header.php"); ?>

<div class="container-fluid">
  <div class="row"> <br>
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-flag"></span> Add Golf Course</div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data" name="theform" onSubmit="return valid()" action="golfcourseadd2.php">
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <div class="row">
                  <div class="col-md-6">
                    <label class="control-label">Golf Course Name</label>
                    <select name="gcfullname" required class="form-control">
                      <option value="">Select Golf Course name</option>
                      <?php
						$get2 = mysqli_query($conn, "SELECT * FROM tbcourse ORDER BY coursename");
						while ($row2 = mysqli_fetch_array($get2)) {
						$coursename  = $row2['coursename'];
						?>
                      <option value="<?php echo $coursename; ?>"><?php echo $coursename; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="control-label">Golf Course Short Name</label>
                    <select name="gcshortname" required class="form-control">
                      <option value="">Select Golf Course Short name</option>
                      <?php
							$get2 = mysqli_query($conn, "SELECT * FROM tbcourse ORDER BY coursename");
							while ($row2 = mysqli_fetch_array($get2)) {
							$courseshortname  = $row2['courseshortname'];
						?>
                      <option value="<?php echo $courseshortname; ?>"><?php echo $courseshortname; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <label class="control-label">Golf Course Image</label>
                <div class="panel-body" >
                  <div class="row" style="max-height: 140px;overflow-y: scroll;">
                    <?php $get2 = mysqli_query($conn, "SELECT * FROM tbcourse");
							while ($row2 = mysqli_fetch_array($get2)) {
								$courseimg  = $row2['courseimg'];
								?>
                   			<div class="col-md-4" style="margin-top:10px; margin-bottom:10px;"> <img src="images/<?php echo $courseimg; ?>" alt="Golf Course Image" width="220" height="120" onClick="changeValue(this.src)" /> </div>
                    <?php } ?>
                  </div>
                </div>
                <input type="hidden" class="form-control" readonly="true" name="gcimage" accept="image/*" />
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <label class="control-label">Description</label>
                <textarea class="form-control" name="description" placeholder="Enter Course Description" rows="6" ></textarea>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <label class="control-label">City</label>
                <select name="city" class="form-control" required>
                  <option value="">Select City</option>
                  <?php
						$get2 = mysqli_query($conn, "SELECT * FROM coursecity ORDER BY city");
						while ($row2 = mysqli_fetch_array($get2)) {
						$city  = $row2['city'];
					?>
                  <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-1"> </div>
            </div>
            <div id="myRadioGroup">
              <div class="row">
                <div class="col-md-1"></div>
                <div class="form-group col-md-10">
                  <!-- Full Name -->
                  <label for="full_name_id" class="control-label">Number of Holes</label>
                  <br>
                  <label class="radio-inline">
                  <input type="radio" id="full_name_id" name="par" value="9" checked>
                  1-9 Holes</label>
                  <label class="radio-inline">
                  <input type="radio" id="full_name_id" name="par" value="18">
                  10-18 Holes</label>
                </div>
                <div class="col-md-1"></div>
              </div>
              <div id="par9" >
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="form-group col-md-10">
                    <!-- Full Name -->
                    <div class="row">
                      <div class="col-md-6">
                        <label for="full_name_id" class="control-label">Number of Pars</label>
                        <br>
                        <select name="holes[]" >
                          <option value="">Hole 1</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 3</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <br>
                        <select name="holes[]" >
                          <option value="">Hole 4</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 5</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 6</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <br>
                        <select name="holes[]" >
                          <option value="">Hole 7</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 8</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 9</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="full_name_id" class="control-label">Stroke Index</label>
                        <br>
                        <select name="strokeindex[]" >
                          <option value="">Hole 1</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 2</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 3</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <br>
                        <select name="strokeindex[]" >
                          <option value="">Hole 4</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <select name="strokeindex[]">
                          <option value="">Hole 5</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 6</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <br>
                        <select name="strokeindex[]" >
                          <option value="">Hole 7</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 8</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 9</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </div>
              </div>
              <div id="par18" class="desc"  style="display: none;">
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="form-group col-md-10">
                    <!-- Full Name -->
                    <div class="row">
                      <div class="col-md-6">
                        <label for="full_name_id" class="control-label">Number of Pars</label>
                        <br>
                        <select name="holes[]" >
                          <option value="">Hole 10</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 11</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 12</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <br>
                        <select name="holes[]" >
                          <option value="">Hole 13</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 14</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 15</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <br>
                        <select name="holes[]" >
                          <option value="">Hole 16</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 17</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                        <select name="holes[]" >
                          <option value="">Hole 18</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
						  <option value="0">--</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="full_name_id" class="control-label">Stroke Index</label>
                        <br>
                        <select name="strokeindex[]" >
                          <option value="">Hole 10</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 11</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 12</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <br>
                        <select name="strokeindex[]" >
                          <option value="">Hole 13</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 14</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 15</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <br>
                        <select name="strokeindex[]" >
                          <option value="">Hole 16</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 17</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                        <select name="strokeindex[]" >
                          <option value="">Hole 18</option>
                          <option value="20">20</option>
                          <option value="19">19</option>
                          <option value="18">18</option>
                          <option value="17">17</option>
                          <option value="16">16</option>
                          <option value="15">15</option>
                          <option value="14">14</option>
                          <option value="13">13</option>
                          <option value="12">12</option>
                          <option value="11">11</option>
                          <option value="10">10</option>
                          <option value="9">9</option>
                          <option value="8">8</option>
                          <option value="7">7</option>
                          <option value="6">6</option>
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                          <option value="1">1</option>
						  <option value="0">--</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1"> </div>
              <div class="form-group col-md-10">
                <!-- Full Name -->
                <button type="submit" name="btnsave"  class="btn btn-primary">Register New Course</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </div>
              <div class="col-md-1"> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-flag"></span> List of Golf Course</div>
        <div class="panel-body" style="max-height: 570px;overflow-y: scroll;">
          <?php $get2 = mysqli_query($conn, "SELECT gcfullname,city FROM tbgolfcourse");
			while ($row2 = mysqli_fetch_array($get2)) {

			$gcfullname  = $row2['gcfullname'];
			$gcshortname = $row2['city'];
		
		?>
          <a href="viewgolfcourse.php">
          <div class="row">
            <div class="col-md-7">
              <p class="text-info"><b><?php echo $gcfullname;  ?></b></p>
            </div>
            <div class="col-md-4">
              <p><b><?php echo $gcshortname;  ?></b></p>
            </div>
          </div>
          </a>
          <hr>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>

<script>
            $(document).ready(function() {
                $("input[name$='par']").click(function() {
                    var test = $(this).val();
                    alert('Are you Sure You Wanna Do This ?');
                    $("div.desc").hide();
                    $("#par" + test).show();    
                    
                });
                
            });
        </script>

<script>
 function changeValue(o){
   document.getElementsByName('gcimage')[0].value=o;
 }
 $('img').click(function(){
     $(this).toggleClass('selectedIMG');
 });
 
</script>

<script>
$(document).ready(function(){
	 $("#nav02").addClass("active");
});	 
</script>

<style>
.panel-body img.selectedIMG{
    border: 4px solid #02E8DA;
}
.panel-body img {
    border-radius: 10px;
    box-shadow: 5px 5px rgba(182, 182, 182, 0.75);
}
.img1 {
    border-radius: none;
    box-shadow: none;
}
</style>


</body>
</html>
