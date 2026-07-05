<?php

include("../includes/auth.php");
include("../includes/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// Faculty Ratings
$faculty = $pdo->query("
SELECT
    faculty.fullname,
    COUNT(evaluations.id) AS total_evaluations,
    ROUND(AVG(evaluations.overall_rating),2) AS average_rating
FROM faculty
LEFT JOIN evaluations
ON faculty.id = evaluations.faculty_id
GROUP BY faculty.id
ORDER BY average_rating DESC
")->fetchAll();

// Sentiment Count
$positive = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Positive'")->fetchColumn();
$neutral = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Neutral'")->fetchColumn();
$negative = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Negative'")->fetchColumn();

// Recent Evaluations
$comments = $pdo->query("
SELECT
faculty.fullname,
evaluations.student_name,
evaluations.comment,
evaluations.sentiment,
evaluations.overall_rating,
evaluations.created_at
FROM evaluations
JOIN faculty
ON evaluations.faculty_id=faculty.id
ORDER BY evaluations.created_at DESC
LIMIT 10
")->fetchAll();

?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Evaluation Report</h2>

<button onclick="window.print()" class="btn btn-success">
Print Report
</button>

</div>

<h4>Faculty Rating Summary</h4>

<table class="table table-bordered table-striped datatable">

<thead>

<tr>

<th>Faculty</th>

<th>Total Evaluations</th>

<th>Average Rating</th>

</tr>

</thead>

<tbody>

<?php foreach($faculty as $row){ ?>

<tr>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= $row['total_evaluations'] ?></td>

<td><?= $row['average_rating'] ?? 0 ?></td>

</tr>

<?php } ?>

</tbody>

</table>

<hr>

<h4>Sentiment Summary</h4>

<div class="row">

<div class="col-md-4">
<div class="alert alert-success">
Positive: <strong><?= $positive ?></strong>
</div>
</div>

<div class="col-md-4">
<div class="alert alert-secondary">
Neutral: <strong><?= $neutral ?></strong>
</div>
</div>

<div class="col-md-4">
<div class="alert alert-danger">
Negative: <strong><?= $negative ?></strong>
</div>
</div>

</div>

<hr>

<h4>Recent Evaluations</h4>

<table class="table table-striped">

<thead>

<tr>

<th>Date</th>
<th>Student</th>
<th>Faculty</th>
<th>Rating</th>
<th>Sentiment</th>
<th>Comment</th>

</tr>

</thead>

<tbody>

<?php foreach($comments as $row){ ?>

<tr>

<td><?= $row['created_at'] ?></td>

<td><?= htmlspecialchars($row['student_name']) ?></td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= $row['overall_rating'] ?></td>

<td><?= $row['sentiment'] ?></td>

<td><?= htmlspecialchars($row['comment']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php include("../includes/footer.php"); ?>