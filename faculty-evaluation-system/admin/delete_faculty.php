<?php

include("../includes/auth.php");
include("../includes/db.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // Delete evaluations first
    $stmt = $pdo->prepare("DELETE FROM evaluations WHERE faculty_id = ?");
    $stmt->execute([$id]);

    // Delete faculty
    $stmt = $pdo->prepare("DELETE FROM faculty WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: faculty.php");
exit();