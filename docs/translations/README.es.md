# Marco de Trabajo del Protocolo de Agente Abierto (OAP)

<p align="center">
  Lee esto en otros idiomas: 
  <a href="./README.de.md">Deutsch</a> | 
  <a href="../../README.md">English</a> | 
  <a href="./README.fr.md">Français</a> | 
  <a href="./README.it.md">Italiano</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Specification-v1.0--RC-blue.svg" alt="Especificación v1.0-RC">
  <img src="https://img.shields.io/badge/Status-CODE%20FREEZE-snowflake.svg" alt="Estado: Congelación de Código">
  <img src="https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg" alt="Licencia CC BY-SA 4.0">
</p>

**El Protocolo de Agente Abierto (OAP) es la infraestructura descentralizada para una economía de IA a IA justa, segura y soberana.**

> **⚠️ ALERTA DE ESTADO: CONGELACIÓN DE CÓDIGO**
>
> El marco de trabajo ha alcanzado la versión **1.0 Release Candidate (Candidato de Lanzamiento)**. Actualmente estamos en **Congelación de Código**. No se añadirán nuevas características a las especificaciones principales. Invitamos a la comunidad a realizar auditorías de seguridad y verificar la interoperabilidad.

---

### La Visión: Un Tercer Camino

El mundo se encuentra en el umbral de una economía autónoma. Los desarrollos actuales fuerzan una elección entre la vigilancia total ("El Guardián que todo lo ve") o ecosistemas cerrados ("La Jaula de Oro").

OAP ofrece un tercer camino: **Soberanía Digital**.
Es la "capa perdida" de internet que permite a los agentes (IAs, robots, humanos):
1.  **Probar Identidad** sin autoridades centrales.
2.  **Transportar Datos** sin censura ni vigilancia.
3.  **Transaccionar Valor** y negociar contratos de forma segura.

---

### Descripción General de la Arquitectura

El marco OAP está organizado en tres capas distintas, separando la confianza, la logística y la lógica de negocio.

#### Capa 0: Confianza e Identidad
*El cimiento matemático.*
*   **Protocolo:** **OAEP** (Open Agent Exchange Protocol - Protocolo de Intercambio de Agente Abierto)
*   **Función:** Handshake (saludo), Autenticación Mutua, Claves de Sesión, Credenciales Verificables.
*   **Tecnología Clave:** DIDs (`did:key`, `did:web`), Ed25519, X25519.

#### Capa 1: Transporte y Logística
*El contenedor de envío.*
*   **Protocolo:** **OATP** (Open Agent Transport Protocol - Protocolo de Transporte de Agente Abierto)
*   **Función:** Entrega asíncrona, encriptación, fragmentación (sharding), enrutamiento ciego.
*   **Tecnología Clave:** Contenedores JWE, Codificación de Borrado Reed-Solomon, Relés Ciegos.

#### Capa 2: Aplicación y Semántica
*El lenguaje de los negocios.*
*   **Protocolos:** Lógica específica del dominio (Comercio, Social, Salud, etc.).
*   **Función:** Negociación, Liquidación, Distribución de Contenido.
*   **Tecnología Clave:** JSON-LD, Schema.org, Máquinas de Estado.

---

### La Suite de Protocolos (v1.0-RC)

Todos los protocolos se encuentran actualmente en estado de **Candidato de Lanzamiento**.

| Acrónimo | Nombre | Capa | Enfoque | Estado |
| :--- | :--- | :--- | :--- | :--- |
| **OAEP** | **Protocolo de Intercambio** | **L0** | Identidad, Handshake, Confianza | ❄️ Congelado |
| **OATP** | **Protocolo de Transporte** | **L1** | Encriptación, Fragmentación, Enrutamiento | ❄️ Congelado |
| **OAPP** | **Protocolo de Pago** | **L2** | Liquidación, PSD2, Escrow (Fideicomiso) | ❄️ Congelado |
| **OACP** | **Protocolo de Comercio** | **L2** | Comercio basado en intención, Negociación | ❄️ Congelado |
| **OADP** | **Protocolo de Datos** | **L2** | Datos Soberanos, Políticas ODRL | ❄️ Congelado |
| **OAFP** | **Protocolo de Feed** | **L2** | Redes Sociales, Curación | ❄️ Congelado |
| **OACoP** | **Protocolo de Colaboración**| **L2** | Programación, Tareas | ❄️ Congelado |
| **OAHP** | **Protocolo de Salud** | **L2** | Historiales Pacientes, Acceso de Emergencia | ❄️ Congelado |
| **OAVP** | **Protocolo de Votación** | **L2** | Elecciones Anónimas, Mixnets | ❄️ Congelado |
| **OARP** | **Protocolo de Robótica** | **L2** | Actuación Física, Seguridad | ❄️ Congelado |

---

### Implementaciones de Referencia

La Fundación OAP mantiene las implementaciones oficiales de referencia en **Rust** para garantizar la seguridad de memoria y el rendimiento.

*   **Lógica Core:** [`oap-foundation/oap-core-rs`](https://github.com/oap-foundation/oap-core-rs)
    *   *Contiene las primitivas criptográficas para la Capa 0 y la Capa 1.*
*   **Lógica de Capa 2:** [`oap-foundation/layer2-core-rs`](https://github.com/oap-foundation/layer2-core-rs)
    *   *Máquinas de estado y lógica de validación para protocolos de aplicación.*

Los bindings para **Python**, **JavaScript/WASM** y **Dart** están disponibles en sus respectivos repositorios.

---

### 📄 Licencia y Legal

Para proteger la naturaleza abierta de este estándar, empleamos un modelo de licencia estricto.

#### Licencia de la Especificación (Copyleft)
El texto de la especificación, las definiciones de arquitectura y la lógica del protocolo contenida en este repositorio están licenciados bajo la **Licencia Creative Commons Atribución-CompartirIgual 4.0 Internacional (CC BY-SA 4.0)**.

[![Licencia: CC BY-SA 4.0](https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-sa/4.0/)

**Intención de esta Licencia:**
El objetivo de usar CC BY-SA 4.0 es proteger permanentemente la naturaleza abierta de este estándar.
*   **CompartirIgual (ShareAlike):** Si modificas, extiendes o construyes sobre esta especificación (por ejemplo, creando una "Capa 2.5"), **debes** distribuir tus contribuciones bajo la misma licencia **CC BY-SA 4.0**.
*   **Sin Bifurcaciones Propietarias:** Está legalmente prohibido crear una versión o extensión propietaria y de código cerrado de este texto de especificación. Todos los derivados deben permanecer libres y abiertos a la comunidad.

#### Nota sobre la Implementación
Para facilitar una adopción amplia, se permite el uso de los conceptos, estructuras de datos (JSON-LD) y la lógica definida en esta especificación para crear **implementaciones de software** (bibliotecas, aplicaciones, agentes) sin activar la cláusula ShareAlike para el software en sí. El código de referencia está licenciado bajo **MIT**.

Sin embargo, cualquier cambio en el **documento de especificación en sí** permanece sujeto al requisito de ShareAlike.

---
**Mantenido por la OAP Foundation**
*Diseña el futuro como un recurso.*