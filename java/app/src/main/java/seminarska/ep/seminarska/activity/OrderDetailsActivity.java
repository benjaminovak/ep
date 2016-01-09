package seminarska.ep.seminarska.activity;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ListActivity;
import android.content.DialogInterface;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;
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

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.model.Narocilo;
import seminarska.ep.seminarska.model.OrderedProduct;
import seminarska.ep.seminarska.model.Product;
import seminarska.ep.seminarska.utilities.Utils;

public class OrderDetailsActivity extends ListActivity {

    private static final String ORDER_DETAILS = "http://10.0.2.2/netbeans/ep/php/api/narocilo/%s";
    private static final String TAG = OrderDetailsActivity.class.getCanonicalName();
    private TextView skupajBrezDDV;
    private TextView DDV;
    private TextView skupajZDDV;

    private OrderedProduct[] products;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_details);

        skupajBrezDDV = (TextView) findViewById(R.id.skupaj_brez_ddv);
        DDV = (TextView) findViewById(R.id.ddv);
        skupajZDDV = (TextView) findViewById(R.id.skupaj_z_ddv);

        String id = getIntent().getExtras().getString("id");
        if (id == null) {
            Toast.makeText(OrderDetailsActivity.this, "Id narocila je null.", Toast.LENGTH_LONG).show();
            finish();
        }

        final RequestQueue queue = Volley.newRequestQueue(this);
        final StringRequest stringRequest = new StringRequest(Request.Method.GET, String.format(ORDER_DETAILS, id),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        if (response.isEmpty()) {
                            Toast.makeText(OrderDetailsActivity.this, "Ni detajlov za tega naročila.", Toast.LENGTH_LONG).show();
                            finish();
                        } else {
                            handleResponse(response);
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(OrderDetailsActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                Log.w(TAG, "Exception: " + error.getLocalizedMessage());
            }
        });

        queue.add(stringRequest);
    }

    private void handleResponse(String response) {
        final Gson gson = new Gson();
        products = gson.fromJson(response, OrderedProduct[].class);
        double skupaj = 0;
        for(OrderedProduct product : products) {
            skupaj += product.cena * product.kolicina;
        }
        skupajBrezDDV.setText("Skupaj brez DDV: " + String.format("%.2f EUR", skupaj * 0.82));
        DDV.setText("DDV: " + String.format("%.2f EUR", skupaj * 0.18));
        skupajZDDV.setText("Skupaj z DDV: " + String.format("%.2f EUR", skupaj));

        final ArrayAdapter<OrderedProduct> adapter = new ArrayAdapter<>(this,
                android.R.layout.simple_list_item_1, products);
        setListAdapter(adapter);
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
