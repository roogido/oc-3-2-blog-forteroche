<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager 
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles() : array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    public function incrementViews(int $id): void
    {
        $sql = "UPDATE article SET views = views + 1 WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
    }    
    
    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id) : ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article) : void 
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article) : void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article) : void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id) : void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Update SH : Ajout méthode
     * Récupère la liste des articles pour la page de monitoring,
     * avec possibilité de tri dynamique.
     *
     * Le tri est sécurisé via une whitelist : seuls les champs autorisés
     * peuvent être utilisés dans l'ORDER BY. Pour le tri sur le nombre de
     * commentaires, la valeur est gérée après récupération (injection manuelle).
     *
     * @param string $sort      Colonne sur laquelle appliquer le tri (whitelistée).
     * @param string $direction Sens du tri : ASC ou DESC.
     *
     * @return Article[]        Tableau d'objets Article hydratés.
     */    
    public function getArticlesForMonitoring(string $sort, string $direction): array
    {
        $allowed = [
            'title' => 'title',
            'views' => 'views',
            'comment_count' => 'date_creation', // tri par commentaire se fera après injection
            'date_creation' => 'date_creation'
        ];

        $sortField = $allowed[$sort] ?? 'date_creation';

        $sql = "SELECT * FROM article ORDER BY {$sortField} {$direction}";
        $result = $this->db->query($sql);

        $articles = [];
        while ($row = $result->fetch()) {
            $articles[] = new Article($row);
        }

        return $articles;
    }    
}