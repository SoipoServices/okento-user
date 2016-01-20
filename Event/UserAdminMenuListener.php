<?php
/**
 * Created by PhpStorm.
 * User: soiposervices
 * Date: 16/01/16
 * Time: 17:25
 */

namespace Soipo\Okento\UserBundle\Event;


use Soipo\Okento\AdminBundle\Event\AbstractAdminMenuListener as AdminMenuListener;
use Soipo\Okento\AdminBundle\Event\AdminMenuEvent;

class UserAdminMenuListener extends AdminMenuListener
{
    public function onOkentoAdminmenu(AdminMenuEvent $event){
        $menu = $event->getMenu();


        $parameters = array();
        $parameters['route'] = 'soipo_okento_user_profile_update';
        $item = $menu->addChild('profile', $parameters);
        $item->setAttribute('icon','fa fa-user');

        if($this->checkRole('ROLE_ADMIN')){
            $parameters = array();
            $parameters['route'] = 'soipo_okento_user_users_list';
            $item = $menu->addChild('users', $parameters);
            $item->setAttribute('icon','fa fa-users');
        }

        $event->setMenu($menu);

    }

}