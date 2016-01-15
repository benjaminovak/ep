package seminarska.ep.seminarska.activity;

import android.content.Intent;
import android.os.Bundle;
import android.app.Activity;
import android.text.InputFilter;
import android.text.Spanned;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;

import java.util.HashMap;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.model.Login;
import seminarska.ep.seminarska.model.Profile;
import seminarska.ep.seminarska.session.MyApplicationObject;
import seminarska.ep.seminarska.utilities.Utils;

public class ProfileActivity extends Activity {

    private static final String PROFILE = "http://10.0.2.2/netbeans/ep/php/api/profile";
    private static final String TAG = ProfileActivity.class.getCanonicalName();
    private Profile profileData;

    private EditText ime;
    private EditText priimek;
    private EditText email;
    private EditText uporabniskoIme;
    private EditText geslo;
    private EditText geslo2;
    private EditText mobilni;
    private EditText ulica;
    private EditText hisnaStevilka;
    private EditText postnaStevilka;
    private EditText nazivPoste;
    private Button spremeniBtn;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        ime = (EditText) findViewById(R.id.ime);
        priimek = (EditText) findViewById(R.id.priimek);
        email = (EditText) findViewById(R.id.email);
        uporabniskoIme = (EditText) findViewById(R.id.uname);
        geslo = (EditText) findViewById(R.id.geslo);
        geslo2 = (EditText) findViewById(R.id.geslo2);
        mobilni = (EditText) findViewById(R.id.mobilen);
        ulica = (EditText) findViewById(R.id.ulica);
        hisnaStevilka = (EditText) findViewById(R.id.hisna_st);
        postnaStevilka = (EditText) findViewById(R.id.postna_st);
        nazivPoste = (EditText) findViewById(R.id.naziv_poste);
        spremeniBtn = (Button) findViewById(R.id.spremeni_btn);

        spremeniBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (validateInput()) {
                    final RequestQueue queue = Volley.newRequestQueue(ProfileActivity.this);
                    final StringRequest stringRequest = new StringRequest(Request.Method.POST, PROFILE,
                            new Response.Listener<String>() {
                                @Override
                                public void onResponse(String response) {
                                    Toast.makeText(ProfileActivity.this, "Profilni podatki so uspešno spremenjeni.", Toast.LENGTH_LONG).show();
                                    finish();
                                }
                            }, new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(ProfileActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                            Log.w(TAG, "Exception: " + error.getLocalizedMessage());
                        }
                    }) {
                        protected Map<String, String> getParams() {
                            Map<String, String> params = new HashMap<String, String>();
                            params.put("id", profileData.id);
                            params.put("ime", ime.getText().toString());
                            params.put("priimek", priimek.getText().toString());
                            params.put("mail", email.getText().toString());
                            params.put("uporabnisko_ime", uporabniskoIme.getText().toString());
                            params.put("geslo", geslo.getText().toString());
                            params.put("aktiven", "1");
                            params.put("uporabnik_id", profileData.id);
                            params.put("telefon", mobilni.getText().toString());
                            params.put("ulica", ulica.getText().toString());
                            params.put("stevilka", hisnaStevilka.getText().toString());
                            params.put("posta", postnaStevilka.getText().toString());
                            params.put("kraj", nazivPoste.getText().toString());
                            return params;
                        }
                    };

