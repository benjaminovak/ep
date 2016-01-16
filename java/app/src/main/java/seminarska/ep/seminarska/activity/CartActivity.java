package seminarska.ep.seminarska.activity;

import android.app.AlertDialog;
import android.app.ListActivity;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;

import java.util.ArrayList;
import java.util.Arrays;

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.adapter.CartProductsAdapter;
import seminarska.ep.seminarska.adapter.ProductsAdapter;
import seminarska.ep.seminarska.model.Product;
import seminarska.ep.seminarska.utilities.Utils;

public class CartActivity extends ListActivity {

    private static final String CART_PRODUCTS = "http://10.0.2.2/netbeans/ep/php/api/cart";
    private static final String CHECKOUT = "http://10.0.2.2/netbeans/ep/php/api/narocilo";
    private static final String TAG = CartActivity.class.getCanonicalName();
    private double skupaj = 0.0;

    private TextView skupajBrezDDV;
    private TextView DDV;
    private TextView skupajZDDV;
    private Button oddajNarocilo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);

        skupajBrezDDV = (TextView) findViewById(R.id.skupaj_brez_ddv);
        DDV = (TextView) findViewById(R.id.ddv);
        skupajZDDV = (TextView) findViewById(R.id.skupaj_z_ddv);
        oddajNarocilo = (Button) findViewById(R.id.oddaj_narocilo);
        oddajNarocilo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(skupaj != 0.0) {
                    final AlertDialog.Builder dialog = new AlertDialog.Builder(CartActivity.this);
                    dialog.setTitle("Oddaja naročila");
                    dialog.setMessage("Ste prepričani da želite oddati naročilo?");
                    dialog.setPositiveButton("Ja", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            final RequestQueue queue = Volley.newRequestQueue(CartActivity.this);
                            final StringRequest stringRequest = new StringRequest(Request.Method.GET, CHECKOUT,
                                    new Response.Listener<String>() {
                                        @Override
                                        public void onResponse(String response) {
                                            Toast.makeText(CartActivity.this, "Naročilo je bilo oddano.", Toast.LENGTH_LONG).show();
                                            finish();
                                        }
                                    }, new Response.ErrorListener() {
                                @Override
                                public void onErrorResponse(VolleyError error) {
                                    Toast.makeText(CartActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                                    Log.w(TAG, "Exception: " + error.getLocalizedMessage());
                                }
                            });

                            queue.add(stringRequest);
                        }
                    });
                    dialog.setNegativeButton("Nazaj", null);
                    dialog.create().show();

                }
            }
        });

        final RequestQueue queue = Volley.newRequestQueue(this);
        final StringRequest stringRequest = new StringRequest(Request.Method.GET, CART_PRODUCTS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.v("RESPONSE", response);
                        if(response.isEmpty()) {
                            Toast.makeText(CartActivity.this, "Košarica je prazna.", Toast.LENGTH_LONG).show();
                            finish();
                        } else {
                            handleResponse(response);
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(CartActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                Log.w(TAG, "Exception: " + error.getLocalizedMessage());
            }
        });

        queue.add(stringRequest);

    }

    private void handleResponse(String response) {
        final Gson gson = new Gson();
        final Product[] products = gson.fromJson(response, Product[].class);

        ArrayList<Product> productsList = new ArrayList<Product>(Arrays.asList(products));

        CartProductsAdapter adapter = new CartProductsAdapter(this, productsList);
        setListAdapter(adapter);

        updateSum(productsList);
    }

    public void updateSum(ArrayList<Product> products){
        skupaj = 0;
        for(Product product : products) {
            skupaj += product.cena * product.vseh;
        }
        skupajBrezDDV.setText("Skupaj brez DDV: " + String.format("%.2f EUR", skupaj * 0.82));
        DDV.setText("DDV: " + String.format("%.2f EUR", skupaj * 0.18));
        skupajZDDV.setText("Skupaj z DDV: " + String.format("%.2f EUR", skupaj));
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

    @Override
    protected void onListItemClick(ListView l, View v, int position, long id) {
        final Product product = (Product) getListAdapter().getItem(position);
        final Intent intent = new Intent(this, ProductDetailActivity.class);
        intent.putExtra("product", product);
        startActivity(intent);
    }
}
