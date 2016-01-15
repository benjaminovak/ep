package seminarska.ep.seminarska.model;

import java.io.Serializable;
import java.util.Locale;

/**
 * Created by Naum on 1/7/2016.
 */
public class Profile implements Serializable {
    public String id;
    public String ime;
    public String priimek;
    public String mail;
    public String uporabnisko_ime;
    public String geslo;
    public String uporabnik_id;
    public String telefon;
    public String ulica;
    public String stevilka;
    public String posta_id;
    public String posta;
    public String kraj;

    @Override
    public String toString() {
        return String.format(Locale.ENGLISH, "%s %s)", ime, priimek);
    }

}
