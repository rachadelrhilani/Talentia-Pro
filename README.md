 # Talentia — Plateforme de Recrutement Laravel

Talentia est une plateforme web développée avec Laravel permettant de connecter des recruteurs et des chercheurs d’emploi.

Le système permet la gestion des profils professionnels, la publication d’offres d’emploi, la recherche d’utilisateurs et l’interaction entre candidats via un système de réseau professionnel.

---

# Objectifs du Projet

- Utiliser Laravel et ses bonnes pratiques
- Mettre en place une authentification sécurisée
- Gérer les profils utilisateurs
- Implémenter un moteur de recherche simple
- Préparer une architecture évolutive

---

# Stack Technique

- Laravel
- Laravel Breeze / Jetstream
- Laravel Livewire
- Spatie Laravel Permission
- MySQL
- Blade + Tailwind CSS
- Eloquent ORM

---

# Types d’Utilisateurs

## Chercheur d’emploi (Candidat)
- Création d’un profil CV
- Recherche d’offres
- Postulation
- Ajout d’amis
- Gestion des compétences

## Recruteur (Entreprise)
- Création d’offres d’emploi
- Gestion des offres
- Consultation des candidatures
- Clôture d’offres

---

# Authentification & Sécurité

- Inscription / Connexion sécurisée
- Gestion des rôles avec Spatie
- Permissions strictes :
  - Seuls les recruteurs peuvent publier des offres
  - Seuls les candidats peuvent postuler

---

# Gestion des Profils

## Informations générales
- Nom
- Bio
- Photo
- Modification du mot de passe

## Profil Candidat (CV)
- Titre professionnel
- Formations
- Expériences
- Compétences

## Profil Recruteur
- Nom de l’entreprise
- Description
- Logo

---

# Recherche

- Recherche utilisateurs par :
  - Nom
  - Spécialité
- Consultation du profil public

---

# Fonctionnalités Candidat

- Gestion du profil CV
- Recherche d’offres d’emploi
- Consultation des offres
- Postulation
- Gestion des amis :
  - Envoyer une demande
  - Accepter / Refuser

---

# Fonctionnalités Recruteur

- Création d’offres
- Modification des offres
- Clôture des offres
- Consultation des candidatures

---

# Interactivité (Livewire)

- Lazy Loading des offres
- Actions dynamiques sans reload
- Interface fluide

---

# Architecture & Base de Données

Relations Eloquent utilisées :

- One To One :
  - User → Profile
  - User → Company

- One To Many :
  - Company → JobOffers
  - JobOffer → Applications

- Many To Many :
  - Profile ↔ Skills
  - Users ↔ Friendships

---

# Migrations principales

- users
- profiles
- companies
- job_offers
- applications
- skills
- profile_skill
- friendships
- education
- experiences

---

# Seeders & Factories

- Génération d’offres fictives
- Création d’utilisateurs test
- Simulation de candidatures
- Peuplement des compétences

---

# Installation du Projet

```bash
git clone https://github.com/rachadelrhilani/talentia.git
cd talentia
