<?php

include("../includes/auth.php");
include("../includes/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// Sentiment Counts
$positive = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Positive'")->fetchColumn();
$neutral = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Neutral'")->fetchColumn();
$negative = $pdo->query("SELECT COUNT(*) FROM evaluations WHERE sentiment='Negative'")->fetchColumn();

// Monthly Evaluations
$monthly = $pdo->query("
SELECT
    MONTH(created_at) AS month,
    COUNT(*) AS total
FROM evaluations
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
")->fetchAll();

$months = [];
$totals = [];

foreach($monthly as $row){
    $months[] = date("M", mktime(0,0,0,$row['month'],1));
    $totals[] = $row['total'];
}

// Faculty Ratings
$faculty = $pdo->query("
SELECT
faculty.fullname,
ROUND(AVG(evaluations.overall_rating),2) AS average
FROM faculty
LEFT JOIN evaluations
ON faculty.id=evaluations.faculty_id
GROUP BY faculty.id
")->fetchAll();

$facultyNames = [];
$facultyRatings = [];

foreach($faculty as $row){
    $facultyNames[] = $row['fullname'];
    $facultyRatings[] = $row['average'] ?: 0;
}

?>

<div class="container-fluid">

<h2 class="mb-4">Analytics Dashboard</h2>

<div class="row">

<div class="col-md-6">

<div class="card">

<div class="card-header">

Sentiment Distribution

</div>

<div class="card-body">

<canvas id="sentimentChart"></canvas>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card">

<div class="card-header">

Monthly Evaluations

</div>

<div class="card-body">

<canvas id="monthlyChart"></canvas>

</div>

</div>

</div>

</div>

<br>

<div class="card">

<div class="card-header">

Faculty Average Ratings

</div>

<div class="card-body">

<canvas id="facultyChart"></canvas>

</div>

</div>

</div>

<script>

// Pie Chart
new Chart(document.getElementById("sentimentChart"),{

type:'pie',

data:{
labels:['Positive','Neutral','Negative'],
datasets:[{
data:[
<?= $positive ?>,
<?= $neutral ?>,
<?= $negative ?>
]
}]
}

});

// Line Chart
new Chart(document.getElementById("monthlyChart"),{

type:'line',

data:{
labels:<?= json_encode($months); ?>,
datasets:[{
label:'Evaluations',
data:<?= json_encode($totals); ?>,
fill:false
}]
}

});

// Bar Chart
new Chart(document.getElementById("facultyChart"),{

type:'bar',

data:{
labels:<?= json_encode($facultyNames); ?>,
datasets:[{
label:'Average Rating',
data:<?= json_encode($facultyRatings); ?>
}]
}

});

</script>

<?php include("../includes/footer.php"); ?>