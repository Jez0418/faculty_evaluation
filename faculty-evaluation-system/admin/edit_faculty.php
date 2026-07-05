<?php

include("../includes/auth.php");
include("../includes/db.php");

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM faculty WHERE id=?");
$stmt->execute([$id]);
$faculty = $stmt->fetch();

if(!$faculty){
    die("Faculty not found.");
}

if(isset($_POST['update'])){

    $faculty_code = trim($_POST['faculty_code']);
    $fullname = trim($_POST['fullname']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE faculty
        SET faculty_code=?,
            fullname=?,
            department=?,
            email=?,
            status=?
        WHERE id=?");

    $stmt->execute([
        $faculty_code,
        $fullname,
        $department,
        $email,
        $status,
        $id
    ]);

    header("Location: faculty.php");
    exit();
}

include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="container-fluid">

<h2>Edit Faculty</h2>

<form method="POST">

<div class="card">

<div class="card-body">

<div class="mb-3">
<label>Faculty Code</label>
<input type="text"
name="faculty_code"
class="form-control"
value="<?= htmlspecialchars($faculty['faculty_code']) ?>"
required>
</div>

<div class="mb-3">
<label>Full Name</label>
<input type="text"
name="fullname"
class="form-control"
value="<?= htmlspecialchars($faculty['fullname']) ?>"
required>
</div>

<div class="mb-3">
<label>Department</label>
<input type="text"
name="department"
class="form-control"
value="<?= htmlspecialchars($faculty['department']) ?>"
required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($faculty['email']) ?>">
</div>

<div class="mb-3">
<label>Status</label>

<select name="status" class="form-control">

<option value="Active"
<?= $faculty['status']=="Active"?"selected":"" ?>>
Active
</option>

<option value="Inactive"
<?= $faculty['status']=="Inactive"?"selected":"" ?>>
Inactive
</option>

</select>

</div>

<button class="btn btn-success" name="update">
Update Faculty
</button>

<a href="faculty.php" class="btn btn-secondary">
Cancel
</a>

</div>

</div>

</form>

</div>

<?php include("../includes/footer.php"); ?>