<?php 
 	try {
		// include_once('db/dbconfig.php');
		include_once('inc/Sphinx-Search-API-PHP-Client/sphinxapi.php');
		// $a = $_GET['q'];
		// var_dump($a);
		// Build search query
		$cl = new SphinxClient();
		$cl->SetServer( "localhost", 3312 );
		$cl->SetMatchMode( SPH_MATCH_EXTENDED );
		$cl->SetRankingMode ( SPH_RANK_SPH04 );

		// Execute the query
		$q = '"' . $cl->EscapeString($_GET['q']) . '"/1';
		// var_dump($q);
		$searchresults = $cl->query($q, 'search' );

		// CREATE OR REPLACE VIEW examplei AS
		//   SELECT
		//     UUID_SHORT() AS sphinxid,
		//     products.id AS proid,
		// 	   products.title AS protitle,
		// 	   products.body AS probody,
		//     1 AS datatype
		//   FROM products
// $cl->GetLastError();
// var_dump($cl);
// echo '<br>';
		var_dump($searchresults);
		// foreach ($searchresults as $value) {
		// 	echo '<pre>';
		// 	var_dump($value);
		// 	echo '</pre>';

		// }
	} catch (PDOException $e) {
	 	echo $e->getMessage();
	 }