package seminarska.ep.seminarska.activity;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.model.Product;

public class ProductDetailActivity extends Activity {

    private static final String TAG = ProductDetailActivity.class.getCanonicalName();
    private TextView tv;

    private Product product;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.product_details);

        tv = (TextView) findViewById(R.id.textView1);

        product = (Product) getIntent().getSerializableExtra("product");

        if(product != null){
            final RequestQueue queue = Volley.newRequestQueue(this);
            final StringRequest stringRequest = new StringRequest(Request.Method.GET, product.uri,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            final Gson gson = new Gson();
                            product = gson.fromJson(response, Product.class);

                            final String text = String.format("Naziv: %s%nCena: %.2f%nOpis: %s%nAktiven: %s", product.naziv, product.cena, product.opis, product.aktiven);
                            tv.setText(text);
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(ProductDetailActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                    Log.w(TAG, "Exception: " + error.getLocalizedMessage());
                }
            });

            queue.add(stringRequest);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
//        getMenuInflater().inflate(R.menu.product_details, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

}
