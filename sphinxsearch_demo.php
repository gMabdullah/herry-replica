<?php 
// schema of view 
CREATE OR REPLACE VIEW examplei AS
		  SELECT
		    UUID_SHORT() AS sphinxid,
		    products.id AS proid,
			   products.title AS protitle,
			   products.body AS probody,
		    1 AS datatype
		  FROM products

// sphinx.conf file
source examplei
{
  type          = mysql

  sql_host      = localhost
  sql_user      = root
  sql_pass      = root # change this to your root users MySQL password
  sql_db        = signup
  sql_port      = 3306

  sql_query     = SELECT * FROM examplei

  sql_attr_uint         = proid
  sql_attr_uint         = protitle
  sql_attr_uint         = probody

  # sql_query_info        = SELECT * FROM documents WHERE id=$id
}
index examplei
{
  source            = examplei
  path              = /var/lib/sphinxsearch/data/examplei
  docinfo           = extern
  # charset_type      = sbcs
}
searchd
{
  listen            = 127.0.0.1:9306:mysql41
  log               = /var/log/sphinxsearch/searchd.log
  query_log         = /var/log/sphinxsearch/query.log
  read_timeout      = 5
  max_children      = 30
  pid_file          = /var/run/sphinxsearch/searchd.pid
  # max_matches       = 1000
  seamless_rotate   = 1
  preopen_indexes   = 1
  unlink_old        = 1
  binlog_path       = /var/lib/sphinxsearch/data
} 

//Html form
<!-- Search Area -->
  <form class="navbar-form navbar-left" name="search" method="get" action="/searchresults.php">
    <div class="form-group">
      <input type="text" name="q" id="q" class="form-control" placeholder="Search..." >
    </div>
    <button type="submit" class="btn btn-default">Search</button>
  </form>

 // Form submitting to that file
 include_once('inc/Sphinx-Search-API-PHP-Client/sphinxapi.php');
	// Build search query
	$cl = new SphinxClient();
	$cl->SetServer( "localhost", 3312 );
	$cl->SetMatchMode( SPH_MATCH_EXTENDED );
	$cl->SetRankingMode ( SPH_RANK_SPH04 );

	// Execute the query
	$q = '"' . $cl->EscapeString($_GET['q']) . '"/1';
	$searchresults = $cl->query($q, 'search' );