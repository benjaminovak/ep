package seminarska.ep.seminarska.model;

/**
 * Created by Naum on 1/8/2016.
 */

import java.io.Serializable;
import java.util.Date;
import java.util.Locale;

public class Narocilo implements Serializable {
    public String id;
    public String uporabnik_id;
    public String obdelano;
    public String datum;
    public String potrjeno;

    @Override
    public String toString() {
        return String.format(Locale.ENGLISH, "%s\n%s, %s", datum, "da".equals(obdelano) ? "Obdelano" : "Neobdelano", "da".equals(potrjeno) ? "potrjeno" : "nepotrjeno");
    }

}

