
Config in config.yml:

assetic:
    bundles:        [SoipoOkentoUserBundle]


In the routing.yml folder:

soipo_okento_user:
    resource: "@SoipoOkentoUserBundle/Resources/config/routing.yml"
    prefix:   /