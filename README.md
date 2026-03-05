# project_talaria

**Authentification**
```bash
composer require symfony/security-bundle
```
puis :

```bash
php bin/console make:auth
```
Choisis :

- Login form authenticator
.....

Symfony va te créer automatiquement :

```
src/Security/LoginFormAuthenticator.php
```

👉 C’EST LUI qui remplacera ton LoginPageController.
