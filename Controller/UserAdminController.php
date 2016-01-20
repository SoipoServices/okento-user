<?php

namespace Soipo\Okento\UserBundle\Controller;

use Soipo\Okento\AdminBundle\Controller\AdminController;
use Soipo\Okento\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;


class UserAdminController extends AdminController
{
    public function updateAction(Request $request)
    {
        $this->get('soipo_okento_admin.access_manager')->checkAccess(array('IS_AUTHENTICATED_FULLY'));

        // 1) build the form
        $user = $this->getUser();
        $form = $this->createForm(new UserType(),$user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $userManager = $this->get('soipo_okento_user.manager.user');

            if(!is_null($user->getPlainPassword())){
                // 3) Encode the password (you could also do this via Doctrine listener)
                $userManager->encodePassword($user);
            }

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $translator  = $this->get('translator');
            $message = $translator->trans('success.thank.you.for.update',array('%user%'=>$user),'flash');

            $this->addFlash('success',$message);
        }

        return $this->render(
            'SoipoOkentoUserBundle:User:update.html.twig',
            array('form' => $form->createView())
        );
    }

    public function listAction(Request $request)
    {

        $this->get('soipo_okento_admin.access_manager')->checkAccess(array('IS_AUTHENTICATED_FULLY','ROLE_ADMIN'));

        $userManager = $this->get('soipo_okento_user.manager.user');

        $users = $userManager->findAllUsers();

        return $this->render(
            'SoipoOkentoUserBundle:User:list.html.twig',
            array('users' => $users)
        );
    }

    public function viewAction($id, Request $request)
    {
        $this->get('soipo_okento_admin.access_manager')->checkAccess(array('IS_AUTHENTICATED_FULLY','ROLE_ADMIN'));

        $userManager = $this->get('soipo_okento_user.manager.user');

        $user = $userManager->findUserBy(array('id'=>$id));

        $translator  = $this->get('translator');

        if(!$user){
            $message = $translator->trans('error.user.not.found',array('%id%'=>$id),'flash');
            $this->addFlash('error',$message);
        }

        return $this->render(
            'SoipoOkentoUserBundle:User:view.html.twig',
            array('user' => $user)
        );
    }

    public function deleteAction($id, Request $request)
    {
        $this->get('soipo_okento_admin.access_manager')->checkAccess(array('IS_AUTHENTICATED_FULLY','ROLE_ADMIN'));

        $userManager = $this->get('soipo_okento_user.manager.user');

        $user = $userManager->findUserBy(array('id'=>$id));

        $translator  = $this->get('translator');
        if($user && $user->getId() != $this->getUser()->getId()){

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $message = $translator->trans('success.user.delete',array('%id%'=>$id),'flash');
            $this->addFlash('success',$message);

        }else{
            $message = $translator->trans('error.user.delete',array('%id%'=>$id),'flash');
            $this->addFlash('error',$message);
        }

        return $this->redirectToRoute('soipo_okento_user_users_list');
    }


    public function activeAction($id, $admin = false, Request $request)
    {
        $this->get('soipo_okento_admin.access_manager')->checkAccess(array('IS_AUTHENTICATED_FULLY','ROLE_ADMIN'));

        $userManager = $this->get('soipo_okento_user.manager.user');

        $user = $userManager->findUserBy(array('id'=>$id));

        $translator  = $this->get('translator');
        if($user && $user->getId() != $this->getUser()->getId()){
            $user->setActive(true);
            $user->addRole('ROLE_MEMBER');
            if($admin){
                $user->addRole('ROLE_ADMIN');
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $message = $translator->trans('success.user.active',array('%id%'=>$id),'flash');
            $this->addFlash('success',$message);

        }else{
            $message = $translator->trans('error.user.not.found',array('%id%'=>$id),'flash');
            $this->addFlash('error',$message);
        }

        return $this->redirectToRoute('soipo_okento_user_users_list');
    }
}
