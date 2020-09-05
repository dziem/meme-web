	<title>
			<?php print htmlentities($title) ?>
	</title>
</head>
<body>
	<nav class="amber darken-1">
		<div class="nav-wrapper container">
			<a href="index.php" class="brand-logo left">The Meme App</a>
			<ul id="nav-mobile" class="right">     
				<li><a href="index.php?op=login">Login</a></li>
				<li class="active"><a href="index.php?op=register">Register</a></li>
			</ul>
		</div>
	</nav>
	<div class="row">
		<form method="POST" action="" class="col l4 m6 s10 offset-l4 offset-m3 offset-s1">
			<div class="row" style="padding: 25px 0;">
				<div class="col s12">
					<h5>Create new account</h5>
					<p>Have an account? <a href="index.php?op=login">Login</a></p>
					<p><?php echo $mes ?></p>
				</div>
				<div class="input-field col s12">
					<input id="username" type="text" name="uname" class="validate" maxlength="25" required>
					<label for="username">Username</label>
				</div>
				<div class="input-field col s12">
					<input id="password" type="password" name="pass" class="validate" maxlength="25" required>
					<label for="password">Password</label>
				</div>
				<input type="hidden" name="form-submitted" value="1" />
				<div class="col s12">
					<button type="submit" class="waves-effect waves-light btn amber darken-1"/>Register</button>
				</div>
			</div>
		</form>
	</div>