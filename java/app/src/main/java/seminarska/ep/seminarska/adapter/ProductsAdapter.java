package seminarska.ep.seminarska.adapter;

import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import seminarska.ep.seminarska.R;
import seminarska.ep.seminarska.activity.ProductDetailActivity;
import seminarska.ep.seminarska.activity.ProductListActivity;
import seminarska.ep.seminarska.model.Product;

/**
 * Created by Naum on 1/7/2016.
 */
public class ProductsAdapter extends ArrayAdapter<Product> {

    private static final String ADD_IN_CART = "http://10.0.2.2/netbeans/ep/php/api/cart/%s";
    private Context ctx;

    public ProductsAdapter(Context context, Product[] products) {
        super(context, 0, products);
        this.ctx = context;
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        // Get the data item for this position
        final Product product = getItem(position);
        // Check if an existing view is being reused, otherwise inflate the view
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.product_adapter, parent, false);
        }
        // Lookup view for data population
        TextView name = (TextView) convertView.findViewById(R.id.name);
        Button addBtn = (Button) convertView.findViewById(R.id.add_btn);
        // Populate the data into the template view using the data object
        name.setText(product.toString());
        addBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final RequestQueue queue = Volley.newRequestQueue(ctx);
                final StringRequest stringRequest = new StringRequest(Request.Method.POST, String.format(ADD_IN_CART, product.id),
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(ctx, "An error occurred.", Toast.LENGTH_LONG).show();
                        Log.w(this.getClass().getCanonicalName(), "Exception: " + error.getLocalizedMessage());
                    }
                });

                queue.add(stringRequest);
            }
        });
        // Return the completed view to render on screen
        return convertView;
    }


}
