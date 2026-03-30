# 🧠 Claude.md — demo-php-laravel

## 🎯 Contexte du projet

App Laravel 12 de classement de course à pied **RunRank**.
L'utilisateur saisit une distance (5k, 10k, 21k, 42k) et un temps, l'app calcule l'allure et attribue un rang (Iron → Challenger).
App stateless — pas de base de données pour les résultats, pas d'authentification.

Déployée sur **Clever Cloud** (runtime PHP).

---

## ☁️ Déploiement Clever Cloud

- **Type d'app** : PHP
- **URL** : https://app-8ebea654-f2d5-4569-8e35-f1c9f520635e.cleverapps.io/
- **Webroot** : `/public` → configuré dans `clevercloud/php.json`
- **Variables d'environnement** : gérées via `.env` commité (pas de config manuelle sur la console)

### Fichiers Clever Cloud
```
clevercloud/php.json   → webroot: /public
.env                   → APP_KEY, APP_ENV=production, SESSION_DRIVER=file
```

---

## 🛠️ Stack

| Élément | Valeur |
|---|---|
| PHP | 8.2+ |
| Laravel | 12.x |
| Base de données | SQLite (migrations Laravel par défaut uniquement) |
| Session / Cache | Fichier (`file`) |
| Frontend | Vite 7 + Tailwind CSS 4 |
| Node.js | Requis pour le build frontend |

---

## 📁 Structure clé

```
app/Http/Controllers/RunController.php   → logique principale (calcul rang + allure)
routes/web.php                           → 2 routes : GET / et POST /result
resources/views/                         → vues Blade
clevercloud/php.json                     → config déploiement Clever Cloud
.env                                     → variables d'environnement (commité)
```

---

## ⚙️ Commandes utiles

```bash
# Installer les dépendances PHP
composer install

# Installer et builder le frontend
npm install && npm run build

# Lancer en local
php artisan serve

# Générer une nouvelle APP_KEY si besoin
php artisan key:generate --show
```

---

## 🚀 Déployer une modification

```bash
# Si modification du frontend : rebuilder d'abord
npm run build

# Commiter et pusher
git add .
git commit -m "description"
git push
```

Clever Cloud redéploie automatiquement après chaque push.

---

## ⚠️ Points de vigilance

- Le `.env` est commité volontairement (démo) — ne pas y mettre de vraies credentials
- `SESSION_DRIVER=file` et `CACHE_STORE=file` : pas besoin de base de données pour les sessions
- Le `--force` dans le script `composer setup` bypass la confirmation de migration en prod
- La distance "21k" utilise 21.1 km dans le calcul (demi-marathon réel)

---

## 🔍 Diagnostic rapide

| Symptôme | Cause probable | Correction |
|---|---|---|
| 403 Forbidden | Webroot mal configuré | Vérifier `clevercloud/php.json` |
| 500 | APP_KEY manquant ou SESSION_DRIVER=database sans migration | Vérifier `.env` |
| Page blanche | Build frontend manquant | `npm run build` + push |
| Erreur de session | SQLite absent ou migration non jouée | Passer SESSION_DRIVER=file |
