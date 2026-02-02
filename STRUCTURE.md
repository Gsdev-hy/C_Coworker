# 🏗️ L'Architecture du Code 

J'ai utilisé une structure **MVC (Modèle - Vue - Contrôleur)**. 

---

## 📂 L'Arborescence 

```text
C_Coworker/
├── app/                  # Le cœur du réacteur ⚛️
│   ├── config/           # Les réglages (connexion BDD...)
│   ├── controllers/      # Les chefs d'orchestre (PHP)
│   ├── helpers/          # Les petits outils pratiques (Auth...)
│   ├── models/           # Les gardiens des données (SQL)
│   ├── sql/              # Les scripts pour créer la BDD
│   ├── views/            # Ce que tu vois à l'écran (HTML/CSS)
│   └── index.php         # La porte d'entrée unique ! 🚪
├── guides/               # Ma doc (Process, idées...)
└── README.md             # Tu es ici !
```

---

## 🧩 Le Concept MVC 

Imagine que tu es au restaurant :

1.  **Le Client (Toi)** : Tu cliques sur un lien (ex: "Voir les espaces").
2.  **Le Routeur (`index.php`)** : C'est le maître d'hôtel. Il reçoit ta demande et appelle le bon serveur.
3.  **Le Contrôleur (`controllers/`)** : C'est le serveur 🤵. Il prend ta commande.
    - Il demande au **Modèle** : "Eh, donne-moi la liste des espaces stp !".
    - Il reçoit les infos (le plat).
    - Il les envoie à la **Vue** pour la présentation.
4.  **Le Modèle (`models/`)** : C'est le cuisinier 👨‍🍳. Il fouille dans le frigo (la Base de Données) pour trouver les ingrédients (les données). Il ne fait que du SQL.
5.  **La Vue (`views/`)** : C'est l'assiette 🍽️. C'est juste du HTML/CSS pour présenter joliment les données au client.

---

## 🔍 Zoom sur les fichiers importants

### `app/index.php` (Le Routeur)
C'est le chef suprême. Tout passe par lui.
Il regarde l'URL `?page=truc` et décide quel contrôleur appeler.
*Exemple : Si `page=dashboard`, il appelle `DashboardController`.

### `app/helpers/AuthHelper.php` (La Sécurité)
C'est le videur de la boîte de nuit. 🦍
Il vérifie si tu es connecté (`isLoggedIn()`) et si tu es admin (`isAdmin()`). Si t'es pas invité, tu rentres pas !

### `app/models/Reservation.php` (Le Cerveau SQL)
C'est là que je gère toute la logique compliquée, comme `isAvailable()` pour vérifier si une salle est libre. C'est du SQL pur et dur.

---

## 🎨 Côté Front (Le style)
J'utilise **Bootstrap 5** (via CDN dans `header.php`). C'est une bibliothèque CSS qui permet d'avoir des boutons jolis et une mise en page qui s'adapte aux mobiles (Responsive) sans écrire 1000 lignes de CSS.
- Les icônes viennent de **Bootstrap Icons** (`<i class="bi bi-star"></i>`).

