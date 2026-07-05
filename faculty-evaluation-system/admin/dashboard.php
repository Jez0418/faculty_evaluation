<?php

include("../includes/auth.php");
include("../includes/db.php");

$totalFaculty = $pdo->query("SELECT COUNT(*) FROM faculty")->fetchColumn();
$totalEvaluations = $pdo->query("SELECT COUNT(*) FROM evaluations")->fetchColumn();
$positive = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Positive'")->fetchColumn();
$neutral = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Neutral'")->fetchColumn();
$negative = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Negative'")->fetchColumn();
$averageRating = $pdo->query("SELECT ROUND(AVG(overall_rating),2) FROM evaluations")->fetchColumn();

if (!$averageRating) {
    $averageRating = 0;
}

$recent = $pdo->query("
SELECT
    evaluations.student_name,
    faculty.fullname,
    evaluations.overall_rating,
    evaluations.sentiment,
    evaluations.created_at
FROM evaluations
JOIN faculty
ON evaluations.faculty_id = faculty.id
ORDER BY evaluations.created_at DESC
LIMIT 10
")->fetchAll();

include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="container-fluid">

<h2 class="mb-4">Dashboard</h2>

<div class="row">

<div class="col-md-3 mb-3">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Total Faculty</h5>
<h2><?= $totalFaculty ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Total Evaluations</h5>
<h2><?= $totalEvaluations ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card bg-warning">
<div class="card-body">
<h5>Average Rating</h5>
<h2><?= $averageRating ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card bg-danger text-white">
<div class="card-body">
<h5>Negative Comments</h5>
<h2><?= $negative ?></h2>
</div>
</div>
</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="card">

<div class="card-header">
Sentiment Analysis
</div>

<div class="card-body">
<canvas id="sentimentChart"></canvas>
</div>

</div>

</div>

<div class="col-md-6">

<div class="card">

<div class="card-header">
Recent Evaluations
</div>

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>
<th>Student</th>
<th>Faculty</th>
<th>Rating</th>
<th>Sentiment</th>
</tr>

</thead>

<tbody>

<?php foreach($recent as $row){ ?>

<tr>

<td><?= htmlspecialchars($row['student_name']) ?></td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= $row['overall_rating'] ?></td>

<td>

<?php

if($row['sentiment']=="Positive"){
    echo "<span class='badge bg-success'>Positive</span>";
}
elseif($row['sentiment']=="Negative"){
    echo "<span class='badge bg-danger'>Negative</span>";
}
else{
    echo "<span class='badge bg-secondary'>Neutral</span>";
}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script>

new Chart(document.getElementById('sentimentChart'),{

type:'pie',

data:{

labels:['Positive','Neutral','Negative'],

datasets:[{

data:[
<?= $positive ?>,
<?= $neutral ?>,
<?= $negative ?>
],

backgroundColor:[
'#198754',
'#6c757d',
'#dc3545'
]

}]

}

});

</script>

</div>

<?php include("../includes/footer.php"); ?>