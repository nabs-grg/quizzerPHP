<?php
//process our answer and add it to the score variable. there is no view and redirect to next question or final page.
include 'database.php'; 
?>
<?php session_start(); ?>
<?php 
//Check to see if score is set_error_handler
	if(!isset($_SESSION['score'])){
		$_SESSION['score'] = 0;
	}

	if($_POST){
		$number = $_POST['number'];
		$selected_choice = $_POST['choice'];
		$next = $number + 1;

	/*
	*	Get total question
	*/

	$query = "SELECT * FROM `questions`";
	//Get Result
	$results = $mysqli->query($query) or die($mysqli->error.__LINE__);
	$total = $results->num_rows;

	/*
	*	Get correct choice
	*/

	$query = "SELECT * FROM `choices`
				WHERE question_number = $number AND is_correct = 1";


	//Get result
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	//Get row
	$row = $result->fetch_assoc();

	//Set Correct choice
	$correct_choice = $row['id'];

	//Compare
	if($correct_choice === $selected_choice){
		//Answer is correct
		$_SESSION['score']++;
	}

	//print_r($_SESSION) ;

	if($next !== $total){
		header("Location: final.php");
		exit();
	} else {		
		header("Location: question.php?n=".$next);
		exit();
	}
}

?>