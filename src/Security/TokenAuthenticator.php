<?php 

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Routing\RouterInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $router;
    private $ticket;
    private $json_response;
    private $user;

    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true),
        ));

        if('app_login' === $request->attributes->get('_route') && ($this->ticket = $request->query->get('ticket'))!=null) {
            if (($this->json_response = json_decode(file_get_contents("http://cla-dev.jeanba.fr/authentification/abc/".urlencode($this->ticket),false, $context),true)) 
                && $this->json_response['success'] == "true") {
                    $this->user = $this->json_response['payload'];
                    if (substr($this->user['cursus'],0,5) == 'ING-G') { //on vérifie que c'est bien un centralien
                        return true;
                    }
            }
        }
        return false;
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return $this->user;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $firstName = $credentials['firstName'];
        $lastName = $credentials['lastName'];
        $email = $credentials['emailCentrale'];
        
        $user = $this->em->getRepository(User::class)
        ->findOneBy(['email' => $email]);

        // if a User object, checkCredentials() is called
        if ($user) {
            return $user;
        } else {
            return $this->registration($lastName, $firstName, $email);
        }
    }

    private function registration($lastName, $firstName, $email)
    {
        $user = new User();
     
        if ($email)
            $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setlastName($lastName);
        $user->setPseudo(strtolower($firstName).'.'.strtolower($lastName));
        $user->setCreatedAt(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success //on l'a vérifié en amont
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new RedirectResponse($this->router->generate('app_login', array(
            'title' => "L'authentification a échoué...",
            'content-text' => 'Réessayer'
        )));

        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('app_login', array(
            'title' => 'Une authentification est requise !',
            'content-text' => 'Se connecter'
        )));
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
