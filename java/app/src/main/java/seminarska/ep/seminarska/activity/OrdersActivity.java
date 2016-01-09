package seminarska.ep.seminarska.activity;

import android.app.ListActivity;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
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
import seminarska.ep.seminarska.adapter.ProductsAdapter;
import seminarska.ep.seminarska.model.Narocilo;
import seminarska.ep.seminarska.model.Product;
import seminarska.ep.seminarska.utilities.Utils;

public class OrdersActivity extends ListActivity {

    private static final String ORDERS = "http://10.0.2.2/netbeans/ep/php/api/narocilo/%s";
    private static final String TAG = OrdersActivity.class.getCanonicalName();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        String tip = getIntent().getExtras().getString("tip");

        final RequestQueue queue = Volley.newRequestQueue(this);
        final StringRequest stringRequest = new StringRequest(Request.Method.GET, String.format(ORDERS, tip != null ? tip : "potrjeni"),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.v("RESPONSE", response);
                        if (response.isEmpty()) {
                            Toast.makeText(OrdersActivity.this, "Ni naročil.", Toast.LENGTH_LONG).show();
                            finish();
                        } else {
                            handleResponse(response);
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(OrdersActivity.this, "An error occurred.", Toast.LENGTH_LONG).show();
                Log.w(TAG, "Exception: " + error.getLocalizedMessage());
            }
        });

        queue.add(stringRequest);
    }

    private void handleResponse(String response) {
        final Gson gson = new Gson();
        final Narocilo[] narocila = gson.fromJson(response, Narocilo[].class);

        final ArrayAdapter<Narocilo> adapter = new ArrayAdapter<>(this,
                android.R.layout.simple_list_item_1, narocila);
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

    @Override
    protected void onListItemClick(ListView l, View v, int position, long id) {
        final Narocilo narocilo = (Narocilo) getListAdapter().getItem(position);
        final Intent intent = new Intent(this, OrderDetailsActivity.class);
        intent.putExtra("id", narocilo.id);
        startActivity(intent);
    }
}
