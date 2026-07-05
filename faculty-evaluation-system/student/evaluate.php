<?php

include("../includes/db.php");
include("../includes/header.php");

$faculty = $pdo->query("SELECT * FROM faculty WHERE status='Active'")->fetchAll();

?>

<div class="container mt-5">

<h2>Faculty Evaluation Form</h2>

<form action="submit_evaluation.php" method="POST">

<div class="mb-3">

<label>Student Name</label>

<input
type="text"
name="student_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Select Faculty</label>

<select
name="faculty_id"
class="form-control"
required>

<option value="">Choose Faculty</option>

<?php foreach($faculty as $f){ ?>

<option value="<?= $f['id'] ?>">

<?= $f['fullname'] ?>

</option>

<?php } ?>

</select>

</div>





<?php

$criteria = [

"Knowledge",

"Communication",

"Professionalism",

"Punctuality",

"Teaching"

];

$names = [

"knowledge",

"communication",

"professionalism",

"punctuality",

"teaching"

];

for($i=0;$i<count($criteria);$i++){

?>

<div class="mb-3">

<label>

<?= $criteria[$i] ?>

</label>

<select
name="<?= $names[$i] ?>"
class="form-control"
required>

<?php

for($x=1;$x<=5;$x++){

?>

<option value="<?= $x ?>">

<?= $x ?>

</option>

<?php

}

?>

</select>

</div>

<?php

}

?>



<div class="mb-3">

<label>Comment</label>

<textarea
name="comment"
rows="5"
class="form-control"
required></textarea>

</div>

<button class="btn btn-success">

Submit Evaluation

</button>

</form>

</div>

<?php
include("../includes/footer.php");
?>