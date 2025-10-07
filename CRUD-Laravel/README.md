# 🧠 TheBrains – Serveur Docker Multi-Projets Automatisé

## 🚀 Présentation

**TheBrains** est un outil d’automatisation et d’orchestration destiné à simplifier la **gestion de serveurs multi-projets Docker**.  
Il installe, configure et maintient un environnement complet avec :

- 🌍 Un **reverse proxy global (NGINX + ACME)** avec certificats SSL automatiques  
- ⚙️ Une **infrastructure modulaire** par projet avec ses propres fichiers et variables  
- 👥 Une **gestion des utilisateurs** et des accès Docker/SSH  
- 🔄 Des **commandes universelles** : création, suppression, mise à jour, logs, etc.

Ce projet est conçu pour offrir **stabilité**, **sécurité** et **simplicité**, tout en restant **hautement personnalisable**.

---

## 🧱 Architecture globale du dossier CI/CD

```
cicd/
│
├── setup/
│   ├── setup-thebrains.sh             # Script principal d’installation du serveur
│   └── thebrains/                     # Scripts de commande "thebrains"
│       ├── thebrains.sh               # Commande principale
│       ├── commands/                  # Sous-commandes disponibles
│       │   ├── create-project.sh
│       │   ├── delete-project.sh
│       │   ├── update-project.sh
│       │   ├── update-system.sh
│       │   ├── create-user.sh
│       │   ├── delete-user.sh
│       │   ├── open-port.sh
│       │   ├── block-port.sh
│       │   ├── logs.sh
│       │   └── ...
│       └── utils/
│           └── load-env.sh            # Chargement global des variables d’environnement
│
├── services/
│   └── proxy/                         # Reverse proxy global (NGINX + ACME)
│       ├── drive/data/nginx/
│       └── drive/configs/nginx/
│
└── projects/
    ├── demo/
    │   ├── drive/data/service1/
    │   ├── drive/configs/service1/
    │   └── environments/service1/
    └── ...
```

---

## ⚙️ Installation d’un nouveau serveur

### 1️⃣ Cloner le dépôt CI/CD

```bash
git clone https://gitlab.com/<organization>/cicd.git
cd cicd/setup
```

### 2️⃣ Configurer l’environnement

Copie du fichier `.env.example` :

```bash
cp .env.example .env
nano .env
```

Ce fichier contient toutes les variables globales (utilisateur, réseau, GitLab, proxy, etc.) :

```env
# === Configuration serveur ===
SERVER_HOST=thebrains-server
SERVER_USER=thebrains
SERVER_TIMEZONE=Africa/Douala

# === Proxy global ===
THEBRAINS_NETWORK=thebrains-network
PROXY_HTTP_PORT=80
PROXY_HTTPS_PORT=443
PROXY_DASHBOARD_PORT=8080

# === GitLab pour les mises à jour ===
GITLAB_URL=https://gitlab.com
GITLAB_USER=ci-runner
GITLAB_TOKEN=<YOUR_TOKEN>

# === Dossiers globaux ===
CICD_ROOT=/opt/thebrains
PROJECTS_DIR=${CICD_ROOT}/projects
SERVICES_DIR=${CICD_ROOT}/services
CONFIG_DIR=${CICD_ROOT}/drive/configs
DATA_DIR=${CICD_ROOT}/drive/data
```

> 💡 Ces variables sont copiées dans `/etc/thebrains/.env` pour être disponibles globalement à tous les scripts.

---

### 3️⃣ Lancer le script d’installation

```bash
sudo bash setup-thebrains.sh
```

Ce script :

- ⚙️ Installe **Docker, Git, Nginx, Acme.sh, UFW**  
- 👤 Crée l’utilisateur système `${SERVER_USER}` et le groupe Docker  
- 🌐 Met en place le **proxy global** (réseau Docker partagé : `${THEBRAINS_NETWORK}`)  
- 🧩 Déploie les **scripts TheBrains** dans `/usr/local/bin/thebrains`  
- 🧰 Initialise un projet de démonstration : `demo`

---

## 💻 Utilisation de la commande `thebrains`

Une fois installé, tu peux utiliser `thebrains` depuis n’importe où dans le terminal :

### 🔧 Commandes principales

| Commande | Description |
|-----------|-------------|
| `thebrains create project <nom>` | Crée un nouveau projet basé sur le modèle `docker-compose-example.yml` |
| `thebrains delete project <nom>` | Supprime un projet (avec sauvegarde ZIP avant suppression) |
| `thebrains update project <nom>` | Reconstruit et redémarre un projet existant |
| `thebrains logs <container>` | Affiche les 100 dernières lignes de logs du conteneur sélectionné |
| `thebrains update` | Met à jour les scripts globaux depuis le dépôt GitLab |
| `thebrains create user <username>` | Crée un nouvel utilisateur et lui donne les accès Docker/SSH |
| `thebrains delete user <username>` | Supprime un utilisateur du système |
| `thebrains open port <port>` | Ouvre un port dans le pare-feu |
| `thebrains block port <port>` | Bloque un port dans le pare-feu |

---

## 🌍 Structure type d’un projet

Chaque projet suit une structure standardisée :

```
projects/<project-name>/
│
├── docker-compose.yml
├── drive/
│   ├── data/         # Volumes de données (DB, stockage applicatif)
│   └── configs/      # Fichiers de config (nginx, supervisor, etc.)
└── environments/     # Fichiers .env spécifiques
```

---

## 📦 Exemple de docker-compose

```yaml
version: "3.8"

services:
  nginx:
    image: nginx:1.25-alpine
    container_name: ${PROJECT_NAME}-nginx
    restart: always
    expose:
      - "80"
    volumes:
      - ./drive/configs/nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
      - ./public:/usr/share/nginx/html:ro
    environment:
      - VIRTUAL_HOST=${PROJECT_DOMAIN}
      - LETSENCRYPT_HOST=${PROJECT_DOMAIN}
      - LETSENCRYPT_EMAIL=${ADMIN_EMAIL}
    networks:
      - ${THEBRAINS_NETWORK}

  app:
    build: .
    container_name: ${PROJECT_NAME}-app
    environment:
      - APP_ENV=production
      - APP_URL=https://${PROJECT_DOMAIN}
    networks:
      - ${THEBRAINS_NETWORK}

networks:
  ${THEBRAINS_NETWORK}:
    external: true
```

---

## 🧩 Création d’un projet manuellement

```bash
mkdir -p projects/myproject/{drive/configs,drive/data,environments}
cp cicd/setup/examples/docker-compose-example.yml projects/myproject/docker-compose.yml
cd projects/myproject
docker compose up -d
```

---

## 🔐 Sécurité et bonnes pratiques

- Ne jamais exécuter Docker directement en **root**
- Chaque projet doit être isolé dans son propre dossier  
- Le réseau Docker global (`${THEBRAINS_NETWORK}`) ne doit jamais être supprimé  
- Les certificats sont gérés automatiquement par **acme.sh**  
- Les ports ouverts doivent être strictement définis dans `.env`

---

## 🧰 Extensions prévues

| Commande future | Description |
|------------------|-------------|
| `thebrains backup project <nom>` | Sauvegarde compressée d’un projet |
| `thebrains restore project <archive>` | Restauration à partir d’une sauvegarde |
| `thebrains deploy gitlab-pipeline` | Déploiement automatisé depuis GitLab CI |
| `thebrains diagnostics` | Vérification complète du serveur et des conteneurs |

---

## 🧾 Licence

Ce projet est distribué sous licence **MIT**.  
Créé avec ❤️ par **TheBrains Group** — Plateforme africaine de technologies collaboratives.