# Open Agent Protocol (OAP) Framework

<p align="center">
  Lies dies in anderen Sprachen: 
  <a href="../../README.md">English</a> | 
  <a href="./README.es.md">Español</a> | 
  <a href="./README.fr.md">Français</a> | 
  <a href="./README.it.md">Italiano</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Specification-v1.0--RC-blue.svg" alt="Spezifikation v1.0-RC">
  <img src="https://img.shields.io/badge/Status-CODE%20FREEZE-snowflake.svg" alt="Status: Code Freeze">
  <img src="https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg" alt="Lizenz CC BY-SA 4.0">
</p>

**Das Open Agent Protocol (OAP) ist die dezentrale Infrastruktur für eine faire, sichere und souveräne KI-zu-KI-Ökonomie.**

> **⚠️ STATUS-WARNUNG: CODE FREEZE**
>
> Das Framework hat den **Version 1.0 Release Candidate** erreicht. Wir befinden uns derzeit im **Code Freeze**. Es werden keine neuen Funktionen zu den Kernspezifikationen hinzugefügt. Wir laden die Community ein, Sicherheitsaudits durchzuführen und die Interoperabilität zu verifizieren.

---

### Die Vision: Ein dritter Weg

Die Welt steht an der Schwelle zu einer autonomen Wirtschaft. Die aktuellen Entwicklungen erzwingen eine Wahl zwischen totaler Überwachung ("Der allsehende Wächter") oder geschlossenen Ökosystemen ("Der goldene Käfig").

OAP bietet einen dritten Weg: **Digitale Souveränität**.
Es ist die "fehlende Schicht" des Internets, die es Agenten (KIs, Robotern, Menschen) ermöglicht:
1.  **Identität zu beweisen** ohne zentrale Autoritäten.
2.  **Daten zu transportieren** ohne Zensur oder Überwachung.
3.  **Werte zu übertragen** und Verträge sicher auszuhandeln.

---

### Architektur-Überblick

Das OAP-Framework ist in drei verschiedene Schichten unterteilt, die Vertrauen, Logistik und Geschäftslogik voneinander trennen.

#### Layer 0: Vertrauen & Identität
*Das mathematische Fundament.*
*   **Protokoll:** **OAEP** (Open Agent Exchange Protocol)
*   **Funktion:** Handshake, gegenseitige Authentifizierung, Sitzungsschlüssel, verifizierbare Nachweise (Verifiable Credentials).
*   **Schlüsseltechnologie:** DIDs (`did:key`, `did:web`), Ed25519, X25519.

#### Layer 1: Transport & Logistik
*Der Versandcontainer.*
*   **Protokoll:** **OATP** (Open Agent Transport Protocol)
*   **Funktion:** Asynchrone Zustellung, Verschlüsselung, Sharding, Blind-Routing.
*   **Schlüsseltechnologie:** JWE-Container, Reed-Solomon Erasure Coding, Blind Relays.

#### Layer 2: Anwendung & Semantik
*Die Sprache des Geschäfts.*
*   **Protokolle:** Domänenspezifische Logik (Handel, Soziales, Gesundheit, etc.).
*   **Funktion:** Verhandlung, Abwicklung, Inhaltsverteilung.
*   **Schlüsseltechnologie:** JSON-LD, Schema.org, Zustandsautomaten.

---

### Die Protokoll-Suite (v1.0-RC)

Alle Protokolle befinden sich derzeit im Status **Release Candidate**.

