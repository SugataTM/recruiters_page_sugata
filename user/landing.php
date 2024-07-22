<?php
if(!isset($_SESSION)){
  // Start Session it is not started yet
  session_start();
}
if(!isset($_SESSION['login']) || $_SESSION['login']!=true)
{
  header('location:../index.php');
  exit;
}
include 'fetch_data.php';
// $userId = 1; // Assuming user ID 1 for this example.

$userId=$_SESSION['UserId'];
//fetch user details
$sql = "SELECT u.UserName, u.Email, u.Phone, d.FirstName, d.LastName, d.Age, lm.LocationName, d.HighestQualification,d.Experience, d.About, d.Image, d.Resume, d.Gender
FROM users u
JOIN userdetails d ON u.UserId = d.UserId
JOIN locationmaster lm ON d.Location = lm.LocationId
WHERE u.UserId = '$userId'";
// var_dump($sql);

$result = $conn->query($sql);
$userData = $result->fetch_assoc();

//Fetch user skills
$sqlSkills = "SELECT s.SkillId, s.SkillName, us.SkillType FROM userskilldetails us
JOIN skillmaster s ON us.SkillId = s.SkillId
WHERE us.UserId = $userId";

$resultSkills = $conn->query($sqlSkills);
$userPrimarySkills = [];
$userSecondarySkills = [];

if($resultSkills->num_rows>0){
    while($row= $resultSkills->fetch_assoc()){
        if($row['SkillType'] == 'Primary'){
            $userPrimarySkills[]=$row['SkillName'];
        }elseif($row['SkillType'] == 'Secondary'){
            $userSecondarySkills[] = $row['SkillName'];
        }
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>User Profile</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <style>
          .navbar {
              background-color: #333;
              color: white;
              display: flex;
              justify-content: space-between;
              padding: 1em;
              margin-bottom: 5px;
          }
          .navbar-brand {
              font-weight: bold;
              font-size: 18px;
              padding-left: 30px;
          }
          .dropdown {
              position: relative;
              display: inline-block;
          }
          #logout{
            padding-right: 50px;
            color: red;
            font-size: 18px;
          }
        </style>
        
    </head>

    <body>
     <div class="navbar">
        <div class="navbar-brand">Tech <br> <span style="color: red;">HireHub</span></div>
        <div class="dropdown">
            <!-- <button class="dropbtn" >
            <img src="hamburger_icon 1.png" alt="Menu"> 
            <img src="../image/hamburger_icon.png" alt="Menu">
             </button> -->
            <div class="dropdown-content" style="right:0px;">
                <!-- <a href="#">User Dashboard</a> -->
                <a id="logout" href="user_logout.php">Logout</a>
                 
            </div>
        </div>
    </div> 



    <div class="container">
    <div class="main-body">
    
          <!-- Breadcrumb -->
          <!-- <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav> -->
          <!-- /Breadcrumb -->
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">

                  <?php if($userData['Image']) { ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($userData['Image']); ?>" alt="user photo" class="rounded-circle" width="150">
                            <?php } ?>
                            

                    <!-- <img src="" alt="Admin" class="rounded-circle" width="150"> -->
                    <div class="mt-3">
                      <h4><?php echo $userData['FirstName']; ?><?php " "?> <?php echo $userData['LastName']; ?></h4>
                      <p class="text-secondary mb-1"><?php echo "Age: ". $userData['Age'].' | '. " Gender: ".$userData['Gender']?></p> 
                      <p class="text-muted font-size-sm"><?php echo "Location: ".$userData['LocationName'];?></p>
                      <!-- <button class="btn btn-primary"> <a href="download_resume.php"></a> Download CV</button> -->
                      <!-- <a href="download_resume.php" class="btn btn-primary">Download Resume</a> -->
                      <?php if($userData['Resume']) { ?>
                       <a class="btn btn-primary" href="download_resume.php?userId=<?php echo $userId; ?>">Download Resume</a><br>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"></i>About Me</h6>
                        <p><?php echo $userData['About']; ?></p>
                    </div>
              </div>
              <!-- <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"></i>Projects</h6>
                        <p><?php echo $row['Project']?></p>
                    </div>
              </div> -->
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $userData['FirstName'].' '. $userData['LastName'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $userData['Email'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $userData['Phone'];?>
                    </div>
                  </div>
                  <!-- <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      (320) 380-4539
                    </div>
                  </div> -->
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $userData['LocationName'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Highest Qualification</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $userData['HighestQualification'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Primary Skill</h6>
                    </div>
                    <?php if(!empty($userPrimarySkills)) { ?>
                        <div class="col-sm-9 text-secondary">
                        <?php echo implode(', ',$userPrimarySkills);?>
                       </div>
                    <?php } ?>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Secondary Skill</h6>
                    </div>
                    <?php if(!empty($userSecondarySkills)) { ?>
                    <div class="col-sm-9 text-secondary">
                    <?php echo implode(', ',$userSecondarySkills);?>
                    </div>
                    <?php } ?>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Experience</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $userData['Experience'];?>
                    </div>
                  </div>
                  <!-- <hr> -->
                  <!-- <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Organisation</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $organization?>
                    </div>
                  </div> -->
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      <a href="edit_profile.php" class="btn btn-primary edit-button">Edit Profile</a>
                      <!-- <button class="btn btn-primary edit-button" onclick="enableEditing()">Edit Profile</button> -->
                    <!-- <a class="btn btn-info " target="__blank" href="user_edit.php">Edit</a> -->
                    </div>
                  </div>
                </div>
              </div>
              </div>



            </div>
          </div>

        </div>
    </div>
    
    </body>
</html>