package seminarska.ep.seminarska.utilities;

import android.app.Activity;
import android.content.Intent;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import seminarska.ep.seminarska.activity.LoginActivity;
import seminarska.ep.seminarska.session.MyApplicationObject;

/**
 * Created by Naum on 1/9/2016.
 */
public class Utils {

    private static final String LOGOUT = "http://10.0.2.2/netbeans/ep/php/api/logout";
    private static final String TAG = Utils.class.getCanonicalName();

    public static void odjava(final Activity activity){
        final RequestQueue queue = Volley.newRequestQueue(activity);
        final StringRequest stringRequest = new StringRequest(Request.Method.GET, LOGOUT,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.v("RESPONSE", response);

                        final MyApplicationObject app = (MyApplicationObject) activity.getApplication();
                        app.active = false;
                        Intent intent = new Intent(activity, LoginActivity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        activity.startActivity(intent);
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(activity, "An error occurred.", Toast.LENGTH_LONG).show();
                Log.w(TAG, "Exception: " + error.getLocalizedMessage());
            }
        });

        queue.add(stringRequest);
    }

}
