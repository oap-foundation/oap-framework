# Open Agent Protocol (OAP) Framework

<p align="center">
  Read this in other languages: 
  <a href="./docs/translations/README.de.md">Deutsch</a> | 
  <a href="./docs/translations/README.es.md">Español</a> | 
  <a href="./docs/translations/README.fr.md">Français</a> | 
  <a href="./docs/translations/README.it.md">Italiano</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Specification-v1.0--RC-blue.svg" alt="Specification v1.0-RC">
  <img src="https://img.shields.io/badge/Status-CODE%20FREEZE-snowflake.svg" alt="Status: Code Freeze">
  <img src="https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg" alt="License CC BY-SA 4.0">
</p>

**The Open Agent Protocol (OAP) is the decentralized infrastructure for a fair, secure, and sovereign AI-to-AI economy.**

> **⚠️ STATUS ALERT: CODE FREEZE**
>
> The framework has reached **Version 1.0 Release Candidate**. We are currently in **Code Freeze**. No new features will be added to the core specifications. We are inviting the community to perform security audits and verify interoperability.

---

### The Vision: A Third Path

The world stands at the threshold of an autonomous economy. Current developments force a choice between total surveillance ("The All-Seeing Guardian") or closed ecosystems ("The Golden Cage").

OAP offers a third path: **Digital Sovereignty**.
It is the "missing layer" of the internet that enables agents (AIs, robots, humans) to:
1.  **Prove Identity** without central authorities.
2.  **Transport Data** without censorship or surveillance.
3.  **Transact Value** and negotiate contracts safely.

---

### Architecture Overview

The OAP framework is organized into three distinct layers, separating trust, logistics, and business logic.

#### Layer 0: Trust & Identity
*The mathematical bedrock.*
*   **Protocol:** **OAEP** (Open Agent Exchange Protocol)
*   **Function:** Handshake, Mutual Authentication, Session Keys, Verifiable Credentials.
*   **Key Tech:** DIDs (`did:key`, `did:web`), Ed25519, X25519.

#### Layer 1: Transport & Logistics
*The shipping container.*
*   **Protocol:** **OATP** (Open Agent Transport Protocol)
*   **Function:** Asynchronous delivery, encryption, sharding, blind routing.
*   **Key Tech:** JWE Containers, Reed-Solomon Erasure Coding, Blind Relays.

#### Layer 2: Application & Semantics
*The language of business.*
*   **Protocols:** Domain-specific logic (Commerce, Social, Health, etc.).
*   **Function:** Negotiation, Settlement, Content Distribution.
*   **Key Tech:** JSON-LD, Schema.org, State Machines.

---

### The Protocol Suite (v1.0-RC)

All protocols are currently in **Release Candidate** status.

| Acronym | Name | Layer | Focus | Status |
| :--- | :--- | :--- | :--- | :--- |
| **OAEP** | **Exchange Protocol** | **L0** | Identity, Handshake, Trust | ❄️ Freeze |
| **OATP** | **Transport Protocol** | **L1** | Encryption, Sharding, Routing | ❄️ Freeze |
| **OAPP** | **Payment Protocol** | **L2** | Settlement, PSD2, Escrow | ❄️ Freeze |
| **OACP** | **Commerce Protocol** | **L2** | Intent-based Trade, Negotiation | ❄️ Freeze |
| **OADP** | **Data Protocol** | **L2** | Sovereign Data, ODRL Policies | ❄️ Freeze |
| **OAFP** | **Feed Protocol** | **L2** | Social Media, Curation | ❄️ Freeze |
| **OACoP** | **Collaboration Protocol** | **L2** | Scheduling, Tasks | ❄️ Freeze |
| **OAHP** | **Health Protocol** | **L2** | Patient Records, Break-Glass | ❄️ Freeze |
| **OAVP** | **Voting Protocol** | **L2** | Anonymous Elections, Mixnets | ❄️ Freeze |
| **OARP** | **Robotics Protocol** | **L2** | Physical Actuation, Safety | ❄️ Freeze |

---

### Reference Implementations

The OAP Foundation maintains the official reference implementations in **Rust** to ensure memory safety and performance.

*   **Core Logic:** [`oap-foundation/oap-core-rs`](https://github.com/oap-foundation/oap-core-rs)
    *   *Contains the cryptographic primitives for Layer 0 and Layer 1.*
*   **Layer 2 Logic:** [`oap-foundation/layer2-core-rs`](https://github.com/oap-foundation/layer2-core-rs)
    *   *State machines and validation logic for application protocols.*

Bindings for **Python**, **JavaScript/WASM**, and **Dart** are available in the respective repositories.

---

### 📄 License & Legal

To protect the open nature of this standard, we employ a strict licensing model.

#### Specification License (Copyleft)
The specification text, architecture definitions, and protocol logic contained in this repository are licensed under the **Creative Commons Attribution-ShareAlike 4.0 International License (CC BY-SA 4.0)**.

[![License: CC BY-SA 4.0](https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-sa/4.0/)

**Intent of this License:**
The goal of using CC BY-SA 4.0 is to permanently protect the open nature of this standard.
*   **ShareAlike:** If you modify, extend, or build upon this specification (e.g., creating a "Layer 2.5"), you **must** distribute your contributions under the same **CC BY-SA 4.0** license.
*   **No Proprietary Forks:** It is legally prohibited to create a proprietary, closed-source version or extension of this specification text. All derivatives must remain free and open to the community.

#### Note on Implementation
To facilitate broad adoption, the use of the concepts, data structures (JSON-LD), and logic defined in this specification to create **software implementations** (libraries, applications, agents) is permitted without triggering the ShareAlike clause for the software itself. The reference code is licensed under **MIT**.

However, any changes to the **specification document itself** remain subject to the ShareAlike requirement.

---
**Maintained by the OAP Foundation**
*Design the future as a resource.*