                    queue.add(stringRequest);
                }
            }
        });

        final RequestQueue queue = Volley.newRequestQueue(ProfileActivity.this);
        final StringRequest stringRequest = new StringRequest(Request.Method.GET, PROFILE,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.v("RESPONSE", response);
                        handleResponse(response);
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(ProfileActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                Log.w(TAG, "Exception: " + error.getLocalizedMessage());
            }
        });

        queue.add(stringRequest);
    }

    private boolean validateInput() {
        if(!Pattern.compile("[a-zA-ZščćžŠČĆŽ ]+").matcher(ime.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri imenu uporabite le črke.", Toast.LENGTH_LONG).show();
            return false;
        } else if(ime.getText().toString().trim().length() <= 0 || ime.getText().toString().trim().length() > 50) {
            Toast.makeText(ProfileActivity.this, "Ime mora biti dolgo med 1 in 50 črk.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("[a-zA-ZščćžŠČĆŽ\\- ]+").matcher(priimek.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri priimku uporabite le črke.", Toast.LENGTH_LONG).show();
            return false;
        } else if(priimek.getText().toString().trim().length() <= 0 || priimek.getText().toString().trim().length() > 50) {
            Toast.makeText(ProfileActivity.this, "Priimek mora biti dolgo med 1 in 50 črk.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!android.util.Patterns.EMAIL_ADDRESS.matcher(email.getText().toString()).matches()){
            Toast.makeText(ProfileActivity.this, "Vnesite veljaven e-mail.", Toast.LENGTH_LONG).show();
            return false;
        } else if(email.getText().toString().trim().length() <= 0) {
            Toast.makeText(ProfileActivity.this, "Vnesite e-mail.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("[a-zA-ZščćžŠČĆŽ0-9 ]+").matcher(uporabniskoIme.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri priimku uporabite le črke.", Toast.LENGTH_LONG).show();
            return false;
        } else if(uporabniskoIme.getText().toString().trim().length() <= 0 || uporabniskoIme.getText().toString().trim().length() > 255) {
            Toast.makeText(ProfileActivity.this, "Uporabniško ime mora biti dolgo med 1 in 255 črk.", Toast.LENGTH_LONG).show();
            return false;
        } else if(geslo.getText().toString().trim().length() < 6 || geslo.getText().toString().trim().length() > 60) {
            Toast.makeText(ProfileActivity.this, "Geslo mora biti dolgo med 6 in 60 črk.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!geslo.getText().toString().trim().equals(geslo2.getText().toString().trim())) {
            Toast.makeText(ProfileActivity.this, "Gesla nista enaka.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("(070|051|050|041|040|031) [0-9]{3} [0-9]{3}+").matcher(mobilni.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri telefonski številki uporabite le številke ločene s presledkom (npr. 031 123 456).", Toast.LENGTH_LONG).show();
            return false;
        } else if(mobilni.getText().toString().trim().length() <= 0 || mobilni.getText().toString().trim().length() > 11) {
            Toast.makeText(ProfileActivity.this, "Telefonska številka mora biti sestavljena od 9 številk in 2 presledka (npr. 031 123 456).", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("[a-zA-ZščćžŠČĆŽ ]+").matcher(ulica.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri vnosu ulice uporabite le črke.", Toast.LENGTH_LONG).show();
            return false;
        } else if(ulica.getText().toString().trim().length() <= 0 || ulica.getText().toString().trim().length() > 75) {
            Toast.makeText(ProfileActivity.this, "Ulica bivanja mora biti dolga med 1 in 75 črk.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("[a-zA-ZščćžŠČĆŽ 0-9 ]+").matcher(hisnaStevilka.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri vnosu hišne številke uporabite le črke.", Toast.LENGTH_LONG).show();
            return false;
        } else if(hisnaStevilka.getText().toString().trim().length() <= 0 || hisnaStevilka.getText().toString().trim().length() > 10) {
            Toast.makeText(ProfileActivity.this, "Hišna številka mora biti dolga med 1 in 10 črk.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("[1-9][0-9]{3}").matcher(postnaStevilka.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Le števila med 1000 in 9999.", Toast.LENGTH_LONG).show();
            return false;
        } else if(!Pattern.compile("[a-zA-ZščćžŠČĆŽ ]+").matcher(nazivPoste.getText().toString()).matches()) {
            Toast.makeText(ProfileActivity.this, "Pri vnosu naziva pošte uporabite le črke.", Toast.LENGTH_LONG).show();
            return false;
        } else if(nazivPoste.getText().toString().trim().length() <= 0 || nazivPoste.getText().toString().trim().length() > 45) {
            Toast.makeText(ProfileActivity.this, "Naziv pošte mora biti dolg med 1 in 45 črk.", Toast.LENGTH_LONG).show();
            return false;
        }

        return true;
    }

    private void handleResponse(String response) {
        final Gson gson = new Gson();
        profileData = gson.fromJson(response, Profile.class);

        ime.setText(profileData.ime);
        priimek.setText(profileData.priimek);
        email.setText(profileData.mail);
        uporabniskoIme.setText(profileData.uporabnisko_ime);
        geslo.setText(profileData.geslo);
        geslo2.setText(profileData.geslo);
        mobilni.setText(profileData.telefon);
        ulica.setText(profileData.ulica);
        hisnaStevilka.setText(profileData.stevilka);
        postnaStevilka.setText(profileData.posta);
        nazivPoste.setText(profileData.kraj);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.odjava) {
            Utils.odjava(this);
        }

        return super.onOptionsItemSelected(item);
    }
}
