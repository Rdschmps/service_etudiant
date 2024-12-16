
## 📚 Service Étudiant - Plateforme d'Aide aux Devoirs

Ce projet est une plateforme web permettant aux étudiants de demander et fournir de l'aide pour leurs devoirs. Les utilisateurs peuvent créer des posts pour poser des questions, répondre aux posts pour gagner des points, et interagir dans un environnement sécurisé grâce à une authentification basée sur des tokens JWT.

---

### 🚀 Fonctionnalités Principales

- **Création de posts** pour poser des questions sur différentes matières.
- **Réponse aux posts** pour aider les autres étudiants et gagner des points.
- **Système de points** pour réguler la participation :
  - **Créer un post** coûte **1 point**.
  - **Répondre à un post** rapporte **1 point**.
- **Authentification sécurisée** avec JWT (JSON Web Tokens).
- **Profil utilisateur** pour consulter les points et les informations personnelles.
- **Déconnexion sécurisée** pour détruire la session et le token JWT.

---

### 🛠️ Technologies Utilisées

- **Frontend** :
  - **HTML5 / CSS3** : Structure et style des pages.
  - **TailwindCSS** : Framework CSS pour un design moderne et responsive.
  - **JavaScript (ES6)** : Dynamique du frontend et appels API avec `fetch`.

- **Backend** :
  - **PHP (v7.4+)** : Langage serveur pour le traitement des requêtes.
  - **Firebase JWT** : Bibliothèque pour la gestion des tokens JWT.
  - **MySQL** : Base de données pour stocker les utilisateurs, posts, et réponses.
  - **Composer** : Gestionnaire de dépendances PHP.

- **API Gateway** :
  - Point d'entrée unique pour les requêtes backend, permettant de centraliser la logique de sécurité et de routage des requêtes.

- **Serveur Local** :
  - **WAMP / XAMPP** : Serveurs Apache + MySQL pour le développement local.

---

### 📥 Installation du Projet

Suivez ces étapes pour installer et exécuter le projet sur votre machine locale.

#### 1. Prérequis

- **WAMP** ou **XAMPP** installé sur votre machine.
- **PHP 7.4+** et **MySQL** activés.
- **Composer** installé globalement (https://getcomposer.org/download/).

#### 2. Cloner le Dépôt

```bash
git clone https://github.com/votre-utilisateur/service-etudiant.git
cd service-etudiant
```

#### 3. Configurer le Backend

1. **Installer les dépendances PHP** avec Composer :

   ```bash
   cd backend
   composer install
   ```

2. **Créer un fichier `.env`** dans le dossier `backend` pour les informations de connexion à la base de données :

   ```plaintext
   DB_HOST=localhost
   DB_NAME=service_etudiant
   DB_USER=root
   DB_PASS=votre_mot_de_passe
   SECRET_KEY=QWxhZGRpbjpvcGVuIHNlc2FtZQ==
   ```

   - **`DB_HOST`** : Adresse du serveur MySQL (souvent `localhost`).
   - **`DB_NAME`** : Nom de la base de données.
   - **`DB_USER`** : Nom d'utilisateur MySQL.
   - **`DB_PASS`** : Mot de passe MySQL.
   - **`SECRET_KEY`** : Clé secrète pour signer les tokens JWT.

3. **Créer la Base de Données** avec le fichier SQL fourni :

   - Importer le fichier **`database.sql`** via **phpMyAdmin** ou la ligne de commande :

     ```bash
     mysql -u root -p < database.sql
     ```

4. **Créer un Utilisateur MySQL** (si nécessaire) :

   ```sql
   CREATE USER 'service_user'@'localhost' IDENTIFIED BY 'password';
   GRANT ALL PRIVILEGES ON service_etudiant.* TO 'service_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

#### 4. Lancer le Serveur Local

- **Avec WAMP/XAMPP** : Démarrez les services Apache et MySQL depuis le panneau de contrôle.

- Placez le dossier du projet dans le répertoire **`www`** (pour WAMP) ou **`htdocs`** (pour XAMPP).

#### 5. Accéder à l'Application

Ouvrez votre navigateur et accédez à l'URL suivante :

```plaintext
http://localhost/service-etudiant/frontend/dashboard.html
```

---

### 🔒 Sécurité

- **Authentification JWT** : Chaque requête aux routes protégées doit inclure un token JWT valide dans l'en-tête `Authorization`.
- **Protection des Routes** : Les pages protégées vérifient si l'utilisateur est connecté avant de s'afficher.
- **API Gateway** : Centralise les requêtes vers le backend pour appliquer des règles de sécurité uniformes.
- **Déconnexion** : La déconnexion supprime le token JWT et détruit la session côté serveur.

---

### 📂 Structure du Projet

```
service-etudiant/
│
├── backend/
│   ├── authentification/
│   │   ├── dashboard.php
│   │   └── logout.php
│   ├── common/
│   │   └── Database.php
│   ├── announcements/
│   │   ├── create_post.php
│   │   └── list_posts.php
│   └── gateway.php
│
├── frontend/
│   ├── dashboard.html
│   ├── create_post.html
│   ├── list_posts.html
│   ├── login.html
│   └── logout.html
│
└── database.sql
```

---

### 📝 API Endpoints

| **Méthode** | **Endpoint**                                           | **Description**                       |
|-------------|--------------------------------------------------------|---------------------------------------|
| `POST`     | `/backend/authentification/dashboard.php`              | Récupérer les informations utilisateur|
| `POST`     | `/backend/authentification/logout.php`                 | Déconnecter l'utilisateur             |
| `POST`     | `/backend/announcements/create_post.php`               | Créer un post                         |
| `GET`      | `/backend/announcements/list_posts.php`                | Lister tous les posts                 |

---

### 🐞 Dépannage

1. **Erreur de connexion à la base de données** :  
   - Vérifiez les informations dans le fichier `.env`.
   - Assurez-vous que MySQL est démarré.

2. **Token JWT invalide** :  
   - Vérifiez la clé secrète (`SECRET_KEY`) utilisée pour signer le token.

3. **Accès aux pages protégées après déconnexion** :  
   - Vérifiez que le token JWT est bien supprimé du `localStorage` après le logout.
   - Assurez-vous que les routes backend vérifient correctement le token JWT.

---

### 🧑‍💻 Auteur

- **Nom** : [Deschamps Rayan] & [Lebleis Michaud Thomin Dorian]


---

### 📄 Licence

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser et de le modifier selon vos besoins.

---

### 🎉 Bon Développement !

N'hésitez pas à proposer des améliorations ou à signaler des bugs via des issues sur le dépôt GitHub. 😊🚀
