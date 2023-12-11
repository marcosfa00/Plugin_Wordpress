## README

### Marcosfa WordPress Plugin with DOCKER COMPOSE

This plugin integrates with a WordPress setup running on Docker Compose. It adds functionalities that modify content displayed on your WordPress site, creating a custom table in the WordPress database and performing dynamic replacements in titles and content.

### Installation within Docker Compose Environment

To use this plugin within a Docker Compose environment:

1. **Download the Plugin:** Download the plugin folder and place it in the `/html/wp-content/plugins/` directory of your WordPress setup within the Docker volume.
2. **Activate the Plugin:** Log in to your WordPress dashboard, navigate to the "Plugins" section, and activate the "Marcosfa Plugin."

### Docker Compose Configuration

This plugin is designed to work within a Docker Compose setup. Ensure that your `docker-compose.yml` file is configured appropriately, including the services for `db` (MariaDB) and `wordpress`.

### Plugin Functionalities

#### 1. Custom Table Creation and Letter Insertion

Upon activation, the plugin creates a custom table named `wp_Letras` in the WordPress database (`wordpress` database specified in the environment) within the MariaDB service. It inserts letters from A to Z into this table.

#### 2. Modify Title's Last Letter

This functionality modifies the last letter of post titles displayed on your WordPress site. It checks if the last letter of the title matches any letter in the `wp_Letras` table. If it does, it substitutes the last letter of the title with the corresponding letter from the database.

#### 3. Replace Numbers with Factorials in Content

Whenever a post or page is displayed, this plugin checks the content for any numerical values. If it finds a number, it replaces it with its factorial value.

### Important Notes:

- **Database Structure:** The plugin creates a table named `wp_Letras` in the `wordpress` database specified within the `db` service defined in Docker Compose. Please ensure proper backup and handle with caution if modifying database structures.
- **Dynamic Modifications:** Title modifications and content replacements occur dynamically within WordPress posts and pages.
- **Plugin Directory:** Place the plugin folder within the WordPress plugin directory (`/html/wp-content/plugins/`) to ensure proper integration and activation within the Docker Compose setup.

### Contributing and Issues

If you encounter any issues or wish to contribute to this plugin, feel free to create an issue or pull request on the GitHub repository.


