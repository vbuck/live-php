mv . /usr/share/live-php

CONFIG=$(cat <<EOF
Alias /live-php /usr/share/live-php

<Directory /usr/share/live-php/>
   AddDefaultCharset UTF-8

   <IfModule !mod_authz_core.c>
     # Apache 2.2
     Order Allow,Deny
     Allow from All
   </IfModule>
</Directory>

<Directory /usr/share/live-php/snippets/>
    Order Deny,Allow
    Deny from All
    Allow from None
</Directory>
EOF
)

echo "$CONFIG" > /etc/httpd/conf.d/live-php.conf

echo "Installed livePHP successfully."