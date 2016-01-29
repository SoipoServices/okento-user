<?php

namespace Soipo\Okento\UserBundle\Controller;

use Soipo\Okento\UserBundle\Entity\User;
use Soipo\Okento\UserBundle\Form\JoinType;
use Soipo\Okento\UserBundle\Form\LoginType;
use Soipo\Okento\UserBundle\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function joinAction(Request $request)
    {

        // 1) build the form
        $user = new User();
        $form = $this->createForm(JoinType::class,$user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $userManager = $this->get('soipo_okento_user.manager.user');

            // 3) Encode the password (you could also do this via Doctrine listener)
            $userManager->encodePassword($user);

            $roles = array('ROLE_USER','ROLE_MEMBER');
            $user->setRoles($roles);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $translator  = $this->get('translator');
            $message = $translator->trans('success.thank.you.for.joining',array('%user%'=>$user),'flash');

            $mailManager = $this->get('soipo_okento_admin.mail_manager');

            $parameters = array('%user%'=>$user,'%username%'=>$user->getUsername(),'%password%'=>$user->getPlainPassword());
            $subject = $translator->trans('email.join.subject',$parameters ,'security');
            $body = $translator->trans('email.join.body',$parameters ,'security');

            $mailManager->sendFromAdmin($user->getEmail(),$subject, $body );


            $this->addFlash('success',$message);

            return $this->redirectToRoute('soipo_okento_user_login');
        }

        return $this->render(
            'SoipoOkentoUserBundle:Security:join.html.twig',
            array('form' => $form->createView())
        );
    }

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class,null,array(
            'action' => $this->generateUrl('soipo_okento_user_login_check'),
            'method' => 'POST',
        ));


        return $this->render(
            'SoipoOkentoUserBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                'form'          => $form->createView()
            )
        );
    }

    public function resetPasswordAction(Request $request)
    {

        $form = $this->createForm(ResetPasswordType::class);


        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $userManager = $this->get('soipo_okento_user.manager.user');
            $username = $form->get('_username')->getData();
            $email = $form->get('_email')->getData();

            $user = $userManager->findUserBy(array('email'=>$email,'username'=>$username));
            $translator = $this->get('translator.default');
            if($user){


                $plainPassword = $userManager->setRandomPassword($user);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $mailManager = $this->get('soipo_okento_admin.mail_manager');

                $subject = $translator->trans('email.reset.password.subject',array('%user%'=>$user),'security');
                $body = $translator->trans('email.reset.password.body',array('%user%'=>$user,'%plainPassword%'=>$plainPassword),'security');

                $mailManager->sendFromAdmin($user->getEmail(),$subject, $body );

                $message = $translator->trans('flash.reset.password.success',array('%email%'=>$email),'security');
                $this->addFlash('success',$message);

            }else{
                $message = $translator->trans('flash.reset.password.error',array('%email%'=>$email),'security');
                $this->addFlash('error',$message);
            }

        }

        return $this->render(
            'SoipoOkentoUserBundle:Security:reset_password.html.twig',
            array('form'=>$form->createView())
        );
    }

    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system

    }
}
