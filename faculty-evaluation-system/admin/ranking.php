<?php

include("../includes/auth.php");
include("../includes/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

$ranking = $pdo->query("
SELECT
    faculty.fullname,
    faculty.department,
    COUNT(evaluations.id) AS total,
    ROUND(AVG(evaluations.overall_rating),2) AS average
FROM faculty
LEFT JOIN evaluations
ON faculty.id=evaluations.faculty_id
GROUP BY faculty.id
ORDER BY average DESC
")->fetchAll();

?>

<div class="container-fluid">

<h2 class="mb-4">

Faculty Performance Ranking

</h2>

<div class="card">

<div class="card-body">

<table class="table table-bordered table-striped datatable">

<thead class="table-dark">

<tr>

<th>Rank</th>

<th>Faculty</th>

<th>Department</th>

<th>Average Rating</th>

<th>Total Evaluations</th>

</tr>

</thead>

<tbody>

<?php

$rank=1;

foreach($ranking as $row){

?>

<tr>

<td>

<?php

if($rank==1){

echo "🥇";

}elseif($rank==2){

echo "🥈";

}elseif($rank==3){

echo "🥉";

}else{

echo $rank;

}

?>

</td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= htmlspecialchars($row['department']) ?></td>

<td>

⭐ <?= $row['average'] ?: 0 ?>

</td>

<td>

<?= $row['total'] ?>

</td>

</tr>

<?php

$rank++;

}

?>

</tbody>

</table>

</div>

</div>

</div>

<?php

include("../includes/footer.php");

?>