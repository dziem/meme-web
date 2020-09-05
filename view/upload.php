<?php if (!isset($_SESSION['login_user'])){ ?>
	<title>Forbidden</title>
<body>
	<div class="container content">
		<h1>You can't access this page</h1>
	</div>
<?php } else { ?>	
	<title>Upload a meme</title>
</head>
<body>
	<nav class="amber darken-1">
		<div class="nav-wrapper container">
			<a href="index.php" class="brand-logo left">The Meme App</a>
			<ul id="nav-mobile" class="right">     
			<?php
				$akunLoginObj = unserialize($_SESSION['login_user']);
				echo '<li class="active"><a href="index.php?op=upload">Upload</a></li>';
				echo '<li><a class="dropdown-button" href="#" data-activates="dropdown1">'.$akunLoginObj->getNamaAuthor().'<i class="fa fa-caret-down right" aria-hidden="true"></i></a></li>';
				echo '<ul id="dropdown1" class="dropdown-content">';
					echo "<li><a href='index.php?op=usermeme&id=".$akunLoginObj->getIdAuthor()."'>My Meme</a></li>";
					echo "<li><a href='index.php?op=editpass&id=".$akunLoginObj->getIdAuthor()."'>Change Password</a></li>";
					echo '<li class="divider"></li>';
					echo '<li><a href="index.php?op=logout">Logout</a></li>';
				echo '</ul>';
			?>
			</ul>
		</div>
	</nav>
	<div class="row">
		<form method="POST" action="" enctype="multipart/form-data" class="col l4 m6 s10 offset-l4 offset-m3 offset-s1">
			<div class="row" style="padding: 25px 0;">
				<div class="col s12">
					<h5>Upload a meme</h5>
				</div>
				<div class="input-field col s12">
					<input id="title" type="text" name="judul" class="validate" maxlength="50" required>
					<label for="title">Title</label>
				</div>
				<div class="input-field col s12">
					<div class="file-field input-field">
						<div class="btn amber darken-1">
							<span>Image</span>
							<input type="file" name="meme" accept="image/*" required>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>
				<div class="col s12">
					<p>
						<input type="checkbox" id="test6" name="nsfw" value="nsfw"/>
						<label for="test6">Not Safe For Work</label>
					</p>
				</div>
				<input type="hidden" name="id_akun" value=<?php echo $akunLoginObj->getIdAuthor();?> />
				<input type="hidden" name="form-submitted" value="1" />
				<div class="col s12" style="margin-top: 25px;">
					<button type="submit" class="waves-effect waves-light btn amber darken-1"/>Upload</button>
				</div>
			</div>
		</form>
	</div>
<?php } ?>