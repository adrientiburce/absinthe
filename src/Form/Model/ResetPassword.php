<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPassword
{

    /**
     *@Assert\Email(
     *     message = "L'email {{ value }} n'es pas valide")
     * @Assert\Regex(
     *      pattern="/@centrale.centralelille.fr$/",
     *      message="Votre adresse doit avoir comme domaine : @centrale.centralelille.fr"
     * )
     */
    private $email;


    /**
     * Get pattern="/@centrale.centralelille.fr$/",
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pattern="/@centrale.centralelille.fr$/",
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
