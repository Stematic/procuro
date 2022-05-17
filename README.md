# Procuro

# Commands

Retrieve an SSL cert if certbot is active.

```shell
sudo certbot certonly --standalone -d mercatura.dev,www.mercatura.dev --preferred-challenges http --non-interactive --agree-tos --email paul.dawson@mercatura.co.uk --http-01-port=8080
```

Produce the actual SSL cert that haproxy can use.

```shell
sudo su -c "cat /etc/letsencrypt/live/mercatura.dev/fullchain.pem /etc/letsencrypt/live/mercatura.dev/privkey.pem > /etc/ssl/letsencrypt/mercatura.dev.pem"
```

Restart the server.

```shell
sudo service haproxy restart
```
