#!/bin/bash

# ========================
# MySQL Check Script
# ========================

# Detect OS
OS=$(uname -s)
echo "🔍 Detected OS: $OS"

# --- Check if MySQL client is installed ---
if ! command -v mysql >/dev/null 2>&1; then
    echo "❌ MySQL client (mysql) is not installed. Exiting."
    exit 1
fi

# --- Check if MySQL service is running ---
case "$OS" in
    Linux*)
        if systemctl is-active --quiet mysql || systemctl is-active --quiet mariadb; then
            echo "✅ MySQL is running on Linux"
        else
            echo "❌ MySQL is NOT running on Linux. Exiting."
            exit 1
        fi
        ;;
    Darwin*)
        # macOS - check via process instead of brew (faster and safer)
        if pgrep -f mysqld >/dev/null 2>&1; then
            echo "✅ MySQL is running on macOS"
        else
            echo "❌ MySQL is NOT running on macOS. Exiting."
            exit 1
        fi
        ;;
    MINGW*|MSYS*|CYGWIN*)
        # Windows Git Bash / MSYS / Cygwin
        if sc query mysql | grep -q "RUNNING"; then
            echo "✅ MySQL is running on Windows"
        else
            echo "❌ MySQL is NOT running on Windows. Exiting."
            exit 1
        fi
        ;;
    *)
        echo "❌ Unsupported OS: $OS. Exiting."
        exit 1
        ;;
esac

# --- Continue your script here ---
echo "🚀 MySQL check passed. Continuing script execution..."

composer install

#copy file .env
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "✅ .env file created from .env.example"
    else
        echo "❌ .env.example not found. Cannot create .env"
        exit 1
    fi
else
    echo "ℹ️ .env file already exists. No action taken."
fi

# untuk testing
## buat database bila belum ada
# Load variables from .env
DB_HOST=$(grep DB_HOST .env.testing | cut -d '=' -f2)
DB_PORT=$(grep DB_PORT .env.testing | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE .env.testing | cut -d '=' -f2)
DB_USERNAME=$(grep DB_USERNAME .env.testing | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD .env.testing | cut -d '=' -f2)

# Default values if not found
DB_PORT=${DB_PORT:-3306}
DB_HOST=${DB_HOST:-127.0.0.1}

# Show info
echo "📦 Checking database for testing: $DB_DATABASE on $DB_HOST:$DB_PORT..."

# Build SQL command
SQL="CREATE DATABASE IF NOT EXISTS \`$DB_DATABASE\`;"

echo "enter mysql password"

# Run command
mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "$SQL"

# Check success
if [ $? -eq 0 ]; then
  echo "✅ Database '$DB_DATABASE' ensured."
else
  echo "❌ Failed to create or access database."
fi

rm -rf public/storage

php artisan storage:link
php artisan migrate:fresh --env=testing --seed

php artisan optimize:clear --env=testing

#php artisan test --env=testing

#delete database kalo udah di testing

echo "enter mysql password"

#
## Build SQL command
SQL="DROP DATABASE IF EXISTS \`$DB_DATABASE\`;"
#
## Run command
mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "$SQL"

echo "testing database dropped"

echo "creating application database"

# Load variables from .env
DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
DB_PORT=$(grep DB_PORT .env | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)
DB_USERNAME=$(grep DB_USERNAME .env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)

# Default values if not found
DB_PORT=${DB_PORT:-3306}
DB_HOST=${DB_HOST:-127.0.0.1}

read -p "Create fresh database? (y/n): " answer
answer=${answer:-y}

if [[ "$answer" == "y" || "$answer" == "Y" ]]; then
    echo "enter mysql password"

    ## Build SQL command
    SQL="CREATE DATABASE IF NOT EXISTS \`$DB_DATABASE\`;"
    #
    ## Run command
    mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "$SQL"

    php artisan migrate:fresh --seed
else
    php artisan migrate --seed
fi

php artisan optimize

## == NGEBUAT FILE HTACCESSNYA ==
HTACCESS_FILE=".htaccess"

HTACCESS_CONTENT='RewriteEngine On
RewriteCond %{REQUEST_URI} !^public
RewriteRule ^(.*)$ public/$1 [L]'

# Cek apakah .htaccess sudah ada
if [ -f "$HTACCESS_FILE" ]; then
  echo "ℹ️ $HTACCESS_FILE already exists. No changes made."
else
  echo "$HTACCESS_CONTENT" > "$HTACCESS_FILE"
  echo "✅ .htaccess file created at $(pwd)/$HTACCESS_FILE"
fi


is_port_in_use() {
  lsof -iTCP:$1 -sTCP:LISTEN -t >/dev/null 2>&1
}

# Loop cari port acak yang belum dipakai
PORT=8000
while true; do
  PORT=$(( RANDOM % 64511 + 1024 ))  # 1024–65535
  if ! is_port_in_use $PORT; then
    echo "$PORT"
    break
  fi
done

#buat jadi service kalo di linux
if [[ "$OSTYPE" == linux-gnu* ]]; then
    CURRENT_DIR=$(pwd)

    # ===== CONFIGURABLE VARIABLES =====
    USER="root"
    GROUP="root"
    WORKDIR="$CURRENT_DIR"
    SERVICE_NAME="laravel-schedule"
    PHP_PATH="/usr/bin/php"
    LOG_DIR="$WORKDIR/storage/logs"
    LOG_FILE="$LOG_DIR/schedule.log"
    ERR_FILE="$LOG_DIR/schedule-error.log"
    SYSTEMD_PATH="/etc/systemd/system/$SERVICE_NAME.service"

    # ===== CREATE LOG DIR IF NOT EXISTS =====
    mkdir -p "$LOG_DIR"
    touch "$LOG_FILE" "$ERR_FILE"
    chown $USER:$GROUP "$LOG_FILE" "$ERR_FILE"

    # ===== CREATE SYSTEMD SERVICE FILE =====
    cat <<EOF > "$SYSTEMD_PATH"
[Unit]
Description=Laravel Schedule Worker
After=network.target

[Service]
User=$USER
Group=$GROUP
Restart=always
WorkingDirectory=$WORKDIR
ExecStart=$PHP_PATH artisan schedule:work
StandardOutput=append:$LOG_FILE
StandardError=append:$ERR_FILE

[Install]
WantedBy=multi-user.target
EOF

    # ===== SETUP SYSTEMD SERVICE =====
    systemctl daemon-reexec
    systemctl daemon-reload
    systemctl enable $SERVICE_NAME
    systemctl restart $SERVICE_NAME

    systemctl status $SERVICE_NAME --no-pager
else
    # Jalankan schedule:work dan serve sebagai subshell dan simpan PID-nya
    php artisan schedule:work &
    SCHEDULE_PID=$!

    php artisan serv --port=$PORT &
    SERVE_PID=$!

    # ===== DONE =====
    echo "✅ Laravel schedule service setup complete and running."

    echo "🌐 Attempting to open $URL in default browser..."

    URL="http://localhost:$PORT"

    # Cek dan jalankan per OS
    if command -v xdg-open >/dev/null 2>&1; then
      xdg-open "$URL"
    elif command -v open >/dev/null 2>&1; then
      open "$URL"
    elif command -v start >/dev/null 2>&1; then
      start "$URL"
    else
      echo "❌ Unable to detect method to open browser. Please open manually: $URL"
      exit 1
    fi

    echo "✅ Browser should be opening now."

    # Saat user tekan Ctrl+C, kill dua-duanya
    trap "kill $SCHEDULE_PID $SERVE_PID" SIGINT

    # Tunggu kedua proses sampai selesai
    wait
fi
