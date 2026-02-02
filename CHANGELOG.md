# 📜 Journal des Modifications (Changelog)

Salut ! Ici on note tout ce qui change dans le projet. C'est un peu le journal de bord du capitaine.

---

## [Unreleased] - En cours de dev 🚧
### ✨ Nouveautés
- **MA2-27 Planning Hebdo** : On peut enfin voir la semaine complète d'un coup d'œil ! 📅 Ajout d'une vue grille avec navigation entre les semaines.
- **MA2-18 Dashboard Admin** : La tour de contrôle est là ! 🏰 Statistiques en temps réel (nombre de users, d'espaces, réservations actives). C'est beau, c'est propre.

### 🐛 Corrections
- **Timezone Fix** : PHP croyait qu'on était à Londres... J'ai forcé `Europe/Paris` pour qu'il arrête de marquer les réservations de 15h comme "À venir" quand il est 15h30. 🕰️
- **Durée des réservations** : Correction du calcul qui oubliait les jours ("4h" au lieu de "2j 4h"). Oups.

---

## [Sprint 3] - 2026-02-01
### ✨ Nouveautés
- **MA2-13/14/15 Gestion des Réservations** : On peut réserver, modifier et annuler !
- **Gestion des Conflits** : Impossible de réserver une salle si elle est déjà prise. J'ai sué sur la requête SQL, mais ça marche ! 🛡️

### 🐛 Corrections
- **Login Admin** : Il y avait un souci de hachage de mot de passe. J'ai tout régénéré proprement. Plus d'excuses pour ne pas se connecter.

---

## [Sprint 2] - Janvier 2026
### ✨ Nouveautés
- **Gestion des Espaces (CRUD)** : Créer, Lire, Mettre à jour, Supprimer des bureaux et salles de réunion. La base quoi.
- **Auth System** : Login/Logout fonctionnel avec sessions PHP.

---

## [Sprint 1] - Décembre 2025
### 🚀 Lancement
- Initialisation du repo.
- Structure MVC mise en place (dossiers app, models, views, controllers...).
- Base de données dessinée (MCD/MLD) et intégrée.

---

*Ce fichier est maintenu par Geoffroy. Dernière mise à jour le 2 Février 2026.*
