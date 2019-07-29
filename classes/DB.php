<?php

	abstract class DB
	{
		public static function getAllMovies()
		{
			global $connection;

			$stmt = $connection->prepare("
				SELECT m.id AS 'movie_id', m.title, m.rating, m.awards, m.release_date, m.length, g.name AS 'genre', g.id AS 'genre_id'
				FROM movies as m
				LEFT JOIN genres as g
				ON g.id = m.genre_id
				ORDER BY m.title;
			");

			$stmt->execute();

			$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$moviesObject = [];

			foreach ($movies as $movie) {
				$finalMovie = new Movie($movie['title'], $movie['rating'], $movie['awards'], $movie['release_date']);
				$finalMovie->setID($movie['id']);
				$finalMovie->setLength($movie['length']);
				$finalMovie->setGenreID($movie['genre_id']);
				$finalMovie->setGenreName($movie['genre']);

				$moviesObject[] = $finalMovie;
			}

			return $moviesObject;
		}

		public static function getAllGenres()
		{
			global $connection;

			$stmt = $connection->prepare(" SELECT id, name, ranking, active FROM genres");

			$stmt->execute();

			$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$genresObject = [];

			foreach ($genres as $genre) {
				$finalGenre = new Genre($genre['name'], $genre['ranking'], $genre['active']);

				$finalGenre->setID($genre['id']);

				$genresObject[] = $finalGenre;
			}

			return $genresObject;
		}

		public static function getAllActors(){
			global $connection;
			$stmt = $connection->prepare("SELECT id, first_name, last_name, rating, favourite_movie_id FROM actors");
		$stmt = execute();
		$actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$actorsObject = [];
		foreach ($actors as $actor){
		  $finalActor = new Actor($actor["first_name"], $actor["last_name"]);
			$finalActor->setID($genre["id"]);
			$finalActor->setRating($actor["rating"]);
			$finalActor->setFavouriteMovieId($actor["favourite_movie_id"]);
			$actorsObject[] = $finalActor;
		} return $actorsObject;

		}

		public static function saveMovie(Movie $movie)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					INSERT INTO movies (title, rating, awards, release_date, length, genre_id)
					VALUES(:title, :rating, :awards, :release_date, :length, :genre_id)
				");


				$stmt->bindValue(':title', $movie->getTitle());
				$stmt->bindValue(':rating', $movie->getRating());
				$stmt->bindValue(':awards', $movie->getAwards());
				$stmt->bindValue(':release_date', $movie->getReleaseDate());
				$stmt->bindValue(':length', $movie->getLength());
				$stmt->bindValue(':genre_id', $movie->getGenreID());

				$stmt->execute();

				return true;
			} catch (PDOException $exception) {
				return false;
			}
		}

		public static function saveGenre(Genre $genre)
		{
			global $connection;

			$genres = self::getAllGenres();

			$finalGenres = [];

			foreach ($genres as $oneGenre) {
				$finalGenres[] = $oneGenre->getName();
			}

			if (!in_array($genre->getName(), $finalGenres)) {
				$stmt = $connection->prepare("
					INSERT INTO genres (name, ranking, active)
					VALUES(:name, :ranking, :active)
				");

				$stmt->bindValue(':name', $genre->getName());
				$stmt->bindValue(':ranking', $genre->getRanking());
				$stmt->bindValue(':active', $genre->getActive());

				$stmt->execute();

				return true;
			} else {
				return false;
			}
		}


		public static function saveActor(Actor $actor){
			global $connection;
			$actors = self::getAllActors();
			$finalActors = [];

		foreach($actors as $actor){
			$finalActors[] = $actor->getFirstName();
			$finalActors[] = $actor->getLastName();

		}

		if (!in_array($actor->getFirstName() && $actor->getLastName(), $finalActors)){

			$stmt = $connection->prepare("
			INSERT INTO actors (first_name, last_name, rating, favourite_movie_id)
			VALUES(:first_name, :last_name, :rating, :favourite_movie_id)
		 	");

		 $stmt->bindValue(":first_name", $actors->getFirstName());
		 $stmt->bindValue(":last_name", $actors->getLastName());
		 $stmt->bindValue(":rating", $actors->getRating());
		 $stmt->bindValue(":favourite_movie_id", $actors->getFavouriteMovieId());
		 $stmt->execute();
		 return true;
		} else {
		return false;
		}
		}


	}
