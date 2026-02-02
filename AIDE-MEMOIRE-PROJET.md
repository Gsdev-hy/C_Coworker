# RÉSUMÉ DE PASSATION - PROJET C'COWORKER

Ce document est destiné à une IA assistant pour reprendre le projet C'Coworker sans accès direct au système de fichiers.

## 1. Contexte du Projet
- **Nom** : C'Coworker
- **Objectif** : Application de gestion de réservation d'espaces de coworking (Bureaux, Salles de réunion).
- **Contexte** : Formation CDA 2025-2026.
- **Équipe** : GeoffroySTREIT (Lead), Guylène, Angelina.
- **Stack Technique** : PHP 8, MySQL, Bootstrap 5, Architecture MVC simplifiée.

## 2. État Actuel de l'Implémentation (Sprint 3 terminé)
- **Base de données** : Tables `users`, `spaces`, `reservations` créées.
- **Spaces (CRUD terminé)** : Gestion complète des espaces (Sprint 2).
- **Authentification (Terminé)** : Système de login/logout, rôles Admin/User, sessions sécurisées via `AuthHelper`.
- **Réservations (CRUD terminé)** : 
    - Liste des réservations avec statuts (À venir, En cours, Terminée).
    - Création, Modification, Suppression.
    - **Logiciel** : Prévention des conflits de créneaux horaires (Overlap detection).
- **Routeur** : `app/index.php` gère toutes les routes dynamiques.
- **Sécurité** : Middleware `AuthHelper` protégeant les actions sensibles.

## 3. Conception Réalisée
- **UML & MERISE** : Tous les diagrammes techniques sont prêts et validés.
- **Agile** : Backlog à jour, sprints 1 à 3 validés.

## 4. Prochaines Étapes (Sprint 4)
1. **Dashboard** : Vue d'ensemble statistique pour les administrateurs.
2. **Planning** : Vue visuelle hebdomadaire des réservations.
3. **Gestion Utilisateurs** : CRUD complet des comptes (Admin only).
4. **Profil** : Consultation des réservations personnelles par l'utilisateur.

## 5. Structure de la Base de Données (MPD)
- `users` : id, firstname, lastname, email, password, role ('admin'|'user').
- `spaces` : id, name, capacity, type ('bureau'|'reunion'|'open-space'), equipment.
- `reservations` : id, user_id, space_id, start_time, end_time.

## 6. Guide pour continuer
> Cher collègue IA, le Sprint 3 est validé. Pour continuer, attaque le **Sprint 4** en commençant par le **Dashboard (MA2-18)**. Il s'agit de créer une vue synthétique affichant le nombre total d'espaces, de réservations actives et d'utilisateurs.
