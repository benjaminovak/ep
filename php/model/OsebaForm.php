<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';

class OsebaForm extends HTML_QuickForm2 {

    public $ime;
    public $priimek;
    public $mail;
    public $uporabnisko_ime;
    public $geslo;
    public $geslo2;
    public $aktiven;
    public $gumb;


    public function __construct($id, $values) {
        parent::__construct($id);

        $this->ime = new HTML_QuickForm2_Element_InputText('ime');
        $this->ime->setAttribute('size', "100%");
        $this->ime->setLabel('Ime:');
        $this->ime->setValue($values["ime"]);
        $this->ime->addRule('required', 'Vnesite ime.');
        $this->ime->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->ime->addRule('maxlength', 'Ime naj bo krajše od 50 znakov.', 50);

        $this->priimek = new HTML_QuickForm2_Element_InputText('priimek');
        $this->priimek->setAttribute('size', "100%");
        $this->priimek->setLabel('Priimek:');
        $this->priimek->setValue($values["priimek"]);
        $this->priimek->addRule('required', 'Vnesite priimek.');
        $this->priimek->addRule('regex', 'Pri priimku uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ\- ]+$/');
        $this->priimek->addRule('maxlength', 'Priimek naj bo krajši od 50 znakov.', 50);

        $this->mail = new HTML_QuickForm2_Element_InputText('mail');
        $this->mail->setAttribute('size', "100%");
        $this->mail->setLabel('Elektronski naslov:');
        $this->mail->setValue($values["mail"]);
        $this->mail->addRule('required', 'Vnesite elektronski naslov.');
        $this->mail->addRule('callback', 'Vnesite veljaven elektronski naslov.', array(
            'callback' => 'filter_var', // vgrejena funkcija v php-ju, ki jo uporabimo za validacijo
            'arguments' => array(FILTER_VALIDATE_EMAIL))
        );
        
        $this->uporabnisko_ime = new HTML_QuickForm2_Element_InputText('uporabnisko_ime');
        $this->uporabnisko_ime->setAttribute('size', "100%");
        $this->uporabnisko_ime->setLabel('Uporabniško ime:');
        $this->uporabnisko_ime->setValue($values["uporabnisko_ime"]);
        $this->uporabnisko_ime->addRule('required', 'Vnesite ime.');
        $this->uporabnisko_ime->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->uporabnisko_ime->addRule('maxlength', 'Ime naj bo krajše od 255 znakov.', 255);

        $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
        $this->geslo->setLabel('Izberite geslo:');
        $this->geslo->setValue($values["geslo"]);
        $this->geslo->setAttribute('size', "100%");
        $this->geslo->addRule('required', 'Vnesite geslo.');
        $this->geslo->addRule('minlength', 'Geslo naj vsebuje vsaj 6 znakov.', 6);


        $this->geslo2 = new HTML_QuickForm2_Element_InputPassword('geslo2');
        $this->geslo2->setLabel('Ponovite geslo:');
        $this->geslo2->setValue($values["geslo"]);
        $this->geslo2->setAttribute('size', "100%");
        $this->geslo2->addRule('required', 'Ponovno vpišite izbrano geslo.');
        $this->geslo2->addRule('eq', 'Gesli nista enaki.', $this->geslo);
        
        $this->aktiven = new HTML_QuickForm2_Element_InputCheckbox('aktiven');
        $this->aktiven->setLabel('Aktiven uporabnik:');
        $this->aktiven->setValue($values["aktiven"]);
        

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->gumb->setAttribute('value', 'Ustvari prodajalca');

        $this->addElement($this->ime);
        $this->addElement($this->priimek);
        $this->addElement($this->mail);
        $this->addElement($this->uporabnisko_ime);
        $this->addElement($this->geslo);
        $this->addElement($this->geslo2);
        $this->addElement($this->aktiven);
        $this->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}