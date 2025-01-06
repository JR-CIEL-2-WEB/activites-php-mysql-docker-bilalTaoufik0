<?php

$courses = json_decode(file_get_contents('courses.json'), true);

$courseId = $_GET['id'] ?? null;

if ($courseId) {
    foreach ($courses as $course) {
        if ($course['id'] === $courseId) {
            echo json_encode($course);
            exit;
        }
    }
}

?>