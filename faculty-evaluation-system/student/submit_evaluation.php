<?php

include("../includes/db.php");
require_once("../nlp/sentiment.php");

// Compute overall rating
$overall = (
    $_POST['knowledge'] +
    $_POST['communication'] +
    $_POST['professionalism'] +
    $_POST['punctuality'] +
    $_POST['teaching']
) / 5;

// Analyze sentiment
$result = analyzeSentiment($_POST['comment']);

$sentiment = $result['sentiment'];
$confidence = $result['confidence'];

// Insert into database
$stmt = $pdo->prepare("
    INSERT INTO evaluations
    (
        faculty_id,
        student_name,
        knowledge,
        communication,
        professionalism,
        punctuality,
        teaching,
        overall_rating,
        comment,
        sentiment,
        confidence
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $_POST['faculty_id'],
    $_POST['student_name'],
    $_POST['knowledge'],
    $_POST['communication'],
    $_POST['professionalism'],
    $_POST['punctuality'],
    $_POST['teaching'],
    $overall,
    $_POST['comment'],
    $sentiment,
    $confidence
]);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Evaluation Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="alert alert-success">
        <h3>Evaluation Submitted Successfully!</h3>
    </div>

    <table class="table table-bordered">

        <tr>
            <th>Overall Rating</th>
            <td><?php echo number_format($overall, 2); ?></td>
        </tr>

        <tr>
            <th>Sentiment</th>
            <td><?php echo $sentiment; ?></td>
        </tr>

        <tr>
            <th>Confidence</th>
            <td><?php echo $confidence; ?>%</td>
        </tr>

    </table>

    <a href="dashboard.php" class="btn btn-primary">
        Back to Dashboard
    </a>

</div>

</body>
</html>