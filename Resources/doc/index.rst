Config in config.yml:

assetic:
    bundles:        [SoipoOkentoUserBundle]


Config in routing.yml:

soipo_okento_user:
    resource: "@SoipoOkentoUserBundle/Resources/config/routing.yml"
    prefix:   /



Config in security.yml

security:
    providers:
        in_memory:
            memory: ~
        in_database:
             id: soipo_okento_user.provider.user
        members:
            chain:
                providers: [in_memory, in_database]
    encoders:
        Soipo\Okento\UserBundle\Entity\User: sha512

    firewalls:
        member:
            pattern:    ^/(.*)
            context: member
            anonymous: ~
            provider: members
            # activate different ways to authenticate

            # http_basic: ~
            # http://symfony.com/doc/current/book/security.html#a-configuring-how-your-users-will-authenticate

            form_login:
                    # http://symfony.com/doc/current/cookbook/security/form_login_setup.html
                    # submit the login form here
                    check_path: /login_check

                    # the user is redirected here when they need to log in
                    login_path: /login

                    # if true, forward the user to the login form instead of redirecting
                    use_forward: false

                    default_target_path: /member/profile/update


            remember_me:
                    key: "%secret%"
                    name:  rememberme
                    lifetime: 3600 # in seconds
                    path: /
                    domain: ~
                    secure: false
                    httponly: true
                    always_remember_me: true

            logout:
                    path:   /logout
                    target: /


    access_control:
          - { path: ^/member, roles: [ROLE_MEMBER,ROLE_ADMIN] }
          - { path: ^/admin, roles:  [ROLE_ADMIN] }