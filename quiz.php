<?php
include 'private/pwds.php';
if(isset($_GET['u'])){
	$uid = $_GET['u'];
	$conn = mysqli_connect('localhost', $mysqlUsername, $mysqlPassword, 'revise');

	$q = "SELECT * from topics where uid = '$uid';";

	$query = mysqli_query($conn, $q);

	$qarray = mysqli_fetch_array($query, MYSQLI_ASSOC);

	$ids = $qarray['ids'];
	$cmd = 'python getquestions.py \''.$ids.'\'';
	$out =  shell_exec($cmd);
} else {
	header('Location: index.php');
}
?>
<?php
include "layouts.php";
$l = getLayout("basic.layout");
$l->writeHeader();
?>
<script type='text/javascript'>
	var questionsJSON = <?php echo "'".utf8_encode($out)."'"; ?>;
	var questions = JSON.parse(questionsJSON);
</script>

<div id='quiz'>
	<h2 id='question'>Loading...</h2>
	<input id='answer' onkeypress="return onEnter(event)"><br/>
	<!--<h4 id='correction'>correction...</h4><br/>-->
	<button id='asubmit' onclick='submitAnswer()'>Submit</button>
</div>
<script src='quiz.js' type='text/javascript'></script>
<?php
$l -> writeFooter();
?>