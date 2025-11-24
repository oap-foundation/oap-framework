# OAP Bridge

## Description
OAP Bridge is a foundational WordPress plugin that connects your WordPress installation to the OAP (Open Agent Protocol) Framework. It serves as the communication layer for other OAP-enabled plugins, such as OAP WooCommerce, ensuring secure and standardized data exchange with autonomous agents.

## Features
- Implements core OAP protocols.
- Secure handshake and authentication.
- API endpoints for agent communication.
- Extensible architecture for other plugins.

## Installation
1. Upload the plugin files to the `/wp-content/plugins/oap-bridge` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to the OAP Bridge settings to configure your node identity and connection parameters.

## Usage
This plugin works primarily in the background. It exposes the necessary API endpoints for OAP interaction. Developers can hook into the bridge to extend functionality or create new OAP-compatible plugins.

## Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- SSL enabled (recommended for production)
- OAP Framework Libraries (OAEP, OACP, OAPP) - These should be installed via Composer or available in the project structure.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
