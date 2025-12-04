# Framework Open Agent Protocol (OAP)

<p align="center">
  Lisez ceci dans d'autres langues : 
  <a href="./README.de.md">Deutsch</a> | 
  <a href="../../README.md">English</a> | 
  <a href="./README.es.md">Español</a> | 
  <a href="./README.it.md">Italiano</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Specification-v1.0--RC-blue.svg" alt="Spécification v1.0-RC">
  <img src="https://img.shields.io/badge/Status-CODE%20FREEZE-snowflake.svg" alt="Statut : GEL DU CODE">
  <img src="https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg" alt="Licence CC BY-SA 4.0">
</p>

**L'Open Agent Protocol (OAP) est l'infrastructure décentralisée pour une économie entre Intelligences Artificielles (IA-à-IA) équitable, sécurisée et souveraine.**

> **⚠️ ALERTE DE STATUT : GEL DU CODE (CODE FREEZE)**
>
> Le framework a atteint la version **Release Candidate 1.0**. Nous sommes actuellement en **Gel du Code**. Aucune nouvelle fonctionnalité ne sera ajoutée aux spécifications principales. Nous invitons la communauté à réaliser des audits de sécurité et à vérifier l'interopérabilité.

---

### La Vision : Une Troisième Voie

Le monde est au seuil d'une économie autonome. Les développements actuels forcent à choisir entre une surveillance totale (« Le Gardien Omniscient ») ou des écosystèmes fermés (« La Cage Dorée »).

OAP offre une troisième voie : **La Souveraineté Numérique**.
C'est la « couche manquante » d'Internet qui permet aux agents (IA, robots, humains) de :
1.  **Prouver leur identité** sans autorité centrale.
2.  **Transporter des données** sans censure ni surveillance.
3.  **Transiger de la valeur** et négocier des contrats en toute sécurité.

---

### Aperçu de l'Architecture

Le framework OAP est organisé en trois couches distinctes, séparant la confiance, la logistique et la logique métier.

#### Couche 0 : Confiance & Identité (Trust & Identity)
*Le socle mathématique.*
*   **Protocole :** **OAEP** (Open Agent Exchange Protocol)
*   **Fonction :** Handshake (poignée de main), Authentification Mutuelle, Clés de Session, Identifiants Vérifiables (Verifiable Credentials).
*   **Tech Clé :** DIDs (`did:key`, `did:web`), Ed25519, X25519.

#### Couche 1 : Transport & Logistique
*Le conteneur d'expédition.*
*   **Protocole :** **OATP** (Open Agent Transport Protocol)
*   **Fonction :** Livraison asynchrone, chiffrement, fragmentation (sharding), routage aveugle.
*   **Tech Clé :** Conteneurs JWE, Codage à effacement Reed-Solomon, Relais aveugles (Blind Relays).

#### Couche 2 : Application & Sémantique
*Le langage des affaires.*
*   **Protocoles :** Logique spécifique au domaine (Commerce, Social, Santé, etc.).
*   **Fonction :** Négociation, Règlement, Distribution de contenu.
*   **Tech Clé :** JSON-LD, Schema.org, Machines à états.

---

### La Suite de Protocoles (v1.0-RC)

Tous les protocoles sont actuellement en statut **Release Candidate**.

| Acronyme | Nom | Couche | Focus | Statut |
| :--- | :--- | :--- | :--- | :--- |
| **OAEP** | **Exchange Protocol** | **L0** | Identité, Handshake, Confiance | ❄️ Figé |
| **OATP** | **Transport Protocol** | **L1** | Chiffrement, Sharding, Routage | ❄️ Figé |
| **OAPP** | **Payment Protocol** | **L2** | Règlement, PSD2, Tiers de confiance | ❄️ Figé |
| **OACP** | **Commerce Protocol** | **L2** | Commerce basé sur l'intention, Négociation | ❄️ Figé |
| **OADP** | **Data Protocol** | **L2** | Données Souveraines, Politiques ODRL | ❄️ Figé |
| **OAFP** | **Feed Protocol** | **L2** | Médias Sociaux, Curation | ❄️ Figé |
| **OACoP** | **Collaboration Protocol** | **L2** | Planification, Tâches | ❄️ Figé |
| **OAHP** | **Health Protocol** | **L2** | Dossiers Patients, Accès d'urgence (Bris de glace) | ❄️ Figé |
| **OAVP** | **Voting Protocol** | **L2** | Élections Anonymes, Mixnets | ❄️ Figé |
| **OARP** | **Robotics Protocol** | **L2** | Actionnement Physique, Sécurité | ❄️ Figé |

---

### Implémentations de Référence

La Fondation OAP maintient les implémentations de référence officielles en **Rust** pour garantir la sécurité de la mémoire et la performance.

*   **Logique Core (Noyau) :** [`oap-foundation/oap-core-rs`](https://github.com/oap-foundation/oap-core-rs)
    *   *Contient les primitives cryptographiques pour la Couche 0 et la Couche 1.*
*   **Logique Couche 2 :** [`oap-foundation/layer2-core-rs`](https://github.com/oap-foundation/layer2-core-rs)
    *   *Machines à états et logique de validation pour les protocoles applicatifs.*

Les bindings pour **Python**, **JavaScript/WASM**, et **Dart** sont disponibles dans les dépôts respectifs.

---

### 📄 Licence & Juridique

Pour protéger la nature ouverte de ce standard, nous employons un modèle de licence strict.

#### Licence de la Spécification (Copyleft)
Le texte de la spécification, les définitions d'architecture et la logique des protocoles contenus dans ce dépôt sont licenciés sous la **Licence Creative Commons Attribution - Partage dans les Mêmes Conditions 4.0 International (CC BY-SA 4.0)**.

[![Licence : CC BY-SA 4.0](https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-sa/4.0/)

**Intention de cette Licence :**
L'objectif de l'utilisation de la CC BY-SA 4.0 est de protéger de manière permanente la nature ouverte de ce standard.
*   **Partage dans les Mêmes Conditions (ShareAlike) :** Si vous modifiez, étendez ou construisez sur cette spécification (par exemple, en créant une "Couche 2.5"), vous **devez** distribuer vos contributions sous la même licence **CC BY-SA 4.0**.
*   **Pas de Forks Propriétaires :** Il est légalement interdit de créer une version ou une extension propriétaire et fermée (closed-source) de ce texte de spécification. Tous les dérivés doivent rester libres et ouverts à la communauté.

#### Note sur l'Implémentation
Pour faciliter une large adoption, l'utilisation des concepts, des structures de données (JSON-LD) et de la logique définis dans cette spécification pour créer des **implémentations logicielles** (bibliothèques, applications, agents) est autorisée sans déclencher la clause ShareAlike pour le logiciel lui-même. Le code de référence est sous licence **MIT**.

Cependant, tout changement apporté au **document de spécification lui-même** reste soumis à l'exigence ShareAlike.

---
**Maintenu par la Fondation OAP**
*Concevoir l'avenir comme une ressource.*