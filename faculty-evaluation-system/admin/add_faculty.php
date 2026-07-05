<?php

include("../includes/auth.php");
include("../includes/db.php");

if(isset($_POST['save'])){

    $faculty_code = trim($_POST['faculty_code']);
    $fullname = trim($_POST['fullname']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO faculty
    (faculty_code, fullname, department, email, status)
    VALUES (?,?,?,?,?)");

    $stmt->execute([
        $faculty_code,
        $fullname,
        $department,
        $email,
        $status
    ]);

    header("Location: faculty.php");
    exit();
}

include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="container-fluid">

<h2>Add Faculty</h2>

<form method="POST">

<div class="card">

<div class="card-body">

<div class="mb-3">

<label>Faculty Code</label>

<input
type="text"
name="faculty_code"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Department</label>

<input
type="text"
name="department"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control">

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option value="Active">Active</option>

<option value="Inactive">Inactive</option>

</select>

</div>

<button
class="btn btn-success"
name="save">

Save Faculty

</button>

<a
href="faculty.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

<?php include("../includes/footer.php"); ?>