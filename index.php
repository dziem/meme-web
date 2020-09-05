<!DOCTYPE html>
  <html>
    <head>
		<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/font-awesome.min.css"/>
		<link type="text/css" rel="stylesheet" href="css/style.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php

require_once 'controller/MainController.php';

$controller = new MainController();

$controller->handleRequest();

?>
		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script>
			$( document ).ready(function(){
				$(".dropdown-button").dropdown({
					hover: true,
					constrainWidth: false,
					alignment: 'right',
					belowOrigin: true
				});
			});
			function upvote(idm,ida,obj){
				if ( $( obj ).hasClass( "voted" ) ) {
					$( obj ).removeClass("voted");
					$( obj ).next().removeAttr("disabled");
					$.post( "index.php?op=cancelupvote", { id_meme: idm, id_akun: ida} ).done(function( data ) {
						var span = $( obj ).parent().prev().find( "span.upvote" );
						$(span).html(data);
					  });
				}else{
					$( obj ).addClass("voted");
					$( obj ).next().attr("disabled", true);
					$.post( "index.php?op=upvote", { id_meme: idm, id_akun: ida} ).done(function( data ) {
						var span = $( obj ).parent().prev().find( "span.upvote" );
						$(span).html(data);
					  });
				}
			}
			function downvote(idm,ida,obj){
				if ( $( obj ).hasClass( "voted" ) ) {
					$( obj ).removeClass("voted");
					$( obj ).prev().removeAttr("disabled");
					$.post( "index.php?op=canceldownvote", { id_meme: idm, id_akun: ida} ).done(function( data ) {
						var span = $( obj ).parent().prev().find( "span.downvote" );
						$(span).html(data);
					  });
				}else{
					$( obj ).addClass("voted");
					$( obj ).prev().attr("disabled", true);
					$.post( "index.php?op=downvote", { id_meme: idm, id_akun: ida} ).done(function( data ) {
						var span = $( obj ).parent().prev().find( "span.downvote" );
						$(span).html(data);
					  });
				}
			}
		</script>
    </body>
</html>