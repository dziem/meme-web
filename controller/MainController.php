<?php
	session_start();
	require_once 'model/Database.php';
	require_once 'model/Object.php';

	class MainController {
		private $db = NULL;
    
		public function __construct() {
			$this->db = new Database();
		}
		
		public function redirect($location) {
			header('Location: '.$location);
		}
		
		function handleRequest() {
			$op = isset($_GET['op'])?$_GET['op']:NULL;
			try {
				if ( !$op || $op == 'listMeme') {
					$this->listMeme();
				}elseif ( $op == 'login' ) {
					$this->login();
				}elseif ( $op == 'logout' ) {
					$this->logout();
				}elseif ( $op == 'upload' ) {
					$this->upload();
				}elseif ( $op == 'usermeme' ) {
					$this->userMeme();
				}elseif ( $op == 'editmeme' ) {
					$this->editMeme();
				}elseif ( $op == 'deletememe' ) {
					$this->deleteMeme();
				}else if( $op == 'upvote' ){
					$this->upvote();
				}else if( $op == 'cancelupvote' ){
					$this->cancelUpvote();
				}else if( $op == 'downvote' ){
					$this->downvote();
				}else if( $op == 'canceldownvote' ){
					$this->cancelDownvote();
				}else if( $op == 'editpass' ){
					$this->editPass();
				} elseif ( $op == 'register' ) {
					$this->register();
				} else {
					$this->showError("Page not found", "Page for operation ".$op." was not found!");
				}
			} catch ( Exception $e ) {
				// some unknown Exception got through here, use application error page to display it
				$this->showError("Application error", $e->getMessage());
			}
		}
		
		public function listMeme() {
			$stmt = 'select * from meme order by id_meme desc';
			$meme = $this->db->selectAll($stmt);
			$memeObj = array();
			foreach ($meme as $memes):
				$stmt2 = "select * from akun where id_akun = '".$memes->id_akun."'";
				$akun = $this->db->selectAll($stmt2);
				if(!isset($_SESSION['login_user'])){
					$memeObj[] = new Meme($memes->id_meme, $akun[0]->id_akun, $akun[0]->username, $memes->judul, $memes->meme, $memes->nsfw, null, $memes->upvote, $memes->downvote);
				}else{
					$akunLoginObj = unserialize($_SESSION['login_user']);
					$stmt3 = "select * from vote where id_akun ='".$akunLoginObj->getIdAuthor()."' and id_meme = '".$memes->id_meme."'";
					$voter = $this->db->selectAll($stmt3);
					if($voter != null){
						$voterObj = new Voter($voter[0]->id_akun, $voter[0]->vote);
						$memeObj[] = new Meme($memes->id_meme, $akun[0]->id_akun, $akun[0]->username, $memes->judul, $memes->meme, $memes->nsfw, $voterObj, $memes->upvote, $memes->downvote);
					}else{
						$memeObj[] = new Meme($memes->id_meme, $akun[0]->id_akun, $akun[0]->username, $memes->judul, $memes->meme, $memes->nsfw, null, $memes->upvote, $memes->downvote);
					}
				}
			endforeach;
			include 'view/home.php';
		}
		
		public function userMeme() {
			$id = isset($_GET['id'])?$_GET['id']:NULL;
			$stmt = "select * from meme where id_akun = '".$id."' order by id_meme desc";
			$meme = $this->db->selectAll($stmt);
			$memeObj = array();
			$stmt2 = "select * from akun where id_akun = '".$id."'";
			$akun = $this->db->selectAll($stmt2);
			$akunObj = new Author($akun[0]->id_akun, $akun[0]->username);
			foreach ($meme as $memes):
				if(!isset($_SESSION['login_user'])){
					$memeObj[] = new Meme($memes->id_meme, $akunObj->getIdAuthor(),  $akunObj->getNamaAuthor(), $memes->judul, $memes->meme, $memes->nsfw, null, $memes->upvote, $memes->downvote);
				}else{
					$akunLoginObj = unserialize($_SESSION['login_user']);
					$stmt3 = "select * from vote where id_akun ='".$akunLoginObj->getIdAuthor()."' and id_meme = '".$memes->id_meme."'";
					$voter = $this->db->selectAll($stmt3);
					if($voter != null){
						$voterObj = new Voter($voter[0]->id_akun, $voter[0]->vote);
						$memeObj[] = new Meme($memes->id_meme, $akunObj->getIdAuthor(),  $akunObj->getNamaAuthor(), $memes->judul, $memes->meme, $memes->nsfw, $voterObj, $memes->upvote, $memes->downvote);
					}else{
						$memeObj[] = new Meme($memes->id_meme, $akunObj->getIdAuthor(),  $akunObj->getNamaAuthor(), $memes->judul, $memes->meme, $memes->nsfw, null, $memes->upvote, $memes->downvote);
					}
				}
			endforeach;
			include 'view/usermeme.php';
		}
		
		public function editMeme(){
			$id = isset($_GET['id'])?$_GET['id']:NULL;
			$stmt = "select * from meme where id_meme = '".$id."'";
			$meme = $this->db->selectAll($stmt);
			$memeObj = array();
			if($meme != null){
				$memeObj[] = new Meme($meme[0]->id_meme, 0,  null, $meme[0]->judul, $meme[0]->meme, $meme[0]->nsfw, null, 0, 0);
			}
			$errors = array();
			if ( isset($_POST['form-submitted']) ) {
            
				$judul       = isset($_POST['judul']) ?   $_POST['judul']  :NULL;
				$meme      = isset($_FILES['meme']['name'])?   $_FILES['meme']['name'] :NULL;
				$meme_tmp      = isset($_FILES['meme']['tmp_name'])?   $_FILES['meme']['tmp_name'] :NULL;
				
				try {
					if(isset($_POST['nsfw'])){
						$nsfwB = 'TRUE';
					}else{
						$nsfwB = 'FALSE';
					}
					if($meme != null){
						$newmeme = date('dmYHis').$meme;
						$new_path = $_SERVER['DOCUMENT_ROOT'] .'/meme/img/' . $newmeme;
						if(move_uploaded_file($meme_tmp, $new_path)){
							unlink($_SERVER['DOCUMENT_ROOT'] .'/meme/img/' .$memeObj[0]->getMeme());
							$stmt2 = "update meme 
							set judul = '".$judul."', meme = '".$newmeme."', nsfw = ".$nsfwB."
							where id_meme = ".$memeObj[0]->getIdMeme();
						}
					}else{
						$stmt2 = "update meme 
						set judul = '".$judul."', nsfw = ".$nsfwB."
						where id_meme = ".$memeObj[0]->getIdMeme();
					}
					$this->db->query($stmt2);
					$id = isset($_GET['id'])?$_GET['id']:NULL;
					$stmt = "select * from meme where id_meme = '".$id."'";
					$meme = $this->db->selectAll($stmt);
					$this->redirect('index.php?op=usermeme&id='.$meme[0]->id_akun);
					return;
				} catch (ValidationException $e) {
					$errors = $e->getErrors();
				}
			}
			include 'view/editmeme.php';
		}
		public function deleteMeme(){
			$id = isset($_GET['id'])?$_GET['id']:NULL;
			$stmt = "select * from meme where id_meme = '".$id."'";
			$meme = $this->db->selectAll($stmt);
			$stmt2 = "delete from vote where id_meme = '".$id."'";
			$stmt3 = "delete from meme where id_meme = '".$id."'";
			$this->db->query($stmt2);
			$this->db->query($stmt3);
			$filename = $_SERVER['DOCUMENT_ROOT'] .'/meme/img/' . $meme[0]->meme;
			if (file_exists($filename)) {
				unlink($filename);
			 }
			$this->redirect('index.php?op=usermeme&id='.$meme[0]->id_akun);
		}
		
		public function login(){
			$title = 'Login';
			$mes = '';
			$errors = array();
			if ( isset($_POST['form-submitted']) ) {
            
				$uname       = isset($_POST['uname']) ?   $_POST['uname']  :NULL;
				$pass      = isset($_POST['pass'])?   $_POST['pass'] :NULL;
				
				try {
					$stmt = "select * from akun where username = '".$uname."' and password = '".$pass."'";
					$resStmt = $this->db->selectAll($stmt);
					if($resStmt != null){
						$autObj = new Author($resStmt[0]->id_akun, $resStmt[0]->username);
						$_SESSION['login_user'] = serialize($autObj);
						$this->redirect('index.php');
						return;
					}else{
						$mes = 'Username / password salah';
					}
				} catch (ValidationException $e) {
					$errors = $e->getErrors();
				}
			}
			include 'view/login.php';
		}
		
		public function logout(){
			session_destroy();
			$this->redirect('index.php');
		}
		
		public function upload(){
			$title = 'Upload a meme';
			$errors = array();
			if ( isset($_POST['form-submitted']) ) {
            
				$judul       = isset($_POST['judul']) ?   $_POST['judul']  :NULL;
				$idAkun       = isset($_POST['id_akun']) ?   $_POST['id_akun']  :NULL;
				$meme      = isset($_FILES['meme']['name'])?   $_FILES['meme']['name'] :NULL;
				$meme_tmp      = isset($_FILES['meme']['tmp_name'])?   $_FILES['meme']['tmp_name'] :NULL;
				
				try {
					$newmeme = date('dmYHis').$meme;
					$new_path = $_SERVER['DOCUMENT_ROOT'] .'/meme/img/' . $newmeme;
					if(isset($_POST['nsfw'])){
						$nsfwB = 'TRUE';
					}else{
						$nsfwB = 'FALSE';
					}
					$id_akun = (int)$idAkun;
					if(move_uploaded_file($meme_tmp, $new_path)){
						$stmt = "insert into meme 
						(id_akun, judul, meme, nsfw, upvote, downvote)
						values (".$id_akun.",'".$judul."','".$newmeme."',".$nsfwB.",0,0)";
						$this->db->query($stmt);
						$this->redirect('index.php');
						return;
					}
				} catch (ValidationException $e) {
					$errors = $e->getErrors();
				}
			}
			include 'view/upload.php';
		}
		
		 public function register() {
			$title = 'Create new account';
			$mes = '';
			$errors = array();
			if ( isset($_POST['form-submitted']) ) {
            
				$uname       = isset($_POST['uname']) ?   $_POST['uname']  :NULL;
				$pass      = isset($_POST['pass'])?   $_POST['pass'] :NULL;
				
				try {
					$stmt3 = "select * from akun where username = '".$uname."'";
					$resStmt3 = $this->db->selectAll($stmt3);
					if($resStmt3 == null){
						$stmt = "insert into akun (username, password) values ('".$uname."','".$pass."')";
						$this->db->query($stmt);
						$stmt2 = "select * from akun where username = '".$uname."' and password = '".$pass."'";
						$resStmt2 = $this->db->selectAll($stmt2);
						$autObj = new Author($resStmt2[0]->id_akun, $resStmt2[0]->username);
						$_SESSION['login_user'] = serialize($autObj);
						$this->redirect('index.php');
						return;
					}else{
						$mes = "Username already exist, use another username";
					}
				} catch (ValidationException $e) {
					$errors = $e->getErrors();
				}
			}
			include 'view/register.php';
		 }
		 public function editPass(){
			$title = 'Change Password';
			$mes = '';
			$errors = array();
			if ( isset($_POST['form-submitted']) ) {
            
				$pass       = isset($_POST['pass']) ?   $_POST['pass']  :NULL;
				$newpass      = isset($_POST['newpass'])?   $_POST['newpass'] :NULL;
				$idAkun       = isset($_POST['id_akun']) ?   $_POST['id_akun']  :NULL;
				
				try {
					$stmt = "select * from akun where id_akun = '".$idAkun."'";
					$resStmt = $this->db->selectAll($stmt);
					$account = new Account($resStmt[0]->id_akun, $resStmt[0]->username, $resStmt[0]->password); 
					if($pass == $account->getPassword()){
						$stmt = "update akun set password = '".$newpass."' where id_akun = '".$idAkun."'";
						$this->db->query($stmt);
						$this->redirect("index.php");
						return;
					}else{
						$mes = "Old password wrong";
					}
				} catch (ValidationException $e) {
					$errors = $e->getErrors();
				}
			}
			include 'view/editpassword.php';
		 }
		 
		 public function upvote() {
			$idMeme       = isset($_POST['id_meme']) ?   $_POST['id_meme']  :NULL;
			$idAkun      = isset($_POST['id_akun'])?   $_POST['id_akun'] :NULL;
			$stmt = "insert into vote (id_akun, id_meme, vote) values ('".$idAkun."','".$idMeme."','u')";
			$this->db->query($stmt);
			$stmt2 = "UPDATE meme set upvote = (upvote + 1) where id_meme = ".$idMeme;
			$this->db->query($stmt2);
			$stmt3 = "select upvote from meme where id_meme = ".$idMeme;
			$resStmt3 = $this->db->selectAll($stmt3);
			echo $resStmt3[0]->upvote;
		 }
		 
		 public function cancelUpvote(){
			$idMeme       = isset($_POST['id_meme']) ?   $_POST['id_meme']  :NULL;
			$idAkun      = isset($_POST['id_akun'])?   $_POST['id_akun'] :NULL;
			$stmt = "delete from vote where id_akun = '".$idAkun."' and id_meme = '".$idMeme."' and vote = 'u'";
			$this->db->query($stmt);
			$stmt2 = "UPDATE meme set upvote = (upvote - 1) where id_meme = ".$idMeme;
			$this->db->query($stmt2);
			$stmt3 = "select upvote from meme where id_meme = ".$idMeme;
			$resStmt3 = $this->db->selectAll($stmt3);
			echo $resStmt3[0]->upvote;
		 }
		 
		 public function downvote() {
			$idMeme       = isset($_POST['id_meme']) ?   $_POST['id_meme']  :NULL;
			$idAkun      = isset($_POST['id_akun'])?   $_POST['id_akun'] :NULL;
			$stmt = "insert into vote (id_akun, id_meme, vote) values ('".$idAkun."','".$idMeme."','d')";
			$this->db->query($stmt);
			$stmt2 = "UPDATE meme set downvote = (downvote + 1) where id_meme = ".$idMeme;
			$this->db->query($stmt2);
			$stmt3 = "select downvote from meme where id_meme = ".$idMeme;
			$resStmt3 = $this->db->selectAll($stmt3);
			echo $resStmt3[0]->downvote;
		 }
		 
		 public function cancelDownvote(){
			$idMeme       = isset($_POST['id_meme']) ?   $_POST['id_meme']  :NULL;
			$idAkun      = isset($_POST['id_akun'])?   $_POST['id_akun'] :NULL;
			$stmt = "delete from vote where id_akun = '".$idAkun."' and id_meme = '".$idMeme."' and vote = 'd'";
			$this->db->query($stmt);
			$stmt2 = "UPDATE meme set downvote = (downvote - 1) where id_meme = ".$idMeme;
			$this->db->query($stmt2);
			$stmt3 = "select downvote from meme where id_meme = ".$idMeme;
			$resStmt3 = $this->db->selectAll($stmt3);
			echo $resStmt3[0]->downvote;
		 }
	}
?>