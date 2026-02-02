Consigne de projet – Sprint Agile pour C’Coworker
1. Informations générales
Durée du Sprint : 1 à 1,5 jour

Date de début : Mardi

Présentation du produit : Lundi 2 février, fin d’après-midi

2. Contexte et objectif du projet
C’Coworker propose des espaces de coworking et des salles de réunion à louer.
L’objectif est de développer un site web pour le personnel administratif permettant de gérer facilement les espaces et les réservations.

Le site doit être :

Simple, clair et interactif

Équipé de formulaires et de règles logiques pour éviter les erreurs

Extension optionnelle :

Accès sécurisé via un compte pour le personnel administratif

Réservation en libre-service pour les utilisateurs externes (une fois la partie administrative fonctionnelle)

3. Public cible
Phase principale – Personnel administratif :
Créer, modifier et supprimer des espaces et des réservations

Consulter le planning et vérifier l’absence de doublons

Phase optionnelle – Utilisateurs externes :
Réserver un espace ou une salle directement

4. Pages et fonctionnalités simplifiées
4.1 Gestion des espaces
Liste des espaces : affichage des bureaux et salles avec capacité et type (open-space / bureau / salle de réunion)

Ajouter un espace

Modifier ou supprimer un espace

4.2 Gestion des réservations
Créer une réservation : choix de l’espace, date, heure de début et de fin, nom de l’utilisateur

Modifier ou supprimer une réservation

Vérification automatique des conflits

4.3 Planning et tableau de bord
Planning hebdomadaire : visualisation des espaces et réservations par jour et heure

Tableau de bord : aperçu des espaces libres/occupés et des prochaines réservations

4.4 Gestion des utilisateurs
Liste des utilisateurs

Ajouter un utilisateur

Modifier ou supprimer un utilisateur

5. Logique du site
Un espace ne peut pas être réservé deux fois au même moment.

6. Interface et ergonomie
Menus simples pour naviguer entre les pages

Codes couleur pour l’état des espaces (libre/occupé)

Tableaux et formulaires faciles à lire et à remplir

Messages clairs pour confirmer ou signaler une erreur

Fonctionne sur ordinateur et tablette (si le temps le permet)

7. Technique
Front-end : HTML, CSS, JavaScript

Back-end : PHP

Base de données : MySQL

Vérification des informations côté client et côté serveur

8. Livrables attendus
Code source complet et fonctionnel

Base de données prête à l’emploi

Documentation simple pour installation et usage (adaptée au temps réduit)

Site fonctionnel avec toutes les fonctionnalités principales

9. Critères de réussite
Fonctionnalités administratives entièrement opérationnelles

Pas de conflits dans les réservations

Interface claire et simple à utiliser

Respect du cahier des charges

10. Organisation Agile du Sprint
Rôles dans l’équipe :
Rôle	Responsabilités
Développeurs	Développement des fonctionnalités, tests, refactoring, Pull Requests
Lead Developer	Organisation des Code Reviews, validation technique des PR, support technique
Product Owner (PO)	Validation fonctionnelle, priorisation des tickets, vérification du respect des besoins métiers
Scrum Master	Facilitation des Dailies, suivi du Kanban, suivi du Burndown Chart, levée des blocages
Notions Agile à appliquer :
Peer Programming : développement en binôme pour partager les connaissances et améliorer la qualité du code.

TDD (Test Driven Development) : écrire les tests avant le code pour chaque fonctionnalité.

KISS (Keep It Simple and Stupid) : privilégier des solutions simples et lisibles.

Refactoring : à la fin de chaque demi-journée, améliorer le code, renommer variables/fonctions, clarifier la logique.

Daily Scrum : réunion quotidienne organisée par le Scrum Master.

Pull Request et Code Review : validation technique par le Lead Developer et l’équipe.

Validation fonctionnelle : chaque ticket validé par le Product Owner.

Kanban et Burndown Chart : suivi continu de l’avancement et mise à jour après validation des tickets (Scrum Master).