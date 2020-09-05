	<title><?php print htmlentities($akunObj->getNamaAuthor()); ?> Meme</title>
</head>
<body>
	<nav class="amber darken-1">
		<div class="nav-wrapper container">
			<a href="index.php" class="brand-logo left">The Meme App</a>
			<ul id="nav-mobile" class="right">     
			<?php
			if (!isset($_SESSION['login_user'])){
			?>
				<li><a href="index.php?op=login">Login</a></li>
				<li><a href="index.php?op=register">Register</a></li>
			<?php 
			} else {
				$akunLoginObj = unserialize($_SESSION['login_user']);
				echo '<li><a href="index.php?op=upload">Upload</a></li>';
				echo '<li><a class="dropdown-button" href="#" data-activates="dropdown1">'.$akunLoginObj->getNamaAuthor().'<i class="fa fa-caret-down right" aria-hidden="true"></i></a></li>';
				echo '<ul id="dropdown1" class="dropdown-content">';
					if ($akunLoginObj->getIdAuthor() == $akunObj->getIdAuthor()){
						echo "<li class='active'><a href='index.php?op=usermeme&id=".$akunLoginObj->getIdAuthor()."'>My Meme</a></li>";
					}else{
						echo "<li><a href='index.php?op=usermeme&id=".$akunLoginObj->getIdAuthor()."'>My Meme</a></li>";
					}
					echo "<li><a href='index.php?op=editpass&id=".$akunLoginObj->getIdAuthor()."'>Change Password</a></li>";
					echo '<li class="divider"></li>';
					echo '<li><a href="index.php?op=logout">Logout</a></li>';
				echo '</ul>';
			}
			?>
			</ul>
		</div>
	</nav>
	<div class="container autcontent">
		<h4><?php print htmlentities($akunObj->getNamaAuthor()); ?> meme</h4>
		<?php if($memeObj == null){
			if (isset($_SESSION['login_user'])){			
				if ($akunLoginObj->getIdAuthor() == $akunObj->getIdAuthor()){?>
					<h1>Booooooooo</br>You are super lame</br>You haven't upload any meme</h1>
				<?php 
				} else {  ?>
					<h1><?php print htmlentities($akunObj->getNamaAuthor()); ?> is super lame</br><?php print htmlentities($akunObj->getNamaAuthor()); ?> haven't upload any meme</h1>
				<?php 
				}
			} else {  ?>
				<h1><?php print htmlentities($akunObj->getNamaAuthor()); ?> is super lame</br><?php print htmlentities($akunObj->getNamaAuthor()); ?> haven't upload any meme</h1>
			<?php
			}
		}else {?>
			<?php foreach ($memeObj as $meme):
			if (!isset($_SESSION['login_user'])){
				if($meme->getNsfw() == true){?>
					<h6><?php print htmlentities($meme->getJudul()); ?></h6>
					<p><span class="badge red darken-1">NSFW</span></p>
					<?php echo '<div class="center-align"><img src="../meme/img/nsfw.png"></div>';?>
					<p><span class="upvote"><?php echo $meme->getUpvote()->getVote();?></span> upvotes, <span class="downvote"><?php echo $meme->getDownvote()->getVote();?></span> downvotes</p>
					<div class="btn-container">
						<button onClick="alert('You have to login first')" class="waves-effect waves-light btn-large grey lighten-5"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>		
						<button onClick="alert('You have to login first')" class="waves-effect waves-light btn-large grey lighten-5"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
					</div><?php
				}else{?>
					<h6><?php print htmlentities($meme->getJudul()); ?></h6>
					<?php echo '<div class="center-align"><img src="../meme/img/'.$meme->getMeme().'"></div>';?>
					<p><span class="upvote"><?php echo $meme->getUpvote()->getVote();?></span> upvotes, <span class="downvote"><?php echo $meme->getDownvote()->getVote();?></span> downvotes</p>
					<div class="btn-container">
						<button onClick="alert('You have to login first')" class="waves-effect waves-light btn-large grey lighten-5"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>		
						<button onClick="alert('You have to login first')" class="waves-effect waves-light btn-large grey lighten-5"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
					</div><?php
				}
			}else{?>
				<h6><?php print htmlentities($meme->getJudul()); ?></h6>
				<?php if($meme->getNsfw() == true){ ?>
					<p><span class="badge red darken-1">NSFW</span></p>
				<?php } ?>
				<?php if ($akunLoginObj->getIdAuthor() == $meme->getAuthor()->getIdAuthor()){?>
					<p style="margin: 5px auto;">
						<a href ="index.php?op=editmeme&id=<?php echo $meme->getIdMeme(); ?>">edit</a>
						<a href ="index.php?op=deletememe&id=<?php echo $meme->getIdMeme(); ?>">delete</a>
					</p>
				<?php 
				}
				echo '<div class="center-align"><img src="../meme/img/'.$meme->getMeme().'"></div>';?>
				<p><span class="upvote"><?php echo $meme->getUpvote()->getVote();?></span> upvotes, <span class="downvote"><?php echo $meme->getDownvote()->getVote();?></span> downvotes</p>
				<div class="btn-container">
					<?php if($meme->getVoter() != null) { ?>
						<?php if($meme->getVoter()->getVotes() == 'u'){ ?>
							<button type="button" onClick="upvote(<?php echo $meme->getIdMeme(); ?>,<?php echo $akunLoginObj->getIdAuthor(); ?>, this)" class="voted waves-effect waves-light btn-large grey lighten-5">
								<i class="fa fa-arrow-up" aria-hidden="true"></i>
							</button>
							<button disabled="disabled" type="button" onClick="downvote(<?php echo $meme->getIdMeme(); ?>,<?php echo $akunLoginObj->getIdAuthor(); ?>, this)" class="waves-effect waves-light btn-large grey lighten-5">
								<i class="fa fa-arrow-down" aria-hidden="true"></i>
							</button>
						<?php } else if($meme->getVoter()->getVotes() == 'd'){ ?>
							<button disabled="disabled" type="button" onClick="upvote(<?php echo $meme->getIdMeme(); ?>,<?php echo $akunLoginObj->getIdAuthor(); ?>, this)" class="waves-effect waves-light btn-large grey lighten-5">
								<i class="fa fa-arrow-up" aria-hidden="true"></i>
							</button>
							<button type="button" onClick="downvote(<?php echo $meme->getIdMeme(); ?>,<?php echo $akunLoginObj->getIdAuthor(); ?>, this)" class="voted waves-effect waves-light btn-large grey lighten-5">
								<i class="fa fa-arrow-down" aria-hidden="true"></i>
							</button>
						<?php }
					}else{ ?>
						<button type="button" onClick="upvote(<?php echo $meme->getIdMeme(); ?>,<?php echo $akunLoginObj->getIdAuthor(); ?>, this)" class="waves-effect waves-light btn-large grey lighten-5">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>
						</button>
						<button type="button" onClick="downvote(<?php echo $meme->getIdMeme(); ?>,<?php echo $akunLoginObj->getIdAuthor(); ?>, this)" class="waves-effect waves-light btn-large grey lighten-5">
							<i class="fa fa-arrow-down" aria-hidden="true"></i>
						</button>
					<?php } ?>
				</div><?php
			}?>
			<?php endforeach; 
		} ?>
	</div>