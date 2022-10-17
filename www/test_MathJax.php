<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
<head>
	<title><?=$title?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="Generator" content="AmeeIV" />
	<meta name="Author" content="Ing. Francesco Pinzani" />
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/struttura.css" />
	<link type="text/css" rel="stylesheet" href="./impianto/css/mathePortal.css" />
	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
	<script type="text/x-mathjax-config">
	  MathJax.Hub.Config({
		tex2jax: {
		  inlineMath: [ ['$','$'], ["\\(","\\)"] ],
		  processEscapes: true
		}
	  });
	</script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
</head>

<body>

<?php include('./impianto/inc/function.php'); // funzioni PHP
	
	$qstId=1019;
	$usrId=886;

	$sql = "
		SELECT *, p.id AS qstId 
		FROM platform__SNA__questions AS p 
		WHERE (p.id='$qstId' AND p.id_lect=$usrId) 
		ORDER BY p.date DESC";
	$result=mysqli_query($conn,$sql);

	while ($row=mysqli_fetch_array($result)) { 
		$qstId=$row["qstId"];
		$description=$row["description"];
		$topic=$row["topic"];
		$subtopic=$row["subtopic"];
		$question=$row["question"];
		$level=$row["level"];
		$answer1=$row["answer1"];
		$answer2=$row["answer2"];
		$answer3=$row["answer3"];
		$answer4=$row["answer4"];
		$fileName=$row["file_name"];
		$fileExt=$row["file_ext"];
		$date=$row["date"];
	}



?>

<?=($question)?>
<br /><br />
Phasellus ornare nec nulla ac pretium. Sed aliquam ipsum id $$\int x^2 \, dx = \frac{x^3}3 +C$$ felis lobortis malesuada. Suspendisse egestas dolor sit amet mi venenatis malesuada.
Praesent sodales metus bibendum, aliquam elit quis, posuere urna.

\[f(a) = \frac{1}{2\pi i} \oint\frac{f(z)}{z-a}dz\]
<br /><br />
$x_{14} = 1,  x_{23} = 1, x_{31} = 1 \text{, other } x_{ij}=0$;


</body>
</html>
