// Création d'un utilisateur
Map<String, String> userData = new HashMap<String, String>();
userData.put("prenom", "Antoine");
userData.put("nom", "Augusti");
User user = User.create(userData);

// Sélection des utilisateurs majeurs et articles qu'ils ont écrits
ArrayList<User> users = User.with("articles")
    .where("age", ">=", 18)
    .get();

// Suppression des utilisateurs vivant à Paris
User.where("ville", "Paris").delete();

// Les derniers articles d'un utilisateur (3ème page)
final int NOMBRE_ARTICLES_PAR_PAGE = 10;
ArrayList<Article> articles = Article.whereUserId(user.getId())
    .latest()
    .skip(2*NOMBRE_ARTICLES_PAR_PAGE)
    .take(NOMBRE_ARTICLES_PAR_PAGE)
    .get();
