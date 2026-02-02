# 🐮 Bienvenue sur C'Coworker !

Salut ! 👋 Bienvenue sur le repo officiel de **C'Coworker**.

## L projet ?

**C'Coworker**, c'est une application web codée pour gérer un espace de coworking.
L'idée est simple :
- **L'Admin** crée des espaces (bureaux, salles de réunion, open-spaces).
- **Les Coworkers* peuvent réserver ces espaces.
- Le tout sans conflits de planning 

### 🛠️ La Stack Technique 
On est sur du **PHP Natif**
- **Backend** : PHP 8.2 (MVC maison).
- **Base de données** : MySQL (MariaDB).
- **Frontend** : HTML5, CSS3, et **Bootstrap 5** pour que ça soit joli sans y passer 10 ans.
- **Icônes** : Bootstrap Icons.

---

## ⚙️ Comment ça marche le Workflow ? (Jira + GitHub)

Alors là, attention, on ne rigole pas avec l'orga. On se la joue pro, méthode Agile et tout le tralala.

### 1. Le Cerveau : JIRA 🧠
Tout part de **Jira**. C'est là que notre équipe note toutes les tâches (User Stories) à faire. Chaque tâche a un code, genre `MA2-18`.
- **Backlog** : Le frigo où on stocke les idées.
- **Sprints** : Ce qu'on cuisine cette semaine.

### 2. Le Code : GITHUB 🐙
GitHub, c'est le coffre-fort. Mais on n'y touche pas n'importe comment !
Voici notre **Process Sacré** (que j'essaie de respecter...) :

1.  **Une tâche = Une branche** : On ne bosse jamais sur `main`. Jamais. Interdit.
    - On crée une branche locale : `git checkout -b MA2-XX-maSuperFeature`.
    - `MA2-XX` c'est l'ID du ticket Jira. Comme ça, on s'y retrouve.

2.  **Les Commits** : On utilise des **Gitmojis** (des émojis dans les commits) parce que c'est plus fun et plus lisible.
    - `:sparkles:` (`:sparkles:`) pour une nouveauté.
    - `:bug:` (`:bug:`) pour... bah un bug corrigé.
    - `:art:` (`:art:`) quand on fait du CSS.

3.  **La Pull Request (PR)** : Une fois fini, on pousse sur GitHub et on crée une "Pull Request". C'est le moment de vérité où on vérifie si on n'a rien cassé avant de fusionner dans `main`.

---

## 💻 Installation (C'est parti !)

Si tu veux lancer le projet chez toi : 

1.  **Clone le repo** :
    ```bash
    git clone https://github.com/Angelina2504/C_Coworker.git
    ```
2.  **Base de données** :
    - Importe le fichier `app/sql/database.sql` dans ton phpMyAdmin.
    - (Optionnel) Ajoute des fausses données avec `app/sql/insert_test_users.sql` et `app/sql/seed_extra_data.sql`.
3.  **Config** :
    - Vérifie `app/config/db.php` pour mettre tes identifiants (root / root ou vide souvent).
4.  **Lance ton serveur** (WAMP, XAMPP, ou juste PHP) :
    ```bash
    cd C_Coworker
    php -S localhost:8000
    ```
5.  **Enjoy !** 👉 `http://localhost:8000/app/index.php`


