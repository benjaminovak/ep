<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';

require_once 'UsersDB.php';

class OsebaForm extends HTML_QuickForm2 {

    public $ime;
    public $priimek;
    public $mail;
    public $uporabnisko_ime;
    public $geslo;
    public $geslo2;
    public $aktiven;
    public $telefon;
    public $ulica;
    public $stevilka;
    public $posta;
    public $kraj;
    public $gumb;


    public function __construct($id, $values, $action) {
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
        $this->uporabnisko_ime->addRule('required', 'Vnesite uporabniško ime.');
        $this->uporabnisko_ime->addRule('regex', 'Pri imenu uporabite le črke in številke.', '/^[a-zA-ZščćžŠČĆŽ0-9 ]+$/');
        $this->uporabnisko_ime->addRule('maxlength', 'Ime naj bo krajše od 255 znakov.', 255);
        if($action == "dodajanje"){
            $this->uporabnisko_ime->addRule('callback', 'Vporabniško ime že obstaja.', 'UsersDB::preveriUpodabniskoImeDodajanje');
        }
        else{
            $this->uporabnisko_ime->addRule('callback', 'Vporabniško ime že obstaja.', array(
                'callback' => 'UsersDB::preveriUpodabniskoImeSpreminjanje',
                'arguments' => array($_SESSION["uname"]))
            );
        }
            
        $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
        $this->geslo->setLabel('Izberite geslo:');
        $this->geslo->setValue($values["geslo"]);
        $this->geslo->setAttribute('size', "100%");
        $this->geslo->addRule('required', 'Vnesite geslo.');
        $this->geslo->addRule('minlength', 'Geslo naj vsebuje vsaj 6 znakov.', 6);
        $this->geslo->addRule('maxlength', 'Geslo naj bo krajši od 60 znakov.', 60);


        $this->geslo2 = new HTML_QuickForm2_Element_InputPassword('geslo2');
        $this->geslo2->setLabel('Ponovite geslo:');
        $this->geslo2->setValue($values["geslo"]);
        $this->geslo2->setAttribute('size', "100%");
        $this->geslo2->addRule('required', 'Ponovno vpišite izbrano geslo.');
        $this->geslo2->addRule('eq', 'Gesli nista enaki.', $this->geslo);
        
        // če je oseba stranka more imetu tudi telefon in pošto
        if(isset($values["stranka"])){
            $this->telefon = new HTML_QuickForm2_Element_InputText('telefon');
            $this->telefon->setAttribute('size', "100%");
            $this->telefon->setLabel('Mobilni telefon:');
            $this->telefon->setValue($values["telefon"]);
            $this->telefon->addRule('required', 'Vnesite telefonsko številko.');
            $this->telefon->addRule('regex', 'Pri telefonski številki uporabite le številke ločene s presledkom (npr. 031 123 456).', '/^(070|051|050|041|040|031) [0-9]{3} [0-9]{3}$/');
            $this->telefon->addRule('maxlength', 'Telefonska številka naj bo krajši od 9 številk in 2 presledka.', 11);
            
            $this->ulica = new HTML_QuickForm2_Element_InputText('ulica');
            $this->ulica->setAttribute('size', "100%");
            $this->ulica->setLabel('Ulica:');
            $this->ulica->setValue($values["ulica"]);
            $this->ulica->addRule('required', 'Vnesite ulico bivanja.');
            $this->ulica->addRule('regex', 'Pri vnosu ulice uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
            $this->ulica->addRule('maxlength', ' naj bo krajši od 75 znakov.', 75);
            
            $this->stevilka = new HTML_QuickForm2_Element_InputText('stevilka');
            $this->stevilka->setAttribute('size', "100%");
            $this->stevilka->setLabel('Hišna številka:');
            $this->stevilka->setValue($values["stevilka"]);
            $this->stevilka->addRule('required', 'Vnesite hišno številko.');
            $this->stevilka->addRule('regex', 'Pri hišni številki uporabite le številke in črke.', '/^[a-zA-ZščćžŠČĆŽ 0-9 ]+$/');
            $this->stevilka->addRule('maxlength', 'Telefonska številka naj bo krajši od 10 znakov.', 10);
            
            $this->posta = new HTML_QuickForm2_Element_InputText('posta');
            $this->posta->setAttribute('size', "100%");
            $this->posta->setLabel('Poštna številka');
            $this->posta->setValue($values["posta"]);
            $this->posta->addRule('required', 'Vnesi številko pošte.');
            $this->posta->addRule('regex', 'Le števila med 1000 in 9999.', '/^[1-9][0-9]{3}$/');
            
            $this->kraj = new HTML_QuickForm2_Element_InputText('kraj');
            $this->kraj->setAttribute('size', "100%");
            $this->kraj->setLabel('Naziv pošte:');
            $this->kraj->setValue($values["kraj"]);
            $this->kraj->addRule('required', 'Vnesi kraj pošte.');
            $this->kraj->addRule('regex', 'Pri kraju uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
            $this->kraj->addRule('maxlength', 'Kraj naj bo krajši od 45 znakov.', 45);
        }
        
        if ($action != "profil") {
            $this->aktiven = new HTML_QuickForm2_Element_InputCheckbox('aktiven');
            $this->aktiven->setLabel('Aktiven uporabnik:');
            if(isset($values["aktiven"]) && $values["aktiven"] == "da" ) {
                $this->aktiven->setValue(1);
            }
        }        

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
         if($action == "dodajanje"){
            if(isset($values["stranka"])){
                $this->gumb->setAttribute('value', 'Ustvari stranko');
            } else {
                $this->gumb->setAttribute('value', 'Ustvari prodajalca');
            }
        }
        elseif ($action == "profil") {
            $this->gumb->setAttribute('value', 'Spremeni');
        }
        else{
            if(isset($values["stranka"])){
                $this->gumb->setAttribute('value', 'Spremeni stranko');
            } else {
                $this->gumb->setAttribute('value', 'Spremeni prodajalca');
            }
        }

        $this->addElement($this->ime);
        $this->addElement($this->priimek);
        $this->addElement($this->mail);
        $this->addElement($this->uporabnisko_ime);
        $this->addElement($this->geslo);
        $this->addElement($this->geslo2);
        if(isset($values["stranka"])){  //dodajanje atributov, ki so samo za stranko
            $this->addElement($this->telefon);
            $this->addElement($this->ulica);
            $this->addElement($this->stevilka);
            $this->addElement($this->posta);
            $this->addElement($this->kraj);
        }
        if ($action != "profil") {
            $this->addElement($this->aktiven);
        }
        $this->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}