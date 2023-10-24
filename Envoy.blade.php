@servers(['local' => "vagrant@$local_ip", 'solution' => 'taskmanage@task-management.roqay.solutions'])

@story('deploy')
@if($with_build == 'true')
build-on-local
@endif
deploy-{{$server}}
@if($with_build == 'true')
reset-after-build
@endif
@endstory

@task('build-on-local', ['on' => ['local']])
echo '<----------------------start build on local---------------------->';
echo '<-------------------------------------------------------------------------->';
echo '<-------------------------------------------------------------------------->';
cd {{$app_name}}
echo '*********************** start building assets ***********************';
npm install
npm run build-mode {{$server}}
echo '*********************** end building assets ***********************';
echo '*********************** start push after building assets ***********************';
git add .
git commit -m '{{$push_message}}'
git pull origin {{$branch}}
git push origin {{$branch}}
echo '*********************** end push after building assets ***********************';
echo '<-------------------------------------------------------------------------->';
echo '<-------------------------------------------------------------------------->';
echo '<---------------------- end build on local ---------------------->';
@endtask

@task('reset-after-build', ['on' => ['local']])
echo '<---------------------- start reset local after build ---------------------->';
echo '<-------------------------------------------------------------------------->';
echo '<-------------------------------------------------------------------------->';
cd {{$app_name}}
echo '*********************** start removing belt assets ***********************';
rm -rf public/build
echo '*********************** end removing belt assets ***********************';
echo '*********************** start push after removing assets ***********************';
git add .
git commit -m '{{$push_message}}'
git pull origin {{$branch}}
git push origin {{$branch}}
echo '*********************** end push after removing assets ***********************';
echo '<-------------------------------------------------------------------------->';
echo '<-------------------------------------------------------------------------->';
echo '<----------------------end reset local after build---------------------->';
@endtask

@task("deploy-solution", ['on' => ["solution"]])
echo '<---------------------- start deploy on {{$server}} server ---------------------->';
echo '<-------------------------------------------------------------------------->';
echo '<-------------------------------------------------------------------------->';
cd public_html
pwd
echo "***************************************"
echo "* Pulling new updates..."
echo "* Pulling new updates From Branch: " {{$branch}}
git pull origin {{$branch}} --ff
echo "***************************************"
/opt/cpanel/ea-php82/root/bin/php /opt/cpanel/composer/bin/composer install --optimize-autoloader --ignore-platform-reqs
echo "***************************************"
php artisan migrate --force
echo "***************************************"
php artisan optimize:clear
echo "***************************************"
php artisan queue:restart
echo "***************************************"
echo '<-------------------------------------------------------------------------->';
echo '<-------------------------------------------------------------------------->';
echo '<---------------------- end deploy on {{$server}} server ---------------------->';
@endtask
