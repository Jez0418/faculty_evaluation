<?php

include("../includes/auth.php");
include("../includes/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

$id=$_GET['id'];

$stmt=$pdo->prepare("SELECT * FROM faculty WHERE id=?");
$stmt->execute([$id]);
$faculty=$stmt->fetch();

$stats=$pdo->prepare("
SELECT

COUNT(*) total,

ROUND(AVG(overall_rating),2) average,

ROUND(AVG(knowledge),2) knowledge,

ROUND(AVG(communication),2) communication,

ROUND(AVG(professionalism),2) professionalism,

ROUND(AVG(punctuality),2) punctuality,

ROUND(AVG(teaching),2) teaching

FROM evaluations

WHERE faculty_id=?

");

$stats->execute([$id]);

$data=$stats->fetch();

$positive=$pdo->prepare("
SELECT COUNT(*) FROM evaluations
WHERE faculty_id=? AND sentiment='Positive'
");
$positive->execute([$id]);

$neutral=$pdo->prepare("
SELECT COUNT(*) FROM evaluations
WHERE faculty_id=? AND sentiment='Neutral'
");
$neutral->execute([$id]);

$negative=$pdo->prepare("
SELECT COUNT(*) FROM evaluations
WHERE faculty_id=? AND sentiment='Negative'
");
$negative->execute([$id]);

$comments=$pdo->prepare("
SELECT *

FROM evaluations

WHERE faculty_id=?

ORDER BY created_at DESC
");

$comments->execute([$id]);

?>

<div class="container-fluid">

<h2><?= htmlspecialchars($faculty['fullname']) ?></h2>

<p>

Department:

<b>

<?= htmlspecialchars($faculty['department']) ?>

</b>

</p>

<hr>

<div class="row">

<div class="col-md-3">

<div class="card text-center">

<div class="card-body">

<h5>Average Rating</h5>

<h2><?= $data['average'] ?: 0 ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center">

<div class="card-body">

<h5>Total Evaluations</h5>

<h2><?= $data['total'] ?></h2>

</div>

</div>

</div>

<div class="col-md-2">

<div class="alert alert-success">

Positive

<h3>

<?= $positive->fetchColumn() ?>

</h3>

</div>

</div>

<div class="col-md-2">

<div class="alert alert-secondary">

Neutral

<h3>

<?= $neutral->fetchColumn() ?>

</h3>

</div>

</div>

<div class="col-md-2">

<div class="alert alert-danger">

Negative

<h3>

<?= $negative->fetchColumn() ?>

</h3>

</div>

</div>

</div>

<br>

<div class="card">

<div class="card-header">

Average Ratings Per Criteria

</div>

<div class="card-body">

<table class="table">

<tr><td>Knowledge</td><td><?= $data['knowledge'] ?></td></tr>

<tr><td>Communication</td><td><?= $data['communication'] ?></td></tr>

<tr><td>Professionalism</td><td><?= $data['professionalism'] ?></td></tr>

<tr><td>Punctuality</td><td><?= $data['punctuality'] ?></td></tr>

<tr><td>Teaching</td><td><?= $data['teaching'] ?></td></tr>

</table>

</div>

</div>

<br>

<div class="card">

<div class="card-header">

Student Comments

</div>

<div class="card-body">

<table class="table table-bordered table-striped datatable">

<thead>

<tr>

<th>Student</th>

<th>Rating</th>

<th>Sentiment</th>

<th>Comment</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php foreach($comments as $row){ ?>

<tr>

<td><?= htmlspecialchars($row['student_name']) ?></td>

<td><?= $row['overall_rating'] ?></td>

<td><?= $row['sentiment'] ?></td>

<td><?= htmlspecialchars($row['comment']) ?></td>

<td><?= $row['created_at'] ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include("../includes/footer.php"); ?>