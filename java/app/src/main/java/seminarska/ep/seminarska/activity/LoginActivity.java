package seminarska.ep.seminarska.activity;

import android.content.Intent;
import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
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

import java.net.CookieHandler;
import java.net.CookieManager;
import java.net.CookiePolicy;
import java.util.HashMap;
import java.util.Map;

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.model.Login;
import seminarska.ep.seminarska.model.Product;
import seminarska.ep.seminarska.session.MyApplicationObject;

public class LoginActivity extends Activity {

    private static final String LOGIN = "http://10.0.2.2/netbeans/ep/php/api/login";
    private static final String TAG = LoginActivity.class.getCanonicalName();
    private CookieManager cm;

    private Button loginBtn;
    private EditText username;
    private EditText password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        loginBtn = (Button) findViewById(R.id.login_btn);
        username = (EditText) findViewById(R.id.uname_et);
        password = (EditText) findViewById(R.id.password_et);

        cm = new CookieManager( null, CookiePolicy.ACCEPT_ALL );
        CookieHandler.setDefault(cm);

        loginBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final RequestQueue queue = Volley.newRequestQueue(LoginActivity.this);
                final StringRequest stringRequest = new StringRequest(Request.Method.POST, LOGIN,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                Log.v("RESPONSE", response);
                                handleResponse(response);
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(LoginActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                        Log.w(TAG, "Exception: " + error.getLocalizedMessage());
                    }
                }) {
                    protected Map<String, String> getParams() throws com.android.volley.AuthFailureError {
                        Map<String, String> params = new HashMap<String, String>();
                        params.put("uname", username.getText().toString());
                        params.put("password", password.getText().toString());
                        return params;
                    }
                };

                queue.add(stringRequest);
            }
        });


    }

    private void handleResponse(String response) {
//        Log.v("LOGIN STATUS", String.valueOf(response.networkResponse.statusCode));
        final Gson gson = new Gson();
        final Login login = gson.fromJson(response, Login.class);

        if(login.loginSuccess) {
            final MyApplicationObject app = (MyApplicationObject) getApplication();
            app.active = login.active;
            app.role = login.role;
            app.id = login.id;

            Intent intent = new Intent(this, HomeActivity.class);
            finish();
            startActivity(intent);
        } else {
            Toast.makeText(LoginActivity.this, "Nepravilno uporabniško ime ali geslo", Toast.LENGTH_LONG).show();
            password.setText("");
        }
    }
}
