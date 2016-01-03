package seminarska.ep.seminarska.activity;

import android.app.ListActivity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ArrayAdapter;
import android.widget.ListView;
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

public class ProductListActivity extends ListActivity {

    public static final String ALL_ACTIVE_PRODUCTS = "http://10.0.2.2/netbeans/ep/php/api/izdelki";
    private static final String TAG = ProductListActivity.class.getCanonicalName();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        final RequestQueue queue = Volley.newRequestQueue(this);
        final StringRequest stringRequest = new StringRequest(Request.Method.GET, ALL_ACTIVE_PRODUCTS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.v("RESPONSE", response);
                        handleResponse(response);
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(ProductListActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                Log.w(TAG, "Exception: " + error.getLocalizedMessage());
            }
        });

        queue.add(stringRequest);
    }

    private void handleResponse(String response) {
        final Gson gson = new Gson();
        final Product[] products = gson.fromJson(response, Product[].class);

        final ArrayAdapter<Product> adapter = new ArrayAdapter<>(this,
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
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    protected void onListItemClick(ListView l, View v, int position, long id) {
        final Product product = (Product) getListAdapter().getItem(position);
        final Intent intent = new Intent(this, ProductDetailActivity.class);
        intent.putExtra("product", product);
        startActivity(intent);
        Toast.makeText(ProductListActivity.this, "Clicked on " + product, Toast.LENGTH_LONG).show();
    }
}
