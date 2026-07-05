<?php

include("../includes/auth.php");
include("../includes/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

$stmt = $pdo->query("SELECT * FROM faculty ORDER BY id DESC");
$faculty = $stmt->fetchAll();

?>

<div class="d-flex justify-content-between align-items-center mb-3">

<h2>Faculty Management</h2>

<a href="add_faculty.php" class="btn btn-primary">
    <i class="fa fa-plus"></i> Add Faculty
</a>

</div>

<table class="table table-bordered table-striped datatable">

<thead>

<tr>

<th>ID</th>

<th>Faculty Code</th>

<th>Name</th>

<th>Department</th>

<th>Email</th>

<th>Status</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

<?php foreach($faculty as $row){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['faculty_code']; ?></td>

<td><?= $row['fullname']; ?></td>

<td><?= $row['department']; ?></td>

<td><?= $row['email']; ?></td>

<td><?= $row['status']; ?></td>

<td>

<a href="faculty_details.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">
View
</a>

<a href="edit_faculty.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
Edit
</a>

<a href="delete_faculty.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this faculty?')">
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php include("../includes/footer.php"); ?>