# Procuro

An api interface for HAProxy configuration generation for multiple servers and domains.

* Handles routing between internal hosts (useful where multiple webservers are running across different machines).
* Handles the generation of a Letsencrypt certificate for those domains.
* Supports custom certificates.

> !! This package is still under development !!

# Commands (after generation).

> These will be moved into an artisan command which handles this through the use of the Laravel queue whenever a server or domain is updated.

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
