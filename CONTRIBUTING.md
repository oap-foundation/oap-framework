# Contributing to the Open Agent Protocol (OAP) Framework

First off, thank you for considering contributing to OAP. You are joining a community of architects building the foundational layer for a more sovereign, fair, and secure digital future. Every contribution, from a simple typo fix to a major architectural proposal, is welcome and valued.

This document provides a set of guidelines for contributing to the OAP Framework and its various repositories. These are mostly guidelines, not strict rules. Use your best judgment, and feel free to propose changes to this document in a pull request.

## Code of Conduct

This project and everyone participating in it is governed by our [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior. (Note: You will need to add a `CODE_OF_CONDUCT.md` file, for which you can use a standard template like the [Contributor Covenant](https://www.contributor-covenant.org/version/2/1/code_of_conduct/)).

## How Can I Contribute?

There are many ways to contribute to the OAP Framework, and not all of them involve writing code.

### 🏛️ **Improving the Specifications**
This is the most critical area for contributions at this early stage. The protocol specifications are the "laws" of our ecosystem.

*   **Report inconsistencies or ambiguities:** If you read the specification and find something that is unclear, contradictory, or could be misinterpreted, please [open an issue](https://github.com/oap-foundation/oap-framework/issues/new) in the relevant `-spec` repository (e.g., `oaep-spec`).
*   **Propose enhancements:** Do you see a missing feature or a better way to solve a problem? Open an issue to start a discussion. Be sure to describe the problem you're trying to solve and your proposed solution.
*   **Ask questions:** Don't hesitate to ask for clarification on why a certain architectural decision was made. These discussions help everyone deepen their understanding.

### 🌐 **Helping with Translations**
As a European-rooted project with global ambition, we aim to make our vision accessible to everyone.

*   **Translate core documents:** We maintain translations of our main `README.md` and `FOUNDING-MANIFESTO.md` in the `docs/translations` directory of this repository. If you are fluent in a language other than English or German, we would be grateful for your help.
*   **Review existing translations:** If you spot an error or a way to improve a translation, please submit a pull request.

### 🐛 **(In the Future) Reporting Bugs & Writing Code**
Once our reference implementations and SDKs are more mature, this will become a key contribution area.

*   **Report bugs:** If you find a bug in one of our reference libraries, please open a detailed issue in the corresponding repository (e.g., `oap-ts`).
*   **Contribute code:** We welcome pull requests for bug fixes, performance improvements, and well-discussed features.

## Your First Contribution

Unsure where to begin? A great way to start is by looking for issues tagged `good first issue` in our repositories. These are tasks that have been identified as good entry points to the project.

Another easy way to contribute is by improving the documentation. If you read a document and think "this could be clearer," then you've found a perfect opportunity to contribute!

### The Contribution Workflow

We use a standard GitHub workflow for proposing changes: **Fork -> Branch -> Pull Request.**

1.  **Fork the repository** you want to contribute to (e.g., `oap-foundation/oaep-spec`).
2.  **Create a new branch** from `main` for your changes. Please use a descriptive branch name (e.g., `fix-typo-in-handshake-section` or `feature-propose-new-did-method`).
3.  **Make your changes.**
4.  **Commit your changes** with a clear and concise commit message.
5.  **Push your branch** to your fork.
6.  **Open a Pull Request (PR)** against the `main` branch of the original repository.
7.  **Provide a clear title and description** for your PR. Explain the "what" and "why" of your changes. If your PR resolves an existing issue, be sure to link it (e.g., "Closes #23").
8.  **Wait for review.** The maintainers will review your PR, provide feedback, and eventually merge it if it aligns with the project's goals.

## Style Guides & Conventions

*   **Commit Messages:** We follow the [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) specification. This helps us maintain a clear and automated changelog.
*   **Code Style (for code contributions):** Each code repository will contain its own style guide and linter configuration (e.g., using Prettier for TypeScript or `rustfmt` for Rust). Please ensure your code conforms to these styles before submitting.

Thank you for being a part of this journey!
