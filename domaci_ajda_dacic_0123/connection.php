<?php


$conn = mysqli_connect("localhost", "root", "", "quiz");

if ($conn->connect_error) {
    echo $conn->connect_error;
}