| Akronym | Name | Schicht | Fokus | Status |
| :--- | :--- | :--- | :--- | :--- |
| **OAEP** | **Austausch-Protokoll** | **L0** | Identität, Handshake, Vertrauen | ❄️ Freeze |
| **OATP** | **Transport-Protokoll** | **L1** | Verschlüsselung, Sharding, Routing | ❄️ Freeze |
| **OAPP** | **Zahlungs-Protokoll** | **L2** | Abwicklung, PSD2, Treuhand (Escrow) | ❄️ Freeze |
| **OACP** | **Handels-Protokoll** | **L2** | Absichtsbasierter Handel, Verhandlung | ❄️ Freeze |
| **OADP** | **Daten-Protokoll** | **L2** | Souveräne Daten, ODRL-Richtlinien | ❄️ Freeze |
| **OAFP** | **Feed-Protokoll** | **L2** | Soziale Medien, Kuration | ❄️ Freeze |
| **OACoP** | **Kollaborations-Protokoll** | **L2** | Zeitplanung, Aufgaben | ❄️ Freeze |
| **OAHP** | **Gesundheits-Protokoll** | **L2** | Patientenakten, Notfallzugriff (Break-Glass) | ❄️ Freeze |
| **OAVP** | **Wahl-Protokoll** | **L2** | Anonyme Wahlen, Mixnets | ❄️ Freeze |
| **OARP** | **Robotik-Protokoll** | **L2** | Physische Betätigung, Sicherheit | ❄️ Freeze |

---

### Referenzimplementierungen

Die OAP Foundation pflegt die offiziellen Referenzimplementierungen in **Rust**, um Speichersicherheit und Leistung zu gewährleisten.

*   **Kernlogik:** [`oap-foundation/Reference-Implementations/oap-core-rs`](https://github.com/oap-foundation/Reference-Implementations/oap-core-rs)
    *   *Enthält die kryptographischen Primitive für Layer 0 und Layer 1.*
*   **Layer 2 Logik:** [`oap-foundation/Reference-Implementations/layer2-core-rs`](https://github.com/oap-foundation/Reference-Implementations/layer2-core-rs)
    *   *Zustandsautomaten und Validierungslogik für Anwendungsprotokolle.*

Bindings für **Python**, **JavaScript/WASM** und **Dart** sind in den entsprechenden Repositories verfügbar.

---

### 📄 Lizenz & Rechtliches

Um den offenen Charakter dieses Standards zu schützen, verwenden wir ein strenges Lizenzmodell.

#### Spezifikationslizenz (Copyleft)
Der Spezifikationstext, die Architekturdefinitionen und die Protokollogik in diesem Repository stehen unter der **Creative Commons Attribution-ShareAlike 4.0 International License (CC BY-SA 4.0)** (Namensnennung - Weitergabe unter gleichen Bedingungen).

[![Lizenz: CC BY-SA 4.0](https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-sa/4.0/deed.de)

**Absicht dieser Lizenz:**
Das Ziel der Verwendung von CC BY-SA 4.0 ist es, den offenen Charakter dieses Standards dauerhaft zu schützen.
*   **ShareAlike (Weitergabe unter gleichen Bedingungen):** Wenn Sie diese Spezifikation modifizieren, erweitern oder darauf aufbauen (z. B. durch Erstellen eines "Layer 2.5"), **müssen** Sie Ihre Beiträge unter derselben **CC BY-SA 4.0** Lizenz veröffentlichen.
*   **Keine proprietären Forks:** Es ist rechtlich untersagt, eine proprietäre, geschlossene Version oder Erweiterung dieses Spezifikationstextes zu erstellen. Alle Ableitungen müssen frei und offen für die Gemeinschaft bleiben.

#### Hinweis zur Implementierung
Um eine breite Akzeptanz zu fördern, ist die Verwendung der Konzepte, Datenstrukturen (JSON-LD) und der in dieser Spezifikation definierten Logik zur Erstellung von **Software-Implementierungen** (Bibliotheken, Anwendungen, Agenten) gestattet, ohne dass die ShareAlike-Klausel für die Software selbst ausgelöst wird. Der Referenzcode steht unter der **MIT**-Lizenz.

Jegliche Änderungen am **Spezifikationsdokument selbst** unterliegen jedoch weiterhin der ShareAlike-Anforderung.

---
**Gepflegt von der OAP Foundation**
*Design the future as a resource.*
