<?php
// Création d'un utilisateur
$data = [
	'prenom' => 'Antoine',
	'age'    => 42
];
$user = User::create($data);

// Sélection des utilisateurs majeurs et articles qu'ils ont écrits
$users = User::with('articles')
	->where('age', '>=', 18)
	->get();

// Suppression des utilisateurs vivant à Paris
User::where('city', 'Paris')->delete();

// Les derniers articles d'un utilisateur (3ème page)
$articles = Article::whereUserId($user->id)
	->latest()
	->take(10)
	->skip(20)
	->get();