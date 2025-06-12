#!/bin/bash
#
#install git klo blm ada
echo "🔍 Checking if Git is installed..."

if command -v git >/dev/null 2>&1; then
  echo "✅ Git is already installed. Version: $(git --version)"
else
    echo "❌ Git is not installed."

    # Deteksi OS dan install Git
    if [[ "$OSTYPE" == "linux-gnu"* ]]; then
      echo "🛠 Installing Git using apt (Debian/Ubuntu)..."
      sudo apt update && sudo apt install -y git

    elif [[ "$OSTYPE" == "darwin"* ]]; then
      echo "🛠 Installing Git using Homebrew (macOS)..."
      if ! command -v brew >/dev/null 2>&1; then
        echo "🍺 Homebrew not found. Installing Homebrew..."
        /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
      fi
      brew install git

    elif [[ "$OSTYPE" == "msys"* ]]; then
      echo "🛑 Windows detected. Please install Git manually: https://git-scm.com/download/win"
      exit 1

    else
      echo "⚠️ Unsupported OS: $OSTYPE"
      exit 1
    fi
fi

# Cek lagi setelah install
if command -v git >/dev/null 2>&1; then
  echo "✅ Git already installed. Version: $(git --version)"
else
  echo "❌ Git installation failed."
  exit 1
fi

# clone repositories
REPO_URL="https://github.com/ramdan_riawan/api_admin_geoabsensi.git"  # Ganti dengan URL repositori kamu
TARGET_DIR="repo"  # Ganti dengan nama folder tujuan (opsional)

# Cek apakah folder sudah ada
if [ -d "$TARGET_DIR" ]; then
  echo "✅ Repository already cloned at ./$TARGET_DIR"
else
  echo "📥 Cloning repository from $REPO_URL..."
  git clone "$REPO_URL" "$TARGET_DIR"
  if [ $? -eq 0 ]; then
    echo "✅ Clone complete: ./$TARGET_DIR"
  else
    echo "❌ Failed to clone repository."
    exit 1
  fi
fi

# install php 8 klo blm ada

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
echo "📦 Checking database: $DB_DATABASE on $DB_HOST:$DB_PORT..."

# Build SQL command
SQL="CREATE DATABASE IF NOT EXISTS \`$DB_DATABASE\`;"

# Run command
mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "$SQL"

# Check success
if [ $? -eq 0 ]; then
  echo "✅ Database '$DB_DATABASE' ensured."
else
  echo "❌ Failed to create or access database."
fi

composer install

rm -rf public/storage

php artisan storage:link
php artisan migrate:fresh --env=testing --seed

php artisan optimize:clear

#php artisan test --env=testing

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

# ===== CONFIGURABLE VARIABLES =====
USER="root"
GROUP="root"
WORKDIR="/home/api-admin-geoabsensi-piter.bikinaplikasi.dev/public_html"
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

# ===== DONE =====
echo "✅ Laravel schedule service setup complete and running."
systemctl status $SERVICE_NAME --no-pager

php artisan schedule:work &

php artisan serv &

echo "🌐 Attempting to open $URL in default browser..."

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
