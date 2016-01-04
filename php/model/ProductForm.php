<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';

require_once 'UsersDB.php';

class ProductForm extends HTML_QuickForm2 {

    public $naziv;
    public $cena;
    public $opis;
    public $aktiven;


    public function __construct($id, $values, $action) {
        parent::__construct($id);      
        
        $this->naziv = new HTML_QuickForm2_Element_InputText('naziv');
        $this->naziv->setAttribute('size', "100%");
        $this->naziv->setLabel('Naziv:');
        $this->naziv->setValue($values["naziv"]);
        $this->naziv->addRule('required', 'Vnesite naziv.');
        $this->naziv->addRule('regex', 'Pri imenu uporabite le črke, številke, narekovaje ali ločila.', '/^[a-zA-ZščćžŠČĆŽ0-9\'\"-.,;! ]+$/');
        $this->naziv->addRule('maxlength', 'Ime naj bo krajše od 80 znakov.', 80);

        $this->cena = new HTML_QuickForm2_Element_InputText('cena');
        $this->cena->setAttribute('size', "100%");
        $this->cena->setLabel('Cena:');
        $this->cena->setValue($values["cena"]);
        $this->cena->addRule('required', 'Vnesite ceno.');
        $this->cena->addRule('regex', 'Pri ceni uporabite le številke in piko za decimalne zapise.', '/^[0-9.]+$/');
        $this->cena->addRule('maxlength', 'Cena naj bo krajši od 10 znakov.', 10);
        
        $this->opis = new HTML_QuickForm2_Element_Textarea('opis');
        $this->opis->setAttribute('rows', 5);
        $this->opis->setAttribute('cols', "98%");
        $this->opis->setLabel('Opis:');
        $this->opis->setValue($values["opis"]);
        $this->opis->addRule('required', 'Vnesite opis.');
        $this->opis->addRule('maxlength', 'Opis naj bo krajši od 250 znakov.', 250);
        
        if ($action != "profil") {
            $this->aktiven = new HTML_QuickForm2_Element_InputCheckbox('aktiven');
            $this->aktiven->setLabel('Aktiven izdelek:');
            if(isset($values["aktiven"]) && $values["aktiven"] == "da" ) {
                $this->aktiven->setValue(1);
            }
        }        

        $this->gumb = new HTML_QuickForm2_Element_InputSubmit(null);
        if($action == "dodajanje"){
             $this->gumb->setAttribute('value', 'Ustvari izdelek');
        }
        elseif ($action == "profil") {
            $this->gumb->setAttribute('value', 'Spremeni');
        }
        else{
            $this->gumb->setAttribute('value', 'Spremeni izdelek');
        }

        $this->addElement($this->naziv);
        $this->addElement($this->cena);
        $this->addElement($this->opis);
        if ($action != "profil") {
            $this->addElement($this->aktiven);
        }
        $this->addElement($this->gumb);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}