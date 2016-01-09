package seminarska.ep.seminarska.model;

import java.io.Serializable;
import java.util.Locale;

/**
 * Created by Naum on 1/2/2016.
 */
public class Product implements Serializable {
    public String id;
    public String naziv;
    public double cena;
    public String opis;
    public String aktiven;
    public String uri;
    public int vseh;

    @Override
    public String toString() {
        return String.format(Locale.ENGLISH, "%s: (%.2f EUR)", naziv, cena);
    }

}
