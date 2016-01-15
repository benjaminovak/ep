package seminarska.ep.seminarska.model;

import java.io.Serializable;
import java.util.Locale;

/**
 * Created by Naum on 1/8/2016.
 */
public class OrderedProduct implements Serializable {
    public String id;
    public String naziv;
    public double cena;
    public String opis;
    public String aktiven;
    public int kolicina;
    public String narocilo_id;
    public String izdelek_id;

    @Override
    public String toString() {
        return String.format("Naziv: %s%nCena: %.2f, Kolicina: %d, Skupna cena: %.2f", naziv, cena, kolicina, cena*kolicina);
    }

}

