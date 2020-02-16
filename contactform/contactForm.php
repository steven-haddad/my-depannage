<?php
// Fetching Values From URL
$habitation = $_POST['habitation'];
$status = $_POST['status'];
$profession = $_POST['profession'];
$zipcode = $_POST['zipcode'];
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$hostname = "transiticsalxdav.mysql.db";
$username="transiticsalxdav";
$password="Davidalex26";
$db="test_db";
$PDO = new PDO('mysql:host=transiticsalxdav.mysql.db;dbname=transiticsalxdav', $username, $password);// Selecting Database
if (isset($_POST['habitation']) && isset($_POST['status'])) {
    $req = $PDO->prepare("INSERT INTO leads (habitation, status, profession, zipcode, name, email, mobile) VALUES (:habitation, :status, :profession, :zipcode, :name, :email, :mobile)");
    try {
        $req->execute(array(
                "habitation" => $habitation, 
                "status" => $status,
                "profession" => $profession,
                "zipcode" => $zipcode,
                "name" => $name,
                "email" => $email,
                "mobile" => $mobile
                )
            );
        print "OK";
    } catch (Exception $e) {
        die("ERROR !");
    }
}
?>