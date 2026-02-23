# EasyColoc – Plateforme Web de Gestion de Colocation

![Laravel](https://img.shields.io/badge/Laravel-8.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)
![Tailwind](https://img.shields.io/badge/TailwindCSS-3.x-blue?logo=tailwindcss)

**EasyColoc** est une application web de gestion de colocation permettant de suivre les dépenses communes, calculer automatiquement les soldes et gérer la répartition des dettes entre membres.

---

## 🔹 Fonctionnalités principales

### 👥 Utilisateurs
- Inscription, connexion et gestion du profil
- Premier utilisateur devient automatiquement **admin global**
- Blocage des utilisateurs bannis

### 🏠 Colocations
- Création, modification, affichage et annulation
- Invitation par email via token (acceptation/refus)
- Une seule colocation active par utilisateur
- Départ d’un membre et retrait par l’owner

### 💸 Dépenses
- Ajout d’une dépense (titre, montant, date, catégorie, payeur)
- Filtre par mois et statistiques par catégorie
- Historique complet des dépenses

### 📊 Balances & Dettes
- Calcul automatique du total payé par chaque membre
- Calcul de la part individuelle et des soldes
- Vue synthétique « qui doit à qui »
- Paiement simple via bouton « Marquer payé »

### ⭐ Réputation
- Départ ou annulation avec dette : -1
- Départ ou annulation sans dette : +1
- Dette d’un membre retiré par l’owner est imputée à l’owner

### 🛠 Admin global
- Accès aux statistiques globales
- Bannissement/débannissement des utilisateurs

---

## 🔹 Technologies utilisées

- **PHP 8.3** & **Laravel 12**
- **Blade Templates** + **Tailwind CSS**
- **MySQL / PostgreSQL**
- **Laravel Breeze** (authentification)
- **Eloquent ORM** (hasMany / belongsToMany)
- JavaScript natif pour certaines interactions

---

## 🔹 Installation

1. Cloner le projet :  
```bash
git clone <votre-repo-url>
cd easycoloc