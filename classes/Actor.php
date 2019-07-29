<?php

	class Actor
	{
		private $id;
		private $first_name;
		private $last_name;
		private $rating;
    private $favourite_movie_id;

		public function __construct($first_name, $last_name)
		{
			$this->first_name = $first_name;
			$this->last_name = $last_name;

		}

		public function setID($id)
		{
			$this->id = $id;
		}

		public function getID()
		{
			return $this->id;
		}

    public function setFirstName($first_name){
      $this->first_name = $first_name;
    }
    public function getFirstName()
		{
			return $this->first_name;
		}

    public function setLastName($last_name){
      $this->last_name = $last_name;
    }
    public function getLastName()
		{
			return $this->last_name;
		}

    public function setRating($rating){
      $this->rating = $rating;
    }
    public function getRating()
		{
			return $this->rating;
		}

    public function setFavouriteMovieId($favourite_movie_id){
      $this->favourite_movie_id = $favourite_movie_id;
    }
    public function getFavouriteMovieId()
		{
			return $this->favourite_movie_id;
		}
	}
