<?php if (!isset($_SESSION['login_user'])){ ?>
	<title>Forbidden</title>
<body>
	<div class="container content">
		<h1>You can't access this page</h1>
	</div>
<?php } else { ?>
	<title>
			<?php print htmlentities($title) ?>
	</title>
</head>
<body>
	<nav class="amber darken-1">
		<div class="nav-wrapper container">
			<a href="index.php" class="brand-logo left">The Meme App</a>
			<ul id="nav-mobile" class="right">     
				<?php
				$akunLoginObj = unserialize($_SESSION['login_user']);
				echo '<li><a href="index.php?op=upload">Upload</a></li>';
				echo '<li><a class="dropdown-button" href="#" data-activates="dropdown1">'.$akunLoginObj->getNamaAuthor().'<i class="fa fa-caret-down right" aria-hidden="true"></i></a></li>';
				echo '<ul id="dropdown1" class="dropdown-content">';
					echo "<li><a href='index.php?op=usermeme&id=".$akunLoginObj->getIdAuthor()."'>My Meme</a></li>";
					echo "<li class='active'><a href='index.php?op=editpass&id=".$akunLoginObj->getIdAuthor()."'>Change Password</a></li>";
					echo '<li class="divider"></li>';
					echo '<li><a href="index.php?op=logout">Logout</a></li>';
				echo '</ul>';
			?>
			</ul>
		</div>
	</nav>
	<div class="row">
		<form method="POST" action="" class="col l4 m6 s10 offset-l4 offset-m3 offset-s1">
			<div class="row" style="padding: 25px 0;">
				<div class="col s12">
					<h5>Change Password</h5>
					<p><?php echo $mes ?></p>
				</div>
				<div class="input-field col s12">
					<input id="password" type="password" name="pass" class="validate" maxlength="25" required>
					<label for="password">Old Password</label>
				</div>
				<div class="input-field col s12">
					<input id="newpassword" type="password" name="newpass" class="validate" maxlength="25" required>
					<label for="newpassword">New Password</label>
				</div>
				<input type="hidden" name="id_akun" value=<?php echo $akunLoginObj->getIdAuthor();?> />
				<input type="hidden" name="form-submitted" value="1" />
				<div class="col s12">
					<button type="submit" class="waves-effect waves-light btn amber darken-1"/>Change</button>
				</div>
			</div>
		</form>
	</div>
<?php } ?>