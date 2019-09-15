* * * * * /bin/usersteste.sh
* * * * * /usr/bin/php /var/www/html/pages/system/cron.online.ssh.php
*/1 * * * * /usr/bin/php /var/www/html/pages/system/cron.ssh.php
0 */1 * * * /usr/bin/php /var/www/html/pages/system/hist.online.php
0 */2 * * * /usr/bin/php /var/www/html/pages/system/cron.php
0 */3 * * * /usr/bin/php /var/www/html/pages/system/cron.servidor.php



apt update && apt install apache2 mysql-server libssh2-1-dev libssh2-php php5 libapache2-mod-php5 php5-mcrypt php5-curl curl unzip cron mcrypt phpmyadmin -y
