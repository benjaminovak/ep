package seminarska.ep.seminarska.adapter;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListAdapter;
import android.widget.NumberPicker;
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
import seminarska.ep.seminarska.activity.CartActivity;
import seminarska.ep.seminarska.activity.ProductListActivity;
import seminarska.ep.seminarska.model.Product;

/**
 * Created by Naum on 1/7/2016.
 */
public class CartProductsAdapter extends ArrayAdapter<Product> {

    private static final String CHANGE_CART = "http://10.0.2.2/netbeans/ep/php/api/cart/%s";
    private Context ctx;
    private ArrayList<Product> productsList;

    public CartProductsAdapter(Context context, ArrayList<Product> products) {
        super(context, 0, products);
        this.ctx = context;
        this.productsList = products;
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        // Get the data item for this position
        final Product product = getItem(position);
        // Check if an existing view is being reused, otherwise inflate the view
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.cart_adapter, parent, false);
        }
        // Lookup view for data population
        TextView name = (TextView) convertView.findViewById(R.id.name);
        final Button changeBtn = (Button) convertView.findViewById(R.id.change_btn);
        final Button removeBtn = (Button) convertView.findViewById(R.id.remove_btn);
        // Populate the data into the template view using the data object
        name.setText(product.naziv);
        changeBtn.setText(String.valueOf(product.vseh));
        changeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final Dialog dialog = new Dialog(ctx);
                dialog.setTitle("Spremeni količino");
                dialog.setContentView(R.layout.product_quantity_dialog);
                final NumberPicker np = (NumberPicker) dialog.findViewById(R.id.kolicina);
                Button daBtn = (Button) dialog.findViewById(R.id.da_btn);
                Button neBtn = (Button) dialog.findViewById(R.id.ne_btn);
                np.setMinValue(1);
                np.setMaxValue(100);
                np.setValue(product.vseh);
                np.setWrapSelectorWheel(false);
                daBtn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        product.vseh = np.getValue();
                        changeBtn.setText(String.valueOf(np.getValue()));
                        ((CartActivity)ctx).updateSum(productsList);
                        changeQuantityRequest(product, np.getValue());
                        dialog.dismiss();
                    }
                });
                neBtn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        dialog.dismiss();
                    }
                });
                dialog.show();
            }
        });

        removeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final RequestQueue queue = Volley.newRequestQueue(ctx);
                final StringRequest stringRequest = new StringRequest(Request.Method.DELETE, String.format(CHANGE_CART, product.id),
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                remove(product);
                                ((CartActivity)ctx).updateSum(productsList);
                                notifyDataSetChanged();
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

    private void changeQuantityRequest(Product product, final int newQuantity) {
        final RequestQueue queue = Volley.newRequestQueue(ctx);
        final StringRequest stringRequest = new StringRequest(Request.Method.PUT, String.format(CHANGE_CART, product.id),
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
        }) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("kolicina", String.valueOf(newQuantity));
                return params;
            }
        };

        queue.add(stringRequest);
    }

}
