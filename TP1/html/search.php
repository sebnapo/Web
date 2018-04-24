<!doctype HTML>
<html lang="fr">
	<head>
	  	<meta charset="utf-8">
	  	<title>Twitter sentiment analysis</title>
	  	<?php include('fonctions.php'); ?>
		<!-- jQuery library -->
		<!-- Compiled and minified CSS -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      	<link rel="stylesheet" type="text/css" href="../css/mycss.css">

	    <!-- Compiled and minified JavaScript -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
	  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

		<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

		<!-- Latest compiled JavaScript -->
	  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


	</head>
	<body>
		<nav class="navbar navbar-dark bg-dark justify-content-between">
		  	<a class="navbar-brand">Welcome to the Moon</a>
	  		<form action="" class="myforminline" method="POST">
		    	<input class="form-control mr-sm-2" type="text" placeholder="Search" autocomplete="off" name="search" id="recherche" aria-label="Search">
		    	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		  	</form>
		</nav>
		</br>
		<div class="container">
			<div class="row">
				<?php
					$pdo = connectBDD();
					
					$default = 'Bitcoin';
					if(isset($_POST['search'])){
						$text=str_replace(' ','',$_POST['search']);
						$default = $text;
						#on recherche plus comme ça seb, on peut plsu ajouter de coins
					}
					/*se connecter à l'api tweeter */
					$connection=seConnecter();
					$arrayobj = sortByDate($pdo,$default,2);
					
					$cpt = $posMoy = $neuMoy = $negMoy = 0;
					
					foreach($arrayobj as $obj) {
						$cpt++;
						echo "\n";
						$posMoy += $obj['pos'];
						$negMoy += $obj['neg'];
						$neuMoy += $obj['neu'];
						//$class = $sentiment->categorise($test["text"]);
					}
					if($cpt != 0){
						$posMoy = $posMoy/$cpt;
						$negMoy = $negMoy/$cpt;
						$neuMoy = $neuMoy/$cpt;
					}
				?>
			</div>
			<div class="row">
				<table class="table">
			  <thead>
				    <tr>
				      <th scope="col"><?php echo $default; ?></th>
				      <th scope="col">Positivité</th>
				      <th scope="col">Negativité</th>
				      <th scope="col">Neutralité</th>
				      <th scope="col">Nombre de tweets</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <th scope="row">Depuis 2h</th>
				      <td><?php echo(round($posMoy,3)) ?></td>
				      <td><?php echo(round($negMoy,3)) ?></td>
				      <td><?php echo(round($neuMoy,3)) ?></td>
				      <td><?php echo $cpt; ?></td>
				    </tr>
				    <?php
				    	$cpt = 0;
				    	$arrayobj = NULL;
				    	$arrayobj = sortByDate($pdo,$default,12);
						$cpt = $posMoy = $neuMoy = $negMoy = 0;
						foreach($arrayobj as $obj) {
							$cpt++;
							echo "\n";
							$posMoy += $obj['pos'];
							$negMoy += $obj['neg'];
							$neuMoy += $obj['neu'];
							//$class = $sentiment->categorise($test["text"]);
						}
						
						
						if($cpt != 0){
							$posMoy = $posMoy/$cpt;
							$negMoy = $negMoy/$cpt;
							$neuMoy = $neuMoy/$cpt;
						}
				    ?>
				    <tr>
				      <th scope="row">Depuis 12h</th>
				      <td><?php echo(round($posMoy,3)) ?></td>
				      <td><?php echo(round($negMoy,3)) ?></td>
				      <td><?php echo(round($neuMoy,3)) ?></td>
				      <td><?php echo $cpt; ?></td>
				    </tr>
				    <?php
				    	$arrayobj = NULL;
				    	$cpt = 0;		
				    	$arrayobj = sortByDate($pdo,$default,7);
						$cpt = $posMoy = $neuMoy = $negMoy = 0;
						foreach($arrayobj as $obj) {
							$cpt++;
							echo "\n";
							$posMoy += $obj['pos'];
							$negMoy += $obj['neg'];
							$neuMoy += $obj['neu'];
							//$class = $sentiment->categorise($test["text"]);
						}
						if($cpt != 0){
							$posMoy = $posMoy/$cpt;
							$negMoy = $negMoy/$cpt;
							$neuMoy = $neuMoy/$cpt;
						}
				    ?>
				    <tr>
				      <th scope="row">Depuis 1 semaine</th>
				      <td><?php echo(round($posMoy,3)) ?></td>
				      <td><?php echo(round($negMoy,3)) ?></td>
				      <td><?php echo(round($neuMoy,3)) ?></td>
				      <td><?php echo $cpt; ?></td>
				    </tr>
				  </tbody>
				</table>
			</div>
		</div>
  </body>
  <script type="text/javascript">
  	$(document).on('click','.badge',function(){	
    		post_to_url('index.php', {search : $(event.target).text(),
    									}, 'post');
	});
  	function post_to_url(path, params, method) {
    method = method || "post";

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
	} 

	$( "#recherche" ).autocomplete({
  		source: 'list.php',
  		success: function(data){
                response(data);
            },
	});            
  </script>
</html>





	


