# Open Agent Protocol (OAP) Framework

<p align="center">
  Leggi questo in altre lingue: 
  <a href="./README.de.md">Deutsch</a> | 
  <a href="../../README.md">English</a> | 
  <a href="./README.es.md">Español</a> | 
  <a href="./README.fr.md">Français</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Specification-v1.0--RC-blue.svg" alt="Specifiche v1.0-RC">
  <img src="https://img.shields.io/badge/Status-CODE%20FREEZE-snowflake.svg" alt="Stato: Code Freeze">
  <img src="https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg" alt="Licenza CC BY-SA 4.0">
</p>

**L'Open Agent Protocol (OAP) è l'infrastruttura decentralizzata per un'economia AI-to-AI equa, sicura e sovrana.**

> **⚠️ AVVISO DI STATO: CODE FREEZE**
>
> Il framework ha raggiunto la versione **1.0 Release Candidate**. Attualmente siamo in **Code Freeze** (Congelamento del Codice). Nessuna nuova funzionalità verrà aggiunta alle specifiche principali. Invitiamo la comunità a eseguire audit di sicurezza e a verificare l'interoperabilità.

---

### La Visione: Una Terza Via

Il mondo si trova sulla soglia di un'economia autonoma. Gli sviluppi attuali costringono a scegliere tra una sorveglianza totale ("Il Custode Onniveggente") o ecosistemi chiusi ("La Gabbia Dorata").

OAP offre una terza via: la **Sovranità Digitale**.
È il "livello mancante" di Internet che consente agli agenti (AI, robot, umani) di:
1.  **Provare l'Identità** senza autorità centrali.
2.  **Trasportare Dati** senza censura o sorveglianza.
3.  **Transare Valore** e negoziare contratti in sicurezza.

---

### Panoramica dell'Architettura

Il framework OAP è organizzato in tre livelli distinti, separando fiducia, logistica e logica di business.

#### Livello 0: Fiducia e Identità
*Il fondamento matematico.*
*   **Protocollo:** **OAEP** (Open Agent Exchange Protocol)
*   **Funzione:** Handshake, Autenticazione Reciproca, Chiavi di Sessione, Credenziali Verificabili.
*   **Tecnologie Chiave:** DID (`did:key`, `did:web`), Ed25519, X25519.

#### Livello 1: Trasporto e Logistica
*Il container di spedizione.*
*   **Protocollo:** **OATP** (Open Agent Transport Protocol)
*   **Funzione:** Consegna asincrona, crittografia, sharding, routing cieco.
*   **Tecnologie Chiave:** Container JWE, Codifica di Cancellazione Reed-Solomon, Relay Ciechi.

#### Livello 2: Applicazione e Semantica
*Il linguaggio del business.*
*   **Protocolli:** Logica specifica del dominio (Commercio, Sociale, Salute, ecc.).
*   **Funzione:** Negoziazione, Regolamento (Settlement), Distribuzione dei Contenuti.
*   **Tecnologie Chiave:** JSON-LD, Schema.org, Macchine a Stati.

---

### La Suite di Protocolli (v1.0-RC)

Tutti i protocolli sono attualmente in stato **Release Candidate**.

| Acronimo | Nome | Livello | Focus | Stato |
| :--- | :--- | :--- | :--- | :--- |
| **OAEP** | **Protocollo di Scambio** | **L0** | Identità, Handshake, Fiducia | ❄️ Freeze |
| **OATP** | **Protocollo di Trasporto** | **L1** | Crittografia, Sharding, Routing | ❄️ Freeze |
| **OAPP** | **Protocollo di Pagamento** | **L2** | Regolamento, PSD2, Escrow | ❄️ Freeze |
| **OACP** | **Protocollo di Commercio** | **L2** | Commercio basato su intenti, Negoziazione | ❄️ Freeze |
| **OADP** | **Protocollo Dati** | **L2** | Dati Sovrani, Policy ODRL | ❄️ Freeze |
| **OAFP** | **Protocollo Feed** | **L2** | Social Media, Curatela | ❄️ Freeze |
| **OACoP** | **Protocollo di Collaborazione** | **L2** | Pianificazione, Task | ❄️ Freeze |
| **OAHP** | **Protocollo Salute** | **L2** | Cartelle Cliniche, Break-Glass | ❄️ Freeze |
| **OAVP** | **Protocollo di Voto** | **L2** | Elezioni Anonime, Mixnet | ❄️ Freeze |
| **OARP** | **Protocollo di Robotica** | **L2** | Attuazione Fisica, Sicurezza | ❄️ Freeze |

---

### Implementazioni di Riferimento

La OAP Foundation mantiene le implementazioni ufficiali di riferimento in **Rust** per garantire sicurezza della memoria e prestazioni.

*   **Logica Core:** [`oap-foundation/oap-core-rs`](https://github.com/oap-foundation/oap-core-rs)
    *   *Contiene le primitive crittografiche per il Livello 0 e il Livello 1.*
*   **Logica Livello 2:** [`oap-foundation/layer2-core-rs`](https://github.com/oap-foundation/layer2-core-rs)
    *   *Macchine a stati e logica di validazione per i protocolli applicativi.*

I binding per **Python**, **JavaScript/WASM** e **Dart** sono disponibili nei rispettivi repository.

---

### 📄 Licenza e Aspetti Legali

Per proteggere la natura aperta di questo standard, adottiamo un modello di licenza rigoroso.

#### Licenza delle Specifiche (Copyleft)
Il testo delle specifiche, le definizioni dell'architettura e la logica del protocollo contenuti in questo repository sono concessi in licenza sotto la **Creative Commons Attribution-ShareAlike 4.0 International License (CC BY-SA 4.0)**.

[![Licenza: CC BY-SA 4.0](https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-sa/4.0/)

**Intento di questa Licenza:**
L'obiettivo dell'utilizzo della CC BY-SA 4.0 è proteggere permanentemente la natura aperta di questo standard.
*   **ShareAlike (Condividi allo stesso modo):** Se modifichi, estendi o costruisci su questa specifica (ad es. creando un "Livello 2.5"), **devi** distribuire i tuoi contributi sotto la stessa licenza **CC BY-SA 4.0**.
*   **Nessun Fork Proprietario:** È legalmente proibito creare una versione proprietaria o chiusa, o un'estensione del testo di questa specifica. Tutti i derivati devono rimanere liberi e aperti alla comunità.

#### Nota sull'Implementazione
Per facilitare un'ampia adozione, l'uso dei concetti, delle strutture dati (JSON-LD) e della logica definita in questa specifica per creare **implementazioni software** (librerie, applicazioni, agenti) è consentito senza attivare la clausola ShareAlike per il software stesso. Il codice di riferimento è concesso in licenza **MIT**.

Tuttavia, qualsiasi modifica al **documento di specifica stesso** rimane soggetta al requisito ShareAlike.

---
**Mantenuto dalla OAP Foundation**
*Design the future as a resource.*