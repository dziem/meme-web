<?php
	class Author{
		private $idAuthor;
		private $namaAuthor;
		
		function __construct( $id, $nama ){
			$this->idAuthor = $id;
			$this->namaAuthor = $nama;
		}
		function setIdAuthor($id){
			$this->idAuthor = $id;
		}
		function setNamaAuthor($nama){
			$this->namaAuthor = $nama;
		}
		function getIdAuthor(){
			return $this->idAuthor;
		}
		function getNamaAuthor(){
			return $this->namaAuthor;
		}
	}
	
	class Account extends Author{
		private $password;
		
		function __construct( $id, $nama, $pass ){
			$this->password = $pass;
			parent::__construct( $id, $nama );
		}
		function getPassword(){
			return $this->password;
		}
		function setPassword($pass){
			$this->password = $pass;
		}
	}
	
	class Meme{
		private $idMeme;
		private $author;
		private $judul;
		private $meme;
		private $nsfw;
		private $rating;
		private $voter;
		private $upvote;
		private $downvote;
		
		function __construct( $idm, $ida, $uname, $jdl, $mim, $nsfw, $vtr, $upv, $dwv ){
			$this->idMeme = $idm;
			$this->author = new Author($ida, $uname);
			$this->judul = $jdl;
			$this->meme = $mim;
			$this->nsfw = $nsfw;
			$this->voter = $vtr;
			$this->upvote = new Upvote($upv);
			$this->downvote = new Downvote($dwv);
		}
		function setIdMeme($id){
			$this->idMeme = $id;
		}
		function setAuthor($autr){
			$this->author = $autr;
		}
		function setVoter($vtr){
			$this->voter = $vtr;
		}
		function setJudul($jdl){
			$this->judul = $jdl;
		}
		function setMeme($nsfw){
			$this->nsfw = $nsfw;
		}
		function setNsfw($mim){
			$this->meme = $mim;
		}
		function getIdMeme(){
			return $this->idMeme;
		}
		function getAuthor(){
			return $this->author;
		}
		function getVoter(){
			return $this->voter;
		}
		function getJudul(){
			return $this->judul;
		}
		function getMeme(){
			return $this->meme;
		}
		function getNsfw(){
			return $this->nsfw;
		}
		function getUpvote(){
			return $this->upvote;
		}
		function getDownvote(){
			return $this->downvote;
		}
	}
	
	class Voter{
		private $user;
		private $votes;
		
		function __construct( $ida, $vote ){
			$this->user = new Author($ida, null);
			$this->votes = $vote;
		}
		function setUser($usr){
			$this->user = $usr;
		}
		function setVotes($vt){
			$this->votes = $vt;
		}
		function getUser(){
			return $this->user;
		}
		function getVotes(){
			return $this->votes;
		}
	}
	
	interface VoteGetter{
		public function getVote();
	}
	
	class Upvote implements VoteGetter{
		private $upvote;
		
		function __construct( $vote ){
			$this->upvote = $vote;
		}
		public function getVote(){
			return $this->upvote;
		}
	}
	
	class Downvote implements VoteGetter{
		private $downvote;
		
		function __construct( $vote ){
			$this->downvote = $vote;
		}
		public function getVote(){
			return $this->downvote;
		}
	}
?>