# Blog Forteroche – Mise à jour et Administration

Ce projet constitue la mise à jour du blog de l’autrice **Emilie Forteroche**, développé selon une architecture MVC légère en PHP 8.2.

L’objectif de cette évolution est d’ajouter :
- un **système de comptage des vues**,
- une **page de monitoring** des articles,
- un **tri dynamique** des colonnes (PHP pur),
- un **système de suppression des commentaires** accessible depuis l’interface,
- un **accès sécurisé** à la partie administration.

Le code respecte les bonnes pratiques modernes :
- PHP 8.2+
- PSR-12
- PDO + requêtes préparées
- Architecture MVC cohérente
- Sécurité (contrôle d’accès, validation)
- HTML/CSS propre et structuré


---

## 📦 Prérequis

### Base de données
Créer la base `blog_forteroche` :
CREATE DATABASE blog_forteroche
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;


Importer ensuite le contenu du fichier SQL initial présent dans `/sql/blog_forteroche.sql`.

### Configuration PHP
- PHP ≥ 8.2
- Activer l’extension **intl** dans `php.ini`

### Configuration du projet
Renommer le fichier :
config/_config.php -> config/config.php


Modifier les identifiants de connexion selon votre environnement local.


---

## 🔐 Connexion à l’administration

Pour accéder à la partie **Administration** et **Monitoring**, il faut être connecté.

**Identifiants fournis par l'autrice :**

- **Login :** Emilie  
- **Mot de passe :** password  

L’accès via le menu *Administration* redirige vers le formulaire de connexion si l’utilisateur n’est pas authentifié.

La suppression des commentaires, la gestion des articles et la page de monitoring sont **réservées à l’utilisateur connecté**.

---

## 🔧 Architecture du projet

/controllers
AdminController.php
ArticleController.php
CommentController.php

/models
Article.php
ArticleManager.php
Comment.php
CommentManager.php
User.php
UserManager.php
DBManager.php

/views
templates/
home.php
detailArticle.php
connectionForm.php
admin.php
adminMonitoring.php
...
View.php

/services
Utils.php

/config
config.php

---

## 🔒 Sécurité

- Les actions sensibles (`deleteComment`, accès admin, monitoring…) sont protégées par :
  - `Utils::checkIfUserIsConnected()` dans les contrôleurs
  - `Utils::isUserConnected()` pour masquer les options dans les vues
- Le manager **ne contient aucune logique métier**, seulement l’accès aux données
- Toutes les requêtes SQL passent par PDO + statements préparés

---

## 📝 Auteur

Projet adapté par **Salem Hadjali** dans le cadre du parcours  
**Développeur d’application full-stack / OpenClassrooms**.

