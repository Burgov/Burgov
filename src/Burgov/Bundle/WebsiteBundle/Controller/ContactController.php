<?php

namespace Burgov\Bundle\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->createForm(new \Burgov\Bundle\WebsiteBundle\Form\Type\ContactType());
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $data = $form->getData();
                
                $message = \Swift_Message::newInstance();
                $message
                    ->setSubject('Bedankt voor uw bericht')
                    ->setBody($this->renderView('BurgovWebsiteBundle:Contact:email_thanks.html.twig', array(
                        'logo_src' => $message->embed(\Swift_Image::fromPath(__DIR__.'/../Resources/public/images/logo.png')),
                        'data' => $data
                    )), 'text/html')
                    ->addPart($this->renderView('BurgovWebsiteBundle:Contact:email_thanks.txt.twig', array(
                        'data' => $data
                    )), 'text/plain')
                    ->setFrom(array('info@burgov.nl' => 'Burgov Webdevelopment'))
                    ->setTo(array($data['email'] => $data['name']))
                ;
                
                $this->get('mailer')->send($message);

                $message2 = \Swift_Message::newInstance();
                $message2
                    ->setSubject('Bedankt voor uw bericht')
                    ->setBody($this->renderView('BurgovWebsiteBundle:Contact:email_message.html.twig', array(
                        'logo_src' => $message2->embed(\Swift_Image::fromPath(__DIR__.'/../Resources/public/images/logo.png')),
                        'data' => $data
                    )), 'text/html')
                    ->setFrom(array('info@burgov.nl' => 'Burgov Webdevelopment'))
                    ->setTo(array('bart@burgov.nl' => 'Bart van den Burg'))
                ;
                
                $this->get('mailer')->send($message2);
                
                $this->getRequest()->getSession()->set('email-data' , $data);
                return $this->redirect($this->generateUrl('/cms/routes/contact/thanks'));
            }
        }
        
        return $this->render('BurgovWebsiteBundle:Contact:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function thanksAction() {
        $data = $this->getRequest()->getSession()->remove('email-data');
        if (null === $data) {
            return $this->redirect($this->generateUrl('/cms/routes'));
        }
        return $this->render('BurgovWebsiteBundle:Contact:thanks.html.twig', array(
            'data' => $data
        ));
    }
}
