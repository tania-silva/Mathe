<?
include('./impianto/inc/function.php'); // funzioni PHP
?>

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
	<script type="text/javascript" src="./impianto/js/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:300,400&subset=latin' rel='stylesheet' type='text/css'>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
</head>

<body>
	<div id="container">
		<? include('./impianto/cappello.php'); //PIEDE?>
		<? include('./impianto/testa.php'); //PIEDE?>
		<div id="cnt1">
			<div id="corpo">

			
				<h1>LATEX</h1>
				<p id="crumbs"><a href="./index.php">Homepage</a> > demo > LATEX</p>

				<div id="page_sx">
					<img src="./impianto/img/sx_diss.jpg" width="190" height="112" alt="" class="ntr" />
					<div class="intro">xxx</div>
				</div>
				<div id="page_crp">

					<p>
					  When \(a \ne 0\), there are two solutions to \(ax^2 + bx + c = 0\) and they are
					  $$x = {-b \pm \sqrt{b^2-4ac} \over 2a}.$$
					</p>

					<p> \(\sqrt{ 2x+5  \phantom{\tiny{!}}}\)  </p>

					<p> \( \sin\left( x  \right) \)  </p>

					<p>\(\sum_{ 0  }^{ 56  } \left( { x  }^{ 2 \sin\left( x  \right)    }   \right)\)</p>

					<p>
The *Gamma function* satisfying \(\Gamma(n) = (n-1)!\quad\forall
n\in\mathbb N\) is via through the Euler integral

$$
\Gamma(z) = \int_0^\infty t^{z-1}e^{-t}dt\,.
$$				
					</p>
			

				</div> <!-- page_crp -->


				<div class="clear"></div>
			</div> <!-- corpo rsv -->
			<div class="clear"></div>
		</div> <!-- cnt1 -->
		<div id="cnt2"></div>
	</div> <!-- container -->
	<? include('./impianto/piede.php'); //PIEDE?>
</body>
</html>
