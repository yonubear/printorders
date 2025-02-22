# Print Orders App for Nextcloud

This document provides step-by-step instructions to install and enable the Print Orders app for Nextcloud.

## Prerequisites

- Nextcloud server version 23 or higher.
- Composer (for PHP dependencies).
- Node.js and npm (for JavaScript dependencies).

## Installation Steps

### 1. Clone the Repository

Clone the Print Orders app repository into the `apps` directory of your Nextcloud installation.

```sh
cd /path/to/nextcloud/apps
git clone https://github.com/yonubear/printorders.git
```

### 2. Navigate to the App Directory

```sh
cd printorders
```

### 3. Install PHP Dependencies

Ensure that you have Composer installed on your system. Run the following command to install the required PHP dependencies:

```sh
composer install
```

### 4. Install Node.js Dependencies

Ensure that you have Node.js and npm installed on your system. Run the following command to install the required JavaScript dependencies:

```sh
npm install
```

### 5. Build Frontend Assets

Run the following command to build the frontend assets:

```sh
npm run build
```

### 6. Set Permissions

Set the appropriate permissions for the app directory:

```sh
chmod -R 755 .
find . -type f -exec chmod 644 {} \;
chmod +x install.sh
```

### 7. Create Symbolic Links (Optional)

If you want to create symbolic links to the app directory in your Nextcloud installation, run the following command:

```sh
./install.sh
```

### 8. Enable the App

Log in to your Nextcloud instance as an admin and enable the Print Orders app via the Nextcloud web interface or by running the following command:

```sh
occ app:enable printorders
```

### 9. Verify Installation

Verify that the Print Orders app is listed and enabled in the "Apps" section of your Nextcloud instance.

## Uninstallation

To uninstall the Print Orders app, follow these steps:

1. Disable the app via the Nextcloud web interface or by running the following command:

    ```sh
    occ app:disable printorders
    ```

2. Remove the app directory:

    ```sh
    rm -rf /path/to/nextcloud/apps/printorders
    ```

## Troubleshooting

If you encounter any issues during installation, please check the Nextcloud logs for error messages. You can also refer to the [Nextcloud App Development Documentation](https://docs.nextcloud.com/server/stable/developer_manual/index.html) for more information.

For further assistance, feel free to open an issue on the [GitHub repository](https://github.com/yonubear/printorders).
