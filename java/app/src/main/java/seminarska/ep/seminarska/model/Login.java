package seminarska.ep.seminarska.model;

/**
 * Created by Naum on 1/5/2016.
 */

import java.io.Serializable;
import java.util.Locale;

public class Login implements Serializable {
    public boolean loginSuccess;
    public boolean active;
    public String role;
    public String id;

//    @Override
//    public String toString() {
//        return String.format(Locale.ENGLISH, "%s: (%.2f EUR)", naziv, cena);
//    }

}

