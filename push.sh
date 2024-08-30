export COMPOSER_ALLOW_SUPERUSER=1
timestamp=$(date +%s)_build
echo "Temp file $timestamp"
mkdir /tmp/$timestamp
cp -rT ./ /tmp/$timestamp
cd /tmp/$timestamp
rm -rf storage\logs\*.log
rm -rf ./public/hot
rm -rf ./public/.hot
rm -rf ./bootstrap\cache\*
rm -rf .idea
rm -rf .git
rm -rf .env
cp .env.example .env
rm -rf ./appdata
rm -rf ./storage/logs/*.log
rm -rf ./vendor
rm -rf ./node_modules
composer install --ignore-platform-reqs
npm install
npm run build
rm -rf ./public/hot
rm -rf ./public/.hot
php artisan cache:clear
php artisan session:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload

docker build -t ancelade/ams:latest .
docker push ancelade/ams:latest
version=$(cat ./version)

docker build -t ancelade/ams:$version .
docker push ancelade/ams:$version
